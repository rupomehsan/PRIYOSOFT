<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class GetAllData
{
    static $model = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;

    public static function execute()
    {
        try {

            $pageLimit     = request()->input('limit') ?? 10;
            $orderByColumn = request()->input('sort_by_col') ?? 'id';
            $orderByType   = request()->input('sort_type') ?? 'desc';
            $status        = request()->input('status') ?? 'all';
            $fields        = request()->input('fields') ?? '*';
            $start_date    = request()->input('start_date');
            $end_date      = request()->input('end_date');

            // Order lifecycle statuses — filter on the order_status column
            $validOrderStatuses = [
                'pending_payment', 'payment_submitted', 'payment_verified',
                'in_progress', 'access_sent', 'completed', 'cancelled', 'refunded',
            ];

            $with = ['productId', 'customerId', 'createdBy'];

            $data = self::$model::query();

            // Search
            if (request()->filled('search')) {
                $searchKey = request()->input('search');
                $data->where(function ($q) use ($searchKey) {
                    $q->where('order_number',    'like', '%' . $searchKey . '%')
                      ->orWhere('ref_code',          'like', '%' . $searchKey . '%')
                      ->orWhere('customer_name',     'like', '%' . $searchKey . '%')
                      ->orWhere('customer_phone',    'like', '%' . $searchKey . '%')
                      ->orWhere('customer_email',    'like', '%' . $searchKey . '%')
                      ->orWhere('domain_name',       'like', '%' . $searchKey . '%')
                      ->orWhere('product_name',      'like', '%' . $searchKey . '%')
                      ->orWhere('plan_name',         'like', '%' . $searchKey . '%')
                      ->orWhere('order_status',      'like', '%' . $searchKey . '%')
                      ->orWhere('payment_method',    'like', '%' . $searchKey . '%')
                      ->orWhere('total_amount',      'like', '%' . $searchKey . '%')
                      ->orWhere('coupon_code',       'like', '%' . $searchKey . '%')
                      ->orWhere('special_requirements', 'like', '%' . $searchKey . '%');
                });
            }

            // Date range
            if ($start_date && $end_date) {
                if ($end_date > $start_date) {
                    $data->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
                } elseif ($end_date == $start_date) {
                    $data->whereDate('created_at', $start_date);
                }
            }

            // Status filtering
            if ($status === 'trashed') {
                $data->onlyTrashed();
            } elseif ($status === 'inactive') {
                $data->where('status', 'inactive');
            } elseif (in_array($status, $validOrderStatuses)) {
                // Filter by order lifecycle status (only active rows)
                $data->where('status', 'active')->where('order_status', $status);
            } elseif ($status === 'active' || $status === 'all') {
                $data->where('status', 'active');
            }

            if (request()->has('get_all') && (int)request()->input('get_all') === 1) {
                $data = $data
                    ->with($with)
                    ->select($fields)
                    ->limit($pageLimit)
                    ->orderBy($orderByColumn, $orderByType)
                    ->get();
                return entityResponse($data);
            } else {
                $data = $data
                    ->with($with)
                    ->select($fields)
                    ->orderBy($orderByColumn, $orderByType)
                    ->paginate($pageLimit);
            }

            return entityResponse([
                ...$data->toArray(),
                "active_data_count" => self::$model::active()->count(),
                "inactive_data_count" => self::$model::inactive()->count(),
                "trashed_data_count" => self::$model::onlyTrashed()->count(),
            ]);

        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}