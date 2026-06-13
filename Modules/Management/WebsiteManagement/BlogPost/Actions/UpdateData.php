<?php

namespace Modules\Management\WebsiteManagement\BlogPost\Actions;

class UpdateData
{
    static $model = \Modules\Management\WebsiteManagement\BlogPost\Database\Models\Model::class;

    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            $requestData = $request->validated();

             // Process file uploads for specific fields
                            if ($request->hasFile('thumbnail')) {
                    $file = $request->file('thumbnail');
                    $requestData['thumbnail'] = uploader($file, 'uploads/WebsiteManagement/BlogPost');
                }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}