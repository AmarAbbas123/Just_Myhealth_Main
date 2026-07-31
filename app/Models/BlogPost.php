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
        'VideoTitle',
        'VideoDescription',
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
     *
     * Guaranteed to never return an empty string — even if the title is
     * made up entirely of characters Str::slug() can't transliterate
     * (e.g. certain emoji or symbols), which previously caused Slug to be
     * saved as '' and broke every link to that post (URLs became
     * "/blogs/" and silently redirected back to the blog list).
     */
    public static function uniqueSlugFromTitle(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);

        if ($base === '') {
            $base = 'post-' . Str::random(8);
        }

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
            $path = trim($this->FeaturedImagePath);

            // Older posts may store a complete URL or a path that already
            // includes the public storage prefix. Do not prefix it a second
            // time, otherwise the browser requests an invalid image URL.
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }

            $path = ltrim(str_replace('\\', '/', $path), '/');

            if (str_starts_with($path, 'public/')) {
                return asset(substr($path, strlen('public/')));
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
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

    /**
     * Whether the optional YouTube sidebar card has content to display.
     */
    public function hasVideoCard(): bool
    {
        return (bool) ($this->VideoUrl || $this->VideoTitle || $this->VideoDescription);
    }
}
