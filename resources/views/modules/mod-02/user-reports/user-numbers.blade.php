<x-app1>

    @php
        $totalUsersCount = $totals['Total Users'] ?? 0;
        $grandTotal = $totalUsersCount > 0 ? $totalUsersCount : 1;
    @endphp

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />

            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                    <span class="w-2 h-2 rounded-full bg-[#1C9BA0] animate-pulse"></span>
                    <span>Last 90 Days Dynamic Feed</span>
                </span>
            </div>
        </div>

        <!-- Quick Summary Cards (Consistent with other admin pages) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <!-- Stat 1: Total Users -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Users</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-0.5">{{ number_format($totalUsersCount) }}</p>
                    <p class="text-[11px] text-gray-400">Registered platform accounts</p>
                </div>
            </div>

            <!-- Stat 2: Active User Types -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">User Classifications</p>
                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">
                        {{ count($totals) }} <span class="text-xs font-normal text-gray-400">defined types</span>
                    </p>
                    <p class="text-[11px] text-gray-400">Patient, Pro & Business tiers</p>
                </div>
            </div>

            <!-- Stat 3: Reporting Scope -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">System Architecture</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">MOD-02 System Reporting</p>
                    <p class="text-[11px] text-gray-400">User Numbers & Trend Metrics</p>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- USER NUMBERS DIRECTORY TABLE -->
        <!-- ===================== -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">User Numbers Directory</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Current registration numbers across all active user roles and classifications.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                        {{ number_format($totalUsersCount) }} Registered Users
                    </span>
                </div>
            </div>

            <!-- Mobile Horizontal Scroll Helper for Table -->
            <div class="sm:hidden px-4 py-2 bg-gray-50/80 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                    <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Swipe horizontally to view all columns</span>
                </span>
                <span class="font-mono text-gray-400">{{ count($totals) }} types</span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed min-w-[650px] lg:min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">
                            <th class="py-3.5 pl-4 sm:pl-6 pr-2 text-center w-12 sm:w-14">#</th>
                            <th class="py-3.5 px-4">User Type / Description</th>
                            <th class="py-3.5 px-4 text-center w-36">Segment</th>
                            <th class="py-3.5 px-4 text-right w-36">Count</th>
                            <th class="py-3.5 pr-4 sm:pr-6 pl-4 text-right w-44">Share of Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($totals as $label => $count)
                            @php
                                $isTotal = strtolower($label) === 'total users';
                                $percent = $grandTotal > 0 ? round(($count / $grandTotal) * 100, 1) : 0;
                                
                                $groupName = 'Platform Wide';
                                $badgeClass = 'bg-teal-50 text-teal-700 border-teal-200 dark:bg-teal-900/30 dark:text-teal-300 dark:border-teal-700/50';
                                $dotColor = 'bg-[#1C9BA0]';
                                
                                $low = strtolower($label);
                                if (str_contains($low, 'patient') || str_contains($low, 'standard') || str_contains($low, 'enhanced') || str_contains($low, 'discharged')) {
                                    $groupName = 'Patient';
                                    $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-700/50';
                                    $dotColor = 'bg-emerald-500';
                                } elseif (str_contains($low, 'professional') || str_contains($low, 'therapist') || str_contains($low, 'trainer') || str_contains($low, 'dietitian')) {
                                    $groupName = 'Professional';
                                    $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-700/50';
                                    $dotColor = 'bg-amber-500';
                                } elseif (str_contains($low, 'business') || str_contains($low, 'local') || str_contains($low, 'regional') || str_contains($low, 'national') || str_contains($low, 'global')) {
                                    $groupName = 'Business';
                                    $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-700/50';
                                    $dotColor = 'bg-indigo-500';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors {{ $isTotal ? 'bg-[#1C9BA0]/5 dark:bg-[#1C9BA0]/10 font-bold' : '' }}">
                                <td class="py-3.5 pl-4 sm:pl-6 pr-2 text-center text-xs font-mono text-gray-400">
                                    {{ $index++ }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-2 h-2 rounded-full {{ $dotColor }} shrink-0"></span>
                                        <span>{{ $label }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeClass }}">
                                        {{ $groupName }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right font-extrabold text-gray-900 dark:text-gray-100">
                                    {{ number_format($count) }}
                                </td>
                                <td class="py-3.5 pr-4 sm:pr-6 pl-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-16 sm:w-20 bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full {{ $dotColor }}" style="width: {{ min(100, $percent) }}%"></div>
                                        </div>
                                        <span class="text-xs font-mono text-gray-500 dark:text-gray-400 w-10 text-right">{{ $percent }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ===================== -->
        <!-- LINE CHARTS: 1 Graph Per Row (Optimized for Mobile & Desktop) -->
        <!-- ===================== -->
        <div class="space-y-6">

            <!-- Card 1: Patient Users -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow overflow-hidden">
                <!-- Card Header -->
                <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 leading-tight truncate">Patient Users</h3>
                            <p class="text-[11px] sm:text-xs text-gray-400 truncate">Standard, Enhanced & Discharged</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60 shrink-0">
                            Last 90 Days
                        </span>
                    </div>
                </div>

                <!-- Chart Container with Mobile Scroll Wrapper -->
                <div class="p-3 sm:p-5">
                    <!-- Mobile Swipe Helper -->
                    <div class="sm:hidden flex items-center justify-between text-[11px] text-gray-400 mb-2 px-1">
                        <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                            <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Swipe horizontally to view all 90 dates</span>
                        </span>
                        <span class="font-mono text-[10px] text-gray-400">90 Days</span>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible">
                        <div class="min-w-[700px] sm:min-w-full">
                            <div id="patientChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Professional Users -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow overflow-hidden">
                <!-- Card Header -->
                <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-4 6h16v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 leading-tight truncate">Professional Users</h3>
                            <p class="text-[11px] sm:text-xs text-gray-400 truncate">Therapists, Trainers & Dietitians</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60 shrink-0">
                            Last 90 Days
                        </span>
                    </div>
                </div>

                <!-- Chart Container with Mobile Scroll Wrapper -->
                <div class="p-3 sm:p-5">
                    <!-- Mobile Swipe Helper -->
                    <div class="sm:hidden flex items-center justify-between text-[11px] text-gray-400 mb-2 px-1">
                        <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                            <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Swipe horizontally to view all 90 dates</span>
                        </span>
                        <span class="font-mono text-[10px] text-gray-400">90 Days</span>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible">
                        <div class="min-w-[700px] sm:min-w-full">
                            <div id="professionalChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Business Users -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow overflow-hidden">
                <!-- Card Header -->
                <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-indigo-500/10 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 leading-tight truncate">Business Users</h3>
                            <p class="text-[11px] sm:text-xs text-gray-400 truncate">Local, Regional, National & Global</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60 shrink-0">
                            Last 90 Days
                        </span>
                    </div>
                </div>

                <!-- Chart Container with Mobile Scroll Wrapper -->
                <div class="p-3 sm:p-5">
                    <!-- Mobile Swipe Helper -->
                    <div class="sm:hidden flex items-center justify-between text-[11px] text-gray-400 mb-2 px-1">
                        <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                            <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Swipe horizontally to view all 90 dates</span>
                        </span>
                        <span class="font-mono text-[10px] text-gray-400">90 Days</span>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible">
                        <div class="min-w-[700px] sm:min-w-full">
                            <div id="businessChart"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const labels = @json($chartData['dates']);
            const isDark = document.documentElement.classList.contains('dark');

            function renderLineChart(el, series, colors) {
                const options = {
                    chart: {
                        type: 'area',
                        height: 290,
                        fontFamily: 'inherit',
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        parentHeightOffset: 0
                    },
                    colors: colors,
                    stroke: {
                        width: 2.2,
                        curve: 'smooth'
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.18,
                            opacityTo: 0.01,
                            stops: [0, 95, 100]
                        }
                    },
                    grid: {
                        borderColor: isDark ? '#374151' : '#F1F5F9',
                        strokeDashArray: 0,
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        padding: {
                            top: 0,
                            right: 8,
                            bottom: 0,
                            left: 8
                        }
                    },
                    markers: {
                        size: 0,
                        hover: {
                            size: 5,
                            strokeWidth: 2
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        type: 'category',
                        categories: labels,
                        labels: {
                            show: true,
                            rotate: -60,
                            rotateAlways: true,
                            hideOverlappingLabels: false,
                            trim: false,
                            style: {
                                colors: isDark ? '#9CA3AF' : '#64748B',
                                fontSize: '10px',
                                fontWeight: 500
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: true,
                            color: isDark ? '#4B5563' : '#E5E7EB'
                        }
                    },
                    yaxis: {
                        min: 0,
                        forceNiceScale: true,
                        labels: {
                            style: {
                                colors: isDark ? '#9CA3AF' : '#94A3B8',
                                fontSize: '11px',
                                fontWeight: 400
                            },
                            formatter: function(val) {
                                return Number.isInteger(val) ? val : Math.floor(val);
                            }
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        x: {
                            show: true
                        },
                        y: {
                            formatter: function(val) {
                                return val + (val === 1 ? ' user' : ' users');
                            }
                        }
                    },
                    series: series,
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        fontSize: '11px',
                        fontWeight: 500,
                        offsetY: -6,
                        markers: {
                            width: 7,
                            height: 7,
                            radius: 12
                        },
                        itemMargin: {
                            horizontal: 8,
                            vertical: 0
                        },
                        labels: {
                            colors: isDark ? '#D1D5DB' : '#64748B'
                        }
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            chart: {
                                height: 260
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'left',
                                offsetY: 0,
                                itemMargin: {
                                    horizontal: 6,
                                    vertical: 2
                                }
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }]
                };

                const chart = new ApexCharts(document.getElementById(el), options);
                chart.render().then(() => {
                    setTimeout(() => {
                        window.dispatchEvent(new Event('resize'));
                    }, 300);
                });
            }

            // -----------------------
            // Patient Chart
            // -----------------------
            renderLineChart('patientChart', [{
                    name: 'Standard',
                    data: @json($chartData['UserStandard'])
                },
                {
                    name: 'Enhanced',
                    data: @json($chartData['UserEnhanced'])
                },
                {
                    name: 'Discharged',
                    data: @json($chartData['UserDischarged'])
                },
            ], ['#1C9BA0', '#6366F1', '#EC4899']);

            // -----------------------
            // Professional Chart
            // -----------------------
            renderLineChart('professionalChart', [{
                    name: 'Therapist',
                    data: @json($chartData['Therapist'])
                },
                {
                    name: 'Trainer',
                    data: @json($chartData['Trainer'])
                },
                {
                    name: 'Dietitian',
                    data: @json($chartData['Dietitian'])
                },
            ], ['#F59E0B', '#10B981', '#6366F1']);

            // -----------------------
            // Business Chart
            // -----------------------
            renderLineChart('businessChart', [{
                    name: 'Local',
                    data: @json($chartData['BusinessLocal'])
                },
                {
                    name: 'Regional',
                    data: @json($chartData['BusinessRegional'])
                },
                {
                    name: 'National',
                    data: @json($chartData['BusinessNational'])
                },
                {
                    name: 'Global',
                    data: @json($chartData['BusinessGlobal'])
                },
            ], ['#6366F1', '#0EA5E9', '#1C9BA0', '#F43F5E']);

        });
    </script>

</x-app1>