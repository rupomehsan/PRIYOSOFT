<?php

namespace Modules\Management\FinanceManagement\Withdrawal\Controller;
use Modules\Management\FinanceManagement\Withdrawal\Actions\GetAllData;
use Modules\Management\FinanceManagement\Withdrawal\Actions\DestroyData;
use Modules\Management\FinanceManagement\Withdrawal\Actions\GetSingleData;
use Modules\Management\FinanceManagement\Withdrawal\Actions\StoreData;
use Modules\Management\FinanceManagement\Withdrawal\Actions\UpdateData;
use Modules\Management\FinanceManagement\Withdrawal\Actions\UpdateStatus;
use Modules\Management\FinanceManagement\Withdrawal\Actions\SoftDelete;
use Modules\Management\FinanceManagement\Withdrawal\Actions\RestoreData;
use Modules\Management\FinanceManagement\Withdrawal\Actions\ImportData;
use Modules\Management\FinanceManagement\Withdrawal\Validations\BulkActionsValidation;
use Modules\Management\FinanceManagement\Withdrawal\Validations\DataStoreValidation;
use Modules\Management\FinanceManagement\Withdrawal\Actions\BulkActions;
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