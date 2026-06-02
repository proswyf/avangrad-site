@extends('layouts.app')

@section('title', 'Тарифы')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/tariffs.css') }}">
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     PAGE HERO — тёмный, как секция тарифов на главной
══════════════════════════════════════════ --}}
<div class="tp-hero">
    <div class="tp-hero-inner">
        <div class="tp-label">Стоимость</div>
        <h1 class="tp-heading">Наши тарифы</h1>
        <p class="tp-subtext">Выберите подходящий формат — от разовых визитов до безлимитного абонемента.</p>
    </div>

    {{-- Декоративная dot-сетка --}}
    <div class="tp-hero-grid" aria-hidden="true"></div>
    {{-- Ambient glow --}}
    <div class="tp-hero-glow" aria-hidden="true"></div>
</div>


{{-- ══════════════════════════════════════════
     CARDS GRID
══════════════════════════════════════════ --}}
<div class="tp-cards-wrap">
    <div class="tp-cards-inner">
        <div class="tp-grid">
            @forelse($tariffs as $tariff)
            <div class="tariff-card {{ $tariff->is_popular ? 'popular' : '' }} reveal-card">
                <div class="card-glow"></div>

                <div class="tariff-name">{{ $tariff->name }}</div>

                <div class="tariff-price">
                    {{ number_format($tariff->price, 0, '', ' ') }}<sub> ₽</sub>
                </div>
                <div class="tariff-period">в {{ $tariff->period }}</div>

                <div class="tariff-features">
                    @php
                        $features = is_array($tariff->features)
                            ? $tariff->features
                            : json_decode($tariff->features, true);
                    @endphp
                    @foreach($features as $feature)
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <div>{{ $feature }}</div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('register') }}" class="tariff-btn">Выбрать тариф</a>
            </div>
            @empty
            <div class="tp-empty">Тарифы временно недоступны</div>
            @endforelse
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     FAQ STRIP — короткий блок с вопросами
══════════════════════════════════════════ --}}
<div class="tp-faq-wrap">
    <div class="tp-faq-inner">
        <div class="tp-faq-label">Часто спрашивают</div>

        <div class="tp-faq-grid">
            <div class="tp-faq-item">
                <div class="tp-faq-q">Можно ли заморозить абонемент?</div>
                <div class="tp-faq-a">Да, заморозка доступна от 7 дней. Оформляется в личном кабинете или на стойке администратора.</div>
            </div>
            <div class="tp-faq-item">
                <div class="tp-faq-q">Есть ли пробное занятие?</div>
                <div class="tp-faq-a">Первое посещение тренажёрного зала — бесплатно при регистрации на сайте.</div>
            </div>
            <div class="tp-faq-item">
                <div class="tp-faq-q">Как оплатить абонемент?</div>
                <div class="tp-faq-a">Картой, наличными или через личный кабинет онлайн — любым удобным способом.</div>
            </div>
            <div class="tp-faq-item">
                <div class="tp-faq-q">Включён ли бассейн в тариф?</div>
                <div class="tp-faq-a">Бассейн и СПА входят в тарифы «Комплекс» и «Безлимит». В остальных — за отдельную доплату.</div>
            </div>
        </div>

        <div class="tp-faq-cta">
            <a href="{{ route('faq') }}" class="tp-faq-link">
                Все вопросы и ответы
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
(function () {
    /* Staggered card reveal */
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

    /* Card glow follow cursor */
    document.querySelectorAll('.tariff-card').forEach(card => {
        const glow = card.querySelector('.card-glow');
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            if (glow) {
                glow.style.left = (e.clientX - r.left) + 'px';
                glow.style.top  = (e.clientY - r.top)  + 'px';
            }
        });
    });
})();
</script>
@endpush

