@extends('layouts.app')

@section('title', $trainer->name)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/trainer-profile.css') }}">
@endpush

@section('content')

{{-- ================= HERO BANNER ================= --}}
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
                <div class="hero-meta-value">★ {{ $trainer->rating ?? 5.0 }}</div>
            </div>
            <div class="hero-meta-item">
                <div class="hero-meta-label">Ставка</div>
                <div class="hero-meta-value">{{ $trainer->price }}2000₽ / занятие</div>
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

{{-- ================= MAIN CONTENT (TWO-COLUMN GRID) ================= --}}
<section class="section-wrap">
    <div class="section-inner">
        <div class="content-grid">
            
            {{-- Левая колонка: Информационные блоки --}}
            <div class="feat-group">
                
                {{-- О тренере --}}
                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">О тренере</div>
                    </div>
                    <div class="tp-block-body">
                        <p>{{ $trainer->bio ?? 'Информация пока не добавлена.' }}</p>
                    </div>
                </div>

                {{-- Методика работы --}}
                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">Методика работы</div>
                    </div>
                    <div class="tp-block-body">
                        <p>{{ $trainer->methodology ?? 'Индивидуальный подход и прогрессивная нагрузка.' }}</p>
                    </div>
                </div>

                {{-- Специализация --}}
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

                {{-- Достижения --}}
                @if($trainer->achievements)
                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">Достижения</div>
                    </div>
                    <ul class="feat-list">
                        @foreach(explode(',', $trainer->achievements) as $a)
                            @if(trim($a))
                                <li>{{ trim($a) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Сертификаты --}}
                @if($trainer->certificates)
                <div class="feat-block">
                    <div class="feat-block-head">
                        <div class="feat-block-title">Сертификаты и образование</div>
                    </div>
                    <ul class="feat-list">
                        @foreach(explode(',', $trainer->certificates) as $c)
                            @if(trim($c))
                                <li>{{ trim($c) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>

            {{-- Правая колонка: Закрепленная карточка --}}
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

{{-- ================= REVIEWS SECTION ================= --}}
@if($reviews->count())
<div class="section-rule"></div>
<section class="section-wrap alt">
    <div class="section-inner">
        
        <div class="section-head">
            <div class="section-head-left">
                <span class="label">Отзывы</span>
                <h2 class="heading-xl">Что говорят клиенты</h2>
            </div>
        </div>

        <div class="tp-reviews-grid">
            @foreach($reviews as $review)
                <div class="tp-review-card">
                    <div class="tp-review-head">
                        <span class="tp-review-author">{{ $review->name }}</span>
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

    </div>
</section>
@endif

{{-- ================= CTA BANNER ================= --}}
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