@extends('layouts.app')

@section('title', 'Добавить занятие')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/classes/create.css') }}">
@endpush

@section('content')

<div class="form-container">
    <a href="{{ route('admin.classes.index') }}" class="btn-back">← Назад к списку</a>
    <h1>Добавить групповое занятие</h1>
    
    <form action="{{ route('admin.classes.store') }}" method="POST" id="classForm" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Название</label>
            <input type="text" name="name" class="form-input" required>
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
            <label class="form-label">Изображение</label>
            <input type="file" name="image_file" class="form-input" accept=".jpg,.jpeg,.png,.webp,.gif">
            <div class="hint">Загрузите JPG, PNG, WEBP или GIF до 5 МБ</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Инструктор</label>
            <input type="text" name="instructor" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Длительность (минуты)</label>
            <input type="number" name="duration" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Максимум человек</label>
            <input type="number" name="max_people" class="form-input" value="15" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Расписание</label>
            <input type="text" name="schedule" class="form-input" placeholder="ПН, СР, ПТ | 19:00 - 20:00" required>
            <div class="hint">Пример: ПН, СР, ПТ | 19:00 - 20:00</div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Дни недели (через запятую)</label>
            <input type="text" name="days_text" class="form-input" placeholder="monday, wednesday, friday">
            <div class="hint">Варианты: monday, tuesday, wednesday, thursday, friday, saturday, sunday</div>
        </div>
        
        <button type="submit" class="btn-submit">Сохранить</button>
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






