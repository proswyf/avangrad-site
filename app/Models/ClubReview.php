<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubReview extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
