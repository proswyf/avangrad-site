@extends('layouts.app')

@section('title', 'Оплата абонемента')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard/tariff-payment.css') }}">
@endpush

@section('content')
<div class="payment-page">
  <div class="payment-shell">
    <div class="payment-header">
      <div>
        <div class="payment-label">Оплата</div>
        <h1 class="payment-title">Подтверждение абонемента</h1>
        <p class="payment-subtitle">Проверьте выбранный тариф, добавьте карту и подтвердите оплату абонемента.</p>
      </div>

      <a href="{{ route('choose-tariff') }}" class="payment-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Назад
      </a>
    </div>

    <div class="payment-grid">
      <section class="payment-card">
        <div class="payment-card-kicker">Выбранный тариф</div>
        <div class="payment-tariff-name">{{ $tariff->name }}</div>
        <div class="payment-price">
          {{ number_format($tariff->price, 0, '', ' ') }} <span>₽</span>
        </div>
        <div class="payment-period">Период: {{ $tariff->period }}</div>

        <div class="payment-features">
          @php
            $features = is_array($tariff->features) ? $tariff->features : json_decode($tariff->features, true);
          @endphp
          @foreach($features ?? [] as $feature)
            <div class="payment-feature">
              <span>✓</span>
              <div>{{ $feature }}</div>
            </div>
          @endforeach
        </div>
      </section>

      <section class="payment-card payment-card--accent">
        <div class="payment-card-kicker">Детали оплаты</div>

        <div class="payment-status">
          <div class="payment-status-dot"></div>
          <div>Оплата банковской картой</div>
        </div>

        <form method="POST" action="{{ route('activate-tariff') }}">
          @csrf
          <input type="hidden" name="tariff" value="{{ $tariff->name }}">

          <div class="payment-form-grid">
            <label class="payment-field">
              <span>Имя владельца карты</span>
              <input type="text" name="card_holder" value="{{ old('card_holder', $user->name) }}" placeholder="IVAN IVANOV" required>
            </label>

            <label class="payment-field payment-field--full">
              <span>Номер карты</span>
              <input type="text" name="card_number" value="{{ old('card_number') }}" inputmode="numeric" placeholder="1111 2222 3333 4444" required>
            </label>

            <label class="payment-field">
              <span>Срок действия</span>
              <input type="text" name="card_expiry" value="{{ old('card_expiry') }}" inputmode="numeric" placeholder="MM/YY" required>
            </label>

            <label class="payment-field">
              <span>CVV</span>
              <input type="password" name="card_cvv" inputmode="numeric" placeholder="123" maxlength="4" required>
            </label>
          </div>

          <div class="payment-summary">
            <div class="payment-row">
              <span>Текущий тариф</span>
              <strong>{{ $user->tariff_id ?? 'Нет активного' }}</strong>
            </div>
            <div class="payment-row">
              <span>Текущий срок</span>
              <strong>{{ $user->tariff_expires_at ? $user->tariff_expires_at->format('d.m.Y') : 'Не задан' }}</strong>
            </div>
            <div class="payment-row">
              <span>Новый срок после оплаты</span>
              <strong>{{ $nextExpiryDate->format('d.m.Y') }}</strong>
            </div>
            <div class="payment-row">
              <span>Сумма к списанию</span>
              <strong>{{ number_format($tariff->price, 0, '', ' ') }} ₽</strong>
            </div>
          </div>

          <div class="payment-note">
            После подтверждения оплаты абонемент сразу активируется или продлевается до новой даты.
          </div>

          <button type="submit" class="payment-submit">
            Добавить карту и оплатить
          </button>
        </form>
      </section>
    </div>
  </div>
</div>
@endsection
