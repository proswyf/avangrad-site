@extends('layouts.app')

@section('title', 'Редактировать занятие')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/classes/edit.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.classes.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Редактировать занятие</h1>
    
    <form action="{{ route('admin.classes.update', $class->id) }}" method="POST" id="classForm">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Название</label>
            <input type="text" name="name" class="form-input" value="{{ $class->name }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-input" value="{{ $class->slug }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-textarea" rows="4" required>{{ $class->description }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Изображение</label>
            <input type="text" name="image" class="form-input" value="{{ $class->image }}" placeholder="yoga.jpg">
            <div class="hint">public/images/classes</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Инструктор</label>
            <input type="text" name="instructor" class="form-input" value="{{ $class->instructor }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Длительность (минуты)</label>
            <input type="number" name="duration" class="form-input" value="{{ $class->duration }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Максимум человек</label>
            <input type="number" name="max_people" class="form-input" value="{{ $class->max_people }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Расписание</label>
            <input type="text" name="schedule" class="form-input" value="{{ $class->schedule }}" required>
            <div class="hint">Пример: ПН, СР, ПТ | 19:00 - 20:00</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Дни недели (через запятую)</label>
            <input type="text" name="days_text" class="form-input" value="{{ implode(', ', $class->days ?? []) }}">
            <div class="hint">Варианты: monday, tuesday, wednesday, thursday, friday, saturday, sunday</div>
        </div>
        
        <div class="form-checkbox">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $class->is_active ? 'checked' : '' }}>
            <label for="is_active">Активно</label>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить изменения</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('classForm').addEventListener('submit', function(e) {
    const daysText = document.querySelector('input[name="days_text"]').value;
    if (daysText) {
        const days = daysText.split(',').map(d => d.trim().toLowerCase());
        const daysInput = document.createElement('input');
        daysInput.type = 'hidden';
        daysInput.name = 'days';
        daysInput.value = JSON.stringify(days);
        this.appendChild(daysInput);
    }
});
</script>
@endpush






