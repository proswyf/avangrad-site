<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Faq;
use App\Models\GroupClass;
use App\Models\Promotion;
use App\Models\Tariff;
use App\Models\Trainer;
use App\Models\TrainerReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function home()
    {
        $tariffs = Tariff::where('is_active', true)->orderBy('sort_order')->get();
        $promotions = Promotion::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_to')->orWhere('valid_to', '>=', now());
            })
            ->orderBy('sort_order')
            ->get();
        $classes = GroupClass::where('is_active', true)->get();

        $trainersQuery = Trainer::where('is_active', true)->orderBy('sort_order');
        $homeReviews = collect();

        if ($this->trainerReviewsReady()) {
            $trainersQuery
                ->withCount('approvedReviews')
                ->withAvg('approvedReviews as approved_rating', 'rating');

            $homeReviews = TrainerReview::approved()
                ->with('trainer')
                ->latest('moderated_at')
                ->latest()
                ->take(6)
                ->get();
        }

        $trainers = $trainersQuery->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $faqsByCategory = $faqs->groupBy('category');

        return view('pages.home', compact('tariffs', 'promotions', 'classes', 'trainers', 'homeReviews', 'faqsByCategory'));
    }

    public function trainerProfile($id)
    {
        $trainerQuery = Trainer::query();
        $reviews = collect();
        $userReview = null;

        if ($this->trainerReviewsReady()) {
            $trainerQuery
                ->withCount('approvedReviews')
                ->withAvg('approvedReviews as approved_rating', 'rating');
        }

        $trainer = $trainerQuery->findOrFail($id);

        if ($this->trainerReviewsReady()) {
            $reviews = $trainer->approvedReviews()->latest()->get();

            if (Auth::check()) {
                $userReview = $trainer->reviews()
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->first();
            }
        }

        return view('pages.trainer-profile', compact('trainer', 'reviews', 'userReview'));
    }

    public function tariffs()
    {
        $tariffs = Tariff::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.tariffs', compact('tariffs'));
    }

    public function promotions()
    {
        $promotions = Promotion::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_to')->orWhere('valid_to', '>=', now());
            })
            ->orderBy('sort_order')
            ->get();

        return view('pages.promotions', compact('promotions'));
    }

    public function groupClasses()
    {
        $classes = GroupClass::where('is_active', true)->get();
        $myBookings = collect();

        if (Auth::check()) {
            $myBookings = Booking::where('user_id', Auth::id())
                ->latestFirst()
                ->get();
        }

        return view('pages.group-classes', compact('classes', 'myBookings'));
    }

    public function trainers()
    {
        $trainers = Trainer::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.trainers', compact('trainers'));
    }

    public function faq()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $faqsByCategory = $faqs->groupBy('category');

        return view('pages.faq', compact('faqsByCategory'));
    }

    public function login()
    {
        return view('pages.login');
    }

    public function register()
    {
        return view('pages.register');
    }

    private function trainerReviewsReady(): bool
    {
        return Schema::hasTable('trainer_reviews')
            && Schema::hasColumn('trainer_reviews', 'status')
            && Schema::hasColumn('trainer_reviews', 'rating');
    }
}
