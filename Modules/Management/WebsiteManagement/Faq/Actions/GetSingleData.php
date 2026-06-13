<?php

namespace Modules\Management\WebsiteManagement\Faq\Actions;



class GetSingleData
{
    static $model = \Modules\Management\WebsiteManagement\Faq\Database\Models\Model::class;

    public static function execute($slug)
    {
        try {
                             $with = ['productId'];

            $fields = request()->input('fields') ?? ['*'];
            if (!$data = self::$model::query()->with($with)->select($fields)->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}