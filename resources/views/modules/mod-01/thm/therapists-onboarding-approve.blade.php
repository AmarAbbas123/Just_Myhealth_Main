<x-app1>

    @php
        $awaitingApprovalCount = $items->total();
        $verifiedReadyCount = \App\Models\SysUserType30Attributes::where('VerificationStatus', 'Approved')->whereNull('ApproverID')->count();
        $totalApprovedCount = \App\Models\SysUserType30Attributes::where('ApprovalStatus', 'Approved')->count();
        $activeTherapistsCount = \App\Models\User::where('UserType', 30)->where('AccountStatus', 1)->count();
    @endphp

    <div class="max-w-7xl mx-auto space-y-6" x-data="therapistsApproval()">

        <!-- Notifications -->
        @if (session('error'))
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-sm shadow-xs animate-fadeIn">
                <svg class="w-5 h-5 shrink-0 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if (session('success'))
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm shadow-xs animate-fadeIn">
                <svg class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Header -->
        <div class="flex items-center justify-between">
            <x-page-header :menu="$menu ?? null" />
        </div>

        <!-- ===================== -->
        <!-- QUICK SUMMARY CARDS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Card 1: Awaiting Final Approval -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Awaiting Approval</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($awaitingApprovalCount) }}</p>
                </div>
            </div>

            <!-- Card 2: Verified & Ready -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-300 bg-amber-50 dark:bg-amber-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Verified Ready</p>
                    <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ number_format($verifiedReadyCount) }}</p>
                </div>
            </div>

            <!-- Card 3: Total Approved -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Approved</p>
                    <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($totalApprovedCount) }}</p>
                </div>
            </div>

            <!-- Card 4: Active Therapists -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active Accounts</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ number_format($activeTherapistsCount) }}</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- ONBOARDING APPROVE TABLE CARD -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">

            <!-- Toolbar -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Therapist Approval Queue</h2>
                    </div>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                    {{ $items->total() }} Therapists Awaiting Approval
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
                <table class="w-full min-w-[1200px] text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/40 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700/80">
                        <tr>
                            @foreach ([
                                'ID' => 'ID',
                                'UserName' => 'UserName',
                                'FirstName' => 'First Name',
                                'LastName' => 'Last Name',
                                'DOB' => 'DOB',
                                'AccountStatus' => 'Status',
                            ] as $col => $label)
                                @php
                                    $sortable = in_array($col, ['UserName', 'AccountStatus']);
                                @endphp
                                <th class="px-4 py-3.5 whitespace-nowrap {{ $col === 'AccountStatus' ? 'text-center' : '' }}">
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
                                                    <span class="opacity-0 group-hover:opacity-60">▲</span>
                                                @endif
                                            </span>
                                        </a>
                                    @else
                                        {{ $label }}
                                    @endif
                                </th>
                            @endforeach

                            <th class="px-4 py-3.5 whitespace-nowrap text-center">Review & Decisions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                        @forelse ($items as $item)
                            @php
                                $attr = $item->userAttributes;
                                $type30 = $item->type30;
                            @endphp
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition-colors">
                                <!-- ID -->
                                <td class="px-4 py-3 font-mono font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    #{{ $item->ID }}
                                </td>

                                <!-- User Name -->
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->UserName }}
                                </td>

                                <!-- First Name -->
                                <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                    {{ $attr->FirstName ?? '-' }}
                                </td>

                                <!-- Last Name -->
                                <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                    {{ $attr->LastName ?? '-' }}
                                </td>

                                <!-- DOB -->
                                <td class="px-4 py-3 whitespace-nowrap font-mono text-gray-600 dark:text-gray-400">
                                    {{ $attr->DOB ?? '-' }}
                                </td>

                                <!-- Status (AccountStatus) strictly 1 or 0 -->
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    @if((string)$item->AccountStatus === '1')
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-mono font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 shadow-xs">
                                            1
                                        </span>
                                    @elseif((string)$item->AccountStatus === '0')
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-mono font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200/80 dark:border-rose-800/60 shadow-xs">
                                            0
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                            {{ $item->AccountStatus ?? '-' }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-3">

                                        <!-- Review Buttons Group -->
                                        <div class="flex items-center gap-1.5 p-1 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                                            <button type="button"
                                                class="px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-2xs hover:border-[#1C9BA0] hover:text-[#1C9BA0] dark:hover:border-[#1C9BA0] dark:hover:text-[#1C9BA0] transition-all flex items-center gap-1.5"
                                                @click='openBioModal("personal", @json($attr), @json($type30))'>
                                                <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>Personal</span>
                                            </button>

                                            <button type="button"
                                                class="px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-2xs hover:border-[#1C9BA0] hover:text-[#1C9BA0] dark:hover:border-[#1C9BA0] dark:hover:text-[#1C9BA0] transition-all flex items-center gap-1.5"
                                                @click='openBioModal("identity", @json($attr), @json($type30))'>
                                                <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                </svg>
                                                <span>Identity</span>
                                            </button>

                                            <button type="button"
                                                class="px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-2xs hover:border-[#1C9BA0] hover:text-[#1C9BA0] dark:hover:border-[#1C9BA0] dark:hover:text-[#1C9BA0] transition-all flex items-center gap-1.5"
                                                @click='openBioModal("qualification", @json($attr), @json($type30))'>
                                                <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                                <span>Qualification</span>
                                            </button>

                                            <button type="button"
                                                class="px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-2xs hover:border-[#1C9BA0] hover:text-[#1C9BA0] dark:hover:border-[#1C9BA0] dark:hover:text-[#1C9BA0] transition-all flex items-center gap-1.5"
                                                @click='openBioModal("experience", @json($attr), @json($type30))'>
                                                <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span>Experience</span>
                                            </button>
                                        </div>

                                        <!-- Decision Actions -->
                                        <div class="flex items-center gap-1.5">
                                            <button type="button"
                                                class="px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-2xs transition-all flex items-center gap-1 active:scale-95"
                                                @click='openStatusModal({{ $item->ID }}, @json($item->UserName), "Approved")'>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>APPROVE</span>
                                            </button>

                                            <button type="button"
                                                class="px-3 py-1.5 text-xs font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-lg shadow-2xs transition-all flex items-center gap-1 active:scale-95"
                                                @click='openStatusModal({{ $item->ID }}, @json($item->UserName), "Further Review")'>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>REVIEW</span>
                                            </button>

                                            <button type="button"
                                                class="px-3 py-1.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-lg shadow-2xs transition-all flex items-center gap-1 active:scale-95"
                                                @click='openStatusModal({{ $item->ID }}, @json($item->UserName), "Rejected")'>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span>REJECT</span>
                                            </button>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="inline-flex flex-col items-center justify-center text-gray-400">
                                        <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center mb-3 text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">No therapists awaiting approval</p>
                                        <p class="text-xs text-gray-400 mt-0.5">All verified therapist applications have been processed.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($items->hasPages())
                <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-700/80">
                    {{ $items->links('pagination::tailwind') }}
                </div>
            @endif

        </div>

        <!-- ===================== -->
        <!-- BIO / DETAILS MODAL -->
        <!-- ===================== -->
        <div x-show="isBioOpen" x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4 transition-all"
            @click.self="closeBioModal"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl p-6 shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col max-h-[90vh]" @click.stop>

                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <span x-text="(therapist.user.FirstName || '') + ' ' + (therapist.user.LastName || '')"></span>
                            </h2>
                            <p class="text-xs text-[#1C9BA0] font-medium" x-text="sectionTitles[reviewSection] || ''"></p>
                        </div>
                    </div>

                    <button @click="closeBioModal" class="w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Section Navigation Pills Inside Modal -->
                <div class="flex items-center gap-2 py-3 overflow-x-auto border-b border-gray-100 dark:border-gray-700 text-xs">
                    <button type="button" @click="reviewSection = 'personal'"
                        :class="reviewSection === 'personal' ? 'bg-[#1C9BA0] text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200'"
                        class="px-3 py-1.5 rounded-lg font-semibold transition shrink-0">
                        Personal Data
                    </button>
                    <button type="button" @click="reviewSection = 'identity'"
                        :class="reviewSection === 'identity' ? 'bg-[#1C9BA0] text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200'"
                        class="px-3 py-1.5 rounded-lg font-semibold transition shrink-0">
                        Identity Docs
                    </button>
                    <button type="button" @click="reviewSection = 'qualification'"
                        :class="reviewSection === 'qualification' ? 'bg-[#1C9BA0] text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200'"
                        class="px-3 py-1.5 rounded-lg font-semibold transition shrink-0">
                        Qualifications
                    </button>
                    <button type="button" @click="reviewSection = 'experience'"
                        :class="reviewSection === 'experience' ? 'bg-[#1C9BA0] text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200'"
                        class="px-3 py-1.5 rounded-lg font-semibold transition shrink-0">
                        Experience
                    </button>
                </div>

                <!-- Modal Body Content -->
                <div class="py-4 overflow-y-auto space-y-4 text-sm text-gray-700 dark:text-gray-300 flex-1 pr-1">

                    <!-- Personal Section -->
                    <div x-show="reviewSection === 'personal'" class="space-y-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <template x-for="field in personalFields" :key="field.key">
                                <div x-show="therapist.user[field.key]" class="p-3 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60">
                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-gray-400" x-text="field.label"></span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100 mt-0.5 block break-words" x-text="therapist.user[field.key]"></span>
                                </div>
                            </template>
                        </div>
                        <div x-show="!hasAnyPersonalData()" class="py-8 text-center text-gray-400 text-sm">
                            No personal data found for this profile.
                        </div>
                    </div>

                    <!-- Identity Section -->
                    <div x-show="reviewSection === 'identity'" class="space-y-3">
                        <template x-for="doc in identityDocs" :key="doc.key">
                            <div x-show="therapist.type30[doc.key]" class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-950/40 text-[#1C9BA0] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-800 dark:text-gray-200" x-text="doc.label"></span>
                                </div>
                                <a class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-[#1C9BA0] hover:bg-[#158085] rounded-lg shadow-2xs transition"
                                   target="_blank"
                                   :href="storageUrl(therapist.type30[doc.key], 'documents')">
                                    <span>View Document</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </template>
                        <div x-show="!hasAnyIdentityDocs()" class="py-8 text-center text-gray-400 text-sm">
                            No identity documents uploaded.
                        </div>
                    </div>

                    <!-- Qualification Section -->
                    <div x-show="reviewSection === 'qualification'" class="space-y-3">
                        <template x-for="i in [1,2,3,4]" :key="i">
                            <div x-show="therapist.type30['QualificationTitle'+i]" class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 space-y-2">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100" x-text="therapist.type30['QualificationTitle'+i]"></h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="therapist.type30['QualificationFrom'+i]"></p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0]" x-text="therapist.type30['QualificationLevel'+i]"></span>
                                </div>

                                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 dark:text-gray-400 pt-1">
                                    <div x-show="therapist.type30['QualificationGrade'+i]">
                                        <span class="font-medium text-gray-400">Grade:</span>
                                        <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="therapist.type30['QualificationGrade'+i]"></span>
                                    </div>
                                    <div x-show="therapist.type30['QualificationDateComplete'+i]">
                                        <span class="font-medium text-gray-400">Completed:</span>
                                        <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="therapist.type30['QualificationDateComplete'+i]"></span>
                                    </div>
                                </div>

                                <div x-show="therapist.type30['QualificationImagePath'+i]" class="pt-2">
                                    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-[#1C9BA0] hover:bg-[#158085] rounded-lg shadow-2xs transition"
                                        target="_blank"
                                        :href="storageUrl(therapist.type30['QualificationImagePath'+i], 'qualification-files')">
                                        <span>View Certificate</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </template>
                        <div x-show="!hasAnyQualification()" class="py-8 text-center text-gray-400 text-sm">
                            No qualifications recorded.
                        </div>
                    </div>

                    <!-- Experience Section -->
                    <div x-show="reviewSection === 'experience'" class="space-y-3">
                        <template x-for="i in [1,2,3,4,5]" :key="i">
                            <div x-show="therapist.type30['TherapyType'+i]" class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Specialty</span>
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100" x-text="therapist.type30['TherapyType'+i]"></h4>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Experience</span>
                                    <p class="text-sm font-bold text-[#1C9BA0]">
                                        <span x-text="therapist.type30['TherapyYearsExperience'+i]"></span> years
                                    </p>
                                </div>
                            </div>
                        </template>
                        <div x-show="!hasAnyExperience()" class="py-8 text-center text-gray-400 text-sm">
                            No experience entries recorded.
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <button type="button" @click="closeBioModal" class="px-5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 transition">
                        Close
                    </button>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- APPROVAL DECISION MODAL -->
        <!-- ===================== -->
        <div x-show="isStatusOpen" x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4 transition-all"
            @click.self="closeStatusModal"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg p-6 shadow-2xl border border-gray-100 dark:border-gray-700" @click.stop>
                
                <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white shrink-0"
                             :class="{
                                'bg-emerald-600': statusValue === 'Approved',
                                'bg-amber-500': statusValue === 'Further Review',
                                'bg-rose-600': statusValue === 'Rejected'
                             }">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">
                            Approval Decision
                        </h2>
                    </div>

                    <button @click="closeStatusModal" class="w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Info Box -->
                <div class="my-4 p-3.5 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Therapist Account</span>
                        <div class="font-bold text-gray-900 dark:text-gray-100 mt-0.5">
                            <span x-text="statusUserName"></span>
                            <span class="text-xs text-gray-400 font-mono">(#<span x-text="statusUserId"></span>)</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-xs text-gray-400 block font-medium">Decision</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold mt-0.5"
                              :class="{
                                'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300': statusValue === 'Approved',
                                'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300': statusValue === 'Further Review',
                                'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300': statusValue === 'Rejected'
                              }"
                              x-text="statusValue">
                        </span>
                    </div>
                </div>

                <form method="POST" :action="statusActionUrl()" class="space-y-4">
                    @csrf
                    <input type="hidden" name="status" :value="statusValue">

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                            Approver Notes (max 128 chars) <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="approver_notes"
                            x-model.trim="approverNotes"
                            maxlength="128"
                            required
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-900/60 px-3.5 py-2.5 text-sm text-gray-800 dark:text-gray-100 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition"
                            placeholder="Enter a mandatory short note for this decision...">
                        <div class="mt-1.5 flex justify-between text-xs text-gray-400">
                            <span>Required for audit trail</span>
                            <span><span x-text="approverNotes.length"></span>/128</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2.5 pt-2">
                        <button type="button" @click="closeStatusModal"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-white rounded-xl text-sm font-semibold shadow-xs transition active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                            :disabled="!approverNotes || approverNotes.length === 0">
                            Submit Decision
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function therapistsApproval() {
            return {
                isBioOpen: false,
                isStatusOpen: false,
                reviewSection: 'personal',
                sectionTitles: {
                    personal: 'Review Personal Data',
                    identity: 'Review Identity',
                    qualification: 'Review Qualification',
                    experience: 'Review Experience'
                },
                personalFields: [
                    { label: 'First Name', key: 'FirstName' },
                    { label: 'Last Name', key: 'LastName' },
                    { label: 'DOB', key: 'DOB' },
                    { label: 'Year of Birth', key: 'YearBirth' },
                    { label: 'Gender', key: 'Gender' },
                    { label: 'Base City', key: 'BaseCity' },
                    { label: 'Base State', key: 'BaseState' },
                    { label: 'Base Country', key: 'BaseCountry' },
                    { label: 'Business Name', key: 'BusinessName' },
                    { label: 'Business Contact First Name', key: 'BusinessContactFirstName' },
                    { label: 'Business Contact Last Name', key: 'BusinessContactLastName' },
                    { label: 'Business Primary Industry', key: 'BusinessPrimaryIndustry' },
                    { label: 'Business Sub Industry', key: 'BusinessSubIndustry' },
                    { label: 'Business Type', key: 'BusinessType' },
                    { label: 'Address 1', key: 'Address1' },
                    { label: 'Address 2', key: 'Address2' },
                    { label: 'Base Zip', key: 'BaseZip' }
                ],
                identityDocs: [
                    { label: 'Passport', key: 'VerificationPassportImagePath' },
                    { label: 'BACP Card', key: 'VerificationBACPCardImagePath' },
                    { label: 'Liability Insurance', key: 'VerificationLiabilityInsuranceImagePath' },
                    { label: 'DBS', key: 'VerificationDBSImagePath' }
                ],
                therapist: {
                    user: {},
                    type30: {}
                },

                statusUserId: null,
                statusUserName: '',
                statusValue: '',
                approverNotes: '',

                hasAnyPersonalData() {
                    return this.personalFields.some((field) => this.therapist.user[field.key]);
                },
                hasAnyIdentityDocs() {
                    return this.identityDocs.some((doc) => this.therapist.type30[doc.key]);
                },
                hasAnyQualification() {
                    return [1, 2, 3, 4].some((i) => this.therapist.type30['QualificationTitle' + i]);
                },
                hasAnyExperience() {
                    return [1, 2, 3, 4, 5].some((i) => this.therapist.type30['TherapyType' + i]);
                },
                storageUrl(path, folder) {
                    if (!path) return '';
                    const raw = String(path).trim();
                    if (!raw) return '';

                    if (raw.startsWith('http://') || raw.startsWith('https://')) return raw;
                    if (raw.startsWith('/storage/')) return raw;
                    if (raw.startsWith('storage/')) return '/' + raw;
                    if (raw.startsWith('/')) return raw;

                    if (folder && raw.startsWith(folder + '/')) return '/storage/' + raw;
                    return '/storage/' + (folder ? folder + '/' : '') + raw;
                },
                openBioModal(section, userAttributes, type30) {
                    this.therapist = {
                        user: userAttributes || {},
                        type30: type30 || {}
                    };
                    this.reviewSection = section || 'personal';
                    this.isBioOpen = true;
                },
                closeBioModal() {
                    this.isBioOpen = false;
                },

                openStatusModal(userId, userName, status) {
                    this.statusUserId = userId;
                    this.statusUserName = userName || '';
                    this.statusValue = status || '';
                    this.approverNotes = '';
                    this.isStatusOpen = true;
                },
                closeStatusModal() {
                    this.isStatusOpen = false;
                },
                statusActionUrl() {
                    if (!this.statusUserId) return '';
                    return `/mod-01/therapist-management/therapist-onboarding-approve/${this.statusUserId}/status`;
                },
            }
        }
    </script>
</x-app1>