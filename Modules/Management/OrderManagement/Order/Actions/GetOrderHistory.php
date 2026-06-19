<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class GetOrderHistory
{
    static $orderModel   = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $historyModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderStatusHistoryModel::class;

    public static function execute($slug)
    {
        try {
            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $history = self::$historyModel::query()
                ->where('order_id', $order->id)
                ->orderByDesc('created_at')
                ->get();

            return messageResponse('Order status history', $history, 200);

        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
