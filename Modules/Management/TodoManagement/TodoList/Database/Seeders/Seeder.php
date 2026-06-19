<?php
namespace Modules\Management\TodoManagement\TodoList\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="Modules\Management\TodoManagement\TodoList\Database\Seeders\Seeder"
     */
    static $model      = \Modules\Management\TodoManagement\TodoList\Database\Models\Model::class;
    static $groupModel = \Modules\Management\TodoManagement\TodoGroup\Database\Models\Model::class;

    // Self-work daily rate in BDT — change here to update all task costs
    const RATE = 800;

    // Work task: days × rate = item_cost
    private static function w(string $title, float $days, string $priority, string $note): array
    {
        return [
            'title'          => $title,
            'priority'       => $priority,
            'estimated_days' => $days,
            'daily_rate'     => self::RATE,
            'fixed_cost'     => 0,
            'item_cost'      => $days * self::RATE,
            'note'           => $note,
        ];
    }

    // Fixed-cost task: out-of-pocket purchase (no daily rate)
    private static function f(string $title, float $fixedCost, string $priority, string $note): array
    {
        return [
            'title'          => $title,
            'priority'       => $priority,
            'estimated_days' => 0,
            'daily_rate'     => 0,
            'fixed_cost'     => $fixedCost,
            'item_cost'      => $fixedCost,
            'note'           => $note,
        ];
    }

    // Mixed task: work time + out-of-pocket expense
    private static function m(string $title, float $days, float $fixedCost, string $priority, string $note): array
    {
        return [
            'title'          => $title,
            'priority'       => $priority,
            'estimated_days' => $days,
            'daily_rate'     => self::RATE,
            'fixed_cost'     => $fixedCost,
            'item_cost'      => ($days * self::RATE) + $fixedCost,
            'note'           => $note,
        ];
    }

    public function run(): void
    {
        self::$model::truncate();

        // Key = group->phase value from group seeder. Must match exactly.
        $phaseTasks = [

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 1 — Planning & Research
            // ────────────────────────────────────────────────────────────────────────────

            'Product Research' => [
                self::w('Define scope and feature list for eCommerce product',           2, 'high',   'Focus on BD online shop owners: product catalog, orders, delivery tracking, bKash checkout.'),
                self::w('Define scope and feature list for Inventory product',           1, 'high',   'Target small wholesalers and shops: stock in/out, supplier management, low-stock alerts.'),
                self::w('Define scope and feature list for Business Portfolio product',  1, 'high',   'Target freelancers and agencies: showcase projects, clients, services, contact form.'),
                self::w('Research BD market demand and competition per product',         3, 'high',   'Check local competitors, Daraz sellers, Shajgoj, BASIS member companies. Note pricing.'),
                self::w('Identify target customer segments',                             1, 'medium', 'Segment by size (micro, small, medium), location (Dhaka vs mofossol), tech literacy.'),
                self::w('Finalize MVP feature list for first launch product',            2, 'high',   'Keep MVP to core 70% features — ship fast, then add more based on real customer feedback.'),
                self::w('Decide product development priority order',                     1, 'medium', 'Recommendation: eCommerce first (highest BD demand), Inventory second, Portfolio third.'),
                self::w('Document product research summary (1-page per product)',        1, 'medium', 'Cover: problem, target user, MVP scope, competitors, estimated price point.'),
            ],

            'Company Legal' => [
                self::w('Brainstorm and shortlist company name options (10+)',            1, 'high',   'Short, memorable, Bangla-friendly, easy to say and type. Check for embarrassing meanings.'),
                self::w('Check name availability: RJSC, domain, all social handles',    1, 'high',   'Use rjsc.gov.bd for company search. Check .com on Namecheap. Same name on all socials.'),
                self::w('Finalize company name and brand direction',                     1, 'high',   'Get full team agreement before starting any design — changing name later is very costly.'),
                self::m('Apply for Trade License from City Corporation',                 2, 3000, 'high',   'Documents: NID, photo, utility bill, rent agreement. Fee ~৳2000-৳4000. Takes 3-7 days.'),
                self::w('Apply for e-TIN certificate from NBR Bangladesh (nbr.gov.bd)', 1, 'medium', 'Free online registration. Required for bank account, invoicing, and VAT registration.'),
                self::w('Open company bank account (Dutch Bangla / BRAC / City Bank)',  1, 'high',   'Bring: Trade License, TIN, NID, company seal. Needed for bKash merchant and SSLCommerz.'),
                self::w('Scan and store all legal certificates in Google Drive',         1, 'medium', 'Create shared "Company Legal" folder. Label files clearly. Never keep originals only.'),
            ],

            'Logo Design' => [
                self::w('Define brand mood, personality, and collect reference logos',   1, 'high',   'Tone: professional, tech-forward, locally trusted. Collect 10+ reference logos you admire.'),
                self::w('Sketch initial logo concepts (3 different directions)',         1, 'high',   'Paper sketch is fine — focus on shape and concept, not polish. Show team for first reaction.'),
                self::w('Design logo in Canva Pro or Adobe Illustrator',                2, 'high',   'Vector format required. Start with Canva Pro (~৳500/mo) — fast for non-designers.'),
                self::w('Create logo variations: icon only, horizontal, stacked',       1, 'high',   'All variations must look good at 16px favicon size and 2000px wide banner size.'),
                self::w('Design dark and light background versions',                    1, 'medium', 'Dark version for social media covers. Light version for white website background.'),
                self::w('Export all formats: PNG (transparent), SVG, PDF, ICO',         1, 'medium', 'PNG at 256, 512, 1024px. SVG for web. ICO for browser favicon. PDF for print.'),
                self::w('Define brand color palette and typography',                    1, 'medium', 'Max 3 brand colors. Document HEX, RGB, CMYK values. Choose 1 heading + 1 body font.'),
                self::w('Write 1-page brand style guide (colors, fonts, do/don\'t)',    1, 'low',    'Share with everyone who creates content. Prevents inconsistent branding across channels.'),
            ],

            'Social Media Setup' => [
                self::w('Create and verify Facebook Business Page',                     1, 'high',   'Facebook is the #1 marketing channel in BD. Add logo, cover, bio, website, WhatsApp.'),
                self::w('Create Facebook Group for customer community',                 1, 'medium', 'Name after niche not brand (e.g., "BD eCommerce Sellers Network") — easier to grow.'),
                self::w('Create LinkedIn Company Page',                                 1, 'high',   'Important for B2B credibility, partnerships, investor visibility, and team recruitment.'),
                self::w('Create YouTube Channel with full profile setup',               1, 'high',   'Add banner, about, links. First video: 60-second company intro. Publish within first week.'),
                self::w('Create Instagram Business Account',                            1, 'medium', 'Link to Facebook Page for cross-posting. Add website link in bio. Category: Software Company.'),
                self::w('Create TikTok Business Account',                              1, 'low',    'Growing fast in BD especially under 30 audience. Good for product demo short videos.'),
                self::w('Standardize username, bio, and links across all platforms',    1, 'high',   'All handles identical or as close as possible. Bio in both Bangla and English.'),
                self::w('Upload logo and cover design to all social profiles',          1, 'high',   'Use correctly sized assets from Creative Design group for each platform format.'),
                self::w('Enable 2-factor authentication on all social accounts',        1, 'high',   'Use Google Authenticator app. BD account hacks are very common — never skip this.'),
                self::w('Save all credentials in a shared password manager',            1, 'high',   'Use Bitwarden (free) or encrypted Google Sheet. Include recovery codes for each account.'),
            ],

            'Email Management' => [
                self::w('Create primary company Gmail account',                         1, 'high',   'e.g. priysoftcorner@gmail.com — use strong password and add recovery phone and email.'),
                self::w('Set up role Gmail aliases (support@, info@, admin@)',          1, 'high',   'Gmail allows aliases free. Route all to primary inbox with different color labels.'),
                self::w('Design professional email signature with logo',                1, 'high',   'Include: name, role, phone, website, social links. Use MySignature.io or Canva.'),
                self::w('Set up Gmail labels, filters, and folders',                    1, 'medium', 'Labels: Clients, Leads, Legal, Finance, Support. Auto-filter incoming by sender domain.'),
                self::w('Configure out-of-office auto-reply message',                  1, 'low',    'State 24-hour response commitment. Include WhatsApp and Facebook Messenger links.'),
                self::w('Enable 2-factor authentication on all email accounts',        1, 'high',   'Critical — this Gmail controls all other service registrations. Use Authenticator app.'),
                self::w('Store all email credentials securely',                        1, 'high',   'Document recovery codes and backup email. Keep offline encrypted copy.'),
            ],

            'Creative Design' => [
                self::w('Design Facebook Page cover photo (820×312px)',                 1, 'high',   'Show tagline, logo, and one clear CTA. Refresh monthly to show new products/offers.'),
                self::w('Design LinkedIn company banner (1128×191px)',                  1, 'high',   'Professional tone. Show products, team photo, and brief value proposition text.'),
                self::w('Design YouTube channel art (2560×1440px)',                    1, 'high',   'Safe area 1546×423px for all devices. Include subscribe CTA and posting schedule.'),
                self::w('Design Instagram highlight cover icons (set of 6)',            1, 'medium', 'Covers: About, Products, Reviews, Team, FAQ, Contact. Consistent brand colors.'),
                self::w('Design launch announcement post template',                    1, 'high',   'First post on all platforms. Make it bold and shareable. Include launch date CTA.'),
                self::w('Design product feature showcase post template',               1, 'high',   'Reusable template to highlight one feature per post — consistent style builds trust.'),
                self::w('Design promotional offer post template',                      1, 'medium', 'For seasonal offers, Eid campaigns, and discount promotions. Bangla text friendly.'),
                self::w('Set up Canva Team brand kit (logo, colors, fonts)',           1, 'medium', 'Brand kit ensures all team members use correct assets — no more off-brand designs.'),
            ],

            'Print Materials' => [
                self::w('Decide visiting card layout, size, and information',           1, 'high',   'Standard BD: 3.5×2 inch. Include: name, role, phone, email, website, QR code to site.'),
                self::w('Design front side of visiting card',                           1, 'high',   'Logo prominently placed. Use brand colors. White space is good — less is more.'),
                self::w('Design back side of visiting card',                           1, 'medium', 'Services list, tagline, or social handles. Optional: QR code linking to demo video.'),
                self::w('Get feedback and finalize visiting card design',              1, 'medium', 'Show to 3-5 people outside the team. Triple-check phone number and email for typos.'),
                self::f('Print 500 visiting cards (local BD print shop)',              800, 'high',  '500 cards ~৳500-৳1000. Ask for 300gsm paper with glossy laminated finish.'),
                self::w('Design company letterhead (A4 format)',                       1, 'medium', 'Header: logo + address. Footer: phone, email, website. Use for proposals and legal docs.'),
                self::w('Design invoice and quotation template (PDF ready)',           1, 'medium', 'Must include: itemized list, BDT amounts, VAT field, payment via bKash/bank info.'),
            ],

            'Domain Hosting' => [
                self::w('Finalize domain name (.com strongly preferred)',               1, 'high',   'Short, matches company name exactly. Avoid hyphens. Also check .com.bd availability.'),
                self::m('Purchase domain from Namecheap or GoDaddy',                   1, 1200, 'high', '.com ~৳1200-৳1500/year on Namecheap. Enable auto-renew and domain privacy protection.'),
                self::w('Research and select best hosting provider',                   1, 'high',   'Options: ExonHost BD (BDT billing, local support), DigitalOcean (VPS), SiteGround.'),
                self::m('Purchase hosting plan (shared or VPS, 1 year)',               1, 3500, 'high', 'Shared ~৳2000-৳3000/yr. VPS ~৳4000-৳6000/yr. Start shared, upgrade when needed.'),
                self::w('Connect domain DNS to hosting server',                        1, 'high',   'Update A record and CNAME in domain panel. DNS propagates in 15 min to 48 hours.'),
                self::w('Install and verify SSL certificate (HTTPS)',                  1, 'high',   'Most hosts include free Let\'s Encrypt SSL. Verify green padlock before showing anyone.'),
                self::w('Set up automated daily backup system',                        1, 'medium', 'Enable cPanel backup to remote storage. Test restore procedure — backups mean nothing untested.'),
                self::w('Test website uptime and loading speed',                       1, 'medium', 'Use GTmetrix for speed. Set up UptimeRobot free monitoring — alerts you on downtime.'),
                self::w('Document all hosting credentials in password manager',        1, 'high',   'Save: cPanel/hPanel login, FTP, database credentials, SSH key. Never lose these.'),
            ],

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 2 — Company Website & eCommerce Software
            // ────────────────────────────────────────────────────────────────────────────

            'Website Design' => [
                self::w('Map all website pages, sections, and navigation structure',   1, 'high',   'Pages: Home, Products (3), Features, Pricing, About, Blog, Contact. Draft sitemap.'),
                self::w('Create low-fidelity wireframes for all pages (Figma/Canva)', 3, 'high',   'Agree on layout structure before adding colors or real content. Cheap to change now.'),
                self::w('Design homepage: hero, features overview, testimonials, CTA', 2, 'high',  'Hero must answer in 5 seconds: what we do, for whom, and why choose us.'),
                self::w('Design product and features detail pages',                    2, 'high',   'One page per product (eCommerce, Inventory, Portfolio) with screenshots and benefits.'),
                self::w('Design pricing page with plan comparison in BDT',             1, 'high',   'BD customers expect clear BDT pricing. Add bKash/Nagad payment method badges.'),
                self::w('Design about us page and contact page',                      1, 'medium', 'Team photos build trust in BD. Contact page: form + WhatsApp + Messenger + Map.'),
                self::w('Design responsive mobile layout for all pages',               2, 'high',   '70%+ BD internet users are on mobile. Approve mobile layout before writing any code.'),
                self::w('Review and finalize all designs with team',                   1, 'medium', 'Sign off on designs before development. Changes in design = free. In code = expensive.'),
            ],

            'Website Frontend' => [
                self::w('Set up Vue.js + Inertia.js project and routing structure',   1, 'high',   'Follow existing Modules pattern in this codebase. Reuse layout, nav, and footer components.'),
                self::w('Build homepage (hero, products, features, testimonials)',     3, 'high',   'Smooth scroll animations. Parallax hero optional. Product section links to each product page.'),
                self::w('Build product and features detail pages',                     2, 'high',   'One page per product. Feature list with icons. Screenshot gallery. Demo CTA button.'),
                self::w('Build pricing page with plan comparison and FAQ accordion',   2, 'high',   'Highlight recommended plan. "Contact us" CTA for custom/enterprise. Yearly discount toggle.'),
                self::w('Build about us page with team cards and company timeline',    1, 'medium', 'Team cards with photo, name, role, LinkedIn. Timeline shows company milestones.'),
                self::w('Build contact page with form, social links, and map',        1, 'medium', 'Form posts to backend API. WhatsApp and Messenger buttons. Embed Google Maps.'),
                self::w('Build blog listing and blog detail pages',                   2, 'medium', 'Category filter and search bar. Social share buttons on each post. SEO-friendly URLs.'),
                self::w('Implement responsive design and test on real mobile device',  2, 'high',   'Test on actual Android phone (Symphony/Tecno/Samsung A-series). Not just browser DevTools.'),
                self::w('Add page-load animations and smooth transitions',             1, 'low',    'Fade-in on scroll for sections. Keep subtle — no flashy effects that slow down the page.'),
                self::w('Cross-browser test: Chrome, Firefox, Edge, Safari mobile',   1, 'medium', 'Chrome is 90%+ BD market share. Test Safari for iPhone users in the target market.'),
            ],

            'Website Backend' => [
                self::w('Set up Laravel project with module structure',                2, 'high',   'Follow existing Modules/ folder pattern. Register all modules in ApiRoutes.php.'),
                self::w('Build site settings module (logo, name, colors, social)',    2, 'high',   'Single source of truth for all dynamic site content. Cached — frontend reads via API.'),
                self::w('Build pages and sections CMS (hero text, features, pricing)',3, 'high',   'Admin edits all page content without code. Stores in DB, served via API to frontend.'),
                self::w('Build team members management module',                       1, 'medium', 'CRUD: photo upload, name, role, bio, LinkedIn URL. Ordered by sort_order field.'),
                self::w('Build testimonials management module',                       1, 'medium', 'Fields: name, company, photo, rating (1-5), testimonial text. Status: active/inactive.'),
                self::w('Build blog posts with categories, tags, and SEO fields',     2, 'medium', 'TipTap or CKEditor rich text. SEO: meta title, description, OG image. Slug auto-generated.'),
                self::w('Build contact form API and email notification to admin',     1, 'high',   'Store lead in DB. Send email to admin on submission. Mark as read/responded in panel.'),
                self::w('Build newsletter subscriber API',                            1, 'medium', 'Simple email sign-up. Export CSV. Mailchimp sync optional later.'),
                self::w('Set up admin authentication, roles, and permissions',        2, 'high',   'Use existing Sanctum setup. Role-based: super admin, content manager, support staff.'),
                self::w('API testing for all modules (Postman collection)',            1, 'medium', 'Test every CRUD endpoint before connecting frontend. Document in shared Postman workspace.'),
            ],

            'Website Content' => [
                self::w('Write homepage hero copy and product taglines',               1, 'high',   'Headline: benefit-focused, not feature-focused. "Grow your shop online" not "Our software".'),
                self::w('Write product feature descriptions for all 3 products',       2, 'high',   'Pain → solution format. Bullet points under 20 words. Avoid technical jargon.'),
                self::w('Write about us story and team bios',                         1, 'medium', 'Founding story in 3 sentences. Bios: name, role, 1-line expertise. Authentic, not corporate.'),
                self::w('Write and publish 5 SEO-focused blog posts',                 5, 'medium', 'Topics: eCommerce for BD shops, inventory tips, portfolio guide, software pricing, bKash.'),
                self::w('Implement on-page SEO: meta tags, OG, structured data',      2, 'high',   'Title tags under 60 chars. Meta desc under 155 chars. All images need descriptive alt text.'),
                self::w('Set up Google Analytics 4 and Google Search Console',        1, 'high',   'GA4 for traffic. Search Console for rankings and indexing. Verify domain ownership.'),
                self::w('Submit XML sitemap to Google Search Console',                1, 'high',   'Laravel-generated sitemap. Submit and check coverage report — fix any errors immediately.'),
                self::w('Set up Facebook Pixel for ad retargeting',                   1, 'medium', 'Add pixel to all pages. Create Custom Audiences for website visitors (future ad campaigns).'),
            ],

            'eCommerce Planning' => [
                self::w('Define eCommerce product MVP scope for BD market',            2, 'high',   'Must-have: product catalog, search, cart, bKash/Nagad checkout, order tracking, admin panel.'),
                self::w('Design eCommerce database schema',                            2, 'high',   'Tables: products, categories, variants, orders, order_items, payments, customers, coupons.'),
                self::w('Create UI/UX wireframes for all customer screens',            3, 'high',   'Screens: home, category, product detail, cart, checkout, confirmation, account, order history.'),
                self::w('Design storefront UI (Daraz-style familiar layout)',          2, 'high',   'BD shoppers trust familiar layouts. Product grid with filter sidebar. Quick-add-to-cart.'),
                self::w('Design product detail page: gallery, variants, cart button', 2, 'high',   'Multi-image swipe gallery. Variant selection updates price/stock live. Stock indicator.'),
                self::w('Design single-page checkout with bKash as first option',     2, 'high',   'One page only. bKash/Nagad first. Auto-fill address from profile. Clear delivery ETA.'),
                self::w('Design admin panel for products and orders',                  2, 'high',   'Admin: add/edit products, view/manage orders, update status, print invoice PDF.'),
                self::w('Review all designs and get sign-off before development',     1, 'medium', 'Confirm with potential customer too if possible. One revision round maximum.'),
            ],

            'eCommerce Backend' => [
                self::w('Set up eCommerce module structure in Laravel',                2, 'high',   'Modules: Products, Categories, Orders, Customers, Coupons, Reports, Payments.'),
                self::w('Build product and category CRUD API with image upload',       3, 'high',   'Product variants (size, color). Image compression on upload. Multiple images per product.'),
                self::w('Build customer auth: register, login, OTP by phone',         2, 'high',   'Phone + OTP is preferred in BD. Email login as secondary. Sanctum token auth.'),
                self::w('Build shopping cart API (add, update, remove, coupon)',      2, 'high',   'Guest cart via session token. Merge guest cart with user cart on login.'),
                self::w('Build order management API (create, update status, history)',3, 'high',   'Statuses: pending → confirmed → processing → shipped → delivered → cancelled.'),
                self::w('Build inventory tracking (stock per product and variant)',    2, 'high',   'Auto-decrement on order. Alert admin when stock below threshold. Prevent overselling.'),
                self::w('Build coupon and discount system',                            2, 'medium', 'Types: % off, flat BDT off, free delivery. Min order value, per-user limit, expiry date.'),
                self::w('Build admin orders dashboard API (filter, search, export)',  2, 'medium', 'Filter by status, date, payment method. CSV export for accounting and finance team.'),
                self::w('Build sales reporting API for admin dashboard',              2, 'medium', 'Daily/monthly totals, top products, peak hours. Feeds the admin analytics charts.'),
                self::w('Write API tests for all critical checkout and payment flows', 2, 'medium', 'Test: add to cart, apply coupon, checkout, payment callback, stock decrement edge cases.'),
            ],

            'eCommerce Frontend' => [
                self::w('Build product listing with filter, sort, and infinite scroll', 3, 'high',  'Filter by category, price range, rating. Sort: popular, newest, price. Mobile-optimized.'),
                self::w('Build product detail page with gallery and variant selector', 2, 'high',   'Swipe gallery on mobile. Variant selection updates price and availability in real time.'),
                self::w('Build cart and wishlist pages',                               2, 'high',   'Cart with quantity editor and coupon field. Wishlist requires login. Persistent across sessions.'),
                self::w('Build customer registration and login pages',                 2, 'high',   'Phone + OTP login preferred. Email login secondary. Social login (Google) optional later.'),
                self::w('Build single-page checkout (address, delivery, payment)',    3, 'high',   'Auto-fill from saved address. bKash/Nagad first. Order summary sidebar. No steps/pages.'),
                self::w('Build order confirmation and live tracking page',             2, 'high',   'Show estimated delivery. Status timeline. WhatsApp support link. Share order button.'),
                self::w('Build customer profile and order history',                   1, 'medium', 'Edit profile, address book, change password, order list with status badges and re-order.'),
                self::w('Build admin product management panel',                        3, 'high',   'Drag-and-drop image upload. Bulk status toggle. Quick inline edit for price/stock.'),
                self::w('Build admin order management panel',                          2, 'high',   'Filter and search. Update status with note. Print invoice as PDF. Assign delivery person.'),
                self::w('Implement responsive mobile design across all pages',         3, 'high',   'Test on low-end Android (512MB RAM, slow 3G). Think Daraz-quality mobile experience.'),
            ],

            'eCommerce Payment' => [
                self::w('Integrate SSLCommerz (cards, bank, all MFS in one)',         3, 'high',   'SSLCommerz covers Visa, Mastercard, bKash, Nagad, Rocket in single integration. Free setup.'),
                self::w('Integrate bKash Checkout API directly',                      2, 'high',   'bKash has 60M+ BD users — highest priority. Use bKash Payment Gateway API v1.2.'),
                self::w('Integrate Nagad payment method',                             2, 'high',   'Nagad growing fast outside Dhaka. Merchant API: create payment → verify → update order.'),
                self::w('Build Cash on Delivery (COD) option and order flow',        1, 'medium', 'COD is 50%+ of BD orders. Mark as paid when driver collects. Status: cod_pending → paid.'),
                self::w('Build IPN/callback handler and payment verification',        2, 'high',   'Verify every payment via gateway API before marking order confirmed. Log all callbacks.'),
                self::w('Test all payment flows in sandbox mode',                     2, 'high',   'Test success, failure, timeout, and double-payment for each method. Use test credentials.'),
                self::w('Build refund and dispute handling admin flow',               2, 'medium', 'Admin marks refund in panel. Notify customer via SMS or email. Log refund reason.'),
                self::w('Document all payment integrations for team',                 1, 'medium', 'API credentials location, test cards, sandbox dashboard URLs, callback endpoint details.'),
            ],

            'Testing QA' => [
                self::w('Write test cases for all critical customer flows',            2, 'high',   'Flows: register → browse → add to cart → checkout → pay → receive confirmation email.'),
                self::w('Functional testing of all company website pages',            2, 'high',   'Test every link, form, and CTA. Verify no console errors. Check on Chrome, Firefox.'),
                self::w('Functional testing of all eCommerce flows end-to-end',       3, 'high',   'Test as real customer on mobile device. Catch UX issues, not just code bugs.'),
                self::w('Cross-browser and cross-device testing',                     2, 'high',   'Devices: iPhone, mid-range Android, laptop. Focus on Chrome (90% BD market share).'),
                self::w('Performance and page load speed testing',                    1, 'medium', 'Target: under 3 seconds on 4G. Use GTmetrix. Fix: image compression, query optimization.'),
                self::w('Security testing: auth, CSRF, SQL injection, XSS, uploads', 2, 'high',   'Test all API endpoints for unauthorized access. Test file upload for malicious file bypass.'),
                self::w('Fix all critical and high-priority bugs',                    3, 'high',   'Critical = blocks user from completing purchase. Must be fixed before go-live. No exceptions.'),
                self::w('User acceptance testing with 3-5 real non-technical users', 2, 'medium', 'Ask a shopkeeper to place a real order. Observe confusion points silently — do not guide.'),
            ],

            'Deployment' => [
                self::w('Configure production server (PHP 8.2, MySQL, Redis, Nginx)', 1, 'high',   'Follow Laravel 11 deployment checklist. Set APP_ENV=production, APP_DEBUG=false.'),
                self::w('Set up CI/CD deployment pipeline (GitHub Actions)',           2, 'medium', 'Auto-deploy on merge to main. Run tests, build assets, clear cache, notify team on Slack.'),
                self::w('Deploy company website to production server',                 1, 'high',   'Run migrations, seed essential data, clear caches. Verify every page before announcing.'),
                self::w('Deploy eCommerce app to production server',                  1, 'high',   'Deploy in off-peak hours (midnight). Have complete rollback plan ready before starting.'),
                self::w('Configure HTTPS, security headers, and server firewall',     1, 'high',   'Headers: HSTS, X-Frame-Options, CSP. Disable directory listing. Close all unused ports.'),
                self::w('Set up uptime monitoring and real-time error alerts',        1, 'high',   'UptimeRobot (free) for uptime. Sentry.io for real-time code errors to your email/Slack.'),
                self::w('Final smoke test on production (real purchase end-to-end)',  1, 'high',   'Place a real order with real payment (৳1 if possible). Confirm order email received.'),
                self::w('Publish launch announcement on all social media',            1, 'high',   'Coordinate Facebook, LinkedIn, WhatsApp group posts simultaneously at launch time.'),
                self::w('Collect initial feedback from first 7 days of users',       2, 'medium', 'Google Form survey. Share in customer WhatsApp group. Aim for 10+ responses minimum.'),
                self::w('Log post-launch bugs and improvement backlog',              1, 'medium', 'Everything reported in first week goes into a prioritized backlog for next sprint.'),
            ],

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 3 — Content Marketing & SEO
            // ────────────────────────────────────────────────────────────────────────────

            'Blog Strategy' => [
                self::w('Define content topics, target audience, and posting frequency', 1, 'high',  '2 posts/week minimum for first 3 months. Topics: BD eCommerce tips, inventory, software.'),
                self::w('Research top 50 keywords for BD software market',              2, 'high',   'Use Google Keyword Planner (free). Focus: high intent + low competition keywords in Bangla+English.'),
                self::w('Build 3-month content calendar (12 blog posts)',               1, 'high',   'Plan topic, target keyword, target reader, and publish date for each post. Share with team.'),
                self::w('Write and publish 4 SEO-focused blog posts (Month 1)',        8, 'high',   '2 days per post: 1 day writing + 1 day editing, images, SEO, and formatting. 1500+ words each.'),
                self::w('Repurpose each blog post into 3 social media posts',          2, 'medium', 'Blog → Facebook post + LinkedIn article + Instagram carousel. Maximum reach per piece.'),
                self::w('Set up comment section and respond to all early comments',    1, 'low',    'Comments signal engagement to Google. Reply within 24 hours to all comments.'),
            ],

            'SEO Optimization' => [
                self::w('Perform keyword research: local BD and international terms',  2, 'high',   'Use Google Search Console, Ubersuggest (free), and AnswerThePublic for keyword ideas.'),
                self::w('Optimize all website pages: title tags, meta, headings, alt', 2, 'high',   'Every page needs unique title (under 60 chars) and meta description (under 155 chars).'),
                self::w('Create XML sitemap and submit to Google Search Console',      1, 'high',   'Laravel generates sitemap automatically. Submit and check coverage report weekly.'),
                self::w('Fix technical SEO: speed, schema markup, canonical tags',    2, 'high',   'Use Google PageSpeed Insights. Add FAQ schema, product schema, and organization schema.'),
                self::w('Build 10 quality backlinks via guest posts and directories', 5, 'high',   'Target: BD tech blogs, BASIS, software review sites (Capterra, Software World). 2/week.'),
                self::w('Submit website to BD and international software directories', 1, 'medium', 'List on: Capterra, GetApp, SourceForge, G2, and Bangladesh tech directories.'),
                self::w('Monitor and report keyword rankings weekly',                  1, 'medium', 'Track target keywords in Google Search Console. Document week-over-week movement.'),
                self::w('Build internal linking structure across all blog posts',      1, 'low',    'Each blog post should link to 3 other relevant posts. Boosts crawl depth and time on site.'),
            ],

            'YouTube Content' => [
                self::w('Plan 12 YouTube videos (4 per month for 3 months)',           1, 'high',   'Topics: how to use eCommerce software, inventory management tutorial, portfolio setup.'),
                self::w('Write scripts for first 4 videos',                           2, 'high',   'Script: hook (first 15 sec), main content, CTA (like/subscribe/contact). Max 10 minutes.'),
                self::w('Record and edit 2 eCommerce tutorial videos in Bangla',      4, 'high',   'Screen recording + face cam preferred. Use OBS (free) for recording. DaVinci Resolve for edit.'),
                self::w('Record and edit 2 Inventory software tutorial videos',       4, 'high',   'Show real use case: adding products, creating purchase order, viewing stock report.'),
                self::w('Add Bangla subtitles and keyword-rich descriptions',         1, 'medium', 'YouTube auto-subtitles then manually correct. Description: keyword in first 2 lines.'),
                self::w('Design eye-catching thumbnails for all videos',              1, 'medium', 'High contrast, face + text. Use Canva. A/B test thumbnail CTR in YouTube Studio.'),
            ],

            'Social Content' => [
                self::w('Create monthly content calendar for all social platforms',    1, 'high',   '3 Facebook posts/week, 1 LinkedIn article/week, daily Instagram story, 1 YouTube/week.'),
                self::w('Design and schedule 12 Facebook posts (Month 1)',            4, 'high',   'Mix: product tips (50%), company behind-the-scenes (20%), promotions (30%). Use Meta Business Suite.'),
                self::w('Create 4 short video Reels/TikToks (Month 1)',               4, 'high',   '30-60 second product demos or tips. Shot on phone is fine — authenticity beats production quality.'),
                self::w('Post daily Instagram stories (product tips and updates)',     2, 'medium', 'Stories: polls, Q&A stickers, countdown to launches. High engagement with BD audience.'),
                self::w('Write and publish 2 LinkedIn articles (Month 1)',            2, 'medium', 'Professional insights: "How small BD shops can grow with eCommerce" — B2B credibility.'),
                self::w('Manage Facebook community group (post and reply daily)',     2, 'medium', 'Pin weekly discussion question. Reply to every comment within 3 hours during business hours.'),
            ],

            'Email Marketing' => [
                self::w('Set up Mailchimp account (free tier up to 500 contacts)',    1, 'high',   'Free tier: 500 subscribers, 1000 emails/month. Enough for first 6 months of growth.'),
                self::w('Build email list via website signup form and social media',  2, 'high',   'Offer lead magnet for signup. Target 200 subscribers in first 3 months.'),
                self::w('Write 5-email welcome drip sequence for new subscribers',    2, 'high',   'Email 1: welcome + lead magnet. 2: company story. 3: product intro. 4: social proof. 5: CTA.'),
                self::w('Design branded email template in Mailchimp',                 1, 'medium', 'Use logo, brand colors, footer with address and unsubscribe link (CAN-SPAM/GDPR required).'),
                self::w('Send weekly newsletter with tips, updates, and offers',      2, 'medium', 'Subject lines in Bangla perform well with BD audience. Keep under 300 words. One clear CTA.'),
                self::w('Track and improve open rates and click-through rates',       1, 'medium', 'Target: 25%+ open rate, 5%+ CTR. Test different subject lines with A/B testing.'),
            ],

            'Lead Magnet' => [
                self::w('Define lead magnet topic relevant to BD business owners',    1, 'high',   'Ideas: "eCommerce Checklist for BD Shops", "How to Set Up Online Store in 7 Days".'),
                self::w('Write and design a 10-15 page PDF guide',                   3, 'high',   'Use Canva for design. Include actionable steps, local examples, and link to your software.'),
                self::w('Build landing page for lead magnet download',               1, 'high',   'Simple page: problem → solution → what you get → email form. No distractions.'),
                self::w('Set up auto-email delivery of lead magnet PDF after signup', 1, 'high',   'Mailchimp automation: subscriber signs up → immediately receives download link email.'),
                self::w('Promote lead magnet on all social platforms and blog posts', 1, 'medium', 'Pin post on Facebook Page. Add CTA in every blog post. Instagram bio link. LinkedIn post.'),
            ],

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 4 — Sales Pipeline & CRM
            // ────────────────────────────────────────────────────────────────────────────

            'CRM Setup' => [
                self::w('Evaluate CRM options: HubSpot free, Zoho, Bitrix24',        1, 'high',   'HubSpot free tier is best for BD startup: generous limits, easy to use, no BDT cost.'),
                self::w('Set up and configure CRM with pipeline stages',              2, 'high',   'Stages: Lead → Contacted → Demo Booked → Demo Done → Proposal Sent → Closed Won/Lost.'),
                self::w('Import existing leads and contacts into CRM',               1, 'high',   'Import from spreadsheet. Tag each lead with source: Facebook, referral, WhatsApp, event.'),
                self::w('Set up task reminders and follow-up automation',             1, 'medium', 'Auto-create follow-up task 3 days after no response. Never let a lead go cold manually.'),
                self::w('Train team on CRM usage and daily update discipline',       1, 'medium', 'Team must update deal stage and notes after every call or message. No CRM = no visibility.'),
            ],

            'Sales Process' => [
                self::w('Document end-to-end sales process (first contact to close)', 2, 'high',   'Map: discovery → qualification → demo → proposal → negotiation → close → handoff.'),
                self::w('Write cold outreach templates (Facebook DM and WhatsApp)',   2, 'high',   'Personalize by industry. Open with their pain point, not your product. Under 100 words.'),
                self::w('Write sales call script and objection handling guide',       2, 'high',   'Common BD objections: "too expensive", "we use WhatsApp already", "not ready now".'),
                self::w('Set up follow-up sequence (day 1, 3, 7, 14 after no reply)',1, 'medium', 'Max 4 follow-ups. After 4 with no reply, archive and revisit in 3 months.'),
                self::w('Train on product demo: all 3 software products',            2, 'high',   'Demo should be 15 minutes max. Show the 3 biggest pain-solvers first, not all features.'),
            ],

            'Lead Generation' => [
                self::w('Identify and list 200 target businesses in Bangladesh',      2, 'high',   'Sources: Facebook groups for BD businesses, bazaar pages, Pathao merchant list, BASIS.'),
                self::w('Send Facebook DMs to 50 local shop owners (Week 1)',         1, 'high',   'Personalized message referencing their business. Not copy-paste spam. 10 per day max.'),
                self::w('Post in 5 major BD business Facebook Groups daily',          2, 'high',   'Groups: BD Business Network, SME Forum, eCommerce Bangladesh. Value-first, no hard sell.'),
                self::w('Reach out via LinkedIn to SME owners and decision-makers',   2, 'medium', 'Connect + message in same request. Mention their industry + your specific solution.'),
                self::w('Activate referral program for first customers',              1, 'medium', '1 month free or 10% commission per referral. Word-of-mouth is the strongest BD channel.'),
                self::w('Attend BD tech events (BASIS Softexpo, ICT Expo, meetups)', 2, 'medium', 'Bring 50 visiting cards. Demo on laptop. Collect business cards with WhatsApp numbers.'),
            ],

            'Proposal System' => [
                self::w('Design professional proposal and quotation template',        1, 'high',   'One-page: problem, your solution, features included, investment (BDT), next step CTA.'),
                self::w('Create pricing tiers in BDT (monthly and yearly)',           1, 'high',   'Example: Basic ৳2000/month, Pro ৳4000/month, Annual 20% discount. Simple, not complex.'),
                self::w('Write feature comparison table for each pricing tier',       1, 'high',   'What each tier includes. Highlight most popular plan. Keep it honest and clear.'),
                self::w('Design proposal delivery workflow (PDF sent via email/WhatsApp)', 1, 'medium', 'Send within 24 hours of demo. Follow up in 48 hours. Set 7-day expiry on offer.'),
                self::w('Create customer contract and service agreement template',    1, 'medium', 'Cover: scope, payment terms, support hours, refund policy. Keep it simple and in plain English.'),
            ],

            'Client Onboarding' => [
                self::w('Design customer welcome email and onboarding checklist',     1, 'high',   'Send within 1 hour of payment. Include: login link, getting started guide, support contact.'),
                self::w('Create step-by-step setup guide (PDF or short video)',       2, 'high',   'First 5 steps a new customer should take. Under 1000 words or under 5 minutes video.'),
                self::w('Set up dedicated WhatsApp group per new client',             1, 'medium', 'Add client + 1 team member. Respond within 2 hours. This builds trust faster than email.'),
                self::w('Conduct 30-minute live onboarding session via Zoom/Google Meet', 1, 'high', 'Walk through their first setup together. Identify their most urgent use case.'),
                self::w('Send 30-day NPS survey and collect early feedback',          1, 'medium', 'Google Form: rate 1-10, what could be better, would you recommend us? Track all responses.'),
            ],

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 5 — Paid Advertising Campaigns
            // ────────────────────────────────────────────────────────────────────────────

            'Facebook Ads' => [
                self::w('Set up Facebook Business Manager and Ad Account',            1, 'high',   'Business Manager → create Ad Account in BDT. Add payment method (bKash or card).'),
                self::w('Define campaign objective, monthly budget, and KPIs',        1, 'high',   'Start: ৳5000/month. KPIs: cost per lead under ৳500, CTR above 1.5%. Awareness first.'),
                self::w('Build target audiences (interest, lookalike, retargeting)',  1, 'high',   'Interest: small business owners, shop owners, entrepreneurs in Bangladesh. Lookalike of website visitors.'),
                self::w('Write 5 ad copy variations for each campaign',               2, 'high',   'Vary: headline, pain point angle, CTA. Test in Bangla and English. Keep under 125 chars.'),
                self::w('Launch awareness campaign targeting BD business owners',     2, 'high',   'Objective: Reach or Video Views. Budget ৳150/day. Monitor for 7 days before changing.'),
                self::w('Launch lead generation campaign with Facebook Lead Form',    2, 'high',   'Pre-filled form reduces friction. Collect: name, phone, business type. Sync to CRM.'),
                self::w('Monitor and optimize weekly (pause underperforming ads)',    2, 'medium', 'Pause ad sets with CPL above ৳800 after 500 impressions. Scale winners by 20% weekly.'),
            ],

            'Google Ads' => [
                self::w('Set up Google Ads account and billing in BDT',               1, 'high',   'Google Ads now accepts BDT payments via card. Get ৳3000 free credit on first ৳3000 spend.'),
                self::w('Perform keyword research for Google Search Ads',             1, 'high',   'Target: "ecommerce software Bangladesh", "inventory management software BD", "online shop software".'),
                self::w('Write 3 responsive search ad variations per product',        2, 'high',   'Headlines: 30 chars max. Descriptions: 90 chars max. Include price and BDT CTA.'),
                self::w('Set up Google Search campaigns for each product',            1, 'high',   'Separate campaign per product. Tight ad groups by keyword intent (brand vs generic vs competitor).'),
                self::w('Configure conversion tracking and Google remarketing',       1, 'high',   'Track: form submissions, sign-ups, demo requests. Install Google tag on all pages.'),
                self::w('Monitor spend, CTR, and conversions weekly',                 2, 'medium', 'Pause keywords with CTR below 1% after 200 impressions. Target CPA under ৳600.'),
            ],

            'Ad Creatives' => [
                self::w('Design 10 Facebook ad image variations (1200×628px)',        3, 'high',   'Test: product screenshot vs lifestyle, dark vs bright background, with/without text overlay.'),
                self::w('Script and produce 5 short product demo videos (30-60 sec)', 5, 'high',  'Screen recording of software in action. Hook in first 3 seconds. Bangla voiceover preferred.'),
                self::w('Design 5 Facebook story ad creatives (1080×1920px)',         2, 'high',   'Vertical format. Large text readable without sound. Swipe-up CTA to landing page.'),
                self::w('Design Google Display Network banners (all required sizes)', 2, 'medium', 'Sizes: 728×90, 300×250, 336×280, 160×600, 300×600, 320×50 (mobile). Use Canva templates.'),
                self::w('Write ad copy for all campaigns (headline, body, CTA)',      2, 'medium', 'Different angles: save time, grow revenue, easy to use, BD customer support, free trial.'),
            ],

            'Campaign Optimization' => [
                self::w('Analyze 2-week performance data for each campaign',          1, 'high',   'Compare: CPM, CTR, CPL, conversion rate. Identify which audience and creative wins.'),
                self::w('A/B test: image vs video, Bangla vs English copy, audiences',3, 'high',  'Run 2 variants simultaneously with equal budget. Minimum 500 impressions per variant.'),
                self::w('Scale winning ad sets (increase budget 20% per week)',       1, 'high',   'Only scale if CPL is below ৳500. Gradual scaling prevents CPL spike from algorithm reset.'),
                self::w('Optimize landing page to reduce bounce and improve conversion', 2, 'high', 'Add customer testimonials, trust badges (SSL, local company), FAQ section, and chat widget.'),
                self::w('Build monthly ad performance report (spend, leads, CPL)',    1, 'medium', 'Track: total spend, leads generated, cost per lead, best performing creative, best audience.'),
            ],

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 6 — Partnership & Reseller Program
            // ────────────────────────────────────────────────────────────────────────────

            'Partner Program' => [
                self::w('Define partnership tiers: affiliate, reseller, agency',      1, 'high',   'Affiliate: one-time referral fee. Reseller: buys and resells. Agency: white-label or bundle.'),
                self::w('Set commission structure (15-20% recurring for BD context)', 1, 'high',   '20% recurring monthly is competitive in BD. Annual plan commission paid upfront.'),
                self::w('Write partner agreement contract (get legal review)',        2, 'high',   'Cover: commission structure, payment terms, IP rights, termination clause, non-compete.'),
                self::w('Build partner documentation and sales toolkit',              2, 'high',   'Kit includes: product brochure, pricing sheet, demo access, pitch deck, email templates.'),
                self::w('Create partner landing page on company website',             1, 'medium', 'Page: benefits, tiers, how it works, application form. Clean and conversion-focused.'),
            ],

            'Agency Outreach' => [
                self::w('Research and list 20 digital agencies in Bangladesh',        2, 'high',   'Search: BASIS member list, Facebook agency groups, LinkedIn. Target web dev and marketing agencies.'),
                self::w('Draft personalized partnership proposal for agencies',       1, 'high',   'Lead with their benefit: earn recurring income, expand service offering, zero dev cost.'),
                self::w('Reach out to top 5 agencies via email and phone call',       2, 'high',   'Email first, follow up with phone after 3 days. Reference specific agency work/clients.'),
                self::w('Conduct 5 partnership discovery meetings',                   2, 'high',   '30-minute meeting. Listen more than talk. Understand their client base and pain points.'),
                self::w('Sign first 2 agency partner agreements',                     1, 'high',   'Start with trusted referral partners. Formalize with signed contract and onboarding call.'),
            ],

            'Reseller Onboarding' => [
                self::w('Create reseller product training guide and video',           2, 'high',   'Cover: product features, target customers, common objections, demo walkthrough, pricing.'),
                self::w('Conduct live product training with first batch of resellers',1, 'high',   '2-hour Zoom session. Record and share for future resellers. Q&A at the end.'),
                self::w('Set up reseller sub-accounts on each platform',             1, 'high',   'Each reseller needs admin access to manage their clients. Track their customer count.'),
                self::w('Provide reseller sales kit (brochure, demo access, pricing)',2, 'medium', 'Printable PDF brochure in Bangla. Link to live demo site with reseller credentials.'),
                self::w('Monthly performance check-in with each reseller',           1, 'medium', 'Track: deals they closed, support issues, feedback from their clients. Celebrate wins.'),
            ],

            'Co Marketing' => [
                self::w('Plan first joint marketing campaign with partner agency',    1, 'high',   'Define: goal (leads or awareness), channels, budget split, shared content, success metric.'),
                self::w('Create co-branded content and ad creatives',                2, 'high',   'Both logos on all assets. Consistent message that serves both audiences. Partner reviews first.'),
                self::w('Launch co-marketing campaign across both channels',          1, 'high',   'Simultaneous publish on both Facebook pages. Cross-promote each other\'s audiences.'),
                self::w('Track leads and sales attributed to partner channels',       1, 'medium', 'Use UTM links per partner. Track in CRM — tag all leads with partner name as source.'),
                self::w('Report results and plan next joint initiative',             1, 'medium', 'Share data transparently with partner. Plan next campaign if ROI was positive for both.'),
            ],

            // ────────────────────────────────────────────────────────────────────────────
            //  MILESTONE 7 — ১০ লক্ষ BDT MRR
            // ────────────────────────────────────────────────────────────────────────────

            'Revenue Growth' => [
                self::w('Set up MRR tracking dashboard (Google Sheets or CRM)',       1, 'high',   'Track: new MRR, expansion MRR, churned MRR, net MRR movement. Update every Monday.'),
                self::w('Analyze monthly churn rate and identify top churn reasons', 1, 'high',   'Talk to every churned customer within 7 days. Understand real reason — price, support, missing feature.'),
                self::w('Launch annual plan upsell campaign (20% discount)',           2, 'high',   'Target: existing monthly customers. Offer 2 months free on annual. Email + WhatsApp outreach.'),
                self::w('Run upsell campaign to upgrade customers to higher tier',    2, 'high',   'Show customers features they are missing by being on lower tier. Personalize per account.'),
                self::w('Identify top revenue sources and double down on them',       1, 'medium', 'Which channel, industry, or product drives most MRR? Put 80% of resources into top 20%.'),
            ],

            'Customer Retention' => [
                self::w('Implement NPS survey at 30, 60, 90 days after signup',      1, 'high',   'Google Form sent by email and WhatsApp. Score 0-10. Follow up personally with detractors.'),
                self::w('Build YouTube tutorial library (1 video per feature)',       3, 'high',   'Customers who understand the product deeply churn much less. Video reduces support load too.'),
                self::w('Create dedicated WhatsApp group for customer community',     1, 'medium', 'Customers helping each other = free support + social proof. Moderate and post weekly tips.'),
                self::w('Proactively call customers who haven\'t logged in for 7 days', 2, 'high',  'Early warning of churn. Call — not email. Ask what stopped them. Fix the friction.'),
                self::w('Launch loyalty reward: 1 month free on each yearly renewal', 1, 'medium', 'Simple reward that increases renewal rate. Announce in advance so customers plan around it.'),
            ],

            'Product Expansion' => [
                self::w('Complete and launch Inventory Management software',          5, 'high',   'Second product launch. Announce to existing eCommerce customers as complementary tool.'),
                self::w('Complete and launch Business Portfolio software',            5, 'high',   'Third product. Target freelancers and agencies. Soft launch with 5 beta users first.'),
                self::w('Implement top 10 most-requested features from feedback',     5, 'high',   'Collect all feature requests in Trello or GitHub Issues. Ship most-voted monthly.'),
                self::w('Build integration between eCommerce and Inventory products', 5, 'high',   'Orders in eCommerce auto-deduct stock in Inventory. Biggest value-add for existing customers.'),
                self::w('Create demo videos for all 3 products in Bangla',           3, 'medium', 'Professional 3-5 minute demo per product. Use for sales, onboarding, and YouTube.'),
            ],

            'Business Scaling' => [
                self::w('Hire first part-time customer support staff',               2, 'high',   'Profile: Bangla/English fluent, basic software knowledge, WhatsApp proficient. Pay: ৳15000-৳20000/mo.'),
                self::w('Document all business processes for team handover',         2, 'high',   'Sales process, support flow, billing, onboarding, deployment — all must be written down.'),
                self::w('Set SLA standards: response time, resolution time, uptime', 1, 'medium', 'Support: reply in 2 hours, resolve in 24 hours. Uptime: 99.5% monthly. Publish on website.'),
                self::w('Present at BASIS Softexpo or local tech event',             2, 'medium', 'Apply for exhibitor booth or speaker slot. 500+ decision-makers in one place.'),
                self::w('Celebrate ১০ লক্ষ BDT MRR milestone with the team',        1, 'low',    'Team dinner, announce on social media, thank early customers publicly. Momentum matters.'),
            ],
        ];

        $defaultTasks = [
            self::w('Define scope and success criteria',    1, 'high',   'Align team before starting work.'),
            self::w('Execute primary work and track daily', 3, 'high',   'Update task status daily in the board.'),
            self::w('Review and gather feedback',           1, 'medium', 'Document all feedback received.'),
            self::w('Revise and finalise deliverable',      1, 'medium', 'Ensure quality before handoff.'),
            self::w('Close task and document learnings',    1, 'low',    'Add insights to team knowledge base.'),
        ];

        $groups = self::$groupModel::orderBy('id')->get();
        $sort   = 1;

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
                    'daily_rate'     => $task['daily_rate'],
                    'fixed_cost'     => $task['fixed_cost'],
                    'item_cost'      => $task['item_cost'],
                    'note'           => $task['note'],
                    'assigned_to'    => null,
                    'is_recurring'   => 0,
                    'sort_order'     => $sort++,
                ]);
            }
        }
    }
}
