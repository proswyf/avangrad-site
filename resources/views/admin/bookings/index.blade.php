@extends('layouts.app')

@section('title', 'Записи на тренировки')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/bookings/index.css') }}">
@endpush

@section('content')

    <div class="admin-container">
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
            <a href="{{ route('admin.bookings.create') }}" class="btn-add">+ Добавить запись</a>
        </div>


        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

       

        <div class="overflow-auto-x">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата записи</th>
                        <th>Пользователь</th>
                        <th>Email</th>
                        <th>Занятие</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="{{ $booking->created_at->diffInHours(now()) < 24 ? 'new-booking' : '' }}">
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                            <td><strong>{{ $booking->user->name }}</strong></td>
                            <td>{{ $booking->user->email }}</td>
                            <td>{{ $booking->class_name }}</td>
                            <td>
                                <span class="badge-{{ $booking->status }}">
                                    {{ $booking->status === 'active' ? 'Активна' : ($booking->status === 'cancelled' ? 'Отменена' : 'Завершена') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn-view">Просмотр</a>
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn-edit">Редактировать</a>
                                <form action="{{ route('admin.bookings.delete', $booking->id) }}" method="POST"
                                    class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"
                                        onclick="return confirm('Удалить запись?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center-inline">Записей пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>
@endsection


