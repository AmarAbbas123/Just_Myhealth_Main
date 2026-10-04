<x-app1>
    <div class="space-y-6" x-data="qualificationModal()">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 flex items-center justify-between gap-3 text-emerald-800 dark:text-emerald-200 shadow-2xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/60 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex items-center gap-3 text-rose-800 dark:text-rose-200 shadow-2xs">
                <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @php
            $qualCount = 0;
            if ($qualf) {
                for ($i = 1; $i <= 4; $i++) {
                    if (
                        $qualf->{'QualificationTitle' . $i} ||
                        $qualf->{'QualificationLevel' . $i} ||
                        $qualf->{'QualificationFrom' . $i} ||
                        $qualf->{'QualificationGrade' . $i} ||
                        $qualf->{'QualificationDateComplete' . $i} ||
                        $qualf->{'QualificationImagePath' . $i}
                    ) {
                        $qualCount++;
                    }
                }
            }
            $hasQualData = $qualCount > 0;
        @endphp

        <!-- Header -->
        <x-page-header />

        <!-- Actions / Counter Bar (Below Header) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 flex-wrap">
            <!-- Left: Counter Badge & View Toggle -->
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                    <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                    <span>{{ $qualCount }} / 4 Qualifications Added</span>
                </span>

                @if ($hasQualData)
                    <!-- View Mode Toggle (Cards vs Table) -->
                    <div class="inline-flex items-center bg-gray-100 dark:bg-gray-700/60 p-1 rounded-xl border border-gray-200/80 dark:border-gray-600/60 text-xs font-semibold">
                        <button type="button" @click="viewMode = 'cards'"
                                :class="viewMode === 'cards' ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>Cards</span>
                        </button>
                        <button type="button" @click="viewMode = 'table'"
                                :class="viewMode === 'table' ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <span>Table</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Right: Action Buttons -->
            <div class="flex items-center gap-3 self-start sm:self-auto">
                @if ($hasQualData)
                    <button type="button" @click="openDeleteModal()"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/50 border border-rose-200 dark:border-rose-800/60 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete All</span>
                    </button>
                @endif

                @if ($qualCount < 4)
                    <button type="button" @click="openAddModal()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Qualification</span>
                    </button>
                @endif
            </div>
        </div>

        @if ($hasQualData)
            {{-- ===================== 1. CARDS VIEW (DEFAULT) ===================== --}}
            <div x-show="viewMode === 'cards'" class="space-y-3.5">
                @for ($i = 1; $i <= 4; $i++)
                    @if (
                        $qualf->{'QualificationTitle' . $i} ||
                        $qualf->{'QualificationLevel' . $i} ||
                        $qualf->{'QualificationFrom' . $i} ||
                        $qualf->{'QualificationGrade' . $i} ||
                        $qualf->{'QualificationDateComplete' . $i} ||
                        $qualf->{'QualificationImagePath' . $i}
                    )
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                            <!-- Left: Certificate Image/Icon & Details -->
                            <div class="flex items-start sm:items-center gap-4 min-w-0">
                                <!-- Certificate Image or Squircle Icon -->
                                <div class="relative shrink-0">
                                    @if ($qualf->{'QualificationImagePath' . $i})
                                        <div class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 group-hover:border-[#1C9BA0]/50 transition-all cursor-pointer shadow-xs"
                                             @click="openImagePreview('{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}', '{{ addslashes($qualf->{'QualificationTitle' . $i} ?? 'Qualification Certificate') }}')">
                                            <img src="{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}"
                                                 alt="{{ $qualf->{'QualificationTitle' . $i} }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="min-w-0 space-y-1.5">
                                    <!-- Title & Badges -->
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 truncate">
                                            {{ $qualf->{'QualificationTitle' . $i} ?: 'Untitled Qualification #' . $i }}
                                        </h3>

                                        @if ($qualf->{'QualificationLevel' . $i})
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                                                {{ $qualf->{'QualificationLevel' . $i} }}
                                            </span>
                                        @endif

                                        @if ($qualf->{'QualificationGrade' . $i})
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                                                <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                {{ $qualf->{'QualificationGrade' . $i} }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Institution & Completion Date -->
                                    <div class="flex items-center gap-y-1.5 gap-x-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400 flex-wrap">
                                        @if ($qualf->{'QualificationFrom' . $i})
                                            <span class="inline-flex items-center gap-1.5 font-medium text-gray-700 dark:text-gray-300">
                                                <svg class="w-4 h-4 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                {{ $qualf->{'QualificationFrom' . $i} }}
                                            </span>
                                        @endif

                                        @if ($qualf->{'QualificationDateComplete' . $i})
                                            <span class="inline-flex items-center gap-1.5 text-gray-500 dark:text-gray-400">
                                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Completed: {{ \Carbon\Carbon::parse($qualf->{'QualificationDateComplete' . $i})->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Actions -->
                            <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                                @if ($qualf->{'QualificationImagePath' . $i})
                                    <button type="button"
                                        @click="openImagePreview('{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}', '{{ addslashes($qualf->{'QualificationTitle' . $i} ?? 'Qualification Certificate') }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                                        <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>View Document</span>
                                    </button>
                                @endif

                                <button type="button" @click="openEditModal({{ $i }})"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:hover:bg-[#1C9BA0]/30 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Edit</span>
                                </button>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>

            {{-- ===================== 2. TABLE VIEW ===================== --}}
            <div x-show="viewMode === 'table'" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                <!-- Mobile Horizontal Scroll Helper -->
                <div class="sm:hidden px-4 py-2 bg-gray-50 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                    <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                        <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        <span>Swipe horizontally to view all columns</span>
                    </span>
                    <span class="font-semibold text-[#1C9BA0]">{{ $qualCount }} / 4</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">
                                <th class="py-3.5 px-5 whitespace-nowrap">Title</th>
                                <th class="py-3.5 px-4 whitespace-nowrap">Level</th>
                                <th class="py-3.5 px-4 whitespace-nowrap">Institution</th>
                                <th class="py-3.5 px-4 whitespace-nowrap">Grade</th>
                                <th class="py-3.5 px-4 whitespace-nowrap">Date Completed</th>
                                <th class="py-3.5 px-4 text-center whitespace-nowrap">Certificate</th>
                                <th class="py-3.5 px-5 text-right whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                            @for ($i = 1; $i <= 4; $i++)
                                @if (
                                    $qualf->{'QualificationTitle' . $i} ||
                                    $qualf->{'QualificationLevel' . $i} ||
                                    $qualf->{'QualificationFrom' . $i} ||
                                    $qualf->{'QualificationGrade' . $i} ||
                                    $qualf->{'QualificationDateComplete' . $i} ||
                                    $qualf->{'QualificationImagePath' . $i}
                                )
                                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors">
                                        <!-- Title -->
                                        <td class="py-4 px-5 font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $qualf->{'QualificationTitle' . $i} ?: 'Untitled' }}
                                        </td>

                                        <!-- Level -->
                                        <td class="py-4 px-4 text-gray-600 dark:text-gray-300">
                                            @if ($qualf->{'QualificationLevel' . $i})
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20">
                                                    {{ $qualf->{'QualificationLevel' . $i} }}
                                                </span>
                                            @else
                                                <span class="text-gray-300 dark:text-gray-600">—</span>
                                            @endif
                                        </td>

                                        <!-- From -->
                                        <td class="py-4 px-4 text-gray-600 dark:text-gray-300 font-medium">
                                            {{ $qualf->{'QualificationFrom' . $i} ?: '—' }}
                                        </td>

                                        <!-- Grade -->
                                        <td class="py-4 px-4">
                                            @if ($qualf->{'QualificationGrade' . $i})
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                                                    {{ $qualf->{'QualificationGrade' . $i} }}
                                                </span>
                                            @else
                                                <span class="text-gray-300 dark:text-gray-600">—</span>
                                            @endif
                                        </td>

                                        <!-- Date Complete -->
                                        <td class="py-4 px-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                            {{ $qualf->{'QualificationDateComplete' . $i} ? \Carbon\Carbon::parse($qualf->{'QualificationDateComplete' . $i})->format('M d, Y') : '—' }}
                                        </td>

                                        <!-- Image / Certificate -->
                                        <td class="py-4 px-4 text-center">
                                            @if ($qualf->{'QualificationImagePath' . $i})
                                                <button type="button"
                                                    @click="openImagePreview('{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}', '{{ addslashes($qualf->{'QualificationTitle' . $i} ?? 'Certificate') }}')"
                                                    class="inline-block relative group">
                                                    <img src="{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}"
                                                         class="w-10 h-10 object-cover rounded-lg border border-gray-200 dark:border-gray-700 group-hover:scale-105 transition-all shadow-2xs cursor-pointer">
                                                </button>
                                            @else
                                                <span class="text-gray-300 dark:text-gray-600">—</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="py-4 px-5 text-right whitespace-nowrap">
                                            <button type="button" @click="openEditModal({{ $i }})"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#1C9BA0] bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 transition-all active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>Edit</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- ===================== EMPTY STATE ===================== --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 sm:p-12 text-center border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center text-white mx-auto shadow-md mb-4"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5" />
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">No Qualifications Added Yet</h3>
                <p class="text-xs sm:text-sm text-gray-400 mt-2 max-w-md mx-auto leading-relaxed">
                    Document your academic credentials, higher education degrees, and clinical certifications. You can add up to 4 verified qualifications.
                </p>
                <div class="mt-6">
                    <button type="button" @click="openAddModal()"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add First Qualification</span>
                    </button>
                </div>
            </div>
        @endif

        {{-- ===================== ADD / EDIT MODAL ===================== --}}
        <div x-show="showModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div @click.away="closeModal()"
                class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-2xl shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-y-auto max-h-[90vh]"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100"
                                x-text="modalMode === 'add' ? 'Add New Qualification' : 'Edit Qualification #' + editIndex"></h2>
                            <p class="text-xs text-gray-400">Enter degree details, institution, and certificate document.</p>
                        </div>
                    </div>
                    <button type="button" @click="closeModal()"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="modalMode === 'add' ? '{{ route('my-bio-qualifications.store') }}' : '{{ route('my-bio-qualifications.update') }}'"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-4">
                        <!-- Qualification Title -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Qualification Title <span class="text-rose-500">*</span>
                            </label>
                            <input :id="'QualificationTitle' + currentIndex"
                                   :name="'QualificationTitle' + currentIndex"
                                   type="text"
                                   maxlength="32"
                                   required
                                   class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                   placeholder="e.g. Master of Clinical Psychology"
                                   x-model="form.QualificationTitle">
                        </div>

                        <!-- Grid: Level & Grade -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Level -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Qualification Level
                                </label>
                                <input :id="'QualificationLevel' + currentIndex"
                                       :name="'QualificationLevel' + currentIndex"
                                       type="text"
                                       maxlength="32"
                                       class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                       placeholder="e.g. Postgraduate / Level 7"
                                       x-model="form.QualificationLevel">
                            </div>

                            <!-- Grade -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Grade / Honors
                                </label>
                                <input :id="'QualificationGrade' + currentIndex"
                                       :name="'QualificationGrade' + currentIndex"
                                       type="text"
                                       maxlength="16"
                                       class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                       placeholder="e.g. Distinction / First Class"
                                       x-model="form.QualificationGrade">
                            </div>
                        </div>

                        <!-- Grid: Institution & Completion Date -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Institution / College / University -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    College / University
                                </label>
                                <input :id="'QualificationFrom' + currentIndex"
                                       :name="'QualificationFrom' + currentIndex"
                                       type="text"
                                       maxlength="32"
                                       class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                       placeholder="e.g. King's College London"
                                       x-model="form.QualificationFrom">
                            </div>

                            <!-- Date Complete -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Completion Date
                                </label>
                                <input :id="'QualificationDateComplete' + currentIndex"
                                       :name="'QualificationDateComplete' + currentIndex"
                                       type="date"
                                       class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                       x-model="form.QualificationDateComplete">
                            </div>
                        </div>

                        <!-- Certificate Image Upload & Live Preview -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Certificate Document (Image)
                            </label>

                            <div class="p-4 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 hover:border-[#1C9BA0]/60 bg-gray-50/50 dark:bg-gray-900/40 transition-all">
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <!-- Preview Box -->
                                    <template x-if="previewImage">
                                        <div class="relative w-20 h-20 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shrink-0 bg-white dark:bg-gray-800 shadow-2xs">
                                            <img :src="previewImage" alt="Preview" class="w-full h-full object-cover">
                                        </div>
                                    </template>
                                    <template x-if="!previewImage">
                                        <div class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </template>

                                    <!-- Upload input -->
                                    <div class="flex-1 min-w-0 text-center sm:text-left">
                                        <input type="file"
                                               :name="'QualificationImagePath' + currentIndex"
                                               accept="image/png,image/jpeg,image/jpg"
                                               @change="handleFileSelect($event)"
                                               class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1C9BA0]/10 file:text-[#1C9BA0] hover:file:bg-[#1C9BA0]/20 cursor-pointer">
                                        <p class="text-[11px] text-gray-400 mt-1">PNG, JPG, or JPEG up to 5MB.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/80">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <span x-text="modalMode === 'add' ? 'Save Qualification' : 'Update Qualification'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== DELETE MODAL ===================== --}}
        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div @click.away="closeDeleteModal()"
                class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700 text-center"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-4 border border-rose-100 dark:border-rose-900/40">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Delete All Qualifications?</h3>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                    Are you sure you want to remove all qualifications and attached certificate files? This action cannot be undone.
                </p>

                <form method="POST" action="{{ route('my-bio-qualifications.delete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" @click="closeDeleteModal()"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-md hover:shadow-lg active:scale-95">
                            Yes, Delete All
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== CERTIFICATE IMAGE LIGHTBOX MODAL ===================== --}}
        <div x-show="showImageModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div @click.away="closeImagePreview()"
                class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 w-full max-w-3xl shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-hidden"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 truncate" x-text="previewImageModalTitle"></h3>
                    <div class="flex items-center gap-2">
                        <a :href="previewImageModalSrc" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] hover:bg-[#1C9BA0]/20 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Open Original</span>
                        </a>
                        <button type="button" @click="closeImagePreview()"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Image Display -->
                <div class="max-h-[75vh] overflow-auto flex items-center justify-center rounded-2xl bg-gray-50 dark:bg-gray-900/60 p-2">
                    <img :src="previewImageModalSrc" :alt="previewImageModalTitle" class="max-h-[70vh] w-auto max-w-full rounded-xl object-contain shadow-xs">
                </div>
            </div>
        </div>

    </div>

    {{-- AlpineJS State --}}
    <script>
        function qualificationModal() {
            return {
                showModal: false,
                showDeleteModal: false,
                showImageModal: false,
                previewImageModalSrc: '',
                previewImageModalTitle: '',
                modalMode: 'add',
                viewMode: 'cards',
                editIndex: null,
                currentIndex: 1,
                previewImage: null,

                // All qualifications data from backend (PHP → JS)
                qualifications: @json($qualf),

                // Form data for currently open modal
                form: {
                    QualificationTitle: '',
                    QualificationLevel: '',
                    QualificationFrom: '',
                    QualificationGrade: '',
                    QualificationDateComplete: '',
                },

                openAddModal() {
                    this.modalMode = 'add';
                    this.currentIndex = this.getNextAvailableIndex();
                    if (this.currentIndex === null) {
                        alert("All 4 qualification slots are already filled.");
                        return;
                    }

                    // clear form
                    this.form = {
                        QualificationTitle: '',
                        QualificationLevel: '',
                        QualificationFrom: '',
                        QualificationGrade: '',
                        QualificationDateComplete: '',
                    };
                    this.previewImage = null;
                    this.showModal = true;
                },

                openEditModal(index) {
                    this.modalMode = 'edit';
                    this.currentIndex = index;
                    this.editIndex = index;

                    // Prefill data from existing qualifications
                    this.form = {
                        QualificationTitle: this.qualifications ? (this.qualifications['QualificationTitle' + index] || '') : '',
                        QualificationLevel: this.qualifications ? (this.qualifications['QualificationLevel' + index] || '') : '',
                        QualificationFrom: this.qualifications ? (this.qualifications['QualificationFrom' + index] || '') : '',
                        QualificationGrade: this.qualifications ? (this.qualifications['QualificationGrade' + index] || '') : '',
                        QualificationDateComplete: this.qualifications ? (this.qualifications['QualificationDateComplete' + index] || '') : '',
                    };

                    const existingImg = this.qualifications ? this.qualifications['QualificationImagePath' + index] : null;
                    this.previewImage = existingImg ? '{{ asset('storage') }}/' + existingImg : null;

                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                    this.editIndex = null;
                    this.previewImage = null;
                },

                openDeleteModal() {
                    this.showDeleteModal = true;
                },

                closeDeleteModal() {
                    this.showDeleteModal = false;
                },

                openImagePreview(src, title) {
                    this.previewImageModalSrc = src;
                    this.previewImageModalTitle = title || 'Qualification Certificate';
                    this.showImageModal = true;
                },

                closeImagePreview() {
                    this.showImageModal = false;
                    this.previewImageModalSrc = '';
                    this.previewImageModalTitle = '';
                },

                handleFileSelect(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.previewImage = URL.createObjectURL(file);
                    }
                },

                getNextAvailableIndex() {
                    const q = this.qualifications;
                    for (let i = 1; i <= 4; i++) {
                        const title = q ? q['QualificationTitle' + i] : null;
                        const level = q ? q['QualificationLevel' + i] : null;
                        const from = q ? q['QualificationFrom' + i] : null;
                        const grade = q ? q['QualificationGrade' + i] : null;
                        const date = q ? q['QualificationDateComplete' + i] : null;
                        const image = q ? q['QualificationImagePath' + i] : null;

                        if (!title && !level && !from && !grade && !date && !image) {
                            return i;
                        }
                    }
                    return null;
                }
            }
        }
    </script>
</x-app1>
