<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// User Management
use Modules\Management\UserManagement\Role\Database\Seeders\Seeder as RoleSeeder;
use Modules\Management\UserManagement\User\Database\Seeders\Seeder as UserSeeder;
use Modules\Management\UserManagement\UserNotification\Database\Seeders\Seeder as UserNotificationSeeder;

// Setting Management
use Modules\Management\SettingManagement\WebsiteSettings\Database\Seeders\Seeder as WebsiteSettingsSeeder;

// Product Management
use Modules\Management\ProductManagement\ProductGroup\Database\Seeders\Seeder as ProductGroupSeeder;
use Modules\Management\ProductManagement\Product\Database\Seeders\Seeder as ProductSeeder;

// Finance Management — Accounts & Categories
use Modules\Management\FinanceManagement\Account\Database\Seeders\Seeder as AccountSeeder;
use Modules\Management\FinanceManagement\IncomeCategory\Database\Seeders\Seeder as IncomeCategorySeeder;
use Modules\Management\FinanceManagement\ExpenseCategory\Database\Seeders\Seeder as ExpenseCategorySeeder;

// Finance Management — Investors
use Modules\Management\FinanceManagement\Investor\Database\Seeders\Seeder as InvestorSeeder;

// Finance Management — Transactions
use Modules\Management\FinanceManagement\Income\Database\Seeders\Seeder as IncomeSeeder;
use Modules\Management\FinanceManagement\Expense\Database\Seeders\Seeder as ExpenseSeeder;
use Modules\Management\FinanceManagement\Investment\Database\Seeders\Seeder as InvestmentSeeder;
use Modules\Management\FinanceManagement\Withdrawal\Database\Seeders\Seeder as WithdrawalSeeder;
use Modules\Management\FinanceManagement\AccountTransfer\Database\Seeders\Seeder as AccountTransferSeeder;

// Finance Management — Profit Sharing & Logs
use Modules\Management\FinanceManagement\ProfitDistribution\Database\Seeders\Seeder as ProfitDistributionSeeder;
use Modules\Management\FinanceManagement\TransactionLog\Database\Seeders\Seeder as TransactionLogSeeder;

// Website Management
use Modules\Management\WebsiteManagement\HeroSection\Database\Seeders\Seeder as HeroSectionSeeder;
use Modules\Management\WebsiteManagement\SiteSection\Database\Seeders\Seeder as SiteSectionSeeder;
use Modules\Management\WebsiteManagement\TeamMember\Database\Seeders\Seeder as TeamMemberSeeder;
use Modules\Management\WebsiteManagement\Testimonial\Database\Seeders\Seeder as TestimonialSeeder;
use Modules\Management\WebsiteManagement\BlogPost\Database\Seeders\Seeder as BlogPostSeeder;
use Modules\Management\WebsiteManagement\AboutUs\Database\Seeders\Seeder as AboutUsSeeder;
use Modules\Management\WebsiteManagement\Faq\Database\Seeders\Seeder as FaqSeeder;
use Modules\Management\WebsiteManagement\ContactLead\Database\Seeders\Seeder as ContactLeadSeeder;
use Modules\Management\WebsiteManagement\Subscriber\Database\Seeders\Seeder as SubscriberSeeder;
use Modules\Management\WebsiteManagement\WhoWeAre\Database\Seeders\Seeder as WhoWeAreSeeder;
// Order Management
use Modules\Management\OrderManagement\Order\Database\Seeders\Seeder as OrderSeeder;

// Todo Management
use Modules\Management\TodoManagement\TodoMilestone\Database\Seeders\Seeder as TodoMilestoneSeeder;
use Modules\Management\TodoManagement\TodoGroup\Database\Seeders\Seeder as TodoGroupSeeder;
use Modules\Management\TodoManagement\TodoList\Database\Seeders\Seeder as TodoListSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // User Management (no dependencies)
            RoleSeeder::class,
            UserSeeder::class,
            UserNotificationSeeder::class,
            WebsiteSettingsSeeder::class,

            // Product Management
            ProductGroupSeeder::class,
            ProductSeeder::class,          // depends on: ProductGroup

            // Finance — Accounts & Categories (no dependencies)
            AccountSeeder::class,
            IncomeCategorySeeder::class,
            ExpenseCategorySeeder::class,
            InvestorSeeder::class,

            // Finance — Transactions (depend on accounts/categories above)
            IncomeSeeder::class,           // depends on: IncomeCategory, Product, Account
            ExpenseSeeder::class,          // depends on: ExpenseCategory, Product, Account
            InvestmentSeeder::class,       // depends on: Investor, Account
            WithdrawalSeeder::class,       // depends on: Investor, Account
            AccountTransferSeeder::class,  // depends on: Account

            // Finance — Profit Sharing & Logs
            ProfitDistributionSeeder::class,
            TransactionLogSeeder::class,   // depends on: Account, Product, Investor

            // Website Management (most depend on Product)
            HeroSectionSeeder::class,
            SiteSectionSeeder::class,
            TeamMemberSeeder::class,
            TestimonialSeeder::class,      // depends on: Product
            BlogPostSeeder::class,         // depends on: User, Product
            AboutUsSeeder::class,
            FaqSeeder::class,              // depends on: Product
            ContactLeadSeeder::class,      // depends on: Product
            SubscriberSeeder::class,
            WhoWeAreSeeder::class,         // depends on: Product

            // Order Management
            OrderSeeder::class,            // depends on: Product, User

            // Todo Management
            TodoMilestoneSeeder::class,
            TodoGroupSeeder::class,
            TodoListSeeder::class,         // depends on: TodoGroup
        ]);
    }
}
