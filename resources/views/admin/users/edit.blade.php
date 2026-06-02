@extends('layouts.app')

@section('title', 'Редактировать пользователя')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.users') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать пользователя</h1>
    
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-input" value="{{ $user->phone }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Пароль (оставьте пустым, чтобы не менять)</label>
            <input type="password" name="password" class="form-input">
            <div class="hint">Минимум 6 символов. Заполните только если хотите сменить пароль</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Роль</label>
            <select name="role" class="form-select" required>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Абонемент</label>
            <select name="tariff_id" class="form-select">
                <option value="">Без абонемента</option>
                @foreach($tariffs as $tariff)
                <option value="{{ $tariff->name }}" {{ $user->tariff_id == $tariff->name ? 'selected' : '' }}>
                    {{ $tariff->name }} - {{ number_format($tariff->price, 0, '', ' ') }} ₽
                </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Действует до</label>
            <input type="date" name="tariff_expires_at" class="form-input" value="{{ $user->tariff_expires_at }}">
        </div>
        
        <button type="submit" class="btn-submit">Сохранить изменения</button>
    </form>
</div>
@endsection




