<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'Title',
        'Slug',
        'Excerpt',
        'Body',
        'FeaturedImagePath',
        'SourcePlatform',
        'SourceUrl',
        'IsPublished',
        'PublishedAt',
        'AuthorUserID',
    ];

    protected $casts = [
        'IsPublished' => 'boolean',
        'PublishedAt' => 'datetime',
    ];

    // Use the slug in route-model binding: /blogs/{blogPost}
    public function getRouteKeyName(): string
    {
        return 'Slug';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'AuthorUserID');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('IsPublished', true)
            ->where('PublishedAt', '<=', now());
    }

    /**
     * Build a unique slug from a title, avoiding collisions with existing posts.
     */
    public static function uniqueSlugFromTitle(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            static::where('Slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }

    public function featuredImageUrl(): string
    {
        return $this->FeaturedImagePath
            ? asset('storage/' . $this->FeaturedImagePath)
            : asset('images/blog-placeholder.jpg');
    }
}
