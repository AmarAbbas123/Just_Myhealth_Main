<x-app1>

    <div class="flex justify-between items-center mb-4">
        <x-page-header />
        <a href="{{ route('faqs.create') }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            + New FAQ
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-lg text-sm">{{ session('status') }}</div>
    @endif

    <div class="bg-white shadow rounded-xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm table-fixed">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-4 py-3 w-20">Order</th>
                    <th class="px-4 py-3 w-25">Question</th>
                    <th class="px-4 py-3 w-30">Answer</th>
                   
                    <th class="px-4 py-3 w-15 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($faqs as $faq)
                    <tr>
                        <td class="px-4 py-3 align-top">{{ $faq->SortOrder }}</td>
                        <td class=" font-medium px-4 py-3 min-w-0 align-top">
                            <div class=" text-gray-800 break-words max-w-xs">
                             
                                 {{ Str::limit(strip_tags($faq->Question ), 40) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 align-top break-words max-w-md">
                            {{ Str::limit(strip_tags($faq->Answer), 40) }}
                        </td>
                        
                        <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap align-top">
                            <a href="{{ route('faqs.edit', $faq) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this FAQ permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No FAQs yet. Click "New FAQ" to add your first one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $faqs->links() }}
    </div>

</x-app1>