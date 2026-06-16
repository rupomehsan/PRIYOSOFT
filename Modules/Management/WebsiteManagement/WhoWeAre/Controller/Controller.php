<?php

namespace Modules\Management\WebsiteManagement\WhoWeAre\Controller;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\GetAllData;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\DestroyData;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\GetSingleData;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\StoreData;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\UpdateData;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\UpdateStatus;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\SoftDelete;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\RestoreData;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\ImportData;
use Modules\Management\WebsiteManagement\WhoWeAre\Validations\BulkActionsValidation;
use Modules\Management\WebsiteManagement\WhoWeAre\Validations\DataStoreValidation;
use Modules\Management\WebsiteManagement\WhoWeAre\Actions\BulkActions;
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