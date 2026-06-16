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

            // ── Story (1 record) ──────────────────────────────────────────
            [
                'section'     => 'story',
                'title'       => 'Crafting Digital Excellence Since 2016',
                'description' => 'PriyoSoft was founded with a single conviction: great software should empower businesses, not complicate them. Over the past 8+ years we have partnered with startups, SMEs, and enterprises across Bangladesh and beyond — delivering ecommerce platforms, inventory systems, and business profile solutions that drive real, measurable results. We build with Laravel, Vue.js, and a relentless obsession for clean code and great UX.',
                'icon'        => 'fas fa-book-open',
                'image'       => null,
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 1,
                'is_visible'  => 1,
                'status'      => 'active',
            ],

            // ── Mission (1 record) ────────────────────────────────────────
            [
                'section'     => 'mission',
                'title'       => 'Our Mission',
                'description' => 'To build affordable, scalable, and beautifully designed software that gives every business — from solo founders to enterprise teams — the digital tools they need to compete and win in a global market.',
                'icon'        => 'fas fa-bullseye',
                'image'       => null,
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
                'description' => 'To become the most trusted software company in South Asia — known not just for the products we build, but for the lasting partnerships we form and the businesses we help grow.',
                'icon'        => 'fas fa-eye',
                'image'       => null,
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 3,
                'is_visible'  => 1,
                'status'      => 'active',
            ],

            // ── Values (3 records) ────────────────────────────────────────
            [
                'section'     => 'value',
                'title'       => 'Craftsmanship Over Speed',
                'description' => 'We write clean, maintainable code that is built to last — not just to ship. Every pull request goes through rigorous review because technical debt is real and we refuse to pass it on to our clients.',
                'icon'        => 'fas fa-gem',
                'image'       => null,
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 4,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'value',
                'title'       => 'Radical Transparency',
                'description' => 'No hidden costs, no silent blockers. We communicate early, often, and honestly — keeping clients informed at every stage from discovery to deployment.',
                'icon'        => 'fas fa-handshake',
                'image'       => null,
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 5,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'value',
                'title'       => 'Client Success First',
                'description' => 'Our engagement does not end at launch. We measure our success by the outcomes our clients achieve — and we stay invested long after the final invoice.',
                'icon'        => 'fas fa-trophy',
                'image'       => null,
                'stat_value'  => null,
                'stat_label'  => null,
                'sort_order'  => 6,
                'is_visible'  => 1,
                'status'      => 'active',
            ],

            // ── Stats (4 records — shown in StatsSection) ─────────────────
            [
                'section'     => 'stat',
                'title'       => 'Projects Delivered',
                'description' => 'Successful projects shipped across ecommerce, inventory, and business profile domains.',
                'icon'        => 'fas fa-rocket',
                'image'       => null,
                'stat_value'  => '50+',
                'stat_label'  => 'Projects Delivered',
                'sort_order'  => 7,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'stat',
                'title'       => 'Happy Clients',
                'description' => 'Businesses across Bangladesh, UK, UAE, and USA who trust PriyoSoft with their digital products.',
                'icon'        => 'fas fa-users',
                'image'       => null,
                'stat_value'  => '30+',
                'stat_label'  => 'Happy Clients',
                'sort_order'  => 8,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'stat',
                'title'       => 'Years Experience',
                'description' => 'Building production-grade software with Laravel and Vue.js since 2016.',
                'icon'        => 'fas fa-calendar-check',
                'image'       => null,
                'stat_value'  => '8+',
                'stat_label'  => 'Years Experience',
                'sort_order'  => 9,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
            [
                'section'     => 'stat',
                'title'       => 'Client Satisfaction',
                'description' => 'Average satisfaction score across all post-project client surveys.',
                'icon'        => 'fas fa-star',
                'image'       => null,
                'stat_value'  => '99%',
                'stat_label'  => 'Client Satisfaction',
                'sort_order'  => 10,
                'is_visible'  => 1,
                'status'      => 'active',
            ],
        ];

        foreach ($entries as $entry) {
            self::$model::create($entry);
        }
    }
}
