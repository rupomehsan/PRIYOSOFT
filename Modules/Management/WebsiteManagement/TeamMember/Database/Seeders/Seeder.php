<?php
namespace Modules\Management\WebsiteManagement\TeamMember\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\TeamMember\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\TeamMember\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'name' => $faker->text(200),
                'role' => $faker->text(200),
                'bio' => $faker->paragraph,
                'photo' => $faker->word,
                'linkedin' => $faker->text(500),
                'github' => $faker->text(500),
                'sort_order' => $faker->randomNumber(5),
                'is_visible' => $faker->boolean,
            ]);
        }
    }
}