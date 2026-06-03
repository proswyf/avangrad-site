@extends('layouts.app')

@section('title', 'Запись к тренеру')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard/book-trainer.css') }}">
@endpush

@section('content')
<div class="book-trainer-section">
  <div class="book-trainer-container">

    <div class="login-header">
      <h2>Запись к тренеру</h2>
      <p>Заполните форму и мы свяжемся с вами для подтверждения</p>
    </div>

    <div class="login-card">

     <div class="trainer-info-block">
        <div class="trainer-info-avatar">
          @if($trainer->image_url)
            <img src="{{ $trainer->image_url }}" alt="{{ $trainer->name }}">
          @else
            <div class="trainer-info-avatar-placeholder">
              {{ mb_strtoupper(mb_substr($trainer->name, 0, 1)) }}
            </div>
          @endif
        </div>
        <div>
          <div class="trainer-info-name">{{ $trainer->name }}</div>
          <div class="trainer-info-role">{{ $trainer->position }}</div>
          @if($trainer->quote)
            <div class="trainer-info-quote">«{{ $trainer->quote }}»</div>
          @endif
        </div>
      </div>

      <form method="POST" action="{{ route('book-trainer') }}">
        @csrf
        <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">

        <div class="booking-datetime-grid">
          <div class="form-group">
            <label class="form-label">Дата тренировки</label>
            <input type="date" name="booking_date" class="form-input"
                   value="{{ old('booking_date') }}"
                   min="{{ now()->format('Y-m-d') }}"
                   data-booking-date required>
            <span class="form-hint">Выберите день тренировки</span>
          </div>

          <div class="form-group">
            <label class="form-label">Время тренировки</label>
            <input type="time" name="booking_time" class="form-input"
                   value="{{ old('booking_time') }}"
                   min="08:00" max="22:00" step="1800"
                   data-booking-time required>
            <span class="form-hint">Выберите удобное время</span>
          </div>
        </div>

        <div class="booking-slot-preview" id="bookingSlotPreview">
          <div class="booking-slot-label">Запланированная тренировка</div>
          <div class="booking-slot-value" id="bookingSlotValue">Выберите дату и время.</div>
        </div>

        <div class="form-group">
          <label class="form-label">Телефон для связи</label>
          <input type="tel" name="phone" class="form-input"
                 value="{{ old('phone', auth()->user()->phone) }}"
                 placeholder="+7 (___) ___-__-__" required>
        </div>

        <div class="form-group">
          <label class="form-label">Комментарий</label>
          <textarea name="comment" class="form-textarea"
                    placeholder="Напишите ваши пожелания или вопросы...">{{ old('comment') }}</textarea>
          <span class="form-hint">Необязательно</span>
        </div>

        <button type="submit" class="submit-button">
          Отправить заявку
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </form>

      <div class="login-divider"></div>

      <div class="trainer-back-wrap">
        <a href="{{ route('trainers') }}" class="trainer-back-link">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
          </svg>
          К списку тренеров
        </a>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.querySelector('[data-booking-date]');
    const timeInput = document.querySelector('[data-booking-time]');
    const slotValue = document.getElementById('bookingSlotValue');

    if (!dateInput || !timeInput || !slotValue) {
      return;
    }

    const pad = (value) => String(value).padStart(2, '0');

    const updateMinimumTime = () => {
      const today = new Date();
      const selectedDate = dateInput.value;
      const todayValue = `${today.getFullYear()}-${pad(today.getMonth() + 1)}-${pad(today.getDate())}`;

      if (selectedDate === todayValue) {
        const minHour = pad(today.getHours());
        const minMinute = pad(today.getMinutes());
        timeInput.min = `${minHour}:${minMinute}`;
      } else {
        timeInput.min = '08:00';
      }
    };

    const updatePreview = () => {
      if (!dateInput.value || !timeInput.value) {
        slotValue.textContent = 'Выберите дату и время.';
        return;
      }

      const selectedDate = new Date(`${dateInput.value}T12:00:00`);
      const weekday = new Intl.DateTimeFormat('ru-RU', { weekday: 'long' }).format(selectedDate);
      const formattedDate = new Intl.DateTimeFormat('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      }).format(selectedDate);

      slotValue.textContent = `${weekday.charAt(0).toUpperCase()}${weekday.slice(1)}, ${formattedDate} в ${timeInput.value}`;
    };

    dateInput.addEventListener('input', () => {
      updateMinimumTime();
      updatePreview();
    });

    timeInput.addEventListener('input', updatePreview);

    updateMinimumTime();
    updatePreview();
  });
</script>
@endpush
