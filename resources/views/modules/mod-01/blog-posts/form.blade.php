<x-app1>

    <div class="flex justify-between mb-4">
        <x-page-header />
    </div>

    <div class="bg-white shadow rounded-xl p-6 border border-gray-100 max-w-3xl">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ $post->exists ? 'Edit Blog Post' : 'New Blog Post' }}
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
            action="{{ $post->exists ? route('blog-posts.update', $post) : route('blog-posts.store') }}"
            enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if ($post->exists)
                @method('PUT')
            @endif

            <div>
                <label class="text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="Title" value="{{ old('Title', $post->Title) }}" required maxlength="255"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Excerpt (short teaser shown on the blog grid)</label>
                <textarea name="Excerpt" rows="2" maxlength="300" required
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('Excerpt', $post->Excerpt) }}</textarea>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Full Post Content</label>
                <textarea name="Body" rows="10" required
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm">{{ old('Body', $post->Body) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Basic HTML is allowed (e.g. &lt;p&gt;, &lt;b&gt;, &lt;img&gt;).</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Source Platform (optional)</label>
                    <select name="SourcePlatform"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">— None (original content) —</option>
                        @foreach (['Instagram', 'Facebook', 'Twitter / X', 'LinkedIn', 'TikTok'] as $platform)
                            <option value="{{ $platform }}" @selected(old('SourcePlatform', $post->SourcePlatform) === $platform)>
                                {{ $platform }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Original Post URL (optional)</label>
                    <input type="url" name="SourceUrl" value="{{ old('SourceUrl', $post->SourceUrl) }}"
                        placeholder="https://instagram.com/p/..."
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Featured Image</label>
                @if ($post->FeaturedImagePath)
                    <img src="{{ $post->featuredImageUrl() }}" class="w-32 h-32 object-cover rounded-lg mt-2 mb-2">
                @endif
                <input type="file" name="FeaturedImage" accept="image/*"
                    class="mt-1 w-full text-sm text-gray-600">
                <p class="text-xs text-gray-400 mt-1">
                    {{ $post->FeaturedImagePath ? 'Upload a new image to replace the current one.' : 'JPG or PNG, up to 4MB.' }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="IsPublished" value="0">
                <input type="checkbox" id="IsPublished" name="IsPublished" value="1"
                    @checked(old('IsPublished', $post->IsPublished))
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="IsPublished" class="text-sm text-gray-700">
                    Published (visible on the public blog immediately)
                </label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    {{ $post->exists ? 'Save Changes' : 'Create Post' }}
                </button>
                <a href="{{ route('blog-posts.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</x-app1>
