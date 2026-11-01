<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Support\SiteSettings;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function show(string $slug): View
    {
        $service = Service::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $related = Service::query()
            ->where('is_active', true)
            ->where('id', '!=', $service->id)
            ->when($service->service_category_id, fn ($q) => $q->where('service_category_id', $service->service_category_id))
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        if ($related->count() < 4) {
            $related = Service::query()
                ->where('is_active', true)
                ->where('id', '!=', $service->id)
                ->orderBy('sort_order')
                ->limit(8)
                ->get();
        }

        $site = SiteSettings::all();
        $region = $site['region_label'] ?? 'Delhi NCR';

        return view('services.show', [
            'service' => $service,
            'related' => $related,
            'allServices' => Service::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'site' => $site,
            'cities' => City::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'timeSlots' => TimeSlot::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'pageTitle' => $service->name.' Repair & Service in '.$region.' | '.($site['site_name'] ?? ''),
            'metaDescription' => $service->meta_description
                ?? 'Book professional '.$service->name.' repair & service in '.$region.'. Doorstep visit, upfront pricing, '.$service->warranty_days.'-day warranty.',
        ]);
    }
}
