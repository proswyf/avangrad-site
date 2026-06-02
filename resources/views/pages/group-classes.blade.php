@extends('layouts.app')

@section('title', 'Групповые занятия')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/group-classes.css') }}">
@endpush

@section('content')
@php($classesByName = $classes->keyBy('name'))

{{-- ══════════════════════════════════════════
     PAGE HERO
══════════════════════════════════════════ --}}
<div class="gc-hero">
    <div class="gc-hero-grid"  aria-hidden="true"></div>
    <div class="gc-hero-glow"  aria-hidden="true"></div>
    <div class="gc-hero-inner">
        <div class="gc-label">Программы</div>
        <h1 class="gc-heading">Групповые занятия</h1>
        <p class="gc-subtext">Зарядись энергией в компании единомышленников — тренируйся под руководством профессионального инструктора.</p>
    </div>
</div>


{{-- ══════════════════════════════════════════
     CLASSES GRID
══════════════════════════════════════════ --}}
<div class="gc-section">
    <div class="gc-inner">
        <div class="gc-grid">
            @forelse($classes as $class)
                @php(
                    $myActiveBooking = $myBookings->first(
                        fn ($booking) => $booking->class_name === $class->name && $booking->can_be_cancelled
                    )
                )
                <div class="class-card reveal-card">

                    {{-- Image --}}
                    @if($class->image_url)
                    <div class="class-img-wrap">
                        <img src="{{ $class->image_url }}" alt="{{ $class->name }}">
                        <div class="class-img-overlay" aria-hidden="true"></div>
                        {{-- Duration chip --}}
                        <div class="class-duration-chip">{{ $class->duration }} мин</div>
                    </div>
                    @endif

                    {{-- Body --}}
                    <div class="class-body">
                        <div class="class-title">{{ $class->name }}</div>

                        <div class="class-meta">
                            <div class="class-meta-item">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                    <path d="M6 1a4 4 0 1 1 0 8A4 4 0 0 1 6 1Zm0 2v2.5l2 1" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                {{ $class->duration }} мин
                            </div>
                            <div class="class-meta-item">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                    <circle cx="6" cy="4" r="2.5" stroke="currentColor" stroke-width="1.2"/>
                                    <path d="M1 11c0-2.21 2.239-4 5-4s5 1.79 5 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                До {{ $class->max_people }} чел
                            </div>
                            <div class="class-meta-item">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                    <rect x="1" y="2" width="10" height="9" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                                    <path d="M4 1v2M8 1v2M1 5h10" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                {{ $class->schedule }}
                            </div>
                        </div>

                        <div class="class-instructor">
                            <span class="class-instructor-label">Инструктор</span>
                            {{ $class->instructor }}
                        </div>

                        <div class="class-desc">{{ $class->description }}</div>

                        <div class="class-action">
                            @auth
                                @if($myActiveBooking)
                                    <div class="class-booked-row">
                                        <span class="status-pill status-pill--active">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                                <path d="M2 6.5l3 3 5-5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Вы записаны
                                        </span>
                                        <form method="POST" action="{{ route('cancel-booking', $myActiveBooking->id) }}" class="inline-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="class-cancel-btn" onclick="return confirm('Отменить запись?')">
                                                Отменить
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('book-class') }}" class="form-full-width">
                                        @csrf
                                        <input type="hidden" name="class" value="{{ $class->name }}">
                                        <button type="submit" class="class-btn">
                                            Записаться
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                                <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('bookings') }}" class="class-btn class-btn--ghost">
                                    Войти для записи
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="gc-empty">Занятия временно недоступны</div>
            @endforelse
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MY BOOKINGS — only for auth users
══════════════════════════════════════════ --}}
@auth
<div class="gc-bookings-wrap">
    <div class="gc-inner">

        <div class="gc-bookings-head">
            <div class="gc-label">Личный кабинет</div>
            <h2 class="gc-bookings-title">Мои записи</h2>
            <p class="gc-bookings-sub">Здесь отображаются ваши записи на групповые занятия.</p>
        </div>

        @if($myBookings->isNotEmpty())
        <div class="bookings-table-wrap">
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Занятие</th>
                        <th>Расписание</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myBookings as $booking)
                        @php($bookedClass = $classesByName->get($booking->class_name))
                        <tr>
                            <td data-label="Занятие">
                                <span class="booking-name">{{ $booking->class_name }}</span>
                            </td>
                            <td data-label="Расписание">
                                <span class="booking-schedule-chip">{{ $bookedClass?->schedule ?? 'Не указано' }}</span>
                            </td>
                            <td data-label="Дата">
                                {{ $booking->booking_date?->format('d.m.Y') ?? '—' }}
                            </td>
                            <td data-label="Статус">
                                <span class="status-pill status-pill--{{ $booking->resolved_status }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td data-label="Действие">
                                @if($booking->can_be_cancelled)
                                    <form method="POST" action="{{ route('cancel-booking', $booking->id) }}" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="class-cancel-btn" onclick="return confirm('Отменить запись?')">
                                            Отменить
                                        </button>
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
            <div class="gc-empty-bookings">
                <div class="gc-empty-bookings-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <rect x="2" y="4" width="18" height="16" rx="2.5" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M7 2v4M15 2v4M2 9h18" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <path d="M7 14h8M7 17h5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </div>
                <p>У вас пока нет записей на групповые занятия.</p>
            </div>
        @endif

    </div>
</div>
@endauth

@endsection


@push('scripts')
<script>
(function () {
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const siblings = Array.from(e.target.parentElement.querySelectorAll('.reveal-card'));
            const idx = siblings.indexOf(e.target);
            setTimeout(() => e.target.classList.add('visible'), idx * 80);
            obs.unobserve(e.target);
        });
    }, { threshold: 0.06 });
    document.querySelectorAll('.reveal-card').forEach(el => obs.observe(el));
})();
</script>
@endpush

