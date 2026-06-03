<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainerReview;
use Illuminate\Http\Request;

class TrainerReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $reviewsQuery = TrainerReview::with(['trainer', 'user'])
            ->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $reviewsQuery->where('status', $status);
        }

        $reviews = $reviewsQuery->paginate(20)->withQueryString();

        $stats = [
            'all' => TrainerReview::count(),
            'pending' => TrainerReview::pending()->count(),
            'approved' => TrainerReview::where('status', 'approved')->count(),
            'rejected' => TrainerReview::where('status', 'rejected')->count(),
        ];

        return view('admin.trainer-reviews.index', compact('reviews', 'stats', 'status'));
    }

    public function approve($id)
    {
        $review = TrainerReview::findOrFail($id);
        $review->update([
            'status' => 'approved',
            'moderated_at' => now(),
            'moderation_note' => null,
        ]);

        return redirect()->route('admin.trainer-reviews.index')->with('success', 'Отзыв одобрен.');
    }

    public function reject(Request $request, $id)
    {
        $review = TrainerReview::findOrFail($id);
        $review->update([
            'status' => 'rejected',
            'moderated_at' => now(),
            'moderation_note' => $request->input('moderation_note'),
        ]);

        return redirect()->route('admin.trainer-reviews.index')->with('success', 'Отзыв отклонен.');
    }

    public function destroy($id)
    {
        $review = TrainerReview::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.trainer-reviews.index')->with('success', 'Отзыв удален.');
    }
}
