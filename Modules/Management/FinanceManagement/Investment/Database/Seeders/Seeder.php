<?php
namespace Modules\Management\FinanceManagement\Investment\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\Investment\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\Investment\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'investor_id' => $faker->randomNumber(8),
                'account_id' => $faker->randomNumber(8),
                'round' => $faker->text(100),
                'amount' => $faker->randomFloat(2, 0, 1000),
                'currency' => $faker->lexify(str_repeat('?', 3)),
                'type' => $faker->randomElement(array (
  0 => 'equity',
  1 => 'loan',
  2 => 'grant',
)),
                'interest_rate' => $faker->randomFloat(2, 0, 1000),
                'agreement_date' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'received_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'agreement_doc' => $faker->word,
                'note' => $faker->paragraph,
            ]);
        }
    }
}