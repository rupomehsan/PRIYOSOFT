<?php
namespace Modules\Management\WebsiteManagement\SiteSection\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\SiteSection\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\SiteSection\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'section' => $faker->text(100),
                'key' => $faker->text(150),
                'value' => $faker->paragraph,
                'sort_order' => $faker->randomNumber(5),
            ]);
        }
    }
}