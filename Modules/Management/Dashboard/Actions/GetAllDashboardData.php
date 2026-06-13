<?php

namespace Modules\Management\Dashboard\Actions;

use Illuminate\Support\Facades\DB;

class GetAllDashboardData
{
    public static function execute()
    {
        try {
            $userModel    = \Modules\Management\UserManagement\User\Database\Models\Model::class;

            $currentYear  = now()->year;
            $currentMonth = now()->month;

            // ── Monthly income/expense arrays (12 months of current year) ──
            $monthlyIncome  = array_fill(0, 12, 0);
            $monthlyExpense = array_fill(0, 12, 0);

            // Aggregate from income table if it exists
            try {
                $incomeRows = DB::table('incomes')
                    ->selectRaw('MONTH(created_at) as m, SUM(amount) as total')
                    ->whereYear('created_at', $currentYear)
                    ->groupByRaw('MONTH(created_at)')
                    ->get();
                foreach ($incomeRows as $row) {
                    $monthlyIncome[$row->m - 1] = (float) $row->total;
                }
            } catch (\Exception $e) {
                // table doesn't exist yet — leave zeros
            }

            try {
                $expenseRows = DB::table('expenses')
                    ->selectRaw('MONTH(created_at) as m, SUM(amount) as total')
                    ->whereYear('created_at', $currentYear)
                    ->groupByRaw('MONTH(created_at)')
                    ->get();
                foreach ($expenseRows as $row) {
                    $monthlyExpense[$row->m - 1] = (float) $row->total;
                }
            } catch (\Exception $e) {
                // table doesn't exist yet — leave zeros
            }

            $totalIncome  = array_sum($monthlyIncome);
            $totalExpense = array_sum($monthlyExpense);
            $currentMonthIncome  = $monthlyIncome[$currentMonth - 1]  ?? 0;
            $currentMonthExpense = $monthlyExpense[$currentMonth - 1] ?? 0;

            // ── Monthly due ──
            $monthlyDue = 0;
            try {
                $monthlyDue = (float) DB::table('vouchers')
                    ->where('status', 'pending')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->sum('amount');
            } catch (\Exception $e) {}

            // ── Counts ──
            $totalUsers = $userModel::count();

            $totalApplications = 0;
            try {
                $totalApplications = DB::table('applications')->count();
            } catch (\Exception $e) {}

            $pendingVouchers = 0;
            try {
                $pendingVouchers = DB::table('vouchers')
                    ->where('status', 'pending')
                    ->count();
            } catch (\Exception $e) {}

            $data = [
                'total_income'           => $totalIncome,
                'total_expense'          => $totalExpense,
                'monthly_due'            => $monthlyDue,
                'current_month_income'   => $currentMonthIncome,
                'current_month_expense'  => $currentMonthExpense,
                'total_users'            => $totalUsers,
                'total_applications'     => $totalApplications,
                'pending_vouchers'       => $pendingVouchers,
                'monthly_income'         => array_values($monthlyIncome),
                'monthly_expense'        => array_values($monthlyExpense),
            ];

            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
