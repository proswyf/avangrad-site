<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Trainer extends Model

{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'position',
        'experience',
        'specialization',
        'certificates',
        'quote',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function reviews()
    {
        return $this->hasMany(\App\Models\TrainerReview::class);
    }
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

        if (Str::startsWith($image, 'trainers/')) {
            return asset('images/' . $image);
        }

        return asset('images/trainers/' . $image);
    }
}
