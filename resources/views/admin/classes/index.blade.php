@extends('layouts.app')

@section('title', 'Управление групповыми занятиями')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/classes/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Управление групповыми занятиями</h1>
        <a href="{{ route('admin.classes.create') }}" class="btn-add">+ Добавить занятие</a>
    </div>
    
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-auto-x">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Инструктор</th>
                    <th>Длительность</th>
                    <th>Расписание</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                <tr>
                    <td>{{ $class->id }}</td>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->instructor }}</td>
                    <td>{{ $class->duration }} мин</td>
                    <td>{{ $class->schedule }}</td>
                    <td>
                        <span class="{{ $class->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $class->is_active ? 'Активно' : 'Неактивно' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn-edit">Редактировать</a>
                        <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить занятие?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center-inline">Занятия не найдены</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection





