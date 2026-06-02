<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'price', 'period', 'description', 
        'features', 'is_popular', 'sort_order', 'is_active'
    ];
    
    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];
}