<?php

namespace Modules\Management\OrderManagement\Order\Actions;

use Illuminate\Support\Str;

class PublicStoreOrder
{
    static $orderModel    = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;
    static $paymentModel  = \Modules\Management\OrderManagement\Order\Database\Models\OrderPaymentModel::class;

    public static function execute()
    {
        try {
            request()->validate([
                'name'           => 'required|string|max:150',
                'phone'          => 'required|string|max:20',
                'email'          => 'nullable|email|max:150',
                'domain'         => 'nullable|string|max:255',
                'description'    => 'nullable|string',
                'delivery_date'  => 'nullable|date',
                'message'        => 'nullable|string',
                'pay_now'        => 'boolean',
                'payment_method' => 'nullable|string|in:bkash,nagad,rocket,bank,card,cod',
                'txn_id'         => 'nullable|string|max:200',
                'screenshot'     => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'product_id'     => 'nullable|integer',
                'product_name'   => 'nullable|string|max:255',
                'plan_name'      => 'nullable|string|max:200',
                'total_amount'   => 'nullable|numeric|min:0',
            ]);

            $order = self::$orderModel::query()->create([
                'order_number'            => 'ORD-' . date('YmdHis') . '-' . Str::random(4),
                'slug'                    => Str::random(10),
                'ref_code'                => 'PFC-' . strtoupper(Str::random(8)),
                'product_id'              => request('product_id'),
                'product_name'            => request('product_name'),
                'plan_name'               => request('plan_name'),
                'customer_name'           => request('name'),
                'customer_phone'          => request('phone'),
                'customer_email'          => request('email'),
                'domain_name'             => request('domain'),
                'project_description'     => request('description'),
                'preferred_delivery_date' => request('delivery_date'),
                'special_requirements'    => request('message'),
                'total_amount'            => request('total_amount', 0),
                'pay_now'                 => request('pay_now', false),
                'payment_method'          => request('payment_method'),
                'order_status'            => request('pay_now') ? 'payment_submitted' : 'pending_payment',
                'ordered_at'              => now(),
                'status'                  => 'active',
            ]);

            if (request('pay_now') && (request('txn_id') || request()->hasFile('screenshot'))) {
                $screenshotPath = null;
                if (request()->hasFile('screenshot')) {
                    $screenshotPath = uploader(request()->file('screenshot'), 'uploads/orders/payments');
                }

                self::$paymentModel::query()->create([
                    'order_id'       => $order->id,
                    'payment_method' => request('payment_method'),
                    'transaction_id' => request('txn_id'),
                    'screenshot'     => $screenshotPath,
                    'amount'         => $order->total_amount,
                    'status'         => 'submitted',
                    'submitted_at'   => now(),
                    'slug'           => Str::random(10),
                ]);
            }

            return messageResponse('Order placed successfully', [
                'order_number' => $order->order_number,
                'ref_code'     => $order->ref_code,
                'slug'         => $order->slug,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return messageResponse($e->getMessage(), $e->errors(), 422, 'validation_error');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
