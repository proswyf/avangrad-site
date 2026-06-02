@extends('layouts.app')

@section('title', 'Главная')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endpush

@section('content')

  {{-- Кастомный курсор --}}
  <div id="cursor"></div>
  <div id="cursor-ring"></div>

  {{-- Floating particles canvas --}}
  <canvas id="particles-canvas"></canvas>

  {{-- Spotlight --}}
  <div class="spotlight-container">
    <div id="spotlight"></div>
  </div>


  {{-- ══════════════════════════════════════════
  HERO
  ══════════════════════════════════════════ --}}
<div class="hero-banner" id="hero">

  <div class="hero-image">
    <img src="{{ asset('images/registr.jpg') }}" alt="Авангард Челябинск">
  </div>

  <div class="hero-content visible">

    <div class="hero-eyebrow">
      Фитнес-клуб · Челябинск
    </div>

    <h1 class="hero-title">
      <span>Твой путь начинается</span>
      Авангард
    </h1>

    <div class="hero-meta">

      <div class="hero-meta-item">
        <span class="hero-meta-label">Режим работы</span>
        <span class="hero-meta-value">Ежедневно 6:00 — 24:00</span>
      </div>

      <div class="hero-meta-item">
        <span class="hero-meta-label">Адрес</span>
        <span class="hero-meta-value">
          ул. Труда, 181, ТРЦ «Авангард»
        </span>
      </div>

      <div class="hero-meta-item">
        <span class="hero-meta-label">Площадь</span>
        <span class="hero-meta-value">2 200 м²</span>
      </div>

    </div>

    <div class="hero-buttons">
      @auth
        <a href="{{ route('dashboard') }}" class="btn-ghost">
          Личный кабинет
          <span class="btn-arrow">→</span>
        </a>

        <a href="{{ route('choose-tariff') }}" class="btn-solid">
          Выбрать тариф
          <span class="btn-arrow">→</span>
        </a>
      @else
        <a href="{{ route('login') }}" class="btn-ghost">
          Войти
          <span class="btn-arrow">→</span>
        </a>

        <a href="{{ route('register') }}" class="btn-solid">
          Регистрация
          <span class="btn-arrow">→</span>
        </a>
      @endauth

    </div>

  </div>

  <div class="hero-scroll">
    <div class="hero-scroll-line"></div>
    <span class="hero-scroll-label">Scroll</span>
  </div>

