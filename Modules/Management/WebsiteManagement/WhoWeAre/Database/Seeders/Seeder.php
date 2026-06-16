<?php
namespace Modules\Management\WebsiteManagement\WhoWeAre\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\WhoWeAre\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\WhoWeAre\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        self::$model::create([
            'badge_label' => 'WHO WE ARE',
            'title'       => 'Crafting Digital Excellence Since 2016',
            'description' => 'PriyoSoft was founded with a single conviction: great software should empower businesses, not complicate them. Over the past 8+ years we have partnered with startups, SMEs, and enterprises across Bangladesh and beyond — delivering ecommerce platforms, inventory systems, and business profile solutions that drive real, measurable results. We build with Laravel, Vue.js, and a relentless obsession for clean code and great UX.',
            'image'       => null,
            'features'    => [
                ['icon' => 'fas fa-rocket',     'title' => 'Fast Delivery',    'description' => 'We ship on time, every time.'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Reliable Code',    'description' => 'Clean, tested, maintainable.'],
                ['icon' => 'fas fa-users',      'title' => 'Client-Focused',   'description' => 'Your success is our goal.'],
                ['icon' => 'fas fa-lightbulb',  'title' => 'Innovation',       'description' => 'Always evolving our stack.'],
            ],
            'stats' => [
                ['stat_value' => '50+',  'stat_label' => 'Projects Delivered'],
                ['stat_value' => '30+',  'stat_label' => 'Happy Clients'],
                ['stat_value' => '8+',   'stat_label' => 'Years of Craft'],
                ['stat_value' => '99%',  'stat_label' => 'Client Satisfaction'],
            ],
            'sort_order' => 1,
            'is_visible'  => 1,
            'status'      => 'active',
        ]);
    }
}
