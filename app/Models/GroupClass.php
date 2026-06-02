<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GroupClass extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'instructor', 
        'duration', 'max_people', 'schedule', 'days', 'is_active'
    ];
    
    protected $casts = [
        'days' => 'array',
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

        if (Str::startsWith($image, 'classes/')) {
            return asset('images/' . $image);
        }

        return asset('images/classes/' . $image);
    }
}
