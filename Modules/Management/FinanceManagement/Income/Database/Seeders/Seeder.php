<?php
namespace Modules\Management\FinanceManagement\Income\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\FinanceManagement\Income\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\Income\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'title' => $faker->text(300),
                'income_category_id' => $faker->randomNumber(8),
                'product_id' => $faker->randomNumber(8),
                'account_id' => $faker->randomNumber(8),
                'amount' => $faker->randomFloat(2, 0, 1000),
                'currency' => $faker->lexify(str_repeat('?', 3)),
                'source' => $faker->text(200),
                'received_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'invoice_no' => $faker->text(100),
                'note' => $faker->paragraph,
                'attachment' => $faker->word,
                'created_by' => $faker->randomNumber(8),
            ]);
        }
    }
}