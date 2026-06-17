<?php
namespace Modules\Management\WebsiteManagement\BlogPost\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * php artisan db:seed --class="Modules\Management\WebsiteManagement\BlogPost\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\BlogPost\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $posts = [
            [
                'title'        => 'Why Your Business Needs an Ecommerce Platform Right Now',
                'excerpt'      => 'Customers shop online at midnight. They compare prices in seconds. If your business is not online, you are invisible to an entire generation of buyers. Here is why ecommerce is no longer optional.',
                'body'         => '<h2>The World Shops Online</h2><p>In Bangladesh, online retail grew over 70% between 2020 and 2024. Customers now expect to browse, compare, and buy without leaving home. A business without an online store loses sales every single day to a competitor who has one.</p><h2>Your Store Is Open 24 Hours</h2><p>A physical store closes at 9pm. An ecommerce platform never closes. A customer in Sylhet can browse your products at 2am and place an order before breakfast. You make revenue while you sleep.</p><h2>Lower Cost, Wider Reach</h2><p>Opening a physical branch in Chittagong costs rent, staff, and utilities. Opening an online store reaches Chittagong, Rajshahi, Khulna, and every district simultaneously. The marginal cost of serving one more customer online is nearly zero.</p><h2>Customer Data You Can Act On</h2><p>An ecommerce platform tells you which products customers view but do not buy, which search terms bring visitors, and where customers abandon checkout. A physical store tells you almost nothing about customer behavior.</p><h2>The Cost of Waiting</h2><p>Every month without an ecommerce presence is a month your competitors build customer habits. The best time to launch was two years ago. The second best time is now.</p>',
                'status'       => 'published',
                'published_at' => '2025-05-20 09:00:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why Inventory Management Software Is the Backbone of Retail Success',
                'excerpt'      => 'Running inventory on paper or spreadsheets is a hidden cost most businesses do not see until a crisis hits. Stockouts, overstock, theft, and expired goods drain profit silently.',
                'body'         => '<h2>The Hidden Cost of Poor Inventory Control</h2><p>When you run out of a fast-selling product, you lose the sale and potentially the customer permanently. When you overstock a slow-moving product, that money sits in a warehouse earning nothing. Both are inventory failures that cost real money every day.</p><h2>What Manual Inventory Actually Costs</h2><p>A mid-sized retailer managing inventory on spreadsheets loses 3-5% of revenue to inventory errors annually. On a business with 50 lakh taka in annual revenue, that is 1.5 to 2.5 lakh taka lost to miscounts, missed reorders, and expired goods.</p><h2>Real-Time Stock Visibility</h2><p>With inventory software, any staff member can see available stock at any location in real time. A customer asks if an item is available in the Mirpur branch? The Gulshan branch can answer instantly without a phone call.</p><h2>Automatic Reorder Points</h2><p>A good inventory system knows your average daily sales for each product and alerts you when stock drops to reorder level. You never run out of your best-selling products because a human forgot to check the shelf.</p><h2>Shrinkage and Theft Detection</h2><p>Without a system, shrinkage is invisible until it becomes catastrophic. With software tracking every item movement, discrepancies surface immediately and can be investigated before they become significant losses.</p>',
                'status'       => 'published',
                'published_at' => '2025-04-30 10:00:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why Every Business Needs a Professional Digital Portfolio in 2025',
                'excerpt'      => 'Before a client calls you, they search for you. What they find in the first 30 seconds determines whether they contact you or move on. A digital portfolio is your first impression and your only chance.',
                'body'         => '<h2>Your Digital Presence Is Your Reputation</h2><p>A potential client who hears about your company will search for you online before making contact. If they find nothing, or find an outdated page with no recent activity, the conversation is over before it starts.</p><h2>What a Portfolio Actually Shows</h2><p>A portfolio is not a brochure. A brochure says what you claim to offer. A portfolio shows what you have actually delivered. Past projects, client names, and case studies are evidence. Clients do not buy promises. They buy demonstrated capability.</p><h2>The Trust Factor in Business Sales</h2><p>Business purchasing decisions involve risk. A professional portfolio reduces perceived risk by answering the question every buyer asks silently: have you done this before, and did it work?</p><h2>Ranking in Search Results</h2><p>A professional website with a regularly updated portfolio ranks in search results. Businesses with active, content-rich websites appear when potential clients search. Businesses without websites do not appear at all.</p><h2>Your Portfolio Works While You Sleep</h2><p>A salesperson works eight hours a day. A portfolio works twenty-four. An inquiry submitted at 11pm on a Sunday costs your business nothing to receive. This is the leverage a digital portfolio provides.</p>',
                'status'       => 'published',
                'published_at' => '2025-04-10 08:30:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why Small Businesses Need Accounting Software — Not Spreadsheets',
                'excerpt'      => 'Most small business owners manage accounts in Excel or notebooks. This works until it does not. Here is what accounting software does that spreadsheets cannot.',
                'body'         => '<h2>The Spreadsheet Trap</h2><p>Spreadsheets are flexible, familiar, and free. They are also error-prone, unsecured, and incapable of producing the financial reports a growing business needs. A single mistyped number cascades through weeks of reports silently.</p><h2>Real-Time Profit and Loss</h2><p>In a spreadsheet system, knowing whether your business made money this month requires hours of manual work. Accounting software generates a profit and loss statement in seconds from transactions already in the system.</p><h2>Tax Compliance Without Panic</h2><p>VAT filing in Bangladesh requires organized records of every sale and purchase within the period. Accounting software tracks VAT on every transaction automatically and generates the submission report when you need it. Compliance becomes routine rather than a crisis.</p><h2>Bank Reconciliation in Minutes</h2><p>Matching your accounting records to your bank statement manually takes hours. Accounting software imports bank statements and matches transactions automatically, flagging only the exceptions that need human review.</p><h2>When You Need to Show Banks or Investors</h2><p>If you approach a bank for a business loan, they will ask for clean financial statements. Businesses that cannot produce organized financials are dismissed immediately. Accounting software produces standard reports that financial institutions recognize and trust.</p>',
                'status'       => 'published',
                'published_at' => '2025-03-25 09:00:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why Your HR Department Needs Software — Not Files and Folders',
                'excerpt'      => 'Managing 30 employees in folders and Excel sheets is possible. Managing 100 employees the same way is chaos. Here is what HRM software does for your team.',
                'body'         => '<h2>The File Cabinet Problem</h2><p>Every employee has a contract, performance reviews, leave records, salary history, and attendance data. For five employees, a file cabinet works. For fifty employees, finding any specific document takes ten minutes and the answer is often wrong.</p><h2>Leave Management Without Confusion</h2><p>In a manual system, a leave request passes through paper, approval, spreadsheet update, and payroll deduction — with mistakes possible at every handoff. HRM software handles the entire chain automatically with a complete audit trail.</p><h2>Payroll Accuracy at Scale</h2><p>Calculating payroll for 50 employees manually takes two or three days of careful work every month. One error can underpay an employee or overpay another. HRM software calculates payroll in minutes with no arithmetic errors.</p><h2>Attendance That Cannot Be Falsified</h2><p>A manual attendance register can be signed by anyone at any time. Biometric or digital attendance integrated with HRM software records exact arrival and departure times and feeds automatically into payroll.</p><h2>When You Need HRM Software</h2><p>If you have more than 20 employees and cannot answer how many leave days an employee has remaining in under 30 seconds, you need HRM software. The system pays for itself in the hours it returns to your HR team every single month.</p>',
                'status'       => 'published',
                'published_at' => '2025-02-18 10:30:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why a POS System Is the Most Important Technology Investment for Retail',
                'excerpt'      => 'A point-of-sale system is not a cash register upgrade. It is the central hub connecting your sales, inventory, staff, and accounting into one real-time picture.',
                'body'         => '<h2>More Than a Receipt Printer</h2><p>Every sale, every return, every discount, every payment method — all recorded automatically, all feeding into your inventory and accounting in real time. A POS system is the data collection point for your entire retail operation.</p><h2>Speed at the Counter Matters</h2><p>A slow checkout experience loses customers. Long queues during peak hours drive people to competitors. POS with barcode scanning and fast payment processing reduces average transaction time dramatically. During Eid rush or sale events, this difference is the difference between satisfied customers and abandoned queues.</p><h2>Inventory Updates Automatically</h2><p>Every item scanned at the counter is automatically deducted from inventory. When a product goes below its reorder point, the system alerts you. You never discover you are out of a best-seller by reaching for an empty shelf.</p><h2>Multiple Payment Methods Without Confusion</h2><p>Customers pay with bKash, Nagad, cards, and cash. A POS system handles all payment methods, records each one separately, and reconciles the day receipts automatically without manual tracking by your cashier.</p><h2>Multi-Branch in One View</h2><p>If you have more than one location, a cloud POS shows sales performance of every branch in real time from a single dashboard. You compare branches and make restocking decisions based on actual data rather than phone calls to each manager.</p>',
                'status'       => 'published',
                'published_at' => '2025-01-30 09:00:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why Businesses That Ignore Digital Transformation Fall Behind',
                'excerpt'      => 'Digital transformation is about doing what your business already does — faster, with fewer errors, and with better information. Here is what it means in practice for Bangladeshi businesses.',
                'body'         => '<h2>What Digital Transformation Actually Means</h2><p>For a Bangladeshi SME, digital transformation means replacing manual, paper-based, or spreadsheet-based processes with software that does the same work faster and more accurately. It is not about following a trend. It is about competing with businesses that have already made this shift.</p><h2>The Competitive Gap Is Already Open</h2><p>Competitors who adopted business software three years ago now process orders faster, restock before they run out, and calculate payroll in minutes instead of days. They make decisions with data. You may be making decisions with intuition and memory. That gap compounds over time.</p><h2>Where Most Businesses Start</h2><p>The most common first step is accounting software. The second step is usually POS or inventory software depending on the business type. The third step is connecting them so data flows between systems without manual reentry.</p><h2>Staff Adoption Is the Real Challenge</h2><p>The technical implementation of business software is rarely the hard part. Employees who have managed inventory in a notebook for five years will resist a software system. Successful transformation requires clear communication about why the change is happening and training that makes the new system manageable.</p><h2>Start Small, Build Systematically</h2><p>A business that makes one meaningful digital improvement every six months is transformed within three years. A business that tries to change everything simultaneously typically fails and reverts to the old way. Pick the process that causes the most pain, solve it, let the team settle, then move to the next.</p>',
                'status'       => 'published',
                'published_at' => '2024-12-22 08:00:00',
                'author_id'    => 1,
            ],
            [
                'title'        => 'Why CRM Software Changes How You Sell and How You Keep Clients',
                'excerpt'      => 'Most businesses lose clients not because of price or product quality but because of follow-up failures and poor communication history. A CRM system exists to solve exactly this problem.',
                'body'         => '<h2>The Follow-Up That Never Happened</h2><p>A sales conversation goes well. The client says they will think about it. You mean to follow up in three days. A week passes. The moment is gone. This happens in every business without a CRM. It is not a character failure. It is a systems failure.</p><h2>What a CRM Actually Does</h2><p>A CRM records every interaction with every prospect and client — calls, emails, meetings, quotes, proposals. It sets follow-up reminders. It tracks where each prospect is in the sales process. It stores contact history so any team member can pick up a conversation with full context.</p><h2>The Value of Context in Every Conversation</h2><p>When a client calls, do you know the last time you spoke to them, what you quoted, and whether they had a complaint last quarter? Without a CRM, this information lives in someone memory or nowhere. With a CRM, any team member has the full history in seconds. Clients feel known. That feeling builds loyalty.</p><h2>Sales Pipeline Visibility</h2><p>Without a CRM, the answer to how much business is in the pipeline is a guess. With a CRM, the pipeline is a live view: 8 prospects in initial contact, 4 in proposal stage, 2 in negotiation. Expected revenue is calculated automatically.</p><h2>Client Retention Is More Profitable Than Acquisition</h2><p>Acquiring a new client costs five to seven times more than retaining an existing one. A CRM tracks renewal dates, flags clients who have not purchased recently, and gives your team the information to reach out proactively before a client considers leaving.</p>',
                'status'       => 'published',
                'published_at' => '2024-11-15 09:30:00',
                'author_id'    => 1,
            ],
        ];

        foreach ($posts as $post) {
            self::$model::create($post);
        }
    }
}
