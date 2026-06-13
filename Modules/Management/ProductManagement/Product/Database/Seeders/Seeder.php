<?php
namespace Modules\Management\ProductManagement\Product\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\ProductManagement\Product\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\ProductManagement\Product\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'product_group_id' => $faker->randomNumber(8),
                'name' => $faker->text(200),
                'slug' => $faker->text(200),
                'description' => $faker->paragraph,
                'status' => $faker->randomElement(array (
  0 => 'planning',
  1 => 'development',
  2 => 'active',
  3 => 'paused',
)),
                'launch_date' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'monthly_target_revenue' => $faker->randomFloat(2, 0, 1000),
                'features' => json_encode([$faker->word, $faker->word]),
                'screenshots' => $faker->word,
            ]);
        }
    }
}