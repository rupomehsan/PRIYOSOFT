<?php
namespace Modules\Management\WebsiteManagement\Testimonial\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\Testimonial\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\Testimonial\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'client_name' => $faker->text(200),
                'client_company' => $faker->text(200),
                'media_type' => $faker->randomElement(array (
  0 => 'image',
  1 => 'video',
)),
                'client_photo' => $faker->word,
                'video_url' => $faker->word,
                'product_id' => $faker->randomNumber(8),
                'rating' => $faker->randomNumber(5),
                'message' => $faker->paragraph,
                'is_featured' => $faker->boolean,
                'is_visible' => $faker->boolean,
            ]);
        }
    }
}