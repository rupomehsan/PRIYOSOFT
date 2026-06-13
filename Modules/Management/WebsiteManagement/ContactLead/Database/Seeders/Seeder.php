<?php
namespace Modules\Management\WebsiteManagement\ContactLead\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\ContactLead\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\ContactLead\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'name' => $faker->text(200),
                'email' => $faker->text(200),
                'phone' => $faker->text(50),
                'subject' => $faker->text(300),
                'product_id' => $faker->randomNumber(8),
                'message' => $faker->paragraph,
                'status' => $faker->randomElement(array (
  0 => 'new',
  1 => 'read',
  2 => 'replied',
  3 => 'closed',
)),
                'ip_address' => $faker->text(50),
            ]);
        }
    }
}