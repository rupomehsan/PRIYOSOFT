<?php
namespace Modules\Management\TodoManagement\TodoMilestone\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoMilestone\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\TodoManagement\TodoMilestone\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        // Costs = sum of all group costs per milestone  (৳800/day work + fixed out-of-pocket)
        $milestones = [
            [
                'title'          => 'Milestone One - Planning & Research: Software Company Foundation',
                'phase'          => 'Phase 1 - Foundation',
                'target_date'    => '2026-07-31',
                'current_status' => 'upcoming',
                'cost'           => 52100,
                'note'           => 'Complete all groundwork before development: product decisions, legal setup, brand identity, domain/hosting, and social presence.',
                'sort_order'     => 1,
            ],
            [
                'title'          => 'Milestone Two - Build Company Website & eCommerce Software',
                'phase'          => 'Phase 2 - Build',
                'target_date'    => '2026-10-31',
                'current_status' => 'upcoming',
                'cost'           => 128800,
                'note'           => 'Build the company portfolio website (Laravel + Vue.js) and the first product: a single-page eCommerce software with bKash/Nagad payment for the Bangladesh market.',
                'sort_order'     => 2,
            ],
            [
                'title'          => 'Milestone Three - Content Marketing & SEO Strategy Launched',
                'phase'          => 'Phase 3 - Marketing',
                'target_date'    => '2026-12-31',
                'current_status' => 'upcoming',
                'cost'           => 58400,
                'note'           => 'Publish 12+ blog posts, launch YouTube channel in Bangla, run social media content calendar, build email list, and achieve first-page Google ranking for 5 target keywords.',
                'sort_order'     => 3,
            ],
            [
                'title'          => 'Milestone Four - Sales Pipeline & CRM Setup Completed',
                'phase'          => 'Phase 3 - Marketing',
                'target_date'    => '2027-01-31',
                'current_status' => 'upcoming',
                'cost'           => 28400,
                'note'           => 'Configure CRM, document full sales process, build prospect list, finalize pricing and proposal templates, and close first 10 paying customers via direct outreach.',
                'sort_order'     => 4,
            ],
            [
                'title'          => 'Milestone Five - Paid Advertising Campaigns Go Live',
                'phase'          => 'Phase 4 - Growth',
                'target_date'    => '2027-03-31',
                'current_status' => 'upcoming',
                'cost'           => 32400,
                'note'           => 'Launch Facebook Ads and Google Ads campaigns. Target cost-per-lead under ৳500. Scale winning ads and build retargeting audiences for both website and eCommerce app.',
                'sort_order'     => 5,
            ],
            [
                'title'          => 'Milestone Six - Partnership & Reseller Program Launched',
                'phase'          => 'Phase 4 - Growth',
                'target_date'    => '2027-05-31',
                'current_status' => 'upcoming',
                'cost'           => 22400,
                'note'           => 'Sign 2+ agency partners and 3+ resellers in Bangladesh. Define commission structure (15-20% recurring), build partner toolkit, and co-launch first joint marketing campaign.',
                'sort_order'     => 6,
            ],
            [
                'title'          => 'Milestone Seven - ১০ লক্ষ টাকা MRR Target Achieved',
                'phase'          => 'Phase 5 - Scale',
                'target_date'    => '2027-12-31',
                'current_status' => 'upcoming',
                'cost'           => 36000,
                'note'           => 'Reach ১০,০০,০০০ BDT monthly recurring revenue through all 3 products, combined direct sales, resellers, and inbound marketing. Launch Inventory and Portfolio products.',
                'sort_order'     => 7,
            ],
        ];

        foreach ($milestones as $data) {
            $data['achieved_date'] = null;
            self::$model::create($data);
        }
    }
}
