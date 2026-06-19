<?php

namespace Modules\Management\WebsiteManagement\ContactLead\Controller;
use Modules\Management\WebsiteManagement\ContactLead\Actions\GetAllData;
use Modules\Management\WebsiteManagement\ContactLead\Actions\DestroyData;
use Modules\Management\WebsiteManagement\ContactLead\Actions\GetSingleData;
use Modules\Management\WebsiteManagement\ContactLead\Actions\StoreData;
use Modules\Management\WebsiteManagement\ContactLead\Actions\UpdateData;
use Modules\Management\WebsiteManagement\ContactLead\Actions\UpdateStatus;
use Modules\Management\WebsiteManagement\ContactLead\Actions\SoftDelete;
use Modules\Management\WebsiteManagement\ContactLead\Actions\RestoreData;
use Modules\Management\WebsiteManagement\ContactLead\Actions\ImportData;
use Modules\Management\WebsiteManagement\ContactLead\Validations\BulkActionsValidation;
use Modules\Management\WebsiteManagement\ContactLead\Validations\DataStoreValidation;
use Modules\Management\WebsiteManagement\ContactLead\Actions\BulkActions;
use App\Http\Controllers\Controller as ControllersController;
use Illuminate\Http\Request;


class Controller extends ControllersController
{

    public function index( ){

        $data = GetAllData::execute();
        return $data;
    }

    public function publicStore(Request $request)
    {
        try {
            $model = \Modules\Management\WebsiteManagement\ContactLead\Database\Models\Model::class;
            $data = $model::create([
                'name'       => $request->input('name'),
                'email'      => $request->input('email'),
                'phone'      => $request->input('phone'),
                'subject'    => $request->input('subject'),
                'product_id' => $request->input('product_id'),
                'message'    => $request->input('message'),
                'status'     => 'new',
                'ip_address' => $request->ip(),
            ]);
            return messageResponse('Message sent successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
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