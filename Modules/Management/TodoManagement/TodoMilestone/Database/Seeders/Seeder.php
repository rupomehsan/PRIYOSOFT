<?php
namespace Modules\Management\TodoManagement\TodoMilestone\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoMilestone\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\TodoManagement\TodoMilestone\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'title' => $faker->text(300),
                'phase' => $faker->text(100),
                'target_date' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'achieved_date' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'status' => $faker->randomElement(array (
  0 => 'upcoming',
  1 => 'achieved',
  2 => 'missed',
)),
                'note' => $faker->paragraph,
                'sort_order' => $faker->randomNumber(5),
            ]);
        }
    }
}