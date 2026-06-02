@extends('layouts.app')

@section('title', 'Вход')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
@endpush

@section('content')
<div class="login-section">
  <div class="login-container">

    <div class="login-header">
      <div class="login-header-top">
       
      </div>
      <h2>Добро пожаловать</h2>
      <p>Войдите в свой аккаунт</p>
    </div>

    <div class="login-card">

      @if($errors->any())
        <div class="error-message">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Email адрес</label>
          <input type="email" class="form-input" name="email"
                 placeholder="example@mail.ru"
                 value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
          <label class="form-label">Пароль</label>
          <input type="password" class="form-input" name="password"
                 placeholder="••••••••" required>
        </div>
        <button type="submit" class="login-button">
          Войти
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </form>

      <div class="login-divider"></div>

      <div class="login-footer">
        <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрируйтесь</a></p>
      </div>

    </div>
  </div>
</div>
@endsection

