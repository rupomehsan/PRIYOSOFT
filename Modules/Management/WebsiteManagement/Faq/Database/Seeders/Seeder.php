<?php
namespace Modules\Management\WebsiteManagement\Faq\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\Faq\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\Faq\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'product_id' => $faker->randomNumber(8),
                'question' => $faker->text(500),
                'answer' => $faker->paragraph,
                'sort_order' => $faker->randomNumber(5),
                'is_visible' => $faker->boolean,
            ]);
        }
    }
}