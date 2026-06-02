@extends('layouts.app')

@section('title', 'Админ-панель')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')

<div class="admin-section">
    <div class="admin-container">
        <div class="admin-header">
            <h1>Админ-панель</h1>
            <p>Управление контентом сайта</p>
        </div>

        <div class="admin-menu">
            <a href="{{ route('admin.tariffs.index') }}" class="menu-card">
                <div class="menu-title">Тарифы</div>
                <div class="menu-desc">Управление тарифами</div>
            </a>

            <a href="{{ route('admin.promotions.index') }}" class="menu-card">
                <div class="menu-title">Акции</div>
                <div class="menu-desc">Управление акциями</div>
            </a>

            <a href="{{ route('admin.classes.index') }}" class="menu-card">
                <div class="menu-title">Групповые занятия</div>
                <div class="menu-desc">Управление занятиями</div>
            </a>

            <a href="{{ route('admin.trainers.index') }}" class="menu-card">
                <div class="menu-title">Тренеры</div>
                <div class="menu-desc">Управление тренерами</div>
            </a>

            <a href="{{ route('admin.faqs.index') }}" class="menu-card">
                <div class="menu-title">Вопросы и ответы</div>
                <div class="menu-desc">Управление FAQ</div>
            </a>

            <a href="{{ route('admin.users') }}" class="menu-card">
                <div class="menu-title">Пользователи</div>
                <div class="menu-desc">Управление пользователями</div>
            </a>

            <a href="{{ route('admin.bookings') }}" class="menu-card">
                <div class="menu-title">Записи на тренировки</div>
                <div class="menu-desc">Управление записями клиентов</div>
            </a>

            <a href="{{ route('admin.trainer-bookings') }}" class="menu-card">
                <div class="menu-title">Заявки к тренерам</div>
                <div class="menu-desc">Управление заявками на тренировки</div>
            </a>
        </div>
    </div>
    <br><br>
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['tariffs'] }}</div>
            <div class="stat-label">Тарифов</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['promotions'] }}</div>
            <div class="stat-label">Акций</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['classes'] }}</div>
            <div class="stat-label">Занятий</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['trainers'] }}</div>
            <div class="stat-label">Тренеров</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['faqs'] }}</div>
            <div class="stat-label">Вопросов</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['users'] }}</div>
            <div class="stat-label">Пользователей</div>
        </div>
    </div>

</div>
@endsection


