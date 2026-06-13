<?php

namespace Modules\Management\FinanceManagement\Database\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class ProfitDistributionItemModel extends EloquentModel
{
    protected $table = "profit_distribution_items";
    protected $guarded = [];
}