<?php

namespace Modules\Management\FinanceManagement\Investor\Controller;
use Modules\Management\FinanceManagement\Investor\Actions\GetAllData;
use Modules\Management\FinanceManagement\Investor\Actions\DestroyData;
use Modules\Management\FinanceManagement\Investor\Actions\GetSingleData;
use Modules\Management\FinanceManagement\Investor\Actions\StoreData;
use Modules\Management\FinanceManagement\Investor\Actions\UpdateData;
use Modules\Management\FinanceManagement\Investor\Actions\UpdateStatus;
use Modules\Management\FinanceManagement\Investor\Actions\SoftDelete;
use Modules\Management\FinanceManagement\Investor\Actions\RestoreData;
use Modules\Management\FinanceManagement\Investor\Actions\ImportData;
use Modules\Management\FinanceManagement\Investor\Validations\BulkActionsValidation;
use Modules\Management\FinanceManagement\Investor\Validations\DataStoreValidation;
use Modules\Management\FinanceManagement\Investor\Actions\BulkActions;
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