<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class UpdateOrderStatus
{
    static $orderModel   = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $historyModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderStatusHistoryModel::class;

    public static function execute($slug)
    {
        try {
            request()->validate([
                'order_status' => 'required|string|in:pending_payment,payment_submitted,payment_verified,in_progress,access_sent,completed,cancelled,refunded',
                'note'         => 'nullable|string',
            ]);

            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $fromStatus = $order->order_status;
            $toStatus   = request('order_status');

            $order->order_status = $toStatus;

            // Set lifecycle timestamps on transition
            $tsMap = [
                'payment_verified' => 'payment_verified_at',
                'in_progress'      => 'work_started_at',
                'access_sent'      => 'access_sent_at',
                'completed'        => 'completed_at',
                'cancelled'        => 'cancelled_at',
            ];
            if (isset($tsMap[$toStatus]) && is_null($order->{$tsMap[$toStatus]})) {
                $order->{$tsMap[$toStatus]} = now();
            }

            $order->save();

            self::$historyModel::query()->create([
                'order_id'   => $order->id,
                'from_status'=> $fromStatus,
                'to_status'  => $toStatus,
                'note'       => request('note'),
                'changed_by' => auth()->id(),
                'slug'       => \Illuminate\Support\Str::random(10),
            ]);

            return messageResponse('Order status updated', $order, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return messageResponse($e->getMessage(), $e->errors(), 422, 'validation_error');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
