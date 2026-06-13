<?php

namespace Modules\Management\TodoManagement\TodoList\Controller;
use Modules\Management\TodoManagement\TodoList\Actions\GetAllData;
use Modules\Management\TodoManagement\TodoList\Actions\DestroyData;
use Modules\Management\TodoManagement\TodoList\Actions\GetSingleData;
use Modules\Management\TodoManagement\TodoList\Actions\StoreData;
use Modules\Management\TodoManagement\TodoList\Actions\UpdateData;
use Modules\Management\TodoManagement\TodoList\Actions\UpdateStatus;
use Modules\Management\TodoManagement\TodoList\Actions\SoftDelete;
use Modules\Management\TodoManagement\TodoList\Actions\RestoreData;
use Modules\Management\TodoManagement\TodoList\Actions\ImportData;
use Modules\Management\TodoManagement\TodoList\Validations\BulkActionsValidation;
use Modules\Management\TodoManagement\TodoList\Validations\DataStoreValidation;
use Modules\Management\TodoManagement\TodoList\Actions\BulkActions;
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