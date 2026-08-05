<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(Request $request, BlogPost $blogPost)
    {
        if (! $blogPost->IsPublished || $blogPost->PublishedAt?->isFuture()) {
            abort(404);
        }

        $validated = $request->validate([
            'GuestName' => ['nullable', 'string', 'max:100'],
            'Comment' => ['required', 'string', 'max:2000'],
        ]);

        $blogPost->comments()->create([
            'UserID' => $request->user()?->getKey(),
            'GuestName' => $validated['GuestName'] ?? null,
            'Comment' => $validated['Comment'],
        ]);

        return redirect()
            ->route('blogs.show', $blogPost)
            ->with('success', 'Your comment has been posted.');
    }
}
