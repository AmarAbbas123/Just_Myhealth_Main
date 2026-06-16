<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFinanceUserType30BankDetails extends Model
{
    protected $table = 'sys_finance_user_type_30_bank_details';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'TherapistUserID',
        'NameOnAccount',
        'BankName',
        'BankIBAN',
        'BankSWIFT',
        'BankSort',
        'BankAccountNumber',
        'BankDefaultCurrency',
    ];
}
