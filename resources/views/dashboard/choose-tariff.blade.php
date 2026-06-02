@extends('layouts.app')

@section('title', 'Абонементы')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard/choose-tariff.css') }}">
@endpush

@section('content')
<div class="tariffs-page-wrap">
  <div class="tariffs-page-inner">

    <div class="tariffs-page-head">
      <div>
        <div class="tariffs-page-label">Личный кабинет</div>
        <div class="tariffs-page-heading">
          {{ $user->tariff_id ? 'Продлить абонемент' : 'Выбрать абонемент' }}
        </div>
        <p class="tariffs-page-sub">
          {{ $user->tariff_id
            ? 'Продлите текущий тариф или перейдите на другой'
            : 'Выберите подходящий тариф и начните тренироваться сегодня' }}
        </p>
      </div>
      <a href="{{ route('dashboard') }}" class="tariffs-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Назад
      </a>
    </div>

    @if($user->tariff_id)
      <div class="current-tariff-notice">
        <div class="current-tariff-dot"></div>
        <div class="current-tariff-text">
          Активный абонемент: <strong>{{ $user->tariff_id }}</strong>
          — действует до
          <strong>{{ \Carbon\Carbon::parse($user->tariff_expires_at)->format('d.m.Y') }}</strong>
        </div>
      </div>
    @endif

    <div class="tp-tariffs-grid">
      @forelse($tariffs as $tariff)
        @php
          $isCurrent = $user->tariff_id === $tariff->name;
          $features = is_array($tariff->features) ? $tariff->features : json_decode($tariff->features, true);
        @endphp
        <div class="tp-tariff-card {{ $isCurrent ? 'current' : '' }} {{ !$isCurrent && $tariff->is_popular ? 'popular' : '' }}">
          @if($isCurrent)
            <div class="tp-current-line"></div>
            <div class="tp-current-badge">Текущий</div>
          @endif

          <div class="tp-tariff-name">{{ $tariff->name }}</div>
          <div class="tp-tariff-price">{{ number_format($tariff->price, 0, '', ' ') }} <sub>₽</sub></div>
          <div class="tp-tariff-period">в {{ $tariff->period }}</div>

          <div class="tp-features">
            @foreach($features ?? [] as $feature)
              <div class="tp-feature">
                <span class="tp-feature-icon">✓</span>
                {{ $feature }}
              </div>
            @endforeach
          </div>

          <a href="{{ route('tariff-payment', ['tariff' => $tariff->name]) }}" class="tp-btn">
            {{ $isCurrent ? 'Продлить на месяц' : 'Перейти к оплате' }}
          </a>
        </div>
      @empty
        <div class="current-tariff-notice">
          <div class="current-tariff-dot"></div>
          <div class="current-tariff-text">Сейчас нет активных тарифов для покупки.</div>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection

