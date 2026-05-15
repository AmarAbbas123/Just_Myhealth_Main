<x-app1>
    @php
        $clientRealName = trim(
            ($client?->userAttributes?->FirstName ?? '') . ' ' . ($client?->userAttributes?->LastName ?? ''),
        );
        $clientName = $clientRealName !== '' ? $clientRealName : ($client?->UserName ?? 'Client');

        $formatDateTime = function ($date, $time = null) {
            if (!$date && !$time) {
                return '-';
            }

            try {
                return \Carbon\Carbon::parse(trim(($date ?? '') . ' ' . ($time ?? '')))->format('d M Y H:i');
            } catch (\Exception $e) {
                return trim(($date ?? '') . ' ' . ($time ?? '')) ?: '-';
            }
        };
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
            <a href="{{ route('therap.session.history.clients') }}"
                class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                Back to Clients
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-8 text-sm">
                <div class="text-gray-700 dark:text-gray-100">
                    Client Name: <span class="font-bold">{{ $clientName }} </span>
                </div>
                <div class="text-gray-700 dark:text-gray-100">
                    UserName: <span class="font-bold"> {{ $client?->UserName ?? '-' }} </span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-gray-500 border-b dark:border-gray-700">
                        <th class="px-4 py-3 font-medium">History Ref</th>
                        <th class="px-4 py-3 font-medium">Session Start</th>
                        <th class="px-4 py-3 font-medium min-w-80">Session Notes</th>
                        <th class="px-4 py-3 font-medium min-w-64">Collateral Links</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition align-top">
                            <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-100">
                                {{ $session->ID }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200 whitespace-nowrap">
                                {{ $formatDateTime($session->SessionStartedDate, $session->SessionStartedTime) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                <div class="whitespace-pre-line">{{ $session->TherapistNotes ?: 'No notes added.' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                @if(count($session->session_resource_links ?? []))
                                    <div class="space-y-1">
                                        @foreach($session->session_resource_links as $resource)
                                            <a href="{{ $resource['url'] }}"
                                                class="block text-blue-700 dark:text-blue-400 underline break-all">
                                                {{ $resource['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500">No documents attached.</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                No notes history found for this client.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app1>
