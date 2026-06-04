@extends('layouts.app')

@section('title', 'Просмотр пользователя')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/show.css') }}">
@endpush

@section('content')
@php
    $roleLabel = $user->role == 'admin' ? 'Администратор' : 'Пользователь';
    $roleClass = $user->role == 'admin' ? 'show-badge show-badge--info' : 'show-badge show-badge--neutral';
@endphp

<div class="show-container">
    <div class="show-header">
        <p class="show-eyebrow">Просмотр пользователя</p>
        <h1 class="show-title">{{ $user->name }}</h1>
        <p class="show-subtitle">{{ $user->email }}</p>
    </div>
    
    <div class="show-row">
        <div class="show-label">Email</div>
        <div class="show-value">{{ $user->email }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Телефон</div>
        <div class="show-value">{{ $user->phone ?? 'Не указан' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Роль</div>
        <div class="show-value">
            <span class="{{ $roleClass }}">{{ $roleLabel }}</span>
        </div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Абонемент</div>
        <div class="show-value">{{ $user->tariff_id ?? 'Не выбран' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Действует до</div>
        <div class="show-value">
            @if($user->tariff_expires_at)
                @php
                    $isExpired = now()->gt($user->tariff_expires_at);
                @endphp
                <span class="{{ $isExpired ? 'show-badge show-badge--danger' : 'show-badge show-badge--ok' }}">
                    {{ \Carbon\Carbon::parse($user->tariff_expires_at)->format('d.m.Y') }}
                    @if($isExpired) (просрочен) @endif
                </span>
            @else
                -
            @endif
        </div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Дата регистрации</div>
        <div class="show-value">{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : '-' }}</div>
    </div>
    
    <div class="show-footer">
        <a href="{{ route('admin.users') }}" class="btn-back">← Назад к списку</a>
    </div>
</div>
@endsection





