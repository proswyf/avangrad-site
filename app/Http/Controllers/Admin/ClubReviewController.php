<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ClubReviewController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->clubReviewsReady()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Сначала выполните миграцию таблицы отзывов о клубе.');
        }

        $status = $request->query('status', 'pending');
        $allowedStatuses = ['pending', 'approved', 'rejected', 'all'];

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $reviewsQuery = ClubReview::with('user')->latest();

        if ($status !== 'all') {
            $reviewsQuery->where('status', $status);
        }

        $reviews = $reviewsQuery->paginate(20)->withQueryString();

        $stats = [
            'all' => ClubReview::count(),
            'pending' => ClubReview::pending()->count(),
            'approved' => ClubReview::approved()->count(),
            'rejected' => ClubReview::where('status', 'rejected')->count(),
        ];

        return view('admin.club-reviews.index', compact('reviews', 'stats', 'status'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->clubReviewsReady()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Сначала выполните миграцию таблицы отзывов о клубе.');
        }

        $review = ClubReview::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'moderation_note' => 'nullable|string|max:1000',
        ]);

        $status = $request->status;

        $review->update([
            'status' => $status,
            'moderated_at' => $status === 'pending' ? null : now(),
            'moderation_note' => blank($request->moderation_note) ? null : trim($request->moderation_note),
        ]);

        $statusLabels = [
            'pending' => 'ожидает модерации',
            'approved' => 'одобрен',
            'rejected' => 'отклонен',
        ];

        return redirect()
            ->route('admin.club-reviews.index', ['status' => $request->query('status', 'pending')])
            ->with('success', 'Статус отзыва обновлен: ' . $statusLabels[$status] . '.');
    }

    private function clubReviewsReady(): bool
    {
        return Schema::hasTable('club_reviews')
            && Schema::hasColumn('club_reviews', 'status')
            && Schema::hasColumn('club_reviews', 'rating');
    }
}
