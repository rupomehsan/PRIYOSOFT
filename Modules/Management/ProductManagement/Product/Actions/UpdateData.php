<?php

namespace Modules\Management\ProductManagement\Product\Actions;

class UpdateData
{
    static $model = \Modules\Management\ProductManagement\Product\Database\Models\Model::class;

    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            $requestData = $request->validated();

            // Screenshots: merge kept existing paths + newly uploaded files
            if ($request->input('screenshots_present')) {
                $kept = array_values(array_filter((array) $request->input('screenshots_kept', [])));
                $newPaths = [];
                if ($request->hasFile('screenshots')) {
                    $files = $request->file('screenshots');
                    $files = is_array($files) ? $files : [$files];
                    $newPaths = array_map(fn($f) => uploader($f, 'uploads/ProductManagement/Product'), $files);
                }
                $all = array_values(array_merge($kept, $newPaths));
                if (empty($all)) {
                    $requestData['screenshots'] = null;
                } else {
                    $requestData['screenshots'] = count($all) === 1 ? $all[0] : json_encode($all);
                }
            } elseif ($request->hasFile('screenshots')) {
                // Fallback: no sentinel but files were still sent (single-mode or direct API)
                $files = $request->file('screenshots');
                $files = is_array($files) ? $files : [$files];
                $paths = array_map(fn($f) => uploader($f, 'uploads/ProductManagement/Product'), $files);
                $requestData['screenshots'] = count($paths) === 1 ? $paths[0] : json_encode($paths);
            }
            if ($request->hasFile('thumbnail')) {
                $requestData['thumbnail'] = uploader($request->file('thumbnail'), 'uploads/ProductManagement/Product/Thumbnails');
            }
  
            $data->update($requestData);
            return messageResponse('Item updated successfully',$data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}