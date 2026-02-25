<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType30ServiceDebits extends Model
{
    protected $table = 'sys_finance_user_type_30_service_debits';

    protected $fillable = [
        'AllocatedTherapistUserID',
        'DebitDate',
        'DebitTime',
        'DebitValue',
        'DebitCurrency',
        'TransactionID',
        'TransactionResult',
    ];

    protected $casts = [
        'DebitValue' => 'decimal:2',
    ];
}