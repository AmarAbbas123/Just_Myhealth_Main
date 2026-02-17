<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType31Fees extends Model
{
    protected $table = 'sys_finance_user_type_31_fees';
    protected $fillable = [
        'PhysicalTrainingUserID',
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