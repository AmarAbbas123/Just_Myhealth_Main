<x-app1>
    <div x-data="financeApp()" class="space-y-6">

        <!-- Page Header & Action -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
            <a href="{{ route('therap.bank.details') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs hover:shadow-xs active:scale-95 self-start md:self-auto">
                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span>Bank & Payout Details</span>
            </a>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Net Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Net Revenue</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5 truncate">
                        £<span x-text="formatCurrency(netRevenue)"></span>
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">After platform fees (All time)</p>
                </div>
            </div>

            <!-- Card 2: Payments Made -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Payments Made</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-0.5 truncate">
                        £<span x-text="formatCurrency(paymentsMade)"></span>
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Processed payouts this year</p>
                </div>
            </div>

            <!-- Card 3: Payments Owed -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Payments Owed</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-0.5 truncate">
                        £<span x-text="formatCurrency(paymentsOwed)"></span>
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Pending transfer (Month end)</p>
                </div>
            </div>

            <!-- Card 4: Future Sessions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Future Sessions</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-0.5 truncate">
                        £<span x-text="formatCurrency(futureSessions)"></span>
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Value of booked consultations</p>
                </div>
            </div>
        </div>

        <!-- Filters Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="flex flex-col sm:flex-row sm:items-end gap-3 sm:gap-4 flex-wrap">
                <!-- Start Date -->
                <div class="flex-1 min-w-[160px]">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Start Date</label>
                    <input type="date" x-model="startDate"
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                </div>

                <!-- End Date -->
                <div class="flex-1 min-w-[160px]">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">End Date</label>
                    <input type="date" x-model="endDate"
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                </div>

                <!-- Transaction Type -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Transaction Type</label>
                    <select x-model="filterType"
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        <option value="">All Transactions</option>
                        <option value="SESSION_ALL">Sessions (All)</option>
                        <option value="SESSION_PAID">Sessions (Paid)</option>
                        <option value="SESSION_OWED">Sessions (Owed)</option>
                        <option value="PAYOUT">Payouts</option>
                    </select>
                </div>

                <!-- Filter & Reset Buttons -->
                <div class="flex items-center gap-2 self-stretch sm:self-auto pt-1 sm:pt-0">
                    <button @click="applyFilters()"
                        type="button"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white shadow-2xs hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter</span>
                    </button>

                    <button @click="resetFilters()"
                        type="button"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-all duration-200 active:scale-95 cursor-pointer">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sessions Transaction Table -->
        <div x-show="filterType !== 'PAYOUT'"
             class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 overflow-hidden">

            <!-- Section Header -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                            Transaction History (Sessions)
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-gray-400">
                            Consultation fee earnings and client session completion records
                        </p>
                    </div>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <span x-text="sessionTransactions.length"></span> Records
                </span>
            </div>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="px-5 sm:px-6 py-4">Date</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">Screen Name</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">Users Name</th>
                            <th scope="col" class="px-5 sm:px-6 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-sm">
                        <template x-for="t in sessionTransactions" :key="t.id">
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors group">
                                <!-- Date -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-[#1C9BA0]/10 flex items-center justify-center text-[#1C9BA0] shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-800 dark:text-gray-200" x-text="formatDate(t.date)"></span>
                                    </div>
                                </td>

                                <!-- Screen Name -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300" x-text="'@' + t.screen_name"></span>
                                </td>

                                <!-- Real Name -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900 dark:text-gray-100" x-text="t.real_name || t.screen_name"></span>
                                </td>

                                <!-- Amount -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-right">
                                    <span class="font-extrabold text-base text-gray-900 dark:text-gray-100">
                                        £<span x-text="t.amount"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <tr x-show="sessionTransactions.length === 0">
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No session transaction history found for the selected filter.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700/70">
                <template x-for="t in sessionTransactions" :key="t.id">
                    <div class="p-4 space-y-2.5 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300">
                                <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium" x-text="formatDate(t.date)"></span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100" x-text="t.real_name || t.screen_name"></h4>
                                <span class="text-xs text-gray-400" x-text="'@' + t.screen_name"></span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-base text-gray-900 dark:text-gray-100">£<span x-text="t.amount"></span></span>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="sessionTransactions.length === 0" class="px-6 py-10 text-center text-sm text-gray-500">
                    No session transactions found.
                </div>
            </div>

        </div>

        <!-- Payout Transaction Table -->
        <div x-show="filterType === '' || filterType === 'PAYOUT'"
             class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 overflow-hidden">

            <!-- Section Header -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                            Transaction History (Payouts)
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-gray-400">
                            Disbursements transferred directly to your bank account
                        </p>
                    </div>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <span x-text="payoutTransactions.length"></span> Transfers
                </span>
            </div>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="px-5 sm:px-6 py-4">Date</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">From</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">To</th>
                            <th scope="col" class="px-5 sm:px-6 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-sm">
                        <template x-for="p in payoutTransactions" :key="p.id">
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors group">
                                <!-- Date -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-800 dark:text-gray-200" x-text="formatDate(p.date)"></span>
                                    </div>
                                </td>

                                <!-- From -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#1C9BA0]"></span>
                                        JustMy.Health
                                    </span>
                                </td>

                                <!-- To -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-800 dark:text-gray-200 text-xs sm:text-sm">Therapist Account</span>
                                </td>

                                <!-- Amount -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-right">
                                    <span class="font-extrabold text-base text-emerald-600 dark:text-emerald-400">
                                        £<span x-text="p.amount"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <tr x-show="payoutTransactions.length === 0">
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No payout transaction history found for the selected filter.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700/70">
                <template x-for="p in payoutTransactions" :key="p.id">
                    <div class="p-4 space-y-2.5 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium" x-text="formatDate(p.date)"></span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">From JustMy.Health &rarr; Account</span>
                            <span class="font-extrabold text-base text-emerald-600 dark:text-emerald-400">£<span x-text="p.amount"></span></span>
                        </div>
                    </div>
                </template>

                <div x-show="payoutTransactions.length === 0" class="px-6 py-10 text-center text-sm text-gray-500">
                    No payout transfers found.
                </div>
            </div>

        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function financeApp() {
            return {
                netRevenue: {{ $netRevenue }},
                paymentsMade: {{ $paymentsMade }},
                paymentsOwed: {{ $paymentsOwed }},
                futureSessions: {{ $unscheduledValue }},

                startDate: '',
                endDate: '',
                filterType: '',

                sessionTransactions: @json($sessionTransactions ?? []),
                payoutTransactions: @json($payoutTransactions ?? []),

                formatCurrency(val) {
                    return Number(val || 0).toLocaleString('en-GB', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },

                formatDate(d) {
                    if (!d) return '-';
                    try {
                        const dateObj = new Date(d);
                        if (isNaN(dateObj.getTime())) return d;
                        return dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                    } catch (e) {
                        return d;
                    }
                },

                applyFilters() {
                    const start = this.startDate ? new Date(this.startDate) : null;
                    const end = this.endDate ? new Date(this.endDate) : null;

                    if (start) start.setHours(0, 0, 0, 0);
                    if (end) end.setHours(23, 59, 59, 999);

                    const byDate = t => {
                        if (!t.date) return true;
                        const d = new Date(t.date);
                        return (!start || d >= start) && (!end || d <= end);
                    };

                    let sessions = @json($sessionTransactions ?? []);
                    let payouts = @json($payoutTransactions ?? []);

                    sessions = sessions.filter(byDate);
                    payouts = payouts.filter(byDate);

                    switch (this.filterType) {
                        case 'SESSION_PAID':
                            sessions = sessions.filter(s => s.payment_status === 'PAID');
                            payouts = [];
                            break;

                        case 'SESSION_OWED':
                            sessions = sessions.filter(s => s.payment_status === 'OWED');
                            payouts = [];
                            break;

                        case 'SESSION_ALL':
                            payouts = [];
                            break;

                        case 'PAYOUT':
                            sessions = [];
                            break;
                    }

                    this.sessionTransactions = sessions;
                    this.payoutTransactions = payouts;
                },

                resetFilters() {
                    this.startDate = '';
                    this.endDate = '';
                    this.filterType = '';
                    this.sessionTransactions = @json($sessionTransactions ?? []);
                    this.payoutTransactions = @json($payoutTransactions ?? []);
                }
            };
        }
    </script>
</x-app1>