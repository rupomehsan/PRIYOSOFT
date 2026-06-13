<?php

namespace Modules\Management\FinanceManagement\Database\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class TransactionLogModel extends EloquentModel
{
    protected $table = "transaction_logs";
    protected $guarded = [];
}