@extends('layouts.app')

@section('title', 'Статистика записей')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/bookings/stats.css') }}">
@endpush

@section('content')

<div class="stats-container">
    <div class="page-header">
        <h1>Статистика записей на тренировки</h1>
        <a href="{{ route('admin.bookings') }}" class="btn-back">← Назад к списку</a>
    </div>
    
    <div class="chart-card">
        <h3>Популярность занятий</h3>
        @php
            $maxCount = $stats['by_class']->max('total') ?? 1;
        @endphp
        
        @if(count($stats['by_class']) > 0)
            <table class="stats-table">
                @foreach($stats['by_class'] as $item)
                <tr>
                    <td width="200" class="class-name">{{ $item->class_name }}</td>
                    <td width="60" class="count">{{ $item->total }} записей</td>
                    <td>
                        @php
                            $width = ($item->total / $maxCount) * 100;
                        @endphp
                        <div class="bar" style="width: {{ $width }}%;"></div>
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <div class="empty-stats">Нет активных записей для статистики</div>
        @endif
    </div>
    
    <div class="chart-card">
        <h3>Динамика записей (последние 7 дней)</h3>
        
        @if(count($stats['by_day']) > 0)
            <table class="stats-table">
                @foreach($stats['by_day'] as $item)
                <tr>
                    <td width="120">{{ \Carbon\Carbon::parse($item->date)->format('d.m.Y') }}</td>
                    <td width="60" class="count">{{ $item->total }} записей</td>
                    <td>
                        @php
                            $maxDayCount = $stats['by_day']->max('total') ?? 1;
                            $dayWidth = ($item->total / $maxDayCount) * 100;
                        @endphp
                        <div class="bar" style="width: {{ $dayWidth }}%;"></div>
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <div class="empty-stats">Нет записей за последние 7 дней</div>
        @endif
    </div>
</div>
@endsection




