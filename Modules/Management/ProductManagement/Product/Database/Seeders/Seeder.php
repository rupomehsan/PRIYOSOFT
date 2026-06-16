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
                'description'            => 'A single-page ecommerce platform that showcases multiple products on one page with category filtering, quick-add to cart, live search, and an inline checkout flow — no page reloads, blazing fast conversion.',
                'status'                 => 'active',
                'launch_date'            => '2023-06-01',
                'monthly_target_revenue' => 120000,
                'regular_price'          => 4999.00,
                'sales_price'            => 3999.00,
                'features'               => ['Single Page App', 'Multi-Product Listing', 'Category Filter', 'Quick Add to Cart', 'Inline Checkout', 'Live Search', 'Mobile Responsive', 'SEO Ready'],
            ],
            [
                'product_group_id'       => $ecommerceId,
                'name'                   => 'Single Page Single Product Ecommerce',
                'description'            => 'High-converting single-product landing page ecommerce — designed for product launches, crowdfunding, and direct sales with countdown timer, testimonials, FAQ, and one-click checkout.',
                'status'                 => 'active',
                'launch_date'            => '2023-09-01',
                'monthly_target_revenue' => 90000,
                'regular_price'          => 2999.00,
                'sales_price'            => 2499.00,
                'features'               => ['Single Product Focus', 'Countdown Timer', 'Testimonials Section', 'FAQ Block', 'One-Click Checkout', 'Upsell & Order Bump', 'A/B Test Ready', 'Pixel & Analytics'],
            ],

            // ─── Inventory (all upcoming / planning) ─────────────────────────────────
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'StockMaster — Warehouse Management System',
                'description'            => 'End-to-end warehouse management with barcode scanning, bin/rack location tracking, stock-in/stock-out, batch & serial number control, and automated low-stock alerts.',
                'status'                 => 'planning',
                'launch_date'            => '2025-01-01',
                'monthly_target_revenue' => 120000,
                'regular_price'          => 9999.00,
                'sales_price'            => 7999.00,
                'features'               => ['Barcode Scanning', 'Bin & Rack Tracking', 'Batch & Serial Control', 'Low-Stock Alerts', 'FIFO/LIFO Support', 'Multi-Warehouse', 'Mobile App'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'PurchasePro — Purchase Order Management',
                'description'            => 'Supplier and purchase order management with quotation comparison, auto-reorder triggers, goods receipt notes, and supplier credit tracking.',
                'status'                 => 'planning',
                'launch_date'            => '2025-02-01',
                'monthly_target_revenue' => 70000,
                'regular_price'          => 5999.00,
                'sales_price'            => 4999.00,
                'features'               => ['Quotation Comparison', 'Auto-Reorder', 'Goods Receipt Notes', 'Supplier Credit', 'PDF PO Generation', 'Approval Workflow'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'AssetTrack — Fixed Asset Management',
                'description'            => 'Fixed asset lifecycle management with depreciation calculation, maintenance scheduling, asset tagging, disposal records, and audit trail.',
                'status'                 => 'planning',
                'launch_date'            => '2025-03-01',
                'monthly_target_revenue' => 55000,
                'regular_price'          => 4999.00,
                'sales_price'            => 3999.00,
                'features'               => ['Depreciation Calc', 'Maintenance Scheduling', 'Asset Tagging', 'Disposal Records', 'Audit Trail', 'Barcode/QR Label'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'TransferHub — Inter-Branch Stock Transfer',
                'description'            => 'Multi-branch stock transfer module with transfer request approval, in-transit tracking, discrepancy management, and real-time branch stock visibility.',
                'status'                 => 'planning',
                'launch_date'            => '2025-04-01',
                'monthly_target_revenue' => 40000,
                'regular_price'          => 3499.00,
                'sales_price'            => 2999.00,
                'features'               => ['Transfer Request Approval', 'In-Transit Tracking', 'Discrepancy Reports', 'Multi-Branch Stock View', 'Branch Ledger'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'ReturnFlow — Return & Damage Management',
                'description'            => 'Customer return and damaged goods management with RMA workflow, condition grading, restocking or disposal routing, and credit note generation.',
                'status'                 => 'planning',
                'launch_date'            => '2025-05-01',
                'monthly_target_revenue' => 30000,
                'regular_price'          => 2999.00,
                'sales_price'            => 2499.00,
                'features'               => ['RMA Workflow', 'Condition Grading', 'Restock / Dispose Routing', 'Credit Note Generation', 'Photo Evidence Upload'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'BarcodeGen — Label & Barcode Studio',
                'description'            => 'Barcode and QR code label designer with bulk generation, custom templates, thermal printer support, and product-sync from inventory database.',
                'status'                 => 'planning',
                'launch_date'            => '2025-06-01',
                'monthly_target_revenue' => 20000,
                'regular_price'          => 1999.00,
                'sales_price'            => 1499.00,
                'features'               => ['Bulk Generation', 'Custom Templates', 'Thermal Printer Support', 'QR & Barcode', 'Product DB Sync'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'InventoryAI — Demand Forecasting Engine',
                'description'            => 'AI-driven demand forecasting using historical sales data, seasonal patterns, and market signals to recommend optimal stock levels and reorder points.',
                'status'                 => 'planning',
                'launch_date'            => '2025-07-01',
                'monthly_target_revenue' => 90000,
                'regular_price'          => 7999.00,
                'sales_price'            => 6499.00,
                'features'               => ['AI Forecasting', 'Seasonal Pattern Analysis', 'Reorder Point Suggestions', 'Historical Data Training', 'Dashboard Alerts'],
            ],
            [
                'product_group_id'       => $inventoryId,
                'name'                   => 'SupplierHub — Vendor Portal',
                'description'            => 'Self-service supplier portal for PO acknowledgement, invoice submission, delivery scheduling, and performance scorecards.',
                'status'                 => 'planning',
                'launch_date'            => '2025-08-01',
                'monthly_target_revenue' => 50000,
                'regular_price'          => 4499.00,
                'sales_price'            => 3799.00,
                'features'               => ['PO Acknowledgement', 'Invoice Submission', 'Delivery Scheduling', 'Performance Scorecards', 'Secure Portal Login'],
            ],

            // ─── Business Profile (all upcoming / planning) ───────────────────────────
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'ProfileX — Company Website Builder',
                'description'            => 'Professional company website builder with pre-built industry templates, team profiles, service pages, blog, contact forms, and custom domain support.',
                'status'                 => 'planning',
                'launch_date'            => '2025-01-01',
                'monthly_target_revenue' => 100000,
                'regular_price'          => 7999.00,
                'sales_price'            => 5999.00,
                'features'               => ['Industry Templates', 'Team Profiles', 'Service Pages', 'Blog Module', 'Contact Forms', 'Custom Domain', 'SEO Tools'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'PortfolioLite — Freelancer Portfolio',
                'description'            => 'Lightweight portfolio site builder for freelancers and agencies — project showcase, skills matrix, client testimonials, and PDF resume export.',
                'status'                 => 'planning',
                'launch_date'            => '2025-02-01',
                'monthly_target_revenue' => 45000,
                'regular_price'          => 2999.00,
                'sales_price'            => 1999.00,
                'features'               => ['Project Showcase', 'Skills Matrix', 'Client Testimonials', 'PDF Resume Export', 'Social Links', 'Dark/Light Mode'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'ClientShowcase — Agency Portfolio CMS',
                'description'            => 'Agency-grade portfolio CMS with case studies, before/after sliders, client logos, award badges, and lead capture forms for prospect conversion.',
                'status'                 => 'planning',
                'launch_date'            => '2025-03-01',
                'monthly_target_revenue' => 65000,
                'regular_price'          => 4999.00,
                'sales_price'            => 3999.00,
                'features'               => ['Case Studies', 'Before/After Slider', 'Client Logos Wall', 'Award Badges', 'Lead Capture Forms', 'Analytics Integration'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'BrandKit — Digital Brand Identity Manager',
                'description'            => 'Centralized brand identity management with logo library, color palette, typography guidelines, brand asset downloads, and brand usage enforcement.',
                'status'                 => 'planning',
                'launch_date'            => '2025-04-01',
                'monthly_target_revenue' => 38000,
                'regular_price'          => 3499.00,
                'sales_price'            => 2799.00,
                'features'               => ['Logo Library', 'Color Palettes', 'Typography Guide', 'Asset Downloads', 'Brand Usage Rules', 'Team Access Control'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'TeamDir — Staff Directory & Org Chart',
                'description'            => 'Interactive staff directory and organization chart tool with employee profiles, department hierarchy, search, and exportable org chart PDF.',
                'status'                 => 'planning',
                'launch_date'            => '2025-05-01',
                'monthly_target_revenue' => 28000,
                'regular_price'          => 2499.00,
                'sales_price'            => 1999.00,
                'features'               => ['Employee Profiles', 'Org Chart Builder', 'Department Hierarchy', 'Search & Filter', 'PDF Export', 'LDAP/SSO Integration'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'TestimonialWall — Client Reviews Showcase',
                'description'            => 'Embeddable client testimonial and review showcase with video testimonials, star ratings, Google/Facebook review import, and customizable widget.',
                'status'                 => 'planning',
                'launch_date'            => '2025-06-01',
                'monthly_target_revenue' => 20000,
                'regular_price'          => 1999.00,
                'sales_price'            => 1499.00,
                'features'               => ['Video Testimonials', 'Star Ratings', 'Google Review Import', 'Facebook Review Import', 'Embeddable Widget', 'Auto Rotation'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'AwardBadge — Certification & Achievement Display',
                'description'            => 'Digital certificate and achievement badge display module for business profiles — ISO certifications, industry awards, partner badges, and trust seals.',
                'status'                 => 'planning',
                'launch_date'            => '2025-07-01',
                'monthly_target_revenue' => 15000,
                'regular_price'          => 1499.00,
                'sales_price'            => 999.00,
                'features'               => ['ISO Certification Display', 'Award Showcase', 'Partner Badge Wall', 'Trust Seals', 'Verification Links', 'Expiry Alerts'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'LeadMagnet — Business Lead Capture Suite',
                'description'            => 'Conversion-optimized lead capture suite with multi-step forms, quote request builders, appointment booking, CRM integration, and lead scoring.',
                'status'                 => 'planning',
                'launch_date'            => '2025-08-01',
                'monthly_target_revenue' => 75000,
                'regular_price'          => 5999.00,
                'sales_price'            => 4499.00,
                'features'               => ['Multi-Step Forms', 'Quote Builder', 'Appointment Booking', 'CRM Integration', 'Lead Scoring', 'Email Automation'],
            ],
            [
                'product_group_id'       => $businessProfileId,
                'name'                   => 'ImpactReport — Annual Report & CSR Builder',
                'description'            => 'Interactive annual report and CSR impact report builder with rich infographics, data charts, PDF/web output, and stakeholder sharing portal.',
                'status'                 => 'planning',
                'launch_date'            => '2025-09-01',
                'monthly_target_revenue' => 55000,
                'regular_price'          => 4999.00,
                'sales_price'            => 3999.00,
                'features'               => ['Rich Infographics', 'Interactive Charts', 'PDF & Web Output', 'Stakeholder Portal', 'Multi-Language'],
            ],
        ];

        foreach ($products as $product) {
            self::$model::create([
                'product_group_id'       => $product['product_group_id'],
                'name'                   => $product['name'],
                'slug'                   => Str::slug($product['name']),
                'description'            => $product['description'],
                'status'                 => $product['status'],
                'launch_date'            => $product['launch_date'],
                'monthly_target_revenue' => $product['monthly_target_revenue'],
                'regular_price'          => $product['regular_price'] ?? null,
                'sales_price'            => $product['sales_price'] ?? null,
                'features'               => json_encode($product['features']),
                'screenshots'            => null,
            ]);
        }
    }
}
