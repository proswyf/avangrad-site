<?php

namespace App\Http\Controllers;

use App\Models\ClubReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ClubReviewController extends Controller
{
    public function store(Request $request)
    {
        if (!$this->clubReviewsReady()) {
            return redirect()
                ->route('home')
                ->with('error', 'Отзывы о клубе пока недоступны. Сначала выполните миграции.');
        }

        $user = $request->user();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string|min:20|max:1500',
        ]);

        $hasExistingReview = ClubReview::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($hasExistingReview) {
            return redirect()
                ->route('home')
                ->with('error', 'У вас уже есть отзыв о клубе, который опубликован или ожидает модерации.');
        }

        ClubReview::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'rating' => (int) $request->rating,
            'text' => trim($request->text),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Отзыв о клубе отправлен на модерацию.');
    }

    private function clubReviewsReady(): bool
    {
        return Schema::hasTable('club_reviews')
            && Schema::hasColumn('club_reviews', 'status')
            && Schema::hasColumn('club_reviews', 'rating');
    }
}
