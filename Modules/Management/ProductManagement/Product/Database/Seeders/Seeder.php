<?php
namespace Modules\Management\ProductManagement\Product\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Str;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\ProductManagement\Product\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\ProductManagement\Product\Database\Models\Model::class;
    static $groupModel = \Modules\Management\ProductManagement\ProductGroup\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $groups = static::$groupModel::pluck('id', 'name')->toArray();

        $ecommerceId       = $groups['Ecommerce']         ?? null;
        $inventoryId       = $groups['Inventory']         ?? null;
        $businessProfileId = $groups['Business Profile']  ?? null;

        $products = [
            // ─── Ecommerce (2 active products) ───────────────────────────────────────
            [
                'product_group_id'       => $ecommerceId,
                'name'                   => 'Single Page Multi-Product Ecommerce',
                'description'            => 'PFC is a blazing-fast single-page multi-product ecommerce platform built with Laravel, Vue.js & MySQL. Customers can place orders directly from the website or via WhatsApp Messenger. Admins get a creative dashboard to manage orders, products, and all site content dynamically — with real-time order tracking from placement to delivery.',
                'project_status'                 => 'active',
                'launch_date'            => '2023-06-01',
                'monthly_target_revenue' => 120000,
                'regular_price'          => 4999.00,
                'sales_price'            => 3999.00,
                'features'               => [
                    'Order via Website',
                    'Order via WhatsApp',
                    'Order via Messenger',
                    'Dynamic Content Management',
                    'Real-Time Order Tracking',
                    'Creative Admin Dashboard',
                    'Order Management',
                    'Product Management',
                    'Content Management',
                    'Multi-Product Single Page',
                    'Mobile Responsive',
                ],
                'thumbnail'              => 'default.png',
                'screenshots'            => [
                    'default.png',
                    'default.png',
                    'default.png',
                ],
                'video_url'              => 'https://www.youtube.com/watch?v=xPPLbEFbCAo&t=2s',
                'promo_link'             => 'https://pfc.priyosoftware.com/',
                'version'                => 'v1.0.0',
            ],
            [
                'product_group_id'       => $ecommerceId,
                'name'                   => 'Single Page Single Product Ecommerce',
                'description'            => 'High-converting single-product landing page ecommerce — designed for product launches, crowdfunding, and direct sales with countdown timer, testimonials, FAQ, and one-click checkout.',
                'project_status'                 => 'active',
                'launch_date'            => '2023-09-01',
                'monthly_target_revenue' => 90000,
                'regular_price'          => 2999.00,
                'sales_price'            => 2499.00,
                'features'               => ['Single Product Focus', 'Countdown Timer', 'Testimonials Section', 'FAQ Block', 'One-Click Checkout', 'Upsell & Order Bump', 'A/B Test Ready', 'Pixel & Analytics'],
                'thumbnail'              => 'default.png',
                'screenshots'            => ['default.png', 'default.png', 'default.png'],
                'video_url'              => null,
                'promo_link'             => 'https://demo.priyosoft.com/ecommerce-single',
            ],

            // ─── Inventory (all upcoming / planning) ─────────────────────────────────
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'StockMaster — Warehouse Management System',
                'description'            => 'End-to-end warehouse management with barcode scanning, bin/rack location tracking, stock-in/stock-out, batch & serial number control, and automated low-stock alerts.',
                'project_status'                 => 'planning',
                'launch_date'            => '2025-01-01',
                'monthly_target_revenue' => 120000,
                'regular_price'          => 9999.00,
                'sales_price'            => 7999.00,
                'features'               => ['Barcode Scanning', 'Bin & Rack Tracking', 'Batch & Serial Control', 'Low-Stock Alerts', 'FIFO/LIFO Support', 'Multi-Warehouse', 'Mobile App'],
                'thumbnail'              => 'default.png',
                'screenshots'            => ['default.png', 'default.png', 'default.png'],
                'video_url'             => null,
            ],


            // ─── Business Profile (all upcoming / planning) ───────────────────────────
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'ProfileX — Company Website Builder',
                'description'            => 'Professional company website builder with pre-built industry templates, team profiles, service pages, blog, contact forms, and custom domain support.',
                'project_status'                 => 'planning',
                'launch_date'            => '2025-01-01',
                'monthly_target_revenue' => 100000,
                'regular_price'          => 7999.00,
                'sales_price'            => 5999.00,
                'features'               => ['Industry Templates', 'Team Profiles', 'Service Pages', 'Blog Module', 'Contact Forms', 'Custom Domain', 'SEO Tools'],
                'thumbnail'              => 'default.png',
                'screenshots'            => ['default.png', 'default.png', 'default.png'],
                'video_url'             => null,
            ],
            
          
        ];

        foreach ($products as $product) {
            self::$model::create([
                'product_group_id'       => $product['product_group_id'],
                'name'                   => $product['name'],
                'slug'                   => Str::slug($product['name']),
                'description'            => $product['description'],
                'project_status'                 => $product['project_status'],
                'launch_date'            => $product['launch_date'],
                'monthly_target_revenue' => $product['monthly_target_revenue'],
                'regular_price'          => $product['regular_price'] ?? null,
                'sales_price'            => $product['sales_price'] ?? null,
                'features'               => json_encode($product['features']),
                'screenshots'            => json_encode($product['screenshots'] ?? ['default.png']),
                'thumbnail'              => $product['thumbnail'] ?? 'default.png',
                'video_url'              => $product['video_url'] ?? null,
                'promo_link'             => $product['promo_link'] ?? null,
                'version'                => $product['version'] ?? 'v1.0.0',
            ]);
        }
    }
}
