@extends('layouts.app')

@section('title', $trainer->name)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/trainer-profile.css') }}">
@endpush

@section('content')

<section class="hero-banner">
    <div class="hero-image">
        <img src="{{ $trainer->image_url }}" alt="{{ $trainer->name }}">
    </div>

    <div class="hero-content visible">
        <a href="{{ route('trainers') }}" class="hero-eyebrow">← Все тренеры</a>

        <h1 class="hero-title">
            <span>{{ $trainer->position }}</span>
            {{ $trainer->name }}
        </h1>

        <div class="hero-meta">
            <div class="hero-meta-item">
                <div class="hero-meta-label">Рейтинг</div>
                <div class="hero-meta-value">
                    @if($trainer->approved_reviews_count)
                        ★ {{ number_format((float) $trainer->approved_rating, 1) }} · {{ $trainer->approved_reviews_count }} отзыв(ов)
                    @else
                        Отзывов пока нет
                    @endif
                </div>
            </div>
            <div class="hero-meta-item">
                <div class="hero-meta-label">Стоимость</div>
                <div class="hero-meta-value">
                    {{ $trainer->price ? $trainer->price . '₽ / занятие' : 'Цена уточняется' }}
                </div>
            </div>
            @if($trainer->quote)
                <div class="hero-meta-item">
                    <div class="hero-meta-label">Кредо</div>
                    <div class="hero-meta-value">«{{ $trainer->quote }}»</div>
                </div>
            @endif
        </div>

        <div class="hero-buttons">
            @auth
                <a href="{{ route('book-trainer.form', $trainer->id) }}" class="btn-solid">
                    Записаться на тренировку <span class="btn-arrow">→</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">
                    Войти для записи <span class="btn-arrow">→</span>
                </a>
            @endauth
        </div>
    </div>

    <div class="hero-scroll">
        <div class="hero-scroll-line"></div>
        <div class="hero-scroll-label">Листать вниз</div>
    </div>
</section>

<div class="section-rule"></div>

