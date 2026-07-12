<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    // GET /blogs — main blog listing page (grid of cards)
    public function index()
    {
        $posts = BlogPost::published()
            ->orderByDesc('PublishedAt')
            ->paginate(6);

        return view('modules.mod-ps.general.blogs', compact('posts'));
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