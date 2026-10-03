<x-app1>
    <div x-data="reportsApp()" class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-3.5 py-2 rounded-xl border border-gray-100 dark:border-gray-700 shadow-2xs self-start sm:self-auto">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Active Support Logging</span>
            </div>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Reports -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Total Reports</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5 truncate" x-text="reports.length"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Recorded complaints & issues</p>
                </div>
            </div>

            <!-- Card 2: Pending Action -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Pending Issues</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-0.5 truncate" x-text="pendingReportsCount"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Awaiting review or action</p>
                </div>
            </div>

            <!-- Card 3: Resolved -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Resolved</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-0.5 truncate" x-text="resolvedReportsCount"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Successfully closed</p>
                </div>
            </div>

            <!-- Card 4: Resolution Rate -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Resolution Rate</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-0.5 truncate" x-text="resolutionRate + '%'"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Closed issues percentage</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 lg:gap-5 items-end">
                <!-- Reported By -->
                <div class="w-full lg:col-span-3">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Reported By</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search reporter..." x-model="filters.reportedBy"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                    </div>
                </div>

                <!-- Issue Summary -->
                <div class="w-full lg:col-span-3">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Issue Summary</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search summary..." x-model="filters.summary"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                    </div>
                </div>

                <!-- Date Range (From - To) -->
                <div class="w-full sm:col-span-2 lg:col-span-4">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Date Range</label>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1 min-w-0">
                            <input type="date" x-model="filters.dateFrom" title="From Date"
                                class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                        </div>
                        <span class="text-gray-400 text-xs font-semibold shrink-0">to</span>
                        <div class="relative flex-1 min-w-0">
                            <input type="date" x-model="filters.dateTo" title="To Date"
                                class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                        </div>
                    </div>
                </div>

                <!-- Actions: Reset Filters -->
                <div class="w-full sm:col-span-2 lg:col-span-2">
                    <button @click="clearFilters"
                        class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset Filters</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reports Table & Card Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
            <!-- Header bar with Counter & Quick Filters -->
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/30">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base">Complaints & Issues Log</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20"
                          x-text="filteredReports.length + ' ' + (filteredReports.length === 1 ? 'report' : 'reports')">
                    </span>
                </div>
                <!-- Quick Filter Tabs -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                    <button @click="filters.status = ''"
                        :class="filters.status === '' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        All
                    </button>
                    <button @click="filters.status = 'Pending'"
                        :class="filters.status === 'Pending' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        Pending
                    </button>
                    <button @click="filters.status = 'Resolved'"
                        :class="filters.status === 'Resolved' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        Resolved
                    </button>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/30 dark:bg-gray-900/20 text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="py-3.5 px-5">Date</th>
                            <th scope="col" class="py-3.5 px-5">Reported By</th>
                            <th scope="col" class="py-3.5 px-5">Issue Summary</th>
                            <th scope="col" class="py-3.5 px-5">Status</th>
                            <th scope="col" class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                        <template x-for="report in filteredReports" :key="report.id">
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-all group">
                                <!-- Date -->
                                <td class="py-4 px-5 font-medium text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span x-text="report.date"></span>
                                    </div>
                                </td>

                                <!-- Reported By -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 flex items-center justify-center font-bold text-xs shrink-0">
                                            <span x-text="report.reportedBy ? report.reportedBy.charAt(0).toUpperCase() : 'U'"></span>
                                        </div>
                                        <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="report.reportedBy"></span>
                                    </div>
                                </td>

                                <!-- Issue Summary -->
                                <td class="py-4 px-5 max-w-md">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100 truncate" x-text="report.summary"></p>
                                    <p class="text-xs text-gray-400 dark:text-gray-400 truncate mt-0.5" x-text="report.details"></p>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold"
                                          :class="report.status === 'Resolved'
                                              ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60'
                                              : 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60'">
                                        <span class="w-1.5 h-1.5 rounded-full"
                                              :class="report.status === 'Resolved' ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse'"></span>
                                        <span x-text="report.status"></span>
                                    </span>
                                </td>

                                <!-- Action Button -->
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <button @click="openReport(report)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:text-teal-300 border border-[#1C9BA0]/30 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>View</span>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-100 dark:divide-gray-700/60">
                <template x-for="report in filteredReports" :key="report.id">
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 flex items-center justify-center font-bold text-xs shrink-0">
                                    <span x-text="report.reportedBy ? report.reportedBy.charAt(0).toUpperCase() : 'U'"></span>
                                </div>
                                <span class="font-bold text-sm text-gray-900 dark:text-gray-100" x-text="report.reportedBy"></span>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                  :class="report.status === 'Resolved'
                                      ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60'
                                      : 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60'">
                                <span class="w-1.5 h-1.5 rounded-full"
                                      :class="report.status === 'Resolved' ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                                <span x-text="report.status"></span>
                            </span>
                        </div>

                        <div>
                            <p class="font-semibold text-sm text-gray-900 dark:text-gray-100" x-text="report.summary"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2" x-text="report.details"></p>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <div class="flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span x-text="report.date"></span>
                            </div>
                            <button @click="openReport(report)"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:text-teal-300 border border-[#1C9BA0]/30 rounded-xl text-xs font-semibold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>View</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredReports.length === 0" class="py-16 text-center px-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4 class="text-base font-bold text-gray-800 dark:text-gray-200">No reports found</h4>
                <p class="text-xs sm:text-sm text-gray-400 mt-1 max-w-sm mx-auto">
                    No complaints match your selected search or date criteria. Try clearing filters to see all entries.
                </p>
                <div class="mt-4">
                    <button @click="clearFilters"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-2xs">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Issue Details / Resolution Modal -->
        <div x-show="selectedReport" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto"
                 @click.away="selectedReport = null"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/40 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Issue Details</h3>
                            <p class="text-xs text-gray-400">Complete investigation log and description</p>
                        </div>
                    </div>
                    <button @click="selectedReport = null" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content Details -->
                <template x-if="selectedReport">
                    <div class="space-y-4 mt-4">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Issue Summary</span>
                            <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 mt-0.5" x-text="selectedReport.summary"></h4>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-gray-50 dark:bg-gray-900/40 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                            <div>
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Reported Date</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1 inline-block" x-text="selectedReport.date"></span>
                            </div>

                            <div>
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Reported By</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1 inline-block" x-text="selectedReport.reportedBy"></span>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Status</span>
                                <span class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                      :class="selectedReport.status === 'Resolved'
                                          ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'
                                          : 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'"
                                      x-text="selectedReport.status">
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-1">Detailed Description</span>
                            <div class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-3.5 border border-gray-100 dark:border-gray-800 text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap break-words min-h-[70px]"
                                 x-text="selectedReport.details || 'No additional details logged.'">
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-between gap-3 pt-5 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" @click="selectedReport = null"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                        Close
                    </button>

                    <template x-if="selectedReport && selectedReport.status === 'Pending'">
                        <button @click="resolveReport"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Mark as Resolved</span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function reportsApp() {
            return {
                filters: {
                    reportedBy: '',
                    summary: '',
                    dateFrom: '',
                    dateTo: '',
                    status: ''
                },
                selectedReport: null,
                reports: [
                    {
                        id: 1,
                        date: '2025-10-25',
                        reportedBy: 'Zain',
                        summary: 'Payment not credited',
                        details: 'The counsellor did not receive payment for last session.',
                        status: 'Pending'
                    },
                    {
                        id: 2,
                        date: '2025-10-22',
                        reportedBy: 'Sara',
                        summary: 'Session connection issue',
                        details: 'Unable to connect to therapist during session time.',
                        status: 'Resolved'
                    },
                    {
                        id: 3,
                        date: '2025-10-20',
                        reportedBy: 'Ali',
                        summary: 'Invoice not visible',
                        details: 'Invoice for last session not showing up in dashboard.',
                        status: 'Pending'
                    },
                    {
                        id: 4,
                        date: '2025-10-18',
                        reportedBy: 'Hina',
                        summary: 'Refund delay',
                        details: 'Refund requested two days ago still pending.',
                        status: 'Resolved'
                    },
                    {
                        id: 5,
                        date: '2025-10-15',
                        reportedBy: 'Umer',
                        summary: 'Wrong session charge',
                        details: 'Charged twice for the same session.',
                        status: 'Pending'
                    }
                ],

                // Metrics
                get pendingReportsCount() {
                    return this.reports.filter(r => r.status === 'Pending').length;
                },
                get resolvedReportsCount() {
                    return this.reports.filter(r => r.status === 'Resolved').length;
                },
                get resolutionRate() {
                    return this.reports.length ? Math.round((this.resolvedReportsCount / this.reports.length) * 100) : 0;
                },

                // Filtered List
                get filteredReports() {
                    return this.reports.filter(r => {
                        const matchBy = (val, term) => (val || '').toLowerCase().includes((term || '').toLowerCase());
                        const reportDate = new Date(r.date + 'T12:00:00');
                        const from = this.filters.dateFrom ? new Date(this.filters.dateFrom + 'T00:00:00') : null;
                        const to = this.filters.dateTo ? new Date(this.filters.dateTo + 'T23:59:59') : null;

                        const inDateRange = (!from || reportDate >= from) && (!to || reportDate <= to);
                        const matchStatus = !this.filters.status || r.status === this.filters.status;

                        return (
                            (!this.filters.reportedBy || matchBy(r.reportedBy, this.filters.reportedBy)) &&
                            (!this.filters.summary || matchBy(r.summary, this.filters.summary)) &&
                            matchStatus &&
                            inDateRange
                        );
                    });
                },

                clearFilters() {
                    this.filters = {
                        reportedBy: '',
                        summary: '',
                        dateFrom: '',
                        dateTo: '',
                        status: ''
                    };
                },

                openReport(report) {
                    this.selectedReport = {
                        ...report
                    };
                },

                resolveReport() {
                    if (this.selectedReport) {
                        this.selectedReport.status = 'Resolved';
                        const idx = this.reports.findIndex(r => r.id === this.selectedReport.id);
                        if (idx !== -1) {
                            this.reports[idx].status = 'Resolved';
                        }
                        this.selectedReport = null;
                    }
                }
            };
        }
    </script>
</x-app1>
