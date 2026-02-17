<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinancePlatformOperationCost extends Model
{
    protected $table = 'sys_finance_platform_operation_costs';

    protected $fillable = [
        'SupplierName',
        'ServiceDescription',
        'ServiceCategory',
        'DebitDate',
        'DebitTime',
        'DebitValue',
        'DebitCurrency',
        'TransactionID',
        'TransactionResult',
    ];

    protected $casts = [
        'DebitDate' => 'date',
        'DebitValue' => 'decimal:2',
    ];
}