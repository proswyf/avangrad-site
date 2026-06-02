<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Faq;
use App\Models\GroupClass;
use App\Models\Promotion;
use App\Models\Tariff;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;

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
        $trainers = Trainer::where('is_active', true)->orderBy('sort_order')->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $faqsByCategory = $faqs->groupBy('category');

        return view('pages.home', compact('tariffs', 'promotions', 'classes', 'trainers', 'faqsByCategory'));
    }
    

    public function trainerProfile($id)
    {
        $trainer = Trainer::findOrFail($id);

        $reviews = $trainer->reviews()->latest()->get();

        $otherTrainers = Trainer::where('is_active', true)
            ->where('id', '!=', $trainer->id)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('pages.trainer-profile', compact(
            'trainer',
            'reviews',
            'otherTrainers'
        ));
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
}
