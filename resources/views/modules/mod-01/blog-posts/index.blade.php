<x-app1>

    <div class="flex justify-between items-center mb-4">
        <x-page-header />
        <a href="{{ route('blog-posts.create') }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            + New Blog Post
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-lg text-sm">{{ session('status') }}</div>
    @endif

    <div class="bg-white shadow rounded-xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm table-fixed">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-4 py-3 w-20">Image</th>
                    <th class="px-4 py-3 w-64">Title</th>
                    <th class="px-4 py-3 w-32">Source</th>
                    <th class="px-4 py-3 w-28">Status</th>
                    <th class="px-4 py-3 w-32">Published</th>
                    <th class="px-4 py-3 w-32 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($posts as $post)
                    <tr>
                        <td class="px-4 py-3 align-top">
                            <img src="{{ $post->featuredImageUrl() }}" class="w-14 h-14 object-cover rounded-lg">
                        </td>
                        <td class="px-4 py-3 min-w-0 align-top">
                            <div class="font-medium text-gray-800 break-words">
                                {{ $post->Title }}
                            </div>
                            <a href="{{ route('blogs.show', $post) }}" target="_blank"
                                class="text-xs text-indigo-600 hover:underline">View live →</a>
                        </td>
                        <td class="px-4 py-3 text-gray-500 align-top break-words">{{ $post->SourcePlatform ?? '—' }}</td>
                        <td class="px-4 py-3 align-top">
                            @if ($post->IsPublished)
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium whitespace-nowrap">Published</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium whitespace-nowrap">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap align-top">
                            {{ $post->PublishedAt?->format('M j, Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap align-top">
                            <a href="{{ route('blog-posts.edit', $post) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('blog-posts.destroy', $post) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this post permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            No blog posts yet. Click "New Blog Post" to add your first one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

</x-app1>