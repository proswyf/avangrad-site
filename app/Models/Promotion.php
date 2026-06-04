<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function getImageUrlAttribute(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        $image = ltrim($this->image, '/');

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        if (Str::startsWith($image, 'images/')) {
            return asset($image);
        }

        if (Str::startsWith($image, 'promotions/')) {
            return asset('images/' . $image);
        }

        return asset('images/promotions/' . $image);
    }
}
