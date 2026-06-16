<?php
namespace Modules\Management\ProductManagement\ProductGroup\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Str;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\ProductManagement\ProductGroup\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\ProductManagement\ProductGroup\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $groups = [
            [
                'name'        => 'Ecommerce',
                'icon'        => 'fa-shopping-cart',
                'description' => 'Complete ecommerce software solutions — online store builders, payment gateways, cart management, and multi-vendor marketplace platforms.',
                'sort_order'  => 10,
            ],
            [
                'name'        => 'Inventory',
                'icon'        => 'fa-boxes',
                'description' => 'Inventory and stock management software — real-time tracking, warehouse management, purchase orders, and supply chain automation.',
                'sort_order'  => 20,
            ],
            [
                'name'        => 'Business Profile',
                'icon'        => 'fa-briefcase',
                'description' => 'Business portfolio and profile software — company websites, digital portfolios, client showcases, and professional brand presence tools.',
                'sort_order'  => 30,
            ],
        ];

        foreach ($groups as $group) {
            self::$model::create([
                'name'        => $group['name'],
                'slug'        => Str::slug($group['name']),
                'description' => $group['description'],
                'icon'        => $group['icon'],
                'sort_order'  => $group['sort_order'],
                'is_active'   => 1,
                'status'      => 'active',
            ]);
        }
    }
}
