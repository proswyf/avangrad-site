<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GroupClassController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TrainerReviewController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/tariffs', 'tariffs')->name('tariffs');
    Route::get('/promotions', 'promotions')->name('promotions');
    Route::get('/group-classes', 'groupClasses')->name('group-classes');
    Route::get('/trainers', 'trainers')->name('trainers');
    Route::get('/trainer/{id}', 'trainerProfile')->name('trainer.profile');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/obrabotka-personalnyh-dannyh', function () {
        return view('pages.obrabotkapersdann');
    })->name('privacy.policy');
    Route::view('/privacy-policy', 'privacy-policy')->name('politikakonf');
});

Route::middleware('guest')->controller(PageController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
});

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/cancel-promotion', [DashboardController::class, 'cancelPromotion'])->name('cancel-promotion');
    Route::delete('/trainer-booking/{id}/cancel', [DashboardController::class, 'cancelTrainerBooking'])->name('cancel-trainer-booking');
    Route::post('/trainer/{trainerId}/reviews', [TrainerReviewController::class, 'store'])->name('trainer.reviews.store');

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/choose-tariff', 'chooseTariff')->name('choose-tariff');
        Route::get('/tariff-payment', 'tariffPayment')->name('tariff-payment');
        Route::post('/activate-tariff', 'activateTariff')->name('activate-tariff');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile');
        Route::get('/bookings', 'bookings')->name('bookings');
        Route::post('/book-class', 'bookClass')->name('book-class');
        Route::delete('/cancel-booking/{id}', 'cancelBooking')->name('cancel-booking');
        Route::get('/book-trainer/{id}', 'bookTrainerForm')->name('book-trainer.form');
        Route::post('/book-trainer', 'bookTrainer')->name('book-trainer');
        Route::post('/apply-promotion/{id}', 'applyPromotion')->name('apply-promotion');
    });
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');

            Route::prefix('users')->group(function () {
                Route::get('/', 'users')->name('users');
                Route::get('/create', 'createUser')->name('users.create');
                Route::post('/', 'storeUser')->name('users.store');
                Route::get('/{id}', 'showUser')->name('users.show');
                Route::get('/{id}/edit', 'editUser')->name('users.edit');
                Route::put('/{id}', 'updateUser')->name('users.update');
                Route::delete('/{id}', 'deleteUser')->name('users.delete');
            });

            Route::prefix('bookings')->group(function () {
                Route::get('/', 'bookings')->name('bookings');
                Route::get('/create', 'createBooking')->name('bookings.create');
                Route::post('/', 'storeBooking')->name('bookings.store');
                Route::get('/stats', 'bookingsStats')->name('bookings.stats');
                Route::get('/{id}', 'showBooking')->name('bookings.show');
                Route::get('/{id}/edit', 'editBooking')->name('bookings.edit');
                Route::put('/{id}', 'updateBooking')->name('bookings.update');
                Route::put('/{id}/status', 'updateBookingStatus')->name('bookings.status');
                Route::delete('/{id}', 'deleteBooking')->name('bookings.delete');
            });

            Route::prefix('trainer-bookings')->group(function () {
                Route::get('/', 'trainerBookings')->name('trainer-bookings');
                Route::get('/{id}', 'showTrainerBooking')->name('trainer-bookings.show');
                Route::put('/{id}/status', 'updateTrainerBookingStatus')->name('trainer-bookings.status');
                Route::delete('/{id}', 'deleteTrainerBooking')->name('trainer-bookings.delete');
            });

            Route::prefix('trainer-reviews')->name('trainer-reviews.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\TrainerReviewController::class, 'index'])->name('index');
                Route::put('/{id}', [\App\Http\Controllers\Admin\TrainerReviewController::class, 'update'])->name('update');
            });
        });

        Route::resource('tariffs', TariffController::class);
        Route::resource('promotions', PromotionController::class);
        Route::resource('classes', GroupClassController::class);
        Route::resource('trainers', TrainerController::class);
        Route::resource('faqs', FaqController::class);
    });
