@extends('layouts.app')

@section('title', 'Добавить вопрос')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faqs/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.faqs.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить вопрос</h1>
    
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Вопрос</label>
            <input type="text" name="question" class="form-input" placeholder="Как начать заниматься?" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Ответ</label>
            <textarea name="answer" class="form-textarea" rows="5" placeholder="Подробный ответ на вопрос..." required></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Категория</label>
            <select name="category" class="form-select" required>
                <option value="general">Общие вопросы</option>
                <option value="club">О клубе и услугах</option>
            </select>
            <div class="hint">Общие вопросы отображаются первыми, вопросы о клубе - после</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-input" value="0">
            <div class="hint">Меньше число = выше в списке</div>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить</button>
    </form>
</div>
@endsection




