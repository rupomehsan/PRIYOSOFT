<?php

namespace Modules\Management\WebsiteManagement\Testimonial\Actions;

class UpdateData
{
    static $model = \Modules\Management\WebsiteManagement\Testimonial\Database\Models\Model::class;

    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            $requestData = $request->validated();

             // Process file uploads for specific fields
                            if ($request->hasFile('client_photo')) {
                    $file = $request->file('client_photo');
                    $requestData['client_photo'] = uploader($file, 'uploads/WebsiteManagement/Testimonial');
                }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}