<x-app1>

    <div class="space-y-6">

        <!-- Page Header -->
        <x-page-header />

        <!-- Main Form Card -->
        <div class="max-w-3xl relative bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 md:p-9 overflow-hidden">

            <!-- Top Brand Accent Strip -->
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #1C9BA0, #127F94);"></div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl sm:rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 text-xs sm:text-sm">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('usr-raise-issue') }}" class="space-y-2 sm:space-y-2">
                @csrf

                <!-- Concern Categories (2-column on desktop, stacked on mobile) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                    <!-- Primary Concern Area -->
                    <div class="space-y-2">
                        <label for="primary_group_ref" class="block text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-200">
                            Choose general Concern Area <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="primary_group_ref"
                            name="primary_group_ref"
                            required
                            class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-3 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs cursor-pointer">
                            <option value="" class="dark:bg-gray-800">Select a concern area</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->ID }}" @selected(old('primary_group_ref') == $category->ID) class="dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                    {{ $category->DisplayName }}
                                </option>
                            @endforeach
                        </select>
                        @error('primary_group_ref')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Secondary Sub-Category -->
                    <div class="space-y-2">
                        <label for="secondary_group_ref" class="block text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-200">
                            Choose Specific Sub-Catagory <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="secondary_group_ref"
                            name="secondary_group_ref"
                            required
                            class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-3 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs cursor-pointer disabled:opacity-50 disabled:bg-gray-100 dark:disabled:bg-gray-900/40 disabled:cursor-not-allowed">
                            <option value="" class="dark:bg-gray-800">Select a sub-category</option>
                        </select>
                        @error('secondary_group_ref')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Issue Details Textarea -->
                <div class="space-y-2" x-data="{ count: {{ strlen(old('issue_details', '')) }} }">
                    <div class="flex items-center justify-between">
                        <label for="issue_details" class="block text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-200">
                            Provide details of the issue or Concern <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-mono" x-text="count + ' / 2048'"></span>
                    </div>
                    <textarea
                        id="issue_details"
                        name="issue_details"
                        rows="7"
                        maxlength="2048"
                        required
                        @input="count = $el.value.length"
                        class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 p-4 text-xs sm:text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 shadow-2xs leading-relaxed transition-all"
                        placeholder="Please add the details that will help the team investigate or resolve this.">{{ old('issue_details') }}</textarea>
                    @error('issue_details')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row items-stretch sm:items-center justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-full text-white font-semibold text-xs sm:text-sm tracking-wide shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.99] cursor-pointer hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <span>Submit issue</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Subcategories Population Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const subCategories = @json($subCategories);
            const primarySelect = document.getElementById('primary_group_ref');
            const secondarySelect = document.getElementById('secondary_group_ref');
            const selectedSecondary = @json(old('secondary_group_ref'));

            function renderSubCategories() {
                const parentId = primarySelect.value;
                const options = subCategories[parentId] || [];

                secondarySelect.innerHTML = '<option value="" class="dark:bg-gray-800">Select a sub-category</option>';

                options.forEach((option) => {
                    const element = document.createElement('option');
                    element.value = option.ID;
                    element.textContent = option.DisplayName;
                    element.className = 'dark:bg-gray-800 text-gray-800 dark:text-gray-100';

                    if (String(option.ID) === String(selectedSecondary)) {
                        element.selected = true;
                    }

                    secondarySelect.appendChild(element);
                });

                secondarySelect.disabled = options.length === 0;
            }

            primarySelect.addEventListener('change', renderSubCategories);
            renderSubCategories();
        });
    </script>

</x-app1>
