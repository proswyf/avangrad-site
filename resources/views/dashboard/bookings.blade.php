@extends('layouts.app')

@section('title', 'Запись на тренировки')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/bookings.css') }}">
@endpush

@section('content')
    @php
        $classesByName = $classes->keyBy('name');
    @endphp

    <div class="bookings-section">
        <div class="bookings-container">

            <div class="page-header">
                <div class="page-header-left">
                    <div class="page-header-label">Личный кабинет</div>
                    <h1>Запись на групповые занятия</h1>
                    <p>Выберите тренировку и запишитесь на удобное занятие.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="page-back">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Назад
                </a>
            </div>

            @if(session('success'))
                <div class="booking-message booking-message-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="booking-message booking-message-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="classes-grid">
                @forelse($classes as $class)
                    @php
                        $upcomingSessions = $class->upcoming_sessions;
                        $classUpcomingBookings = $myBookings
                            ->filter(fn($b) => $b->class_name === $class->name && $b->can_be_cancelled)
                            ->sortBy(fn($b) => ($b->booking_date?->format('Y-m-d') ?? '') . ' ' . ($b->booking_time_label ?? '99:99'));
                    @endphp
                    <div class="class-card">
                        @if($class->image_url)
                            <div class="class-image">
                                <img src="{{ $class->image_url }}" alt="{{ $class->name }}">
                            </div>
                        @endif
                        <div class="class-content">
                            <div class="class-title">{{ $class->name }}</div>
                            <div class="class-info">
                                <span class="class-info-item">{{ $class->duration }} мин</span>
                                <span class="class-info-item">До {{ $class->max_people }} чел</span>
                                <span class="class-info-item">{{ $class->instructor }}</span>
                            </div>
                            <div class="class-description">{{ $class->description }}</div>
                            <div class="class-schedule">{{ $class->schedule }}</div>

                            @if($classUpcomingBookings->isNotEmpty())
                                <div class="class-booked-slots">
                                    <div class="class-booked-slots-title">Ваши ближайшие записи</div>
                                    @foreach($classUpcomingBookings as $classBooking)
                                        <div class="class-booked-slot">
                                            <span>{{ $classBooking->booking_schedule_label ?? 'Дата уточняется' }}</span>
                                            <form method="POST" action="{{ route('cancel-booking', $classBooking->id) }}" class="inline-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="booking-action-button" onclick="return confirm('Отменить запись?')">Отменить</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('book-class') }}" class="class-booking-form">
                                @csrf
                                <input type="hidden" name="class" value="{{ $class->name }}">
                                <label class="class-slot-label" for="booking-slot-{{ $class->id }}">Выберите ближайшее занятие</label>
                                <select name="booking_date" id="booking-slot-{{ $class->id }}" class="class-slot-select" required>
                                    <option value="">Выберите дату и время</option>
                                    @foreach($upcomingSessions as $session)
                                        <option value="{{ $session['date'] }}">{{ $session['label'] }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="book-button" {{ empty($upcomingSessions) ? 'disabled' : '' }}>
                                    {{ empty($upcomingSessions) ? 'Слоты появятся позже' : 'Записаться' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state-block">
                        <p class="empty-state-text">Занятия временно недоступны</p>
                    </div>
                @endforelse
            </div>

            <div class="bookings-history">
                <div class="bookings-history-header">
                    <h2>Мои записи</h2>
                    <p>Все ваши групповые занятия и их текущий статус.</p>
                </div>

                @if($myBookings->isNotEmpty())
                    <div class="bookings-table-wrap">
                        <table class="bookings-table">
                            <thead>
                                <tr>
                                    <th>Занятие</th>
                                    <th>Когда</th>
                                    <th>Расписание</th>
                                    <th>Статус</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myBookings as $booking)
                                    @php
                                        $bookedClass = $classesByName->get($booking->class_name);
                                    @endphp
                                    <tr>
                                        <td data-label="Занятие">
                                            <div class="booking-table-title">{{ $booking->class_name }}</div>
                                        </td>
                                        <td data-label="Когда">
                                            {{ $booking->booking_schedule_label ?? ($booking->booking_date?->format('d.m.Y') ?? '—') }}
                                        </td>
                                        <td data-label="Расписание">
                                            <span class="booking-schedule-chip">
                                                {{ $bookedClass?->schedule ?? '—' }}
                                            </span>
                                        </td>
                                        <td data-label="Статус">
                                            <span class="booking-status-pill {{ $booking->resolved_status }}">
                                                {{ $booking->status_label }}
                                            </span>
                                        </td>
                                        <td data-label="Действие">
                                            @if($booking->can_be_cancelled)
                                                <form method="POST" action="{{ route('cancel-booking', $booking->id) }}"
                                                    class="inline-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="booking-action-button"
                                                        onclick="return confirm('Отменить запись?')">Отменить</button>
                                                </form>
                                            @else
                                                <span class="booking-action-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-bookings-panel">
                        <p>У вас пока нет записей на тренировки.</p>
                        <p class="text-small">Выберите занятие выше и запишитесь.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

