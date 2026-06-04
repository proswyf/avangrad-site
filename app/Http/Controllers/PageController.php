<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ClubReview;
use App\Models\Faq;
use App\Models\GroupClass;
use App\Models\Promotion;
use App\Models\Tariff;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
        $clubReviews = collect();
        $userClubReview = null;

        if ($this->trainerReviewsReady()) {
            $trainersQuery
                ->withCount('approvedReviews')
                ->withAvg('approvedReviews as approved_rating', 'rating');
        }

        if ($this->clubReviewsReady()) {
            $clubReviews = ClubReview::approved()
                ->latest('moderated_at')
                ->latest()
                ->take(6)
                ->get();

            if (Auth::check()) {
                $userClubReview = ClubReview::where('user_id', Auth::id())
                    ->latest()
                    ->first();
            }
        }

        $trainers = $trainersQuery->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $faqsByCategory = $faqs->groupBy('category');

        return view('pages.home', compact(
            'tariffs',
            'promotions',
            'classes',
            'trainers',
            'clubReviews',
            'userClubReview',
            'faqsByCategory'
        ));
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

    public function trainerCertificate($id)
    {
        $trainer = Trainer::findOrFail($id);
        $certificateImageUrl = $this->resolveTrainerCertificateImage($trainer);

        return view('pages.trainer-certificate', compact('trainer', 'certificateImageUrl'));
    }

    public function tariffs()
    {
        $tariffs = Tariff::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.tariffs', compact('tariffs'));
    }

    public function tariffShow($slug)
    {
        $tariff = Tariff::where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $otherTariffs = Tariff::where('is_active', true)
            ->where('id', '!=', $tariff->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('pages.tariff-show', compact('tariff', 'otherTariffs'));
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
        $trainersQuery = Trainer::where('is_active', true)->orderBy('sort_order');

        if ($this->trainerReviewsReady()) {
            $trainersQuery
                ->withCount('approvedReviews')
                ->withAvg('approvedReviews as approved_rating', 'rating');
        }

        $trainers = $trainersQuery->get();

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

    private function clubReviewsReady(): bool
    {
        return Schema::hasTable('club_reviews')
            && Schema::hasColumn('club_reviews', 'status')
            && Schema::hasColumn('club_reviews', 'rating');
    }

    private function resolveTrainerCertificateImage(Trainer $trainer): ?string
    {
        $certificateMap = [
            'Алексей Смирнов' => 'AlekseiSmirnov.jpg',
            'Мария Волкова' => 'MariaVolkova.jpg',
            'Дмитрий Ковалев' => 'DmitriKovalev.jpg',
            'Анна Кузнецова' => 'AnnaKyznecova.jpg',
            'Игорь Морозов' => 'IgorMorozov.jpg',
            'Елена Соколова' => 'ElenaSokolova.jpg',
        ];

        $filename = $certificateMap[$trainer->name] ?? null;

        if (! $filename) {
            $fallbackName = Str::of($trainer->name)
                ->ascii()
                ->replaceMatches('/[^A-Za-z0-9\\s]/', '')
                ->squish()
                ->replace(' ', '')
                ->toString();

            foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
                $candidate = $fallbackName . '.' . $extension;

                if (File::exists(public_path('images/sertifikat/' . $candidate))) {
                    $filename = $candidate;
                    break;
                }
            }
        }

        if (! $filename) {
            return null;
        }

        $relativePath = 'images/sertifikat/' . $filename;

        if (! File::exists(public_path($relativePath))) {
            return null;
        }

        return asset($relativePath);
    }
}
