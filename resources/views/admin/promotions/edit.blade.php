@extends('layouts.app')

@section('title', 'Редактировать акцию')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/promotions/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.promotions.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать акцию</h1>
    
    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-input" value="{{ $promotion->title }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-input" value="{{ $promotion->slug }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-textarea" rows="4" required>{{ $promotion->description }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Бейдж</label>
            <input type="text" name="badge" class="form-input" value="{{ $promotion->badge }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Изображение</label>
            <input type="file" name="image_file" class="form-input" accept=".jpg,.jpeg,.png,.webp,.gif">
            <div class="hint">Загрузите новое изображение, если хотите заменить текущее</div>
            @if($promotion->image_url)
                <div class="hint">Текущее изображение</div>
                <img src="{{ $promotion->image_url }}" class="image-thumb-round" alt="{{ $promotion->title }}">
            @endif
        </div>
        
        <div class="form-group">
            <label class="form-label">Действует с</label>
            <input type="date" name="valid_from" class="form-input" value="{{ $promotion->valid_from }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Действует до</label>
            <input type="date" name="valid_to" class="form-input" value="{{ $promotion->valid_to }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="{{ $promotion->sort_order }}">
        </div>
        
        <div class="form-checkbox">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $promotion->is_active ? 'checked' : '' }}>
            <label for="is_active">Активна</label>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить изменения</button>
    </form>
</div>
@endsection




