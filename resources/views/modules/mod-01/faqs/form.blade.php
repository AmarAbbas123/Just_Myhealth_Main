<x-app1>

    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 sm:pt-7 pb-10 space-y-6">

        <!-- Top Navigation & Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0">
                <x-page-header />
            </div>

            <!-- Back to FAQs Button -->
            <div class="shrink-0 self-start sm:self-center">
                <a href="{{ route('faqs.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-xs transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to FAQs</span>
                </a>
            </div>
        </div>

        <!-- Hero Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            <div class="flex items-start gap-4 p-5 sm:p-6">
                <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center text-white shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.5-3.122 2.5-1.098 0-2.068-.46-2.678-1.165m9.544-3.998l1.914 1.914a41.74 41.74 0 010 6.152l-1.314 1.314a23.935 23.935 0 01-6.447 0L9.614 9.614l-1.314 1.314a23.935 23.935 0 010-6.447L14.534 3.69a41.74 41.74 0 016.152 0l1.314-1.314z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#1C9BA0]">Knowledge Base</span>
                        @if ($faq->exists)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                ID: #{{ $faq->id }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mt-0.5">
                        {{ $faq->exists ? 'Edit FAQ' : 'New FAQ' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $faq->exists ? 'Update the question, answer and publication properties.' : 'Create a new question and answer entry for the FAQ directory.' }}
                    </p>
                </div>
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-[#1C9BA0] via-[#127F94] to-teal-400"></div>
        </div>

        <!-- Validation Errors Alert -->
        @if ($errors->any())
            <div class="flex gap-3 rounded-2xl border border-red-200 dark:border-red-900/60 bg-red-50 dark:bg-red-950/30 p-4 text-sm text-red-700 dark:text-red-400 shadow-xs">
                <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

            <!-- Section 1: Question & Answer -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-6 space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100 dark:border-gray-700/80">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#1C9BA0]/10 text-xs font-bold text-[#1C9BA0]">1</span>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100">Question & Answer Content</h2>
                </div>

                <!-- Question -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Question <span class="text-red-500">*</span>
                    </label>
                    <textarea name="Question" rows="2" required
                              placeholder="Enter the question..."
                              class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">{{ old('Question', $faq->Question) }}</textarea>
                </div>

                <!-- Answer -->
                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Answer <span class="text-red-500">*</span>
                        </label>
                        <span class="text-[11px] text-gray-400">HTML markup allowed</span>
                    </div>
                    <textarea name="Answer" rows="5" required
                              placeholder="Provide the detailed answer..."
                              class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 font-mono transition">{{ old('Answer', $faq->Answer) }}</textarea>
                </div>
            </div>

            <!-- Section 2: Categorization & Settings -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-6 space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100 dark:border-gray-700/80">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#1C9BA0]/10 text-xs font-bold text-[#1C9BA0]">2</span>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100">Categorization & Placement</h2>
                </div>

                <!-- Section Picker -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Section <span class="font-normal text-gray-400 normal-case">(optional)</span>
                    </label>

                    @php
                        $sections = [
                            'General', 'Security', 'Privacy', 'GDPR',
                            'Account', 'Billing', 'Technical',
                        ];
                        $currentSection = old('Section', $faq->Section);
                        $isCustom = $currentSection && !in_array($currentSection, $sections);
                    @endphp

                    <!-- Hidden input submitted with the form -->
                    <input type="hidden" name="Section" id="SectionValue" value="{{ $currentSection }}">

                    <div class="relative mt-2">
                        <select id="SectionPicker"
                                onchange="syncSection(this.value)"
                                class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 pl-3.5 pr-8 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition cursor-pointer">
                            <option value="">— None —</option>
                            @foreach ($sections as $s)
                                <option value="{{ $s }}" @selected(!$isCustom && $currentSection === $s)>{{ $s }}</option>
                            @endforeach
                            <option value="__custom" @selected($isCustom)>Other / Custom…</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div id="SectionCustomWrap" class="{{ $isCustom ? '' : 'hidden' }} mt-3">
                        <input type="text" id="SectionCustom"
                               value="{{ $isCustom ? $currentSection : '' }}"
                               placeholder="Enter custom section name…"
                               maxlength="100"
                               oninput="document.getElementById('SectionValue').value = this.value"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 px-3.5 py-2.5 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                    </div>

                    @error('Section')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <!-- Sort Order -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Sort Order <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="SortOrder" value="{{ old('SortOrder', $faq->SortOrder ?? 0) }}" min="0" required
                               class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 px-3.5 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition font-mono">
                    </div>

                    <!-- HashTag -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            HashTag <span class="font-normal text-gray-400 normal-case">(optional)</span>
                        </label>
                        <div class="relative mt-2">
                            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 font-semibold select-none">#</span>
                            <input type="text" name="HashTag" id="HashTag"
                                   value="{{ old('HashTag', $faq->HashTag) }}"
                                   placeholder="e.g. how-to-register"
                                   maxlength="100"
                                   pattern="[a-zA-Z0-9_-]+"
                                   class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 pl-8 pr-3.5 py-2.5 text-sm font-mono text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition"
                                   oninput="this.value = this.value.replace(/^#+/, '')">
                        </div>
                        @error('HashTag')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <script>
                    function syncSection(val) {
                        const wrap = document.getElementById('SectionCustomWrap');
                        const hidden = document.getElementById('SectionValue');
                        if (val === '__custom') {
                            wrap.classList.remove('hidden');
                            hidden.value = document.getElementById('SectionCustom').value;
                        } else {
                            wrap.classList.add('hidden');
                            hidden.value = val;
                        }
                    }
                </script>
            </div>

            <!-- Section 3: Publishing Visibility Toggle -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-6">
                <label for="IsActive" class="flex items-center justify-between gap-4 cursor-pointer select-none">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">Active Status</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Toggle visibility on public and patient FAQ directories</p>
                    </div>

                    <div class="relative inline-flex shrink-0 items-center">
                        <input type="hidden" name="IsActive" value="0">
                        <input type="checkbox" id="IsActive" name="IsActive" value="1"
                               @checked(old('IsActive', $faq->IsActive ?? true))
                               class="peer sr-only">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1C9BA0]"></div>
                    </div>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                <button type="submit"
                        class="w-full sm:w-auto px-7 py-3 text-sm font-semibold text-white rounded-xl shadow-xs hover:opacity-95 transition-all text-center"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    {{ $faq->exists ? 'Save Changes' : 'Create FAQ' }}
                </button>

                <a href="{{ route('faqs.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-xs transition-all">
                    Cancel
                </a>
            </div>
        </form>

    </div>

</x-app1>