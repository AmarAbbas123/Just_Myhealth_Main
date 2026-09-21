<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FAQ extends Model
{
    protected $table = 'faqs';
    
    protected $fillable = [
        'Question',
        'Answer',
        'SortOrder',
        'Section',
        'IsActive',
        'HashTag',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('IsActive', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('SortOrder')->orderBy('id');
    }
}