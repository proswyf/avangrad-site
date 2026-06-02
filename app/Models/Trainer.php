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
        'bio',
        'experience',
        'specialization',
        'certificates',
        'quote',
        'image',
        'methodology',
        'achievements',
        'price',
        'rating',
        'clients_count',
        'sessions_count',
        'formats',
        'image_url',
        'education',
        'instagram',
        'telegram',
        'training_format',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'clients_count' => 'integer',
        'sessions_count' => 'integer',
    ];
    public function reviews()
    {
        return $this->hasMany(\App\Models\TrainerReview::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('status', 'approved');
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
