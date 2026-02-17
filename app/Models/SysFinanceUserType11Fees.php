<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType11Fees extends Model
{
    protected $table = 'sys_finance_user_type_11_fees';
    protected $fillable = [
        'BusinessRegionalUserID',
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