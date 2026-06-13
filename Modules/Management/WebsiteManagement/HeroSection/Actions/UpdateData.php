<?php

namespace Modules\Management\WebsiteManagement\HeroSection\Actions;

class UpdateData
{
    static $model = \Modules\Management\WebsiteManagement\HeroSection\Database\Models\Model::class;

    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            $requestData = $request->validated();

             // Process file uploads for specific fields
                            if ($request->hasFile('background_image')) {
                    $file = $request->file('background_image');
                    $requestData['background_image'] = uploader($file, 'uploads/WebsiteManagement/HeroSection');
                }
                if ($request->hasFile('hero_image')) {
                    $file = $request->file('hero_image');
                    $requestData['hero_image'] = uploader($file, 'uploads/WebsiteManagement/HeroSection');
                }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}