@extends('layouts.app')

@section('title', 'Акции')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/promotions.css') }}">
@endpush

@section('content')

@php
  $activePromo = auth()->check() ? auth()->user()->active_promotion : null;
@endphp

{{-- HERO --}}
<div class="pr-hero">
  <div class="pr-hero-grid" aria-hidden="true"></div>
  <div class="pr-hero-glow" aria-hidden="true"></div>
  <div class="pr-hero-inner">
    <div class="pr-label">Специальные предложения</div>
    <h1 class="pr-heading">Акции</h1>
    <p class="pr-subtext">Успей воспользоваться выгодными условиями — предложения ограничены по времени.</p>
  </div>
</div>

{{-- ACTIVE PROMO NOTICE --}}
@if($activePromo)
<div class="pr-notice-wrap">
  <div class="pr-inner">
    <div class="pr-active-notice">
      <div class="pr-active-notice-left">
        <div class="pr-active-notice-dot"></div>
        <div>
          <div class="pr-active-notice-label">Активная акция</div>
          <div class="pr-active-notice-title">{{ $activePromo }}</div>
        </div>
      </div>
      <div class="pr-active-notice-right">
        <div class="pr-active-notice-hint">Одновременно может быть активна только одна акция</div>
        <form method="POST" action="{{ route('cancel-promotion') }}">
          @csrf
          <button type="submit" class="pr-cancel-btn"
                  onclick="return confirm('Отменить акцию «{{ $activePromo }}»?')">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
            Отменить акцию
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif

{{-- GRID --}}
<div class="pr-section">
  <div class="pr-inner">
    <div class="pr-grid">
      @forelse($promotions as $promo)

        @php
          $isApplied = $activePromo === $promo->title;
          $isLocked  = $activePromo && !$isApplied;
        @endphp

        <div class="promo-card reveal-card {{ $isLocked ? 'promo-card--locked' : '' }}">

          @if($promo->image)
            <div class="promo-img-wrap">
              <img src="{{ asset('images/promotions/' . $promo->image) }}" alt="{{ $promo->title }}">
              @if($promo->badge)
                <div class="promo-badge">{{ $promo->badge }}</div>
              @endif
              @if($promo->valid_to)
                <div class="promo-deadline">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                    <circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1.2"/>
                    <path d="M6 3.5V6l2 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                  </svg>
                  до {{ \Carbon\Carbon::parse($promo->valid_to)->format('d.m.Y') }}
                </div>
              @endif
            </div>
          @endif

          <div class="promo-body">
            @if(!$promo->image && $promo->badge)
              <div class="promo-badge promo-badge--inline">{{ $promo->badge }}</div>
            @endif

            <div class="promo-title">{{ $promo->title }}</div>
            <div class="promo-desc">{{ $promo->description }}</div>

            @if(!$promo->image && $promo->valid_to)
              <div class="promo-deadline promo-deadline--inline">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                  <circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1.2"/>
                  <path d="M6 3.5V6l2 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                </svg>
                Действует до {{ \Carbon\Carbon::parse($promo->valid_to)->format('d.m.Y') }}
              </div>
            @endif

            <div class="promo-action">
              @auth
                @if($isApplied)
                  <button class="promo-btn promo-btn--applied" disabled>
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                      <path d="M2.5 7l3 3 6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Акция применена
                  </button>
                @elseif($isLocked)
                  <button class="promo-btn promo-btn--locked" disabled>
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                      <rect x="3" y="6" width="8" height="6" rx="1.5" stroke="currentColor" stroke-width="1.4"/>
                      <path d="M5 6V4.5a2 2 0 1 1 4 0V6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    Недоступно
                  </button>
                @else
                  <form method="POST" action="{{ url('/apply-promotion/' . $promo->id) }}" class="form-full-width">
                    @csrf
                    <button type="submit" class="promo-btn">
                      Воспользоваться
                      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </button>
                  </form>
                @endif
              @else
                <a href="{{ route('login') }}" class="promo-btn promo-btn--ghost">
                  Войти, чтобы воспользоваться
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              @endauth
            </div>
          </div>

        </div>

      @empty
        <div class="pr-empty">Акции временно недоступны</div>
      @endforelse
    </div>
  </div>
</div>

{{-- MODAL --}}
<div class="promo-modal" id="promoModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="promo-modal-box">
    <div class="promo-modal-icon" aria-hidden="true">
      <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
        <circle cx="14" cy="14" r="13" stroke="currentColor" stroke-width="1.5"/>
        <path d="M8 14l4 4 8-8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="promo-modal-title" id="modalTitle"></div>
    <div class="promo-modal-message" id="modalMessage"></div>
    <div class="promo-modal-code" id="modalCode"></div>
    <button class="promo-modal-close" onclick="closePromoModal()">Отлично!</button>
  </div>
</div>

@if(session('promotion_applied'))
<div id="promo-data"
     data-title="{{ session('promotion_applied')['title'] }}"
     data-message="{{ session('promotion_applied')['message'] }}"
     data-code="{{ session('promotion_applied')['code'] }}"
     class="display-none"></div>
@endif

@endsection

@push('scripts')
<script>
(function () {
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

  window.showPromoModal = function (title, message, code) {
    const modal = document.getElementById('promoModal');
    if (!modal) return;
    document.getElementById('modalTitle').textContent   = title;
    document.getElementById('modalMessage').textContent = message;
    const codeEl = document.getElementById('modalCode');
    codeEl.textContent = code ? 'Промокод: ' + code : '';
    codeEl.style.display = code ? '' : 'none';
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.closePromoModal = function () {
    const modal = document.getElementById('promoModal');
    if (modal) {
      modal.classList.remove('open');
      document.body.style.overflow = '';
    }
  };

  document.getElementById('promoModal')?.addEventListener('click', function (e) {
    if (e.target === this) closePromoModal();
  });

  const pd = document.getElementById('promo-data');
  if (pd && pd.dataset.title) {
    showPromoModal(pd.dataset.title, pd.dataset.message, pd.dataset.code);
  }
})();
</script>
@endpush

