<x-app1>
    <div x-data="chartsDashboard()" x-init="init()" class="px-6 py-6">
        <x-page-header />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden p-5 pt-6">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#1C9BA0] to-[#6366F1]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#1C9BA0]/10 text-[#1C9BA0]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 dark:text-gray-100 leading-tight">User Types</h2>
                        <p class="text-xs text-slate-400 dark:text-gray-400">Live breakdown</p>
                    </div>
                </div>
                <div id="chart-user-type" class="min-h-[260px]"></div>
            </div>

            <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden p-5 pt-6">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#F59E0B] to-[#F472B6]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F59E0B]/10 text-[#F59E0B]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 dark:text-gray-100 leading-tight">Device Types</h2>
                        <p class="text-xs text-slate-400 dark:text-gray-400">Live breakdown</p>
                    </div>
                </div>
                <div id="chart-device-type" class="min-h-[260px]"></div>
            </div>

            <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden p-5 pt-6">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#818CF8] to-[#38BDF8]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#818CF8]/10 text-[#818CF8]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082M9.75 3.104a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-5.16-.184L5 14.5m14.8.8l1.399 1.4c1.019 1.02.317 2.76-1.117 2.76H4.918c-1.434 0-2.136-1.74-1.117-2.76L5 14.5" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 dark:text-gray-100 leading-tight">Device OS</h2>
                        <p class="text-xs text-slate-400 dark:text-gray-400">Live breakdown</p>
                    </div>
                </div>
                <div id="chart-device-os" class="min-h-[260px]"></div>
            </div>

            <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden p-5 pt-6">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#4ADE80] to-[#1C9BA0]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#4ADE80]/10 text-[#4ADE80]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M12 3c2.5 2.7 4 6.2 4 9s-1.5 6.3-4 9c-2.5-2.7-4-6.2-4-9s1.5-6.3 4-9z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 dark:text-gray-100 leading-tight">Browsers</h2>
                        <p class="text-xs text-slate-400 dark:text-gray-400">Live breakdown</p>
                    </div>
                </div>
                <div id="chart-device-browser" class="min-h-[260px]"></div>
            </div>
        </div>
    </div>


    <script>
        window.chartsDashboard = function() {
            return {
                charts: {},
                refreshTimer: null,
                initialized: false,

                // One shared, brand-consistent palette so slice colors stay predictable
                // across all four donuts (teal-led, same family used across the app).
                palette: ['#1C9BA0', '#6366F1', '#F59E0B', '#F472B6', '#818CF8', '#38BDF8', '#4ADE80', '#94A3B8'],

                async init() {
                    if (this.initialized) return; // 🔒 prevent double init
                    this.initialized = true;

                    await this.loadCharts();

                    // 🔁 auto refresh every 30s (only once)
                    this.refreshTimer = setInterval(() => {
                        this.loadCharts(true);
                    }, 30000);
                },

                async loadCharts(update = false) {
                    const res = await fetch('/mod-02/user-reports/device-os-browser/data');
                    const data = await res.json();

                    this.draw('chart-user-type', data.userType, 'User Types', update);
                    this.draw('chart-device-type', data.deviceType, 'Device Types', update);
                    this.draw('chart-device-os', data.deviceOS, 'Device OS', update);
                    this.draw('chart-device-browser', data.deviceBrowser, 'Browsers', update);
                },

                draw(el, dataset, title, update) {
                    const total = dataset.series.reduce((a, b) => a + b, 0);

                    // 🔄 update only
                    if (update && this.charts[el]) {
                        this.charts[el].updateSeries(dataset.series);
                        return;
                    }

                    // 🧹 destroy old chart if exists
                    if (this.charts[el]) {
                        this.charts[el].destroy();
                        delete this.charts[el];
                    }

                    const chart = new ApexCharts(
                        document.getElementById(el), {
                            chart: {
                                type: 'donut',
                                height: 260,
                                fontFamily: 'inherit'
                            },
                            colors: this.palette,
                            labels: dataset.labels,
                            series: dataset.series,
                            stroke: {
                                width: 2,
                                colors: ['#ffffff']
                            },
                            dataLabels: {
                                style: {
                                    fontSize: '9px',
                                    fontWeight: 600
                                },
                                dropShadow: {
                                    enabled: false
                                }
                            },
                            tooltip: {
                                theme: 'light'
                            },
                            legend: {
                                position: 'bottom',
                                fontSize: '11px',
                                fontWeight: 600,
                                labels: {
                                    colors: '#64748B'
                                },
                                markers: {
                                    width: 8,
                                    height: 8,
                                    radius: 3
                                },
                                itemMargin: {
                                    horizontal: 8,
                                    vertical: 2
                                }
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '72%',
                                        labels: {
                                            show: true,
                                            value: {
                                                fontSize: '18px',
                                                fontWeight: 700,
                                                color: '#0F172A'
                                            },
                                            total: {
                                                show: true,
                                                label: title,
                                                fontSize: '11px',
                                                color: '#94A3B8',
                                                formatter: () => total
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    );

                    chart.render();
                    this.charts[el] = chart;
                }
            };
        };
    </script>

</x-app1>