<?php

namespace Modules\Management\WebsiteManagement\Faq\Controller;
use Modules\Management\WebsiteManagement\Faq\Actions\GetAllData;
use Modules\Management\WebsiteManagement\Faq\Actions\DestroyData;
use Modules\Management\WebsiteManagement\Faq\Actions\GetSingleData;
use Modules\Management\WebsiteManagement\Faq\Actions\StoreData;
use Modules\Management\WebsiteManagement\Faq\Actions\UpdateData;
use Modules\Management\WebsiteManagement\Faq\Actions\UpdateStatus;
use Modules\Management\WebsiteManagement\Faq\Actions\SoftDelete;
use Modules\Management\WebsiteManagement\Faq\Actions\RestoreData;
use Modules\Management\WebsiteManagement\Faq\Actions\ImportData;
use Modules\Management\WebsiteManagement\Faq\Validations\BulkActionsValidation;
use Modules\Management\WebsiteManagement\Faq\Validations\DataStoreValidation;
use Modules\Management\WebsiteManagement\Faq\Actions\BulkActions;
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