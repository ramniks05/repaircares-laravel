<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\StatCounter;
use App\Models\TimeSlot;
use App\Models\User;
use App\Models\WorkStep;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@techrepair.local'],
            [
                'name' => 'Site Admin',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $settings = [
            'site_name' => 'Repair Cares',
            'site_tagline' => 'Professional repair service in Greater Noida West — we fix it right, the first time.',
            'brand_red' => 'Repair',
            'brand_black' => 'Care',
            'brand_line2' => 'Cares.com',
            'logo_path' => 'assets/images/repair-care-logo.jpg',
            'hero_banner' => 'assets/images/repaircares-hero-ac.jpg',
            'region_label' => 'Greater Noida West',
            'helpline' => '+91 7210102008',
            'whatsapp' => '917210102008',
            'contact_email' => 'info@repaircares.com',
            'service_hours' => 'Mon–Sat: 9:00 AM – 8:00 PM · Sun: 10:00 AM – 6:00 PM · Emergency on request',
            'hero_title' => 'Fast & Reliable Repair Service',
            'hero_subtitle' => 'Greater Noida West',
            'services_intro' => 'Expert doorstep appliance repair — AC, refrigerator, washing machine, RO, geyser, microwave, chimney, TV, and more. Same-day service within ~10 km of Greater Noida West.',
            'featured_intro' => 'Most booked repair services near you',
            'gallery_intro' => 'Real jobs completed by our certified technicians across Greater Noida West and nearby sectors.',
            'steps_intro' => 'Book in minutes — we respond within 30 minutes during business hours.',
            'why_intro' => 'Trusted local repair with transparent pricing and quality spare parts.',
            'amc_title' => 'Annual Maintenance Contracts (AMC)',
            'amc_description' => 'Seasonal servicing, priority visits, and savings on spare parts for AC, RO, fridge & washing machines in Greater Noida West.',
            'amc_button_text' => 'Inquire AMC Plans',
            'network_title' => 'Verified Technicians — Greater Noida West',
            'network_description' => 'RepairCares connects you with background-verified appliance technicians, plumbers, and electricians serving Noida Extension and surrounding areas.',
            'footer_about' => 'RepairCares.com offers professional home appliance repair in Greater Noida West. Expert technicians, fair pricing, and same-day doorstep service when you need it most.',
            'head_offices' => 'Shop No k4 Galaxy Shoppe, Opposite of 11th avenu, Greater Noida West, Noida West 201301',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        SiteSettings::flush();

        foreach (['Greater Noida West', 'Noida Extension', 'Noida', 'Ghaziabad', 'Delhi NCR'] as $i => $city) {
            City::query()->updateOrCreate(
                ['slug' => Str::slug($city)],
                ['name' => $city, 'is_active' => true, 'sort_order' => $i]
            );
        }

        foreach ([
            '09:00 AM - 12:00 PM',
            '12:00 PM - 03:00 PM',
            '03:00 PM - 06:00 PM',
            '06:00 PM - 09:00 PM',
        ] as $i => $slot) {
            TimeSlot::query()->updateOrCreate(
                ['label' => $slot],
                ['is_active' => true, 'sort_order' => $i]
            );
        }

        $categories = [
            'Appliance Repair' => 'appliance-repair',
            'Home Maintenance' => 'home-maintenance',
            'Interior & Decor' => 'interior-decor',
        ];

        foreach ($categories as $name => $slug) {
            ServiceCategory::query()->updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $appliance = ServiceCategory::where('slug', 'appliance-repair')->first();
        $home = ServiceCategory::where('slug', 'home-maintenance')->first();
        $interior = ServiceCategory::where('slug', 'interior-decor')->first();

        // image = Repair Cares detail; listing_image = subject / product catalog art
        $services = [
            ['AC Repair', 'ac-repair', $appliance->id, 374, 299, 4.8, 'assets/images/repaircares-listing-ac.jpg', 'assets/images/cat_ac.jpg'],
            ['Gas Stove', 'gas-stove', $home->id, 249, 199, 4.9, 'assets/images/repaircares-listing-gas-stove.jpg', 'assets/images/148509.png'],
            ['Refrigerator', 'refrigerator', $appliance->id, 311, 249, 4.8, 'assets/images/repaircares-listing-refrigerator.jpg', 'assets/images/148372.png'],
            ['Washing Machine', 'washing-machine', $appliance->id, 311, 249, 4.8, 'assets/images/repaircares-listing-washing-machine.jpg', 'assets/images/148373.png'],
            ['Geyser Repair', 'geyser-repair', $appliance->id, 311, 249, 4.9, 'assets/images/repaircares-listing-geyser.jpg', 'assets/images/148374.png'],
            ['Kitchen Chimney', 'kitchen-chimney', $home->id, 499, 399, 4.8, 'assets/images/repaircares-listing-chimney.jpg', 'assets/images/cat_chimney.jpg'],
            ['Dishwasher', 'dishwasher', $appliance->id, 374, 299, 4.7, 'assets/images/repaircares-listing-dishwasher.jpg', 'assets/images/148381.png'],
            ['Cook Range', 'cook-range', $home->id, 436, 349, 4.8, 'assets/images/repaircares-listing-cook-range.jpg', 'assets/images/148382.png'],
            ['RO Water Purifier', 'ro-water-purifier', $home->id, 249, 199, 4.9, 'assets/images/repaircares-listing-ro.jpg', 'assets/images/148383.png'],
            ['Microwave Oven', 'microwave-oven', $appliance->id, 311, 249, 4.8, 'assets/images/repaircares-listing-microwave.jpg', 'assets/images/148395.png'],
            ['LED TV Repair', 'led-tv-repair', $appliance->id, 374, 299, 4.8, 'assets/images/repaircares-listing-led-tv.jpg', 'assets/images/148414.png'],
            ['Sofa Wash & Repair', 'sofa-wash-repair', $interior->id, 624, 499, 4.9, 'assets/images/repaircares-listing-sofa.jpg', 'assets/images/148431.png'],
            ['Wall Louver Panel', 'wall-louver-panel', $interior->id, 186, 149, 4.9, 'assets/images/repaircares-listing-louver.jpg', 'assets/images/148484.png'],
            ['Customized Wallpaper', 'customized-wallpaper', $interior->id, 44, 35, 4.9, 'assets/images/repaircares-listing-wallpaper.jpg', 'assets/images/148485.png'],
            ['Aluminium & Glass', 'aluminium-glass', $interior->id, 225, 180, 4.8, 'assets/images/repaircares-listing-louver.jpg', 'assets/images/cat_aluminium_glass.jpg'],
            ['Electrician', 'electrician', $home->id, 124, 99, 4.9, 'assets/images/repaircares-listing-electrician.jpg', 'assets/images/repaircares-subject-electrician.jpg'],
            ['Carpenter', 'carpenter', $home->id, 186, 149, 4.8, 'assets/images/repaircares-listing-carpenter.jpg', 'assets/images/repaircares-subject-carpenter.jpg'],
            ['Plumber', 'plumber', $home->id, 186, 149, 4.9, 'assets/images/repaircares-listing-plumber.jpg', 'assets/images/repaircares-subject-plumber.jpg'],
            ['Interior Designer', 'interior-designer', $interior->id, 624, 499, 4.9, 'assets/images/repaircares-listing-interior.jpg', 'assets/images/repaircares-subject-interior.jpg'],
            ['Painter', 'painter', $interior->id, 15, 12, 4.9, 'assets/images/repaircares-listing-painter.jpg', 'assets/images/repaircares-subject-painter.jpg'],
        ];

        foreach ($services as $i => [$name, $slug, $catId, $orig, $sale, $rating, $image, $listingImage]) {
            $title = $name.' Repair & Service';
            Service::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'service_category_id' => $catId,
                    'name' => $name,
                    'short_description' => 'Professional '.$title.' at your doorstep in Delhi NCR with upfront pricing and 30-day warranty.',
                    'meta_description' => 'Book '.$title.' in Delhi NCR (Delhi, Gurgaon, Noida, Ghaziabad, Faridabad). Verified technicians, same-day slots & WhatsApp booking.',
                    'detail_content' => '<p>We provide reliable <strong>'.$title.'</strong> across Delhi NCR. Our certified technicians diagnose the issue on-site, share a clear quote before starting work, and use quality spare parts where required.</p>'
                        .'<ul><li>Doorstep visit in ~45 minutes (subject to slot availability)</li><li>Repair, maintenance & installation support</li><li>Upfront estimate — no hidden charges</li><li>30-day post-service warranty</li><li>Book instantly via WhatsApp</li></ul>',
                    'icon' => null,
                    'image' => $image,
                    'listing_image' => $listingImage,
                    'price_original' => $orig,
                    'price_sale' => $sale,
                    'rating' => $rating,
                    'duration_mins' => 45,
                    'warranty_days' => 30,
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
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

        $features = [
            ['Verified Technicians', '100% police-verified and background-checked technicians with 5+ years of certified brand experience.', 'Police Verified', 'Certified Techs', '🛡️'],
            ['Transparent Pricing', 'Upfront fixed rate cards with zero hidden fees. Clear quote before starting any repair work.', 'Upfront Quotes', 'Zero Hidden Fees', '💰'],
            ['30-Day Warranty', 'Complete post-service assurance with free revisit support and up to 90 days warranty on spare parts.', 'Free Revisit', 'Genuine Spare Parts', '✅'],
            ['45-Min Express Arrival', 'Rapid doorstep arrival across Delhi, Gurgaon, Noida, Ghaziabad & Faridabad within 45 minutes.', 'Same-Day Delivery', 'Express Booking', '⚡'],
            ['Hygiene & Safety First', 'Sanitized tools, protective gear, and complete post-service area cleanup after job completion.', 'Sanitized Kits', 'Post Cleanup', '🧼'],
            ['24/7 Customer Support', 'Dedicated phone & WhatsApp support desk for instant query resolution and appointment scheduling.', 'Instant Help', 'Dedicated Manager', '📞'],
        ];

        foreach ($features as $i => $row) {
            Feature::query()->updateOrCreate(
                ['title' => $row[0]],
                [
                    'description' => $row[1],
                    'badge_one' => $row[2],
                    'badge_two' => $row[3],
                    'icon' => $row[4],
                    'sort_order' => $i,
                ]
            );
        }

        $steps = [
            [1, 'Book Service', 'Select service online or call/WhatsApp us to book a time slot.'],
            [2, 'Doorstep Visit', 'Certified technician arrives in 45 minutes with safety tools.'],
            [3, 'Inspection & Quote', 'Technician diagnoses issue and provides upfront estimate.'],
            [4, 'Repair & Warranty', 'Instant repair with OEM parts & 30-day warranty guarantee.'],
        ];

        foreach ($steps as $i => [$num, $title, $desc]) {
            WorkStep::query()->updateOrCreate(
                ['step_number' => $num],
                ['title' => $title, 'description' => $desc, 'sort_order' => $i]
            );
        }

        $stats = [
            ['Certified Partners', '2,500', '+'],
            ['NCR Hubs', '50', '+'],
            ['Jobs Completed', '25k', '+'],
            ['Avg Rating', '4.9', ' ★'],
        ];

        foreach ($stats as $i => [$label, $value, $suffix]) {
            StatCounter::query()->updateOrCreate(
                ['label' => $label],
                ['value' => $value, 'suffix' => $suffix, 'sort_order' => $i]
            );
        }

        $pages = [
            ['About Us', 'about-us', 'Appliance Repair', '<p>We are Delhi NCR\'s trusted home service brand with verified technicians and transparent pricing.</p>'],
            ['Contact Us', 'contact-us', 'Quick Links', '<h2>Get in Touch</h2><p>Choose your preferred method — we help with all appliance repair needs in Greater Noida West.</p><ul><li><strong>Phone:</strong> <a href="tel:+917210102008">+91 7210102008</a></li><li><strong>WhatsApp:</strong> Chat with us instantly (same number)</li><li><strong>Email:</strong> <a href="mailto:info@repaircares.com">info@repaircares.com</a></li><li><strong>Service location:</strong> Shop No k4 Galaxy Shoppe, Opposite of 11th avenu, Greater Noida West, Noida West 201301</li><li><strong>Service area:</strong> Within ~10 km of Greater Noida West</li><li><strong>Hours:</strong> Monday–Saturday 9:00 AM – 8:00 PM; Sunday 10:00 AM – 6:00 PM. Emergency service on request.</li></ul><p>We respond to inquiries within 30 minutes during business hours. Same-day service available for urgent repairs.</p>'],
            ['Privacy Policy', 'privacy-policy', 'Quick Links', '<p>Your privacy matters. We only use contact details to schedule and deliver services.</p>'],
            ['Terms & Conditions', 'terms-and-conditions', 'Quick Links', '<p>Standard service terms apply. Quotes are shared before work begins.</p>'],
            ['Refund Policy', 'refund-policy', 'Quick Links', '<p>Refunds are processed as per inspection and service completion policy.</p>'],
            ['Cancellation Policy', 'cancellation-policy', 'Quick Links', '<p>Free cancellation up to 2 hours before scheduled slot where applicable.</p>'],
            ['Disclaimer', 'disclaimer', 'Quick Links', '<p>Brand names are used for descriptive purposes only.</p>'],
        ];

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

        HeroSlide::query()
            ->whereIn('image', [
                'assets/images/banner_wooden_wor.png',
                'assets/images/banner_gas_hob.png',
                'assets/images/hero_banner1.png',
            ])
            ->update(['is_active' => false]);

        HeroSlide::query()
            ->where('sort_order', '>=', count($heroBanners))
            ->update(['is_active' => false]);

        foreach ($pages as [$title, $slug, $section, $content]) {
            Page::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => $content,
                    'footer_section' => $section,
                    'is_published' => true,
                ]
            );
        }
    }
}
