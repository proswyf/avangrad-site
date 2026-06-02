@extends('layouts.app')

@section('title', 'Вопросы и ответы')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/faq.css') }}">
@endpush

@section('content')

    {{-- ══════════════════════════════════════════
    HERO
    ══════════════════════════════════════════ --}}
    <div class="fq-hero">
        <div class="fq-hero-grid" aria-hidden="true"></div>
        <div class="fq-hero-glow" aria-hidden="true"></div>
        <div class="fq-hero-inner">
            <div class="fq-label">Поддержка</div>
            <h1 class="fq-heading">Вопросы и ответы</h1>
            <p class="fq-subtext">Ответы на самые популярные вопросы — быстро и по делу.</p>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
    CONTENT — two-column layout
    ══════════════════════════════════════════ --}}
    <div class="fq-section">
        <div class="fq-inner">
            <div class="fq-layout">

                {{-- LEFT — accordion list --}}
                <div class="fq-accordion-col">
                    @php
                        $categoryTranslations = [
                            'general' => 'Общие вопросы',
                            'membership' => 'Абонементы',
                            'trainers' => 'Тренеры',
                            'pool' => 'Бассейн',
                            'spa' => 'СПА-зона',
                            'payments' => 'Оплата',
                            'schedule' => 'Расписание',
                            'children' => 'Детские программы',
                            'club' => 'Клуб',

                        ];
                    @endphp
                    @forelse($faqsByCategory as $category => $faqs)

                        {{-- Category header (shown only if multiple categories) --}}
                        @if(count($faqsByCategory) > 1)
                            <div class="fq-category">
                                {{ $categoryTranslations[$category] ?? $category }}
                            </div>
                        @endif

                        <div class="fq-group">
                            @foreach($faqs as $index => $faq)
                                <div class="faq-item reveal-card" data-index="{{ $index }}">
                                    <button class="faq-question" aria-expanded="false" onclick="toggleFaq(this)">
                                        <span class="faq-q-text">{{ $faq->question }}</span>
                                        <span class="faq-chevron" aria-hidden="true">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="faq-answer" role="region">
                                        <div class="faq-answer-inner">{{ $faq->answer }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @empty
                        <div class="fq-empty">Вопросы временно недоступны</div>
                    @endforelse
                </div>

                {{-- RIGHT — sticky contact card --}}
                <aside class="fq-aside">
                    <div class="fq-contact-card">
                        <div class="fq-contact-icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <path d="M4 4h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                                    stroke="currentColor" stroke-width="1.4" />
                                <path d="M2 6l9 7 9-7" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="fq-contact-heading">Остались вопросы?</div>
                        <p class="fq-contact-sub">Свяжитесь с нами — ответим в течение дня.</p>

                        <div class="fq-contact-list">
                            <a href="tel:+79991234567" class="fq-contact-item">
                                <div class="fq-contact-item-icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2 2h3l1.5 3.5L5 7a9 9 0 0 0 2 2l1.5-1.5L12 9v3c-5.5 0-10-4.5-10-10Z"
                                            stroke="currentColor" stroke-width="1.2" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="fq-contact-item-label">Телефон</div>
                                    <div class="fq-contact-item-value">+7 (999) 123-45-67</div>
                                </div>
                            </a>
                            <a href="mailto:info@fitclub.ru" class="fq-contact-item">
                                <div class="fq-contact-item-icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <rect x="1" y="3" width="12" height="8" rx="1.5" stroke="currentColor"
                                            stroke-width="1.2" />
                                        <path d="M1 4l6 4 6-4" stroke="currentColor" stroke-width="1.2" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="fq-contact-item-label">Email</div>
                                    <div class="fq-contact-item-value">info@fitclub.ru</div>
                                </div>
                            </a>
                            <div class="fq-contact-item fq-contact-item--static">
                                <div class="fq-contact-item-icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path
                                            d="M7 1a4.5 4.5 0 0 1 4.5 4.5C11.5 9 7 13 7 13S2.5 9 2.5 5.5A4.5 4.5 0 0 1 7 1Z"
                                            stroke="currentColor" stroke-width="1.2" />
                                        <circle cx="7" cy="5.5" r="1.5" stroke="currentColor" stroke-width="1.2" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="fq-contact-item-label">Адрес</div>
                                    <div class="fq-contact-item-value">ул. Труда, 181, ТРЦ «Авангард»</div>
                                </div>
                            </div>
                        </div>

                        <div class="fq-contact-hours">
                            <span class="fq-hours-dot" aria-hidden="true"></span>
                            Ежедневно 6:00 — 24:00
                        </div>
                    </div>


                </aside>

            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        (function () {
            /* ── Accordion ── */
            window.toggleFaq = function (btn) {
                const item = btn.closest('.faq-item');
                const answer = item.querySelector('.faq-answer');
                const isOpen = item.classList.contains('open');

                /* Close all others */
                document.querySelectorAll('.faq-item.open').forEach(el => {
                    el.classList.remove('open');
                    el.querySelector('.faq-answer').style.maxHeight = '0';
                    el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
                });

                if (!isOpen) {
                    item.classList.add('open');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    btn.setAttribute('aria-expanded', 'true');
                }
            };

            /* ── Stagger reveal ── */
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    const siblings = Array.from(e.target.parentElement.querySelectorAll('.reveal-card'));
                    const idx = siblings.indexOf(e.target);
                    setTimeout(() => e.target.classList.add('visible'), idx * 55);
                    obs.unobserve(e.target);
                });
            }, { threshold: 0.04 });
            document.querySelectorAll('.reveal-card').forEach(el => obs.observe(el));
        })();
    </script>
@endpush

