<?php

namespace Modules\Management\OrderManagement\Order\Database\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class OrderPaymentModel extends EloquentModel
{
    protected $table = "order_payments";
    protected $guarded = [];
}