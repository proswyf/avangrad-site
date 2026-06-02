@extends('layouts.app')

@section('title', 'Отзывы о клубе')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/club-reviews/index.css') }}">
@endpush

@section('content')

<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад к админ-панели</a>
        <h1>Отзывы о клубе</h1>
    </div>

    <div class="review-filter-row">
        <a href="{{ route('admin.club-reviews.index', ['status' => 'pending']) }}" class="review-filter-chip {{ $status === 'pending' ? 'is-active' : '' }}">
            На модерации <span>{{ $stats['pending'] }}</span>
        </a>
        <a href="{{ route('admin.club-reviews.index', ['status' => 'approved']) }}" class="review-filter-chip {{ $status === 'approved' ? 'is-active' : '' }}">
            Одобрены <span>{{ $stats['approved'] }}</span>
        </a>
        <a href="{{ route('admin.club-reviews.index', ['status' => 'rejected']) }}" class="review-filter-chip {{ $status === 'rejected' ? 'is-active' : '' }}">
            Отклонены <span>{{ $stats['rejected'] }}</span>
        </a>
        <a href="{{ route('admin.club-reviews.index', ['status' => 'all']) }}" class="review-filter-chip {{ $status === 'all' ? 'is-active' : '' }}">
            Все <span>{{ $stats['all'] }}</span>
        </a>
    </div>

    <div class="review-admin-list">
        @forelse($reviews as $review)
            <article class="review-admin-card">
                <div class="review-admin-head">
                    <div class="review-admin-main">
                        <div class="review-admin-trainer">Отзыв о клубе</div>
                        <div class="review-admin-author">
                            {{ $review->name }}
                            @if($review->user?->email)
                                <span>{{ $review->user->email }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="review-admin-side">
                        <span class="status-badge status-{{ $review->status }}">
                            {{ $review->status === 'pending' ? 'Ожидает' : ($review->status === 'approved' ? 'Одобрен' : 'Отклонен') }}
                        </span>
                        <div class="review-admin-date">{{ $review->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                </div>

                <div class="review-admin-rating">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                </div>

                <p class="review-admin-text">{{ $review->text }}</p>

                @if($review->moderation_note)
                    <div class="review-admin-note">
                        <strong>Комментарий модератора:</strong> {{ $review->moderation_note }}
                    </div>
                @endif

                <form action="{{ route('admin.club-reviews.update', ['id' => $review->id, 'status' => $status]) }}" method="POST" class="review-admin-form">
                    @csrf
                    @method('PUT')

                    <div class="review-admin-form-grid">
                        <div class="review-admin-field">
                            <label for="status-{{ $review->id }}">Статус</label>
                            <select id="status-{{ $review->id }}" name="status" class="form-select">
                                <option value="pending" @selected($review->status === 'pending')>Ожидает</option>
                                <option value="approved" @selected($review->status === 'approved')>Одобрен</option>
                                <option value="rejected" @selected($review->status === 'rejected')>Отклонен</option>
                            </select>
                        </div>

                        <div class="review-admin-field review-admin-field--wide">
                            <label for="note-{{ $review->id }}">Комментарий модератора</label>
                            <textarea id="note-{{ $review->id }}" name="moderation_note" rows="3" class="form-textarea" placeholder="Необязательно">{{ old('moderation_note', $review->moderation_note) }}</textarea>
                        </div>
                    </div>

                    <div class="review-admin-actions">
                        <button type="submit" class="btn-edit">Сохранить</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="review-admin-empty">
                По выбранному фильтру отзывов пока нет.
            </div>
        @endforelse
    </div>

    <div class="pagination pagination-spaced">
        {{ $reviews->links() }}
    </div>
</div>

@endsection
