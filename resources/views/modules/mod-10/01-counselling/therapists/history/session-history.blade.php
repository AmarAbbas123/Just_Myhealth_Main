<x-app1>
    @php
        $resourceGroups = collect($sessionNoteResources ?? [])
            ->groupBy('folder_key')
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'folder_key' => $first['folder_key'] ?? 'group::' . md5((string) ($first['folder'] ?? 'Root')),
                    'folder' => $first['folder'] ?? 'Root',
                    'type' => $first['type'] ?? 'private',
                    'items' => $items->values(),
                ];
            })
            ->values();
    @endphp

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
                                    ($session->patient?->userAttributes?->FirstName ?? '') .
                                        ' ' .
                                        ($session->patient?->userAttributes?->LastName ?? ''),
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

            <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-lg p-6 shadow-lg flex flex-col max-h-[90vh]"
                @click.stop>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-1">
                    Session Details
                </h2>
                <p class="text-sm text-gray-500 mb-4">Complete information about this session.</p>

                <!-- Loading -->
                <div x-show="loading" class="text-center text-gray-500 py-6">Loading session details...</div>

                <!-- Scrollable Content -->
                <div x-show="!loading" class="overflow-y-auto flex-1 space-y-3 text-sm pr-1">

                    <div><b>Date:</b> <span x-text="selectedSession.session_started_date"></span></div>
                    <div><b>Patient:</b> <span x-text="selectedSession.patient"></span></div>
                    <div><b>Media Type:</b> <span x-text="selectedSession.media_type"></span></div>
                    <div><b>Duration:</b> <span x-text="selectedSession.duration"></span></div>

                    <!-- ─── NOTES ─── -->
                    <div>
                        <b>Therapy Notes:</b>
                        <!-- VIEW mode -->
                        <template x-if="!editMode">
                            <p class="mt-2 px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded shadow">
                                <span x-text="selectedSession.therapist_notes || 'No notes added.'"></span>
                            </p>
                        </template>
                        <!-- EDIT mode -->
                        <template x-if="editMode">
                            <textarea x-model="editNotes" rows="5"
                                class="mt-2 w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Write session notes…"></textarea>
                        </template>
                    </div>

                    <!-- ─── RESOURCES ─── -->
                    <div>
                        <b>Support Collateral Links:</b>

                        <!-- VIEW mode -->
                        <template x-if="!editMode">
                            <div class="mt-2 space-y-1">
                                <template x-if="selectedSession.session_note_resources.length === 0">
                                    <p class="text-sm text-gray-500">No documents attached.</p>
                                </template>
                                <template x-for="(resource, index) in selectedSession.session_note_resources"
                                    :key="index">
                                    <a :href="resource.url" class="block text-sm text-blue-700 underline break-all"
                                        x-text="resource.name"></a>
                                </template>
                            </div>
                        </template>


                        <!-- EDIT mode -->
                        <template x-if="editMode">
                            <div class="mt-2 space-y-3">

                                <!-- Currently attached -->
                                <template x-if="selectedResourcePaths.length > 0">
                                    <div class="space-y-1">
                                        <p class="text-xs font-medium text-gray-600 dark:text-gray-300">Currently
                                            attached</p>
                                        <template x-for="resource in selectedResourcesForDisplay()"
                                            :key="resource.path">
                                            <div
                                                class="flex items-center justify-between gap-2 rounded-md bg-gray-50 dark:bg-gray-700 px-3 py-2">
                                                <span class="text-sm text-blue-700 dark:text-blue-400 truncate"
                                                    x-text="resource.name"></span>
                                                <button type="button" @click="toggleResource(resource.path, false)"
                                                    class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 transition">
                                                    Remove
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <!-- Type toggle: Common / Private -->
                                <div class="flex gap-2">
                                    <button type="button" @click="selectedResourceType = 'common'"
                                        :class="selectedResourceType === 'common'
                                            ?
                                            'bg-sky-600 text-white' :
                                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                                        class="px-4 py-1.5 rounded-full text-sm font-medium transition">
                                        🌐 Common
                                    </button>
                                    <button type="button" @click="selectedResourceType = 'private'"
                                        :class="selectedResourceType === 'private'
                                            ?
                                            'bg-sky-600 text-white' :
                                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                                        class="px-4 py-1.5 rounded-full text-sm font-medium transition">
                                        🔒 Private
                                    </button>
                                </div>

                                <!-- File list for selected type -->
                                <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                                    <template x-if="itemsForSelectedType().length === 0">
                                        <p class="text-sm text-gray-500">No files in this category.</p>
                                    </template>
                                    <template x-for="resource in itemsForSelectedType()" :key="resource.path">
                                        <label
                                            class="flex items-center justify-between gap-3 rounded-md border border-gray-200 dark:border-gray-600 px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <input type="checkbox" :checked="isResourceSelected(resource.path)"
                                                    :disabled="!isResourceSelected(resource.path) && selectedResourcePaths
                                                        .length >= 8"
                                                    @change="toggleResource(resource.path, $event.target.checked)"
                                                    class="rounded border-gray-300 text-indigo-600">
                                                <p class="text-sm text-gray-800 dark:text-gray-100 truncate"
                                                    x-text="resource.name"></p>
                                            </div>
                                            <a :href="resource.url" target="_blank"
                                                class="text-xs text-blue-700 dark:text-blue-400 underline flex-shrink-0">
                                                Preview
                                            </a>
                                        </label>
                                    </template>
                                </div>

                                <p class="text-xs text-gray-400"
                                    x-text="`${selectedResourcePaths.length}/8 attachments selected`">
                                </p>

                            </div>
                        </template>
                    </div>

                    <!-- Save error -->
                    <p x-show="saveError" x-text="saveError" class="text-red-500 text-xs mt-1"></p>

                </div>

                <!-- ─── FOOTER BUTTONS ─── -->
                <div class="mt-5 flex justify-between items-center gap-2 flex-wrap border-t pt-4 dark:border-gray-700">

                    <!-- Left: Edit / Cancel -->
                    <div class="flex gap-2">
                        <template x-if="!editMode">
                            <button @click="startEdit"
                                class="px-3 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg shadow hover:bg-amber-600 transition">
                                ✏️ Edit Notes
                            </button>
                        </template>
                        <template x-if="editMode">
                            <button @click="cancelEdit"
                                class="px-3 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-300 transition">
                                Cancel
                            </button>
                        </template>
                    </div>

                    <!-- Right: Save / Close -->
                    <div class="flex gap-2">
                        <template x-if="editMode">
                            <button @click="saveEdits" :disabled="saving"
                                class="px-3 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg shadow hover:bg-emerald-700 transition disabled:opacity-50">
                                <span x-text="saving ? 'Saving…' : '💾 Save Changes'"></span>
                            </button>
                        </template>
                        <button @click="closeModal"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                            Close
                        </button>
                    </div>

                </div>

            </div>
        </div>


    </div>

    <script>
        function sessionHistory() {
            return {
                isMessageModalOpen: false,
                loading: false,
                editMode: false,
                saving: false,
                saveError: '',

                // Edit state
                editNotes: '',
                selectedResourceType: 'common',
                availableResourceGroups: @json($resourceGroups),
                selectedResourceGroupKey: @json($resourceGroups->first()['folder_key'] ?? ''),
                selectedResourcePaths: [],

                selectedSession: {
                    id: null,
                    patient: '',
                    media_type: '',
                    session_started_date: '',
                    duration: '',
                    recording: '',
                    therapist_notes: '',
                    session_note_resources: [] // [{url, name, index}]
                },

                async openDetailsModal(calendarId, patientName) {
                    this.isMessageModalOpen = true;
                    this.loading = true;
                    this.editMode = false;
                    this.saveError = '';
                    this.selectedResourcePaths = [];

                    this.selectedSession = {
                        id: calendarId,
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
                        this.selectedSession.session_started_date = d.session_started_date ?? 'N/A';
                        this.selectedSession.recording = d.recording ?? '';
                        this.selectedSession.therapist_notes = d.therapist_notes ?? '';
                        this.selectedSession.session_note_resources =
                            Array.isArray(d.session_note_resources) ? d.session_note_resources : [];

                        // Duration
                        if (d.session_started_time && d.session_ended_time) {
                            const start = new Date(`1970-01-01T${d.session_started_time}`);
                            const end = new Date(`1970-01-01T${d.session_ended_time}`);
                            const diffMs = end - start;
                            if (diffMs > 0) {
                                const mins = Math.floor(diffMs / 60000);
                                const hrs = Math.floor(mins / 60);
                                const remM = mins % 60;
                                this.selectedSession.duration = hrs > 0 ? `${hrs}h ${remM}m` : `${remM}m`;
                            } else {
                                this.selectedSession.duration = 'Not entered';
                            }
                        } else {
                            this.selectedSession.duration = 'Not entered';
                        }

                    } catch (e) {
                        console.error(e);
                        alert('Failed to load session details');
                    } finally {
                        this.loading = false;
                    }
                },

                startEdit() {
                    this.editNotes = this.selectedSession.therapist_notes;
                    this.selectedResourceType = 'common';
                    this.selectedResourcePaths = this.selectedSession.session_note_resources
                        .map(resource => resource.path)
                        .filter(Boolean);
                    if (!this.selectedResourceGroupKey && this.availableResourceGroups.length > 0) {
                        this.selectedResourceGroupKey = this.availableResourceGroups[0].folder_key;
                    }
                    this.saveError = '';
                    this.editMode = true;
                },

                cancelEdit() {
                    this.editMode = false;
                    this.selectedResourceType = 'common';
                    this.selectedResourcePaths = [];
                    this.saveError = '';
                },

                currentResourceGroupItems() {
                    const group = this.availableResourceGroups.find(
                        item => item.folder_key === this.selectedResourceGroupKey
                    );

                    return group?.items ?? [];
                },

                allAvailableResources() {
                    return this.availableResourceGroups.flatMap(group => group.items ?? []);
                },

                selectedResourcesForDisplay() {
                    const resourcesByPath = new Map(
                        this.allAvailableResources().map(resource => [resource.path, resource])
                    );

                    return this.selectedResourcePaths.map(path => {
                        const resource = resourcesByPath.get(path) ?? {
                            path,
                            name: path
                        };
                        return {
                            ...resource,
                            name: resource.path.split('/').pop() || resource.name // ← clean name
                        };
                    });
                },

                isResourceSelected(path) {
                    return this.selectedResourcePaths.includes(path);
                },

                toggleResource(path, checked) {
                    if (checked) {
                        if (this.selectedResourcePaths.length >= 8 || this.isResourceSelected(path)) {
                            return;
                        }

                        this.selectedResourcePaths.push(path);
                        return;
                    }

                    this.selectedResourcePaths = this.selectedResourcePaths.filter(item => item !== path);
                },

                async saveEdits() {
                    this.saving = true;
                    this.saveError = '';

                    try {
                        const form = new FormData();
                        form.append('history_id', this.selectedSession.id);
                        form.append('therapist_notes', this.editNotes);

                        this.selectedResourcePaths.forEach(path => {
                            form.append('selected_resources[]', path);
                        });

                        const res = await fetch('/mod-10/my-session-history/update-notes', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: form
                        });

                        const json = await res.json();

                        if (json.success) {
                            // Reflect notes change locally
                            this.selectedSession.therapist_notes = this.editNotes;
                            this.selectedResourcePaths = [];
                            this.editMode = false;
                            // Reload resources from server to get fresh URLs
                            await this.refreshResources();
                        } else {
                            this.saveError = json.message ?? 'Could not save changes.';
                        }

                    } catch (e) {
                        console.error(e);
                        this.saveError = 'An error occurred while saving.';
                    } finally {
                        this.saving = false;
                    }
                },

                async refreshResources() {
                    try {
                        const res = await fetch('/therapist/session-history/details', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                calendar_id: this.selectedSession.id
                            })
                        });
                        const json = await res.json();
                        if (json.success) {
                            this.selectedSession.session_note_resources =
                                Array.isArray(json.data.session_note_resources) ?
                                json.data.session_note_resources : [];
                        }
                    } catch (e) {
                        console.error('Failed to refresh resources', e);
                    }
                },

                itemsForSelectedType() {
                    return this.availableResourceGroups
                        .flatMap(group => group.items ?? [])
                        .filter(resource => resource.type === this.selectedResourceType)
                        .map(resource => ({
                            ...resource,
                            name: resource.path.split('/').pop() || resource.name
                        }));
                },

                closeModal() {
                    this.isMessageModalOpen = false;
                    this.editMode = false;
                    this.selectedResourceType = 'common';
                    this.selectedResourcePaths = [];
                    this.saveError = '';
                }
            }
        }
    </script>


</x-app1>
