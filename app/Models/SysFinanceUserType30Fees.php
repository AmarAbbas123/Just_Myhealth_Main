<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType30Fees extends Model
{
    protected $table = 'sys_finance_user_type_30_fees';
    protected $fillable = [
        'TherapistUserID',
        'FeeType',
        'CreditDate',
        'CreditTime',
        'CreditValue',
        'CreditCurrency',
        'TransactionID',
        'TransactionResult'
    ];
    protected $casts = [
        'CreditValue' => 'decimal:2',
    ];
}
