# PriyoSoft Corner — Database Design

---

## Overview

Two concerns are tracked here:

1. **Finance** — income, expense, investment, withdrawal, profit sharing
2. **Website Content** — pages, team, testimonials, blog, contact leads

---

## 1. COMPANY & PRODUCTS

### `product_groups`

> Categorizes the 3 software products. Add before `products`.

| Column      | Type         | Notes                                        |
| ----------- | ------------ | -------------------------------------------- |
| id          | bigint PK    |                                              |
| name        | varchar(200) | e.g. "eCommerce Solutions", "Business Tools" |
| description | text         | nullable                                     |
| icon        | varchar(200) | icon class or image path, nullable           |
| sort_order  | tinyint      |                                              |
| is_active   | tinyint(1)   | default 1                                    |
| created_at  | timestamp    |                                              |
| updated_at  | timestamp    |                                              |

---

### `products`

| Column                 | Type                       | Notes                                         |
| ---------------------- | -------------------------- | --------------------------------------------- |
| id                     | bigint PK                  |                                               |
| product_group_id       | bigint FK → product_groups | nullable                                      |
| name                   | varchar(200)               | eCommerce / Inventory / Business Portfolio    |
| slug                   | varchar(200)               | unique                                        |
| description            | text                       |                                               |
| status                 | enum                       | `planning`, `development`, `active`, `paused` |
| launch_date            | date                       | nullable                                      |
| monthly_target_revenue | decimal(15,2)              |                                               |
| created_at             | timestamp                  |                                               |
| updated_at             | timestamp                  |                                               |

> Seed: `ecommerce`, `inventory`, `business-portfolio`

---

## 2. ACCOUNTS (Wallets / Bank / Cash)

### `accounts`

| Column          | Type          | Notes                                             |
| --------------- | ------------- | ------------------------------------------------- |
| id              | bigint PK     |                                                   |
| name            | varchar(150)  | e.g. "bKash Main", "Dutch-Bangla", "Cash in Hand" |
| type            | enum          | `cash`, `bank`, `mobile_banking`, `crypto`        |
| account_number  | varchar(100)  | nullable                                          |
| opening_balance | decimal(15,2) | default 0                                         |
| current_balance | decimal(15,2) | maintained via triggers/app                       |
| currency        | char(3)       | `BDT`, `USD`                                      |
| is_active       | tinyint(1)    | default 1                                         |
| created_at      | timestamp     |                                                   |
| updated_at      | timestamp     |                                                   |

---

## 3. CATEGORIES

### `income_categories`

| Column      | Type         | Notes                                                      |
| ----------- | ------------ | ---------------------------------------------------------- |
| id          | bigint PK    |                                                            |
| name        | varchar(150) | e.g. "Product Sale", "Subscription", "Consulting", "Grant" |
| description | varchar(300) |                                                            |
| created_at  | timestamp    |                                                            |

### `expense_categories`

| Column      | Type         | Notes                                                                  |
| ----------- | ------------ | ---------------------------------------------------------------------- |
| id          | bigint PK    |                                                                        |
| name        | varchar(150) | e.g. "Server Cost", "Salary", "Marketing", "Domain", "Office", "Tools" |
| description | varchar(300) |                                                                        |
| created_at  | timestamp    |                                                                        |

---

## 4. INCOME

### `incomes`

| Column             | Type                          | Notes                              |
| ------------------ | ----------------------------- | ---------------------------------- |
| id                 | bigint PK                     |                                    |
| title              | varchar(300)                  | short description                  |
| income_category_id | bigint FK → income_categories |                                    |
| product_id         | bigint FK → products          | nullable — general income if null  |
| account_id         | bigint FK → accounts          | money received into which account  |
| amount             | decimal(15,2)                 |                                    |
| currency           | char(3)                       | default `BDT`                      |
| source             | varchar(200)                  | client name / platform / reference |
| received_at        | date                          |                                    |
| invoice_no         | varchar(100)                  | nullable                           |
| note               | text                          | nullable                           |
| attachment         | varchar(500)                  | receipt/screenshot path, nullable  |
| created_by         | bigint FK → users             |                                    |
| created_at         | timestamp                     |                                    |
| updated_at         | timestamp                     |                                    |

---

## 5. EXPENSES

### `expenses`

| Column              | Type                           | Notes                   |
| ------------------- | ------------------------------ | ----------------------- |
| id                  | bigint PK                      |                         |
| title               | varchar(300)                   |                         |
| expense_category_id | bigint FK → expense_categories |                         |
| product_id          | bigint FK → products           | nullable                |
| account_id          | bigint FK → accounts           | paid from which account |
| amount              | decimal(15,2)                  |                         |
| currency            | char(3)                        | default `BDT`           |
| vendor              | varchar(200)                   | who was paid, nullable  |
| paid_at             | date                           |                         |
| invoice_no          | varchar(100)                   | nullable                |
| note                | text                           | nullable                |
| attachment          | varchar(500)                   | receipt path, nullable  |
| created_by          | bigint FK → users              |                         |
| created_at          | timestamp                      |                         |
| updated_at          | timestamp                      |                         |

---

## 6. INVESTORS

### `investors`

| Column            | Type         | Notes                                     |
| ----------------- | ------------ | ----------------------------------------- |
| id                | bigint PK    |                                           |
| name              | varchar(200) |                                           |
| email             | varchar(200) | nullable, unique                          |
| phone             | varchar(50)  |                                           |
| address           | text         | nullable                                  |
| nid_or_passport   | varchar(100) | nullable, for KYC                         |
| type              | enum         | `individual`, `company`                   |
| equity_percentage | decimal(5,2) | total agreed equity %, nullable for loans |
| note              | text         | nullable                                  |
| joined_at         | date         |                                           |
| status            | enum         | `active`, `exited`                        |
| created_at        | timestamp    |                                           |
| updated_at        | timestamp    |                                           |

---

## 7. INVESTMENTS (Money coming IN from investors)

### `investments`

| Column         | Type                  | Notes                     |
| -------------- | --------------------- | ------------------------- |
| id             | bigint PK             |                           |
| investor_id    | bigint FK → investors |                           |
| account_id     | bigint FK → accounts  | deposited into            |
| round          | varchar(100)          | e.g. "Seed", "Round 1"    |
| amount         | decimal(15,2)         |                           |
| currency       | char(3)               |                           |
| type           | enum                  | `equity`, `loan`, `grant` |
| interest_rate  | decimal(5,2)          | for loans, nullable       |
| agreement_date | date                  |                           |
| received_at    | date                  |                           |
| agreement_doc  | varchar(500)          | file path, nullable       |
| note           | text                  | nullable                  |
| created_at     | timestamp             |                           |
| updated_at     | timestamp             |                           |

---

## 8. WITHDRAWALS

Covers both **owner withdrawals** and **investor returns/withdrawals**.

### `withdrawals`

| Column            | Type                  | Notes                                           |
| ----------------- | --------------------- | ----------------------------------------------- |
| id                | bigint PK             |                                                 |
| withdrawn_by_type | enum                  | `owner`, `investor`                             |
| user_id           | bigint FK → users     | nullable — for owner                            |
| investor_id       | bigint FK → investors | nullable — for investor                         |
| account_id        | bigint FK → accounts  | withdrawn from which account                    |
| amount            | decimal(15,2)         |                                                 |
| currency          | char(3)               |                                                 |
| reason            | varchar(300)          | e.g. "Salary", "Profit Share", "Loan Repayment" |
| withdrawn_at      | date                  |                                                 |
| attachment        | varchar(500)          | nullable                                        |
| note              | text                  | nullable                                        |
| created_by        | bigint FK → users     |                                                 |
| created_at        | timestamp             |                                                 |
| updated_at        | timestamp             |                                                 |

---

## 9. PROFIT SHARING

Track how profit is distributed each month/quarter.

### `profit_distributions`

| Column         | Type          | Notes                      |
| -------------- | ------------- | -------------------------- |
| id             | bigint PK     |                            |
| period         | varchar(20)   | e.g. "2025-Q1", "2025-06"  |
| total_income   | decimal(15,2) |                            |
| total_expense  | decimal(15,2) |                            |
| net_profit     | decimal(15,2) | computed: income - expense |
| distributed_at | date          |                            |
| note           | text          | nullable                   |
| created_at     | timestamp     |                            |

### `profit_distribution_items`

| Column                 | Type                             | Notes                           |
| ---------------------- | -------------------------------- | ------------------------------- |
| id                     | bigint PK                        |                                 |
| profit_distribution_id | bigint FK → profit_distributions |                                 |
| recipient_type         | enum                             | `owner`, `investor`             |
| user_id                | bigint FK → users                | nullable                        |
| investor_id            | bigint FK → investors            | nullable                        |
| percentage             | decimal(5,2)                     |                                 |
| amount                 | decimal(15,2)                    |                                 |
| withdrawal_id          | bigint FK → withdrawals          | nullable, link to actual payout |

---

## 10. ACCOUNT TRANSFERS

When money moves between your own accounts (e.g. bKash → Bank).

### `account_transfers`

| Column          | Type                 | Notes                   |
| --------------- | -------------------- | ----------------------- |
| id              | bigint PK            |                         |
| from_account_id | bigint FK → accounts |                         |
| to_account_id   | bigint FK → accounts |                         |
| amount          | decimal(15,2)        |                         |
| fee             | decimal(15,2)        | transfer fee, default 0 |
| transferred_at  | date                 |                         |
| note            | text                 | nullable                |
| created_by      | bigint FK → users    |                         |
| created_at      | timestamp            |                         |

---

---

## WEBSITE CONTENT TABLES

---

## 11. PAGES / SECTIONS

### `site_sections`

Flexible key-value store for hero banners, about text, mission, vision, etc.

| Column     | Type         | Notes                                                           |
| ---------- | ------------ | --------------------------------------------------------------- |
| id         | bigint PK    |                                                                 |
| section    | varchar(100) | `hero`, `about`, `mission`, `vision`, `cta`, `footer`           |
| key        | varchar(150) | `title`, `subtitle`, `description`, `button_text`, `button_url` |
| value      | text         |                                                                 |
| sort_order | int          |                                                                 |
| updated_at | timestamp    |                                                                 |

---

## 12. PRODUCTS SHOWCASE (Website)

Reuse the `products` table above — add these extra columns to it or use a separate display table:

### `product_features`

| Column      | Type                 | Notes                  |
| ----------- | -------------------- | ---------------------- |
| id          | bigint PK            |                        |
| product_id  | bigint FK → products |                        |
| icon        | varchar(200)         | icon class or SVG path |
| title       | varchar(200)         |                        |
| description | text                 |                        |
| sort_order  | int                  |                        |

### `product_screenshots`

| Column     | Type                 | Notes    |
| ---------- | -------------------- | -------- |
| id         | bigint PK            |          |
| product_id | bigint FK → products |          |
| image      | varchar(500)         |          |
| caption    | varchar(300)         | nullable |
| sort_order | int                  |          |

---

## 13. TEAM MEMBERS

### `team_members`

| Column     | Type         | Notes                                  |
| ---------- | ------------ | -------------------------------------- |
| id         | bigint PK    |                                        |
| name       | varchar(200) |                                        |
| role       | varchar(200) | e.g. "CEO & Founder", "Lead Developer" |
| bio        | text         | nullable                               |
| photo      | varchar(500) |                                        |
| linkedin   | varchar(500) | nullable                               |
| github     | varchar(500) | nullable                               |
| sort_order | int          |                                        |
| is_visible | tinyint(1)   | default 1                              |
| created_at | timestamp    |                                        |

---

## 14. TESTIMONIALS

### `testimonials`

| Column         | Type                 | Notes     |
| -------------- | -------------------- | --------- |
| id             | bigint PK            |           |
| client_name    | varchar(200)         |           |
| client_company | varchar(200)         | nullable  |
| client_photo   | varchar(500)         | nullable  |
| product_id     | bigint FK → products | nullable  |
| rating         | tinyint              | 1–5       |
| message        | text                 |           |
| is_featured    | tinyint(1)           | default 0 |
| is_visible     | tinyint(1)           | default 1 |
| created_at     | timestamp            |           |

---

## 15. BLOG / NEWS

### `blog_posts`

| Column       | Type                 | Notes                |
| ------------ | -------------------- | -------------------- |
| id           | bigint PK            |                      |
| title        | varchar(500)         |                      |
| slug         | varchar(500)         | unique               |
| thumbnail    | varchar(500)         | nullable             |
| excerpt      | text                 | nullable             |
| body         | longtext             |                      |
| author_id    | bigint FK → users    |                      |
| product_id   | bigint FK → products | nullable             |
| status       | enum                 | `draft`, `published` |
| published_at | timestamp            | nullable             |
| created_at   | timestamp            |                      |
| updated_at   | timestamp            |                      |

---

## 16. ABOUT US

### `about_us`

> Stores all content for the About Us page — company story, mission, vision, values, and key stats.

| Column      | Type         | Notes                                                   |
| ----------- | ------------ | ------------------------------------------------------- |
| id          | bigint PK    |                                                         |
| section     | enum         | `story`, `mission`, `vision`, `value`, `stat`           |
| title       | varchar(300) | e.g. "Our Story", "Why We Exist", "Client Satisfaction" |
| description | text         | main content/body text                                  |
| icon        | varchar(200) | icon class or image path, nullable                      |
| image       | varchar(500) | section image, nullable                                 |
| stat_value  | varchar(100) | nullable — e.g. "50+", "99%", "3" (for section = stat)  |
| stat_label  | varchar(200) | nullable — e.g. "Happy Clients", "Products Launched"    |
| sort_order  | tinyint      |                                                         |
| is_visible  | tinyint(1)   | default 1                                               |
| created_at  | timestamp    |                                                         |
| updated_at  | timestamp    |                                                         |

> **Seed sections:**
>
> - `story` — company founding story paragraph
> - `mission` — what the company is on a mission to do
> - `vision` — long-term vision statement
> - `value` — core values (multiple rows: Integrity, Innovation, Support…)
> - `stat` — numbers to show off (multiple rows: 50+ clients, 3 products, 99% uptime…)

---

## 17. FAQS

### `faqs`

| Column     | Type                 | Notes                          |
| ---------- | -------------------- | ------------------------------ |
| id         | bigint PK            |                                |
| product_id | bigint FK → products | nullable — general FAQ if null |
| question   | varchar(500)         |                                |
| answer     | text                 |                                |
| sort_order | int                  |                                |
| is_visible | tinyint(1)           | default 1                      |

---

## 17. CONTACT LEADS (from website contact form)

### `contact_leads`

| Column     | Type                 | Notes                                         |
| ---------- | -------------------- | --------------------------------------------- |
| id         | bigint PK            |                                               |
| name       | varchar(200)         |                                               |
| email      | varchar(200)         |                                               |
| phone      | varchar(50)          | nullable                                      |
| subject    | varchar(300)         | nullable                                      |
| product_id | bigint FK → products | nullable — which product they're asking about |
| message    | text                 |                                               |
| status     | enum                 | `new`, `read`, `replied`, `closed`            |
| ip_address | varchar(50)          |                                               |
| created_at | timestamp            |                                               |

---

## 18. NEWSLETTER SUBSCRIBERS

### `subscribers`

| Column          | Type         | Notes     |
| --------------- | ------------ | --------- |
| id              | bigint PK    |           |
| email           | varchar(200) | unique    |
| name            | varchar(200) | nullable  |
| is_active       | tinyint(1)   | default 1 |
| subscribed_at   | timestamp    |           |
| unsubscribed_at | timestamp    | nullable  |

---

## TRANSACTION LOG (General Ledger)

### `transaction_log`

> Single table that records **every money movement** across the company.
> Every income, expense, investor investment, and withdrawal creates one row here.
> Running balance tells you instantly whether the company is in **profit or loss**.

| Column           | Type                  | Notes                                                                                  |
| ---------------- | --------------------- | -------------------------------------------------------------------------------------- |
| id               | bigint PK             |                                                                                        |
| account_id       | bigint FK → accounts  | which account was affected                                                             |
| type             | enum                  | `income`, `expense`, `investment`, `withdrawal`, `transfer_in`, `transfer_out`         |
| direction        | enum                  | `credit` (money in ↑) or `debit` (money out ↓)                                         |
| amount           | decimal(15,2)         |                                                                                        |
| balance_before   | decimal(15,2)         | account balance before this entry                                                      |
| balance_after    | decimal(15,2)         | account balance after this entry                                                       |
| reference_type   | varchar(100)          | source table: `incomes`, `expenses`, `investments`, `withdrawals`, `account_transfers` |
| reference_id     | bigint                | ID of the source record in reference_type table                                        |
| description      | varchar(400)          | auto-generated summary e.g. "Income: Product Sale - bKash"                             |
| product_id       | bigint FK → products  | nullable — which product this relates to                                               |
| investor_id      | bigint FK → investors | nullable — filled when type = investment or withdrawal (investor)                      |
| transaction_date | date                  |                                                                                        |
| created_by       | bigint FK → users     |                                                                                        |
| created_at       | timestamp             |                                                                                        |

