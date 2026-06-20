<?php
namespace Modules\Management\FinanceManagement\Account\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class="Modules\Management\FinanceManagement\Account\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\FinanceManagement\Account\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $accounts = [
            // ── Cash Accounts ─────────────────────────────────────────────
            [
                'name'            => 'Main Cash Box',
                'type'            => 'cash',
                'account_number'  => 'CASH-001',
                'opening_balance' => 50000.00,
                'current_balance' => 50000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],
            [
                'name'            => 'Petty Cash',
                'type'            => 'cash',
                'account_number'  => 'CASH-002',
                'opening_balance' => 10000.00,
                'current_balance' => 10000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],

            // ── Bank Accounts ─────────────────────────────────────────────
            [
                'name'            => 'Dutch-Bangla Bank — Business Current',
                'type'            => 'bank',
                'account_number'  => '1051060078421',
                'opening_balance' => 200000.00,
                'current_balance' => 200000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],
            [
                'name'            => 'BRAC Bank — Savings Account',
                'type'            => 'bank',
                'account_number'  => '1501202345678',
                'opening_balance' => 150000.00,
                'current_balance' => 150000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],
            [
                'name'            => 'Islami Bank — Company Account',
                'type'            => 'bank',
                'account_number'  => '2070900123456',
                'opening_balance' => 100000.00,
                'current_balance' => 100000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],
            [
                'name'            => 'Eastern Bank — USD Account',
                'type'            => 'bank',
                'account_number'  => 'EBL-USD-987654',
                'opening_balance' => 5000.00,
                'current_balance' => 5000.00,
                'currency'        => 'USD',
                'is_active'       => 1,
                'status'          => 'active',
            ],

            // ── Mobile Banking ────────────────────────────────────────────
            [
                'name'            => 'bKash — Business Account',
                'type'            => 'mobile_banking',
                'account_number'  => '01XXXXXXXXX',
                'opening_balance' => 25000.00,
                'current_balance' => 25000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],
            [
                'name'            => 'Nagad — Business Account',
                'type'            => 'mobile_banking',
                'account_number'  => '01XXXXXXXXX',
                'opening_balance' => 15000.00,
                'current_balance' => 15000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],
            [
                'name'            => 'Rocket (DBBL) — Business Account',
                'type'            => 'mobile_banking',
                'account_number'  => '01XXXXXXXXX',
                'opening_balance' => 10000.00,
                'current_balance' => 10000.00,
                'currency'        => 'BDT',
                'is_active'       => 1,
                'status'          => 'active',
            ],

            // ── Crypto ────────────────────────────────────────────────────
            [
                'name'            => 'Binance — USDT Wallet',
                'type'            => 'crypto',
                'account_number'  => 'TXxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'opening_balance' => 1000.00,
                'current_balance' => 1000.00,
                'currency'        => 'USD',
                'is_active'       => 1,
                'status'          => 'active',
            ],
        ];

        foreach ($accounts as $account) {
            self::$model::create($account);
        }
    }
}
