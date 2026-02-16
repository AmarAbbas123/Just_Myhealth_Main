<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceServiceFeeDetail extends Model
{
    protected $table = 'sys_finance_service_fee_details';
    protected $fillable = [
        'UserType', 'FeeType', 'CurrencyGBP', 'CurrencyUSD', 'CurrencyEUR'
    ];
}
