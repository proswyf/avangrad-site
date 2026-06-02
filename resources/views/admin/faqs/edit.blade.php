@extends('layouts.app')

@section('title', 'Редактировать вопрос')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faqs/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.faqs.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать вопрос</h1>
    
    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Вопрос</label>
            <input type="text" name="question" class="form-input" value="{{ $faq->question }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Ответ</label>
            <textarea name="answer" class="form-textarea" rows="5" required>{{ $faq->answer }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Категория</label>
            <select name="category" class="form-select" required>
                <option value="general" {{ $faq->category == 'general' ? 'selected' : '' }}>Общие вопросы</option>
                <option value="club" {{ $faq->category == 'club' ? 'selected' : '' }}>О клубе и услугах</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="{{ $faq->sort_order }}">
        </div>
        
        <div class="form-checkbox">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}>
            <label for="is_active">Активен</label>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить изменения</button>
    </form>
</div>
@endsection




