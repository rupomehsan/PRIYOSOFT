<?php

namespace Modules\Management\OrderManagement\Order\Database\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class OrderDeliveryModel extends EloquentModel
{
    protected $table = "order_deliveries";
    protected $guarded = [];
}