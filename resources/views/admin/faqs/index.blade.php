@extends('layouts.app')

@section('title', 'Управление вопросами и ответами')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faqs/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Управление вопросами и ответами</h1>
        <a href="{{ route('admin.faqs.create') }}" class="btn-add">+ Добавить вопрос</a>
    </div>
    
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-auto-x">
        <table class="admin-table">
            <thead>
                 <tr>
                    <th>ID</th>
                    <th>Вопрос</th>
                    <th>Ответ</th>
                    <th>Категория</th>
                    <th>Порядок</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td>{{ $faq->id }}</td>
                    <td class="question-text" title="{{ $faq->question }}">{{ $faq->question }}</td>
                    <td class="answer-text" title="{{ $faq->answer }}">{{ Str::limit($faq->answer, 80) }}</td>
                    <td>
                        <span class="badge-{{ $faq->category }}">
                            {{ $faq->category == 'general' ? 'Общие' : ($faq->category == 'club' ? 'Клуб' : $faq->category) }}
                        </span>
                    </td>
                    <td>{{ $faq->sort_order }}</td>
                    <td>
                        <span class="{{ $faq->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $faq->is_active ? 'Активен' : 'Неактивен' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn-edit">Редактировать</a>
                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить вопрос?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center-inline">Вопросы не найдены</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection





