<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Service;
use App\Models\StatCounter;
use App\Models\TimeSlot;
use App\Models\WorkStep;
use App\Support\SiteSettings;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'site' => SiteSettings::all(),
            'cities' => City::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'featuredServices' => Service::query()->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->get(),
            'timeSlots' => TimeSlot::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'gallery' => GalleryItem::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'features' => Feature::query()->orderBy('sort_order')->get(),
            'steps' => WorkStep::query()->orderBy('sort_order')->get(),
            'stats' => StatCounter::query()->orderBy('sort_order')->get(),
            'footerPages' => Page::query()->where('is_published', true)->orderBy('title')->get(),
            'heroSlides' => HeroSlide::query()->where('is_active', true)->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }
}
