<?php

namespace Modules\Management\OrderManagement\Order\Actions;

use Illuminate\Support\Str;

class AddAdminPayment
{
    static $orderModel   = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $paymentModel = \Modules\Management\OrderManagement\Order\Database\Models\OrderPaymentModel::class;

    public static function execute($slug)
    {
        try {
            request()->validate([
                'transaction_id' => 'nullable|string|max:200',
                'screenshot'     => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'amount'         => 'nullable|numeric|min:0',
                'payment_method' => 'nullable|string',
                'sender_number'  => 'nullable|string|max:30',
                'note'           => 'nullable|string',
                'status'         => 'nullable|string|in:pending,submitted,verified,rejected',
            ]);

            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $screenshotPath = null;
            if (request()->hasFile('screenshot')) {
                $screenshotPath = uploader(request()->file('screenshot'), 'uploads/orders/payments');
            }

            $payment = self::$paymentModel::query()->create([
                'order_id'       => $order->id,
                'transaction_id' => request('transaction_id'),
                'screenshot'     => $screenshotPath,
                'amount'         => request('amount'),
                'payment_method' => request('payment_method') ?: $order->payment_method,
                'sender_number'  => request('sender_number'),
                'note'           => request('note'),
                'status'         => request('status', 'submitted'),
                'submitted_at'   => now(),
                'slug'           => Str::random(10),
            ]);

            return messageResponse('Payment record added', $payment, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return messageResponse($e->getMessage(), $e->errors(), 422, 'validation_error');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
