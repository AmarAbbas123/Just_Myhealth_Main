<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType12Fees extends Model
{
    protected $table = 'sys_finance_user_type_12_fees';
    protected $fillable = [
        'BusinessNationalID',
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