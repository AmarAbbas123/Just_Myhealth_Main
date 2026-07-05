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

    <article class="pt-28 pb-16 lg:pt-32 lg:pb-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('blogs') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                ← Back to Blog
            </a>

            @if ($blogPost->SourcePlatform)
                <span class="inline-flex mt-4 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-green-700">
                    Originally on {{ $blogPost->SourcePlatform }}
                </span>
            @endif

            <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                {{ $blogPost->Title }}
            </h1>

            <div class="mt-3 flex items-center gap-3 text-sm text-gray-500">
                <time datetime="{{ $blogPost->PublishedAt?->toDateString() }}">
                    {{ $blogPost->PublishedAt?->format('F j, Y') }}
                </time>
                @if ($blogPost->author)
                    <span>&middot;</span>
                    <span>{{ $blogPost->author->name ?? $blogPost->author->UserName }}</span>
                @endif
            </div>

            <img src="{{ $blogPost->featuredImageUrl() }}" alt="{{ $blogPost->Title }}"
                class="mt-6 w-full rounded-2xl object-cover max-h-[480px]">

            <div class="prose prose-lg mt-8 max-w-none text-gray-700">
                {!! $blogPost->Body !!}
            </div>

            @if ($blogPost->SourceUrl)
                <p class="mt-8 text-sm text-gray-500">
                    Original post:
                    <a href="{{ $blogPost->SourceUrl }}" target="_blank" rel="noopener noreferrer"
                        class="text-green-600 hover:underline">{{ $blogPost->SourceUrl }}</a>
                </p>
            @endif
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="py-12 bg-gray-50 border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">More from the blog</h2>
                <div class="grid gap-6 sm:grid-cols-3">
                    @foreach ($related as $post)
                        <a href="{{ route('blogs.show', $post) }}"
                            class="block rounded-xl overflow-hidden bg-white border border-gray-100 shadow-sm hover:shadow-md transition">
                            <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->Title }}" class="w-full h-32 object-cover">
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $post->Title }}</h3>
                                <time class="text-xs text-gray-400">{{ $post->PublishedAt?->format('M j, Y') }}</time>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-app-layout>
