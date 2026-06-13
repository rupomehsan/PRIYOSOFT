<?php

namespace Modules\Management\WebsiteManagement\Testimonial\Actions;

class StoreData
{
    static $model = \Modules\Management\WebsiteManagement\Testimonial\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            // Process file uploads for specific fields
                            if ($request->hasFile('client_photo')) {
                    $file = $request->file('client_photo');
                    $requestData['client_photo'] = uploader($file, 'uploads/WebsiteManagement/Testimonial');
                }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}