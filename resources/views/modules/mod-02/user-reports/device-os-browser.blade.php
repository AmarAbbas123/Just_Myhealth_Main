<x-app1>
    <div x-data="chartsDashboard()" x-init="init()" class="px-6 py-6">
        <x-page-header />

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 border rounded-xl p-4">
                <div id="chart-user-type" class="min-h-[260px] w-full"></div>
            </div>

            <div class="bg-white dark:bg-gray-800 border rounded-xl p-4">
                <div id="chart-device-type" class="min-h-[260px]"></div>
            </div>

            <div class="bg-white dark:bg-gray-800 border rounded-xl p-4">
                <div id="chart-device-os" class="min-h-[260px]"></div>
            </div>

            <div class="bg-white dark:bg-gray-800 border rounded-xl p-4">
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

                async init() {
                    if (this.initialized) return;
                    this.initialized = true;

                    this.$nextTick(async () => {
                        await this.loadCharts();

                        this.refreshTimer = setInterval(() => {
                            this.loadCharts(true);
                        }, 30000);
                    });
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
                                height: 260
                            },
                            labels: dataset.labels,
                            series: dataset.series,
                            legend: {
                                position: 'bottom'
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '70%',
                                        labels: {
                                            show: true,
                                            total: {
                                                show: true,
                                                label: title,
                                                formatter: () => total
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    );

                    chart.render().then(() => {
                        setTimeout(() => {
                            window.dispatchEvent(new Event('resize'));
                        }, 0);
                    });
                    this.charts[el] = chart;
                }
            };
        };
    </script>

</x-app1>
