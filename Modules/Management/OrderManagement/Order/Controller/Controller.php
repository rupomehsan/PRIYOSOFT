<?php

namespace Modules\Management\OrderManagement\Order\Controller;

use Modules\Management\OrderManagement\Order\Actions\GetAllData;
use Modules\Management\OrderManagement\Order\Actions\DestroyData;
use Modules\Management\OrderManagement\Order\Actions\GetSingleData;
use Modules\Management\OrderManagement\Order\Actions\StoreData;
use Modules\Management\OrderManagement\Order\Actions\UpdateData;
use Modules\Management\OrderManagement\Order\Actions\UpdateStatus;
use Modules\Management\OrderManagement\Order\Actions\SoftDelete;
use Modules\Management\OrderManagement\Order\Actions\RestoreData;
use Modules\Management\OrderManagement\Order\Actions\ImportData;
use Modules\Management\OrderManagement\Order\Actions\BulkActions;
use Modules\Management\OrderManagement\Order\Actions\PublicStoreOrder;
use Modules\Management\OrderManagement\Order\Actions\UpdateOrderStatus;
use Modules\Management\OrderManagement\Order\Actions\GetOrderPayments;
use Modules\Management\OrderManagement\Order\Actions\VerifyPayment;
use Modules\Management\OrderManagement\Order\Actions\RejectPayment;
use Modules\Management\OrderManagement\Order\Actions\GetOrderHistory;
use Modules\Management\OrderManagement\Order\Actions\DeliverOrder;
use Modules\Management\OrderManagement\Order\Actions\AddOrderNote;
use Modules\Management\OrderManagement\Order\Actions\AddAdminPayment;
use Modules\Management\OrderManagement\Order\Validations\BulkActionsValidation;
use Modules\Management\OrderManagement\Order\Validations\DataStoreValidation;
use App\Http\Controllers\Controller as ControllersController;

class Controller extends ControllersController
{
    // -------------------------------------------------------------------------
    // Public (frontend Payment.vue form submission — no auth required)
    // -------------------------------------------------------------------------

    public function publicStore()
    {
        return PublicStoreOrder::execute();
    }

    // -------------------------------------------------------------------------
    // Admin CRUD
    // -------------------------------------------------------------------------

    public function index()
    {
        return GetAllData::execute();
    }

    public function store(DataStoreValidation $request)
    {
        return StoreData::execute($request);
    }

    public function show($slug)
    {
        return GetSingleData::execute($slug);
    }

    public function update(DataStoreValidation $request, $slug)
    {
        return UpdateData::execute($request, $slug);
    }

    // -------------------------------------------------------------------------
    // Order lifecycle status transitions
    // -------------------------------------------------------------------------

    public function updateOrderStatus($slug)
    {
        return UpdateOrderStatus::execute($slug);
    }

    // -------------------------------------------------------------------------
    // Payment management
    // -------------------------------------------------------------------------

    public function getPayments($slug)
    {
        return GetOrderPayments::execute($slug);
    }

    public function verifyPayment($slug)
    {
        return VerifyPayment::execute($slug);
    }

    public function rejectPayment($slug)
    {
        return RejectPayment::execute($slug);
    }

    // -------------------------------------------------------------------------
    // Status history
    // -------------------------------------------------------------------------

    public function getHistory($slug)
    {
        return GetOrderHistory::execute($slug);
    }

    // -------------------------------------------------------------------------
    // Delivery & notes
    // -------------------------------------------------------------------------

    public function deliver($slug)
    {
        return DeliverOrder::execute($slug);
    }

    public function addNote($slug)
    {
        return AddOrderNote::execute($slug);
    }

    public function addAdminPayment($slug)
    {
        return AddAdminPayment::execute($slug);
    }

    // -------------------------------------------------------------------------
    // Standard admin utilities
    // -------------------------------------------------------------------------

    public function updateStatus()
    {
        return UpdateStatus::execute();
    }

    public function softDelete()
    {
        return SoftDelete::execute();
    }

    public function destroy($slug)
    {
        return DestroyData::execute($slug);
    }

    public function restore()
    {
        return RestoreData::execute();
    }

    public function import()
    {
        return ImportData::execute();
    }

    public function bulkAction(BulkActionsValidation $request)
    {
        return BulkActions::execute($request);
    }
}