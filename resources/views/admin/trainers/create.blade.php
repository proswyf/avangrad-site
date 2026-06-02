@extends('layouts.app')

@section('title', 'Добавить тренера')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/trainers/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.trainers.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить тренера</h1>
    
    <form action="{{ route('admin.trainers.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-input" required>
            <div class="hint">Пример: alexey-smirnov</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Должность</label>
            <input type="text" name="position" class="form-input" placeholder="Фитнес-директор, персональный тренер" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Опыт (лет)</label>
            <input type="number" name="experience" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Специализация</label>
            <input type="text" name="specialization" class="form-input" placeholder="силовой тренинг, функциональный тренинг" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Сертификаты</label>
            <input type="text" name="certificates" class="form-input" placeholder="FPA, CrossFit Level 2">
        </div>
        
        <div class="form-group">
            <label class="form-label">Цитата</label>
            <textarea name="quote" class="form-textarea" rows="3" placeholder="Каждое тело уникально..."></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Изображение (имя файла)</label>
            <input type="text" name="image" class="form-input" placeholder="trainer1.jpg">
            <div class="hint">Фото должно лежать в папке public/images/trainers</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="0">
        </div>
        
        <button type="submit" class="btn-submit">Сохранить</button>
    </form>
</div>
@endsection





