<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Support\SiteSettings;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('pages.show', [
            'page' => $page,
            'site' => SiteSettings::all(),
        ]);
    }
}
