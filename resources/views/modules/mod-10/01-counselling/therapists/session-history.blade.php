<x-app1>
    <div x-data="sessionHistory()" class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
            {{-- <div class="flex items-center gap-2 mt-2 md:mt-0">
                <button @click="exportCSV"
                    class="px-3 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg shadow hover:bg-amber-700 transition">
                    📤 Export CSV
                </button>
            </div> --}}
        </div>

        <!-- Filter Bar -->
        {{-- <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm overflow-x-auto">
            <form @submit.prevent="applyFilters" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Date Range -->
                <div>
                    <label class="block text-sm text-gray-500 dark:text-gray-300 mb-1">From</label>
                    <input x-model="filters.startDate" type="date"
                        class="w-full border-gray-300 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-900 text-sm p-2">
                </div>
                <div>
                    <label class="block text-sm text-gray-500 dark:text-gray-300 mb-1">To</label>
                    <input x-model="filters.endDate" type="date"
                        class="w-full border-gray-300 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-900 text-sm p-2">
                </div>

                <!-- Patient -->
                <div>
                    <label class="block text-sm text-gray-500 dark:text-gray-300 mb-1">Patient</label>
                    <input x-model="filters.patient" type="text" placeholder="Search patient"
                        class="w-full border-gray-300 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-900 text-sm p-2">
                </div>

                <!-- Therapy Type -->
                <div>
                    <label class="block text-sm text-gray-500 dark:text-gray-300 mb-1">Therapy Type</label>
                    <select x-model="filters.type"
                        class="w-full border-gray-300 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-900 text-sm p-2">
                        <option value="">All</option>
                        <option value="Video">Video</option>
                        <option value="Audio">Audio</option>
                        <option value="Text">Text</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-4 flex flex-col sm:flex-row justify-end gap-2 mt-2 sm:mt-0">
                    <button type="button" @click="resetFilters"
                        class="px-3 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition">
                        ♻️ Reset
                    </button>
                    <button type="submit"
                        class="px-3 py-2 bg-emerald-600 text-white rounded-lg shadow hover:bg-emerald-700 transition">
                        🔍 Apply Filters
                    </button>
                </div>
            </form>
        </div> --}}

        <!-- Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">

                <!-- Table Head -->
                <thead>
                    <tr class="text-gray-500 border-b dark:border-gray-700">
                        <th class="px-4 py-3 font-medium text-center">
                            Date / Time
                        </th>
                        <th class="px-4 py-3 font-medium">
                            Screen Name
                        </th>
                        <th class="px-4 py-3 font-medium">
                            Users Name
                        </th>
                        <th class="px-4 py-3 font-medium text-center">
                            Media
                        </th>
                        <th class="px-4 py-3 font-medium text-right">
                            Actions
                        </th>
                    </tr>
                </thead>

                @php
                    $sessionMap = [
                        'Video' => ['label' => '🎥 Video'],
                        'Audio' => ['label' => '🎧  Audio'],
                        // 'Message' => ['label' => '💬 Chatting'],
                    ];
                @endphp

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/avatar1.jfif') }}"
                                        class="w-10 h-10 rounded-full object-cover" alt="Avatar">
                                    <div>
                                        <div class="font-medium text-gray-500 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($session->SessionStartedDate)->format('d M Y') }}
                                            {{ \Carbon\Carbon::parse($session->SessionStartedTime)->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Screen Name -->
                            <td class="px-4 py-3 font-medium text-gray-500 dark:text-gray-100">
                                {{ $session->patient?->UserName }}
                            </td>

                            <!-- User Name -->
                            <td class="px-4 py-3 font-medium text-gray-500 dark:text-gray-100">
                                {{ optional($session->patient?->userAttributes)->FirstName }}
                                {{ optional($session->patient?->userAttributes)->LastName }}
                            </td>

                            <!-- Media -->
                            <td class="px-4 py-3 text-center font-medium text-gray-500 dark:text-gray-100">
                                @if (isset($sessionMap[$session?->SessionMediaType]))
                                    {{ $sessionMap[$session?->SessionMediaType]['label'] }}
                                @endif
                            </td>

                            <!-- Actions -->
                            @php
                            $clientName = trim(
                                ($session->patient?->userAttributes?->FirstName ?? '') . ' ' .
                                ($session->patient?->userAttributes?->LastName ?? '')
                            );
                        @endphp


                            <td class="px-4 py-3 text-right">
                                <button @click="openDetailsModal({{ $session->ID }}, '{{ $clientName }}')"
                                    class="px-3 py-1 bg-sky-200 text-black rounded-md text-sm">
                                    💬 View Details
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                No waiting sessions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Modal -->
        <div x-show="isMessageModalOpen" @click.self="closeModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4" x-transition>

            <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-lg p-6 shadow-lg" @click.stop>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                    Session Details
                </h2>

                <p class="text-sm text-gray-500 mb-4">
                    Complete information about this session.
                </p>

                <!-- Loading -->
                <div x-show="loading" class="text-center text-gray-500">
                    Loading session details...
                </div>

                <!-- Data -->
                <div x-show="!loading" class="space-y-3 text-sm">

                    <div><b>Date:</b>
                        <span x-text="selectedSession.session_started_date"></span>
                    </div>

                    <div><b>Patient:</b>
                        <span x-text="selectedSession.patient"></span>
                    </div>

                    <div><b>Media Type:</b>
                        <span x-text="selectedSession.media_type"></span>
                    </div>

                    <div><b>Duration:</b>
                        <span x-text="selectedSession.duration"></span>
                    </div>

                    {{-- <div><b>Recording:</b>
                        <template x-if="selectedSession.recording">
                            <a :href="`/recordings/${selectedSession.id}`" target="_blank" class="text-blue-600 underline">
                                View Recording
                            </a>
                        </template>

                        <template x-if="!selectedSession.recording">
                            <span>Not available</span>
                        </template>
                    </div> --}}

                    <div><b>Therapy Notes:</b> <br><br>
                        <p class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium shadow">
                            <span x-text="selectedSession.therapist_notes"></span>
                        </p>
                    </div>

                    <div>
                        <b>Support Collateral Links:</b>
                        <template x-if="selectedSession.session_note_resources.length === 0">
                            <p class="text-sm text-gray-500 mt-2">No links added.</p>
                        </template>
                        <div class="mt-2 space-y-1">
                            <template x-for="(link, index) in selectedSession.session_note_resources" :key="index">
                                <a :href="link" target="_blank" class="block text-sm text-blue-700 underline break-all"
                                    x-text="link"></a>
                            </template>
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="closeModal"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                        Close
                    </button>
                </div>

            </div>
        </div>


    </div>

    <script>
        function sessionHistory() {
            return {
                isMessageModalOpen: false,
                loading: false,

                selectedSession: {
                    patient: '',
                    media_type: '',
                    session_started_date: '',
                    duration: '',
                    recording: '',
                    therapist_notes: '',
                    session_note_resources: []
                },

                async openDetailsModal(calendarId, patientName) {
                    this.isMessageModalOpen = true;
                    this.loading = true;

                    this.selectedSession = {
                        patient: patientName,
                        media_type: '',
                        session_started_date: '',
                        duration: '',
                        recording: '',
                        therapist_notes: '',
                        session_note_resources: []
                    };

                    try {
                        const res = await fetch('/therapist/session-history/details', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                calendar_id: calendarId
                            })
                        });

                        const json = await res.json();
                        const d = json.data;

                        this.selectedSession.media_type = d.media_type ?? 'N/A';

                        // Date ONLY (already formatted by controller)
                        this.selectedSession.session_started_date = d.session_started_date ?? 'N/A';

                        // Duration calculation
                        if (d.session_started_time && d.session_ended_time) {
                            const start = new Date(`1970-01-01T${d.session_started_time}`);
                            const end = new Date(`1970-01-01T${d.session_ended_time}`);

                            const diffMs = end - start;

                            if (diffMs > 0) {
                                const mins = Math.floor(diffMs / 60000);
                                const hrs = Math.floor(mins / 60);
                                const remM = mins % 60;

                                this.selectedSession.duration =
                                    hrs > 0 ? `${hrs}h ${remM}m` : `${remM}m`;
                            } else {
                                this.selectedSession.duration = 'Not entered';
                            }
                        } else {
                            this.selectedSession.duration = 'Not entered';
                        }

                        this.selectedSession.recording =
                            d.recording ?? '';

                        this.selectedSession.id = calendarId;
    

                        this.selectedSession.therapist_notes =
                            d.therapist_notes ?? '';

                        this.selectedSession.session_note_resources =
                            Array.isArray(d.session_note_resources) ? d.session_note_resources : [];

                    } catch (e) {
                        console.error(e);
                        alert('Failed to load session details');
                    } finally {
                        this.loading = false;
                    }
                },

                closeModal() {
                    this.isMessageModalOpen = false;
                }
            }
        }
    </script>


</x-app1>
