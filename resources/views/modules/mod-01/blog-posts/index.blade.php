<x-app1>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
        <x-page-header />
        <a href="{{ route('blog-posts.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            + New Blog Post
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-lg text-sm">{{ session('status') }}</div>
    @endif

    <!-- ===================== -->
    <!-- MOBILE: card list (below sm) -->
    <!-- ===================== -->
    <div class="space-y-3 sm:hidden">
        @forelse ($posts as $post)
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-4">
                <div class="flex items-start gap-3">
                    <img src="{{ $post->featuredImageUrl() }}"
                        class="h-14 w-14 flex-shrink-0 rounded-xl object-cover shadow-sm ring-1 ring-slate-100">
                    <div class="min-w-0 flex-1">
                        <div class="font-medium text-slate-800 truncate">{{ $post->Title }}</div>
                        <div class="mt-1 flex flex-wrap items-center gap-2">
                            @if ($post->IsPublished)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Draft
                                </span>
                            @endif
                            <span class="text-xs text-slate-400">{{ $post->SourcePlatform ?? '—' }}</span>
                        </div>
                        <div class="mt-1 text-xs text-slate-400">
                            {{ $post->PublishedAt?->format('M j, Y') ?? '—' }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2 border-t border-slate-100 pt-3">
                    <a href="{{ route('blogs.show', $post) }}" target="_blank"
                        class="flex-1 rounded-lg py-1.5 text-center text-xs font-semibold text-indigo-600 hover:bg-indigo-50 transition">
                        View live
                    </a>
                    <a href="{{ route('blog-posts.edit', $post) }}"
                        class="flex-1 rounded-lg py-1.5 text-center text-xs font-semibold text-indigo-600 hover:bg-indigo-50 transition">
                        Edit
                    </a>
                    <form action="{{ route('blog-posts.destroy', $post) }}" method="POST" class="flex-1"
                        onsubmit="return confirm('Delete this post permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-lg py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center">
                <p class="text-sm font-medium text-slate-800">No blog posts yet.</p>
                <p class="mt-1 text-sm text-slate-400">Tap "New Blog Post" above to add your first one.</p>
            </div>
        @endforelse
    </div>

    <!-- ===================== -->
    <!-- TABLET / DESKTOP: table (sm and up) -->
    <!-- ===================== -->
    <div class="hidden sm:block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50/60 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <tr>
                        <th class="px-5 py-3.5">Post</th>
                        <th class="px-5 py-3.5">Source</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Published</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($posts as $post)
                        <tr class="transition-colors hover:bg-[#F7FCFC]">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $post->featuredImageUrl() }}"
                                        class="h-12 w-12 flex-shrink-0 rounded-xl object-cover shadow-sm ring-1 ring-slate-100">
                                    <div class="min-w-0">
                                        <div class="truncate font-medium text-slate-800">{{ $post->Title }}</div>
                                        <a href="{{ route('blogs.show', $post) }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:underline">
                                            View live
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">{{ $post->SourcePlatform ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                @if ($post->IsPublished)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500 ring-1 ring-inset ring-slate-400/10">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $post->PublishedAt?->format('M j, Y') ?? '—' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('blog-posts.edit', $post) }}"
                                        class="rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('blog-posts.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Delete this post permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-full border border-slate-100 bg-slate-50 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17h6m-6-4h6m-6-4h2M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2h-2.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0013.586 3H10.414a1 1 0 00-.707.293L8.293 4.707A1 1 0 017.586 5H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-slate-800">No blog posts yet.</p>
                                    <p class="mt-1 text-sm text-slate-400">Click "New Blog Post" above to add your first one.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

</x-app1>