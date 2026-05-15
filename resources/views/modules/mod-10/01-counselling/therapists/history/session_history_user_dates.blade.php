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
                $value = trim(($date ?? '') . ' ' . ($time ?? ''));
                $format = $time ? 'd M Y H:i' : 'd M Y';

                return \Carbon\Carbon::parse($value)->format($format);
            } catch (\Exception $e) {
                return trim(($date ?? '') . ' ' . ($time ?? '')) ?: '-';
            }
        };

        $formatDuration = function ($session) {
            if (!$session->SessionStartedDate || !$session->SessionStartedTime || !$session->SessionEndedDate || !$session->SessionEndedTime) {
                return '-';
            }

            try {
                $start = \Carbon\Carbon::parse($session->SessionStartedDate . ' ' . $session->SessionStartedTime);
                $end = \Carbon\Carbon::parse($session->SessionEndedDate . ' ' . $session->SessionEndedTime);

                if ($end->lessThanOrEqualTo($start)) {
                    return '-';
                }

                $minutes = $start->diffInMinutes($end);
                $hours = intdiv($minutes, 60);
                $remainingMinutes = $minutes % 60;

                return $hours > 0 ? "{$hours}h {$remainingMinutes}m" : "{$remainingMinutes}m";
            } catch (\Exception $e) {
                return '-';
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
                    Client Name: <span class="font-bold"> {{ $clientName }} </span>
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
                        <th class="px-4 py-3 font-medium">Session Booked</th>
                        <th class="px-4 py-3 font-medium">Client Entered Waiting Room</th>
                        <th class="px-4 py-3 font-medium">Therapist Entered Waiting Room</th>
                        <th class="px-4 py-3 font-medium">Session Started</th>
                        <th class="px-4 py-3 font-medium">Session Ended</th>
                        <th class="px-4 py-3 font-medium">Session Duration</th>
                        <th class="px-4 py-3 font-medium">Session Type</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-100">
                                {{ $session->ID }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $formatDateTime($session->SessionBookedDate) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $formatDateTime($session->PatientEnteredWaitingRoomDate, $session->PatientEnteredWaitingRoomTime) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $formatDateTime($session->TherapistEnteredWaitingRoomDate, $session->TherapistEnteredWaitingRoomTime) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $formatDateTime($session->SessionStartedDate, $session->SessionStartedTime) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $formatDateTime($session->SessionEndedDate, $session->SessionEndedTime) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $formatDuration($session) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-200">
                                {{ $session->SessionMediaType ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                No session dates found for this client.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app1>
