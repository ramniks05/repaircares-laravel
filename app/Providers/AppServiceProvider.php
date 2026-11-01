<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Service;
use App\Support\SiteSettings;
use App\Support\WhatsAppLink;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.public', function ($view) {
            $view->with('site', SiteSettings::all());
            if (! array_key_exists('cities', $view->getData())) {
                $view->with('cities', \App\Models\City::query()->where('is_active', true)->orderBy('sort_order')->get());
            }
            if (! array_key_exists('bookingServices', $view->getData())) {
                $view->with('bookingServices', \App\Models\Service::query()->where('is_active', true)->orderBy('sort_order')->get());
            }
            if (! array_key_exists('bookingTimeSlots', $view->getData())) {
                $view->with('bookingTimeSlots', \App\Models\TimeSlot::query()->where('is_active', true)->orderBy('sort_order')->get());
            }

            $view->with('whatsappChatUrl', WhatsAppLink::url(WhatsAppLink::chatMessage()));
            $view->with('whatsappPhone', WhatsAppLink::normalizePhone(SiteSettings::get('whatsapp', '')));
        });

        View::composer('partials.site-footer', function ($view) {
            if (! array_key_exists('site', $view->getData())) {
                $view->with('site', SiteSettings::all());
            }
            if (! array_key_exists('footerServices', $view->getData())) {
                $view->with('footerServices', Service::query()->where('is_active', true)->orderBy('sort_order')->get());
            }
            if (! array_key_exists('featuredServices', $view->getData())) {
                $view->with('featuredServices', Service::query()->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->get());
            }
            if (! array_key_exists('footerCities', $view->getData())) {
                $view->with('footerCities', \App\Models\City::query()->where('is_active', true)->orderBy('sort_order')->get());
            }
            if (! array_key_exists('footerPages', $view->getData())) {
                $view->with('footerPages', Page::query()->where('is_published', true)->orderBy('title')->get());
            }
            if (! array_key_exists('whatsappChatUrl', $view->getData())) {
                $view->with('whatsappChatUrl', WhatsAppLink::url(WhatsAppLink::chatMessage()));
            }
        });
    }
}
