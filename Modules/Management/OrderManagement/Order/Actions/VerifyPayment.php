<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class VerifyPayment
{
    static $orderModel   = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $paymentModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderPaymentModel::class;
    static $historyModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderStatusHistoryModel::class;

    public static function execute($slug)
    {
        try {
            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $payment = self::$paymentModel::query()
                ->where('order_id', $order->id)
                ->whereIn('status', ['pending', 'submitted'])
                ->latest()
                ->first();

            if (!$payment) {
                return messageResponse('No pending payment found for this order', [], 404, 'error');
            }

            $payment->update([
                'status'      => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            $fromStatus = $order->order_status;
            $order->update([
                'order_status'          => 'payment_verified',
                'payment_verified_at'   => now(),
            ]);

            self::$historyModel::query()->create([
                'order_id'   => $order->id,
                'from_status'=> $fromStatus,
                'to_status'  => 'payment_verified',
                'note'       => 'Payment verified',
                'changed_by' => auth()->id(),
                'slug'       => \Illuminate\Support\Str::random(10),
            ]);

            return messageResponse('Payment verified successfully', $payment, 200);

        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
