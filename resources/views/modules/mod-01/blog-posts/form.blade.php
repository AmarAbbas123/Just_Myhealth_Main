<x-app1>

    <div class="flex justify-between mb-6">
        <x-page-header />
    </div>

    <div class="max-w-3xl">
        <div class="mb-6">
            <span class="text-xs font-semibold uppercase tracking-widest text-indigo-500">Blog</span>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">
                {{ $post->exists ? 'Edit Blog Post' : 'New Blog Post' }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $post->exists ? 'Update the content below and save your changes.' : 'Fill in the details below to create a new post.' }}
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
            action="{{ $post->exists ? route('blog-posts.update', $post) : route('blog-posts.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if ($post->exists)
                @method('PUT')
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Title</label>
                    <input type="text" name="Title" value="{{ old('Title', $post->Title) }}" required maxlength="255"
                        placeholder="e.g. 5 stretches to ease desk-work back pain"
                        class="mt-2 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Excerpt</label>
                    <p class="text-xs text-gray-400 mt-0.5 mb-2">Short teaser shown on the blog grid — one or two sentences.</p>
                    <textarea name="Excerpt" rows="2" maxlength="300" required
                        placeholder="A quick hook that makes someone want to click Read more…"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">{{ old('Excerpt', $post->Excerpt) }}</textarea>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Full Post Content</label>
                    <p class="text-xs text-gray-400 mt-0.5 mb-2">Basic HTML is allowed (e.g. &lt;p&gt;, &lt;b&gt;, &lt;img&gt;).</p>
                    <textarea name="Body" rows="10" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition font-mono text-sm">{{ old('Body', $post->Body) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Source Platform</label>
                        <select name="SourcePlatform"
                            class="mt-2 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                            <option value="">— None (original content) —</option>
                            @foreach (['Instagram', 'Facebook', 'Twitter / X', 'LinkedIn', 'TikTok'] as $platform)
                                <option value="{{ $platform }}" @selected(old('SourcePlatform', $post->SourcePlatform) === $platform)>
                                    {{ $platform }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Original Post URL</label>
                        <input type="url" name="SourceUrl" value="{{ old('SourceUrl', $post->SourceUrl) }}"
                            placeholder="https://instagram.com/p/..."
                            class="mt-2 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Featured Image</label>
                    <div class="mt-2 flex items-center gap-4">
                        @if ($post->FeaturedImagePath)
                            <img src="{{ $post->featuredImageUrl() }}" class="w-20 h-20 object-cover rounded-xl border border-gray-100">
                        @else
                            <div class="w-20 h-20 rounded-xl bg-gray-50 border border-dashed border-gray-200 flex items-center justify-center text-gray-300 text-xs">
                                No image
                            </div>
                        @endif
                        <div>
                            <input type="file" name="FeaturedImage" accept="image/*"
                                class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:text-sm file:font-medium hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $post->FeaturedImagePath ? 'Upload a new image to replace the current one.' : 'JPG or PNG, up to 4MB.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <label for="IsPublished"
                    class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 cursor-pointer">
                    <input type="hidden" name="IsPublished" value="0">
                    <input type="checkbox" id="IsPublished" name="IsPublished" value="1"
                        @checked(old('IsPublished', $post->IsPublished))
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">
                        Published <span class="text-gray-400">— visible on the public blog immediately</span>
                    </span>
                </label>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-indigo-700 transition">
                    {{ $post->exists ? 'Save Changes' : 'Create Post' }}
                </button>
                <a href="{{ route('blog-posts.index') }}" class="px-6 py-2.5 bg-white text-gray-600 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</x-app1>