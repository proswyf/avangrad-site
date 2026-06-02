@extends('layouts.app')

@section('title', 'Управление акциями')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/promotions/index.css') }}">
@endpush

@section('content')

<div class="admin-container">

    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Управление акциями</h1>
        <a href="{{ route('admin.promotions.create') }}" class="btn-add">+ Добавить акцию</a>
    </div>
    
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-auto-x">
        <table class="admin-table">
            <thead>
                <tr><th>ID</th><th>Название</th><th>Бейдж</th><th>Действует до</th><th>Статус</th><th>Действия</th></tr>
            </thead>
            <tbody>
                @forelse($promotions as $promo)
                <tr>
                    <td>{{ $promo->id }}</td>
                    <td>{{ $promo->title }}</td>
                    <td>{{ $promo->badge ?? '-' }}</td>
                    <td>{{ $promo->valid_to ? \Carbon\Carbon::parse($promo->valid_to)->format('d.m.Y') : '∞' }}</td>
                    <td><span class="{{ $promo->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $promo->is_active ? 'Активна' : 'Неактивна' }}</span></td>
                    <td>
                        <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn-edit">Редактировать</a>
                        <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="inline-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center-inline">Акции не найдены</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection






