@extends('layouts.app')

@section('title', 'Управление тренерами')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/trainers/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Управление тренерами</h1>
        <a href="{{ route('admin.trainers.create') }}" class="btn-add">+ Добавить тренера</a>
    </div>
    
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-auto-x">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Имя</th>
                    <th>Должность</th>
                    <th>Опыт</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </thead>
            <tbody>
                @forelse($trainers as $trainer)
                <tr>
                    <td>{{ $trainer->id }}</td>
                    <td>
                        @if($trainer->image_url)
                            <img src="{{ $trainer->image_url }}" class="image-thumb-round" alt="{{ $trainer->name }}">
                        @else
                            <span class="text-muted-light">нет фото</span>
                        @endif
                    </td>
                    <td><strong>{{ $trainer->name }}</strong></td>
                    <td>{{ $trainer->position }}</td>
                    <td>{{ $trainer->experience }} лет</td>
                    <td>
                        <span class="{{ $trainer->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $trainer->is_active ? 'Активен' : 'Неактивен' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="btn-edit">Редактировать</a>
                        <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить тренера?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center-inline">Тренеры не найдены</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection








