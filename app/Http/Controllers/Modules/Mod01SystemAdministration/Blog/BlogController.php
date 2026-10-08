<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    // GET /blogs — main blog listing page (grid of cards)
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $platform = trim($request->get('platform', ''));

        $posts = BlogPost::published()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('Title', 'like', "%{$search}%")
                      ->orWhere('Excerpt', 'like', "%{$search}%")
                      ->orWhere('Body', 'like', "%{$search}%")
                      ->orWhere('SourcePlatform', 'like', "%{$search}%");
                });
            })
            ->when($platform, function ($query, $platform) {
                $query->where('SourcePlatform', $platform);
            })
            ->orderByDesc('PublishedAt')
            ->paginate(6)
            ->withQueryString();

        $platforms = BlogPost::published()
            ->whereNotNull('SourcePlatform')
            ->where('SourcePlatform', '!=', '')
            ->distinct()
            ->pluck('SourcePlatform');

        return view('modules.mod-ps.general.blogs', compact('posts', 'search', 'platform', 'platforms'));
    }

    // GET /blogs/{blogPost} — single full post page
    public function show(BlogPost $blogPost)
    {
        // Route-model binding matches on Slug (see BlogPost::getRouteKeyName()).
        // Unpublished / future-dated posts 404 for everyone except logged-in admins,
        // so you can preview a draft link before it goes live.
        $isAdmin = auth()->check()
            && array_key_exists((int) auth()->user()->UserType, config('user_types.admins', []));

        if (! $isAdmin && (! $blogPost->IsPublished || $blogPost->PublishedAt?->isFuture())) {
            abort(404);
        }

        $related = BlogPost::published()
            ->where('id', '!=', $blogPost->id)
            ->orderByDesc('PublishedAt')
            ->take(3)
            ->get();

        return view('modules.mod-ps.general.blog-show', compact('blogPost', 'related'));
    }
}
