@extends('layouts.app')

@section('title', 'Управление тарифами')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/tariffs/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Управление тарифами</h1>
        <a href="{{ route('admin.tariffs.create') }}" class="btn-add">+ Добавить тариф</a>
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
                    <th>Цена</th>
                    <th>Период</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tariffs as $tariff)
                <tr>
                    <td>{{ $tariff->id }}</td>
                    <td>{{ $tariff->name }}</td>
                    <td>{{ number_format($tariff->price, 0, '', ' ') }} ₽</td>
                    <td>{{ $tariff->period }}</td>
                    <td>
                        <span class="{{ $tariff->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $tariff->is_active ? 'Активен' : 'Неактивен' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.tariffs.edit', $tariff->id) }}" class="btn-edit">Редактировать</a>
                        <form action="{{ route('admin.tariffs.destroy', $tariff->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить тариф?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center-inline">Тарифы не найдены</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection





