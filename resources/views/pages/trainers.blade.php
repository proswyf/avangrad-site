@extends('layouts.app')

@section('title', 'Тренеры')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/trainers.css') }}">
@endpush

@section('content')

    {{-- ══════════════════════════════════════════
    PAGE HERO
    ══════════════════════════════════════════ --}}
    <div class="tr-hero">
        <div class="tr-hero-grid" aria-hidden="true"></div>
        <div class="tr-hero-glow" aria-hidden="true"></div>
        <div class="tr-hero-inner">
            <div class="tr-label">Команда</div>
            <h1 class="tr-heading">Наши тренеры</h1>
            <p class="tr-subtext">Профессионалы своего дела — помогут выстроить программу, прийти к цели и удержать
                результат.</p>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
    TRAINERS GRID
    ══════════════════════════════════════════ --}}
    <div class="tr-section">
        <div class="tr-inner">
            <div class="tr-grid">
                @forelse($trainers as $trainer)
                    <div class="trainer-card reveal-card">
                        <div class="trainer-photo">
                            <img src="{{ $trainer->image_url }}" alt="{{ $trainer->name }}">
                            <div class="trainer-photo-overlay" aria-hidden="true"></div>
                            <div class="trainer-topline">
                                <div class="trainer-rating-badge">
                                    @if(($trainer->approved_reviews_count ?? 0) > 0)
                                        <span class="trainer-rating-star">★</span>
                                        <span>{{ number_format((float) $trainer->approved_rating, 1) }}</span>
                                        <span class="trainer-rating-count">· {{ $trainer->approved_reviews_count }} отзыв(ов)</span>
                                    @else
                                        <span>Новый тренер</span>
                                    @endif
                                </div>

                                @if(!is_null($trainer->price))
                                    <div class="trainer-price-badge">{{ number_format((float) $trainer->price, 0, '', ' ') }} ₽</div>
                                @endif
                            </div>

                            <div class="trainer-exp-badge">
                                <span class="trainer-exp-num">{{ $trainer->experience }}</span>
                                <span class="trainer-exp-lbl">лет<br>опыта</span>
                            </div>
                        </div>

                        <div class="trainer-body">
                            <div class="trainer-head">
                                <div class="trainer-name">{{ $trainer->name }}</div>
                                <div class="trainer-role">{{ $trainer->position }}</div>
                            </div>

                            <div class="trainer-tags">
                                @foreach(collect(explode(',', (string) $trainer->specialization))->map(fn ($item) => trim($item))->filter()->take(3) as $tag)
                                    <span class="trainer-tag">{{ $tag }}</span>
                                @endforeach
                                @if($trainer->certificates)
                                    <span class="trainer-tag trainer-tag--accent">Сертификаты</span>
                                @endif
                            </div>

                            @if($trainer->bio)
                                <p class="trainer-summary">{{ \Illuminate\Support\Str::limit($trainer->bio, 120) }}</p>
                            @endif

                            @if($trainer->quote)
                                <blockquote class="trainer-quote">"{{ $trainer->quote }}"</blockquote>
                            @endif

                            <div class="trainer-action">
                                <a href="{{ route('trainer.profile', $trainer->id) }}" class="trainer-link">
                                    Подробнее о тренере
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                @auth
                                    <a href="{{ route('book-trainer.form', $trainer->id) }}" class="trainer-btn">
                                        Записаться на тренировку
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                            <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="trainer-btn trainer-btn--ghost">
                                        Войти для записи
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                            <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="tr-empty">Тренеры временно недоступны</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        (function () {
            /* Staggered reveal */
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    const siblings = Array.from(e.target.parentElement.querySelectorAll('.reveal-card'));
                    const idx = siblings.indexOf(e.target);
                    setTimeout(() => e.target.classList.add('visible'), idx * 80);
                    obs.unobserve(e.target);
                });
            }, { threshold: 0.06 });
            document.querySelectorAll('.reveal-card').forEach(el => obs.observe(el));

            /* Subtle tilt on hover */
            document.querySelectorAll('.trainer-card').forEach(card => {
                card.addEventListener('mousemove', e => {
                    const r = card.getBoundingClientRect();
                    const tx = ((e.clientX - r.left) / r.width - .5) * 4;
                    const ty = ((e.clientY - r.top) / r.height - .5) * 4;
                    card.style.transform = `translateY(-5px) rotateX(${-ty}deg) rotateY(${tx}deg)`;
                    card.style.transition = 'transform .08s ease, box-shadow .2s ease, border-color .2s ease';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                    card.style.transition = 'transform .35s cubic-bezier(.25,.46,.45,.94), box-shadow .25s ease, border-color .25s ease, opacity .65s ease, translate .65s ease';
                });
            });
        })();
    </script>
@endpush
