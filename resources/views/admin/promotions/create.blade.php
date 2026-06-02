@extends('layouts.app')

@section('title', 'Добавить акцию')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/promotions/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.promotions.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить акцию</h1>
    
    <form action="{{ route('admin.promotions.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-textarea" rows="4" required></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Бейдж (например: Новинка, Ограничено)</label>
            <input type="text" name="badge" class="form-input">
        </div>
        
        <div class="form-group">
            <label class="form-label">Изображение (имя файла, например: promo1.jpg)</label>
            <input type="text" name="image" class="form-input" placeholder="promo1.jpg">
        </div>
        
        <div class="form-group">
            <label class="form-label">Действует с</label>
            <input type="date" name="valid_from" class="form-input">
        </div>
        
        <div class="form-group">
            <label class="form-label">Действует до</label>
            <input type="date" name="valid_to" class="form-input">
        </div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="0">
        </div>
        
        <button type="submit" class="btn-submit">Сохранить</button>
    </form>
</div>
@endsection




