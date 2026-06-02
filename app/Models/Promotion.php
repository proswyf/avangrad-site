<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'slug', 'description', 'details', 'badge', 
        'image', 'valid_from', 'valid_to', 'is_active', 'sort_order'
    ];
    
    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
        'is_active' => 'boolean',
    ];
}