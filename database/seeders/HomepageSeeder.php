<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use App\Models\HomepageSection;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default Settings
        Setting::setValue('site_name', 'Battery Shop', 'string', 'general', 'Site name displayed in header and footer');
        Setting::setValue('site_logo', null, 'image', 'general', 'Logo image for header and footer');
        Setting::setValue('contact_email', 'hello@batteryshop.com', 'string', 'contact', 'Contact email address');
        Setting::setValue('contact_phone', '1-800-BATTERY', 'string', 'contact', 'Contact phone number');
        Setting::setValue('contact_address', '123 Battery St, Power City, PC 12345', 'string', 'contact', 'Contact address');

        // Hero Slides
        HeroSlide::create([
            'title' => 'Power Your Journey with Confidence',
            'subtitle' => 'Premium batteries for every vehicle. Fast shipping, expert advice, and the best warranty in the industry.',
            'button_text' => 'Shop Batteries',
            'button_link' => '/products',
            'background_color' => '#1a1a2e',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        HeroSlide::create([
            'title' => 'Find Your Perfect Battery',
            'subtitle' => 'Use our smart battery finder to match the exact battery for your vehicle by make, model, and year.',
            'button_text' => 'Find My Battery',
            'button_link' => '/battery-finder',
            'background_color' => '#2d1b1b',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        HeroSlide::create([
            'title' => 'Top Brands, Best Prices',
            'subtitle' => 'Bosch, Varta, Exide, Banner, and more. Premium quality at competitive prices.',
            'button_text' => 'View All Brands',
            'button_link' => '/brands',
            'background_color' => '#1b2d1b',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Homepage Sections
        HomepageSection::create([
            'name' => 'hero',
            'title' => 'Hero Slider',
            'type' => 'hero',
            'content' => [
                'show_trust_indicators' => true,
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        HomepageSection::create([
            'name' => 'categories',
            'title' => 'Shop by Category',
            'type' => 'categories',
            'content' => [],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        HomepageSection::create([
            'name' => 'featured_products',
            'title' => 'Featured Products',
            'type' => 'products',
            'content' => [],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        HomepageSection::create([
            'name' => 'brands',
            'title' => 'Trusted Brands',
            'type' => 'brands',
            'content' => [],
            'is_active' => true,
            'sort_order' => 4,
        ]);

        HomepageSection::create([
            'name' => 'new_arrivals',
            'title' => 'New Arrivals',
            'type' => 'arrivals',
            'content' => [],
            'is_active' => true,
            'sort_order' => 5,
        ]);

        HomepageSection::create([
            'name' => 'cta',
            'title' => 'Call to Action',
            'type' => 'cta',
            'content' => [
                'description' => 'Use our battery finder to match the perfect battery for your vehicle by make, model, and year.',
                'button_text' => 'Start Battery Finder',
                'button_link' => '/battery-finder',
            ],
            'is_active' => true,
            'sort_order' => 6,
        ]);
    }
}