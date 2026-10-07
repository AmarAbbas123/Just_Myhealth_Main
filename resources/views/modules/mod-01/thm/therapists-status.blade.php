<x-app1>

    @php
        $totalTherapists = $items->total();
        $activeTherapists = \App\Models\User::where('UserType', 30)->where('AccountStatus', 1)->count();
        $pendingTherapists = \App\Models\User::where('UserType', 30)->where(function($q){
            $q->whereNull('AccountStatus')->orWhere('AccountStatus', 0);
        })->count();
        $setupCompleteCount = \App\Models\User::where('UserType', 30)->where('AccountSetupComplete', 1)->count();
    @endphp

    <div class="max-w-7xl mx-auto space-y-6" x-data="therapistsStatus()">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <x-page-header :menu="$menu ?? null" />
        </div>

        <!-- ===================== -->
        <!-- QUICK SUMMARY CARDS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Stat 1: Total Therapists -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Therapists</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($totalTherapists) }}</p>
                </div>
            </div>

            <!-- Stat 2: Active Accounts -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active Status</p>
                    <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($activeTherapists) }}</p>
                </div>
            </div>

            <!-- Stat 3: Inactive / Pending -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-300 bg-amber-50 dark:bg-amber-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Inactive / Pending</p>
                    <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ number_format($pendingTherapists) }}</p>
                </div>
            </div>

            <!-- Stat 4: Setup Completed -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Setup Completed</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ number_format($setupCompleteCount) }}</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- THERAPISTS TABLE CARD -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Therapist Status Roster</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                    {{ $totalTherapists }} Therapists
                </span>
            </div>

            <!-- Scroll helper note -->
            <div class="px-4 sm:px-5 py-2.5 bg-gray-50/80 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] sm:text-xs text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1.5 font-medium text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Scroll horizontally to review all columns</span>
                </span>
                <div class="flex items-center gap-3 font-mono text-[11px]">
                    <span class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 1
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-400 dark:text-gray-500 font-bold">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span> 0
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px] text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/40 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700/80">
                        <tr>
                            <th class="px-4 py-3.5 whitespace-nowrap text-center">Actions</th>
                            @foreach ([
                                'ID' => 'No.',
                                'UserName' => 'UserName',
                                'FirstName' => 'First Name',
                                'LastName' => 'Last Name',
                                'Email' => 'Email',
                                'DOB' => 'DOB',
                                'Gender' => 'Gender',
                                'BaseCountry' => 'Country',
                                'BaseState' => 'State',
                                'BaseCity' => 'City',
                                'AccountStatus' => 'Status',
                                'UserCreatedDateTime' => 'Created',
                                'AccountSetupComplete' => 'Setup',
                            ] as $col => $label)
                                @php
                                    $sortable = in_array($col, [                                    
                                        'UserName',
                                        'Email',
                                        'AccountStatus',
                                        'UserCreatedDateTime',
                                        'AccountSetupComplete',
                                    ]);
                                @endphp
                                <th class="px-4 py-3.5 whitespace-nowrap">
                                    @if ($sortable)
                                        <a href="{{ request()->fullUrlWithQuery([
                                                'sort_by' => $col,
                                                'sort_dir' => $sortBy == $col && $sortDir == 'asc' ? 'desc' : 'asc',
                                            ]) }}"
                                           class="inline-flex items-center gap-1 group hover:text-[#1C9BA0] transition">
                                            <span>{{ $label }}</span>
                                            <span class="text-[10px]">
                                                @if ($sortBy == $col)
                                                    {{ $sortDir == 'asc' ? '▲' : '▼' }}
                                                @else
                                                    <span class="opacity-0 group-hover:opacity-40">↕</span>
                                                @endif
                                            </span>
                                        </a>
                                    @else
                                        <span>{{ $label }}</span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-gray-700 dark:text-gray-300">
                        @forelse ($items as $item)
                            @php
                                $attr = $item->userAttributes;
                                $type30 = $item->type30;
                                $displayName = trim(($attr->FirstName ?? '') . ' ' . ($attr->LastName ?? ''));
                                $displayName = $displayName !== '' ? $displayName : ($item->UserName ?? '');
                                $createdDate = $item->UserCreatedDateTime ?? $item->CreatedAt ?? $item->created_at;
                                $isActive = ($item->AccountStatus == 1 || strtolower((string)$item->AccountStatus) === 'active');
                                $isSetupComplete = ($item->AccountSetupComplete == 1 || strtolower((string)$item->AccountSetupComplete) === 'yes');
                            @endphp
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors">
                                <!-- Actions -->
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button type="button"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 hover:bg-emerald-100 transition shadow-2xs"
                                                @click='openBioModal(@json($attr), @json($type30))'>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>BIO</span>
                                        </button>
                                        <button type="button"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-[#1C9BA0] bg-[#1C9BA0]/10 dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20 hover:bg-[#1C9BA0]/20 transition shadow-2xs"
                                                @click='openMessageModal({ id: {{ $item->ID }}, name: @json($displayName), userType: 30 })'>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            <span>Message</span>
                                        </button>
                                    </div>
                                </td>

                                <!-- No. (ID) -->
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        #{{ $item->ID }}
                                    </span>
                                </td>

                                <!-- UserName -->
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->UserName }}
                                </td>

                                <!-- First Name -->
                                <td class="px-4 py-3 whitespace-nowrap">{{ $attr->FirstName ?? '—' }}</td>

                                <!-- Last Name -->
                                <td class="px-4 py-3 whitespace-nowrap">{{ $attr->LastName ?? '—' }}</td>

                                <!-- Email -->
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-[#1C9BA0] font-mono text-xs">{{ $item->Email }}</span>
                                </td>

                                <!-- DOB -->
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                    {{ $attr->DOB ?? '—' }}
                                </td>

                                <!-- Gender -->
                                <td class="px-4 py-3 whitespace-nowrap text-xs">{{ $attr->Gender ?? '—' }}</td>

                                <!-- Country -->
                                <td class="px-4 py-3 whitespace-nowrap text-xs">{{ $attr->BaseCountry ?? '—' }}</td>

                                <!-- State -->
                                <td class="px-4 py-3 whitespace-nowrap text-xs">{{ $attr->BaseState ?? '—' }}</td>

                                <!-- City -->
                                <td class="px-4 py-3 whitespace-nowrap text-xs">{{ $attr->BaseCity ?? '—' }}</td>

                                <!-- AccountStatus -->
                                <td class="px-4 py-3 text-center whitespace-nowrap font-mono text-xs font-bold {{ ($item->AccountStatus == 1) ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ $item->AccountStatus ?? 0 }}
                                </td>

                                <!-- Created -->
                                <td class="px-4 py-3 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">
                                    {{ $createdDate ? \Illuminate\Support\Carbon::parse($createdDate)->format('Y-m-d') : '—' }}
                                </td>

                                <!-- AccountSetupComplete -->
                                <td class="px-4 py-3 text-center whitespace-nowrap font-mono text-xs font-bold {{ ($item->AccountSetupComplete == 1) ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ $item->AccountSetupComplete ?? 0 }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-12 text-center text-gray-400 text-sm" colspan="14">
                                    No therapists found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($items->hasPages())
                <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $items->links('pagination::tailwind') }}
                </div>
            @endif

        </div>

        <!-- ===================== -->
        <!-- BIO MODAL -->
        <!-- ===================== -->
        <div x-show="isBioOpen" x-cloak
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4"
             @click.self="closeBioModal">

            <div class="bg-white dark:bg-gray-800 rounded-3xl w-full max-w-2xl border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]"
                 @click.stop>

                <!-- Modal Header -->
                <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                <span x-text="therapist.user.FirstName || ''"></span>
                                <span x-text="therapist.user.LastName || ''"></span>
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Therapist Profile & Credentials</p>
                        </div>
                    </div>

                    <button @click="closeBioModal" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-5 sm:p-6 space-y-5 overflow-y-auto">
                    <!-- General Details -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                            <span class="text-xs font-semibold uppercase text-gray-400">Location:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                <span x-text="therapist.user.BaseCity || ''"></span>,
                                <span x-text="therapist.user.BaseState || ''"></span>,
                                <span x-text="therapist.user.BaseCountry || ''"></span>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs">
                            <div>
                                <span class="text-gray-400 block">Salutation</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="therapist.type30.PreferredSalutation || '—'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Primary Language</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="therapist.type30.LanguagePrimary || '—'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Secondary Language</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="therapist.type30.LanguageSecondary || '—'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Therapy Services -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2.5">Therapy Services</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <template x-for="i in [1,2,3,4,5]">
                                <div x-show="therapist.type30['TherapyType'+i]"
                                     class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 text-xs space-y-1">
                                    <div class="font-bold text-gray-900 dark:text-gray-100" x-text="therapist.type30['TherapyType'+i]"></div>
                                    <div class="text-gray-500 dark:text-gray-400">
                                        Experience: <span class="font-semibold text-gray-700 dark:text-gray-300" x-text="therapist.type30['TherapyYearsExperience'+i]"></span> yrs
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Qualifications -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2.5">Qualifications</h3>
                        <div class="space-y-2">
                            <template x-for="i in [1,2,3,4]">
                                <div x-show="therapist.type30['QualificationTitle'+i]"
                                     class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 text-xs">
                                    <div class="font-bold text-gray-900 dark:text-gray-100" x-text="therapist.type30['QualificationTitle'+i]"></div>
                                    <div class="text-gray-500 dark:text-gray-400 mt-0.5">
                                        <span x-text="therapist.type30['QualificationFrom'+i]"></span>
                                        <span x-show="therapist.type30['QualificationLevel'+i]"> &bull; <span x-text="therapist.type30['QualificationLevel'+i]"></span></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Bio Details -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2.5">Bio Details</h3>
                        <div class="p-4 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 space-y-2 text-xs leading-relaxed text-gray-700 dark:text-gray-300">
                            <template x-for="i in [1,2,3,4,5,6]">
                                <p x-show="therapist.type30['BioTextParagraph'+i]"
                                   x-text="therapist.type30['BioTextParagraph'+i]"></p>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/50 flex justify-end">
                    <button type="button" @click="closeBioModal"
                            class="px-5 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-xs">
                        Close
                    </button>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- MESSAGE MODAL -->
        <!-- ===================== -->
        <div x-show="isMessageOpen" x-cloak
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4"
             @click.self="closeMessageModal">

            <div class="bg-white dark:bg-gray-800 rounded-3xl w-full max-w-lg border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden"
                 @click.stop>
                
                <!-- Modal Header -->
                <div class="p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">Send Direct Message</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                To: <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="messageTarget.name || 'Therapist'"></span>
                            </p>
                        </div>
                    </div>

                    <button @click="closeMessageModal" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="sendMessage" class="p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                            Message Content
                        </label>
                        <textarea x-model="messageText" rows="4" required
                                  class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition"
                                  placeholder="Type your message here..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-2">
                        <button type="button" @click="closeMessageModal"
                                class="px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-xs">
                            Cancel
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 text-xs font-semibold text-white rounded-xl shadow-xs hover:opacity-95 transition"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                :disabled="sending">
                            <span x-show="!sending">Send Message</span>
                            <span x-show="sending">Sending...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function therapistsStatus() {
            return {
                isBioOpen: false,
                isMessageOpen: false,
                sending: false,
                messageText: '',
                messageTarget: {
                    id: null,
                    name: '',
                    userType: 30
                },
                therapist: {
                    user: {},
                    type30: {}
                },
                zim: null,
                isZimLoggedIn: false,

                openBioModal(userAttributes, type30) {
                    this.therapist = {
                        user: userAttributes || {},
                        type30: type30 || {}
                    };
                    this.isBioOpen = true;
                },
                closeBioModal() {
                    this.isBioOpen = false;
                },
                async openMessageModal(target) {
                    this.messageTarget = Object.assign({
                        userType: 30
                    }, target || {});
                    this.messageText = '';
                    this.isMessageOpen = true;
                    if (!this.isZimLoggedIn) {
                        await this.initZego();
                    }
                },
                closeMessageModal() {
                    this.isMessageOpen = false;
                },
                async initZego() {
                    try {
                        const res = await fetch('/zego/chat-token', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const data = await res.json();

                        if (!ZIM.getInstance()) {
                            ZIM.create({
                                appID: data.appID
                            });
                        }
                        this.zim = ZIM.getInstance();
                        this.zim.on('error', (zim, err) => console.error('ZIM error', err));

                        await this.zim.login(data.userID, {
                            userName: data.userName,
                            token: data.token
                        });

                        this.isZimLoggedIn = true;
                    } catch (err) {
                        console.error('Zego init failed', err);
                    }
                },
                async sendMessage() {
                    if (this.sending || !this.messageText.trim() || !this.messageTarget.id) return;
                    this.sending = true;

                    const text = this.messageText.trim();

                    try {
                        await fetch('/chat/store-message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                to_user_id: this.messageTarget.id,
                                to_user_type: this.messageTarget.userType || 30,
                                message: text
                            })
                        });

                        if (this.isZimLoggedIn && this.zim) {
                            await this.zim.sendMessage({
                                type: 1,
                                message: ''
                            }, String(this.messageTarget.id), 0, {
                                priority: 1
                            });
                        }

                        this.messageText = '';
                        this.isMessageOpen = false;
                    } catch (err) {
                        console.error('Send message failed', err);
                    } finally {
                        this.sending = false;
                    }
                }
            }
        }
    </script>
</x-app1>