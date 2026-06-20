<?php
namespace Modules\Management\FinanceManagement\ExpenseCategory\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class="Modules\Management\FinanceManagement\ExpenseCategory\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\ExpenseCategory\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $categories = [
            [
                'name'        => 'Office Rent',
                'slug'        => 'office-rent',
                'description' => 'Monthly rent payments for office space, co-working desks, or business premises.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Staff Salaries',
                'slug'        => 'staff-salaries',
                'description' => 'Monthly salary payments to full-time employees, developers, designers, and support staff.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Freelancer Payments',
                'slug'        => 'freelancer-payments',
                'description' => 'Payments made to freelancers and contractors for project-based work or part-time contributions.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Server & Hosting Costs',
                'slug'        => 'server-hosting-costs',
                'description' => 'Expenses for VPS, dedicated servers, cloud hosting (AWS, GCP, DigitalOcean), and CDN services.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Domain Registration',
                'slug'        => 'domain-registration',
                'description' => 'Annual fees for registering and renewing domain names for company and client projects.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Software & SaaS Subscriptions',
                'slug'        => 'software-saas-subscriptions',
                'description' => 'Monthly or yearly fees for tools like Adobe CC, Figma, Slack, Zoom, GitHub, Jira, and other SaaS platforms.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Internet & Utilities',
                'slug'        => 'internet-utilities',
                'description' => 'Monthly bills for broadband internet, electricity, water, gas, and other office utility services.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Marketing & Advertising',
                'slug'        => 'marketing-advertising',
                'description' => 'Expenses for Facebook Ads, Google Ads, SEO tools, promotional campaigns, and brand marketing.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Equipment & Hardware',
                'slug'        => 'equipment-hardware',
                'description' => 'Purchases of laptops, desktops, monitors, routers, printers, and other IT hardware.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Office Supplies & Stationery',
                'slug'        => 'office-supplies-stationery',
                'description' => 'Costs for pens, paper, notebooks, printer ink, folders, and general office consumables.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Travel & Transportation',
                'slug'        => 'travel-transportation',
                'description' => 'Expenses for client visits, business travel, fuel, ride-shares, and public transport fares.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Training & Development',
                'slug'        => 'training-development',
                'description' => 'Costs for online courses, developer certifications, Udemy/Coursera subscriptions, and team workshops.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Legal & Compliance',
                'slug'        => 'legal-compliance',
                'description' => 'Fees for legal advice, trade license renewal, business registration, contracts, and regulatory compliance.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Accounting & Audit',
                'slug'        => 'accounting-audit',
                'description' => 'Payments to accountants, auditors, tax consultants, and bookkeeping service providers.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Bank Charges & Fees',
                'slug'        => 'bank-charges-fees',
                'description' => 'Bank service charges, wire transfer fees, payment gateway charges, and financial transaction costs.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Client Entertainment',
                'slug'        => 'client-entertainment',
                'description' => 'Expenses for client meetings, business lunches, dinners, and hospitality costs.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Project Outsourcing',
                'slug'        => 'project-outsourcing',
                'description' => 'Costs incurred when outsourcing parts of client projects to third-party agencies or development teams.',
                'status'      => 'active',
            ],
            [
                'name'        => 'SSL Certificates',
                'slug'        => 'ssl-certificates',
                'description' => 'Annual purchase and renewal of SSL/TLS certificates for company and client websites.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Taxes & Government Fees',
                'slug'        => 'taxes-government-fees',
                'description' => 'VAT, income tax, corporate tax, government levies, and other statutory payment obligations.',
                'status'      => 'active',
            ],
            [
                'name'        => 'Miscellaneous Expenses',
                'slug'        => 'miscellaneous-expenses',
                'description' => 'Unclassified or one-off operational expenses that do not fall under any specific category.',
                'status'      => 'active',
            ],
        ];

        foreach ($categories as $category) {
            self::$model::create($category);
        }
    }
}
