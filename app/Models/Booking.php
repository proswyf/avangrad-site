<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_name',
        'booking_date',
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
        return $this->resolved_status === 'active';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
