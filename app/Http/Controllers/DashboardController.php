<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GroupClass;
use App\Models\Promotion;
use App\Models\Tariff;
use App\Models\Trainer;
use App\Models\TrainerBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $upcomingTrainerBookings = TrainerBooking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
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
            ->where('status', 'pending')
            ->firstOrFail();

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

    public function activateTariff(Request $request)
    {
        $request->validate([
            'tariff' => 'required|string',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->tariff_id = $request->tariff;
        $user->tariff_expires_at = now()->addMonth();
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Абонемент успешно активирован!');
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
        $request->validate([
            'class' => [
                'required',
                'string',
                Rule::exists('group_classes', 'name')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $bookingDate = now()->toDateString();
        $class = GroupClass::where('name', $request->class)
            ->where('is_active', true)
            ->firstOrFail();

        $existingBooking = Booking::where('user_id', $user->id)
            ->where('class_name', $class->name)
            ->whereDate('booking_date', $bookingDate)
            ->first();

        if ($existingBooking?->status === 'active') {
            return redirect()->back()->with('error', 'Вы уже записаны на это занятие.');
        }

        if ($existingBooking?->status === 'completed') {
            return redirect()->back()->with('error', 'Эта запись уже отмечена как завершенная.');
        }

        $activeBookingsCount = Booking::where('class_name', $class->name)
            ->whereDate('booking_date', $bookingDate)
            ->where('status', 'active')
            ->count();

        if ($class->max_people && $activeBookingsCount >= $class->max_people) {
            return redirect()->back()->with('error', 'На это занятие больше нет свободных мест.');
        }

        if ($existingBooking) {
            $existingBooking->update(['status' => 'active']);
        } else {
            Booking::create([
                'user_id' => $user->id,
                'class_name' => $class->name,
                'booking_date' => $bookingDate,
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
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'phone' => 'required|string|max:20',
            'comment' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $trainer = Trainer::findOrFail($request->trainer_id);

        TrainerBooking::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'trainer_name' => $trainer->name,
            'booking_date' => $request->booking_date,
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
}
