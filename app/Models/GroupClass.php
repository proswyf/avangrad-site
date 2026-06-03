<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GroupClass extends Model
{
    use HasFactory;

    private const WEEKDAY_MAP = [
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 3,
        'thursday' => 4,
        'friday' => 5,
        'saturday' => 6,
        'sunday' => 7,
    ];
    
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

    public function getScheduleStartTimeAttribute(): ?string
    {
        if (!preg_match('/(\d{2}:\d{2})/', (string) $this->schedule, $matches)) {
            return null;
        }

        return $matches[1];
    }

    public function getUpcomingSessionsAttribute(): array
    {
        $allowedDays = collect($this->days ?? [])
            ->map(fn ($day) => self::WEEKDAY_MAP[$day] ?? null)
            ->filter()
            ->values()
            ->all();

        $startTime = $this->schedule_start_time;

        if (empty($allowedDays) || !$startTime) {
            return [];
        }

        $sessions = [];
        $cursor = now()->startOfDay();

        for ($offset = 0; $offset < 45 && count($sessions) < 8; $offset++) {
            $date = $cursor->copy()->addDays($offset);

            if (!in_array($date->dayOfWeekIso, $allowedDays, true)) {
                continue;
            }

            $sessionAt = Carbon::createFromFormat(
                'Y-m-d H:i',
                $date->format('Y-m-d') . ' ' . $startTime,
                config('app.timezone')
            );

            if ($sessionAt->lt(now())) {
                continue;
            }

            $weekday = mb_convert_case(
                $date->copy()->locale('ru')->translatedFormat('l'),
                MB_CASE_TITLE,
                'UTF-8'
            );

            $sessions[] = [
                'date' => $date->format('Y-m-d'),
                'date_label' => $date->format('d.m.Y'),
                'weekday_label' => $weekday,
                'time_label' => $startTime,
                'label' => $weekday . ', ' . $date->format('d.m.Y') . ' в ' . $startTime,
            ];
        }

        return $sessions;
    }

    public function runsOnDate(Carbon $date): bool
    {
        $allowedDays = collect($this->days ?? [])
            ->map(fn ($day) => self::WEEKDAY_MAP[$day] ?? null)
            ->filter()
            ->values()
            ->all();

        return in_array($date->dayOfWeekIso, $allowedDays, true);
    }
}
