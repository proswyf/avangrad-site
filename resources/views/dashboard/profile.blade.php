@extends('layouts.app')

@section('title', 'Мой профиль')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard/profile.css') }}">
@endpush

@section('content')
<div class="login-section">
  <div class="login-container profile-login-container">

    <div class="login-header">
      <div class="login-header-top">
        <span class="login-eyebrow">Личный кабинет</span>
      </div>
      <h2>Мой профиль</h2>
      <p>Редактируйте свои данные</p>
    </div>

    <div class="login-card">

      @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('profile') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Имя</label>
          <input type="text" class="form-input" name="name"
                 value="{{ $user->name }}"
                 placeholder="Как вас зовут?" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-input" name="email"
                 value="{{ $user->email }}"
                 placeholder="example@mail.ru" required>
        </div>
        <div class="form-group">
          <label class="form-label">Телефон</label>
          <input type="tel" class="form-input" name="phone"
                 value="{{ $user->phone }}"
                 placeholder="+7 (___) ___-__-__">
        </div>
        <button type="submit" class="login-button">
          Сохранить изменения
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 6L9 17l-5-5"/>
          </svg>
        </button>
      </form>

      <div class="login-divider"></div>


      <div class="profile-actions">
        <a href="{{ route('dashboard') }}" class="logout-button">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="1.8"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
          </svg>
          Назад
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-button">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
            </svg>
            Выйти из аккаунта
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection

