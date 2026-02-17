<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType13Fees extends Model
{
    protected $table = 'sys_finance_user_type_13_fees';
    protected $fillable = [
        'BusinessGlobalID',
        'FeeType',
        'CreditDate',
        'CreditTime',
        'CreditValue',
        'CreditCurrency',
        'TransactionID',
        'TransactionResult',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'CreditValue' => 'decimal:2',
        'CreditDate' => 'date',
    ];
}