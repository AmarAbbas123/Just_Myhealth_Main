<x-app1>

    <div class="px-6 mx-auto mt-6">

        <!-- Header -->
        <div class="flex justify-between mb-6">
            <x-page-header />
        </div>

        <!-- ===================== -->
        <!-- TOP ORANGE BOXES -->
        <!-- ===================== -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            @foreach ($totals as $label => $count)
                <div class="bg-[#f9bc06] text-black rounded-xl p-4 shadow">
                    <div class="text-sm uppercase">{{ $label }}</div>
                    <div class="text-2xl font-bold mt-1">{{ $count }}</div>
                </div>
            @endforeach
        </div>

        <!-- ===================== -->
        <!-- LINE CHARTS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Standard / Enhanced / Discharged -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold mb-2">Patient Users (Last 90 Days)</h2>
                <div id="patientChart"></div>
            </div>

            <!-- Professionals -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold mb-2">Professional Users (Last 90 Days)</h2>
                <div id="professionalChart"></div>
            </div>

            <!-- Business -->
            <div class="bg-white p-4 rounded shadow ">
                <h2 class="font-semibold mb-2">Business Users (Last 90 Days)</h2>
                <div id="businessChart"></div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const labels = @json($chartData['dates']);

            function renderLineChart(el, series) {
                const options = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    xaxis: {
                        categories: labels
                    },
                    series: series,
                    legend: {
                        position: 'top'
                    }
                };

                const chart = new ApexCharts(document.getElementById(el), options);
                chart.render();
                chart.render().then(() => {
                    // wait for sidebar + layout transitions
                    setTimeout(() => {
                        window.dispatchEvent(new Event('resize'));
                    }, 350);
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
            ]);

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
            ]);

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
            ]);

        });
    </script>


</x-app1>
