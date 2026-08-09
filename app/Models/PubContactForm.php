<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PubContactForm extends Model
{
    use HasFactory;

    protected $table = 'pub_contact_form';

    protected $fillable = [
        'Name',
        'Email',
        'Subject',
        'Message',
        'FormLocation',
        'Status',
    ];
}
