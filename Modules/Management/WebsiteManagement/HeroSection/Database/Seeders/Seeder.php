<?php
namespace Modules\Management\WebsiteManagement\HeroSection\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\HeroSection\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\HeroSection\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $slides = [
            [
                'badge_text'             => '🚀 Our First Product — Now Live!',
                'headline'               => 'Single Page. Multi Product. Built for Sales.',
                'subheadline'            => 'PHP · Laravel · Vue.js · MySQL — works on every device',
                'description'            => 'PFC lets customers order from your website or directly via WhatsApp Messenger. Track every order in real time, manage products and content dynamically — all from a creative admin dashboard. Built with Laravel, Vue.js &amp; MySQL. Works on every device.',
                'primary_button_text'    => 'Visit PFC Live',
                'primary_button_url'     => 'https://pfc.priyosoftware.com/',
                'secondary_button_text'  => 'Book a Free Demo',
                'secondary_button_url'   => '#newsletter',
                'media_type'             => 'image',
                'background_image'       => 'default.png',
                'hero_image'             => 'uploads/WebsiteManagement/HeroSection/2026-06-16-16065020061.jpg',
                'video_url'              => null,
                'is_active'              => 1,
                'status'                 => 'active',
            ],
            [
                'badge_text'             => '🛒 Ecommerce Solutions',
                'headline'               => 'Launch Your Online Store & Sell More — Faster',
                'subheadline'            => 'Single-page ecommerce platforms built for conversion',
                'description'            => 'From multi-product marketplaces to high-converting single-product landing pages — we build blazing-fast, mobile-first ecommerce solutions that turn visitors into buyers. No page reloads. No friction. Just sales.',
                'primary_button_text'    => 'Explore Ecommerce Products',
                'primary_button_url'     => '#products',
                'secondary_button_text'  => 'Book a Free Demo',
                'secondary_button_url'   => '#newsletter',
                'media_type'             => 'image',
                'background_image'       => 'default.png',
                'hero_image'             => 'default.png',
                'video_url'              => null,
                'is_active'              => 1,
                'status'                 => 'active',
            ],
            [
                'badge_text'             => '📦 Inventory & Warehouse Management',
                'headline'               => 'Take Full Control of Your Stock, Anywhere',
                'subheadline'            => 'Smart inventory systems for modern warehouses',
                'description'            => 'Real-time stock tracking, barcode scanning, multi-warehouse support, AI demand forecasting, and automated reorder alerts — all in one powerful platform. Built for manufacturers, distributors, and retailers who mean business.',
                'primary_button_text'    => 'View Inventory Suite',
                'primary_button_url'     => '#products',
                'secondary_button_text'  => 'Schedule a Demo',
                'secondary_button_url'   => '#newsletter',
                'media_type'             => 'image',
                'background_image'       => 'default.png',
                'hero_image'             => 'default.png',
                'video_url'              => null,
                'is_active'              => 1,
                'status'                 => 'active',
            ],
            [
                'badge_text'             => '🏢 Business Profile & Portfolio',
                'headline'               => 'Build a Brand Presence That Wins Clients',
                'subheadline'            => 'Professional websites, portfolios & brand tools',
                'description'            => 'From company websites and freelancer portfolios to agency showcases and digital brand identity managers — we craft stunning online presences that establish credibility, attract leads, and grow your business.',
                'primary_button_text'    => 'Explore Portfolio Products',
                'primary_button_url'     => '#products',
                'secondary_button_text'  => 'Get Started Today',
                'secondary_button_url'   => '#newsletter',
                'media_type'             => 'image',
                'background_image'       => 'default.png',
                'hero_image'             => 'default.png',
                'video_url'              => null,
                'is_active'              => 1,
                'status'                 => 'active',
            ],
        ];

        foreach ($slides as $slide) {
            self::$model::create($slide);
        }
    }
}
