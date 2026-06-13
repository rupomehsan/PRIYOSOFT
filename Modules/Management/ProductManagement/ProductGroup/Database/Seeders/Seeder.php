<?php
namespace Modules\Management\ProductManagement\ProductGroup\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\ProductManagement\ProductGroup\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\ProductManagement\ProductGroup\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'name' => $faker->text(200),
                'description' => $faker->paragraph,
                'icon' => $faker->text(200),
                'sort_order' => $faker->randomNumber(5),
                'is_active' => $faker->boolean,
            ]);
        }
    }
}