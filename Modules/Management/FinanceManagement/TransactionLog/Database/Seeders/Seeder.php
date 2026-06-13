<?php
namespace Modules\Management\FinanceManagement\TransactionLog\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\TransactionLog\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\TransactionLog\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'account_id' => $faker->randomNumber(8),
                'type' => $faker->randomElement(array (
  0 => 'income',
  1 => 'expense',
  2 => 'investment',
  3 => 'withdrawal',
  4 => 'transfer_in',
  5 => 'transfer_out',
)),
                'direction' => $faker->randomElement(array (
  0 => 'credit',
  1 => 'debit',
)),
                'amount' => $faker->randomFloat(2, 0, 1000),
                'balance_before' => $faker->randomFloat(2, 0, 1000),
                'balance_after' => $faker->randomFloat(2, 0, 1000),
                'reference_type' => $faker->text(100),
                'reference_id' => $faker->randomNumber(8),
                'description' => $faker->text(400),
                'product_id' => $faker->randomNumber(8),
                'investor_id' => $faker->randomNumber(8),
                'transaction_date' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'created_by' => $faker->randomNumber(8),
            ]);
        }
    }
}