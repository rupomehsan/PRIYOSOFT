<?php
namespace Modules\Management\WebsiteManagement\AboutUs\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\AboutUs\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\AboutUs\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $entries = [

          
            // ── Mission (1 record) ────────────────────────────────────────
            [
                'section'     => 'mission',
                'title'       => 'Our Mission',
                'description' => 'We craft affordable, scalable, and beautifully engineered software that equips businesses of every size — from ambitious solo founders to growing enterprise teams — with the digital firepower they need to outpace the competition and thrive in a fast-moving global market.',
                'icon'        => 'fas fa-crosshairs',
                'image'       => 'default.png',
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 2,
                'is_visible'  => 1,
                'status'      => 'active',
            ],

            // ── Vision (1 record) ─────────────────────────────────────────
            [
                'section'     => 'vision',
                'title'       => 'Our Vision',
                'description' => 'To be the most trusted technology partner in South Asia — recognised not merely for the software we ship, but for the enduring client relationships we nurture, the real problems we solve, and the businesses we help reach their full potential.',
                'icon'        => 'fas fa-binoculars',
                'image'       => 'default.png',
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 3,
                'is_visible'  => 1,
                'status'      => 'active',
            ],

            // ── Values (4 records) ────────────────────────────────────────
            [
                'section'     => 'value',
                'title'       => 'Fast Delivery',
                'description' => 'Timelines are commitments, not estimates. We run tight agile sprints, maintain clear communication at every milestone, and consistently deliver production-ready releases — on or before the agreed date, without ever compromising on quality.',
                'icon'        => 'fas fa-shipping-fast',
                'image'       => 'default.png',
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 4,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'value',
                'title'       => 'Reliable Code',
                'description' => 'Every line we write is purposeful, peer-reviewed, and backed by automated tests. We follow SOLID principles, enforce strict coding standards, and architect systems that are easy to extend, maintain, and scale — because your codebase is a long-term asset.',
                'icon'        => 'fas fa-code-branch',
                'image'       => 'default.png',
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 5,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'value',
                'title'       => 'Client-Focused',
                'description' => 'We treat every project as a partnership, not a transaction. From the first discovery call to post-launch support, we listen deeply, communicate proactively, and make decisions that genuinely serve your business goals — your success is the only metric that matters.',
                'icon'        => 'fas fa-handshake',
                'image'       => 'default.png',
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 6,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'value',
                'title'       => 'Innovation',
                'description' => 'The tech landscape never stands still, and neither do we. We continuously evaluate emerging tools, frameworks, and best practices — adopting what adds real value — so the solutions we build today remain performant, secure, and competitive well into the future.',
                'icon'        => 'fas fa-flask',
                'image'       => 'default.png',
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 7,
                'is_visible'  => 1,
                'status'      => 'active',
            ],

            // ── Stats (4 records — shown in StatsSection) ─────────────────
            [
                'section'     => 'stat',
                'title'       => 'Projects Delivered',
                'description' => 'Successful projects shipped across ecommerce, inventory, and business profile domains.',
                'icon'        => 'fas fa-rocket',
                'image'       => 'default.png',
                'stat_value'  => '50+',
                'stat_label'  => 'Projects Delivered',
                'sort_order'  => 8,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'stat',
                'title'       => 'Happy Clients',
                'description' => 'Businesses across Bangladesh, UK, UAE, and USA who trust PriyoSoft with their digital products.',
                'icon'        => 'fas fa-users',
                'image'       => 'default.png',
                'stat_value'  => '30+',
                'stat_label'  => 'Happy Clients',
                'sort_order'  => 9,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'stat',
                'title'       => 'Years Experience',
                'description' => 'Building production-grade software with Laravel and Vue.js since 2016.',
                'icon'        => 'fas fa-calendar-check',
                'image'       => 'default.png',
                'stat_value'  => '8+',
                'stat_label'  => 'Years Experience',
                'sort_order'  => 10,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'stat',
                'title'       => 'Client Satisfaction',
                'description' => 'Average satisfaction score across all post-project client surveys.',
                'icon'        => 'fas fa-star',
                'image'       => 'default.png',
                'stat_value'  => '99%',
                'stat_label'  => 'Client Satisfaction',
                'sort_order'  => 11,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
        ];

        foreach ($entries as $entry) {
            self::$model::create($entry);
        }
    }
}