---

### HOW EACH EVENT CREATES A LOG ENTRY

| Event                       | direction | type           | Effect on Balance                       |
| --------------------------- | --------- | -------------- | --------------------------------------- |
| Income recorded             | `credit`  | `income`       | balance_after = balance_before + amount |
| Expense recorded            | `debit`   | `expense`      | balance_after = balance_before − amount |
| Investor invests            | `credit`  | `investment`   | balance_after = balance_before + amount |
| Withdrawal (owner/investor) | `debit`   | `withdrawal`   | balance_after = balance_before − amount |
| Transfer out                | `debit`   | `transfer_out` | from account decreases                  |
| Transfer in                 | `credit`  | `transfer_in`  | to account increases                    |

---

### PROFIT / LOSS FORMULA

```sql
-- Overall company profit or loss
SELECT
    SUM(CASE WHEN direction = 'credit' THEN amount ELSE 0 END) AS total_in,
    SUM(CASE WHEN direction = 'debit'  THEN amount ELSE 0 END) AS total_out,
    SUM(CASE WHEN direction = 'credit' THEN amount ELSE -amount END) AS net_balance
FROM transaction_log;

-- Positive net_balance = PROFIT ✓
-- Negative net_balance = LOSS  ✗

-- Monthly profit/loss trend
SELECT
    DATE_FORMAT(transaction_date, '%Y-%m') AS month,
    SUM(CASE WHEN direction = 'credit' THEN amount ELSE -amount END) AS net
FROM transaction_log
GROUP BY month
ORDER BY month;

-- Per-product profit/loss
SELECT
    p.name AS product,
    SUM(CASE WHEN t.direction = 'credit' THEN t.amount ELSE -t.amount END) AS net
FROM transaction_log t
JOIN products p ON p.id = t.product_id
GROUP BY t.product_id;
```

---

## RELATIONSHIPS SUMMARY

```
product_groups    ← products.product_group_id

products          ← incomes, expenses, product_features, product_screenshots,
                     testimonials, faqs, blog_posts, contact_leads, transaction_log

investors         ← investments, withdrawals, profit_distribution_items, transaction_log

accounts          ← incomes, expenses, withdrawals, account_transfers,
                     investments, transaction_log

income_categories ← incomes
expense_categories← expenses

profit_distributions → profit_distribution_items → withdrawals

transaction_log   ← (auto-populated from incomes, expenses, investments, withdrawals)
```

---

## DASHBOARD KPIs (computed from transaction_log)

| Metric                | Formula                                                           |
| --------------------- | ----------------------------------------------------------------- |
| Total Money In        | SUM(amount) WHERE direction = 'credit'                            |
| Total Money Out       | SUM(amount) WHERE direction = 'debit'                             |
| **Net Profit / Loss** | **SUM(credit) − SUM(debit)** — positive = profit, negative = loss |
| Total Income only     | SUM(amount) WHERE type = 'income'                                 |
| Total Expenses only   | SUM(amount) WHERE type = 'expense'                                |
| Total Invested        | SUM(amount) WHERE type = 'investment'                             |
| Total Withdrawn       | SUM(amount) WHERE type = 'withdrawal'                             |
| Cash in Hand          | SUM(accounts.current_balance)                                     |
| Income by Product     | GROUP BY product_id WHERE type = 'income'                         |
| Expense by Category   | JOIN expenses ON reference_id, GROUP BY expense_category_id       |
| Investor ROI          | (profit share paid ÷ invested amount) × 100                       |

---

---

# ORDER SYSTEM — DATABASE TABLES

> Digital product sales only — no physical shipping.
> Customer pays via bKash/Nagad, submits transaction ID, then receives
> product access via email (file/credentials) or team contacts them directly.

---

## 19. `orders`

