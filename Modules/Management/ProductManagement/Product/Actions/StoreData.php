<?php

namespace Modules\Management\ProductManagement\Product\Actions;

class StoreData
{
    static $model = \Modules\Management\ProductManagement\Product\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            // Process file uploads for specific fields
                            if ($request->hasFile('screenshots')) {
                    $file = $request->file('screenshots');
                    $requestData['screenshots'] = uploader($file, 'uploads/ProductManagement/Product');
                }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}