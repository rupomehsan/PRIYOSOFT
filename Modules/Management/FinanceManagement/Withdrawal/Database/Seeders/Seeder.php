<?php
namespace Modules\Management\FinanceManagement\Withdrawal\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\Withdrawal\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\Withdrawal\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'withdrawn_by_type' => $faker->randomElement(array (
  0 => 'owner',
  1 => 'investor',
)),
                'user_id' => $faker->randomNumber(8),
                'investor_id' => $faker->randomNumber(8),
                'account_id' => $faker->randomNumber(8),
                'amount' => $faker->randomFloat(2, 0, 1000),
                'currency' => $faker->lexify(str_repeat('?', 3)),
                'reason' => $faker->text(300),
                'withdrawn_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'attachment' => $faker->word,
                'note' => $faker->paragraph,
                'created_by' => $faker->randomNumber(8),
            ]);
        }
    }
}