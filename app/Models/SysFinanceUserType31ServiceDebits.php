<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType31ServiceDebits extends Model
{
    protected $table = 'sys_finance_user_type_31_service_debits';

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