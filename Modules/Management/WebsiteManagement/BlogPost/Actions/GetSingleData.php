<?php

namespace Modules\Management\WebsiteManagement\BlogPost\Actions;



class GetSingleData
{
    static $model = \Modules\Management\WebsiteManagement\BlogPost\Database\Models\Model::class;

    public static function execute($slug)
    {
        try {
                             $with = ['authorId', 'productId'];

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