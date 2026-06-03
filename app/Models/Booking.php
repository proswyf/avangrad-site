<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_name',
        'booking_date',
        'booking_time',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function scopeLatestFirst($query)
    {
        return $query
            ->orderByDesc('booking_date')
            ->orderByDesc('created_at');
    }

    public function getResolvedStatusAttribute(): string
    {
        return match ($this->status) {
            'cancelled', 'completed' => $this->status,
            default => 'active',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->resolved_status) {
            'cancelled' => 'Отменена',
            'completed' => 'Завершена',
            default => 'Активна',
        };
    }

    public function getCanBeCancelledAttribute(): bool
    {
        if ($this->resolved_status !== 'active' || !$this->booking_date) {
            return false;
        }

        if ($this->booking_time) {
            $bookingAt = Carbon::createFromFormat(
                'Y-m-d H:i',
                $this->booking_date->format('Y-m-d') . ' ' . substr((string) $this->booking_time, 0, 5),
                config('app.timezone')
            );

            return $bookingAt->gte(now());
        }

        return $this->booking_date->gte(now()->startOfDay());
    }

    public function getBookingDateLabelAttribute(): ?string
    {
        return $this->booking_date?->format('d.m.Y');
    }

    public function getBookingWeekdayLabelAttribute(): ?string
    {
        if (!$this->booking_date) {
            return null;
        }

        return mb_convert_case(
            $this->booking_date->copy()->locale('ru')->translatedFormat('l'),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }

    public function getBookingTimeLabelAttribute(): ?string
    {
        if (!$this->booking_time) {
            return null;
        }

        return substr((string) $this->booking_time, 0, 5);
    }

    public function getBookingScheduleLabelAttribute(): ?string
    {
        if (!$this->booking_date_label) {
            return null;
        }

        $label = $this->booking_weekday_label . ', ' . $this->booking_date_label;

        if ($this->booking_time_label) {
            $label .= ' в ' . $this->booking_time_label;
        }

        return $label;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
