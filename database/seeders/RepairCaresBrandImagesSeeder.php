<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Service;
use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;

/**
 * Swaps OneClick technician stock photos for Repair Cares AI images.
 * Run: php artisan db:seed --class=RepairCaresBrandImagesSeeder --force
 */
class RepairCaresBrandImagesSeeder extends Seeder
{
    public function run(): void
    {
        $legacyTechnicianImages = [
            'assets/images/hero_banner1.png',
            'assets/images/img_1791318841_1907.png',
            'assets/images/img_1791320117_4548.png',
            'assets/images/img_1791318774_5011.png',
            'assets/images/ac_repair.jpg',
            'assets/images/148372.png', 'assets/images/148373.png', 'assets/images/148374.png',
            'assets/images/148381.png', 'assets/images/148382.png', 'assets/images/148383.png',
            'assets/images/148395.png', 'assets/images/148414.png', 'assets/images/148431.png',
            'assets/images/148484.png', 'assets/images/148485.png', 'assets/images/148502.png',
            'assets/images/148503.png', 'assets/images/148504.png', 'assets/images/148509.png',
            'assets/images/cat_ac.jpg', 'assets/images/cat_chimney.jpg', 'assets/images/cat_electrician.png',
            'assets/images/cat_plumbe.png',
        ];

        HeroSlide::query()->whereIn('image', $legacyTechnicianImages)->update(['is_active' => false]);

        $serviceImages = [
            'ac-repair' => 'assets/images/repaircares-listing-ac.jpg',
            'gas-stove' => 'assets/images/repaircares-listing-gas-stove.jpg',
            'refrigerator' => 'assets/images/repaircares-listing-refrigerator.jpg',
            'washing-machine' => 'assets/images/repaircares-listing-washing-machine.jpg',
            'geyser-repair' => 'assets/images/repaircares-listing-geyser.jpg',
            'kitchen-chimney' => 'assets/images/repaircares-listing-chimney.jpg',
            'dishwasher' => 'assets/images/repaircares-listing-dishwasher.jpg',
            'cook-range' => 'assets/images/repaircares-listing-cook-range.jpg',
            'ro-water-purifier' => 'assets/images/repaircares-listing-ro.jpg',
            'microwave-oven' => 'assets/images/repaircares-listing-microwave.jpg',
            'led-tv-repair' => 'assets/images/repaircares-listing-led-tv.jpg',
            'sofa-wash-repair' => 'assets/images/repaircares-listing-sofa.jpg',
            'wall-louver-panel' => 'assets/images/repaircares-listing-louver.jpg',
            'customized-wallpaper' => 'assets/images/repaircares-listing-wallpaper.jpg',
            'aluminium-glass' => 'assets/images/repaircares-listing-louver.jpg',
            'electrician' => 'assets/images/repaircares-listing-electrician.jpg',
            'carpenter' => 'assets/images/repaircares-listing-carpenter.jpg',
            'plumber' => 'assets/images/repaircares-listing-plumber.jpg',
            'interior-designer' => 'assets/images/repaircares-listing-interior.jpg',
            'painter' => 'assets/images/repaircares-listing-painter.jpg',
        ];

        foreach ($serviceImages as $slug => $path) {
            Service::query()->where('slug', $slug)->update([
                'image' => $path,
                'listing_image' => $path,
            ]);
        }

        $gallery = [
            ['High-Pressure Foam Jet AC Washing', 'Jet Wash', 'assets/images/repaircares-hero-ac.jpg'],
            ['Double Door Fridge Gas Refilling', 'Gas Charging', 'assets/images/repaircares-gallery-fridge.jpg'],
            ['Front Load Washing Machine Repair', 'Drum Service', 'assets/images/repaircares-gallery-washer.jpg'],
            ['Sofa Cleaning Service', 'Sofa Service', 'assets/images/repaircares-listing-sofa.jpg'],
            ['Front Load Drum & Bearing Repair', 'Drum Repair', 'assets/images/repaircares-listing-washing-machine.jpg'],
            ['RO Service Kit & Filter Change', 'Filter Swap', 'assets/images/repaircares-listing-ro.jpg'],
            ['Smart TV Wall Bracket Mounting', 'Wall Mount', 'assets/images/repaircares-listing-led-tv.jpg'],
            ['WPC Louver Panel Accent Wall', 'WPC Louver', 'assets/images/repaircares-listing-louver.jpg'],
        ];

        foreach ($gallery as $i => [$title, $subtitle, $image]) {
            GalleryItem::query()->updateOrCreate(
                ['title' => $title],
                ['subtitle' => $subtitle, 'image' => $image, 'is_active' => true, 'sort_order' => $i]
            );
        }

        $heroBanners = [
            ['assets/images/repaircares-hero-ac.jpg', 'Repair Cares — AC repair Greater Noida West'],
            ['assets/images/repaircares-listing-refrigerator.jpg', 'Refrigerator repair and gas refilling'],
            ['assets/images/repaircares-listing-washing-machine.jpg', 'Washing machine repair service'],
            ['assets/images/repaircares-listing-ro.jpg', 'RO water purifier service'],
            ['assets/images/repaircares-listing-geyser.jpg', 'Geyser repair and installation'],
            ['assets/images/repaircares-listing-gas-stove.jpg', 'Gas stove and hob repair'],
            ['assets/images/repaircares-listing-chimney.jpg', 'Chimney cleaning and repair'],
            ['assets/images/repaircares-listing-led-tv.jpg', 'LED TV repair and wall mount'],
            ['assets/images/repaircares-listing-sofa.jpg', 'Sofa wash and deep cleaning'],
            ['assets/images/repaircares-listing-wallpaper.jpg', 'Custom wallpaper installation'],
        ];

        foreach ($heroBanners as $i => [$image, $alt]) {
            HeroSlide::query()->updateOrCreate(
                ['sort_order' => $i],
                [
                    'image' => $image,
                    'alt_text' => $alt,
                    'is_active' => true,
                ]
            );
        }

        Setting::query()->updateOrCreate(
            ['key' => 'hero_banner'],
            ['value' => 'assets/images/repaircares-hero-ac.jpg']
        );
        SiteSettings::flush();
    }
}
