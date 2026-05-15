<x-app1>
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @forelse($clients as $session)
                @php
                    $client = $session->patient;
                    $realName = trim(
                        ($client?->userAttributes?->FirstName ?? '') . ' ' . ($client?->userAttributes?->LastName ?? ''),
                    );
                    $displayName = $realName !== '' ? $realName : ($client?->UserName ?? 'Client');
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            <img src="{{ $client?->profile_photo ?? asset('images/avatar1.jfif') }}"
                                onerror="this.src='{{ asset('images/avatar1.jfif') }}'"
                                class="w-16 h-16 rounded-full object-cover flex-shrink-0" alt="Avatar">

                            <div class="min-w-0">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 truncate">
                                    {{ $displayName }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-300 truncate">
                                    {{ $client?->UserName ?? 'No username' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 sm:w-48">
                            <a href="{{ route('therap.session.history.clients.dates', ['client_id' => $session->PatientUserID]) }}"
                                class="px-3 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg text-center shadow hover:bg-sky-700 transition">
                                View Session Dates
                            </a>
                            <a href="{{ route('therap.session.history.clients.notes', ['client_id' => $session->PatientUserID]) }}"
                                class="px-3 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg text-center shadow hover:bg-emerald-700 transition">
                                View Notes History
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 text-center text-gray-500">
                    No client session history found.
                </div>
            @endforelse
        </div>
    </div>
</x-app1>
