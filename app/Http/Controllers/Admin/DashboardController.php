<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\ClubReview;
use App\Models\Tariff;
use App\Models\Promotion;
use App\Models\GroupClass;
use App\Models\Trainer;
use App\Models\TrainerBooking;
use App\Models\TrainerReview;
use App\Models\Faq;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
public function index()
{
    $reviewsReady = $this->trainerReviewsReady();
    $clubReviewsReady = $this->clubReviewsReady();

    $stats = [
        'tariffs' => Tariff::count(),
        'promotions' => Promotion::count(),
        'classes' => GroupClass::count(),
        'trainers' => Trainer::count(),
        'trainer_reviews' => $reviewsReady ? TrainerReview::count() : 0,
        'pending_trainer_reviews' => $reviewsReady ? TrainerReview::pending()->count() : 0,
        'club_reviews' => $clubReviewsReady ? ClubReview::count() : 0,
        'pending_club_reviews' => $clubReviewsReady ? ClubReview::pending()->count() : 0,
        'faqs' => Faq::count(),
        'users' => User::count(),
    ];
    
    return view('admin.dashboard', compact('stats'));
}
    
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }
    
    public function createUser()
    {
        $tariffs = Tariff::where('is_active', true)->get();
        return view('admin.users.create', compact('tariffs'));
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'tariff_id' => 'nullable|string',
            'tariff_expires_at' => 'nullable|date',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'tariff_id' => $request->tariff_id,
            'tariff_expires_at' => $request->tariff_expires_at,
        ]);
        
        return redirect()->route('admin.users')->with('success', 'Пользователь добавлен');
    }
    
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $tariffs = Tariff::where('is_active', true)->get();
        return view('admin.users.edit', compact('user', 'tariffs'));
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'tariff_id' => 'nullable|string',
            'tariff_expires_at' => 'nullable|date',
        ]);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'tariff_id' => $request->tariff_id,
            'tariff_expires_at' => $request->tariff_expires_at,
        ];
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('admin.users')->with('success', 'Пользователь обновлен');
    }
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Нельзя удалить свой аккаунт');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'Пользователь удален');
    }
    
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    
    public function bookings()
    {
        $bookings = Booking::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $stats = [
            'total' => Booking::count(),
            'today' => Booking::whereDate('created_at', today())->count(),
            'active' => Booking::where('status', 'active')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }
    
    public function showBooking($id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }
    
    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:active,cancelled,completed'
        ]);
        
        $booking->update(['status' => $request->status]);
        
        return redirect()->route('admin.bookings')
            ->with('success', 'Статус записи изменен на "' . $request->status . '"');
    }
    
    public function deleteBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        
        return redirect()->route('admin.bookings')
            ->with('success', 'Запись удалена');
    }
    
    public function bookingsStats()
    {
        $stats = [
            'by_class' => Booking::where('status', 'active')
                ->select('class_name', DB::raw('count(*) as total'))
                ->groupBy('class_name')
                ->get(),
            'by_day' => Booking::where('status', 'active')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(7)
                ->get(),
        ];
        
        return view('admin.bookings.stats', compact('stats'));
    }
        // ========== ЗАЯВКИ К ТРЕНЕРАМ ==========
    
    /**
     * Список заявок к тренерам
     */
    public function trainerBookings()
    {
        $bookings = TrainerBooking::with(['user', 'trainer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $stats = [
            'total' => TrainerBooking::count(),
            'pending' => TrainerBooking::where('status', 'pending')->count(),
            'confirmed' => TrainerBooking::where('status', 'confirmed')->count(),
            'cancelled' => TrainerBooking::where('status', 'cancelled')->count(),
            'completed' => TrainerBooking::where('status', 'completed')->count(),
        ];
        
        return view('admin.trainer-bookings.index', compact('bookings', 'stats'));
    }
    
    /**
     * Просмотр заявки
     */
    public function showTrainerBooking($id)
    {
        $booking = TrainerBooking::with(['user', 'trainer'])->findOrFail($id);
        return view('admin.trainer-bookings.show', compact('booking'));
    }
    
    /**
     * Изменение статуса заявки
     */
    public function updateTrainerBookingStatus(Request $request, $id)
    {
        $booking = TrainerBooking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);
        
        $booking->update(['status' => $request->status]);
        
        $statusNames = [
            'pending' => 'Ожидает',
            'confirmed' => 'Подтверждена',
            'cancelled' => 'Отменена',
            'completed' => 'Завершена'
        ];
        
        return redirect()->route('admin.trainer-bookings')
            ->with('success', 'Статус заявки изменен на "' . ($statusNames[$request->status] ?? $request->status) . '"');
    }
    
    /**
     * Удаление заявки
     */
    public function deleteTrainerBooking($id)
    {
        $booking = TrainerBooking::findOrFail($id);
        $booking->delete();
        
        return redirect()->route('admin.trainer-bookings')
            ->with('success', 'Заявка удалена');
    }

    /**
 * Форма создания записи
 */
public function createBooking()
{
    $users = User::all();
    $classes = GroupClass::where('is_active', true)->get();
    return view('admin.bookings.create', compact('users', 'classes'));
}

/**
 * Сохранение новой записи
 */
public function storeBooking(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'class_name' => 'required|string',
        'booking_date' => 'required|date',
        'status' => 'required|in:active,cancelled,completed',
    ]);

    $class = GroupClass::where('name', $request->class_name)->first();
    
    Booking::create([
        'user_id' => $request->user_id,
        'class_name' => $request->class_name,
        'booking_date' => $request->booking_date,
        'booking_time' => $class?->schedule_start_time,
        'status' => $request->status,
    ]);
    
    return redirect()->route('admin.bookings')->with('success', 'Запись добавлена');
}

/**
 * Форма редактирования записи
 */
public function editBooking($id)
{
    $booking = Booking::with('user')->findOrFail($id);
    $users = User::all();
    $classes = GroupClass::where('is_active', true)->get();
    return view('admin.bookings.edit', compact('booking', 'users', 'classes'));
}

/**
 * Обновление записи
 */
public function updateBooking(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'class_name' => 'required|string',
        'booking_date' => 'required|date', 
        'status' => 'required|in:active,cancelled,completed',
    ]);

    $class = GroupClass::where('name', $request->class_name)->first();
    
    $booking->update([
        'user_id' => $request->user_id,
        'class_name' => $request->class_name,
        'booking_date' => $request->booking_date,
        'booking_time' => $class?->schedule_start_time,
        'status' => $request->status,
    ]);
    
    return redirect()->route('admin.bookings')->with('success', 'Запись обновлена');
}

private function trainerReviewsReady(): bool
{
    return Schema::hasTable('trainer_reviews')
        && Schema::hasColumn('trainer_reviews', 'status')
        && Schema::hasColumn('trainer_reviews', 'rating');
}

private function clubReviewsReady(): bool
{
    return Schema::hasTable('club_reviews')
        && Schema::hasColumn('club_reviews', 'status')
        && Schema::hasColumn('club_reviews', 'rating');
}
}
