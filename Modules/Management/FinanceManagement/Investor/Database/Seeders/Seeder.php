<?php
namespace Modules\Management\FinanceManagement\Investor\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\Investor\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\Investor\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'name' => $faker->text(200),
                'email' => $faker->text(200),
                'phone' => $faker->text(50),
                'address' => $faker->paragraph,
                'nid_or_passport' => $faker->text(100),
                'type' => $faker->randomElement(array (
  0 => 'individual',
  1 => 'company',
)),
                'equity_percentage' => $faker->randomFloat(2, 0, 1000),
                'note' => $faker->paragraph,
                'joined_at' => $faker->dateTime()->format('Y-m-d H:i:s'),

            ]);
        }
    }
}