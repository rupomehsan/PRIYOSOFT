<?php
namespace Modules\Management\FinanceManagement\ProfitDistribution\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\ProfitDistribution\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\ProfitDistribution\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'period' => $faker->text(20),
                'total_income' => $faker->randomFloat(2, 0, 1000),
                'total_expense' => $faker->randomFloat(2, 0, 1000),
                'net_profit' => $faker->randomFloat(2, 0, 1000),
                'distributed_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'note' => $faker->paragraph,
            ]);
        }
    }
}