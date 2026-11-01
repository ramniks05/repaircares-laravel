<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Service;
use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;

/**
 * Two image roles per service:
 * - `listing_image` — subject / product art for grids & cards (Our Services, Most Booked)
 * - `image` — Repair Cares technician photo for detail hero & rate card
 *
 * Run: php artisan db:seed --class=RepairCaresBrandImagesSeeder --force
 */
class RepairCaresBrandImagesSeeder extends Seeder
{
    /** @return array<string, string> slug => detail hero image */
    private function detailImages(): array
    {
        return [
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
    }

    /** @return array<string, string> slug => subject / catalog image (appliance, icon — not “at work” photo) */
    private function subjectCatalogImages(): array
    {
        return [
            'ac-repair' => 'assets/images/cat_ac.jpg',
            'gas-stove' => 'assets/images/148509.png',
            'refrigerator' => 'assets/images/148372.png',
            'washing-machine' => 'assets/images/148373.png',
            'geyser-repair' => 'assets/images/148374.png',
            'kitchen-chimney' => 'assets/images/cat_chimney.jpg',
            'dishwasher' => 'assets/images/148381.png',
            'cook-range' => 'assets/images/148382.png',
            'ro-water-purifier' => 'assets/images/148383.png',
            'microwave-oven' => 'assets/images/148395.png',
            'led-tv-repair' => 'assets/images/148414.png',
            'sofa-wash-repair' => 'assets/images/148431.png',
            'wall-louver-panel' => 'assets/images/148484.png',
            'customized-wallpaper' => 'assets/images/148485.png',
            'aluminium-glass' => 'assets/images/cat_aluminium_glass.jpg',
            'electrician' => 'assets/images/repaircares-subject-electrician.jpg',
            'carpenter' => 'assets/images/repaircares-subject-carpenter.jpg',
            'plumber' => 'assets/images/repaircares-subject-plumber.jpg',
            'interior-designer' => 'assets/images/repaircares-subject-interior.jpg',
            'painter' => 'assets/images/repaircares-subject-painter.jpg',
        ];
    }

    public function run(): void
    {
        $detailImages = $this->detailImages();
        $subjectImages = $this->subjectCatalogImages();

        foreach ($detailImages as $slug => $detailPath) {
            Service::query()->where('slug', $slug)->update([
                'image' => $detailPath,
                'listing_image' => $subjectImages[$slug] ?? $detailPath,
            ]);
        }

        $this->syncServiceImageRoles($detailImages, $subjectImages);

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

        $this->retireLegacyHeroSlides(count($heroBanners));
        $this->purgeLegacyImportMedia();
        $this->ensureRepairCaresSiteBranding();

        SiteSettings::flush();
    }

    private function ensureRepairCaresSiteBranding(): void
    {
        foreach ([
            'site_name' => 'Repair Cares',
            'brand_red' => 'Repair',
            'brand_black' => 'Care',
            'brand_line2' => 'Cares.com',
            'logo_path' => 'assets/images/repair-cares-logo.jpg',
            'hero_banner' => 'assets/images/repaircares-hero-ac.jpg',
        ] as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    /** @return list<string> basename fragments for old import assets that must not appear on the site */
    private function legacyImportAssetBasenames(): array
    {
        return [
            'hero_banner1.png',
            'banner_wooden_wor.png',
            'banner_gas_hob.png',
            'logo.jpg',
            'ac_repair.jpg',
            'refrigerator.png',
            'washing_machine.jpg',
            'geysers.png',
            'dishwasher.jpg',
            'cook_range.jpg',
            'microwave.jpg',
            'led_tv.jpg',
            'sofa_wash.jpg',
            'carpenter.jpg',
            'interior_designer.jpg',
            'painter.jpg',
            'aluminium_glass.jpg',
            'cat_electrician.png',
            'cat_plumbe.png',
            '148502.png',
            '148503.png',
            '148504.png',
            'img_1791318841_1907.png',
            'img_1791320117_4548.png',
            'img_1791318774_5011.png',
        ];
    }

    private function pathUsesLegacyImportAsset(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        foreach ($this->legacyImportAssetBasenames() as $basename) {
            if (str_contains($path, $basename)) {
                return true;
            }
        }

        return false;
    }

    private function purgeLegacyImportMedia(): void
    {
        $detailImages = $this->detailImages();
        $subjectImages = $this->subjectCatalogImages();
        $detailFallback = 'assets/images/repaircares-hero-ac.jpg';

        Service::query()->each(function (Service $service) use ($detailImages, $subjectImages, $detailFallback): void {
            $updates = [];
            if ($this->pathUsesLegacyImportAsset($service->image)) {
                $updates['image'] = $detailImages[$service->slug] ?? $detailFallback;
            }
            if ($this->pathUsesLegacyImportAsset($service->listing_image)) {
                $updates['listing_image'] = $subjectImages[$service->slug] ?? ($detailImages[$service->slug] ?? $detailFallback);
            }
            if ($updates !== []) {
                $service->update($updates);
            }
        });

        foreach ($this->legacyImportAssetBasenames() as $basename) {
            GalleryItem::query()
                ->where('image', 'like', '%'.$basename)
                ->update(['is_active' => false]);

            HeroSlide::query()
                ->where('image', 'like', '%'.$basename)
                ->update(['is_active' => false]);
        }
    }

    /**
     * @param  array<string, string>  $detailImages
     * @param  array<string, string>  $subjectImages
     */
    private function syncServiceImageRoles(array $detailImages, array $subjectImages): void
    {
        $detailFallback = 'assets/images/repaircares-hero-ac.jpg';

        Service::query()->orderBy('id')->each(function (Service $service) use ($detailImages, $subjectImages, $detailFallback): void {
            $detail = $detailImages[$service->slug] ?? $detailFallback;
            $subject = $subjectImages[$service->slug] ?? $detail;
            $updates = [];

            $imagePath = (string) $service->image;
            if ($imagePath === '' || ! str_contains($imagePath, 'repaircares') || $this->isBannedDetailAsset($imagePath)) {
                $updates['image'] = $detail;
            }

            $listingPath = (string) $service->listing_image;
            if ($listingPath === '' || $this->isBannedCatalogAsset($listingPath)) {
                $updates['listing_image'] = $subject;
            }

            if ($updates !== []) {
                $service->update($updates);
            }
        });
    }

    /** Technician/detail shots must not be used as catalog tiles. */
    private function isBannedCatalogAsset(string $path): bool
    {
        if ($this->pathUsesLegacyImportAsset($path)) {
            return true;
        }

        return str_contains($path, 'repaircares-listing')
            || str_contains($path, 'repaircares-hero')
            || str_contains($path, 'repaircares-gallery');
    }

    /** Old import banners must not be detail heroes. */
    private function isBannedDetailAsset(string $path): bool
    {
        return $this->pathUsesLegacyImportAsset($path);
    }

    /** Deactivate hero slides that still point at old import art or extra sort slots. */
    private function retireLegacyHeroSlides(int $canonicalCount): void
    {
        foreach ($this->legacyImportAssetBasenames() as $basename) {
            HeroSlide::query()
                ->where('image', 'like', '%'.$basename)
                ->update(['is_active' => false]);
        }

        HeroSlide::query()
            ->where('sort_order', '>=', $canonicalCount)
            ->update(['is_active' => false]);
    }
}
