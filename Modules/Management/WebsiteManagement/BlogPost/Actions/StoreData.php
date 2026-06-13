<?php

namespace Modules\Management\WebsiteManagement\BlogPost\Actions;

class StoreData
{
    static $model = \Modules\Management\WebsiteManagement\BlogPost\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            // Process file uploads for specific fields
                            if ($request->hasFile('thumbnail')) {
                    $file = $request->file('thumbnail');
                    $requestData['thumbnail'] = uploader($file, 'uploads/WebsiteManagement/BlogPost');
                }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}