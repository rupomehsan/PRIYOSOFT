<?php

namespace Modules\Management\OrderManagement\Order\Actions;

use Illuminate\Support\Str;

class DeliverOrder
{
    static $orderModel    = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $deliveryModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderDeliveryModel::class;
    static $historyModel  = \Modules\Management\OrderManagement\Order\Database\Models\OrderStatusHistoryModel::class;

    public static function execute($slug)
    {
        try {
            request()->validate([
                'method'  => 'required|string|in:email,whatsapp,manual_contact',
                'message' => 'nullable|string',
                'subject' => 'nullable|string|max:300',
            ]);

            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $attachmentPath = null;
            if (request()->hasFile('attachment')) {
                $attachmentPath = uploader(request()->file('attachment'), 'uploads/orders/deliveries');
            }

            $delivery = self::$deliveryModel::query()->create([
                'order_id'        => $order->id,
                'method'          => request('method'),
                'contact_via'     => request('contact_via'),
                'recipient_email' => request('recipient_email', $order->customer_email),
                'subject'         => request('subject'),
                'message'         => request('message'),
                'attachment'      => $attachmentPath,
                'sent_by'         => auth()->id(),
                'delivered_at'    => now(),
                'slug'            => Str::random(10),
            ]);

            $fromStatus = $order->order_status;
            $order->update([
                'order_status'    => 'access_sent',
                'delivery_method' => request('method'),
                'access_sent_at'  => now(),
            ]);

            self::$historyModel::query()->create([
                'order_id'   => $order->id,
                'from_status'=> $fromStatus,
                'to_status'  => 'access_sent',
                'note'       => 'Delivery sent via ' . request('method'),
                'changed_by' => auth()->id(),
                'slug'       => Str::random(10),
            ]);

            return messageResponse('Order delivered successfully', $delivery, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return messageResponse($e->getMessage(), $e->errors(), 422, 'validation_error');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
