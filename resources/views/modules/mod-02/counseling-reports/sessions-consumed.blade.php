<x-app1>
    <div class="px-6 py-6">
        <x-page-header />

        <div class="grid gap-6 mb-8">
            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Sessions Consumed per day over the previous 30 days</h2>
                <div id="chart-sessions-daily" style="width:100%; min-height:340px;"></div>
            </div>

            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Sessions Consumed per week over the previous 365 days</h2>
                <div id="chart-sessions-weekly" style="width:100%; min-height:380px;"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dailyLabels  = @json($dailyLabels);
            const dailyData    = @json($dailyData);
            const weeklyLabels = @json($weeklyLabels);
            const weeklyData   = @json($weeklyData);

            const dailyOptions = {
                chart: {
                    type: 'bar',
                    height: 340,
                    width: '100%',
                    parentHeightOffset: 0,
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    zoom: { enabled: false },
                    
                },
                plotOptions: {
                    bar: { borderRadius: 4, columnWidth: '55%' }
                },
                dataLabels: { enabled: false },
                series: [{ name: 'Sessions', data: dailyData }],
                xaxis: {
                    categories: dailyLabels,
                    labels: {
                        rotate: -45,
                        hideOverlappingLabels: true,
                        trim: true,
                    },
                    tickPlacement: 'on',
                },
                yaxis: {
                    title: { text: 'Number of Sessions' }
                },
                tooltip: {
                    y: { formatter: value => `${value} session${value === 1 ? '' : 's'}` }
                },
                grid: {
                    padding: { right: 20 }
                }
            };

            const weeklyOptions = {
                chart: {
                    type: 'bar',
                    height: 380,
                    width: '100%',
                    parentHeightOffset: 0,
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: { show: false },
                },
                plotOptions: {
                    bar: { borderRadius: 4, columnWidth: '55%' }
                },
                dataLabels: { enabled: false },
                series: [{ name: 'Sessions', data: weeklyData }],
                xaxis: {
                    categories: weeklyLabels,
                    labels: {
                        rotate: -45,
                        hideOverlappingLabels: true,
                        trim: true,
                    },
                    tickPlacement: 'on',
                },
                yaxis: {
                    title: { text: 'Number of Sessions' }
                },
                tooltip: {
                    y: { formatter: value => `${value} session${value === 1 ? '' : 's'}` }
                },
                grid: {
                    padding: { right: 20 }
                }
            };

            // Initial render
            let dailyChart  = new ApexCharts(document.getElementById('chart-sessions-daily'), dailyOptions);
            let weeklyChart = new ApexCharts(document.getElementById('chart-sessions-weekly'), weeklyOptions);

            dailyChart.render();
            weeklyChart.render();

            // Destroy and re-render after layout settles (fixes sidebar width issue)
            setTimeout(() => {
                dailyChart.destroy();
                weeklyChart.destroy();

                dailyChart  = new ApexCharts(document.getElementById('chart-sessions-daily'), dailyOptions);
                weeklyChart = new ApexCharts(document.getElementById('chart-sessions-weekly'), weeklyOptions);

                dailyChart.render();
                weeklyChart.render();
            }, 300);
        });
    </script>
</x-app1>