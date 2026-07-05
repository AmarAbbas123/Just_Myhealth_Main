<x-app1>

    <div class="flex justify-between mb-6">
        <x-page-header />
    </div>

    <div class="max-w-3xl space-y-6">

        <!-- Header -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-start gap-3 p-4 sm:items-center sm:gap-4 sm:p-6">
                <div class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">Blog</p>
                    <h1 class="text-lg sm:text-xl font-semibold text-slate-900 mt-0.5">
                        {{ $post->exists ? 'Edit Blog Post' : 'New Blog Post' }}
                    </h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        {{ $post->exists ? 'Update the content below and save your changes.' : 'Fill in the details below to create a new post.' }}
                    </p>
                </div>
            </div>
            <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 to-indigo-300"></div>
        </div>

        @if ($errors->any())
            <div class="flex gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M4.93 19h14.14a1 1 0 00.86-1.5L12.86 4.5a1 1 0 00-1.72 0L4.07 17.5a1 1 0 00.86 1.5z" />
                </svg>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
            action="{{ $post->exists ? route('blog-posts.update', $post) : route('blog-posts.store') }}"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($post->exists)
                @method('PUT')
            @endif

            <!-- Content section -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6 space-y-6">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">1</span>
                    Content
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Title</label>
                    <input type="text" name="Title" value="{{ old('Title', $post->Title) }}" required maxlength="255"
                        placeholder="e.g. 5 stretches to ease desk-work back pain"
                        class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Excerpt</label>
                    <p class="text-xs text-slate-400 mt-0.5 mb-2">Short teaser shown on the blog grid — one or two sentences.</p>
                    <textarea name="Excerpt" rows="2" maxlength="250" required
                        placeholder="A quick hook that makes someone want to click Read more…"
                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">{{ old('Excerpt', $post->Excerpt) }}</textarea>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Full Post Content</label>
                    <p class="text-xs text-slate-400 mt-0.5 mb-2">Basic HTML is allowed (e.g. &lt;p&gt;, &lt;b&gt;, &lt;img&gt;).</p>
                    <textarea name="Body" rows="10" required
                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition font-mono text-sm">{{ old('Body', $post->Body) }}</textarea>
                </div>
            </div>

            <!-- Source section -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6 space-y-6">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">2</span>
                    Source
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Source Platform</label>
                        <select name="SourcePlatform"
                            class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                            <option value="">— None (original content) —</option>
                            @foreach (['Instagram', 'Facebook', 'Twitter / X', 'LinkedIn', 'TikTok'] as $platform)
                                <option value="{{ $platform }}" @selected(old('SourcePlatform', $post->SourcePlatform) === $platform)>
                                    {{ $platform }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Original Post URL</label>
                        <input type="url" name="SourceUrl" value="{{ old('SourceUrl', $post->SourceUrl) }}"
                            placeholder="https://instagram.com/p/..."
                            class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                    </div>
                </div>
            </div>

            <!-- Media section -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">3</span>
                    Featured Image
                </div>

                <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                    @if ($post->FeaturedImagePath)
                        <img src="{{ $post->featuredImageUrl() }}" class="w-20 h-20 object-cover rounded-xl border border-slate-100 shadow-sm">
                    @else
                        <div class="w-20 h-20 rounded-xl bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center text-slate-300 text-xs">
                            No image
                        </div>
                    @endif
                    <div class="min-w-0">
                        <input type="file" name="FeaturedImage" accept="image/*"
                            class="max-w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:text-sm file:font-medium hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-400 mt-1">
                            {{ $post->FeaturedImagePath ? 'Upload a new image to replace the current one.' : 'JPG or PNG, up to 4MB.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Publish settings -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6">
                <label for="IsPublished" class="flex items-start justify-between gap-4 cursor-pointer sm:items-center">
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-800">Published</span>
                        <span class="block text-xs text-slate-400 mt-0.5">Visible on the public blog immediately</span>
                    </span>

                    <span class="relative inline-flex flex-shrink-0 mt-0.5 sm:mt-0">
                        <input type="hidden" name="IsPublished" value="0">
                        <input type="checkbox" id="IsPublished" name="IsPublished" value="1"
                            @checked(old('IsPublished', $post->IsPublished))
                            class="peer sr-only">
                        <span class="h-6 w-11 rounded-full bg-slate-200 transition-colors duration-200 peer-checked:bg-indigo-600"></span>
                        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-5"></span>
                    </span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-indigo-700 transition">
                    {{ $post->exists ? 'Save Changes' : 'Create Post' }}
                </button>
                <a href="{{ route('blog-posts.index') }}" class="w-full sm:w-auto text-center px-6 py-2.5 bg-white text-slate-600 text-sm font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</x-app1>