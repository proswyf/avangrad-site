<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\GroupClass;
use App\Models\Promotion;
use App\Models\Tariff;
use App\Models\Trainer;
use App\Models\TrainerBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $upcomingTrainerBookings = TrainerBooking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($this->trainerBookingsHaveTime(), function ($query) {
                $today = now()->toDateString();
                $currentTime = now()->format('H:i:s');

                $query->where(function ($builder) use ($today, $currentTime) {
                    $builder->whereDate('booking_date', '>', $today)
                        ->orWhere(function ($sameDayQuery) use ($today, $currentTime) {
                            $sameDayQuery->whereDate('booking_date', $today)
                                ->where(function ($timeQuery) use ($currentTime) {
                                    $timeQuery->whereNull('booking_time')
                                        ->orWhere('booking_time', '>=', $currentTime);
                                });
                        });
                })->orderBy('booking_date')
                    ->orderBy('booking_time');
            }, function ($query) {
                $query->where('booking_date', '>=', now()->toDateString())
                    ->orderBy('booking_date');
            })
            ->with('trainer')
            ->get();

        return view('dashboard.index', compact('user', 'upcomingTrainerBookings'));
    }

    public function cancelTrainerBooking($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $booking = TrainerBooking::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Запись не найдена.');
        }

        if (!in_array($booking->status, ['pending', 'confirmed'], true)) {
            return redirect()->back()->with('error', 'Эту запись уже нельзя отменить.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Запись к тренеру отменена.');
    }

    public function cancelPromotion()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->active_promotion = null;
        $user->save();

        return redirect()->back()->with('success', 'Акция отменена.');
    }

    public function chooseTariff()
    {
        /** @var User $user */
        $user = Auth::user();
        $tariffs = Tariff::where('is_active', true)->orderBy('sort_order')->get();

        return view('dashboard.choose-tariff', compact('tariffs', 'user'));
    }

    public function tariffPayment(Request $request)
    {
        $validated = $request->validate([
            'tariff' => [
                'required',
                'string',
                Rule::exists('tariffs', 'name')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $tariff = Tariff::where('name', $validated['tariff'])
            ->where('is_active', true)
            ->firstOrFail();
        $nextExpiryDate = $this->calculateTariffExpiryDate($user);

        return view('dashboard.tariff-payment', compact('user', 'tariff', 'nextExpiryDate'));
    }

    public function activateTariff(Request $request)
    {
        $request->merge($this->normalizePaymentInput($request));

        $request->validate([
            'tariff' => [
                'required',
                'string',
                Rule::exists('tariffs', 'name')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
            'card_holder' => 'required|string|max:255',
            'card_number' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D+/', '', (string) $value);

                    if (strlen($digits) < 13 || strlen($digits) > 19) {
                        $fail('Введите корректный номер карты.');
                    }
                },
            ],
            'card_expiry' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'card_cvv' => ['required', 'string', 'regex:/^[0-9]{2,4}$/'],
        ], [
            'card_expiry.regex' => 'Укажите срок действия в формате MM/YY.',
            'card_cvv.regex' => 'CVV должен содержать от 2 до 4 цифр.',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->tariff_id = $request->tariff;
        $user->tariff_expires_at = $this->calculateTariffExpiryDate($user);
        $user->save();

        return redirect()->route('dashboard')->with(
            'success',
            'Абонемент успешно активирован до ' . $user->tariff_expires_at->format('d.m.Y') . '!'
        );
    }

    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Профиль обновлен');
    }

    public function bookings()
    {
        /** @var User $user */
        $user = Auth::user();
        $classes = GroupClass::where('is_active', true)->get();
        $myBookings = Booking::where('user_id', $user->id)
            ->latestFirst()
            ->get();

        return view('dashboard.bookings', compact('classes', 'myBookings'));
    }

    public function bookClass(Request $request)
    {
        if (!$this->bookingsHaveTime()) {
            return redirect()->back()->with(
                'error',
                'Для записи на конкретный слот нужно применить свежие миграции базы данных.'
            );
        }

        $request->validate([
            'class' => [
                'required',
                'string',
                Rule::exists('group_classes', 'name')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $class = GroupClass::where('name', $request->class)
            ->where('is_active', true)
            ->firstOrFail();
        $bookingDate = Carbon::parse($request->booking_date)->startOfDay();
        $bookingTime = $class->schedule_start_time;

        if (!$bookingTime) {
            return redirect()->back()->with('error', 'У этого занятия пока не указано время в расписании.');
        }

        if (!$class->runsOnDate($bookingDate)) {
            return redirect()->back()->with('error', 'Это занятие не проводится в выбранный день.');
        }

        $bookingAt = Carbon::createFromFormat(
            'Y-m-d H:i',
            $bookingDate->format('Y-m-d') . ' ' . $bookingTime,
            config('app.timezone')
        );

        if ($bookingAt->lt(now())) {
            return redirect()->back()->with('error', 'Выберите ближайшее занятие в будущем.');
        }

        $existingBooking = Booking::where('user_id', $user->id)
            ->where('class_name', $class->name)
            ->whereDate('booking_date', $bookingDate->format('Y-m-d'))
            ->where('booking_time', $bookingTime)
            ->first();

        if ($existingBooking?->status === 'active') {
            return redirect()->back()->with('error', 'Вы уже записаны на это занятие.');
        }

        if ($existingBooking?->status === 'completed') {
            return redirect()->back()->with('error', 'Эта запись уже отмечена как завершенная.');
        }

        $activeBookingsCount = Booking::where('class_name', $class->name)
            ->whereDate('booking_date', $bookingDate->format('Y-m-d'))
            ->where('booking_time', $bookingTime)
            ->where('status', 'active')
            ->count();

        if ($class->max_people && $activeBookingsCount >= $class->max_people) {
            return redirect()->back()->with('error', 'На это занятие больше нет свободных мест.');
        }

        if ($existingBooking) {
            $existingBooking->update([
                'booking_date' => $bookingDate->format('Y-m-d'),
                'booking_time' => $bookingTime,
                'status' => 'active',
            ]);
        } else {
            Booking::create([
                'user_id' => $user->id,
                'class_name' => $class->name,
                'booking_date' => $bookingDate->format('Y-m-d'),
                'booking_time' => $bookingTime,
                'status' => 'active',
            ]);
        }

        return redirect()->back()->with('success', 'Вы записаны на занятие "' . $class->name . '".');
    }

    public function cancelBooking($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Запись не найдена.');
        }

        if ($booking->status !== 'active') {
            return redirect()->back()->with('error', 'Отменить можно только активную запись.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Запись отменена.');
    }

    public function bookTrainerForm($id)
    {
        $trainer = Trainer::findOrFail($id);

        return view('dashboard.book-trainer', compact('trainer'));
    }

    public function bookTrainer(Request $request)
    {
        if (!$this->trainerBookingsHaveTime()) {
            return redirect()->back()->with(
                'error',
                'Для записи по времени нужно применить свежие миграции базы данных.'
            );
        }

        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'phone' => 'required|string|max:20',
            'comment' => 'nullable|string|max:500',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $trainer = Trainer::findOrFail($request->trainer_id);
        $bookingAt = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->booking_date . ' ' . $request->booking_time,
            config('app.timezone')
        );

        if ($bookingAt->lt(now())) {
            return redirect()->back()
                ->withErrors(['booking_time' => 'Выберите дату и время тренировки в будущем.'])
                ->withInput();
        }

        TrainerBooking::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'trainer_name' => $trainer->name,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'phone' => $request->phone,
            'comment' => $request->comment,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with(
            'success',
            'Заявка на тренировку к ' . $trainer->name . ' отправлена! Мы свяжемся с вами для подтверждения.'
        );
    }

    public function applyPromotion($id)
    {
        /** @var User $user */
        $user = Auth::user();
        $promotion = Promotion::findOrFail($id);

        if (!$promotion->is_active) {
            return redirect()->back()->with('error', 'Эта акция больше не действует');
        }

        if ($promotion->valid_to && now()->gt($promotion->valid_to)) {
            return redirect()->back()->with('error', 'Срок действия акции истек');
        }

        $user->active_promotion = $promotion->title;
        $user->save();

        return redirect()->back()->with('promotion_applied', [
            'title' => $promotion->title,
            'message' => 'Акция "' . $promotion->title . '" применена! Предъявите это сообщение на стойке регистрации.',
            'code' => strtoupper(substr(md5($promotion->id . $user->id), 0, 8)),
        ]);
    }

    private function normalizePaymentInput(Request $request): array
    {
        return [
            'card_holder' => preg_replace('/\s+/', ' ', trim((string) $request->input('card_holder', ''))),
            'card_number' => $this->formatCardNumber((string) $request->input('card_number', '')),
            'card_expiry' => $this->formatCardExpiry((string) $request->input('card_expiry', '')),
            'card_cvv' => substr(preg_replace('/\D+/', '', (string) $request->input('card_cvv', '')), 0, 4),
        ];
    }

    private function formatCardNumber(string $value): string
    {
        $digits = substr(preg_replace('/\D+/', '', $value), 0, 19);

        return trim(implode(' ', str_split($digits, 4)));
    }

    private function formatCardExpiry(string $value): string
    {
        $digits = substr(preg_replace('/\D+/', '', $value), 0, 4);

        if (strlen($digits) <= 2) {
            return $digits;
        }

        return substr($digits, 0, 2) . '/' . substr($digits, 2, 2);
    }

    private function trainerBookingsHaveTime(): bool
    {
        return Schema::hasTable('trainer_bookings')
            && Schema::hasColumn('trainer_bookings', 'booking_time');
    }

    private function bookingsHaveTime(): bool
    {
        return Schema::hasTable('bookings')
            && Schema::hasColumn('bookings', 'booking_time');
    }

    protected function calculateTariffExpiryDate(User $user)
    {
        $currentExpiryDate = $user->tariff_expires_at;

        if ($currentExpiryDate && ($currentExpiryDate->isFuture() || $currentExpiryDate->isToday())) {
            return $currentExpiryDate->copy()->addMonth();
        }

        return now()->addMonth();
    }
}
