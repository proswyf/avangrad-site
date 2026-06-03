<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerBooking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'trainer_id', 'trainer_name', 'booking_date', 'booking_time', 'phone', 'comment', 'status'
    ];
    
    protected $casts = [
        'booking_date' => 'date',
    ];

    protected $appends = [
        'booking_date_label',
        'booking_weekday_label',
        'booking_time_label',
        'booking_schedule_label',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function getBookingDateLabelAttribute(): ?string
    {
        if (!$this->booking_date) {
            return null;
        }

        return $this->booking_date->copy()->locale('ru')->translatedFormat('d.m.Y');
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
        if (!$this->booking_date) {
            return null;
        }

        $label = $this->booking_weekday_label . ', ' . $this->booking_date_label;

        if ($this->booking_time_label) {
            $label .= ' в ' . $this->booking_time_label;
        }

        return $label;
    }
}
