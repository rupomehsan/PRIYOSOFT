<?php
namespace Modules\Management\WebsiteManagement\BlogPost\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\BlogPost\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\BlogPost\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'title' => $faker->text(500),
                'slug' => $faker->text(500),
                'thumbnail' => $faker->word,
                'excerpt' => $faker->paragraph,
                'body' => $faker->paragraph,
                'author_id' => $faker->randomNumber(8),
                'product_id' => $faker->randomNumber(8),
                'status' => $faker->randomElement(array (
  0 => 'draft',
  1 => 'published',
)),
                'published_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}