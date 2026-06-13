<?php

namespace Modules\Management\FinanceManagement\Income\Actions;

class StoreData
{
    static $model = \Modules\Management\FinanceManagement\Income\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            // Process file uploads for specific fields
                            if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    $requestData['attachment'] = uploader($file, 'uploads/FinanceManagement/Income');
                }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}