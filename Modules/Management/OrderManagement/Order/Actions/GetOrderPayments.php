<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class GetOrderPayments
{
    static $orderModel   = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $paymentModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderPaymentModel::class;

    public static function execute($slug)
    {
        try {
            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $payments = self::$paymentModel::query()
                ->where('order_id', $order->id)
                ->orderByDesc('created_at')
                ->get();

            return messageResponse('Order payments', $payments, 200);

        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
