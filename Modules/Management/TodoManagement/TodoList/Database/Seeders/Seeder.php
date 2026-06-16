<?php
namespace Modules\Management\TodoManagement\TodoList\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoList\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\TodoManagement\TodoList\Database\Models\Model::class;

    static $groupModel = \Modules\Management\TodoManagement\TodoGroup\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $phaseTasks = [
            'Research' => [
                ['title' => 'Define research objectives and scope',              'priority' => 'high',   'estimated_days' => 1, 'note' => 'Agree on what success looks like before starting.'],
                ['title' => 'Collect data from primary and secondary sources',   'priority' => 'high',   'estimated_days' => 3, 'note' => 'Use surveys, interviews, reports, and competitor sites.'],
                ['title' => 'Analyse and synthesise findings',                   'priority' => 'medium', 'estimated_days' => 2, 'note' => 'Look for patterns, gaps, and opportunities.'],
                ['title' => 'Identify key insights and action points',           'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Prioritise top 5 insights that directly affect strategy.'],
                ['title' => 'Compile research report and share with team',       'priority' => 'low',    'estimated_days' => 1, 'note' => 'Keep it visual — charts and summaries over raw data.'],
            ],
            'Planning' => [
                ['title' => 'Define deliverables and acceptance criteria',       'priority' => 'high',   'estimated_days' => 1, 'note' => 'Clear definition of done prevents scope creep.'],
                ['title' => 'Break down work into sub-tasks and owners',         'priority' => 'high',   'estimated_days' => 1, 'note' => 'Each task should be completable in under 2 days.'],
                ['title' => 'Estimate effort and timeline',                      'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Add 20% buffer for unknowns.'],
                ['title' => 'Identify risks and mitigation strategies',          'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Flag blockers early to avoid last-minute delays.'],
                ['title' => 'Get stakeholder sign-off on plan',                  'priority' => 'low',    'estimated_days' => 1, 'note' => 'Document approval in writing.'],
            ],
            'Branding' => [
                ['title' => 'Draft initial concepts and mood board',             'priority' => 'high',   'estimated_days' => 2, 'note' => 'Gather 3 distinct visual directions for review.'],
                ['title' => 'Create first design iteration',                     'priority' => 'high',   'estimated_days' => 3, 'note' => 'Focus on logo, colour palette, and typography first.'],
                ['title' => 'Collect internal feedback and revise',              'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Run 2 rounds of revision maximum.'],
                ['title' => 'Finalise assets and export all formats',            'priority' => 'medium', 'estimated_days' => 1, 'note' => 'SVG, PNG (transparent), PDF, and dark/light variants.'],
                ['title' => 'Upload to brand asset library and document usage',  'priority' => 'low',    'estimated_days' => 1, 'note' => 'Include do/don\'t examples in brand guide.'],
            ],
            'Marketing' => [
                ['title' => 'Define campaign goal and target audience segment',  'priority' => 'high',   'estimated_days' => 1, 'note' => 'Be specific — one segment per campaign.'],
                ['title' => 'Write copy and create visual assets',               'priority' => 'high',   'estimated_days' => 3, 'note' => 'A/B test headline variations.'],
                ['title' => 'Internal review and compliance check',              'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Ensure brand voice consistency and legal compliance.'],
                ['title' => 'Schedule and publish across all channels',          'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Use a scheduling tool; stagger times by timezone.'],
                ['title' => 'Track KPIs and report performance after 7 days',   'priority' => 'low',    'estimated_days' => 1, 'note' => 'CTR, conversions, and engagement are primary metrics.'],
            ],
            'SEO' => [
                ['title' => 'Perform keyword research and map to pages',         'priority' => 'high',   'estimated_days' => 2, 'note' => 'Focus on keywords with high intent and low competition.'],
                ['title' => 'Audit on-page SEO for all target pages',            'priority' => 'high',   'estimated_days' => 2, 'note' => 'Check title tags, meta descriptions, headings, alt text.'],
                ['title' => 'Fix technical SEO issues (speed, schema, sitemap)', 'priority' => 'medium', 'estimated_days' => 2, 'note' => 'Use PageSpeed Insights and Screaming Frog.'],
                ['title' => 'Build 10 quality backlinks via outreach',           'priority' => 'medium', 'estimated_days' => 5, 'note' => 'Guest posts and resource page links preferred.'],
                ['title' => 'Monitor rankings weekly and report progress',       'priority' => 'low',    'estimated_days' => 1, 'note' => 'Track in Google Search Console and Ahrefs/SEMrush.'],
            ],
            'Content' => [
                ['title' => 'Research topic, angle, and target keyword',         'priority' => 'high',   'estimated_days' => 1, 'note' => 'Confirm search intent before writing.'],
                ['title' => 'Write detailed content outline',                    'priority' => 'high',   'estimated_days' => 1, 'note' => 'H2/H3 structure, key points, and CTA placement.'],
                ['title' => 'Write first draft',                                 'priority' => 'high',   'estimated_days' => 2, 'note' => 'Aim for comprehensive coverage — target 1500+ words.'],
                ['title' => 'Edit, proofread, and add visuals',                  'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Add custom screenshots, charts, or infographics.'],
                ['title' => 'Publish, share, and repurpose across channels',     'priority' => 'low',    'estimated_days' => 1, 'note' => 'Repurpose into LinkedIn post and email snippet.'],
            ],
            'Sales Setup' => [
                ['title' => 'Document the sales process end-to-end',            'priority' => 'high',   'estimated_days' => 2, 'note' => 'Map from first touch to signed contract.'],
                ['title' => 'Build email and call templates for each stage',     'priority' => 'high',   'estimated_days' => 2, 'note' => 'Personalisation tokens must be clearly marked.'],
                ['title' => 'Configure CRM pipeline stages and fields',          'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Mirror the documented sales process exactly.'],
                ['title' => 'Set up automation and follow-up sequences',         'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Max 5 touches per sequence; respect opt-outs.'],
                ['title' => 'Run a test deal through pipeline and QA',           'priority' => 'low',    'estimated_days' => 1, 'note' => 'Catch broken automations before going live.'],
            ],
            'Acquisition' => [
                ['title' => 'Build and validate prospect list (100 contacts)',   'priority' => 'critical','estimated_days' => 2, 'note' => 'Verify emails to keep bounce rate under 3%.'],
                ['title' => 'Send personalised outreach (batch 1 of 50)',        'priority' => 'high',   'estimated_days' => 1, 'note' => 'Reference a specific pain point per contact.'],
                ['title' => 'Follow up with non-responders after 3 days',        'priority' => 'high',   'estimated_days' => 1, 'note' => 'One follow-up only; keep it brief.'],
                ['title' => 'Book and conduct discovery calls',                  'priority' => 'medium', 'estimated_days' => 3, 'note' => 'Focus on their problem, not your product.'],
                ['title' => 'Send proposal and close',                           'priority' => 'medium', 'estimated_days' => 2, 'note' => 'Respond to all objections in writing within 24 hours.'],
            ],
            'Paid Ads' => [
                ['title' => 'Define campaign objective, budget, and KPIs',       'priority' => 'high',   'estimated_days' => 1, 'note' => 'Set target CAC and ROAS before spending any budget.'],
                ['title' => 'Create 3 ad creative variations per ad set',        'priority' => 'high',   'estimated_days' => 2, 'note' => 'Test different headlines, images, and CTAs.'],
                ['title' => 'Set up tracking pixels and conversion events',      'priority' => 'high',   'estimated_days' => 1, 'note' => 'Verify events fire correctly in test mode.'],
                ['title' => 'Launch campaign and monitor daily for 7 days',      'priority' => 'medium', 'estimated_days' => 7, 'note' => 'Pause ad sets with CTR under 1% after 500 impressions.'],
                ['title' => 'Optimise bids, audiences, and creatives',           'priority' => 'medium', 'estimated_days' => 2, 'note' => 'Scale winning ad sets by 20% per day maximum.'],
            ],
            'Partnerships' => [
                ['title' => 'Research and shortlist 10 potential partners',      'priority' => 'high',   'estimated_days' => 2, 'note' => 'Prioritise partners with complementary audience overlap.'],
                ['title' => 'Draft partnership proposal and value proposition',  'priority' => 'high',   'estimated_days' => 2, 'note' => 'Lead with what\'s in it for them, not you.'],
                ['title' => 'Reach out and schedule introductory calls',         'priority' => 'medium', 'estimated_days' => 3, 'note' => 'Target 3 warm leads via mutual connections first.'],
                ['title' => 'Negotiate terms and draft partnership agreement',   'priority' => 'medium', 'estimated_days' => 3, 'note' => 'Get legal review before signing. Cover IP and revenue split.'],
                ['title' => 'Onboard partner and co-launch first initiative',    'priority' => 'low',    'estimated_days' => 5, 'note' => 'Define success metrics upfront; review at 30 days.'],
            ],
            'Growth' => [
                ['title' => 'Analyse current metrics and identify bottlenecks',  'priority' => 'high',   'estimated_days' => 1, 'note' => 'Focus on the one metric that most impacts MRR.'],
                ['title' => 'Run growth experiment (A/B test or feature flag)',  'priority' => 'high',   'estimated_days' => 5, 'note' => 'Minimum 100 samples per variant for statistical significance.'],
                ['title' => 'Collect user feedback and NPS data',                'priority' => 'medium', 'estimated_days' => 3, 'note' => 'Survey churned users for the most honest feedback.'],
                ['title' => 'Implement winning changes based on data',           'priority' => 'medium', 'estimated_days' => 3, 'note' => 'Ship small, measure fast.'],
                ['title' => 'Report results and plan next growth sprint',        'priority' => 'low',    'estimated_days' => 1, 'note' => 'Update MRR dashboard and share with leadership.'],
            ],
        ];

        $defaultTasks = [
            ['title' => 'Define scope and success criteria',                 'priority' => 'high',   'estimated_days' => 1, 'note' => 'Align team before starting work.'],
            ['title' => 'Execute primary work and track progress',           'priority' => 'high',   'estimated_days' => 3, 'note' => 'Update status daily.'],
            ['title' => 'Review and gather feedback',                        'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Document all feedback.'],
            ['title' => 'Revise and finalise deliverable',                   'priority' => 'medium', 'estimated_days' => 1, 'note' => 'Ensure quality before handoff.'],
            ['title' => 'Close task and document learnings',                 'priority' => 'low',    'estimated_days' => 1, 'note' => 'Add to team knowledge base.'],
        ];

        $groups = self::$groupModel::orderBy('id')->get();
        $sort = 1;

        foreach ($groups as $group) {
            $tasks = $phaseTasks[$group->phase] ?? $defaultTasks;

            foreach ($tasks as $task) {
                self::$model::create([
                    'todo_group_id'  => $group->id,
                    'title'          => $task['title'],
                    'priority'       => $task['priority'],
                    'current_status' => 'pending',
                    'status'         => 'active',
                    'estimated_days' => $task['estimated_days'],
                    'note'           => $task['note'],
                    'assigned_to'    => null,
                    'is_recurring'   => 0,
                    'sort_order'     => $sort++,
                ]);
            }
        }
    }
}
