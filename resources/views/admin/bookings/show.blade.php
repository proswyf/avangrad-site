@extends('layouts.app')

@section('title', 'Просмотр записи')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/bookings/show.css') }}">
@endpush

@section('content')

<div class="booking-container">
    <div class="booking-header">
        <h1>Запись на тренировку #{{ $booking->id }}</h1>
    </div>
    
    <div class="info-row">
        <div class="info-label">Дата записи</div>
        <div class="info-value">{{ $booking->created_at->format('d.m.Y H:i') }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Пользователь</div>
        <div class="info-value">{{ $booking->user->name }} ({{ $booking->user->email }})</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Телефон</div>
        <div class="info-value">{{ $booking->user->phone ?? 'Не указан' }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Занятие</div>
        <div class="info-value">{{ $booking->class_name }}</div>
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
    <div class="info-value">{{ $booking->booking_time_label ?? 'По расписанию' }}</div>
</div>
    
    <div class="info-row">
        <div class="info-label">Статус</div>
        <div class="info-value">
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
    
    <div class="text-center-inline">
        <a href="{{ route('admin.bookings') }}" class="btn-back">← Назад к списку</a>
    </div>
</div>
@endsection





