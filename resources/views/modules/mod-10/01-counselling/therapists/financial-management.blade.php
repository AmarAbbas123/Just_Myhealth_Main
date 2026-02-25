<x-app1>
    <div x-data="financeApp()" x-init="init()" class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <x-page-header />
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 border rounded-lg bg-white">
                <p class="text-sm">Net Revenue (All Time)</p>
                <p class="text-xl font-bold text-green-600">GBP: £<span x-text="netRevenue"></span></p>
                <p class="text-xs text-gray-500">Total earnings after platform fee’s</p>
            </div>

            <div class="p-4 border rounded-lg bg-white">
                <p class="text-sm">Payments Made (This Year)</p>
                <p class="text-xl font-bold text-green-600">GBP: £<span x-text="paymentsMade"></span></p>
                <p class="text-xs text-gray-500">Payments processed this year</p>
            </div>

            <div class="p-4 border rounded-lg bg-white">
                <p class="text-sm">Payments Owed</p>
                <p class="text-xl font-bold text-red-600">GBP: £<span x-text="paymentsOwed"></span></p>
                <p class="text-xs text-gray-500">Pending transfer (Month End)</p>
            </div>

            <div class="p-4 border rounded-lg bg-white">
                <p class="text-sm">Future sessions</p>
                <p class="text-xl font-bold text-purple-600">GBP: £<span x-text="futureSessions"></span></p>
                <p class="text-xs text-gray-500">Value of future booked sessions</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-end gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

            <!-- Start Date -->
            <div class="flex flex-col">
                <label class="mb-1 text-xs font-medium text-gray-500">Start date</label>
                <input type="date" x-model="startDate"
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700
                   focus:border-teal-500 focus:ring-1 focus:ring-teal-500">
            </div>

            <!-- End Date -->
            <div class="flex flex-col">
                <label class="mb-1 text-xs font-medium text-gray-500">End date</label>
                <input type="date" x-model="endDate"
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700
                   focus:border-teal-500 focus:ring-1 focus:ring-teal-500">
            </div>

            <!-- Type -->
            <div class="flex flex-col min-w-[180px]">
                <label class="mb-1 text-xs font-medium text-gray-500">Type</label>
                <select x-model="filterType"
                    class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700
                   focus:border-teal-500 focus:ring-1 focus:ring-teal-500">
                    <option value="">All types</option>
                    <option value="SESSION_ALL">Sessions (All)</option>
                    <option value="SESSION_PAID">Sessions (Paid)</option>
                    <option value="SESSION_OWED">Sessions (Owed)</option>
                    <option value="PAYOUT">Payouts</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
                <button @click="applyFilters()"
                    class="inline-flex items-center rounded-md bg-teal-600 px-4 py-2 text-sm font-medium text-white
                   hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-1
                   transition">
                    Filter
                </button>

                <button @click="resetFilters()"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-orange-500 px-4 py-2 text-sm
                   font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2
                   focus:ring-gray-400 focus:ring-offset-1 transition">
                    Reset
                </button>
            </div>

        </div>


        <!-- Sessions Table -->
        <div class="bg-white border rounded p-4">
            <h3 class="font-semibold mb-3">Transaction History (Sessions):</h3>

            <table class="w-full text-sm">
                <thead class="border-b">
                    <tr>
                        <th class="text-left py-1">Date</th>
                        <th class="text-left py-1">Screen Name</th>
                        <th class="text-left py-1">Users Name</th>
                        <th class="text-right py-1">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="t in sessionTransactions" :key="t.id">
                        <tr class="border-b">
                            <td x-text="t.date"></td>
                            <td x-text="t.screen_name"></td>
                            <td x-text="t.real_name"></td>
                            <td class="text-right">£<span x-text="t.amount"></span></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Payout Table -->
        <div class="bg-white border rounded p-4">
            <h3 class="font-semibold mb-3">Transaction History (Payout):</h3>

            <table class="w-full text-sm">
                <thead class="border-b">
                    <tr>
                        <th class="text-left py-1">Date</th>
                        <th class="text-left py-1">From</th>
                        <th class="text-left py-1">To</th>
                        <th class="text-right py-1">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="p in payoutTransactions" :key="p.id">
                        <tr class="border-b">
                            <td x-text="p.date"></td>
                            <td>SYSTEM</td>
                            <td>SYSTEM</td>
                            <td class="text-right">£<span x-text="p.amount"></span></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function financeApp() {
            return {
                netRevenue: {{ $netRevenue }},
                paymentsMade: {{ $paymentsMade }},
                paymentsOwed: {{ $paymentsOwed }},
                futureSessions: {{ $unscheduledValue }},

                startDate: '',
                endDate: '',
                filterType: '',

                sessionTransactions: @json($sessionTransactions ?? []),
                payoutTransactions: @json($payoutTransactions ?? []),

                applyFilters() {
                    const start = this.startDate ? new Date(this.startDate) : null;
                    const end = this.endDate ? new Date(this.endDate) : null;

                    const byDate = t => {
                        const d = new Date(t.date);
                        return (!start || d >= start) && (!end || d <= end);
                    };

                    // Reset first
                    let sessions = @json($sessionTransactions);
                    let payouts = @json($payoutTransactions);

                    // Date filter
                    sessions = sessions.filter(byDate);
                    payouts = payouts.filter(byDate);

                    // Type filter
                    switch (this.filterType) {
                        case 'SESSION_PAID':
                            sessions = sessions.filter(s => s.payment_status === 'PAID');
                            payouts = []; // hide payouts
                            break;

                        case 'SESSION_OWED':
                            sessions = sessions.filter(s => s.payment_status === 'OWED');
                            payouts = [];
                            break;

                        case 'SESSION_ALL':
                            payouts = [];
                            break;

                        case 'PAYOUT':
                            sessions = [];
                            break;
                    }

                    this.sessionTransactions = sessions;
                    this.payoutTransactions = payouts;
                },

                resetFilters() {
                    this.startDate = '';
                    this.endDate = '';
                    this.filterType = '';
                    this.sessionTransactions = @json($sessionTransactions);
                    this.payoutTransactions = @json($payoutTransactions);
                }

            }
        }
    </script>
</x-app1>