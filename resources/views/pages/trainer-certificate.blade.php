@extends('layouts.app')

@section('title', 'Сертификат — ' . $trainer->name)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/trainer-certificate.css') }}">
@endpush

@section('content')

<section class="certificate-page">
    <div class="certificate-shell">
        <div class="certificate-head">
            <a href="{{ route('trainer.profile', $trainer->id) }}" class="certificate-back">← Вернуться к тренеру</a>
            <span class="certificate-kicker">Сертификат тренера</span>
            <h1 class="certificate-title">{{ $trainer->name }}</h1>
            <p class="certificate-subtitle">{{ $trainer->position }}</p>
        </div>

        @if($certificateImageUrl)
            <div class="certificate-actions">
                <a href="{{ route('trainer.profile', $trainer->id) }}" class="certificate-btn certificate-btn--ghost">Назад к профилю</a>
                <a href="{{ $certificateImageUrl }}" target="_blank" rel="noopener" class="certificate-btn">Открыть изображение</a>
            </div>

            <div class="certificate-stage">
                <img src="{{ $certificateImageUrl }}" alt="Сертификат тренера {{ $trainer->name }}" class="certificate-image">
            </div>
        @else
            <div class="certificate-empty">
                Изображение сертификата для этого тренера пока не добавлено.
            </div>
        @endif
    </div>
</section>

@endsection
