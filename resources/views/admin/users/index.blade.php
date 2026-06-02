@extends('layouts.app')

@section('title', 'Управление пользователями')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Управление пользователями</h1>
        <a href="{{ route('admin.users.create') }}" class="btn-add">+ Добавить пользователя</a>
    </div>
    
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif
    
    <div class="overflow-auto-x">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Роль</th>
                    <th>Абонемент</th>
                    <th>Действует до</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        <span class="badge-{{ $user->role }}">
                            {{ $user->role == 'admin' ? 'Администратор' : 'Пользователь' }}
                        </span>
                    </td>
                    <td>{{ $user->tariff_id ?? '-' }}</td>
                    <td>
                        @if($user->tariff_expires_at)
                            @php
                                $isExpired = now()->gt($user->tariff_expires_at);
                            @endphp
                            <span class="{{ $isExpired ? 'badge-expired' : 'badge-active' }}">
                                {{ \Carbon\Carbon::parse($user->tariff_expires_at)->format('d.m.Y') }}
                                @if($isExpired) (просрочен) @endif
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $user->created_at ? $user->created_at->format('d.m.Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn-view">Просмотр</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">Редактировать</a>
                        @if($user->id != auth()->id())
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Удалить пользователя?')">Удалить</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center-inline">Пользователи не найдены</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection





