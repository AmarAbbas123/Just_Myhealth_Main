<x-app1>

    <div class="px-6 mx-auto mt-6">
 
        <!-- Page Title -->
        <div class="mb-8">
            <x-page-header />
        </div>

        <!-- Summary Cards (Single-line summary) -->
        <div class="mb-8 w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-green-500">
                <div class="text-sm font-semibold text-gray-700">Total All Time</div>
                <div class="text-2xl font-bold text-green-700">{{ $allTime['total'] ?? 'GBP: £0.00' }}</div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-teal-500">
                <div class="text-sm font-semibold text-gray-700">Total This Year</div>
                <div class="text-2xl font-bold text-teal-700">{{ $thisYear['total'] ?? 'GBP: £0.00' }}</div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-gray-500">
                <div class="text-sm font-semibold text-gray-700">Record Count (All Time)</div>
                <div class="text-2xl font-bold text-gray-700">{{ $recordsAll->count() ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow text-left border-l-4 border-blue-500">
                <div class="text-sm font-semibold text-gray-700">Record Count (This Year)</div>
                <div class="text-2xl font-bold text-blue-700">{{ $recordsThisYear->count() ?? 0 }}</div>
            </div>
        </div>

        <!-- Professional Persons Payments – All Time -->
        <div class="mb-8 p-6 bg-yellow-200 rounded-2xl border-4 border-yellow-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Professional Persons Payments – All Time</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-7 gap-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Debits</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $allTime['total'] ?? 'GBP: £0.00' }}</div>
                </div>
                @foreach(['Compute','Services Plugins','SW Dev','SW Support','Security Services','Misc'] as $cat)
                    @php $key = strtolower(str_replace(' ', '_', $cat)); @endphp
                    <div class="bg-white rounded-lg p-4 shadow text-center">
                        <div class="text-sm font-semibold text-gray-700 mb-2">{{ $cat }}</div>
                        <div class="text-2xl font-semibold text-gray-900">{{ $allTime[$key] ?? 'GBP: £0.00' }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Professional Persons Payments – This Year -->
        <div class="mb-8 p-6 bg-green-100 rounded-2xl border-4 border-green-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Professional Persons Payments – This Year</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-7 gap-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Debits (YTD)</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $thisYear['total'] ?? 'GBP: £0.00' }}</div>
                </div>
                @foreach(['Compute','Services Plugins','SW Dev','SW Support','Security Services','Misc'] as $cat)
                    @php $key = strtolower(str_replace(' ', '_', $cat)); @endphp
                    <div class="bg-white rounded-lg p-4 shadow text-center">
                        <div class="text-sm font-semibold text-gray-700 mb-2">{{ $cat }}</div>
                        <div class="text-2xl font-semibold text-gray-900">{{ $thisYear[$key] ?? 'GBP: £0.00' }}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</x-app1>