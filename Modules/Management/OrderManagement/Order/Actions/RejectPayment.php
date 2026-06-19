<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class RejectPayment
{
    static $orderModel   = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $paymentModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderPaymentModel::class;
    static $historyModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderStatusHistoryModel::class;

    public static function execute($slug)
    {
        try {
            request()->validate([
                'reason' => 'required|string|max:500',
            ]);

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
                'status'           => 'rejected',
                'rejection_reason' => request('reason'),
            ]);

            $fromStatus = $order->order_status;
            $order->update(['order_status' => 'pending_payment']);

            self::$historyModel::query()->create([
                'order_id'   => $order->id,
                'from_status'=> $fromStatus,
                'to_status'  => 'pending_payment',
                'note'       => 'Payment rejected: ' . request('reason'),
                'changed_by' => auth()->id(),
                'slug'       => \Illuminate\Support\Str::random(10),
            ]);

            return messageResponse('Payment rejected', $payment, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return messageResponse($e->getMessage(), $e->errors(), 422, 'validation_error');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
