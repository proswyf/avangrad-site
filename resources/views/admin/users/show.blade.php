@extends('layouts.app')

@section('title', 'Просмотр пользователя')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/show.css') }}">
@endpush

@section('content')

<div class="user-container">
    <div class="user-header">
        <div class="user-avatar">
            👤
        </div>
        <div class="user-name">{{ $user->name }}</div>
        <div class="user-role">
            <span class="badge-{{ $user->role }}">
                {{ $user->role == 'admin' ? 'Администратор' : 'Пользователь' }}
            </span>
        </div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Email</div>
        <div class="info-value">{{ $user->email }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Телефон</div>
        <div class="info-value">{{ $user->phone ?? 'Не указан' }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Абонемент</div>
        <div class="info-value">{{ $user->tariff_id ?? 'Не выбран' }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Действует до</div>
        <div class="info-value">
            @if($user->tariff_expires_at)
                @php
                    $isExpired = now()->gt($user->tariff_expires_at);
                @endphp
                <span class="{{ $isExpired ? 'badge-expired' : 'badge-active' }}">
                    {{ \Carbon\Carbon::parse($user->tariff_expires_at)->format('d.m.Y') }}
                    @if($isExpired) (просрочен) @endif
                </span>
            @else
                -
            @endif
        </div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Дата регистрации</div>
        <div class="info-value">{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : '-' }}</div>
    </div>
    
    <div class="text-center-inline">
        <a href="{{ route('admin.users') }}" class="btn-back">← Назад к списку</a>
    </div>
</div>
@endsection





