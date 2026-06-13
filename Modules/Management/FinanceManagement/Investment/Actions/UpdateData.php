<?php

namespace Modules\Management\FinanceManagement\Investment\Actions;

class UpdateData
{
    static $model = \Modules\Management\FinanceManagement\Investment\Database\Models\Model::class;

    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            $requestData = $request->validated();

             // Process file uploads for specific fields
                            if ($request->hasFile('agreement_doc')) {
                    $file = $request->file('agreement_doc');
                    $requestData['agreement_doc'] = uploader($file, 'uploads/FinanceManagement/Investment');
                }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}