@extends('layouts.app')

@section('title', 'Редактировать тренера')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/trainers/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.trainers.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать тренера</h1>
    
    <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-input" value="{{ $trainer->name }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-input" value="{{ $trainer->slug }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Должность</label>
            <input type="text" name="position" class="form-input" value="{{ $trainer->position }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Опыт (лет)</label>
            <input type="number" name="experience" class="form-input" value="{{ $trainer->experience }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Специализация</label>
            <input type="text" name="specialization" class="form-input" value="{{ $trainer->specialization }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Сертификаты</label>
            <input type="text" name="certificates" class="form-input" value="{{ $trainer->certificates }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Цитата</label>
            <textarea name="quote" class="form-textarea" rows="3">{{ $trainer->quote }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Изображение</label>
            <input type="text" name="image" class="form-input" value="{{ $trainer->image }}">
            <div class="hint">Фото должно лежать в папке public/images/trainers</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="{{ $trainer->sort_order }}">
        </div>
        
        <div class="form-checkbox">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $trainer->is_active ? 'checked' : '' }}>
            <label for="is_active">Активен</label>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить изменения</button>
    </form>
</div>
@endsection





