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
                <!-- Total Revenue All Time -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Tal Revenue</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">{{ $allTimeRevenue['total'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Registration Fee All Time -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Registration Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">{{ $allTimeRevenue['registration_fees'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Session Fee All Time -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Session Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">{{ $allTimeRevenue['session_fees'] ?? 'xx' }}</div>
                </div>
            </div>

            <!-- Additional Registration Fee Items (All Time) -->
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Physical Training (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $allTimeRevenue['physical_training_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Dietitian (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $allTimeRevenue['dietitian_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Local (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $allTimeRevenue['business_local_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Regional (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $allTimeRevenue['business_regional_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - National (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $allTimeRevenue['business_national_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Global (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $allTimeRevenue['business_global_registration'] ?? 'xx' }}</div>
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
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">{{ $thisYearRevenue['total'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Registration Fee This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Registration Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">{{ $thisYearRevenue['registration_fees'] ?? 'xx' }}</div>
                    
                </div>

                <!-- Counselling Session Fee This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Session Fee's)</div>
                    <div class="text-2xl sm:text-3xl font-semibold text-gray-900">{{ $thisYearRevenue['session_fees'] ?? 'xx' }}</div>
                    
                </div>
            </div>

            <!-- Additional Registration Fee Items (This Year) -->
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Physical Training (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $thisYearRevenue['physical_training_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Dietitian (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $thisYearRevenue['dietitian_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Local (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $thisYearRevenue['business_local_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Regional (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $thisYearRevenue['business_regional_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - National (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $thisYearRevenue['business_national_registration'] ?? 'xx' }}</div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Business - Global (Registration Fee's)</div>
                    <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $thisYearRevenue['business_global_registration'] ?? 'xx' }}</div>
                </div>
            </div>
        </div>

        

            

            

       

        <!-- Top Summary Cards -->
        <div class="mb-6 w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-green-500">
                <div class="text-sm font-semibold text-gray-700">Net Revenue (All Time)</div>
                <div class="text-2xl font-bold text-green-700">{{ $allTimeRevenue['total'] ?? 'xx' }}</div>
                <div class="text-xs text-gray-500 mt-1">Total earnings after platform fee's</div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-teal-500">
                <div class="text-sm font-semibold text-gray-700">Payments Made (This Year)</div>
                <div class="text-2xl font-bold text-teal-700">{{ $thisYearRevenue['total'] ?? (isset($dataSource['this_year']['total_calculation']) ? 'GBP: £' . number_format($dataSource['this_year']['total_calculation'], 2) : 'xx') }}</div>
                <div class="text-xs text-gray-500 mt-1">Payments processed this year</div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-red-500">
                <div class="text-sm font-semibold text-gray-700">Payments Owed</div>
                <div class="text-2xl font-bold text-red-700">
                    @php
                        $allTime = $dataSource['all_time']['total_calculation'] ?? 0;
                        $thisYear = $dataSource['this_year']['total_calculation'] ?? 0;
                        $owed = $allTime - $thisYear;
                    @endphp
                    {{ 'GBP: £' . number_format($owed, 2) }}
                </div>
                <div class="text-xs text-gray-500 mt-1">Pending transfer (Month End)</div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-violet-500">
                <div class="text-sm font-semibold text-gray-700">Future sessions</div>
                <div class="text-2xl font-bold text-violet-700">{{ 'GBP: £' . number_format(0, 2) }}</div>
                <div class="text-xs text-gray-500 mt-1">Value of future booked sessions</div>
            </div>
        </div>

            <!-- This Year Session Credits Table -->


    </div>

</x-app1>