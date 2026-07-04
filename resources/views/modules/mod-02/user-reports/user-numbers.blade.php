<x-app1>

    <div class="px-6 mx-auto mt-6">

        <!-- Header -->
        <div class="flex justify-between mb-6">
            <x-page-header />
        </div>

        <!-- ===================== -->
        <!-- HERO STAT BAND -->
        <!-- ===================== -->
        <div class="relative overflow-hidden rounded-3xl mb-8 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0B2B2E] via-[#124F52] to-[#1C9BA0]"></div>
            <div class="pointer-events-none absolute -top-16 -right-10 h-64 w-64 rounded-full bg-[#2DD4BF]/30 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-[#F59E0B]/20 blur-3xl"></div>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.07)_1px,transparent_0)] [background-size:22px_22px]"></div>

            <div class="relative grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 p-6">
                @php
                    // Match the icon (and its accent color) to what the label actually says,
                    // instead of cycling through icons arbitrarily. Falls back to a generic
                    // "layers" icon + teal if a label doesn't match any keyword below.
                    $iconRules = [
                        'patient'      => ['M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z', '#2DD4BF'], // users
                        'therapist'    => ['M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-4 6h16v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8z', '#F59E0B'], // briefcase
                        'professional' => ['M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-4 6h16v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8z', '#F59E0B'], // briefcase
                        'trainer'      => ['M13 10V3L4 14h7v7l9-11h-7z', '#4ADE80'], // bolt
                        'dietitian'    => ['M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', '#F472B6'], // heart
                        'business'     => ['M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6', '#818CF8'], // building
                        'local'        => ['M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6', '#818CF8'], // building
                        'regional'     => ['M12 21c-4.418-3.06-7-6.5-7-10a7 7 0 1114 0c0 3.5-2.582 6.94-7 10z', '#38BDF8'], // map pin
                        'national'     => ['M3 12h18M12 3c2.5 2.7 4 6.2 4 9s-1.5 6.3-4 9c-2.5-2.7-4-6.2-4-9s1.5-6.3 4-9z', '#818CF8'], // globe
                        'global'       => ['M3 12h18M12 3c2.5 2.7 4 6.2 4 9s-1.5 6.3-4 9c-2.5-2.7-4-6.2-4-9s1.5-6.3 4-9z', '#38BDF8'], // globe
                        'discharged'   => ['M5 13l4 4L19 7', '#4ADE80'], // check
                        'enhanced'     => ['M13 10V3L4 14h7v7l9-11h-7z', '#F59E0B'], // bolt
                        'standard'     => ['M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6-4a4 4 0 11-8 0 4 4 0 018 0z', '#2DD4BF'], // users
                    ];
                    $defaultIcon = ['M4 6h16M4 12h16M4 18h16', '#2DD4BF']; // layers/list fallback
                @endphp
                @foreach ($totals as $label => $count)
                    @php
                        $match = $defaultIcon;
                        foreach ($iconRules as $keyword => $rule) {
                            if (str_contains(strtolower($label), $keyword)) {
                                $match = $rule;
                                break;
                            }
                        }
                        [$icon, $tint] = $match;
                    @endphp
                    <div class="group rounded-2xl border border-white/10 bg-white/10 backdrop-blur-md p-4 transition duration-200 hover:bg-white/15 hover:-translate-y-0.5">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg mb-3"
                            style="background-color: {{ $tint }}26;">
                            <svg class="h-5 w-5" style="color: {{ $tint }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}" />
                            </svg>
                        </span>
                        <div class="text-2xl font-bold text-white leading-none">{{ $count }}</div>
                        <div class="text-[11px] font-medium uppercase tracking-wider text-white/60 mt-2">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ===================== -->
        <!-- LINE CHARTS -->
        <!-- ===================== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Standard / Enhanced / Discharged -->
            <div class="relative bg-white p-5 pt-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#1C9BA0] to-[#6366F1]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#1C9BA0]/10 text-[#1C9BA0]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 leading-tight">Patient Users</h2>
                        <p class="text-xs text-slate-400">Last 90 days</p>
                    </div>
                </div>
                <div id="patientChart" class="mt-2"></div>
            </div>

            <!-- Professionals -->
            <div class="relative bg-white p-5 pt-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#F59E0B] to-[#F472B6]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F59E0B]/10 text-[#F59E0B]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-4 6h16v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 leading-tight">Professional Users</h2>
                        <p class="text-xs text-slate-400">Last 90 days</p>
                    </div>
                </div>
                <div id="professionalChart" class="mt-2"></div>
            </div>

            <!-- Business -->
            <div class="relative bg-white p-5 pt-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden ">
                <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#818CF8] to-[#38BDF8]"></span>
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#818CF8]/10 text-[#818CF8]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800 leading-tight">Business Users</h2>
                        <p class="text-xs text-slate-400">Last 90 days</p>
                    </div>
                </div>
                <div id="businessChart" class="mt-2"></div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const labels = @json($chartData['dates']);

            function renderLineChart(el, series, colors) {
                const options = {
                    chart: {
                        type: 'line',
                        height: 300,
                        fontFamily: 'inherit',
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors: colors,
                    stroke: {
                        width: 3,
                        curve: 'smooth'
                    },
                    // No gradient/area fill here on purpose — with several series sitting
                    // close to 0, a semi-transparent fill sat right on top of the thin lines
                    // and muddied their color. Plain, fully-opaque lines stay crisp and match
                    // the legend dots exactly.
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    grid: {
                        borderColor: '#e8e8e8',
                        
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
                            left: 8,
                            right: 8
                        }
                    },
                    markers: {
                        size: 0,
                        hover: {
                            size: 6
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: labels,
                        labels: {
                            style: {
                                colors: '#0a0f16',
                                fontSize: '11px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#94A3B8',
                                fontSize: '11px'
                            }
                        }
                    },
                    tooltip: {
                        theme: 'light'
                    },
                    series: series,
                    legend: {
                        position: 'top',
                        horizontalAlign: 'left',
                        fontSize: '11px',
                        fontWeight: 700,
                        markers: {
                            width: 9,
                            height: 9,
                            radius: 3
                        },
                        itemMargin: {
                            horizontal: 10
                        },
                        labels: {
                            colors: '#64748B'
                        }
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
            ], ['#1C9BA0', '#6366F1', '#F472B6']);

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
            ], ['#F59E0B', '#F472B6', '#818CF8']);

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
            ], ['#818CF8', '#38BDF8', '#1C9BA0', '#F472B6']);

        });
    </script>


</x-app1>