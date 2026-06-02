@extends('layouts.app')

@section('title', 'Редактировать тариф')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/tariffs/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.tariffs.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать тариф</h1>
    
    <form action="{{ route('admin.tariffs.update', $tariff->id) }}" method="POST" id="tariffForm">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Название</label>
            <input type="text" name="name" class="form-input" value="{{ $tariff->name }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-input" value="{{ $tariff->slug }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Цена (₽)</label>
            <input type="number" name="price" class="form-input" value="{{ $tariff->price }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Период</label>
            <input type="text" name="period" class="form-input" value="{{ $tariff->period }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Преимущества (каждое с новой строки)</label>
            <textarea name="features_text" class="form-textarea" rows="5">@php 
                $features = is_array($tariff->features) ? $tariff->features : json_decode($tariff->features, true);
                echo implode("\n", $features ?? []);
            @endphp</textarea>
        </div>
        
      
        
        <div class="form-checkbox">
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $tariff->is_active ? 'checked' : '' }}>
    <label for="is_active">Активен</label>
</div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="{{ $tariff->sort_order }}">
        </div>
        <input type="hidden" name="features" id="featuresInput">
        <button type="submit" class="btn-submit">Сохранить изменения</button>
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





