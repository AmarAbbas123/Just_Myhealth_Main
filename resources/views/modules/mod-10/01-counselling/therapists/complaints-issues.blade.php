<x-app1>
    <div x-data="reportsApp()" class="space-y-6">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- Filters -->
        <div
            class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm flex flex-col sm:flex-row flex-wrap gap-3 items-center">
            <input type="text" placeholder="Search by Reported By..." x-model="filters.reportedBy"
                class="w-full sm:w-1/2 md:w-1/5 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />

            <input type="text" placeholder="Search by Issue Summary..." x-model="filters.summary"
                class="w-full sm:w-1/2 md:w-1/4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />

            <div class="flex gap-2 w-full sm:w-auto items-center">
                <label class="text-xs text-gray-500">From</label>
                <input type="date" x-model="filters.dateFrom"
                    class="border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />

                <label class="text-xs text-gray-500">To</label>
                <input type="date" x-model="filters.dateTo"
                    class="border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />

            </div>

            <button @click="clearFilters"
                class="px-3 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition">
                ♻️ Reset
            </button>
        </div>

        <!-- Reports Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm overflow-x-auto">

            <!-- Desktop Table -->
            <div class="hidden md:block">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300 min-w-[600px]">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                            <th class="py-2 px-3">Date</th>
                            <th class="py-2 px-3">Reported By</th>
                            <th class="py-2 px-3">Issue Summary</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="report in filteredReports" :key="report.id">
                            <tr
                                class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-2 px-3" x-text="report.date"></td>
                                <td class="py-2 px-3" x-text="report.reportedBy"></td>
                                <td class="py-2 px-3 truncate max-w-xs" x-text="report.summary"></td>
                                <td class="py-2 px-3">
                                    <span
                                        :class="report.status === 'Resolved' ? 'bg-green-100 text-green-700' :
                                            'bg-yellow-100 text-yellow-700'"
                                        x-text="report.status"></span>
                                </td>
                                <td class="py-2 px-3 text-right">
                                    <button @click="openReport(report)"
                                        class="px-3 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                                        👁️ View</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                <template x-for="report in filteredReports" :key="report.id">
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md shadow-sm space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium" x-text="report.reportedBy"></span>
                            <span x-text="report.date"></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span x-text="report.summary"></span>
                            <span :class="report.status === 'Resolved' ? 'text-green-600' : 'text-yellow-600'"
                                x-text="report.status"></span>
                        </div>
                        <div class="flex justify-end mt-1">
                            <button @click="openReport(report)"
                                class="bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition hover:underline text-xs">👁️
                                View</button>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="filteredReports.length === 0" class="text-center py-6 text-gray-500 text-sm">
                No reports found for the selected filters.
            </div>
        </div>

        <!-- View Modal -->
        <div x-show="selectedReport"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" x-transition>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg relative">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Issue Details</h2>

                <div class="space-y-2 text-sm">
                    <p><strong>Date:</strong> <span x-text="selectedReport.date"></span></p>
                    <p><strong>Reported By:</strong> <span x-text="selectedReport.reportedBy"></span></p>
                    <p><strong>Issue Summary:</strong> <span x-text="selectedReport.summary"></span></p>
                    <p><strong>Details:</strong></p>
                    <p class="text-gray-600 dark:text-gray-300" x-text="selectedReport.details"></p>
                </div>

                <div class="mt-5 flex flex-col sm:flex-row justify-end gap-2">
                    <button @click="resolveReport" x-show="selectedReport.status === 'Pending'"
                        class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Resolve</button>
                    <button @click="selectedReport=null"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                        Close</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function reportsApp() {
            return {
                filters: {
                    reportedBy: '',
                    summary: '',
                    dateFrom: '',
                    dateTo: ''
                },
                selectedReport: null,
                reports: [{
                        id: 1,
                        date: '2025-10-25',
                        reportedBy: 'Zain',
                        summary: 'Payment not credited',
                        details: 'The counsellor did not receive payment for last session.',
                        status: 'Pending'
                    },
                    {
                        id: 2,
                        date: '2025-10-22',
                        reportedBy: 'Sara',
                        summary: 'Session connection issue',
                        details: 'Unable to connect to therapist during session time.',
                        status: 'Resolved'
                    },
                    {
                        id: 3,
                        date: '2025-10-20',
                        reportedBy: 'Ali',
                        summary: 'Invoice not visible',
                        details: 'Invoice for last session not showing up in dashboard.',
                        status: 'Pending'
                    },
                    {
                        id: 4,
                        date: '2025-10-18',
                        reportedBy: 'Hina',
                        summary: 'Refund delay',
                        details: 'Refund requested two days ago still pending.',
                        status: 'Resolved'
                    },
                    {
                        id: 5,
                        date: '2025-10-15',
                        reportedBy: 'Umer',
                        summary: 'Wrong session charge',
                        details: 'Charged twice for the same session.',
                        status: 'Pending'
                    },
                ],

                get filteredReports() {
                    return this.reports.filter(r => {
                        const matchBy = (val, term) => val.toLowerCase().includes(term.toLowerCase());
                        const reportDate = new Date(r.date);
                        const from = this.filters.dateFrom ? new Date(this.filters.dateFrom) : null;
                        const to = this.filters.dateTo ? new Date(this.filters.dateTo) : null;

                        const inDateRange = (!from || reportDate >= from) && (!to || reportDate <= to);

                        return (
                            (!this.filters.reportedBy || matchBy(r.reportedBy, this.filters.reportedBy)) &&
                            (!this.filters.summary || matchBy(r.summary, this.filters.summary)) &&
                            inDateRange
                        );
                    });
                },

                clearFilters() {
                    this.filters = {
                        reportedBy: '',
                        summary: '',
                        dateFrom: '',
                        dateTo: ''
                    };
                },

                openReport(report) {
                    this.selectedReport = {
                        ...report
                    };
                },

                resolveReport() {
                    if (this.selectedReport) {
                        this.selectedReport.status = 'Resolved';
                        const idx = this.reports.findIndex(r => r.id === this.selectedReport.id);
                        this.reports[idx].status = 'Resolved';
                        this.selectedReport = null;
                    }
                }
            }
        }
    </script>
</x-app1>
