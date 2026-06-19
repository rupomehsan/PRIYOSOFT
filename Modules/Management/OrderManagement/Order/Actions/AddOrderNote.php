<?php

namespace Modules\Management\OrderManagement\Order\Actions;

class AddOrderNote
{
    static $orderModel = \Modules\Management\OrderManagement\Order\Database\Models\Model::class;

    public static function execute($slug)
    {
        try {
            request()->validate([
                'admin_note' => 'required|string',
            ]);

            $order = self::$orderModel::query()->where('slug', $slug)->first();
            if (!$order) {
                return messageResponse('Order not found', [], 404, 'error');
            }

            $order->update(['admin_note' => request('admin_note')]);

            return messageResponse('Note saved', $order, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return messageResponse($e->getMessage(), $e->errors(), 422, 'validation_error');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
