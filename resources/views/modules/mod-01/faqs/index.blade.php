<x-app1>

    @php
        $totalCount = $faqs->total();
        $activeCount = \App\Models\FAQ::where('IsActive', 1)->count();
        $inactiveCount = max(0, $totalCount - $activeCount);
        $sectionsList = \App\Models\FAQ::whereNotNull('Section')->where('Section', '!=', '')->distinct()->pluck('Section')->sort()->values();
        $sectionsCount = $sectionsList->count();
    @endphp

    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6"
         x-data="{
             search: '',
             selectedSection: '',
             match(question, answer, section, tag) {
                 const q = this.search.toLowerCase().trim();
                 const matchesQuery = !q ||
                     (question && question.toLowerCase().includes(q)) ||
                     (answer && answer.toLowerCase().includes(q)) ||
                     (tag && tag.toLowerCase().includes(q));
                 const matchesSection = !this.selectedSection || section === this.selectedSection;
                 return matchesQuery && matchesSection;
             }
         }">

        <!-- Page Header & Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <x-page-header />

            <div class="flex items-center gap-3 shrink-0 self-start sm:self-auto">
                <a href="{{ route('faqs.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white shadow-xs hover:opacity-95 transition-all"
                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>New FAQ</span>
                </a>
            </div>
        </div>

        <!-- Session Status Flash Alert -->
        @if (session('status'))
            <div class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-sm shadow-xs"
                 x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- ===================== -->
        <!-- QUICK SUMMARY CARDS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Stat 1: Total FAQs -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.5-3.122 2.5-1.098 0-2.068-.46-2.678-1.165m9.544-3.998l1.914 1.914a41.74 41.74 0 010 6.152l-1.314 1.314a23.935 23.935 0 01-6.447 0L9.614 9.614l-1.314 1.314a23.935 23.935 0 010-6.447L14.534 3.69a41.74 41.74 0 016.152 0l1.314-1.314z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total FAQs</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($totalCount) }}</p>
                </div>
            </div>

            <!-- Stat 2: Active Questions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active Questions</p>
                    <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($activeCount) }}</p>
                </div>
            </div>

            <!-- Stat 3: Inactive / Draft -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-300 bg-amber-50 dark:bg-amber-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Inactive / Draft</p>
                    <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ number_format($inactiveCount) }}</p>
                </div>
            </div>

            <!-- Stat 4: Knowledge Sections -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Sections</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ number_format($sectionsCount) }}</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- FAQS DIRECTORY CARD -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar with Search & Section Filters -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.5-3.122 2.5-1.098 0-2.068-.46-2.678-1.165m9.544-3.998l1.914 1.914a41.74 41.74 0 010 6.152l-1.314 1.314a23.935 23.935 0 01-6.447 0L9.614 9.614l-1.314 1.314a23.935 23.935 0 010-6.447L14.534 3.69a41.74 41.74 0 016.152 0l1.314-1.314z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">FAQ Directory</h2>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-64">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text"
                               x-model="search"
                               placeholder="Search questions or answers..."
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-700 focus:border-[#1C9BA0] focus:ring-1 focus:ring-[#1C9BA0] text-gray-800 dark:text-gray-100 placeholder-gray-400 transition">
                    </div>

                    <!-- Section Picker Filter -->
                    @if($sectionsList->isNotEmpty())
                        <div class="relative shrink-0 w-full sm:w-auto">
                            <select x-model="selectedSection"
                                    class="w-full sm:w-auto appearance-none pl-3.5 pr-8 py-2 text-xs font-medium rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-700 focus:border-[#1C9BA0] focus:ring-1 focus:ring-[#1C9BA0] text-gray-800 dark:text-gray-100 transition cursor-pointer">
                                <option value="">All Sections</option>
                                @foreach($sectionsList as $sec)
                                    <option value="{{ $sec }}">{{ $sec }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Desktop Table (md+) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[850px] text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/40 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700/80">
                        <tr>
                            <th class="px-5 py-3.5 w-20 whitespace-nowrap">Order</th>
                            <th class="px-5 py-3.5 max-w-xs">Question</th>
                            <th class="px-5 py-3.5 max-w-sm">Answer</th>
                            <th class="px-5 py-3.5 w-32 whitespace-nowrap">Section</th>
                            <th class="px-5 py-3.5 w-32 whitespace-nowrap">HashTag</th>
                            <th class="px-5 py-3.5 w-24 text-center whitespace-nowrap">Status</th>
                            <th class="px-5 py-3.5 w-28 text-right whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-gray-700 dark:text-gray-300">
                        @forelse ($faqs as $faq)
                            <tr x-show="match({{ json_encode($faq->Question) }}, {{ json_encode($faq->Answer) }}, {{ json_encode($faq->Section) }}, {{ json_encode($faq->HashTag) }})"
                                class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors">
                                
                                <!-- Sort Order -->
                                <td class="px-5 py-4 align-top whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                        #{{ $faq->SortOrder }}
                                    </span>
                                </td>

                                <!-- Question -->
                                <td class="px-5 py-4 align-top max-w-xs">
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100 leading-snug">
                                        {{ Str::limit(strip_tags($faq->Question), 75) }}
                                    </div>
                                </td>

                                <!-- Answer -->
                                <td class="px-5 py-4 align-top max-w-sm">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">
                                        {{ Str::limit(strip_tags($faq->Answer), 110) }}
                                    </div>
                                </td>

                                <!-- Section -->
                                <td class="px-5 py-4 align-top whitespace-nowrap">
                                    @if($faq->Section)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $faq->Section }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>

                                <!-- HashTag -->
                                <td class="px-5 py-4 align-top whitespace-nowrap">
                                    @if($faq->HashTag)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20">
                                            #{{ $faq->HashTag }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>

                                <!-- Active Status -->
                                <td class="px-5 py-4 align-top text-center whitespace-nowrap">
                                    @if($faq->IsActive)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Active</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            <span>Inactive</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 align-top text-right whitespace-nowrap space-x-2">
                                    <a href="{{ route('faqs.edit', $faq) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-[#1C9BA0] bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this FAQ permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.5-3.122 2.5-1.098 0-2.068-.46-2.678-1.165m9.544-3.998l1.914 1.914a41.74 41.74 0 010 6.152l-1.314 1.314a23.935 23.935 0 01-6.447 0L9.614 9.614l-1.314 1.314a23.935 23.935 0 010-6.447L14.534 3.69a41.74 41.74 0 016.152 0l1.314-1.314z" />
                                        </svg>
                                        <p class="font-medium text-gray-500 dark:text-gray-400">No FAQs available yet.</p>
                                        <a href="{{ route('faqs.create') }}" class="text-xs font-semibold text-[#1C9BA0] hover:underline">
                                            + Create your first FAQ
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (< md) -->
            <div class="md:hidden p-4 space-y-3">
                @forelse ($faqs as $faq)
                    <div x-show="match({{ json_encode($faq->Question) }}, {{ json_encode($faq->Answer) }}, {{ json_encode($faq->Section) }}, {{ json_encode($faq->HashTag) }})"
                         class="bg-gray-50/60 dark:bg-gray-900/40 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-4 space-y-3">
                        
                        <!-- Header with Order & Status -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                #{{ $faq->SortOrder }}
                            </span>

                            @if($faq->IsActive)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inactive
                                </span>
                            @endif
                        </div>

                        <!-- Question -->
                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100 leading-snug">
                            {{ Str::limit(strip_tags($faq->Question), 90) }}
                        </div>

                        <!-- Answer preview -->
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-3">
                            {{ Str::limit(strip_tags($faq->Answer), 130) }}
                        </p>

                        <!-- Badges row -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @if($faq->Section)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    {{ $faq->Section }}
                                </span>
                            @endif
                            @if($faq->HashTag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-mono font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20">
                                    #{{ $faq->HashTag }}
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700/60">
                            <a href="{{ route('faqs.edit', $faq) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#1C9BA0] bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this FAQ permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-400 text-sm">
                        No FAQs found.
                    </div>
                @endforelse
            </div>

            <!-- Pagination Bar -->
            @if ($faqs->hasPages())
                <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $faqs->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app1>