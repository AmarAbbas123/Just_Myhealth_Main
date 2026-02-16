<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysConfiguredAutoEmails extends Model
{
    use HasFactory;
    
    protected $table = 'sys_configured_auto_emails';
    protected $primaryKey = 'ID';
    public $timestamps = false;  //  IMPORTANT   if table dont have created_at, updated_at columns
    
    protected $fillable = [
        'ModuleRef',
        'ModuleSubRef',
        'ModuleFull',
        'EmailSubRef',
        'EmailShortDesc',
        'EamilLongDesc',
    ];

    public function sentEmails()
    {
        return $this->hasMany(SysSentAutoEmail::class, 'EmailSubRef', 'EmailSubRef');
    }
}
