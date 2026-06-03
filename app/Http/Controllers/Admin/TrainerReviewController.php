<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TrainerReviewController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->trainerReviewsReady()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Сначала выполните миграцию таблицы отзывов о тренерах.');
        }

        $status = $request->query('status', 'pending');
        $allowedStatuses = ['pending', 'approved', 'rejected', 'all'];

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $reviewsQuery = TrainerReview::with(['trainer', 'user'])->latest();

        if ($status !== 'all') {
            $reviewsQuery->where('status', $status);
        }

        $reviews = $reviewsQuery->paginate(20)->withQueryString();

        $stats = [
            'all' => TrainerReview::count(),
            'pending' => TrainerReview::pending()->count(),
            'approved' => TrainerReview::approved()->count(),
            'rejected' => TrainerReview::where('status', 'rejected')->count(),
        ];

        return view('admin.trainer-reviews.index', compact('reviews', 'stats', 'status'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->trainerReviewsReady()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Сначала выполните миграцию таблицы отзывов о тренерах.');
        }

        $review = TrainerReview::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'moderation_note' => 'nullable|string|max:1000',
        ]);

        $status = $request->input('status');

        $review->update([
            'status' => $status,
            'moderated_at' => $status === 'pending' ? null : now(),
            'moderation_note' => blank($request->input('moderation_note'))
                ? null
                : trim((string) $request->input('moderation_note')),
        ]);

        $statusLabels = [
            'pending' => 'ожидает модерации',
            'approved' => 'одобрен',
            'rejected' => 'отклонен',
        ];

        return redirect()
            ->route('admin.trainer-reviews.index', ['status' => $request->query('status', 'pending')])
            ->with('success', 'Статус отзыва обновлен: ' . $statusLabels[$status] . '.');
    }

    private function trainerReviewsReady(): bool
    {
        return Schema::hasTable('trainer_reviews')
            && Schema::hasColumn('trainer_reviews', 'status')
            && Schema::hasColumn('trainer_reviews', 'rating');
    }
}
