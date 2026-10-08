<x-app-layout title="Blog | JustMy.Health" metaDescription="Wellness tips, therapy insights, and updates from JustMy.Health — including our latest social media posts.">
<section class="relative h-72 lg:h-80 flex items-start lg:items-center pt-20 lg:pt-24">
    
    <!-- Background Image -->
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/welcome-page/hero-bg.jpg') }}"
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

    <!-- Main heading & Search Filter -->
    <section class="relative pt-12 pb-6 lg:pt-16 lg:pb-8 bg-gray-50">
        <div class="max-w-3xl mx-auto text-center px-4">
            <span class="inline-flex rounded-full bg-teal-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-teal-700">
                Our Blog
            </span>
            <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900">Insights, Stories &amp; Updates</h1>
            <p class="mt-3 text-gray-600">
                Wellness tips, therapy insights, and the latest posts from our community and social channels —
                all in one place.
            </p>

            <!-- Search Filter Bar -->
            <div class="mt-8 max-w-xl mx-auto">
                <form action="{{ route('blogs') }}" method="GET" class="relative">
                    @if(!empty($platform))
                        <input type="hidden" name="platform" value="{{ $platform }}">
                    @endif
                    <div class="relative flex items-center">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ $search ?? '' }}"
                               placeholder="Search articles by title, topic, or keyword..."
                               class="w-full rounded-full border border-gray-200 bg-white pl-11 pr-28 py-3.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-teal-600 focus:outline-hidden focus:ring-2 focus:ring-teal-600/20">
                        
                        @if(!empty($search))
                            <a href="{{ route('blogs', array_filter(['platform' => $platform ?? null])) }}"
                               class="absolute right-24 text-gray-400 hover:text-gray-600 p-1"
                               title="Clear search query">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif

                        <button type="submit"
                                class="absolute right-1.5 top-1.5 bottom-1.5 px-5 rounded-full text-xs font-semibold text-white shadow-xs transition hover:opacity-95 active:scale-95"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            Search
                        </button>
                    </div>
                </form>

                {{-- Platform Topic Filter Pills --}}
                @if(isset($platforms) && $platforms->isNotEmpty())
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-4">
                        <a href="{{ route('blogs', array_filter(['search' => $search ?? null])) }}"
                           class="px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ empty($platform) ? 'bg-teal-700 text-white shadow-xs' : 'bg-white text-gray-600 border border-gray-200 hover:border-teal-500 hover:text-teal-700' }}">
                            All Topics
                        </a>
                        @foreach($platforms as $p)
                            <a href="{{ route('blogs', array_filter(['search' => $search ?? null, 'platform' => $p])) }}"
                               class="px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ ($platform ?? '') === $p ? 'bg-teal-700 text-white shadow-xs' : 'bg-white text-gray-600 border border-gray-200 hover:border-teal-500 hover:text-teal-700' }}">
                                {{ $p }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Active Filter Summary --}}
                @if(!empty($search) || !empty($platform))
                    <div class="flex items-center justify-center gap-2 mt-4 text-xs text-gray-500">
                        <span>
                            Found <strong class="font-bold text-gray-800">{{ $posts->total() }}</strong> {{ \Illuminate\Support\Str::plural('article', $posts->total()) }}
                            @if(!empty($search))
                                matching "<span class="font-semibold text-teal-700">{{ $search }}</span>"
                            @endif
                            @if(!empty($platform))
                                in <span class="font-semibold text-teal-700">{{ $platform }}</span>
                            @endif
                        </span>
                        <span>•</span>
                        <a href="{{ route('blogs') }}" class="font-semibold text-teal-700 hover:underline">
                            Reset filters
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </section>

    <!-- Post grid -->
    <section class="py-10 lg:py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($posts->isEmpty())
                <div class="text-center py-16 max-w-md mx-auto rounded-2xl border border-dashed border-gray-200 bg-white p-8">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 mx-auto flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    @if(!empty($search) || !empty($platform))
                        <h3 class="text-base font-bold text-gray-900 mb-1">No matching articles found</h3>
                        <p class="text-sm text-gray-500 mb-5">We couldn't find any articles matching your search query. Try different keywords or reset your filters.</p>
                        <a href="{{ route('blogs') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold text-white shadow-xs transition hover:opacity-95"
                           style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            Reset Search Filters
                        </a>
                    @else
                        <p class="text-gray-500">No posts published yet — check back soon.</p>
                    @endif
                </div>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="group flex flex-col rounded-2xl bg-white overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,0.06)] ring-1 ring-gray-100 hover:shadow-[0_20px_40px_-16px_rgba(15,118,110,0.25)] hover:-translate-y-1 transition-all duration-300">

                            <a href="{{ route('blogs.show', $post) }}" class="relative block overflow-hidden aspect-[16/10]">
                                <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->Title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.06]"
                                    loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-black/0"></div>

                                @if ($post->SourcePlatform)
                                    <span class="absolute top-3 left-3 inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-wide text-white bg-white/15 backdrop-blur-md px-3 py-1 rounded-full ring-1 ring-white/25">
                                        {{ $post->SourcePlatform }}
                                    </span>
                                @endif
                            </a>

                            <div class="flex flex-col flex-1 p-5">
                                <time class="text-xs font-medium text-gray-400" datetime="{{ $post->PublishedAt?->toDateString() }}">
                                    {{ $post->PublishedAt?->format('M j, Y') }}
                                </time>

                                <h2 class="mt-2 text-lg text-gray-900 leading-snug font-bold">
                                    <a href="{{ route('blogs.show', $post) }}" class="hover:text-teal-700 transition-colors">
                                        {{ $post->Title }}
                                    </a>
                                </h2>

                                <p class="mt-2 text-sm text-gray-600 flex-1 leading-relaxed">
                                    {{ $post->Excerpt }}
                                </p>

                                <a href="{{ route('blogs.show', $post) }}"
                                    class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-teal-700 group/link">
                                    Read more
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover/link:translate-x-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
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