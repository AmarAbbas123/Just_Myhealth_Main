<x-app-layout title="Blog | JustMy.Health" metaDescription="Wellness tips, therapy insights, and updates from JustMy.Health — including our latest social media posts.">

    <!-- Hero -->
    <section class="relative pt-28 pb-12 lg:pt-32 lg:pb-16 bg-gray-50">
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
