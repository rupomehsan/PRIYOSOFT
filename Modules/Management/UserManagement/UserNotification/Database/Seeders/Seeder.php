<?php
namespace Modules\Management\UserManagement\UserNotification\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\UserManagement\UserNotification\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\UserManagement\UserNotification\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'user_id' => $faker->randomNumber(8),
                'topic' => $faker->text(100),
                'description' => $faker->paragraph,
                'to_all' => $faker->boolean,
                'seen' => $faker->boolean,
            ]);
        }
    }
}