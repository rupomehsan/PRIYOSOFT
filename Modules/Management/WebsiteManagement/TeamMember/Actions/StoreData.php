<?php

namespace Modules\Management\WebsiteManagement\TeamMember\Actions;

class StoreData
{
    static $model = \Modules\Management\WebsiteManagement\TeamMember\Database\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();

            // Process file uploads for specific fields
                            if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $requestData['photo'] = uploader($file, 'uploads/WebsiteManagement/TeamMember');
                }
          
            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}