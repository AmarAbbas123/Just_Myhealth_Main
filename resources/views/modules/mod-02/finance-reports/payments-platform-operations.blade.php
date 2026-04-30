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

        <!-- Platform Operations – All Time -->
        <div class="mb-8 p-6 bg-yellow-200 rounded-2xl border-4 border-yellow-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Platform Operations Costs – All Time</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Operations Cost</div>
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

        <!-- Platform Operations – This Year -->
        <div class="mb-8 p-6 bg-green-100 rounded-2xl border-4 border-green-400">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Platform Operations Costs – This Year</h2>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4 shadow text-center">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Total Operations Cost (YTD)</div>
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

        <!-- Detailed Table (All Time) -->
        

        <!-- DB Table View (Read Only): sys_finance_platform_operation_costs -->
        <div class="mt-10 mb-10 bg-white border rounded-2xl shadow">
            
            <!-- Mobile cards -->
            <div class="md:hidden p-4 space-y-3">
                @forelse(($recordsAll ?? collect()) as $row)
                    <div class="border rounded-xl p-4 bg-white shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $row->ServiceCategory ?? '' }}
                                </div>
                                <div class="text-xs text-gray-500 truncate">      
                                    {{ $row->SupplierName ?? '' }}
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-semibold text-gray-900 whitespace-nowrap">
                                    {{ number_format((float) ($row->DebitValue ?? 0), 2) }}
                                </div>
                                <div class="text-xs text-gray-500 whitespace-nowrap">
                                    {{ $row->DebitCurrency ?? '' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-1 gap-2 text-sm">
                            <div>
                                <div class="text-[11px] uppercase tracking-wide text-gray-500">ServiceDescription</div>
                                <div class="text-gray-800 break-words">{{ $row->ServiceDescription ?? '' }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <div class="text-[11px] uppercase tracking-wide text-gray-500">DebitDate</div>
                                    <div class="text-gray-800 whitespace-nowrap">
                                        {{ $row->DebitDate ? \Illuminate\Support\Carbon::parse($row->DebitDate)->format('Y-m-d') : '' }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-[11px] uppercase tracking-wide text-gray-500">Supplier</div>
                                    <div class="text-gray-800 truncate">{{ $row->SupplierName ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-500 text-sm">
                        No records found.
                    </div>
                @endforelse
            </div>

            <!-- Desktop table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[900px] text-sm">
                    <thead class="bg-gray-50 text-base  text-gray-800 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left whitespace-nowrap">ServiceCategory</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">SupplierName</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">ServiceDescription</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">DebitDate</th>
                            <th class="px-4 py-3 text-right whitespace-nowrap">DebitValue</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">DebitCurrency</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse(($recordsAll ?? collect()) as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $row->ServiceCategory ?? '' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $row->SupplierName ?? '' }}</td>
                                <td class="px-4 py-3">{{ $row->ServiceDescription ?? '' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $row->DebitDate ? \Illuminate\Support\Carbon::parse($row->DebitDate)->format('Y-m-d') : '' }}
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    {{ number_format((float) ($row->DebitValue ?? 0), 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $row->DebitCurrency ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-6 text-center text-gray-500" colspan="6">
                                    No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-app1>