</div>


  {{-- Divider --}}
  <div class="section-rule"></div>


  {{-- ══════════════════════════════════════════
  ТРЕНАЖЁРНЫЙ ЗАЛ
  ══════════════════════════════════════════ --}}
  <section class="section-wrap">
    <div class="section-inner">
      <div class="section-head reveal">
        <div class="section-head-left">
          <div class="label">Пространство</div>
          <h2 class="heading-xl">Тренажёрный зал</h2>
          <p class="subtext">Оснащённый по европейским стандартам зал с продуманным зонированием и премиальным
            оборудованием.</p>
        </div>
      </div>

      <div class="content-grid reveal">
        <div class="feat-group">
          <div class="feat-block">
            <div class="feat-block-head">
              <div class="feat-block-title">Высокие стандарты</div>
            </div>
            <ul class="feat-list">
              <li>Продуманное зонирование</li>
              <li>Хорошая вентиляция, освещение и оптимальный температурный режим</li>
              <li>Премиальное оборудование Technogym и Matrix</li>
              <li>Большое количество тренажёров — без очередей</li>
            </ul>
          </div>
          <div class="feat-block">
            <div class="feat-block-head">
              <div class="feat-block-title">Удобства</div>
            </div>
            <ul class="feat-list">
              <li>Просторные раздевалки</li>
              <li>Комфортные душевые</li>
              <li>Бесплатные шкафчики</li>
              <li>Фитнес-бар</li>
              <li>Зона отдыха</li>
              <br><br>
            </ul>
          </div>
        </div>

        <div class="media-col">
          <img src="{{ asset('images/0z.jpg') }}" alt="Тренажёрный зал">
          <div class="media-stats">
            <div class="media-stat">
              <div class="media-stat-val" data-count="2200">0</div>
              <div class="media-stat-lbl">м² площадь</div>
            </div>
            <div class="media-stat">
              <div class="media-stat-val" data-count="120">0</div>
              <div class="media-stat-lbl">тренажёров</div>
            </div>
            <div class="media-stat">
              <div class="media-stat-val" data-count="7">0</div>
              <div class="media-stat-lbl">зон</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="section-rule"></div>


  {{-- ══════════════════════════════════════════
  СПА-ЗОНА
  ══════════════════════════════════════════ --}}
  <section class="section-wrap alt">
    <div class="section-inner">
      <div class="section-head reveal">
        <div class="section-head-left">
          <div class="label">Восстановление</div>
          <h2 class="heading-xl">СПА-зона</h2>
          <p class="subtext">Полное расслабление и восстановление после интенсивных тренировок.</p>
        </div>
      </div>

      <div class="content-grid reverse reveal">
        <div class="feat-group">
          <div class="feat-block">
            <div class="feat-block-head">
              <div class="feat-block-title">Услуги</div>
            </div>
            <ul class="feat-list">
              <li>Финская сауна</li>
              <li>Турецкий хаммам</li>
              <li>Инфракрасная сауна</li>
              <li>Криосауна</li>
              <li>Массажный кабинет</li>
              <br><br>
            </ul>
          </div>
          <div class="feat-block">
            <div class="feat-block-head">
              <div class="feat-block-title">Преимущества</div>
            </div>
            <ul class="feat-list">
              <li>Профессиональные массажисты</li>
              <li>Ароматерапия и хромотерапия</li>
              <li>Чайная зона с травяными сборами</li>
              <li>Индивидуальный подход</li>
            </ul>
          </div>
        </div>

        <div class="media-col">
          <div>
            <div class=" h-100">
              <div class=" active h-100">
                <img src="{{ asset('images/spa.jpg') }}" class="d-block w-100 h-100 object-cover" alt="СПА">
              </div>
            </div>
          </div>
          <div class="media-stats">
            <div class="media-stat">
              <div class="media-stat-val">7</div>
              <div class="media-stat-lbl">процедур</div>
            </div>
            <div class="media-stat">
              <div class="media-stat-val">∞</div>
              <div class="media-stat-lbl">расслабление</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="section-rule"></div>


  {{-- ══════════════════════════════════════════
  БАССЕЙН
  ══════════════════════════════════════════ --}}
  <section class="section-wrap">
    <div class="section-inner">
      <div class="section-head reveal">
        <div class="section-head-left">
          <div class="label">Водная зона</div>
          <h2 class="heading-xl">Бассейн</h2>
          <p class="subtext">25 метров чистоты — пространство для спорта, акватренировок и медитации в воде.</p>
        </div>
      </div>

      <div class="content-grid reveal">
        <div class="feat-group">
          <div class="feat-block">
            <div class="feat-block-head">
              <div class="feat-block-title">Характеристики</div>
            </div>
            <ul class="feat-list">
              <li>Длина 25 метров, 6 дорожек</li>
              <li>Глубина от 1.2 до 1.8 м</li>
              <li>Температура воды 27–28°C</li>
              <li>Современная система очистки</li>
              <li>Подогрев пола</li>
            </ul>
          </div>
          <div class="feat-block">
            <div class="feat-block-head">
              <div class="feat-block-title">Занятия</div>
            </div>
            <ul class="feat-list">
              <li>Аквааэробика</li>
              <li>Обучение плаванию с нуля</li>
              <li>Персональные тренировки</li>
              <li>Детские группы</li>
              <li>Аква-йога</li>
            </ul>
          </div>
        </div>

        <div class="media-col">
          <img src="{{ asset('images/pool.jpg') }}" alt="Бассейн">
          <div class="media-stats">
            <div class="media-stat">
              <div class="media-stat-val">25м</div>
              <div class="media-stat-lbl">длина</div>
            </div>
            <div class="media-stat">
              <div class="media-stat-val">6</div>
              <div class="media-stat-lbl">дорожек</div>
            </div>
            <div class="media-stat">
              <div class="media-stat-val">28°</div>
              <div class="media-stat-lbl">температура</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- ══════════════════════════════════════════
  ТАРИФЫ
  ══════════════════════════════════════════ --}}
  <section class="tariffs-wrap">
    <div class="tariffs-inner">
      <div class="tariffs-head reveal">
        <div class="label">Стоимость</div>
        <h2 class="heading-xl">Наши тарифы</h2>
        <p class="subtext">Выберите подходящий формат — от разовых визитов до безлимитного абонемента.</p>
      </div>

      <div class="tariffs-grid">
        @forelse($tariffs as $tariff)
          <div class="tariff-card {{ $tariff->is_popular ? 'popular' : '' }} reveal-card">
            <div class="card-glow"></div>
            <div class="tariff-name">{{ $tariff->name }}</div>
            <div class="tariff-price">
              {{ number_format($tariff->price, 0, '', ' ') }}<sub> ₽</sub>
            </div>
            <div class="tariff-period">в {{ $tariff->period }}</div>
            <div class="tariff-features">
              @php $features = is_array($tariff->features) ? $tariff->features : json_decode($tariff->features, true); @endphp
              @foreach($features as $feature)
                <div class="feature-item">
                  <div class="feature-icon">✓</div>
                  <div>{{ $feature }}</div>
                </div>
              @endforeach
            </div>
            <a href="{{ route('choose-tariff') }}" class="tariff-btn">Выбрать тариф</a>
          </div>
        @empty
          <div class="empty-on-dark">
            Тарифы временно недоступны
          </div>
        @endforelse
      </div>
    </div>
  </section>


  {{-- ══════════════════════════════════════════
  ТРЕНЕРЫ
  ══════════════════════════════════════════ --}}
  <section class="trainers-wrap">
    <div class="section-inner">
      <div class="section-head reveal">
        <div class="section-head-left">
          <div class="label">Команда</div>
          <h2 class="heading-xl">Наши тренеры</h2>
          <p class="subtext">Профессионалы своего дела, готовые привести к результату.</p>
        </div>
      </div>

      <div class="trainers-grid">
        @forelse($trainers as $trainer)
          <div class="trainer-card reveal-card">
            <div class="tcard-glow"></div>
            <div class="trainer-photo">
              <img src="{{ $trainer->image_url }}" alt="{{ $trainer->name }}">
              <div class="trainer-photo-overlay"></div>
              <div class="trainer-exp">{{ $trainer->experience }} лет опыта</div>
            </div>
            <div class="trainer-body">
              <div class="trainer-name">{{ $trainer->name }}</div>
              <div class="trainer-role">{{ $trainer->position }}</div>
              <div class="trainer-meta">
                <div class="trainer-meta-item">{{ $trainer->certificates }}</div>
                <div class="trainer-meta-item">{{ $trainer->specialization }}</div>
              </div>
              <div class="trainer-quote">"{{ $trainer->quote }}"</div>
              @auth
                <a href="{{ route('trainer.profile', $trainer->id) }}" class="text-dark mb-3">
                                    Подробнее о тренере
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                <a href="{{ route('book-trainer.form', $trainer->id) }}" class="trainer-cta">
                  Записаться
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </a>
              @else
                <a href="{{ route('trainer.profile', $trainer->id) }}" class="text-dark mb-3">
                                    Подробнее о тренере
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                <a href="{{ route('book-trainer.form', $trainer->id) }}" class="trainer-cta">
                  Войти для записи
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </a>
              @endauth
            </div>
          </div>
        @empty
          <div class="empty-on-light">
            Тренеры временно недоступны
          </div>
        @endforelse
      </div>
    </div>
  </section>

  @if($homeReviews->isNotEmpty())
    <div class="section-rule"></div>
    <section class="section-wrap alt">
      <div class="section-inner">
        <div class="section-head reveal">
          <div class="section-head-left">
            <div class="label">Отзывы</div>
            <h2 class="heading-xl">Клиенты о наших тренерах</h2>
            <p class="subtext">Публикуем только прошедшие модерацию отзывы о персональных тренировках.</p>
          </div>
        </div>

        <div class="home-reviews-grid">
          @foreach($homeReviews as $review)
            <article class="home-review-card reveal-card">
              <div class="home-review-stars">
                @for($i = 1; $i <= 5; $i++)
                  {{ $i <= $review->rating ? '★' : '☆' }}
                @endfor
              </div>
              <p class="home-review-text">{{ $review->text }}</p>
              <div class="home-review-meta">
                <div class="home-review-author">{{ $review->name }}</div>
                <a href="{{ route('trainer.profile', $review->trainer->id) }}" class="home-review-trainer">
                  {{ $review->trainer->name }}
                </a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

