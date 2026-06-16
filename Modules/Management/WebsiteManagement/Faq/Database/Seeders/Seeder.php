<?php
namespace Modules\Management\WebsiteManagement\Faq\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\WebsiteManagement\Faq\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\Faq\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $faqs = [

            // ── About PriyoSoft ───────────────────────────────────────────
            [
                'question'   => 'What is PriyoSoft and what do you do?',
                'answer'     => 'PriyoSoft is a Bangladesh-based software company founded in 2016. We design and build custom web software — primarily ecommerce platforms, inventory & warehouse management systems, and business profile websites. We work with startups, SMEs, and enterprises across Bangladesh, the UK, UAE, and the USA.',
                'sort_order' => 1,
            ],
            [
                'question'   => 'What technologies does PriyoSoft use?',
                'answer'     => 'Our core stack is Laravel (PHP) on the backend and Vue.js on the frontend, deployed on Ubuntu servers via Docker. For mobile apps we use Flutter. We use MySQL for relational data, Redis for caching, and AWS S3 / DigitalOcean Spaces for file storage.',
                'sort_order' => 2,
            ],
            [
                'question'   => 'How long has PriyoSoft been in business?',
                'answer'     => 'PriyoSoft was founded in 2016 — giving us 8+ years of hands-on experience delivering production-grade web software. Over that time we have completed 50+ projects for 30+ clients across multiple industries.',
                'sort_order' => 3,
            ],
            [
                'question'   => 'Do you work with international clients?',
                'answer'     => 'Yes. While we are based in Dhaka, Bangladesh, we actively serve clients in the UK, UAE, USA, and across South Asia. All project communication is conducted in English and we work across time zones.',
                'sort_order' => 4,
            ],
            [
                'question'   => 'How do I get started with PriyoSoft?',
                'answer'     => 'Simply send us a message through our contact form or email hello@priyosoft.com. We will schedule a free 30-minute discovery call to understand your requirements and provide a no-obligation proposal within 48 hours.',
                'sort_order' => 5,
            ],

            // ── Ecommerce Products ────────────────────────────────────────
            [
                'question'   => 'What ecommerce solutions does PriyoSoft offer?',
                'answer'     => 'We offer two flagship ecommerce products: (1) Single Page Multi-Product Ecommerce — a full marketplace-style platform with category filtering, live search, and inline checkout; and (2) Single Page Single Product Ecommerce — a high-converting landing page optimised for one product, with countdown timers, testimonials, and one-click checkout.',
                'sort_order' => 6,
            ],
            [
                'question'   => 'Can your ecommerce platform handle multiple payment gateways?',
                'answer'     => 'Yes. Our ecommerce solutions support bKash, Nagad, SSLCommerz, Stripe, and PayPal out of the box. Additional payment gateways can be integrated on request. All transactions are secured with HTTPS and PCI-compliant practices.',
                'sort_order' => 7,
            ],
            [
                'question'   => 'Is your ecommerce solution mobile responsive?',
                'answer'     => 'Absolutely. All our ecommerce platforms are built mobile-first. They are fully responsive across phones, tablets, and desktops and score 90+ on Google PageSpeed Insights for mobile performance.',
                'sort_order' => 8,
            ],

            // ── Inventory & Warehouse Management ─────────────────────────
            [
                'question'   => 'What inventory management products are available?',
                'answer'     => 'Our inventory suite includes: StockMaster (warehouse management with barcode scanning), PurchasePro (purchase order management), AssetTrack (fixed asset lifecycle), TransferHub (inter-branch stock transfers), ReturnFlow (returns & damage management), BarcodeGen (label & barcode studio), InventoryAI (AI demand forecasting), and SupplierHub (vendor self-service portal).',
                'sort_order' => 9,
            ],
            [
                'question'   => 'Does your inventory system support multiple warehouses?',
                'answer'     => 'Yes. StockMaster supports unlimited warehouses and branches. You can track stock levels, transfers, and discrepancies per location in real time — all from a single dashboard.',
                'sort_order' => 10,
            ],
            [
                'question'   => 'Does your system support barcode and QR code scanning?',
                'answer'     => 'Yes. StockMaster integrates with USB barcode scanners, mobile camera scanning, and thermal label printers. BarcodeGen lets you design and bulk-print custom barcode and QR labels synced directly with your product database.',
                'sort_order' => 11,
            ],
            [
                'question'   => 'Can your inventory system forecast demand automatically?',
                'answer'     => 'Yes — InventoryAI uses historical sales data, seasonal trends, and market signals to recommend optimal stock levels and reorder points. It reduces overstock, prevents stockouts, and sends automated dashboard alerts when action is needed.',
                'sort_order' => 12,
            ],

            // ── Business Profile & Portfolio ──────────────────────────────
            [
                'question'   => 'What business profile and portfolio products do you offer?',
                'answer'     => 'Our business profile suite includes: ProfileX (company website builder), PortfolioLite (freelancer portfolio), ClientShowcase (agency portfolio CMS), BrandKit (digital brand identity manager), TeamDir (staff directory & org chart), TestimonialWall (client reviews showcase), AwardBadge (certification display), LeadMagnet (lead capture suite), and ImpactReport (annual report builder).',
                'sort_order' => 13,
            ],
            [
                'question'   => 'Can I manage my company website content without a developer?',
                'answer'     => 'Yes. ProfileX and all our CMS-based products include an easy-to-use admin dashboard where you can update text, images, team members, testimonials, blog posts, and more — no coding required.',
                'sort_order' => 14,
            ],
            [
                'question'   => 'Do your business profile websites support custom domains?',
                'answer'     => 'Yes. All our website products support custom domain names. We assist with DNS configuration and SSL certificate setup as part of the onboarding process.',
                'sort_order' => 15,
            ],

            // ── Pricing & Engagement ──────────────────────────────────────
            [
                'question'   => 'How much does a project with PriyoSoft cost?',
                'answer'     => 'Pricing depends on scope, complexity, and customisation level. Our standard ecommerce packages start from ৳30,000 BDT (approx. $250 USD). Inventory systems and custom enterprise builds are quoted individually after a discovery call. We offer both fixed-price and time & materials models.',
                'sort_order' => 16,
            ],
            [
                'question'   => 'How long does it take to build a custom software project?',
                'answer'     => 'A standard ecommerce site or business profile website typically takes 3–6 weeks. An inventory management system takes 6–16 weeks depending on modules. We provide a detailed timeline after the discovery phase and keep you updated at every milestone.',
                'sort_order' => 17,
            ],
            [
                'question'   => 'Do you provide post-launch support and maintenance?',
                'answer'     => 'Yes. We offer monthly maintenance packages covering bug fixes, security patches, server monitoring, and feature updates. Most of our clients continue working with us 12+ months after their initial launch.',
                'sort_order' => 18,
            ],

            // ── Technical / Misc ──────────────────────────────────────────
            [
                'question'   => 'Can you integrate with third-party tools like CRMs, ERPs, or accounting software?',
                'answer'     => 'Yes. We have experience integrating with HubSpot, Zoho CRM, QuickBooks, Tally, Xero, Facebook/Google Ads pixels, Mailchimp, and custom REST APIs. If you use a specific tool, let us know during the discovery call.',
                'sort_order' => 19,
            ],
            [
                'question'   => 'Can you take over and improve an existing codebase?',
                'answer'     => 'Yes. We regularly audit, refactor, and extend existing Laravel and Vue.js codebases. We start with a thorough technical audit, provide an honest assessment, and outline a clear improvement roadmap before writing a single line of code.',
                'sort_order' => 20,
            ],
        ];

        foreach ($faqs as $faq) {
            self::$model::create([
                'product_id'  => null,
                'question'    => $faq['question'],
                'answer'      => $faq['answer'],
                'sort_order'  => $faq['sort_order'],
                'is_visible'  => 1,
                'status'      => 'active',
            ]);
        }
    }
}
