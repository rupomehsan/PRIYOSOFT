<?php
namespace Modules\Management\WebsiteManagement\HeroSection\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\HeroSection\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\HeroSection\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'badge_text' => $faker->text(100),
                'headline' => $faker->text(300),
                'subheadline' => $faker->text(300),
                'description' => $faker->paragraph,
                'primary_button_text' => $faker->text(100),
                'primary_button_url' => $faker->word,
                'secondary_button_text' => $faker->text(100),
                'secondary_button_url' => $faker->word,
                'media_type' => $faker->randomElement(array (
  0 => 'image',
  1 => 'video',
)),
                'background_image' => $faker->word,
                'hero_image' => $faker->word,
                'video_url' => $faker->word,
                'is_active' => $faker->boolean,
            ]);
        }
    }
}