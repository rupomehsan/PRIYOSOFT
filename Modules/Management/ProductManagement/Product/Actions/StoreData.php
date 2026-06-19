<?php

namespace Modules\Management\ProductManagement\Product\Actions;

class StoreData
{
    static $model = \Modules\Management\ProductManagement\Product\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            if ($request->hasFile('screenshots')) {
                $files = $request->file('screenshots');
                if (is_array($files)) {
                    $paths = array_map(fn($f) => uploader($f, 'uploads/ProductManagement/Product'), $files);
                    $requestData['screenshots'] = json_encode(array_values($paths));
                } else {
                    $requestData['screenshots'] = uploader($files, 'uploads/ProductManagement/Product');
                }
            }
            if ($request->hasFile('thumbnail')) {
                $requestData['thumbnail'] = uploader($request->file('thumbnail'), 'uploads/ProductManagement/Product/Thumbnails');
            }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}