<x-app-layout
    :title="$blogPost->Title . ' | JustMy.Health Blog'"
    :metaDescription="$blogPost->Excerpt">

    @push('meta')
        <link rel="canonical" href="{{ route('blogs.show', $blogPost) }}">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $blogPost->Title }}">
        <meta property="og:description" content="{{ $blogPost->Excerpt }}">
        <meta property="og:image" content="{{ $blogPost->featuredImageUrl() }}">
        <meta property="og:url" content="{{ route('blogs.show', $blogPost) }}">
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $blogPost->Title,
                'description' => $blogPost->Excerpt,
                'image' => $blogPost->featuredImageUrl(),
                'datePublished' => optional($blogPost->PublishedAt)->toIso8601String(),
                'dateModified' => $blogPost->updated_at->toIso8601String(),
                'author' => ['@type' => 'Organization', 'name' => 'JustMy.Health'],
                'publisher' => ['@type' => 'Organization', 'name' => 'JustMy.Health'],
                'mainEntityOfPage' => route('blogs.show', $blogPost),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    <div class="bg-gray-50">

        <!-- Compact header bar -->
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <a href="{{ route('blogs') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-teal-700 hover:text-teal-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Blog
                </a>

                @if ($blogPost->SourcePlatform)
                    <span class="block mt-4 text-xs font-semibold uppercase tracking-widest text-teal-600">
                        {{ $blogPost->SourcePlatform }}
                    </span>
                @endif

                <h1 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900 leading-tight max-w-3xl">
                    {{ $blogPost->Title }}
                </h1>

                <div class="mt-3 flex items-center gap-3 text-sm text-gray-500">
                    <time datetime="{{ $blogPost->PublishedAt?->toDateString() }}">
                        {{ $blogPost->PublishedAt?->format('F j, Y') }}
                    </time>
                    @if ($blogPost->author)
                        <span class="text-gray-300">•</span>
                        <span>{{ $blogPost->author->name ?? $blogPost->author->UserName }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Two-column layout: main content + sidebar -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="grid lg:grid-cols-3 gap-10">

                <!-- Main content -->
                <article class="lg:col-span-2 min-w-0">
                    <div class="rounded-2xl overflow-hidden bg-gray-100" style="max-height:440px;">
                        <img src="{{ $blogPost->featuredImageUrl() }}" alt="{{ $blogPost->Title }}"
                            class="w-full object-cover" style="max-height:440px;">
                    </div>

                    <div class="prose prose-teal prose-lg mt-8 max-w-none text-gray-700">
                        {!! $blogPost->Body !!}
                    </div>

                    @if ($blogPost->SourceUrl)
                        <p class="mt-10 pt-6 border-t border-gray-200 text-sm text-gray-500">
                            Original post:
                            <a href="{{ $blogPost->SourceUrl }}" target="_blank" rel="noopener noreferrer"
                                class="text-teal-700 hover:underline">{{ $blogPost->SourceUrl }}</a>
                        </p>
                    @endif
                </article>

                <!-- Sidebar: recent posts -->
                <aside class="lg:col-span-1">
                    <div class="lg:sticky lg:top-24">
                        <div class="flex items-center gap-3 mb-5">
                            <h2 class="text-sm font-bold uppercase tracking-widest text-gray-900">Recent Posts</h2>
                            <div class="flex-1 h-px bg-gray-200"></div>
                        </div>

                        @if ($related->isEmpty())
                            <p class="text-sm text-gray-400">No other posts yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($related as $post)
                                    <a href="{{ route('blogs.show', $post) }}"
                                        class="group flex gap-3 items-start rounded-xl p-2 -mx-2 hover:bg-white transition">
                                        <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->Title }}"
                                            class="w-20 h-16 rounded-lg object-cover flex-shrink-0">
                                        <div class="min-w-0">
                                            @if ($post->SourcePlatform)
                                                <span class="text-[10px] font-semibold uppercase tracking-wide text-teal-600">
                                                    {{ $post->SourcePlatform }}
                                                </span>
                                            @endif
                                            <h3 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 group-hover:text-teal-700 transition-colors">
                                                {{ $post->Title }}
                                            </h3>
                                            <time class="text-xs text-gray-400">{{ $post->PublishedAt?->format('M j, Y') }}</time>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('blogs') }}"
                            class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-teal-700 hover:text-teal-800">
                            View all posts
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </div>

</x-app-layout>