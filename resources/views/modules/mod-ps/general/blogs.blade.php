<x-app-layout title="Blog | JustMy.Health" metaDescription="Wellness tips, therapy insights, and updates from JustMy.Health — including our latest social media posts.">
<section class="relative h-72 lg:h-80 flex items-start lg:items-center pt-20 lg:pt-24">
    
    <!-- Background Image -->
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/welcome-page/hero-bg.png') }}"
             alt="Hero Background"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <!-- Content -->
    <div class="px-6 lg:px-20 max-w-4xl">

        <!-- Breadcrumb -->
        <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
            </svg>
            <span>Home</span>
            <span class="text-white/60">›</span>
            <span class="text-white font-semibold">Blogs</span>
        </div>

        <!-- Page Title -->
        <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
            Blogs <span class="text-teal-400">JustMy.Health</span>
        </h1>

       

    </div>
</section>
    <!-- Hero -->
    <section class="relative pt-12 pb-12 lg:pt-16 lg:pb-16 bg-gray-50">
        <div class="max-w-3xl mx-auto text-center px-4">
            <span class="inline-flex rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-green-700">
                Our Blog
            </span>
            <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900">Insights, Stories &amp; Updates</h1>
            <p class="mt-4 text-gray-600">
                Wellness tips, therapy insights, and the latest posts from our community and social channels —
                all in one place.
            </p>
        </div>
    </section>

    <!-- Post grid -->
    <section class="py-10 lg:py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($posts->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500">No posts published yet — check back soon.</p>
                </div>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="flex flex-col rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition overflow-hidden">
                            <a href="{{ route('blogs.show', $post) }}" class="block">
                                <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->Title }}"
                                    class="w-full h-48 object-cover" loading="lazy">
                            </a>
                            <div class="flex flex-col flex-1 p-5">
                                @if ($post->SourcePlatform)
                                    <span class="text-xs font-semibold uppercase tracking-wide text-green-600 mb-2">
                                        {{ $post->SourcePlatform }}
                                    </span>
                                @endif
                                <h2 class="text-lg font-semibold text-gray-900 leading-snug">
                                    <a href="{{ route('blogs.show', $post) }}" class="hover:text-green-600">
                                        {{ $post->Title }}
                                    </a>
                                </h2>
                                <p class="mt-2 text-sm text-gray-600 flex-1">
                                    {{ $post->Excerpt }}
                                </p>
                                <div class="mt-4 flex items-center justify-between">
                                    <time class="text-xs text-gray-400" datetime="{{ $post->PublishedAt?->toDateString() }}">
                                        {{ $post->PublishedAt?->format('M j, Y') }}
                                    </time>
                                    <a href="{{ route('blogs.show', $post) }}"
                                        class="text-sm font-semibold text-green-600 hover:text-green-700">
                                        Read more →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif

        </div>
    </section>

</x-app-layout>
