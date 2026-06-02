@extends('layouts.app')

@section('title', 'Редактировать запись')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/bookings/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.bookings') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать запись #{{ $booking->id }}</h1>
    
    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Пользователь</label>
            <select name="user_id" class="form-select" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Занятие</label>
            <select name="class_name" class="form-select" required>
                @foreach($classes as $class)
                <option value="{{ $class->name }}" {{ $booking->class_name == $class->name ? 'selected' : '' }}>
                    {{ $class->name }} ({{ $class->schedule }})
                </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
    <label class="form-label">Дата тренировки</label>
    <input type="date" name="booking_date" class="form-input" value="{{ $booking->booking_date }}" required>
</div>
        
        <div class="form-group">
            <label class="form-label">Статус</label>
            <select name="status" class="form-select" required>
                <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>Активна</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Отменена</option>
                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Завершена</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить изменения</button>
    </form>
</div>
@endsection




