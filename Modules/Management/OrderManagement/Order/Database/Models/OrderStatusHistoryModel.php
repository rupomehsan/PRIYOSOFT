<?php

namespace Modules\Management\OrderManagement\Order\Database\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class OrderStatusHistoryModel extends EloquentModel
{
    protected $table = "order_status_histories";
    protected $guarded = [];
}