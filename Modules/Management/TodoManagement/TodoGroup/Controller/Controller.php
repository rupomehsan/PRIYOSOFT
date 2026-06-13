<?php

namespace Modules\Management\TodoManagement\TodoGroup\Controller;
use Modules\Management\TodoManagement\TodoGroup\Actions\GetAllData;
use Modules\Management\TodoManagement\TodoGroup\Actions\DestroyData;
use Modules\Management\TodoManagement\TodoGroup\Actions\GetSingleData;
use Modules\Management\TodoManagement\TodoGroup\Actions\StoreData;
use Modules\Management\TodoManagement\TodoGroup\Actions\UpdateData;
use Modules\Management\TodoManagement\TodoGroup\Actions\UpdateStatus;
use Modules\Management\TodoManagement\TodoGroup\Actions\SoftDelete;
use Modules\Management\TodoManagement\TodoGroup\Actions\RestoreData;
use Modules\Management\TodoManagement\TodoGroup\Actions\ImportData;
use Modules\Management\TodoManagement\TodoGroup\Validations\BulkActionsValidation;
use Modules\Management\TodoManagement\TodoGroup\Validations\DataStoreValidation;
use Modules\Management\TodoManagement\TodoGroup\Actions\BulkActions;
use App\Http\Controllers\Controller as ControllersController;


class Controller extends ControllersController
{

    public function index( ){

        $data = GetAllData::execute();
        return $data;
    }

    public function store(DataStoreValidation $request)
    {
        $data = StoreData::execute($request);
        return $data;
    }

    public function show($slug)
    {
        $data = GetSingleData::execute($slug);
        return $data;
    }

    public function update(DataStoreValidation $request, $slug)
    {
        $data = UpdateData::execute($request, $slug);
        return $data;
    }
         public function updateStatus()
    {
        $data = UpdateStatus::execute();
        return $data;
    }

    public function softDelete()
    {
        $data = SoftDelete::execute();
        return $data;
    }
    public function destroy($slug)
    {
        $data = DestroyData::execute($slug);
        return $data;
    }
    public function restore()
    {
        $data = RestoreData::execute();
        return $data;
    }
    public function import()
    {
        $data = ImportData::execute();
        return $data;
    }
    public function bulkAction(BulkActionsValidation $request)
    {
        $data = BulkActions::execute($request);
        return $data;
    }

}