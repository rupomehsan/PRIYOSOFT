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

            if ($request->hasFile('screenshots')) {
                $requestData['screenshots'] = uploader($request->file('screenshots'), 'uploads/ProductManagement/Product');
            }
            if ($request->hasFile('thumbnail')) {
                $requestData['thumbnail'] = uploader($request->file('thumbnail'), 'uploads/ProductManagement/Product/Thumbnails');
            }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}