<section class="section-wrap">
    <div class="section-inner">
        <div class="content-grid">
            <div class="feat-group">
                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">О тренере</div>
                    </div>
                    <div class="tp-block-body">
                        <p>{{ $trainer->bio ?? 'Информация пока не добавлена.' }}</p>
                    </div>
                </div>

                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">Методика работы</div>
                    </div>
                    <div class="tp-block-body">
                        <p>{{ $trainer->methodology ?? 'Индивидуальный подход и прогрессивная нагрузка.' }}</p>
                    </div>
                </div>

                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">Специализация</div>
                    </div>
                    <div class="tp-block-body">
                        <div class="feat-tags">
                            @foreach(explode(',', $trainer->specialization ?? '') as $tag)
                                @if(trim($tag))
                                    <span class="feat-tag">{{ trim($tag) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                @if($trainer->achievements)
                    <div class="feat-block">
                        <div class="feat-block-head">
                            <div class="feat-block-title">Достижения</div>
                        </div>
                        <ul class="feat-list">
                            @foreach(explode(',', $trainer->achievements) as $achievement)
                                @if(trim($achievement))
                                    <li>{{ trim($achievement) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($trainer->certificates)
                    <div class="feat-block">
                        <div class="feat-block-head">
                            <div class="feat-block-title">Сертификаты и образование</div>
                        </div>
                        <ul class="feat-list">
                            @foreach(explode(',', $trainer->certificates) as $certificate)
                                @if(trim($certificate))
                                    <li>{{ trim($certificate) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="media-col-wrap">
                <div class="media-col">
                    <img src="{{ $trainer->image_url }}" alt="{{ $trainer->name }}">

                    <div class="media-stats">
                        <div class="media-stat">
                            <div class="media-stat-val">{{ $trainer->experience }}</div>
                            <div class="media-stat-lbl">лет опыта</div>
                        </div>
                        <div class="media-stat">
                            <div class="media-stat-val">{{ $trainer->clients_count ?? 0 }}</div>
                            <div class="media-stat-lbl">клиентов</div>
                        </div>
                        <div class="media-stat">
                            <div class="media-stat-val">{{ $trainer->sessions_count ?? 0 }}</div>
                            <div class="media-stat-lbl">тренировок</div>
                        </div>
                    </div>
                </div>

                @if($trainer->training_format)
                    <div class="tp-format-card">
                        <span class="tp-format-label">Формат тренировок</span>
                        <span class="tp-format-val">{{ $trainer->training_format }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="section-rule"></div>

<section class="section-wrap alt">
    <div class="section-inner">
        <div class="section-head">
            <div class="section-head-left">
                <span class="label">Отзывы</span>
                <h2 class="heading-xl">Что говорят клиенты</h2>
                <p class="subtext tp-subtext">Все отзывы публикуются только после проверки администратором.</p>
            </div>
        </div>

        <div class="tp-review-layout">
            <div class="tp-review-form-card">
                <div class="tp-review-form-head">
                    <h3>Оставить отзыв</h3>
                    <p>Поделитесь впечатлением о тренировках с {{ $trainer->name }}.</p>
                </div>

                @auth
                    @if($userReview && $userReview->status === 'pending')
                        <div class="tp-review-state tp-review-state--pending">
                            Ваш отзыв уже отправлен и ожидает модерации.
                        </div>
                    @elseif($userReview && $userReview->status === 'approved')
                        <div class="tp-review-state tp-review-state--approved">
                            Ваш отзыв уже опубликован. Спасибо за обратную связь.
                        </div>
                    @else
                        @if($userReview && $userReview->status === 'rejected')
                            <div class="tp-review-state tp-review-state--rejected">
                                Предыдущий отзыв был отклонен.
                                @if($userReview->moderation_note)
                                    Причина: {{ $userReview->moderation_note }}
                                @endif
                            </div>
                        @endif

                        <form method="POST" action="{{ route('trainer.reviews.store', $trainer->id) }}" class="tp-review-form">
                            @csrf

                            <div class="tp-form-group">
                                <label for="rating">Оценка</label>
                                <select id="rating" name="rating" class="tp-form-control" required>
                                    <option value="">Выберите оценку</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" @selected((int) old('rating') === $i)>{{ $i }} из 5</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="tp-form-group">
                                <label for="text">Отзыв</label>
                                <textarea
                                    id="text"
                                    name="text"
                                    class="tp-form-control tp-form-control--textarea"
                                    rows="6"
                                    minlength="20"
                                    maxlength="1500"
                                    placeholder="Расскажите, что вам понравилось на тренировках, каких результатов удалось добиться и чем запомнился тренер."
                                    required
                                >{{ old('text') }}</textarea>
                            </div>

                            <button type="submit" class="tp-review-submit">Отправить на модерацию</button>
                        </form>
                    @endif
                @else
                    <div class="tp-review-state">
                        Чтобы оставить отзыв, войдите в аккаунт.
                    </div>
                    <a href="{{ route('login') }}" class="tp-review-login">Войти</a>
                @endauth
            </div>

            <div class="tp-review-list">
                @if($reviews->count())
                    <div class="tp-reviews-grid">
                        @foreach($reviews as $review)
                            <div class="tp-review-card">
                                <div class="tp-review-head">
                                    <div class="tp-review-author-wrap">
                                        <span class="tp-review-author">{{ $review->name }}</span>
                                        <span class="tp-review-date">{{ $review->created_at->format('d.m.Y') }}</span>
                                    </div>
                                    <span class="tp-review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= $review->rating ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                </div>
                                <p class="tp-review-text">{{ $review->text }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="tp-review-empty">
                        Пока нет опубликованных отзывов. Станьте первым, кто поделится впечатлением.
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="tariffs-wrap">
    <div class="tariffs-inner">
        <div class="tariffs-head">
            <span class="label">Запись на занятие</span>
            <h2 class="heading-xl">Готовы начать тренировки?</h2>
            <p class="subtext">Выберите удобное время и сделайте первый шаг к результату под руководством эксперта.</p>

            <div class="tp-cta-action">
                @auth
                    <a href="{{ route('book-trainer.form', $trainer->id) }}" class="tariff-btn">
                        Записаться к тренеру
                    </a>
                @else
                    <a href="{{ route('login') }}" class="tariff-btn">
                        Войти и записаться
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection
