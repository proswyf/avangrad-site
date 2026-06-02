<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'user_id',
        'name',
        'rating',
        'text',
        'status',
        'moderated_at',
        'moderation_note',
    ];

    protected $casts = [
        'moderated_at' => 'datetime',
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
