@extends('layouts.app')

@section('title', 'Добавить пользователя')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.users') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить пользователя</h1>
    
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-input" placeholder="+7 (___) ___-__-__">
        </div>
        
        <div class="form-group">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-input" required>
            <div class="hint">Минимум 6 символов</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Роль</label>
            <select name="role" class="form-select" required>
                <option value="user">Пользователь</option>
                <option value="admin">Администратор</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Абонемент</label>
            <select name="tariff_id" class="form-select">
                <option value="">Без абонемента</option>
                @foreach($tariffs as $tariff)
                <option value="{{ $tariff->name }}">{{ $tariff->name }} - {{ number_format($tariff->price, 0, '', ' ') }} ₽</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Действует до</label>
            <input type="date" name="tariff_expires_at" class="form-input">
        </div>
        
        <button type="submit" class="btn-submit">Сохранить</button>
    </form>
</div>
@endsection




