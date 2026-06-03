@extends('layouts.app')

@section('title', 'Личный кабинет')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard/index.css') }}">
@endpush

@section('content')
<div class="dashboard-section">
  <div class="dashboard-container">

    <div class="dashboard-page-label">Личный кабинет</div>
    <h1 class="dashboard-heading">Привет, {{ $user->name }}</h1>
    <p class="dashboard-subtext">Добро пожаловать в личный кабинет Авангард. Здесь ты можешь управлять своим абонементом, записываться на тренировки и следить за прогрессом.</p>

    @if(!$user->tariff_id)
      <div class="tariff-banner">
        <div class="tariff-banner-info">
          <div class="tariff-banner-label">Нет активного абонемента</div>
          <div class="tariff-banner-title">Начни тренироваться сегодня</div>
          <div class="tariff-banner-sub">Выбери подходящий тариф и приступай</div>
        </div>
        <a href="{{ route('tariffs') }}" class="tariff-banner-btn">
          Выбрать абонемент
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    @else
      <div class="tariff-banner active">
        <div class="tariff-banner-info">
          <div class="tariff-banner-label">Активный абонемент</div>
          <div class="tariff-banner-title">{{ $user->tariff_id }}</div>
          <div class="tariff-banner-sub">Действует до {{ \Carbon\Carbon::parse($user->tariff_expires_at)->format('d.m.Y') }}</div>
        </div>
        <a href="{{ route('choose-tariff') }}" class="tariff-banner-btn">
          Продлить
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    @endif

    @if($user->active_promotion)
      <div class="promo-banner">
        <div class="promo-banner-left">
          <div class="promo-banner-label">Активная акция</div>
          <div class="promo-banner-title">{{ $user->active_promotion }}</div>
          <div class="promo-banner-sub">Предъявите код на стойке регистрации</div>
        </div>
        <div class="promo-code">
          {{ strtoupper(substr(md5($user->id), 0, 8)) }}
        </div>
      </div>
    @endif

    <div class="dashboard-grid">

      <a href="{{ route('choose-tariff') }}" class="dashboard-item">
        <div class="dashboard-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8C8C8C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-4 0v2M8 7V5a2 2 0 0 0-4 0v2"/></svg>
        </div>
        <div>
          <div class="dashboard-item-title">Абонементы</div>
          <div class="dashboard-item-desc">Выбрать или продлить абонемент</div>
        </div>
        <div class="dashboard-item-link">
          Перейти
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
      </a>

      <a href="{{ route('bookings') }}" class="dashboard-item">
        <div class="dashboard-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8C8C8C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div>
          <div class="dashboard-item-title">Запись</div>
          <div class="dashboard-item-desc">Запишись на групповые занятия</div>
        </div>
        <div class="dashboard-item-link">
          Перейти
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
      </a>
@if($upcomingTrainerBookings->isNotEmpty())
  <div class="trainer-booking-list">
    @foreach($upcomingTrainerBookings as $tb)
      <div class="trainer-booking-card">
        <div class="trainer-booking-main">

          {{-- фото тренера --}}
          <div class="trainer-booking-avatar">
            @if($tb->trainer?->image_url)
              <img src="{{ $tb->trainer->image_url }}" alt="{{ $tb->trainer_name }}">
            @else
              <div class="trainer-booking-avatar-fallback">
                {{ mb_strtoupper(mb_substr($tb->trainer_name, 0, 1)) }}
              </div>
            @endif
          </div>

          <div>
            <div class="trainer-booking-kicker">
              Предстоящая тренировка
            </div>
            <div class="trainer-booking-name">
              {{ $tb->trainer_name }}
            </div>
            @if($tb->trainer?->position)
              <div class="trainer-booking-position">
                {{ $tb->trainer->position }}
              </div>
            @endif
            <div class="trainer-booking-actions">
            <form method="POST" action="{{ route('cancel-trainer-booking', $tb->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit"
                      onclick="return confirm('Отменить запись к тренеру {{ $tb->trainer_name }}?')"
                      class="trainer-booking-cancel">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
                Отменить
              </button>
            </form>
          </div>
          </div>
        </div>

        <div class="trainer-booking-meta">
          <div class="trainer-booking-meta-item">
            <div class="trainer-booking-meta-label">Дата</div>
            <div class="trainer-booking-meta-value">
              {{ $tb->booking_date_label ?? '—' }}
            </div>
          </div>

          <div class="trainer-booking-meta-item">
            <div class="trainer-booking-meta-label">День</div>
            <div class="trainer-booking-meta-value">
              {{ $tb->booking_weekday_label ?? '—' }}
            </div>
          </div>

          <div class="trainer-booking-meta-item">
            <div class="trainer-booking-meta-label">Время</div>
            <div class="trainer-booking-meta-value">
              {{ $tb->booking_time_label ?? 'Уточняется' }}
            </div>
          </div>

          @if($tb->comment)
            <div class="trainer-booking-meta-item">
              <div class="trainer-booking-meta-label">Комментарий</div>
              <div class="trainer-booking-comment">{{ $tb->comment }}</div>
            </div>
          @endif
        </div>
      </div>
    @endforeach
  </div>
@endif
      <a href="{{ route('profile') }}" class="dashboard-item">
        <div class="dashboard-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8C8C8C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        </div>
        <div>
          <div class="dashboard-item-title">Профиль</div>
          <div class="dashboard-item-desc">Редактировать личные данные</div>
        </div>
        <div class="dashboard-item-link">
          Перейти
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
      </a>

    </div>
  </div>
</div>
@endsection

