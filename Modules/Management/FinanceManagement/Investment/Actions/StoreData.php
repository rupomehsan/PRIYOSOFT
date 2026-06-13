<?php

namespace Modules\Management\FinanceManagement\Investment\Actions;

class StoreData
{
    static $model = \Modules\Management\FinanceManagement\Investment\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            // Process file uploads for specific fields
                            if ($request->hasFile('agreement_doc')) {
                    $file = $request->file('agreement_doc');
                    $requestData['agreement_doc'] = uploader($file, 'uploads/FinanceManagement/Investment');
                }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}