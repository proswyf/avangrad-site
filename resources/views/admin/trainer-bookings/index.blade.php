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
                </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                    <td><strong>{{ $booking->user->name }}</strong><br><small>{{ $booking->user->email }}</small></td>
                    <td>{{ $booking->trainer_name }}</td>
                    <td>
                        <strong>{{ $booking->booking_date_label ?? '—' }}</strong><br>
                        <small>{{ $booking->booking_weekday_label ?? '—' }}{{ $booking->booking_time_label ? ', ' . $booking->booking_time_label : '' }}</small>
                    </td>
                    <td>{{ $booking->phone }}</td>
                    <td>
                        <span class="status-badge status-{{ $booking->status }}">
                            {{ $booking->status === 'pending' ? 'Ожидает' : ($booking->status === 'confirmed' ? 'Подтверждена' : ($booking->status === 'cancelled' ? 'Отменена' : 'Завершена')) }}
                        </span>
                    </td>
                    <td>
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







