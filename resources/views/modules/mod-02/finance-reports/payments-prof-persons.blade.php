<x-app1>

    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Page Title -->
        <div class="flex items-center justify-between">
            <x-page-header />
        </div>

        <!-- Payments – All Time -->
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
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Payments – All Time</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-500/20">
                    Lifetime: {{ $allTime['total'] ?? 'GBP: £0.00' }}
                </span>
            </div>

            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Payments -->
                    <div class="bg-gradient-to-br from-amber-50/80 to-amber-100/40 dark:from-amber-950/20 dark:to-gray-800 rounded-2xl p-5 border border-amber-200/80 dark:border-amber-700/40 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-300">Total Payments</span>
                            <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $allTime['total'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>

                    <!-- Counselling (Type 30) -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Counselling (Type 30)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1C9BA0]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $allTime['type30'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>

                    <!-- Physical Training (Type 31) -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Physical Training (Type 31)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#6366F1]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $allTime['type31'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>

                    <!-- Dietitian (Type 32) -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Dietitian (Type 32)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $allTime['type32'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Payments – This Year -->
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
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Payments – This Year ({{ date('Y') }})</h2>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20">
                    This Year: {{ $thisYear['total'] ?? 'GBP: £0.00' }}
                </span>
            </div>

            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Payments -->
                    <div class="bg-gradient-to-br from-emerald-50/80 to-emerald-100/40 dark:from-emerald-950/20 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200/80 dark:border-emerald-700/40 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300">Total Payments</span>
                            <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $thisYear['total'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>

                    <!-- Counselling (Type 30) -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Counselling (Type 30)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1C9BA0]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $thisYear['type30'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>

                    <!-- Physical Training (Type 31) -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Physical Training (Type 31)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#6366F1]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $thisYear['type31'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>

                    <!-- Dietitian (Type 32) -->
                    <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/60 shadow-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Dietitian (Type 32)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span>
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-1">
                            {{ $thisYear['type32'] ?? 'GBP: £0.00' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Monthly Chart (This Year) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-shadow overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Payments (Monthly)</h3>
                </div>
                @if (!empty($chart['range']))
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 dark:bg-gray-700/60 text-gray-500 dark:text-gray-300 border border-gray-100 dark:border-gray-600/60">
                        {{ $chart['range'] }}
                    </span>
                @endif
            </div>

            <div class="p-3 sm:p-5 w-full min-w-0">
                <div id="chart-payments-monthly" class="w-full min-w-0"></div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const chart = @json($chart ?? []);
            const labels = chart.labels || [];
            const type30 = chart.type30 || [];
            const type31 = chart.type31 || [];
            const type32 = chart.type32 || [];
            const isDark = document.documentElement.classList.contains('dark');

            const money = (val) => '£' + Number(val || 0).toFixed(2);

            const monthlyChart = new ApexCharts(
                document.querySelector("#chart-payments-monthly"), {
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
                        {
                            name: "Counselling (Type 30)",
                            data: type30
                        },
                        {
                            name: "Physical Training (Type 31)",
                            data: type31
                        },
                        {
                            name: "Dietitian (Type 32)",
                            data: type32
                        }
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
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: labels,
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
                        y: {
                            formatter: money
                        }
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

            window.addEventListener('resize', function () {
                if (typeof monthlyChart !== 'undefined') monthlyChart.resize();
            });

            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 300);

        });
    </script>

</x-app1>