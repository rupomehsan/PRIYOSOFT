<?php
namespace Modules\Management\FinanceManagement\IncomeCategory\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class="Modules\Management\FinanceManagement\IncomeCategory\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\IncomeCategory\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $categories = [
            [
                'name'        => 'Web Development',
                'slug'        => 'web-development',
                'description' => 'Revenue from custom website development projects including static sites, dynamic web apps, and admin panels.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Mobile App Development',
                'slug'        => 'mobile-app-development',
                'description' => 'Income from Android and iOS mobile application development for clients.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Software Licensing',
                'slug'        => 'software-licensing',
                'description' => 'Revenue from selling software licenses, SaaS subscriptions, and product keys.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Domain & Hosting Sales',
                'slug'        => 'domain-hosting-sales',
                'description' => 'Income from reselling domain registrations, shared hosting, VPS, and dedicated server packages.',
                'status'      => 'active',
            ],
            [
                'name'        => 'SEO & Digital Marketing',
                'slug'        => 'seo-digital-marketing',
                'description' => 'Revenue from SEO services, Google Ads management, social media marketing, and content marketing campaigns.',
                'status'      => 'active',
            ],
            [
                'name'        => 'UI/UX Design Services',
                'slug'        => 'ui-ux-design-services',
                'description' => 'Income from user interface design, wireframing, prototyping, and user experience consulting.',
                'status'      => 'active',
            ],
            [
                'name'        => 'E-commerce Development',
                'slug'        => 'ecommerce-development',
                'description' => 'Revenue from building e-commerce platforms, online shops, payment gateway integrations, and inventory systems.',
                'status'      => 'active',
            ],
            [
                'name'        => 'API Development & Integration',
                'slug'        => 'api-development-integration',
                'description' => 'Income from building REST APIs, third-party API integrations, and microservices architecture.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Maintenance & Support',
                'slug'        => 'maintenance-support',
                'description' => 'Recurring revenue from annual maintenance contracts, bug fixing, and ongoing technical support packages.',
                'status'      => 'active',
            ],
            [
                'name'        => 'IT Consulting',
                'slug'        => 'it-consulting',
                'description' => 'Income from technology consulting, system architecture planning, and strategic IT advisory services.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Training & Workshops',
                'slug'        => 'training-workshops',
                'description' => 'Revenue from technical training sessions, developer workshops, and online course subscriptions.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Cloud & DevOps Services',
                'slug'        => 'cloud-devops-services',
                'description' => 'Income from cloud migration, AWS/GCP/Azure setup, CI/CD pipeline configuration, and server management.',
                'status'      => 'active',
            ],
            [
                'name'        => 'ERP & CRM Development',
                'slug'        => 'erp-crm-development',
                'description' => 'Revenue from building custom ERP systems, CRM platforms, and enterprise resource management tools.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Graphic Design',
                'slug'        => 'graphic-design',
                'description' => 'Income from logo design, branding, brochure, business card, banner, and print media design services.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Content & Copywriting',
                'slug'        => 'content-copywriting',
                'description' => 'Revenue from website content writing, blog posts, product descriptions, and technical documentation.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Social Media Management',
                'slug'        => 'social-media-management',
                'description' => 'Income from managing Facebook, Instagram, LinkedIn, and YouTube pages for business clients.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Project Consultation Fee',
                'slug'        => 'project-consultation-fee',
                'description' => 'One-time fees charged for initial project scoping, requirement analysis, and technical feasibility consultation.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Government & Tender Projects',
                'slug'        => 'government-tender-projects',
                'description' => 'Revenue from government contracts, public sector tenders, and NGO-funded software projects.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Affiliate & Referral Income',
                'slug'        => 'affiliate-referral-income',
                'description' => 'Commission income earned from referring clients to partner companies or affiliate programs.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Other Income',
                'slug'        => 'other-income',
                'description' => 'Miscellaneous income not covered under any specific category, including ad-hoc tasks and one-off payments.',
                'status'      => 'active',
            ],
        ];

        foreach ($categories as $category) {
            self::$model::create($category);
        }
    }
}
