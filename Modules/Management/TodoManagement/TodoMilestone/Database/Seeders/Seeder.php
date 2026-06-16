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

        $milestones = [
            [
                'title'          => 'Market Research & Competitor Analysis',
                'phase'          => 'Business Planning',
                'target_date'    => '2026-07-15',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Identify top 10 competitors, pricing models, target audience segments, and market gaps for software positioning.',
                'sort_order'     => 1,
            ],
            [
                'title'          => 'Business Plan & Revenue Model Finalized',
                'phase'          => 'Business Planning',
                'target_date'    => '2026-08-01',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Define subscription tiers, one-time licensing, freemium model, and 3-year revenue projections.',
                'sort_order'     => 2,
            ],
            [
                'title'          => 'Brand Identity & Marketing Assets Ready',
                'phase'          => 'Marketing',
                'target_date'    => '2026-08-20',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Logo, color palette, brand guidelines, pitch deck, and social media profile creatives.',
                'sort_order'     => 3,
            ],
            [
                'title'          => 'Landing Page & Lead Capture System Live',
                'phase'          => 'Marketing',
                'target_date'    => '2026-09-01',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'SEO-optimized landing page with email capture, live chat, and CRM integration for lead management.',
                'sort_order'     => 4,
            ],
            [
                'title'          => 'Content Marketing & SEO Strategy Launched',
                'phase'          => 'Marketing',
                'target_date'    => '2026-09-20',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Publish 10 blog posts, 5 case studies, and initiate link-building. Target 20 high-value keywords.',
                'sort_order'     => 5,
            ],
            [
                'title'          => 'Sales Pipeline & CRM Setup Completed',
                'phase'          => 'Sales',
                'target_date'    => '2026-10-01',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Configure CRM (HubSpot/Zoho), define sales stages, create email templates, and set up follow-up automation.',
                'sort_order'     => 6,
            ],
            [
                'title'          => 'First 10 Paying Customers Onboarded',
                'phase'          => 'Sales',
                'target_date'    => '2026-11-01',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Close first 10 paid subscriptions via direct outreach, LinkedIn campaigns, and referral network.',
                'sort_order'     => 7,
            ],
            [
                'title'          => 'Paid Advertising Campaigns Go Live',
                'phase'          => 'Marketing',
                'target_date'    => '2026-11-15',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Launch Google Ads and Facebook/LinkedIn retargeting campaigns. Budget: $500/month. Target CAC under $80.',
                'sort_order'     => 8,
            ],
            [
                'title'          => 'Partnership & Reseller Program Launched',
                'phase'          => 'Sales',
                'target_date'    => '2026-12-01',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Onboard 3 agency partners and 2 resellers. Define commission structure (20% recurring revenue share).',
                'sort_order'     => 9,
            ],
            [
                'title'          => '$10,000 MRR Target Achieved',
                'phase'          => 'Growth',
                'target_date'    => '2027-03-01',
                'achieved_date'  => null,
                'current_status' => 'upcoming',
                'note'           => 'Reach $10K monthly recurring revenue through combined direct sales, partnerships, and inbound marketing.',
                'sort_order'     => 10,
            ],
        ];

        $words = ['One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten'];

        foreach ($milestones as $i => $data) {
            $data['title'] = 'Milestone ' . $words[$i] . ' - ' . $data['title'];
            $data['cost'] = 100;
            self::$model::create($data);
        }
    }
}