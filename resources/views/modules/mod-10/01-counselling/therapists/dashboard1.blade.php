<x-app1>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">✨ Therapist Dashboard</h2>
            <span class="text-sm text-gray-500">Welcome back, {{ Auth::user()->UserName ?? 'Therapist' }}</span>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="stat-card">
                <p class="text-gray-500 text-sm">Total Patients</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">42</h3>
            </div>
            <div class="stat-card">
                <p class="text-gray-500 text-sm">Upcoming Appointments</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">8</h3>
            </div>
            <div class="stat-card">
                <p class="text-gray-500 text-sm">Sessions Completed</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">112</h3>
            </div>
            <div class="stat-card">
                <p class="text-gray-500 text-sm">Total Earnings</p>
                <h3 class="text-2xl font-bold text-green-600">$1,250</h3>
            </div>
        </div>

        <!-- Recent Patients Table -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Recent Patients</h3>
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-2 px-3">Name</th>
                        <th class="py-2 px-3">Appointment Date</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="py-2 px-3">Ali Khan</td>
                        <td class="py-2 px-3">Oct 28, 2025</td>
                        <td class="py-2 px-3 text-green-600">Confirmed</td>
                        <td class="py-2 px-3">$40</td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="py-2 px-3">Sara Ahmed</td>
                        <td class="py-2 px-3">Oct 30, 2025</td>
                        <td class="py-2 px-3 text-yellow-500">Pending</td>
                        <td class="py-2 px-3">$60</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .stat-card {
            @apply bg-white dark:bg-gray-800 shadow rounded-lg p-4;
        }
    </style>
</x-app1>
