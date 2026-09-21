<x-app1>

    <div class="flex justify-between items-center mb-4">
        <x-page-header />
        <a href="{{ route('faqs.create') }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition text-sm font-semibold">
            + New FAQ
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-lg text-sm">{{ session('status') }}</div>
    @endif

    {{-- ─── Desktop table (md+) ─── --}}
    <div class="hidden md:block bg-white shadow rounded-xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 w-16">Order</th>
                    <th class="px-4 py-3">Question</th>
                    <th class="px-4 py-3">Answer</th>
                    <th class="px-4 py-3 w-28">Section</th>
                    <th class="px-4 py-3 w-28">HashTag</th>
                    <th class="px-4 py-3 w-20 text-center">Active</th>
                    <th class="px-4 py-3 w-24 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($faqs as $faq)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 text-gray-500 align-top">{{ $faq->SortOrder }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 align-top max-w-xs">
                            {{ Str::limit(strip_tags($faq->Question), 50) }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 align-top max-w-sm">
                            {{ Str::limit(strip_tags($faq->Answer), 60) }}
                        </td>
                        <td class="px-4 py-3 align-top">
                            @if($faq->Section)
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-200">
                                    {{ $faq->Section }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 align-top">
                            @if($faq->HashTag)
                                <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-mono font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-100">
                                    #{{ $faq->HashTag }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 align-top text-center">
                            @if($faq->IsActive)
                                <span class="inline-block h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-emerald-100"></span>
                            @else
                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300"></span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap align-top">
                            <a href="{{ route('faqs.edit', $faq) }}" class="text-indigo-600 hover:underline text-xs font-medium">Edit</a>
                            <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this FAQ permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-400 text-sm">
                            No FAQs yet. Click <strong>+ New FAQ</strong> to add your first one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ─── Mobile cards (< md) ─── --}}
    <div class="md:hidden space-y-3">
        @forelse ($faqs as $faq)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 space-y-3">
                {{-- Question --}}
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm font-semibold text-gray-800 leading-snug">
                        {{ Str::limit(strip_tags($faq->Question), 80) }}
                    </p>
                    <span class="shrink-0 text-xs text-gray-400 mt-0.5">#{{ $faq->SortOrder }}</span>
                </div>

                {{-- Answer preview --}}
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ Str::limit(strip_tags($faq->Answer), 100) }}
                </p>

                {{-- Badges row --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if($faq->Section)
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-200">
                            {{ $faq->Section }}
                        </span>
                    @endif
                    @if($faq->HashTag)
                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-mono font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-100">
                            #{{ $faq->HashTag }}
                        </span>
                    @endif
                    @if($faq->IsActive)
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-100">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500 ring-1 ring-inset ring-gray-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Inactive
                        </span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-1 border-t border-gray-100">
                    <a href="{{ route('faqs.edit', $faq) }}"
                        class="text-indigo-600 hover:underline text-xs font-semibold">Edit</a>
                    <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="inline"
                        onsubmit="return confirm('Delete this FAQ permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8 text-center text-gray-400 text-sm">
                No FAQs yet. Click <strong>+ New FAQ</strong> to add your first one.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $faqs->links() }}
    </div>

</x-app1>