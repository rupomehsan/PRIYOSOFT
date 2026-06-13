<?php

namespace Modules\Management\UserManagement\Role\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\Modules\Management\UserManagement\Role\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\UserManagement\Role\Database\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();

        Schema::disableForeignKeyConstraints();
        DB::table('role_permission')->truncate();
        self::$model::truncate();
        Schema::enableForeignKeyConstraints();

        self::$model::create([
            'name' => "super_admin",
            'serial_no' => 1,
        ]);


      

       
    }
}