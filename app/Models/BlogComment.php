<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'BlogPostID',
        'UserID',
        'GuestName',
        'Comment',
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class, 'BlogPostID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }
}
