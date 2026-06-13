<?php

namespace Modules\Management\ProductManagement\Product\Actions;

class UpdateData
{
    static $model = \Modules\Management\ProductManagement\Product\Database\Models\Model::class;

    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            $requestData = $request->validated();

             // Process file uploads for specific fields
                            if ($request->hasFile('screenshots')) {
                    $file = $request->file('screenshots');
                    $requestData['screenshots'] = uploader($file, 'uploads/ProductManagement/Product');
                }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}