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

      
    }
}