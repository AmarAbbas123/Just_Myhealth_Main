<x-app1>

    <div class="w-full max-w-7xl  space-y-6">

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <x-page-header />
        </div>

        <!-- ===================== -->
        <!-- QUICK SUMMARY CARDS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Stat 1: Total All Time -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total All Time</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $allTime['total'] ?? 'GBP: £0.00' }}</p>
                </div>
            </div>

            <!-- Stat 2: Total This Year -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total This Year</p>
                    <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $thisYear['total'] ?? 'GBP: £0.00' }}</p>
                </div>
            </div>

            <!-- Stat 3: Record Count (All Time) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Records (All Time)</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($recordsAll->count() ?? 0) }}</p>
                </div>
            </div>

            <!-- Stat 4: Record Count (This Year) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Records ({{ date('Y') }})</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ number_format($recordsThisYear->count() ?? 0) }}</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- PLATFORM OPERATIONS – ALL TIME -->
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
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Platform Operations Costs – All Time</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-500/20">
                    Lifetime: {{ $allTime['total'] ?? 'GBP: £0.00' }}
                </span>
            </div>

            <div class="p-4 sm:p-6 space-y-4">
                <!-- Featured Total Card -->
                <div class="bg-gradient-to-br from-amber-50/80 to-amber-100/40 dark:from-amber-950/20 dark:to-gray-800 rounded-2xl p-5 border border-amber-200/80 dark:border-amber-700/40 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-300">Total Operations Cost</span>
                        <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                        {{ $allTime['total'] ?? 'GBP: £0.00' }}
                    </div>
                </div>

                <!-- 6 Category Breakdown Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
                    @foreach(['Compute','Services Plugins','SW Dev','SW Support','Security Services','Misc'] as $cat)
                        @php $key = strtolower(str_replace(' ', '_', $cat)); @endphp
                        <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                            <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">{{ $cat }}</div>
                            <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $allTime[$key] ?? 'GBP: £0.00' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- PLATFORM OPERATIONS – THIS YEAR -->
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
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Platform Operations Costs – This Year ({{ date('Y') }})</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20">
                    This Year: {{ $thisYear['total'] ?? 'GBP: £0.00' }}
                </span>
            </div>

            <div class="p-4 sm:p-6 space-y-4">
                <!-- Featured Total Card -->
                <div class="bg-gradient-to-br from-emerald-50/80 to-emerald-100/40 dark:from-emerald-950/20 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200/80 dark:border-emerald-700/40 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300">Total Operations Cost (YTD)</span>
                        <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                        {{ $thisYear['total'] ?? 'GBP: £0.00' }}
                    </div>
                </div>

                <!-- 6 Category Breakdown Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
                    @foreach(['Compute','Services Plugins','SW Dev','SW Support','Security Services','Misc'] as $cat)
                        @php $key = strtolower(str_replace(' ', '_', $cat)); @endphp
                        <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/40 transition-all">
                            <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">{{ $cat }}</div>
                            <div class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $thisYear[$key] ?? 'GBP: £0.00' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- DETAILED OPERATIONS LEDGER TABLE -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Operations Cost Ledger</h3>
                </div>

                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60">
                    {{ $recordsAll->count() }} Entries
                </span>
            </div>
            
            <!-- Mobile Cards -->
            <div class="md:hidden p-4 space-y-3">
                @forelse(($recordsAll ?? collect()) as $row)
                    <div class="border border-gray-100 dark:border-gray-700 rounded-xl p-4 bg-gray-50/50 dark:bg-gray-900/40">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20">
                                    {{ $row->ServiceCategory ?? '' }}
                                </span>
                                <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-1 truncate">      
                                    {{ $row->SupplierName ?? '' }}
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ number_format((float) ($row->DebitValue ?? 0), 2) }}
                                </div>
                                <div class="text-[11px] text-gray-400 whitespace-nowrap uppercase">
                                    {{ $row->DebitCurrency ?? '' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 space-y-2 text-xs">
                            @if(!empty($row->ServiceDescription))
                                <div>
                                    <span class="text-gray-400 font-medium">Description:</span>
                                    <span class="text-gray-700 dark:text-gray-300 ml-1">{{ $row->ServiceDescription }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                                <span>Date:</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">
                                    {{ $row->DebitDate ? \Illuminate\Support\Carbon::parse($row->DebitDate)->format('d M Y') : '—' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-400 text-sm">
                        No records found.
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[850px] text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/40 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700/80">
                        <tr>
                            <th class="px-5 py-3.5 whitespace-nowrap">Category</th>
                            <th class="px-5 py-3.5 whitespace-nowrap">Supplier</th>
                            <th class="px-5 py-3.5">Description</th>
                            <th class="px-5 py-3.5 whitespace-nowrap">Date</th>
                            <th class="px-5 py-3.5 text-right whitespace-nowrap">Debit Value</th>
                            <th class="px-5 py-3.5 text-center whitespace-nowrap">Currency</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-gray-700 dark:text-gray-300">
                        @forelse(($recordsAll ?? collect()) as $row)
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20">
                                        {{ $row->ServiceCategory ?? '' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 font-medium whitespace-nowrap">{{ $row->SupplierName ?? '' }}</td>
                                <td class="px-5 py-3.5 max-w-md truncate text-gray-600 dark:text-gray-400">{{ $row->ServiceDescription ?? '—' }}</td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-gray-500 dark:text-gray-400 font-mono text-xs">
                                    {{ $row->DebitDate ? \Illuminate\Support\Carbon::parse($row->DebitDate)->format('Y-m-d') : '—' }}
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap font-bold text-gray-900 dark:text-gray-100 font-mono">
                                    {{ number_format((float) ($row->DebitValue ?? 0), 2) }}
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                                        {{ $row->DebitCurrency ?? 'GBP' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-5 py-8 text-center text-gray-400" colspan="6">
                                    No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</x-app1>