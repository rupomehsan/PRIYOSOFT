<?php
namespace Modules\Management\WebsiteManagement\AboutUs\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\AboutUs\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\AboutUs\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'section' => $faker->randomElement(array (
  0 => 'story',
  1 => 'mission',
  2 => 'vision',
  3 => 'value',
  4 => 'stat',
)),
                'title' => $faker->text(300),
                'description' => $faker->paragraph,
                'icon' => $faker->text(200),
                'image' => $faker->word,
                'stat_value' => $faker->text(100),
                'stat_label' => $faker->text(200),
                'sort_order' => $faker->randomNumber(5),
                'is_visible' => $faker->boolean,
            ]);
        }
    }
}