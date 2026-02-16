<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysModuleList extends Model
{
    use HasFactory;

    protected $table = 'sys_module_list';
    protected $primaryKey = 'ID';

    // IMPORTANT   if table dont have created_at, updated_at columns
    public $timestamps = false; 

    protected $fillable = [
        'ModuleRef',
        'ModuleSubRef',
        'ModuleFull',
        'ModuleDesc',
        'ModuleStatus',
    ];
}
