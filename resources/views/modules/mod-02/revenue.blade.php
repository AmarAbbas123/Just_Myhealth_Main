<x-app1>

    <div class="px-6 mx-auto mt-6">

        <!-- Page Title -->
        <div class="mb-8">
            <x-page-header />
            
        </div>

        <!-- Revenue – All Time Section -->
        <div class="mb-8 p-6 bg-yellow-200 rounded-2xl border-4 border-yellow-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Revenue – All Time</h2>

            <div class="w-full grid grid-cols-3 gap-4">
                <!-- Total Revenue All Time -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Revenue</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $allTimeRevenue['total'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Registration Fee All Time -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Registration Fee's)</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $allTimeRevenue['registration_fees'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Session Fee All Time -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Session Fee's)</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $allTimeRevenue['session_fees'] ?? 'xx' }}</div>
                </div>
            </div>
        </div>

        <!-- Revenue – This Year Section -->
        <div class="mb-8 p-6 bg-green-100 rounded-2xl border-4 border-green-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Revenue – This Year</h2>
            
            <div class="w-full grid grid-cols-3 gap-4">
                <!-- Total Revenue This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Revenue</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $thisYearRevenue['total'] ?? 'xx' }}</div>
                </div>

                <!-- Counselling Registration Fee This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Registration Fee's)</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $thisYearRevenue['registration_fees'] ?? 'xx' }}</div>
                    
                </div>

                <!-- Counselling Session Fee This Year -->
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Counselling (Session Fee's)</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $thisYearRevenue['session_fees'] ?? 'xx' }}</div>
                    
                </div>
            </div>
        </div>

        

            

            

       

            <!-- This Year Session Credits Table -->
            
        

    </div>

</x-app1>
