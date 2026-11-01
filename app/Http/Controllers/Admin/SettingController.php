<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /** @return array<string, string> */
    public static function labels(): array
    {
        return [
            'site_name' => 'Site Name',
            'brand_red' => 'Brand (red part)',
            'brand_black' => 'Brand (black part)',
            'brand_line2' => 'Brand line 2',
            'logo_path' => 'Logo path',
            'hero_banner' => 'Hero banner path',
            'site_tagline' => 'Tagline',
            'region_label' => 'Region Label',
            'helpline' => 'Helpline',
            'whatsapp' => 'WhatsApp Number',
            'contact_email' => 'Contact Email',
            'service_hours' => 'Service Hours',
            'hero_title' => 'Hero Title',
            'hero_subtitle' => 'Hero Subtitle',
            'services_intro' => 'Services Intro',
            'featured_intro' => 'Most Booked intro',
            'gallery_intro' => 'Gallery intro',
            'steps_intro' => 'How it works intro',
            'why_intro' => 'Why choose us intro',
            'amc_title' => 'AMC Title',
            'amc_description' => 'AMC Description',
            'amc_button_text' => 'AMC Button Text',
            'network_title' => 'Network Title',
            'network_description' => 'Network Description',
            'footer_about' => 'Footer About Text',
            'head_offices' => 'Head Offices',
        ];
    }

    public function index(): View
    {
        $settings = SiteSettings::all();
        $rows = [];
        foreach (self::labels() as $key => $label) {
            $rows[] = [
                'key' => $key,
                'label' => $label,
                'value' => (string) ($settings[$key] ?? ''),
            ];
        }

        return view('admin.settings.index', compact('rows'));
    }

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => SiteSettings::all(),
            'labels' => self::labels(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        foreach (array_keys(self::labels()) as $key) {
            if ($request->has($key)) {
                SiteSettings::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Site settings saved.');
    }
}
