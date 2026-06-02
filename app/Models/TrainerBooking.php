<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerBooking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'trainer_id', 'trainer_name', 'booking_date', 'phone', 'comment', 'status'
    ];
    
    protected $casts = [
        'booking_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}