<?php
namespace Modules\Management\OrderManagement\Order\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\OrderManagement\Order\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'order_number' => $faker->text(50),
                'product_id' => $faker->randomNumber(8),
                'customer_id' => $faker->randomNumber(8),
                'plan_name' => $faker->text(200),
                'billing_cycle' => $faker->randomElement(array (
  0 => 'monthly',
  1 => 'yearly',
  2 => 'one_time',
)),
                'status' => $faker->randomElement(array (
  0 => 'pending_payment',
  1 => 'payment_submitted',
  2 => 'payment_verified',
  3 => 'access_sent',
  4 => 'cancelled',
  5 => 'refunded',
)),
                'delivery_method' => $faker->randomElement(array (
  0 => 'email',
  1 => 'manual_contact',
)),
                'subtotal' => $faker->randomFloat(2, 0, 1000),
                'discount_amount' => $faker->randomFloat(2, 0, 1000),
                'total_amount' => $faker->randomFloat(2, 0, 1000),
                'coupon_code' => $faker->text(100),
                'customer_note' => $faker->paragraph,
                'ordered_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'payment_verified_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'access_sent_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'cancelled_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'created_by' => $faker->randomNumber(8),
            ]);
        }
    }
}