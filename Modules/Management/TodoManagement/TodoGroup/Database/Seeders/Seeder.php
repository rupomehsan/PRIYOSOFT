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

        $groups = [
            // Milestone 1: Market Research & Competitor Analysis
            1 => [
                ['name' => 'Identify Top 10 Competitors',           'phase' => 'Research'],
                ['name' => 'Analyze Competitor Pricing Models',      'phase' => 'Research'],
                ['name' => 'Define Target Audience Personas',        'phase' => 'Research'],
                ['name' => 'Survey Potential Customers',             'phase' => 'Research'],
                ['name' => 'Map Market Gaps & Opportunities',        'phase' => 'Research'],
                ['name' => 'Analyze SEO & Content Strategies',       'phase' => 'Research'],
                ['name' => 'Evaluate Competitor UX & Features',      'phase' => 'Research'],
                ['name' => 'Assess Market Size & Growth Rate',       'phase' => 'Research'],
                ['name' => 'Collect Industry Reports & Benchmarks',  'phase' => 'Research'],
                ['name' => 'Prepare Research Summary Report',        'phase' => 'Research'],
            ],
            // Milestone 2: Business Plan & Revenue Model
            2 => [
                ['name' => 'Define Product Vision & Mission',        'phase' => 'Planning'],
                ['name' => 'Design Subscription Tier Structure',     'phase' => 'Planning'],
                ['name' => 'Calculate Unit Economics & CAC/LTV',     'phase' => 'Planning'],
                ['name' => 'Build 3-Year Revenue Projection Model',  'phase' => 'Planning'],
                ['name' => 'Define Freemium vs Paid Strategy',       'phase' => 'Planning'],
                ['name' => 'Identify Key Cost Drivers',              'phase' => 'Planning'],
                ['name' => 'Set Break-Even & Profitability Targets', 'phase' => 'Planning'],
                ['name' => 'Draft Investor-Ready Executive Summary', 'phase' => 'Planning'],
                ['name' => 'Create Financial Risk Assessment',       'phase' => 'Planning'],
                ['name' => 'Legal Entity & Tax Structure Setup',     'phase' => 'Planning'],
            ],
            // Milestone 3: Brand Identity & Marketing Assets
            3 => [
                ['name' => 'Logo Design & Brand Mark',               'phase' => 'Branding'],
                ['name' => 'Define Brand Color Palette & Typography','phase' => 'Branding'],
                ['name' => 'Write Brand Voice & Messaging Guide',    'phase' => 'Branding'],
                ['name' => 'Design Social Media Profile Templates',  'phase' => 'Branding'],
                ['name' => 'Create Email Signature & Letterhead',    'phase' => 'Branding'],
                ['name' => 'Design Business Cards & Print Materials','phase' => 'Branding'],
                ['name' => 'Build Sales Pitch Deck (12 slides)',     'phase' => 'Branding'],
                ['name' => 'Design Product Screenshots & Mockups',   'phase' => 'Branding'],
                ['name' => 'Create Explainer Video Script',          'phase' => 'Branding'],
                ['name' => 'Compile Brand Asset Library',            'phase' => 'Branding'],
            ],
            // Milestone 4: Landing Page & Lead Capture
            4 => [
                ['name' => 'Write Landing Page Copy & Headlines',    'phase' => 'Marketing'],
                ['name' => 'Design Landing Page Wireframes',         'phase' => 'Marketing'],
                ['name' => 'Develop & Deploy Landing Page',          'phase' => 'Marketing'],
                ['name' => 'Integrate Email Capture Form',           'phase' => 'Marketing'],
                ['name' => 'Set Up CRM & Lead Pipeline',             'phase' => 'Marketing'],
                ['name' => 'Configure Live Chat Widget',             'phase' => 'Marketing'],
                ['name' => 'Add Testimonials & Social Proof',        'phase' => 'Marketing'],
                ['name' => 'Implement A/B Testing for CTA Buttons',  'phase' => 'Marketing'],
                ['name' => 'Set Up Google Analytics & Heatmaps',     'phase' => 'Marketing'],
                ['name' => 'Configure Lead Nurture Email Sequence',  'phase' => 'Marketing'],
            ],
            // Milestone 5: Content Marketing & SEO
            5 => [
                ['name' => 'Perform Keyword Research (Top 50)',      'phase' => 'SEO'],
                ['name' => 'Publish 5 Long-Form Blog Posts',         'phase' => 'Content'],
                ['name' => 'Write 3 Detailed Case Studies',          'phase' => 'Content'],
                ['name' => 'Create YouTube Tutorial Videos',         'phase' => 'Content'],
                ['name' => 'Set Up LinkedIn Content Calendar',       'phase' => 'Content'],
                ['name' => 'Launch Weekly Email Newsletter',         'phase' => 'Content'],
                ['name' => 'Build Backlink Outreach List',           'phase' => 'SEO'],
                ['name' => 'Submit to 10 Software Directories',      'phase' => 'SEO'],
                ['name' => 'Optimize On-Page SEO for All Pages',     'phase' => 'SEO'],
                ['name' => 'Create Downloadable Lead Magnet (PDF)',  'phase' => 'Content'],
            ],
            // Milestone 6: Sales Pipeline & CRM Setup
            6 => [
                ['name' => 'Select & Configure CRM Platform',        'phase' => 'Sales Setup'],
                ['name' => 'Define Sales Stages & Deal Criteria',    'phase' => 'Sales Setup'],
                ['name' => 'Write Cold Email Outreach Templates',    'phase' => 'Sales Setup'],
                ['name' => 'Build Prospect List (500 contacts)',     'phase' => 'Sales Setup'],
                ['name' => 'Set Up Follow-Up Automation Sequences',  'phase' => 'Sales Setup'],
                ['name' => 'Create Sales Call Script & Objections',  'phase' => 'Sales Setup'],
                ['name' => 'Design Proposal & Quote Template',       'phase' => 'Sales Setup'],
                ['name' => 'Configure Contract & e-Sign Workflow',   'phase' => 'Sales Setup'],
                ['name' => 'Set Sales KPIs & Weekly Reporting',      'phase' => 'Sales Setup'],
                ['name' => 'Train Sales Team on Product Demo',       'phase' => 'Sales Setup'],
            ],
            // Milestone 7: First 10 Paying Customers
            7 => [
                ['name' => 'Launch LinkedIn Outreach Campaign',      'phase' => 'Acquisition'],
                ['name' => 'Send 200 Cold Emails (Week 1)',          'phase' => 'Acquisition'],
                ['name' => 'Conduct 20 Discovery Calls',             'phase' => 'Acquisition'],
                ['name' => 'Deliver 10 Product Demo Sessions',       'phase' => 'Acquisition'],
                ['name' => 'Send 10 Customized Proposals',           'phase' => 'Acquisition'],
                ['name' => 'Activate Referral Incentive Program',    'phase' => 'Acquisition'],
                ['name' => 'Post in 5 Relevant Online Communities',  'phase' => 'Acquisition'],
                ['name' => 'Onboard First Customer with Hands-On',   'phase' => 'Acquisition'],
                ['name' => 'Collect NPS & Feedback from Customers',  'phase' => 'Acquisition'],
                ['name' => 'Publish First Customer Success Story',   'phase' => 'Acquisition'],
            ],
            // Milestone 8: Paid Advertising Campaigns
            8 => [
                ['name' => 'Set Up Google Ads Account & Billing',    'phase' => 'Paid Ads'],
                ['name' => 'Build 3 Google Search Ad Campaigns',     'phase' => 'Paid Ads'],
                ['name' => 'Create LinkedIn Lead Gen Ad Creatives',  'phase' => 'Paid Ads'],
                ['name' => 'Design Facebook Retargeting Audiences',  'phase' => 'Paid Ads'],
                ['name' => 'Install Pixel & Conversion Tracking',    'phase' => 'Paid Ads'],
                ['name' => 'Set Daily Budget Caps & Bid Strategies', 'phase' => 'Paid Ads'],
                ['name' => 'Write 5 Ad Copy Variations per Channel', 'phase' => 'Paid Ads'],
                ['name' => 'Design 10 Ad Banner Creatives',          'phase' => 'Paid Ads'],
                ['name' => 'Monitor & Optimize Weekly (First Month)','phase' => 'Paid Ads'],
                ['name' => 'Report on CAC, ROAS, and Conversions',   'phase' => 'Paid Ads'],
            ],
            // Milestone 9: Partnership & Reseller Program
            9 => [
                ['name' => 'Define Partner Tiers & Commission Rates','phase' => 'Partnerships'],
                ['name' => 'Write Partner Agreement Contract',        'phase' => 'Partnerships'],
                ['name' => 'Build Partner Onboarding Portal',        'phase' => 'Partnerships'],
                ['name' => 'Create Partner Marketing Toolkit',       'phase' => 'Partnerships'],
                ['name' => 'Identify & Shortlist 20 Agency Partners','phase' => 'Partnerships'],
                ['name' => 'Pitch to Top 5 Agency Prospects',        'phase' => 'Partnerships'],
                ['name' => 'Sign First 3 Reseller Agreements',       'phase' => 'Partnerships'],
                ['name' => 'Train Partners on Product & Sales Flow', 'phase' => 'Partnerships'],
                ['name' => 'Set Up Partner Revenue Tracking',        'phase' => 'Partnerships'],
                ['name' => 'Launch Co-Marketing Campaign with Partner','phase' => 'Partnerships'],
            ],
            // Milestone 10: $10,000 MRR Target
            10 => [
                ['name' => 'Track MRR Dashboard Weekly',             'phase' => 'Growth'],
                ['name' => 'Reduce Churn Below 3% Monthly',          'phase' => 'Growth'],
                ['name' => 'Launch Upsell Campaign to Existing Users','phase' => 'Growth'],
                ['name' => 'Introduce Annual Plan Discount (20%)',    'phase' => 'Growth'],
                ['name' => 'Run Product Hunt Launch Campaign',        'phase' => 'Growth'],
                ['name' => 'Feature in 3 Industry Newsletters',      'phase' => 'Growth'],
                ['name' => 'Close 2 Enterprise Deals ($500+/mo)',     'phase' => 'Growth'],
                ['name' => 'Launch Affiliate Program',               'phase' => 'Growth'],
                ['name' => 'Expand to 2nd Target Market Segment',    'phase' => 'Growth'],
                ['name' => 'Celebrate $10K MRR & Plan Next Phase',   'phase' => 'Growth'],
            ],
        ];

        $sort = 1;
        foreach ($groups as $milestoneId => $items) {
            foreach ($items as $item) {
                self::$model::create([
                    'todo_milestone_id' => $milestoneId,
                    'name'              => $item['name'],
                    'phase'             => $item['phase'],
                    'sort_order'        => $sort++,
                    'current_status'            => 'pending',
                    'cost'              => 500,
                ]);
            }
        }
    }
}
