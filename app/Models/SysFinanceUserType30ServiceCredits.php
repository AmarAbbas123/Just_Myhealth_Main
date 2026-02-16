<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType30ServiceCredits extends Model
{
    protected $table = 'sys_finance_user_type_30_service_credits';
    protected $fillable = [
        'PatientUserID',
        'AllocatedTherapistUserID',
        'NumberSessionsPurchased',
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
