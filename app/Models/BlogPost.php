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
        'VideoUrl',
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
        if ($this->FeaturedImagePath) {
            return asset('storage/' . $this->FeaturedImagePath);
        }

        // Inline SVG fallback — no dependency on a physical placeholder file
        // existing in public/images/, so this can never 404.
        $label = htmlspecialchars(mb_substr($this->Title ?: 'Blog Post', 0, 30), ENT_QUOTES);
        $svg = <<<SVG
            <svg xmlns="http://www.w3.org/2000/svg" width="800" height="450" viewBox="0 0 800 450">
                <rect width="800" height="450" fill="#e5e7eb"/>
                <text x="400" y="235" font-family="Arial, sans-serif" font-size="28" fill="#9ca3af"
                    text-anchor="middle" dominant-baseline="middle">{$label}</text>
            </svg>
            SVG;

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Convert a normal YouTube/Vimeo watch URL into its embeddable iframe URL.
     * Returns null if VideoUrl is empty or isn't a recognized embeddable host —
     * in that case the blog page falls back to a "Watch the video" button
     * that opens the original link in a new tab instead (e.g. for Facebook).
     */
    public function embeddableVideoUrl(): ?string
    {
        $url = $this->VideoUrl;
        if (! $url) {
            return null;
        }

        // youtube.com/watch?v=XXXX or youtu.be/XXXX
        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // vimeo.com/XXXXXXX
        if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return null;
    }

    /**
     * True if VideoUrl exists but isn't embeddable (e.g. a Facebook video link) —
     * used to decide whether to show an iframe or an external "Watch" button.
     */
    public function hasExternalOnlyVideo(): bool
    {
        return (bool) $this->VideoUrl && ! $this->embeddableVideoUrl();
    }
}