@endsection


@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      'use strict';

      /* ── Хедер / navbar ── */
      const navbar = document.querySelector('#main-navbar')
        || document.querySelector('nav')
        || document.querySelector('header')
        || document.querySelector('.navbar');

      function syncNav() {
        const heroBottom = document.getElementById('hero')?.getBoundingClientRect().bottom ?? 0;
        const scrolled = heroBottom < 80;
        if (navbar) navbar.classList.toggle('scrolled', scrolled);
        document.body.classList.toggle('hero-visible', !scrolled);
      }
      window.addEventListener('scroll', syncNav, { passive: true });
      syncNav();

      /* ── Parallax hero ── */
      const heroImg = document.querySelector('#heroImg img');
      function onParallax() {
        if (!heroImg) return;
        heroImg.style.transform = `translateY(${window.scrollY * 0.26}px)`;
      }
      window.addEventListener('scroll', onParallax, { passive: true });

      /* ── Hero content fade-in ── */
      const heroContent = document.getElementById('heroContent');
      if (heroContent) requestAnimationFrame(() => heroContent.classList.add('visible'));

      /* ══════════════════════════════════════════
         CUSTOM CURSOR
      ══════════════════════════════════════════ */
      const cursor = document.getElementById('cursor');
      const ring = document.getElementById('cursor-ring');
      let mx = 0, my = 0, rx = 0, ry = 0;

      document.addEventListener('mousemove', e => {
        mx = e.clientX; my = e.clientY;
        cursor.style.left = mx + 'px';
        cursor.style.top = my + 'px';
      });

      (function animRing() {
        rx += (mx - rx) * 0.12;
        ry += (my - ry) * 0.12;
        ring.style.left = rx + 'px';
        ring.style.top = ry + 'px';
        requestAnimationFrame(animRing);
      })();

      document.addEventListener('mousedown', () => document.body.classList.add('cursor-click'));
      document.addEventListener('mouseup', () => document.body.classList.remove('cursor-click'));

      document.querySelectorAll('a, button, .tariff-card, .trainer-card, .feat-list li').forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
      });

      /* ══════════════════════════════════════════
         SPOTLIGHT (hero only)
      ══════════════════════════════════════════ */
      const spotlight = document.getElementById('spotlight');
      document.addEventListener('mousemove', e => {
        if (spotlight) {
          spotlight.style.left = e.clientX + 'px';
          spotlight.style.top = e.clientY + 'px';
        }
      });

      /* ══════════════════════════════════════════
         FLOATING PARTICLES (hero canvas)
      ══════════════════════════════════════════ */
      const canvas = document.getElementById('particles-canvas');
      if (canvas) {
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];

        function resize() {
          W = canvas.width = window.innerWidth;
          H = canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', resize);

        for (let i = 0; i < 55; i++) {
          particles.push({
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight,
            r: Math.random() * 1.4 + 0.3,
            vx: (Math.random() - .5) * 0.22,
            vy: (Math.random() - .5) * 0.22,
            a: Math.random() * 0.4 + 0.05
          });
        }

        function drawParticles() {
          ctx.clearRect(0, 0, W, H);
          particles.forEach(p => {
            p.x += p.vx; p.y += p.vy;
            if (p.x < 0) p.x = W;
            if (p.x > W) p.x = 0;
            if (p.y < 0) p.y = H;
            if (p.y > H) p.y = 0;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255,255,255,${p.a})`;
            ctx.fill();
          });
          requestAnimationFrame(drawParticles);
        }
        drawParticles();
      }

      /* ══════════════════════════════════════════
         CARD GLOW (tariff cards)
      ══════════════════════════════════════════ */
      document.querySelectorAll('.tariff-card').forEach(card => {
        const glow = card.querySelector('.card-glow');
        card.addEventListener('mousemove', e => {
          const r = card.getBoundingClientRect();
          const x = e.clientX - r.left;
          const y = e.clientY - r.top;
          if (glow) { glow.style.left = x + 'px'; glow.style.top = y + 'px'; }
        });
      });

      /* ══════════════════════════════════════════
         TRAINER CARD MAGNETIC GLOW
      ══════════════════════════════════════════ */
      document.querySelectorAll('.trainer-card').forEach(card => {
        card.addEventListener('mousemove', e => {
          const r = card.getBoundingClientRect();
          const x = ((e.clientX - r.left) / r.width * 100).toFixed(1);
          const y = ((e.clientY - r.top) / r.height * 100).toFixed(1);
          card.style.setProperty('--mx', x + '%');
          card.style.setProperty('--my', y + '%');
          // Subtle tilt
          const tx = ((e.clientX - r.left) / r.width - .5) * 4;
          const ty = ((e.clientY - r.top) / r.height - .5) * 4;
          card.style.transform = `translateY(-5px) scale(1.01) rotateX(${-ty}deg) rotateY(${tx}deg)`;
          card.style.transition = 'transform .08s ease, box-shadow .25s ease, border-color .25s ease';
        });
        card.addEventListener('mouseleave', () => {
          card.style.transform = '';
          card.style.transition = 'transform .35s cubic-bezier(.25,.46,.45,.94), box-shadow .25s ease, border-color .25s ease, opacity .65s ease, translate .65s ease';
        });
      });

      /* ══════════════════════════════════════════
         SCROLL REVEAL
      ══════════════════════════════════════════ */
      const revealObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); }
        });
      }, { threshold: 0.10 });
      document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

      /* ── Staggered cards ── */
      const cardObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            const siblings = Array.from(e.target.parentElement.querySelectorAll('.reveal-card'));
            const idx = siblings.indexOf(e.target);
            setTimeout(() => e.target.classList.add('visible'), idx * 80);
            cardObs.unobserve(e.target);
          }
        });
      }, { threshold: 0.08 });
      document.querySelectorAll('.reveal-card').forEach(el => cardObs.observe(el));

      /* ══════════════════════════════════════════
         NUMBER COUNTER ANIMATION
      ══════════════════════════════════════════ */
      const counterObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (!e.isIntersecting) return;
          const el = e.target;
          const end = parseInt(el.dataset.count, 10);
          if (isNaN(end)) return;
          const dur = 1400;
          const start = performance.now();
          function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            const ease = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(ease * end).toLocaleString('ru-RU');
            if (p < 1) requestAnimationFrame(tick);
          }
          requestAnimationFrame(tick);
          counterObs.unobserve(el);
        });
      }, { threshold: 0.5 });
      document.querySelectorAll('[data-count]').forEach(el => counterObs.observe(el));

      /* ══════════════════════════════════════════
         HORIZONTAL MARQUEE EFFECT on headings
         (subtle letter-spacing on scroll near element)
      ══════════════════════════════════════════ */
      const headings = document.querySelectorAll('.heading-xl');
      function onScroll() {
        headings.forEach(h => {
          const r = h.getBoundingClientRect();
          const center = r.top + r.height / 2;
          const vCenter = window.innerHeight / 2;
          const dist = Math.abs(center - vCenter) / window.innerHeight;
          h.style.letterSpacing = `calc(-0.03em + ${(1 - dist) * 0.008}em)`;
        });
      }
      window.addEventListener('scroll', onScroll, { passive: true });

    })();
  </script>
@endpush
