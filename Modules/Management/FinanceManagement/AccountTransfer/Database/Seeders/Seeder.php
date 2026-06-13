<?php
namespace Modules\Management\FinanceManagement\AccountTransfer\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\AccountTransfer\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\AccountTransfer\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'from_account_id' => $faker->randomNumber(8),
                'to_account_id' => $faker->randomNumber(8),
                'amount' => $faker->randomFloat(2, 0, 1000),
                'fee' => $faker->randomFloat(2, 0, 1000),
                'transferred_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'note' => $faker->paragraph,
                'created_by' => $faker->randomNumber(8),
            ]);
        }
    }
}