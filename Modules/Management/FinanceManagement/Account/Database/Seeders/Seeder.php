<?php
namespace Modules\Management\FinanceManagement\Account\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\Account\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\Account\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'name' => $faker->text(150),
                'type' => $faker->randomElement(array (
  0 => 'cash',
  1 => 'bank',
  2 => 'mobile_banking',
  3 => 'crypto',
)),
                'account_number' => $faker->text(100),
                'opening_balance' => $faker->randomFloat(2, 0, 1000),
                'current_balance' => $faker->randomFloat(2, 0, 1000),
                'currency' => $faker->lexify(str_repeat('?', 3)),
                'is_active' => $faker->boolean,
            ]);
        }
    }
}