<?php
namespace Modules\Management\WebsiteManagement\Subscriber\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\Subscriber\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\Subscriber\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'email' => $faker->text(200),
                'name' => $faker->text(200),
                'is_active' => $faker->boolean,
            ]);
        }
    }
}