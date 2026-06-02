@extends('layouts.app')

@section('title', 'Добавить запись')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/bookings/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.bookings') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить запись на тренировку</h1>
    
    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Пользователь</label>
            <select name="user_id" class="form-select" required>
                <option value="">Выберите пользователя</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Занятие</label>
            <select name="class_name" class="form-select" required>
                <option value="">Выберите занятие</option>
                @foreach($classes as $class)
                <option value="{{ $class->name }}">{{ $class->name }} ({{ $class->schedule }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
    <label class="form-label">Дата тренировки</label>
    <input type="date" name="booking_date" class="form-input" required>
</div>
        
        <div class="form-group">
            <label class="form-label">Статус</label>
            <select name="status" class="form-select" required>
                <option value="active">Активна</option>
                <option value="cancelled">Отменена</option>
                <option value="completed">Завершена</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить</button>
    </form>
</div>
@endsection




