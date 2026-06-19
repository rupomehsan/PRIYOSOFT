<?php

namespace Modules\Management\SettingManagement\WebsiteSettings\Actions;

use Illuminate\Support\Facades\DB;

class StoreData
{
    static $model = \Modules\Management\SettingManagement\WebsiteSettings\Database\Models\Model::class;
    static $SettingValueModel = \Modules\Management\SettingManagement\WebsiteSettings\Database\Models\SettingValueModel::class;

    public static function execute()
    {
        try {
            $requestData = request()->all(); // Get all request data
            $responseData = [];

            foreach ($requestData as $title => $value) {
                if (is_null($value) && !request()->hasFile($title)) {
                    continue; // Skip if no value or file exists
                }

                DB::transaction(function () use ($title, $value, &$responseData) {
                    $finalValue = $value; // Default to the provided value

                    // Handle file upload for any file field
                    if (request()->hasFile($title)) {
                        $file = request()->file($title);
                        $finalValue = uploader($file, 'uploads/settings');
                    }

                    // Update or create the setting title
                    $settingTitle = self::$model::updateOrCreate(
                        ['title' => $title],
                        ['title' => $title]
                    );

                    // Update or create the setting value
                    $settingValue = self::$SettingValueModel::updateOrCreate(
                        ['setting_title_id' => $settingTitle->id],
                        ['value' => $finalValue]
                    );

                    // Collect response data for success response
                    $responseData[] = [
                        'title' => $settingTitle->title,
                        'value' => $settingValue->value,
                    ];
                });
            }

            return messageResponse('Settings updated successfully', $responseData, 200);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
