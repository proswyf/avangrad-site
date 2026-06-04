@extends('layouts.app')

@section('title', 'Заявки к тренерам')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/trainer-bookings/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Заявки на тренировки с тренерами</h1>
    </div>
    
    @if(session('success'))
        <div class="success-message success-message-accent">
            {{ session('success') }}
        </div>
    @endif
    
   
    
    <div class="overflow-auto-x">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата заявки</th>
                    <th>Клиент</th>
                    <th>Тренер</th>
                    <th>Дата тренировки</th>
                    <th>Телефон</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td data-label="ID">{{ $booking->id }}</td>
                    <td data-label="Дата заявки">{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                    <td data-label="Клиент"><strong>{{ $booking->user?->name ?? 'Клиент удален' }}</strong><br><small>{{ $booking->user?->email ?? 'Email недоступен' }}</small></td>
                    <td data-label="Тренер">{{ $booking->trainer_name }}</td>
                    <td data-label="Дата тренировки">
                        <strong>{{ $booking->booking_date_label ?? '—' }}</strong><br>
                        <small>{{ $booking->booking_weekday_label ?? '—' }}{{ $booking->booking_time_label ? ', ' . $booking->booking_time_label : '' }}</small>
                    </td>
                    <td data-label="Телефон">{{ $booking->phone ?: 'Не указан' }}</td>
                    <td data-label="Статус">
                        <span class="status-badge status-{{ $booking->status }}">
                            {{ $booking->status === 'pending' ? 'Ожидает' : ($booking->status === 'confirmed' ? 'Подтверждена' : ($booking->status === 'cancelled' ? 'Отменена' : 'Завершена')) }}
                        </span>
                    </td>
                    <td data-label="Действия">
                        <a href="{{ route('admin.trainer-bookings.show', $booking->id) }}" class="btn-view">Просмотр</a>
                        <form action="{{ route('admin.trainer-bookings.delete', $booking->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить заявку?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center-inline">Заявок пока нет</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="pagination pagination-spaced">
        {{ $bookings->links() }}
    </div>
</div>
@endsection







