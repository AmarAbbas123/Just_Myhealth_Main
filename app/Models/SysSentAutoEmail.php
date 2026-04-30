<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysSentAutoEmail extends Model
{
    use HasFactory;

    protected $table = 'sys_sent_auto_emails';
    protected $primaryKey = 'ID';
    public $timestamps = false;   // IMPORTANT   if table dont have created_at, updated_at columns

    protected $fillable = [
        'UserID',
        'UserType',
        'ModuleRef',
        'ModuleSubRef',
        'ModuleFull',
        'EmailSubRef',
        'EmailSentDateTime',
        'EventNotes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }

    public function configuredEmail()
    {
        return $this->belongsTo(SysConfiguredAutoEmails::class, 'EmailSubRef', 'EmailSubRef');
    }
}
