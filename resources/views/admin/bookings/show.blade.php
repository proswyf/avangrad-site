@extends('layouts.app')

@section('title', 'Просмотр записи')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/bookings/show.css') }}">
@endpush

@section('content')
@php
    $userName = $booking->user?->name ?? 'Пользователь удален';
    $userEmail = $booking->user?->email ?? 'Email недоступен';
    $statusLabel = $booking->status === 'active' ? 'Активна' : ($booking->status === 'cancelled' ? 'Отменена' : 'Завершена');
    $statusClass = $booking->status === 'active'
        ? 'show-badge show-badge--ok'
        : ($booking->status === 'cancelled' ? 'show-badge show-badge--danger' : 'show-badge show-badge--info');
@endphp

<div class="show-container">
    <div class="show-header">
        <p class="show-eyebrow">Просмотр записи</p>
        <h1 class="show-title">Запись на тренировку #{{ $booking->id }}</h1>
        <p class="show-subtitle">{{ $userName }} · {{ $userEmail }}</p>
    </div>
    
    <div class="show-row">
        <div class="show-label">Дата записи</div>
        <div class="show-value">{{ $booking->created_at->format('d.m.Y H:i') }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Пользователь</div>
        <div class="show-value">
            <strong>{{ $userName }}</strong>
            <small>{{ $userEmail }}</small>
        </div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Телефон</div>
        <div class="show-value">{{ $booking->user?->phone ?? 'Не указан' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Занятие</div>
        <div class="show-value">{{ $booking->class_name }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Дата тренировки</div>
        <div class="show-value">{{ $booking->booking_date_label ?? '—' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">День недели</div>
        <div class="show-value">{{ $booking->booking_weekday_label ?? '—' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Время тренировки</div>
        <div class="show-value">{{ $booking->booking_time_label ?? 'По расписанию' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Статус</div>
        <div class="show-value show-value--form">
            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
            <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" class="inline-form">
                @csrf
                @method('PUT')
                <select name="status" class="status-select" onchange="this.form.submit()">
                    <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>Активна</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Отменена</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Завершена</option>
                </select>
            </form>
        </div>
    </div>
    
    <div class="show-footer">
        <a href="{{ route('admin.bookings') }}" class="btn-back">← Назад к списку</a>
    </div>
</div>
@endsection





