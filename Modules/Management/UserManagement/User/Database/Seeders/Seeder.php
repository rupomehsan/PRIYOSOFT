<?php

namespace Modules\Management\UserManagement\User\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class="Modules\Management\UserManagement\User\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\UserManagement\User\Database\Models\Model::class;

    

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        self::$model::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ── Base system users ──────────────────────────────────────────
        self::$model::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@gmail.com',
            'password' => Hash::make('@12345678'),
            'image'    => 'avatar.png',
            'role_id'  => 1,
        ]);

      
    }
}