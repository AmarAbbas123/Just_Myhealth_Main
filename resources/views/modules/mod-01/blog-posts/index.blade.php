<x-app1>

    @php
        $totalPosts = $posts->total();
        $publishedCount = \App\Models\BlogPost::where('IsPublished', true)->count();
        $draftCount = \App\Models\BlogPost::where('IsPublished', false)->count();
        $videoPostsCount = \App\Models\BlogPost::whereNotNull('VideoUrl')->where('VideoUrl', '!=', '')->count();
    @endphp

    <div class="w-full max-w-7xl mx-auto space-y-6"
         x-data="{
             search: '',
             statusFilter: 'all',
             matches(title, source, isPublished) {
                 const q = this.search.toLowerCase().trim();
                 const matchesQuery = !q ||
                     (title && title.toLowerCase().includes(q)) ||
                     (source && source.toLowerCase().includes(q));

                 const matchesStatus =
                     this.statusFilter === 'all' ||
                     (this.statusFilter === 'published' && isPublished) ||
                     (this.statusFilter === 'draft' && !isPublished);

                 return matchesQuery && matchesStatus;
             }
         }">

        <!-- Header & Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <x-page-header :menu="$menu ?? null" title="Blog Posts" subtitle="Manage, publish, and curate blog articles and media" />

            <div class="flex items-center gap-3 shrink-0 self-start sm:self-auto">
                <a href="{{ route('blog-posts.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white shadow-xs hover:opacity-95 transition-all active:scale-95"
                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>New Blog Post</span>
                </a>
            </div>
        </div>

        <!-- Session Status Flash Alert -->
        @if (session('status'))
            <div class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-sm shadow-xs animate-fadeIn"
                 x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- ===================== -->
        <!-- QUICK SUMMARY CARDS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Card 1: Total Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Articles</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($totalPosts) }}</p>
                </div>
            </div>

            <!-- Card 2: Published Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Published</p>
                    <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($publishedCount) }}</p>
                </div>
            </div>

            <!-- Card 3: Drafts -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-300 bg-amber-50 dark:bg-amber-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Drafts</p>
                    <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ number_format($draftCount) }}</p>
                </div>
            </div>

            <!-- Card 4: Video Features -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Video Posts</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ number_format($videoPostsCount) }}</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- BLOG POSTS TABLE & ROSTER -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">

            <!-- Toolbar & Search Filters -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Blog Articles & Media</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                        {{ $totalPosts }} Posts
                    </span>
                </div>

                <!-- Instant Filter Controls -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative min-w-[200px] flex-1 sm:flex-initial">
                        <input type="text"
                               x-model="search"
                               placeholder="Filter by title or platform..."
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-900/60 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-hidden focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition" />
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <select x-model="statusFilter"
                            class="py-2 px-3 text-xs rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-900/60 text-gray-700 dark:text-gray-200 focus:outline-hidden focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                        <option value="all">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Drafts</option>
                    </select>
                </div>
            </div>

            {{-- ── Mobile card list (visible on xs/sm, hidden md+) ── --}}
            <div class="flex flex-col divide-y divide-gray-100 dark:divide-gray-700/60 md:hidden">
                @forelse ($posts as $post)
                    <div class="p-4 flex gap-3 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition"
                         x-show="matches(@json($post->Title), @json($post->SourcePlatform), @json($post->IsPublished))">
                        <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->Title }}" class="w-16 h-16 object-cover rounded-xl shrink-0 border border-gray-200 dark:border-gray-700">
                        <div class="min-w-0 flex-1">
                            <div class="font-bold text-gray-900 dark:text-gray-100 text-sm leading-snug break-words">
                                {{ $post->Title }}
                            </div>
                            <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                                @if ($post->IsPublished)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 text-[11px] font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Draft
                                    </span>
                                @endif

                                @if ($post->SourcePlatform)
                                    <span class="px-2 py-0.5 rounded-md bg-gray-50 dark:bg-gray-700/40 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 text-[11px]">
                                        {{ $post->SourcePlatform }}
                                    </span>
                                @endif

                                @if ($post->PublishedAt)
                                    <span class="text-[11px] text-gray-400">
                                        {{ $post->PublishedAt->format('M j, Y') }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 mt-3">
                                <a href="{{ route('blogs.show', $post) }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-[#1C9BA0] hover:underline">
                                    <span>View live</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                                <a href="{{ route('blog-posts.edit', $post) }}"
                                    class="text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-[#1C9BA0] dark:hover:text-[#1C9BA0]">
                                    Edit
                                </a>
                                <form action="{{ route('blog-posts.destroy', $post) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Delete this post permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-rose-600 hover:text-rose-700">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-12 text-center">
                        <p class="text-sm text-gray-500">No blog posts yet. Click "New Blog Post" to add your first one.</p>
                    </div>
                @endforelse
            </div>

            {{-- ── Desktop table (hidden on xs/sm, visible md+) ── --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/40 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700/80">
                        <tr>
                            <th class="px-5 py-3.5 w-24">Image</th>
                            <th class="px-5 py-3.5">Title & Live URL</th>
                            <th class="px-5 py-3.5 w-36">Source</th>
                            <th class="px-5 py-3.5 w-32">Status</th>
                            <th class="px-5 py-3.5 w-36">Published Date</th>
                            <th class="px-5 py-3.5 w-40 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                        @forelse ($posts as $post)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition-colors"
                                x-show="matches(@json($post->Title), @json($post->SourcePlatform), @json($post->IsPublished))">
                                
                                <!-- Featured Image Thumbnail -->
                                <td class="px-5 py-3.5 align-middle">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 shrink-0 shadow-2xs">
                                        <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->Title }}" class="w-full h-full object-cover">
                                    </div>
                                </td>

                                <!-- Title & Live Link -->
                                <td class="px-5 py-3.5 min-w-0 align-middle">
                                    <div class="font-bold text-gray-900 dark:text-gray-100 break-words hover:text-[#1C9BA0] transition">
                                        {{ $post->Title }}
                                    </div>
                                    <div class="flex items-center gap-3 mt-1 text-xs">
                                        <a href="{{ route('blogs.show', $post) }}" target="_blank"
                                            class="inline-flex items-center gap-1 font-semibold text-[#1C9BA0] hover:text-[#158085] hover:underline">
                                            <span>View live article</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>

                                        @if($post->VideoUrl)
                                            <span class="inline-flex items-center gap-1 text-[11px] text-indigo-600 dark:text-indigo-400 font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                                Video Included
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Source Platform -->
                                <td class="px-5 py-3.5 align-middle">
                                    @if($post->SourcePlatform)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                            {{ $post->SourcePlatform }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="px-5 py-3.5 align-middle whitespace-nowrap">
                                    @if ($post->IsPublished)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 text-xs font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 text-xs font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <!-- Published Date -->
                                <td class="px-5 py-3.5 align-middle whitespace-nowrap text-xs text-gray-600 dark:text-gray-400 font-mono">
                                    {{ $post->PublishedAt?->format('M j, Y') ?? '—' }}
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-3.5 align-middle text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('blog-posts.edit', $post) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-[#1C9BA0] hover:text-[#1C9BA0] dark:hover:border-[#1C9BA0] dark:hover:text-[#1C9BA0] shadow-2xs transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        <form action="{{ route('blog-posts.destroy', $post) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this post permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-600 bg-white dark:bg-gray-800 rounded-lg border border-rose-200 dark:border-rose-900/60 hover:bg-rose-50 dark:hover:bg-rose-950/40 shadow-2xs transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="inline-flex flex-col items-center justify-center text-gray-400">
                                        <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center mb-3 text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">No blog posts found</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Click "New Blog Post" to publish your first article.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            @if ($posts->hasPages())
                <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-700/80">
                    {{ $posts->links('pagination::tailwind') }}
                </div>
            @endif

        </div>

    </div>

</x-app1>