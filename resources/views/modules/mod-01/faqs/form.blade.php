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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.5-3.122 2.5-1.098 0-2.068-.46-2.678-1.165m9.544-3.998l1.914 1.914a41.74 41.74 0 010 6.152l-1.314 1.314a23.935 23.935 0 01-6.447 0L9.614 9.614l-1.314 1.314a23.935 23.935 0 010-6.447L14.534 3.69a41.74 41.74 0 016.152 0l1.314-1.314z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">FAQ</p>
                    <h1 class="text-lg sm:text-xl font-semibold text-slate-900 mt-0.5">
                        {{ $faq->exists ? 'Edit FAQ' : 'New FAQ' }}
                    </h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        {{ $faq->exists ? 'Update the question and answer below.' : 'Fill in the details below to create a new FAQ.' }}
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
            action="{{ $faq->exists ? route('faqs.update', $faq) : route('faqs.store') }}"
            class="space-y-6">
            @csrf
            @if ($faq->exists)
                @method('PUT')
            @endif

            <!-- Question & Answer section -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6 space-y-6">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">1</span>
                    Question & Answer
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Question</label>
                    <textarea name="Question" rows="1" required
                        placeholder="Enter the question..."
                        class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">{{ old('Question', $faq->Question) }}</textarea>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Answer</label>
                    <p class="text-xs text-slate-400 mt-0.5 mb-2">HTML is allowed for formatting.</p>
                    <textarea name="Answer" rows="3" required
                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition font-mono text-sm">{{ old('Answer', $faq->Answer) }}</textarea>
                </div>
            </div>

            <!-- Settings section -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">2</span>
                    Settings
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sort Order</label>
                        <input type="number" name="SortOrder" value="{{ old('SortOrder', $faq->SortOrder) }}" min="0"
                            class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400 transition">
                    </div>
                </div>
            </div>

            <!-- Publish settings -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6">
                <label for="IsActive" class="flex items-start justify-between gap-4 cursor-pointer sm:items-center">
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-800">Active</span>
                        <span class="block text-xs text-slate-400 mt-0.5">Visible on the public FAQ page</span>
                    </span>

                    <span class="relative inline-flex flex-shrink-0 mt-0.5 sm:mt-0">
                        <input type="hidden" name="IsActive" value="0">
                        <input type="checkbox" id="IsActive" name="IsActive" value="1"
                            @checked(old('IsActive', $faq->IsActive))
                            class="peer sr-only">
                        <span class="h-6 w-11 rounded-full bg-slate-200 transition-colors duration-200 peer-checked:bg-indigo-600"></span>
                        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-5"></span>
                    </span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-indigo-700 transition">
                    {{ $faq->exists ? 'Save Changes' : 'Create FAQ' }}
                </button>
                <a href="{{ route('faqs.index') }}" class="w-full sm:w-auto text-center px-6 py-2.5 bg-white text-slate-600 text-sm font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</x-app1>