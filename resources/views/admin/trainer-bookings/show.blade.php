@extends('layouts.app')

@section('title', 'Просмотр заявки')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/trainer-bookings/show.css') }}">
@endpush

@section('content')

<div class="booking-container">
    <div class="booking-header">
        <h1>Заявка #{{ $booking->id }}</h1>
        <p>Клиент: {{ $booking->user->name }}</p>
    </div>
    
    <div class="info-row">
        <div class="info-label">Дата заявки</div>
        <div class="info-value">{{ $booking->created_at->format('d.m.Y H:i') }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Клиент</div>
        <div class="info-value">{{ $booking->user->name }} ({{ $booking->user->email }})</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Телефон</div>
        <div class="info-value">{{ $booking->phone }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Тренер</div>
        <div class="info-value">{{ $booking->trainer_name }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Дата тренировки</div>
        <div class="info-value">{{ $booking->booking_date_label ?? '—' }}</div>
    </div>

    <div class="info-row">
        <div class="info-label">День недели</div>
        <div class="info-value">{{ $booking->booking_weekday_label ?? '—' }}</div>
    </div>

    <div class="info-row">
        <div class="info-label">Время тренировки</div>
        <div class="info-value">{{ $booking->booking_time_label ?? 'Уточняется' }}</div>
    </div>
    
    @if($booking->comment)
    <div class="info-row">
        <div class="info-label">Комментарий</div>
        <div class="info-value">{{ $booking->comment }}</div>
    </div>
    @endif
    
    <div class="info-row">
        <div class="info-label">Статус</div>
        <div class="info-value">
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
            <span class="status-badge status-{{ $booking->status }} status-offset">
                {{ $booking->status === 'pending' ? 'Ожидает' : ($booking->status === 'confirmed' ? 'Подтверждена' : ($booking->status === 'cancelled' ? 'Отменена' : 'Завершена')) }}
            </span>
        </div>
    </div>
    
    <div class="text-center-inline">
        <a href="{{ route('admin.trainer-bookings') }}" class="btn-back">← Назад к списку</a>
    </div>
</div>
@endsection







