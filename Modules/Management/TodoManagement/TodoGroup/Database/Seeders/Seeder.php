<?php
namespace Modules\Management\TodoManagement\TodoGroup\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoGroup\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\TodoManagement\TodoGroup\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        // Array key = todo_milestone_id  (matches order milestones are seeded: 1-7)
        // phase = key used by TodoList seeder to look up tasks — must be unique per group
        // cost  = sum of all task item_costs in this group (৳800/day + fixed expenses)
        $groups = [

            // ── MILESTONE 1: Planning & Research ──────────────────────────────────────
            1 => [
                ['name' => 'Product Research & Identification',     'phase' => 'Product Research',   'cost' => 9600],
                ['name' => 'Company Name & Legal Setup',            'phase' => 'Company Legal',      'cost' => 9000],
                ['name' => 'Logo & Brand Identity Design',          'phase' => 'Logo Design',        'cost' => 6800],
                ['name' => 'Social Media Account Setup',            'phase' => 'Social Media Setup', 'cost' => 4400],
                ['name' => 'Gmail & Email Account Management',      'phase' => 'Email Management',   'cost' => 3200],
                ['name' => 'Social Media Banner & Creative Design', 'phase' => 'Creative Design',    'cost' => 6000],
                ['name' => 'Visiting Card & Print Materials',       'phase' => 'Print Materials',    'cost' => 4400],
                ['name' => 'Domain & Hosting Setup',                'phase' => 'Domain Hosting',     'cost' => 8700],
            ],

            // ── MILESTONE 2: Company Website & eCommerce Software ─────────────────────
            2 => [
                ['name' => 'Company Website - UI/UX Design',            'phase' => 'Website Design',      'cost' => 10400],
                ['name' => 'Company Website - Frontend Development',     'phase' => 'Website Frontend',    'cost' => 12800],
                ['name' => 'Company Website - Backend & CMS',           'phase' => 'Website Backend',     'cost' => 12800],
                ['name' => 'Company Website - Content & SEO',           'phase' => 'Website Content',     'cost' => 10400],
                ['name' => 'eCommerce Software - Planning & Design',    'phase' => 'eCommerce Planning',  'cost' => 12800],
                ['name' => 'eCommerce Software - Backend Development',  'phase' => 'eCommerce Backend',   'cost' => 16000],
                ['name' => 'eCommerce Software - Frontend Development', 'phase' => 'eCommerce Frontend',  'cost' => 18400],
                ['name' => 'eCommerce Software - Payment Integration',  'phase' => 'eCommerce Payment',   'cost' => 12000],
                ['name' => 'Testing & Quality Assurance',               'phase' => 'Testing QA',          'cost' => 13600],
                ['name' => 'Deployment & Go Live',                      'phase' => 'Deployment',          'cost' => 9600],
            ],

            // ── MILESTONE 3: Content Marketing & SEO ──────────────────────────────────
            3 => [
                ['name' => 'Blog Content Strategy',           'phase' => 'Blog Strategy',    'cost' => 11600],
                ['name' => 'SEO Setup & Optimization',        'phase' => 'SEO Optimization', 'cost' => 11600],
                ['name' => 'YouTube Channel & Video Content', 'phase' => 'YouTube Content',  'cost' => 10400],
                ['name' => 'Social Media Content Calendar',   'phase' => 'Social Content',   'cost' => 12000],
                ['name' => 'Email Marketing Setup',           'phase' => 'Email Marketing',  'cost' =>  7200],
                ['name' => 'Lead Magnet & Content Offer',     'phase' => 'Lead Magnet',      'cost' =>  5600],
            ],

            // ── MILESTONE 4: Sales Pipeline & CRM ─────────────────────────────────────
            4 => [
                ['name' => 'CRM Platform Setup',          'phase' => 'CRM Setup',       'cost' =>  4800],
                ['name' => 'Sales Process Documentation', 'phase' => 'Sales Process',   'cost' =>  7200],
                ['name' => 'Lead Generation & Outreach',  'phase' => 'Lead Generation', 'cost' =>  8000],
                ['name' => 'Proposal & Pricing System',   'phase' => 'Proposal System', 'cost' =>  4000],
                ['name' => 'Customer Onboarding Process', 'phase' => 'Client Onboarding','cost' => 4400],
            ],

            // ── MILESTONE 5: Paid Advertising Campaigns ───────────────────────────────
            5 => [
                ['name' => 'Facebook Ads Campaign',       'phase' => 'Facebook Ads',          'cost' =>  8400],
                ['name' => 'Google Ads Campaign',         'phase' => 'Google Ads',             'cost' =>  6400],
                ['name' => 'Ad Creative Design',          'phase' => 'Ad Creatives',           'cost' => 11200],
                ['name' => 'Campaign Monitoring & Optimization', 'phase' => 'Campaign Optimization', 'cost' => 6400],
            ],

            // ── MILESTONE 6: Partnership & Reseller Program ───────────────────────────
            6 => [
                ['name' => 'Partner Program Design',   'phase' => 'Partner Program',      'cost' => 5600],
                ['name' => 'Agency Partner Outreach',  'phase' => 'Agency Outreach',      'cost' => 6400],
                ['name' => 'Reseller Onboarding',      'phase' => 'Reseller Onboarding',  'cost' => 5600],
                ['name' => 'Co-Marketing Campaigns',   'phase' => 'Co Marketing',         'cost' => 4800],
            ],

            // ── MILESTONE 7: ১০ লক্ষ BDT MRR ─────────────────────────────────────────
            7 => [
                ['name' => 'Revenue Growth & MRR Tracking', 'phase' => 'Revenue Growth',    'cost' =>  5600],
                ['name' => 'Customer Retention Strategy',   'phase' => 'Customer Retention','cost' =>  6000],
                ['name' => 'Product Expansion (Inventory & Portfolio)', 'phase' => 'Product Expansion','cost' => 18400],
                ['name' => 'Business Scaling & Team',       'phase' => 'Business Scaling',  'cost' =>  6000],
            ],
        ];

        $sort = 1;
        foreach ($groups as $milestoneId => $items) {
            foreach ($items as $item) {
                self::$model::create([
                    'todo_milestone_id' => $milestoneId,
                    'name'              => $item['name'],
                    'phase'             => $item['phase'],
                    'cost'              => $item['cost'],
                    'sort_order'        => $sort++,
                    'current_status'    => 'pending',
                    'status'            => 'active',
                ]);
            }
        }
    }
}
