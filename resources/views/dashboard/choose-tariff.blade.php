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

      {{-- Стартовый --}}
      @php $isCurrent = $user->tariff_id === 'Стартовый'; @endphp
      <div class="tp-tariff-card {{ $isCurrent ? 'current' : '' }}">
        @if($isCurrent)
          <div class="tp-current-line"></div>
          <div class="tp-current-badge">Текущий</div>
        @endif
        <div class="tp-tariff-name">Стартовый</div>
        <div class="tp-tariff-price">1 500 <sub>₽</sub></div>
        <div class="tp-tariff-period">в месяц</div>
        <div class="tp-features">
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Тренажерный зал</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Кардиозона</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Раздевалка с душем</div>
          <div class="tp-feature tp-feature--off"><span class="tp-feature-icon">—</span>Групповые занятия</div>
          <div class="tp-feature tp-feature--off"><span class="tp-feature-icon">—</span>Бассейн</div>
        </div>
        <form method="POST" action="{{ route('activate-tariff') }}">
          @csrf
          <input type="hidden" name="tariff" value="Стартовый">
          <button type="submit" class="tp-btn">
            {{ $isCurrent ? 'Продлить на месяц' : 'Активировать' }}
          </button>
        </form>
      </div>

      {{-- Оптимальный --}}
      @php $isCurrent = $user->tariff_id === 'Оптимальный'; @endphp
      <div class="tp-tariff-card {{ $isCurrent ? 'current' : 'popular' }}">
        @if($isCurrent)
          <div class="tp-current-line"></div>
          <div class="tp-current-badge">Текущий</div>
        @endif
        <div class="tp-tariff-name">Оптимальный</div>
        <div class="tp-tariff-price">3 000 <sub>₽</sub></div>
        <div class="tp-tariff-period">в месяц</div>
        <div class="tp-features">
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Тренажерный зал</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Кардиозона</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Раздевалка с душем</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Групповые занятия</div>
          <div class="tp-feature tp-feature--off"><span class="tp-feature-icon">—</span>Бассейн</div>
        </div>
        <form method="POST" action="{{ route('activate-tariff') }}">
          @csrf
          <input type="hidden" name="tariff" value="Оптимальный">
          <button type="submit" class="tp-btn">
            {{ $isCurrent ? 'Продлить на месяц' : 'Активировать' }}
          </button>
        </form>
      </div>

      {{-- VIP --}}
      @php $isCurrent = $user->tariff_id === 'VIP'; @endphp
      <div class="tp-tariff-card {{ $isCurrent ? 'current' : '' }}">
        @if($isCurrent)
          <div class="tp-current-line"></div>
          <div class="tp-current-badge">Текущий</div>
        @endif
        <div class="tp-tariff-name">VIP</div>
        <div class="tp-tariff-price">5 000 <sub>₽</sub></div>
        <div class="tp-tariff-period">в месяц</div>
        <div class="tp-features">
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Тренажерный зал</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Кардиозона</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Раздевалка с душем</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Групповые занятия</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Бассейн</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Персональный тренер</div>
          <div class="tp-feature"><span class="tp-feature-icon">✓</span>Фитнес-бар со скидкой</div>
        </div>
        <form method="POST" action="{{ route('activate-tariff') }}">
          @csrf
          <input type="hidden" name="tariff" value="VIP">
          <button type="submit" class="tp-btn">
            {{ $isCurrent ? 'Продлить на месяц' : 'Активировать' }}
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection

