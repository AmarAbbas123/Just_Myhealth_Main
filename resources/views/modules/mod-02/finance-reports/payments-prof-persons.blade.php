<x-app1>

    <div class="px-4 sm:px-6 lg:px-8 mx-auto mt-6 max-w-7xl">

        <!-- Page Title -->
        <div class="mb-8">
            <x-page-header />
        </div>

        <!-- Payments – All Time -->
        <div class="mb-8 p-6 bg-yellow-200 rounded-2xl border-4 border-yellow-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payments – All Time</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Payments</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTime['total'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Type 30)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTime['type30'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Physical Training (Type 31)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTime['type31'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Dietitian (Type 32)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTime['type32'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments – This Year -->
        <div class="mb-8 p-6 bg-green-100 rounded-2xl border-4 border-green-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payments – This Year</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Payments</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYear['total'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Type 30)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYear['type30'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Physical Training (Type 31)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYear['type31'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Dietitian (Type 32)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYear['type32'] ?? 'GBP: £0.00' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Chart (This Year) -->
        <div class="mt-10 mb-10 grid grid-cols-1 lg:grid-cols-1 gap-6 w-full">
            <div class="bg-white border rounded-2xl shadow p-4 pr-6 w-full overflow-hidden">
                <div class="mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">Payments (Monthly)</h2>
                    <p class="text-sm text-gray-500">
                        Counselling vs Physical Training vs Dietitian
                        @if (!empty($chart['range']))
                            <span class="text-gray-400">({{ $chart['range'] }})</span>
                        @endif
                    </p>
                </div>
                <div id="chart-payments-monthly" class="w-full min-h-[340px]"></div>
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

            const money = (val) => '£' + Number(val || 0).toFixed(2);

            const monthlyChart = new ApexCharts(
                document.querySelector("#chart-payments-monthly"), {
                    chart: {
                        type: 'bar',
                        height: 340,
                        width: '100%'
                    },
                    series: [{
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
                            columnWidth: '55%',
                            borderRadius: 4
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: labels
                    },
                    yaxis: {
                        labels: {
                            formatter: (v) => '£' + Number(v).toFixed(0)
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: money
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            );

            monthlyChart.render();

            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 400);

        });
    </script>

</x-app1>