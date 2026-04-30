<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',  // 🔼 validation helper fields, not DB columns, must be lowercase
        'Password',     // 🔼 DB field, must be uppercase
        'Password_confirmation', // 🔼 validation helper fields, not DB columns, must be lowercase
    ];
}
