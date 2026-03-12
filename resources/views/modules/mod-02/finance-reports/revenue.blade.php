<x-app1>

    <div class="px-4 sm:px-6 lg:px-8 mx-auto mt-6 max-w-7xl">

        <!-- Page Title -->
        <div class="mb-8">
            <x-page-header />
        </div>

        <!-- Revenue – All Time Section -->
        <div class="mb-8 p-6 bg-yellow-200 rounded-2xl border-4 border-yellow-400">

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Revenue – All Time</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Revenue</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['total'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Registration Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['registration_fees'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Session Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['session_fees'] ?? 'xx' }}
                    </div>
                </div>

            </div>


            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Physical Training</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['physical_training_registration'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Dietitian</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['dietitian_registration'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Local</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['business_local_registration'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Regional</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['business_regional_registration'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - National</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['business_national_registration'] ?? 'xx' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Global</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $allTimeRevenue['business_global_registration'] ?? 'xx' }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Revenue – This Year Section -->
        <div class="mb-8 p-6 bg-green-100 rounded-2xl border-4 border-green-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Revenue – This Year</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Total Revenue This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Revenue</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['total'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Registration Fee This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Registration Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['registration_fees'] ?? 'xx' }}</div>

                </div>

                <!-- Counselling Session Fee This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Session Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['session_fees'] ?? 'xx' }}</div>

                </div>
            </div>

            <!-- Additional Registration Fee Items (This Year) -->
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Physical Training (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['physical_training_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Dietitian (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['dietitian_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Local (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['business_local_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Regional (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['business_regional_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - National (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['business_national_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Global (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">
                        {{ $thisYearRevenue['business_global_registration'] ?? 'xx' }}</div>
                </div>
            </div>
        </div>




        <!-- SUMMARY CARDS -->

        <div class="mb-6 w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white rounded-lg p-4 shadow border-l-4 border-green-500">
                <div class="text-sm font-semibold text-gray-700">Net Revenue</div>
                <div class="text-2xl font-bold text-green-700">
                    {{ $allTimeRevenue['total'] ?? 'xx' }}
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow border-l-4 border-teal-500">
                <div class="text-sm font-semibold text-gray-700">Payments Made</div>
                <div class="text-2xl font-bold text-teal-700">
                    {{ $thisYearRevenue['total'] ?? 'xx' }}
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow border-l-4 border-red-500">
                <div class="text-sm font-semibold text-gray-700">Payments Owed</div>

                @php
                    $allTime = $dataSource['all_time']['total_calculation'] ?? 0;
                    $thisYear = $dataSource['this_year']['total_calculation'] ?? 0;
                    $owed = $allTime - $thisYear;
                @endphp

                <div class="text-2xl font-bold text-red-700">
                    {{ '£' . number_format($owed, 2) }}
                </div>

            </div>

            <div class="bg-white rounded-lg p-4 shadow border-l-4 border-violet-500">
                <div class="text-sm font-semibold text-gray-700">Future Sessions</div>
                <div class="text-2xl font-bold text-violet-700">
                    £0.00
                </div>
            </div>

        </div>

        <!-- CHARTS -->

        <div class="mt-10 mb-10 grid grid-cols-1 lg:grid-cols-1 gap-6 w-full">

            <div class="bg-white border rounded-2xl shadow p-4 pr-6 w-full overflow-hidden">
                <div class="mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">Revenue (Monthly)</h2>
                    <p class="text-sm text-gray-500">Professional vs Business vs Session fees</p>
                </div>
                <div id="chart-revenue-monthly" class="w-full min-h-[340px]"></div>
            </div>

            <div class="bg-white border rounded-2xl shadow p-4 pr-6 w-full overflow-hidden">
                <div class="mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">Revenue (Weekly)</h2>
                    <p class="text-sm text-gray-500">Professional vs Business vs Session fees</p>
                </div>
                <div id="chart-revenue-weekly" class="w-full min-h-[340px]"></div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const combined = @json($combinedCharts ?? []);

    const monthly = combined.monthly || { labels: [], professional: [], business: [], session: [] };
    const weekly  = combined.weekly  || { labels: [], professional: [], business: [], session: [] };

    const money = (val) => '£' + Number(val || 0).toFixed(2);

    /* MONTHLY CHART */
    const monthlyChart = new ApexCharts(
        document.querySelector("#chart-revenue-monthly"),
        {
            chart: {
                type: 'bar',
                height: 340,
                width: '100%'
            },
            series: [
                { name: "Professional Registration Fee's", data: monthly.professional },
                { name: "Business Registration Fee's", data: monthly.business },
                { name: "Session Fee's", data: monthly.session }
            ],
            plotOptions: {
                bar: {
                    columnWidth: '55%',
                    borderRadius: 4
                }
            },
            dataLabels: { enabled: false },
            xaxis: { categories: monthly.labels },
            yaxis: {
                labels: {
                    formatter: (v) => '£' + Number(v).toFixed(0)
                }
            },
            tooltip: {
                y: { formatter: money }
            },
            legend: { position: 'bottom' }
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
                height: 340,
                width: '100%'
            },
            series: [
                { name: "Professional Registration Fee's", data: weekly.professional },
                { name: "Business Registration Fee's", data: weekly.business },
                { name: "Session Fee's", data: weekly.session }
            ],
            plotOptions: {
                bar: {
                    columnWidth: '60%',
                    borderRadius: 3
                }
            },
            dataLabels: { enabled: false },
            xaxis: { categories: weekly.labels },
            yaxis: {
                labels: {
                    formatter: (v) => '£' + Number(v).toFixed(0)
                }
            },
            tooltip: {
                y: { formatter: money }
            },
            legend: { position: 'bottom' }
        }
    );

    weeklyChart.render();


    /* 🔥 FIX FOR OVERFLOW */
    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 400);

});
</script>

    </div>

</x-app1>
