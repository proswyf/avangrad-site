<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\TrainerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TrainerReviewController extends Controller
{
    public function store(Request $request, $trainerId)
    {
        if (!$this->trainerReviewsReady()) {
            return redirect()
                ->route('trainer.profile', $trainerId)
                ->with('error', 'Отзывы пока недоступны. Сначала выполните миграции.');
        }

        $trainer = Trainer::where('is_active', true)->findOrFail($trainerId);
        $user = $request->user();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string|min:20|max:1500',
        ]);

        $hasExistingReview = TrainerReview::where('trainer_id', $trainer->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($hasExistingReview) {
            return redirect()
                ->route('trainer.profile', $trainer->id)
                ->with('error', 'У вас уже есть отзыв по этому тренеру, который опубликован или ожидает модерации.');
        }

        TrainerReview::create([
            'trainer_id' => $trainer->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'rating' => (int) $request->rating,
            'text' => trim($request->text),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('trainer.profile', $trainer->id)
            ->with('success', 'Отзыв отправлен на модерацию.');
    }

    private function trainerReviewsReady(): bool
    {
        return Schema::hasTable('trainer_reviews')
            && Schema::hasColumn('trainer_reviews', 'status')
            && Schema::hasColumn('trainer_reviews', 'rating');
    }
}