| Column              | Type                  | Notes                                                                                              |
| ------------------- | --------------------- | -------------------------------------------------------------------------------------------------- |
| id                  | bigint PK             |                                                                                                    |
| order_number        | varchar(50)           | unique, auto-generated e.g. `ORD-20260613-0001`                                                    |
| product_id          | bigint FK → products  | which software product was ordered                                                                 |
| customer_id         | bigint FK → customers |                                                                                                    |
| plan_name           | varchar(200)          | e.g. "Basic", "Pro", "Enterprise"                                                                  |
| billing_cycle       | enum                  | `monthly`, `yearly`, `one_time`                                                                    |
| status              | enum                  | `pending_payment`, `payment_submitted`, `payment_verified`, `access_sent`, `cancelled`, `refunded` |
| delivery_method     | enum                  | `email`, `manual_contact`                                                                          |
| subtotal            | decimal(15,2)         |                                                                                                    |
| discount_amount     | decimal(15,2)         | default 0                                                                                          |
| total_amount        | decimal(15,2)         | subtotal − discount                                                                                |
| coupon_code         | varchar(100)          | nullable                                                                                           |
| customer_note       | text                  | any message from customer, nullable                                                                |
| ordered_at          | timestamp             |                                                                                                    |
| payment_verified_at | timestamp             | nullable — when admin confirmed the payment                                                        |
| access_sent_at      | timestamp             | nullable — when file/credentials were sent                                                         |
| cancelled_at        | timestamp             | nullable                                                                                           |
| created_by          | bigint FK → users     | nullable — admin who created manually                                                              |
| created_at          | timestamp             |                                                                                                    |
| updated_at          | timestamp             |                                                                                                    |

---

## 20. `order_payments`

> Customer sends payment via bKash/Nagad and submits their transaction ID here.
> Admin verifies and marks it confirmed.

| Column           | Type               | Notes                                             |
| ---------------- | ------------------ | ------------------------------------------------- |
| id               | bigint PK          |                                                   |
| order_id         | bigint FK → orders |                                                   |
| payment_method   | enum               | `bkash`, `nagad`, `bank_transfer`, `card`         |
| sender_number    | varchar(20)        | customer's bKash/Nagad number they paid from      |
| transaction_id   | varchar(200)       | TxnID submitted by customer                       |
| amount           | decimal(15,2)      |                                                   |
| status           | enum               | `submitted`, `verified`, `rejected`               |
| submitted_at     | timestamp          | when customer submitted the TxnID                 |
| verified_at      | timestamp          | nullable — when admin confirmed                   |
| verified_by      | bigint FK → users  | nullable — which admin verified                   |
| rejection_reason | varchar(300)       | nullable — filled if rejected                     |
| screenshot       | varchar(500)       | nullable — customer can upload payment screenshot |
| note             | text               | nullable                                          |
| created_at       | timestamp          |                                                   |
| updated_at       | timestamp          |                                                   |

---

## 21. `order_deliveries`

> Tracks how and when digital access was delivered to the customer.
> Either via email (file/credentials) or manual contact (call/WhatsApp).

| Column          | Type               | Notes                                                             |
| --------------- | ------------------ | ----------------------------------------------------------------- |
| id              | bigint PK          |                                                                   |
| order_id        | bigint FK → orders |                                                                   |
| method          | enum               | `email`, `manual_contact`                                         |
| contact_via     | varchar(100)       | nullable — e.g. "WhatsApp", "Phone", "Gmail" (for manual_contact) |
| recipient_email | varchar(200)       | nullable — email address file/credentials were sent to            |
| subject         | varchar(300)       | nullable — email subject line                                     |
| message         | text               | nullable — what was sent or said                                  |
| attachment      | varchar(500)       | nullable — file path of what was sent (license, zip, credentials) |
| sent_by         | bigint FK → users  | which team member delivered                                       |
| delivered_at    | timestamp          |                                                                   |
| created_at      | timestamp          |                                                                   |

---

## 22. `order_status_history`

> Every status change on an order is logged here for full audit trail.

| Column      | Type               | Notes                        |
| ----------- | ------------------ | ---------------------------- |
| id          | bigint PK          |                              |
| order_id    | bigint FK → orders |                              |
| from_status | varchar(100)       | previous status              |
| to_status   | varchar(100)       | new status                   |
| note        | text               | nullable — reason for change |
| changed_by  | bigint FK → users  | nullable                     |
| created_at  | timestamp          |                              |

---

## ORDER FLOW

```
Customer places order
        ↓
  status: pending_payment
        ↓
Customer pays bKash/Nagad → submits TxnID + screenshot
  → order_payments.status = submitted
        ↓
Admin verifies TxnID
  → order_payments.status = verified
  → orders.status = payment_verified
        ↓
Admin sends file/credentials via email  OR  contacts customer manually
  → order_deliveries record created
  → orders.status = access_sent
        ↓
Done ✓
```

