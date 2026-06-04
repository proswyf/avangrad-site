@extends('layouts.app')

@section('title', 'Просмотр заявки')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/trainer-bookings/show.css') }}">
@endpush

@section('content')
@php
    $clientName = $booking->user?->name ?? 'Клиент удален';
    $clientEmail = $booking->user?->email ?? 'Email недоступен';
    $statusLabel = $booking->status === 'pending'
        ? 'Ожидает'
        : ($booking->status === 'confirmed'
            ? 'Подтверждена'
            : ($booking->status === 'cancelled' ? 'Отменена' : 'Завершена'));
    $statusClass = $booking->status === 'pending'
        ? 'show-badge show-badge--warn'
        : ($booking->status === 'confirmed'
            ? 'show-badge show-badge--ok'
            : ($booking->status === 'cancelled' ? 'show-badge show-badge--danger' : 'show-badge show-badge--info'));
@endphp

<div class="show-container">
    <div class="show-header">
        <p class="show-eyebrow">Просмотр заявки</p>
        <h1 class="show-title">Заявка к тренеру #{{ $booking->id }}</h1>
        <p class="show-subtitle">{{ $clientName }} · {{ $clientEmail }}</p>
    </div>
    
    <div class="show-row">
        <div class="show-label">Дата заявки</div>
        <div class="show-value">{{ $booking->created_at->format('d.m.Y H:i') }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Клиент</div>
        <div class="show-value">
            <strong>{{ $clientName }}</strong>
            <small>{{ $clientEmail }}</small>
        </div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Телефон</div>
        <div class="show-value">{{ $booking->phone ?: 'Не указан' }}</div>
    </div>
    
    <div class="show-row">
        <div class="show-label">Тренер</div>
        <div class="show-value">{{ $booking->trainer_name }}</div>
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
        <div class="show-value">{{ $booking->booking_time_label ?? 'Уточняется' }}</div>
    </div>
    
    @if($booking->comment)
    <div class="show-row">
        <div class="show-label">Комментарий</div>
        <div class="show-value show-value--text">{{ $booking->comment }}</div>
    </div>
    @endif
    
    <div class="show-row">
        <div class="show-label">Статус</div>
        <div class="show-value show-value--form">
            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
            <form action="{{ route('admin.trainer-bookings.status', $booking->id) }}" method="POST" class="inline-form">
                @csrf
                @method('PUT')
                <select name="status" class="status-select" onchange="this.form.submit()">
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Ожидает</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Подтверждена</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Отменена</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Завершена</option>
                </select>
            </form>
        </div>
    </div>
    
    <div class="show-footer">
        <a href="{{ route('admin.trainer-bookings') }}" class="btn-back">← Назад к списку</a>
    </div>
</div>
@endsection







