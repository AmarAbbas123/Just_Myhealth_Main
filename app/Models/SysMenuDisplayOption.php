<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysMenuDisplayOption extends Model
{
    use HasFactory;

    protected $table = 'sys_menu_display_options';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ParentID',
        'DisplayName',
        'MainPaneID',
        'MainPaneLabel',
        'TileText',
        'Grouping',
        '1',
        '10',
        '30',
        '31',
        '32',
        '90',
        '91',   
        'MenuURL', 
        'ImagePath'
    ];

    // Relation for children
    public function children()
    {
        $userType = auth()->check() ? auth()->user()->UserType : null;
    
        return $this->hasMany(SysMenuDisplayOption::class, 'ParentID')
            ->where($userType, 1)
            ->with('children');
    }
    
}
