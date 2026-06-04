@extends('layouts.app')

@section('title', $tariff->name)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/tariff-show.css') }}">
@endpush

@section('content')
@php
    $features = is_array($tariff->features) ? $tariff->features : json_decode($tariff->features, true);
@endphp

<div class="tariff-show-hero">
    <div class="tariff-show-inner">
        <a href="{{ route('tariffs') }}" class="tariff-show-back">← Все тарифы</a>
        <div class="tariff-show-label">Подробно о тарифе</div>
        <h1 class="tariff-show-title">{{ $tariff->name }}</h1>
        <p class="tariff-show-subtitle">{{ $tariff->description ?: 'Подробная информация о тарифе, его преимуществах и формате посещения.' }}</p>
    </div>
</div>

<div class="tariff-show-wrap">
    <div class="tariff-show-inner">
        <div class="tariff-show-grid">
            <section class="tariff-show-main">
                <div class="tariff-show-card">
                    <div class="tariff-show-card-label">Что входит</div>
                    <div class="tariff-show-section-title">Преимущества тарифа</div>

                    <div class="tariff-show-features">
                        @forelse($features ?? [] as $feature)
                            <div class="tariff-show-feature">
                                <span class="tariff-show-feature-icon">✓</span>
                                <span>{{ $feature }}</span>
                            </div>
                        @empty
                            <div class="tariff-show-empty">Преимущества пока не указаны.</div>
                        @endforelse
                    </div>
                </div>

                <div class="tariff-show-card">
                    <div class="tariff-show-card-label">Описание</div>
                    <div class="tariff-show-section-title">Кому подходит этот тариф</div>
                    <div class="tariff-show-description">
                        {{ $tariff->description ?: 'Этот тариф подойдет тем, кто хочет подобрать удобный формат тренировок под свой график и цели.' }}
                    </div>
                </div>
            </section>

            <aside class="tariff-show-side">
                <div class="tariff-show-summary {{ $tariff->is_popular ? 'is-popular' : '' }}">
                    @if($tariff->is_popular)
                        <div class="tariff-show-popular">Популярный выбор</div>
                    @endif

                    <div class="tariff-show-name">{{ $tariff->name }}</div>
                    <div class="tariff-show-price">{{ number_format($tariff->price, 0, '', ' ') }} <sub>₽</sub></div>
                    <div class="tariff-show-period">в {{ $tariff->period }}</div>

                    <div class="tariff-show-meta">
                        <div class="tariff-show-meta-item">
                            <div class="tariff-show-meta-label">Формат</div>
                            <div class="tariff-show-meta-value">Абонемент клуба</div>
                        </div>
                        <div class="tariff-show-meta-item">
                            <div class="tariff-show-meta-label">Подходит для</div>
                            <div class="tariff-show-meta-value">Регулярных тренировок</div>
                        </div>
                    </div>

                    <a href="{{ route('choose-tariff') }}" class="tariff-show-cta">Выбрать тариф</a>
                </div>
            </aside>
        </div>

        @if($otherTariffs->isNotEmpty())
            <div class="tariff-show-more">
                <div class="tariff-show-more-head">
                    <div class="tariff-show-card-label">Другие варианты</div>
                    <div class="tariff-show-section-title">Посмотрите ещё тарифы</div>
                </div>

                <div class="tariff-show-more-grid">
                    @foreach($otherTariffs as $otherTariff)
                        <a href="{{ route('tariffs.show', $otherTariff->slug) }}" class="tariff-show-mini">
                            <div class="tariff-show-mini-name">{{ $otherTariff->name }}</div>
                            <div class="tariff-show-mini-price">{{ number_format($otherTariff->price, 0, '', ' ') }} ₽</div>
                            <div class="tariff-show-mini-period">в {{ $otherTariff->period }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
