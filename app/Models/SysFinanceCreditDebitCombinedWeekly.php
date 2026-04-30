<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceCreditDebitCombinedWeekly extends Model
{
    protected $table = 'sys_finance_credit_debit_combined_weekly';

    protected $fillable = [
        'TransactionDescription',
        'TransactionType',
        'TransactionWeek',
        'TransactionValue',
        'TransactionCurrency',
    ];

    protected $casts = [
        'TransactionWeek' => 'date',
        'TransactionValue' => 'decimal:2',
    ];
}