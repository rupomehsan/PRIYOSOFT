<?php
namespace Modules\Management\TodoManagement\TodoList\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoList\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\TodoManagement\TodoList\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'todo_group_id' => $faker->randomNumber(8),
                'title' => $faker->text(400),
                'assigned_to' => $faker->text(100),
                'estimated_days' => $faker->randomFloat(2, 0, 1000),
                'daily_rate' => $faker->randomFloat(2, 0, 1000),
                'fixed_cost' => $faker->randomFloat(2, 0, 1000),
                'item_cost' => $faker->randomFloat(2, 0, 1000),
                'is_recurring' => $faker->boolean,
                'priority' => $faker->randomElement(array (
  0 => 'critical',
  1 => 'high',
  2 => 'medium',
  3 => 'low',
)),
                'status' => $faker->randomElement(array (
  0 => 'pending',
  1 => 'in_progress',
  2 => 'completed',
  3 => 'skipped',
)),
                'completed_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'note' => $faker->paragraph,
                'sort_order' => $faker->randomNumber(5),
            ]);
        }
    }
}