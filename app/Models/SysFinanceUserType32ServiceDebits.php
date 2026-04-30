<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType32ServiceDebits extends Model
{
    protected $table = 'sys_finance_user_type_32_service_debits';

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