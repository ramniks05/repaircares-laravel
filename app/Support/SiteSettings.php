<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SiteSettings
{
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = Cache::remember('site_settings', 3600, function () {
            return Setting::query()->pluck('value', 'key')->all();
        });

        return $all[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    public static function all(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            return Setting::query()->pluck('value', 'key')->all();
        });
    }

    public static function flush(): void
    {
        Cache::forget('site_settings');
    }
}
