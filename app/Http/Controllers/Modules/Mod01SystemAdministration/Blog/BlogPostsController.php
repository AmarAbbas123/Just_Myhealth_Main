<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostsController extends Controller
{
    // GET /mod-01/tm/blog-posts
    public function index()
    {
        $posts = BlogPost::orderByDesc('created_at')->paginate(20);

        return view('modules.mod-01.blog-posts.index', compact('posts'));
    }

    // GET /mod-01/tm/blog-posts/create
    public function create()
    {
        return view('modules.mod-01.blog-posts.form', [
            'post' => new BlogPost(),
        ]);
    }

    // POST /mod-01/tm/blog-posts
    public function store(Request $request)
    {
        $validated = $this->validatePost($request);

        $post = new BlogPost($validated);
        $post->Slug = BlogPost::uniqueSlugFromTitle($validated['Title']);
        $post->AuthorUserID = $request->user()->id;

        if ($request->hasFile('FeaturedImage')) {
            $post->FeaturedImagePath = $request->file('FeaturedImage')->store('blog-posts', 'public');
        }

        if ($post->IsPublished && ! $post->PublishedAt) {
            $post->PublishedAt = now();
        }

        $post->save();

        return redirect()
            ->route('blog-posts.index')
            ->with('status', 'Blog post created.');
    }

    // GET /mod-01/tm/blog-posts/{blog_post}/edit
    public function edit(BlogPost $blogPost)
    {
        return view('modules.mod-01.blog-posts.form', [
            'post' => $blogPost,
        ]);
    }

    // PUT/PATCH /mod-01/tm/blog-posts/{blog_post}
    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validatePost($request, $blogPost->id);

        $wasPublished = $blogPost->IsPublished;
        $blogPost->fill($validated);

        // Re-slug only if the title actually changed, so existing shared
        // links/SEO indexing for this post don't break on every edit.
        if ($blogPost->isDirty('Title')) {
            $blogPost->Slug = BlogPost::uniqueSlugFromTitle($validated['Title'], $blogPost->id);
        }

        if ($request->hasFile('FeaturedImage')) {
            if ($blogPost->FeaturedImagePath) {
                Storage::disk('public')->delete($blogPost->FeaturedImagePath);
            }
            $blogPost->FeaturedImagePath = $request->file('FeaturedImage')->store('blog-posts', 'public');
        }

        if (! $wasPublished && $blogPost->IsPublished && ! $blogPost->PublishedAt) {
            $blogPost->PublishedAt = now();
        }

        $blogPost->save();

        return redirect()
            ->route('blog-posts.index')
            ->with('status', 'Blog post updated.');
    }

    // DELETE /mod-01/tm/blog-posts/{blog_post}
    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->FeaturedImagePath) {
            Storage::disk('public')->delete($blogPost->FeaturedImagePath);
        }
        $blogPost->delete();

        return redirect()
            ->route('blog-posts.index')
            ->with('status', 'Blog post deleted.');
    }

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'Title' => ['required', 'string', 'max:255'],
            'Excerpt' => ['required', 'string', 'max:300'],
            'Body' => ['required', 'string'],
            'FeaturedImage' => ['nullable', 'image', 'max:4096'],
            'SourcePlatform' => ['nullable', 'string', 'max:100'],
            'SourceUrl' => ['nullable', 'url', 'max:2048'],
            'IsPublished' => ['sometimes', 'boolean'],
            'PublishedAt' => ['nullable', 'date'],
        ]);
    }
}
