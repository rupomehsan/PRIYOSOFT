<?php

namespace Modules\Management\FinanceManagement\Investor\Actions;

class StoreData
{
    static $model = \Modules\Management\FinanceManagement\Investor\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();
            $requestData['status'] = $requestData['status'] ?? 'active';

            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}