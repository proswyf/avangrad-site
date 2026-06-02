@extends('layouts.app')

@section('title', 'Регистрация')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/register.css') }}">
@endpush

@section('content')
<div class="login-section">
  <div class="login-container">

    <div class="login-header">
      <div class="login-header-top">
      </div>
      <h2>Создать аккаунт</h2>
      <p>Начни свой путь к идеальному телу</p>
    </div>

    <div class="login-card">

      @if($errors->any())
        <div class="error-message">
          @foreach($errors->all() as $error)
            {{ $error }}<br>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Имя</label>
          <input type="text" class="form-input" name="name"
                 placeholder="Как вас зовут?"
                 value="{{ old('name') }}" required autofocus>
        </div>
        <div class="form-group">
          <label class="form-label">Email адрес</label>
          <input type="email" class="form-input" name="email"
                 placeholder="example@mail.ru"
                 value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Пароль</label>
          <input type="password" class="form-input" name="password"
                 placeholder="Минимум 6 символов" required>
          <span class="password-hint">Минимум 6 символов</span>
        </div>
        <div class="form-group">
          <label class="form-label">Подтверждение пароля</label>
          <input type="password" class="form-input" name="password_confirmation"
                 placeholder="Повторите пароль" required>
        </div>
        <div class="form-group" style="flex-direction:row;align-items:flex-start;gap:10px;">
          <input type="checkbox" name="agree" id="agree" required
                 style="width:16px;height:16px;margin-top:2px;flex-shrink:0;accent-color:var(--ink);cursor:pointer;">
          <label for="agree" style="font-size:.80rem;color:var(--ink-muted);font-weight:300;line-height:1.5;cursor:pointer;">
            Я соглашаюсь на
            <a href="{{ route('privacy.policy') }}" style="color:var(--ink);font-weight:500;text-decoration:none;border-bottom:1px solid var(--border-hard);padding-bottom:1px;">
              обработку персональных данных
            </a>
          </label>
        </div>
        <button type="submit" class="login-button">
          Зарегистрироваться
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </form>

      <div class="login-divider"></div>

      <div class="login-footer">
        <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войдите</a></p>
      </div>

    </div>
  </div>
</div>
@endsection