## ORDER SYSTEM RELATIONSHIPS

```
orders
  ├── order_payments.order_id       (customer TxnID submission + verification)
  ├── order_deliveries.order_id     (email/manual delivery log)
  └── order_status_history.order_id (full audit trail)
```

---

---

# PROJECT TODO LIST — DATABASE TABLES

---

## 23. `todo_milestones`

> Added before groups — marks key delivery checkpoints across all phases.

| Column        | Type         | Notes                                                |
| ------------- | ------------ | ---------------------------------------------------- |
| id            | bigint PK    |                                                      |
| title         | varchar(300) | e.g. "eCommerce Beta Launched", "Company Registered" |
| phase         | varchar(100) | e.g. "Phase 1 — Foundation"                          |
| target_date   | date         | planned completion date                              |
| achieved_date | date         | nullable — filled when done                          |
| status        | enum         | `upcoming`, `achieved`, `missed`                     |
| note          | text         | nullable                                             |
| sort_order    | tinyint      |                                                      |
| created_at    | timestamp    |                                                      |
| updated_at    | timestamp    |                                                      |

---

## 24. `todo_groups`

| Column     | Type         | Notes                                              |
| ---------- | ------------ | -------------------------------------------------- |
| id         | bigint PK    |                                                    |
| cost       | bigint PK    |                                                    |
| name       | varchar(200) | e.g. "Legal & Registration", "Backend Core"        |
| phase      | varchar(100) | e.g. "Phase 1 — Foundation", "Phase 4 — eCommerce" |
| sort_order | tinyint      | display order                                      |
| status     | enum         | `pending`, `in_progress`, `completed`              |
| created_at | timestamp    |                                                    |
| updated_at | timestamp    |                                                    |

---

## 25. `todo_list`

| Column         | Type                    | Notes                                            |
| -------------- | ----------------------- | ------------------------------------------------ |
| id             | bigint PK               |                                                  |
| todo_group_id  | bigint FK → todo_groups |                                                  |
| title          | varchar(400)            | task description                                 |
| assigned_to    | varchar(100)            | `founder`, `developer`, `designer`               |
| estimated_days | decimal(5,1)            | nullable                                         |
| daily_rate     | decimal(12,2)           | rate per day (BDT)                               |
| fixed_cost     | decimal(12,2)           | nullable — used when task is fixed price         |
| item_cost      | decimal(12,2)           | (estimated_days × daily_rate) OR fixed_cost      |
| is_recurring   | tinyint(1)              | 0 = one-time, 1 = monthly                        |
| priority       | enum                    | `critical`, `high`, `medium`, `low`              |
| status         | enum                    | `pending`, `in_progress`, `completed`, `skipped` |
| completed_at   | date                    | nullable                                         |
| note           | text                    | nullable                                         |
| sort_order     | smallint                | order within group                               |
| created_at     | timestamp               |                                                  |
| updated_at     | timestamp               |                                                  |

---

## TODO RELATIONSHIPS

```
todo_milestones   (standalone — phase checkpoints)

todo_groups
    └── todo_list.todo_group_id
```

---

## USEFUL QUERIES

**Milestone status overview:**

```sql
SELECT phase, title, target_date, achieved_date, status
FROM todo_milestones
ORDER BY sort_order;
```

**Group-wise cost total:**

```sql
SELECT g.phase, g.name,
       COUNT(t.id)                  AS total_tasks,
       SUM(t.item_cost)             AS group_cost,
       SUM(t.status = 'completed')  AS done
FROM todo_groups g
JOIN todo_list t ON t.todo_group_id = g.id
GROUP BY g.id
ORDER BY g.sort_order;
```

**Item-wise cost list:**

```sql
SELECT g.phase, g.name AS group_name,
       t.title, t.assigned_to,
       t.estimated_days, t.daily_rate, t.fixed_cost,
       t.item_cost, t.is_recurring, t.priority, t.status
FROM todo_list t
JOIN todo_groups g ON g.id = t.todo_group_id
ORDER BY g.sort_order, t.sort_order;
```

**Grand total one-time vs monthly:**

```sql
SELECT
    SUM(CASE WHEN is_recurring = 0 THEN item_cost ELSE 0 END) AS one_time_total,
    SUM(CASE WHEN is_recurring = 1 THEN item_cost ELSE 0 END) AS monthly_total
FROM todo_list;
```
