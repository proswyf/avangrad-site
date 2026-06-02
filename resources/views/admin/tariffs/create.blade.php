@extends('layouts.app')

@section('title', 'Добавить тариф')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/tariffs/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.tariffs.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить тариф</h1>
    
    <form action="{{ route('admin.tariffs.store') }}" method="POST" id="tariffForm">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Название</label>
            <input type="text" name="name" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug (уникальный идентификатор)</label>
            <input type="text" name="slug" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Цена (₽)</label>
            <input type="number" name="price" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Период</label>
            <input type="text" name="period" class="form-input" value="месяц" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Преимущества (каждое с новой строки)</label>
            <textarea name="features_text" class="form-textarea" rows="5" placeholder="Тренажерный зал&#10;Кардиозона&#10;Раздевалка"></textarea>
        </div>
        
        
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="0">
        </div>
        <input type="hidden" name="features" id="featuresInput">
        <button type="submit" class="btn-submit">Сохранить</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('tariffForm').addEventListener('submit', function(e) {
    const featuresText = document.querySelector('textarea[name="features_text"]').value;
    const features = featuresText.split('\n').filter(f => f.trim());
    const featuresInput = document.createElement('input');
    featuresInput.type = 'hidden';
    featuresInput.name = 'features';
    featuresInput.value = JSON.stringify(features);
    this.appendChild(featuresInput);
});
</script>
@endpush





