<x-app1>

    @php
        $allTime = $dataSource['all_time']['total_calculation'] ?? 0;
        $thisYear = $dataSource['this_year']['total_calculation'] ?? 0;
        $owed = $allTime - $thisYear;
    @endphp

    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <x-page-header />
        </div>

        <!-- ===================== -->
        <!-- QUICK SUMMARY CARDS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Stat 1: Net Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Net Revenue</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $allTimeRevenue['total'] ?? 'xx' }}</p>
                </div>
            </div>

            <!-- Stat 2: Payments Made -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Payments Made</p>
                    <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $thisYearRevenue['total'] ?? 'xx' }}</p>
                </div>
            </div>

            <!-- Stat 3: Payments Owed -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-rose-600 dark:text-rose-300 bg-rose-50 dark:bg-rose-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Payments Owed</p>
                    <p class="text-xl sm:text-2xl font-bold text-rose-600 dark:text-rose-400 mt-1">£{{ number_format($owed, 2) }}</p>
                </div>
            </div>

            <!-- Stat 4: Future Sessions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Future Sessions</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">£0.00</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- REVENUE – ALL TIME SECTION -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Revenue – All Time</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-500/20">
                    Lifetime: {{ $allTimeRevenue['total'] ?? 'xx' }}
                </span>
            </div>

            <div class="p-4 sm:p-6 space-y-4">
                <!-- Top 3 Primary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Total Revenue Card -->
                    <div class="bg-gradient-to-br from-amber-50/80 to-amber-100/40 dark:from-amber-950/20 dark:to-gray-800 rounded-2xl p-5 border border-amber-200/80 dark:border-amber-700/40 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-300">Total Revenue</span>
                            <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ $allTimeRevenue['total'] ?? 'xx' }}
                        </div>
                    </div>

                    <!-- Counselling Registration Fees -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Counselling (Registration Fees)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1C9BA0]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ $allTimeRevenue['registration_fees'] ?? 'xx' }}
                        </div>
                    </div>

                    <!-- Counselling Session Fees -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Counselling (Session Fees)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ $allTimeRevenue['session_fees'] ?? 'xx' }}
                        </div>
                    </div>
                </div>

                <!-- Secondary Breakdown (6 categories) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Physical Training</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $allTimeRevenue['physical_training_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Dietitian</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $allTimeRevenue['dietitian_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - Local</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $allTimeRevenue['business_local_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - Regional</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $allTimeRevenue['business_regional_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - National</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $allTimeRevenue['business_national_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - Global</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $allTimeRevenue['business_global_registration'] ?? 'xx' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- REVENUE – THIS YEAR SECTION -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #10B981, #059669);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Revenue – This Year ({{ date('Y') }})</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20">
                    This Year: {{ $thisYearRevenue['total'] ?? 'xx' }}
                </span>
            </div>

            <div class="p-4 sm:p-6 space-y-4">
                <!-- Top 3 Primary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Total Revenue This Year -->
                    <div class="bg-gradient-to-br from-emerald-50/80 to-emerald-100/40 dark:from-emerald-950/20 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200/80 dark:border-emerald-700/40 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300">Total Revenue This Year</span>
                            <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ $thisYearRevenue['total'] ?? 'xx' }}
                        </div>
                    </div>

                    <!-- Counselling Registration Fee This Year -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Counselling (Registration Fees)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1C9BA0]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ $thisYearRevenue['registration_fees'] ?? 'xx' }}
                        </div>
                    </div>

                    <!-- Counselling Session Fee This Year -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Counselling (Session Fees)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ $thisYearRevenue['session_fees'] ?? 'xx' }}
                        </div>
                    </div>
                </div>

                <!-- Secondary Breakdown (6 categories) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Physical Training (Registration Fees)</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $thisYearRevenue['physical_training_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Dietitian (Registration Fees)</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $thisYearRevenue['dietitian_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - Local (Registration Fees)</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $thisYearRevenue['business_local_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - Regional (Registration Fees)</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $thisYearRevenue['business_regional_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - National (Registration Fees)</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $thisYearRevenue['business_national_registration'] ?? 'xx' }}
                        </div>
                    </div>

                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Business - Global (Registration Fees)</div>
                        <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $thisYearRevenue['business_global_registration'] ?? 'xx' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- CHARTS SECTION: 1 Graph Per Row (Fluid & Responsive) -->
        <!-- ===================== -->
        <div class="space-y-6">

            <!-- Chart 1: Revenue (Monthly) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow overflow-hidden">
                <!-- Header -->
                <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Revenue (Monthly)</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60">
                        Monthly Totals
                    </span>
                </div>

                <div class="p-3 sm:p-5 w-full min-w-0">
                    <div id="chart-revenue-monthly" class="w-full min-w-0"></div>
                </div>
            </div>

            <!-- Chart 2: Revenue (Weekly) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow overflow-hidden">
                <!-- Header -->
                <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-indigo-500/10 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Revenue (Weekly)</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60">
                        Weekly Stacked
                    </span>
                </div>

                <div class="p-3 sm:p-5 w-full min-w-0">
                    <div id="chart-revenue-weekly" class="w-full min-w-0"></div>
                </div>
            </div>

        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const combined = @json($combinedCharts ?? []);
        const isDark = document.documentElement.classList.contains('dark');

        const monthly = combined.monthly || { labels: [], professional: [], business: [], session: [] };
        const weekly  = combined.weekly  || { labels: [], professional: [], business: [], session: [] };

        const money = (val) => '£' + Number(val || 0).toFixed(2);

        /* MONTHLY CHART */
        const monthlyChart = new ApexCharts(
            document.querySelector("#chart-revenue-monthly"),
            {
                chart: {
                    type: 'bar',
                    height: 330,
                    width: '100%',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    parentHeightOffset: 0
                },
                colors: ['#1C9BA0', '#6366F1', '#F59E0B'],
                series: [
                    { name: "Professional Registration Fees", data: monthly.professional },
                    { name: "Business Registration Fees", data: monthly.business },
                    { name: "Session Fees", data: monthly.session }
                ],
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                        borderRadius: 4
                    }
                },
                grid: {
                    borderColor: isDark ? '#374151' : '#F1F5F9',
                    strokeDashArray: 0,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: {
                        left: 12,
                        right: 25,
                        top: 0,
                        bottom: 0
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: monthly.labels,
                    labels: {
                        hideOverlappingLabels: true,
                        style: {
                            colors: isDark ? '#9CA3AF' : '#64748B',
                            fontSize: '11px',
                            fontWeight: 500
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: isDark ? '#9CA3AF' : '#64748B',
                            fontSize: '11px',
                            fontWeight: 500
                        },
                        formatter: (v) => '£' + Number(v).toFixed(0)
                    }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: { formatter: money }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '12px',
                    fontWeight: 500,
                    offsetY: 6,
                    markers: {
                        width: 8,
                        height: 8,
                        radius: 12
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 4
                    },
                    labels: {
                        colors: isDark ? '#D1D5DB' : '#64748B'
                    }
                },
                responsive: [
                    {
                        breakpoint: 768,
                        options: {
                            chart: { height: 280 },
                            plotOptions: { bar: { columnWidth: '65%' } },
                            xaxis: {
                                labels: {
                                    rotate: -45,
                                    style: { fontSize: '10px' }
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            chart: { height: 250 },
                            legend: {
                                position: 'bottom',
                                fontSize: '11px',
                                itemMargin: { horizontal: 6, vertical: 2 }
                            }
                        }
                    }
                ]
            }
        );
     
        monthlyChart.render();

        /* WEEKLY CHART */
        const weeklyChart = new ApexCharts(
            document.querySelector("#chart-revenue-weekly"),
            {
                chart: {
                    type: 'bar',
                    stacked: true,
                    height: 330,
                    width: '100%',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    parentHeightOffset: 0
                },
                colors: ['#1C9BA0', '#6366F1', '#F59E0B'],
                series: [
                    { name: "Professional Registration Fees", data: weekly.professional },
                    { name: "Business Registration Fees", data: weekly.business },
                    { name: "Session Fees", data: weekly.session }
                ],
                plotOptions: {
                    bar: {
                        columnWidth: '55%',
                        borderRadius: 3
                    }
                },
                grid: {
                    borderColor: isDark ? '#374151' : '#F1F5F9',
                    strokeDashArray: 0,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: {
                        left: 12,
                        right: 25,
                        top: 0,
                        bottom: 0
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: weekly.labels,
                    labels: {
                        rotate: -45,
                        rotateAlways: true,
                        hideOverlappingLabels: true,
                        style: {
                            colors: isDark ? '#9CA3AF' : '#64748B',
                            fontSize: '10px',
                            fontWeight: 500
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: isDark ? '#9CA3AF' : '#64748B',
                            fontSize: '11px',
                            fontWeight: 500
                        },
                        formatter: (v) => '£' + Number(v).toFixed(0)
                    }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: { formatter: money }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '12px',
                    fontWeight: 500,
                    offsetY: 6,
                    markers: {
                        width: 8,
                        height: 8,
                        radius: 12
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 4
                    },
                    labels: {
                        colors: isDark ? '#D1D5DB' : '#64748B'
                    }
                },
                responsive: [
                    {
                        breakpoint: 768,
                        options: {
                            chart: { height: 280 },
                            plotOptions: { bar: { columnWidth: '70%' } }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            chart: { height: 250 },
                            legend: {
                                position: 'bottom',
                                fontSize: '11px',
                                itemMargin: { horizontal: 6, vertical: 2 }
                            }
                        }
                    }
                ]
            }
        );

        weeklyChart.render();

        /* Ensure smooth recalculation on window or sidebar resize */
        window.addEventListener('resize', function () {
            if (typeof monthlyChart !== 'undefined') monthlyChart.resize();
            if (typeof weeklyChart !== 'undefined') weeklyChart.resize();
        });

        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 300);

    });
    </script>

</x-app1>
