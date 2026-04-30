<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceCreditDebitCombinedMonthly extends Model
{
    protected $table = 'sys_finance_credit_debit_combined_monthly';

    protected $fillable = [
        'TransactionDescription',
        'TransactionType',
        'TransactionMonth',
        'TransactionValue',
        'TransactionCurrency',
    ];

    protected $casts = [
        'TransactionMonth' => 'date',
        'TransactionValue' => 'decimal:2',
    ];
}