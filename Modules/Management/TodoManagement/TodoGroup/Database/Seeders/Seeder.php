<?php
namespace Modules\Management\TodoManagement\TodoGroup\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoGroup\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\TodoManagement\TodoGroup\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'name' => $faker->text(200),
                'phase' => $faker->text(100),
                'sort_order' => $faker->randomNumber(5),
                'status' => $faker->randomElement(array (
  0 => 'pending',
  1 => 'in_progress',
  2 => 'completed',
)),
            ]);
        }
    }
}