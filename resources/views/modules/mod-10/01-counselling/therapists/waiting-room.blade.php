<!-- resources/views/therapdashboard/waiting-room.blade.php -->
<x-app1>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- <script> window.WAITING_ROOM_ID = @json($roomID); </script> --}}
    <script>
        window.ZEGO_LOCK = false;
        window.ZEGO_INSTANCE = null;
    </script>

    <div x-data="waitingRoomApp()" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <x-page-header />
            {{-- <button @click="showAdmitAll=true"
                class="px-3 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                🚑 Admit All Patients
            </button> --}}
        </div>

        <div x-show="notesStatusMessage" x-cloak
            class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            <span x-text="notesStatusMessage"></span>
        </div>

        <!-- Waiting List Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="hidden md:table-header-group">
                    <tr class="text-gray-500 border-b dark:border-gray-700">
                        <th class="py-2">Screen Name</th>
                        <th class="py-2">Users Name</th>
                        <th class="py-2">Date/Time</th>
                        <th class="py-2">Media</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 text-right">Actions</th>
                    </tr>
                </thead>

                @php
                    $sessionMap = [
                        'Video' => ['label' => '🎥 Start Video', 'bg' => 'bg-green-600'],
                        'Audio' => ['label' => '🎧 Start Audio', 'bg' => 'bg-indigo-600'],
                        'Message' => ['label' => '💬 Start Chatting', 'bg' => 'bg-sky-600'],
                    ];
                @endphp

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 md:divide-y">
                    @forelse($sessions as $session)
                        <tr class="block md:table-row border border-gray-200 dark:border-gray-700 rounded-lg md:border-0 md:rounded-none mb-3 md:mb-0 overflow-hidden">
                            <td class="block md:table-cell p-3 md:py-3 md:px-0">
                                <div class="md:hidden text-[11px] font-semibold text-gray-500 mb-1">Screen Name</div>
                                <div class="flex items-center gap-3">
                                <img src="{{ asset('images/avatar1.jfif') }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                {{-- <img src="{{ asset('storage/' . $session->patient->ProfilePhotoPath) }}"
                                    alt="Profile Photo"
                                    class="w-10 h-10 rounded-full object-cover"> --}}

                                <div>
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $session->patient->UserName }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $session->SessionType }} —
                                        {{ $session->DisplaySessionDateTimeFrom->format('H:i') }}
                                    </div>
                                </div>
                                </div>
                            </td>

                            <td class="block md:table-cell p-3 md:py-3 md:px-0 text-gray-500">
                                <div class="md:hidden text-[11px] font-semibold text-gray-500 mb-1">Users Name</div>
                                {{ optional($session->patient->userAttributes)->FirstName }}
                                {{ optional($session->patient->userAttributes)->LastName }}
                            </td>

                            <td class="block md:table-cell p-3 md:py-3 md:px-0 text-gray-500">
                                <div class="md:hidden text-[11px] font-semibold text-gray-500 mb-1">Date/Time</div>
                                {{ $session->DisplaySessionDateTimeFrom->format('Y-m-d H:i') }}
                            </td>

                            <td class="block md:table-cell p-3 md:py-3 md:px-0 text-gray-500">
                                <div class="md:hidden text-[11px] font-semibold text-gray-500 mb-1">Media</div>
                                {{ $session->SessionType }}
                            </td>

                            <td class="block md:table-cell p-3 md:py-3 md:px-0">
                                <div class="md:hidden text-[11px] font-semibold text-gray-500 mb-1">Status</div>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">
                                    Scheduled
                                </span>
                            </td>

                            @php $clientName = optional($session->patient->userAttributes)->FirstName; @endphp

                            <td class="block md:table-cell p-3 md:py-3 md:px-0 md:text-right">
                                <div class="md:hidden text-[11px] font-semibold text-gray-500 mb-2">Actions</div>
                                <div class="flex flex-wrap md:flex-nowrap justify-start md:justify-end items-center gap-2">

                                    <button
                                        @click="openOnboardingAnswers('{{ $session->PatientUserID }}','{{ $session->patient->UserName }}')"
                                        class="px-3 py-1 bg-gray-100 text-gray-800 rounded-md text-sm border border-gray-200 hover:bg-gray-200 transition">
                                        View Answers
                                    </button>

                                    <button
                                        @click="openOnboardingIssue('{{ $session->PatientUserID }}','{{ $session->patient->UserName }}')"
                                        class="px-3 py-1 bg-gray-100 text-gray-800 rounded-md text-sm border border-gray-200 hover:bg-gray-200 transition">
                                        View Issue
                                    </button>

                                    @if (isset($sessionMap[$session->SessionType]))
                                        <button
                                            @click="
                                            currentClient='{{ $clientName }}';
                                            roomID='{{ $session->SessionZegoCloudConnectID }}';
                                            sessionType='{{ $session->SessionType }}';
                                            currentCalendarID={{ $session->ID }};
                                            markTherapistEntered();
                                            showSession=true"
                                            class="px-3 py-1 {{ $sessionMap[$session->SessionType]['bg'] }} text-white rounded-md text-sm">
                                            {{ $sessionMap[$session->SessionType]['label'] }}
                                        </button>
                                    @endif

                                    <button
                                        @click="openMessageModal('{{ $clientName }}', '{{ $session->PatientUserID }}')"
                                        class="px-3 py-1 bg-sky-200 text-black rounded-md text-sm">
                                        💬 Message User
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                No waiting sessions found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- Admit All Modal -->
        {{-- <div x-show="showAdmitAll" x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40">
            <div @click.away="showAdmitAll=false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Admit All Patients</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to admit all waiting patients?</p>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="showAdmitAll=false"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                        Cancel</button>
                    <button @click="admitAll()" class="px-3 py-2 bg-teal-600 text-white rounded-md">Confirm Admit
                        All</button>
                </div>
            </div>
        </div> --}}

        <!-- Start Session Modal -->
        <div x-show="showSession" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div @click.away="showSession=false"
                class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Session with <span
                            x-text="currentClient"></span></h3>
                    <button @click="showSession=false" class="text-gray-500">✕</button>
                </div>
                <div class="text-sm text-gray-500">Manage live session controls below:</div>

                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-900 p-3 rounded-md">
                    {{-- Session timer hidden for now --}}
                    {{-- <div>
                        <span class="font-medium text-gray-800 dark:text-gray-100">Session Timer:</span>
                        <span x-text="Math.floor(timer/60)+'m '+(timer%60)+'s'"
                            class="text-sm text-gray-500 ml-1"></span>
                    </div> --}}
                    <div class="text-sm text-gray-500">
                        Live session controls
                    </div>
                    {{-- Recording toggle hidden for now --}}
                    {{-- <button @click="toggleRecording()" :class="recording ? 'bg-red-600 text-white' : 'bg-gray-200'"
                        class="px-3 py-1 rounded-md text-sm">
                        <span x-text="recording ? 'Stop Recording' : 'Start Recording'"></span>
                    </button> --}}
                </div>

                <div class="flex justify-end gap-2">
                    <button @click="endSession()"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                        End Session</button>
                    <button @click="startSession(currentCalendarID)"
                        class="px-3 py-2 bg-green-600 text-white rounded-md">Start Live
                        Session</button>
                </div>
            </div>
        </div>

        <!-- Message Modal -->
        <div x-show="showMessageModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div @click.away="showMessageModal=false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Message <span
                            x-text="messageClient"></span></h3>
                    <button @click="showMessageModal=false" class="text-gray-500">✕</button>
                </div>
                <textarea x-model="messageText" rows="4" placeholder="Type your message..."
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 px-3 py-2 mb-3"></textarea>
                <div class="flex justify-end gap-2">
                    <button @click="showMessageModal=false"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                        Cancel</button>
                    <button @click="sendMessage()" class="px-3 py-2 bg-green-600 text-white rounded-md">📩 Send</button>
                </div>
            </div>
        </div>

        <!-- Session Notes Modal (opens after session ends) -->
        <div x-show="showNotesModal" x-cloak x-transition
            class="fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div 
            {{-- @click.away="closeNotesModal()" --}}
                class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-5xl h-[85vh] shadow-xl flex flex-col overflow-hidden">
                <div class="flex items-center justify-between gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Post Session Notes</h3>
                        <p class="text-sm text-gray-500">Add notes and attach up to 4 support collateral links.</p>
                    </div>
                    <button type="button" @click="closeNotesModal()" class="text-gray-500 text-xl leading-none">&times;</button>
                </div>

                <div class="flex-1 bg-gray-100 min-h-0">
                    <template x-if="notesModalUrl">
                        <iframe data-notes-iframe :src="notesModalUrl" class="w-full h-full min-h-[50vh] border-0"
                            title="Post Session Notes"></iframe>
                    </template>
                </div>
            </div>
        </div>

        <!-- Onboarding Answers Modal (Q1-Q39) -->
        <div x-show="showOnboardingAnswersModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div @click.away="showOnboardingAnswersModal=false"
                class="bg-white dark:bg-gray-800 rounded-lg p-4 sm:p-6 w-full max-w-lg md:max-w-3xl max-h-[85vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        On-boarding Questions & Answers
                        <span class="text-sm font-normal text-gray-500" x-text="onboardingPatientLabel"></span>
                    </h3>
                    <button @click="showOnboardingAnswersModal=false" class="text-gray-500">✕</button>
                </div>

                <div x-show="onboardingLoading" class="text-sm text-gray-500 py-6 text-center">
                    Loading...
                </div>

                <div x-show="!onboardingLoading" class="bg-gray-50 rounded-lg border border-gray-200 p-3 sm:p-4">
                    <!-- Headings -->
                    <div class="hidden md:grid grid-cols-2 gap-6 text-sm font-semibold text-gray-700 mb-2">
                        <div>Question</div>
                        <div class="text-center">Answer</div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <template x-for="row in onboardingQa" :key="row.id">
                            <div class="py-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-6 items-start">
                                    <div class="text-sm text-gray-700">
                                        <span class="md:hidden font-semibold text-gray-700">Question:</span>
                                        <span x-text="row.question"></span>
                                    </div>
                                    <div class="text-sm  text-gray-700 md:text-center">
                                        <span class="md:hidden font-semibold text-gray-700">Answer:</span>
                                        <span x-text="row.answer || '—'"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onboarding Issue Modal (Q40) -->
        <div x-show="showOnboardingIssueModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div @click.away="showOnboardingIssueModal=false"
                class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-3xl max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        User Description of active issue
                        <span class="text-sm font-normal text-gray-500" x-text="onboardingPatientLabel"></span>
                    </h3>
                    <button @click="showOnboardingIssueModal=false" class="text-gray-500">✕</button>
                </div>

                <div x-show="onboardingLoading" class="text-sm text-gray-500 py-6 text-center">
                    Loading...
                </div>

                <div x-show="!onboardingLoading" class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                    <p class="text-gray-700 text-sm whitespace-pre-wrap" x-text="onboardingIssue || '—'"></p>
                </div>
            </div>
        </div>

        <div id="videoContainer" class="w-full h-[70vh] mt-4 rounded-lg overflow-hidden"></div>

    </div>

    {{-- zegocloud video Session  --}}
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt@2.9.3/zego-uikit-prebuilt.js"></script>
    {{-- <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script> --}}
    {{-- <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt@latest/zego-uikit-prebuilt.js"></script> --}}

    <script>
        window.waitingRoomApp = function() {
            return {
                init() {
                    this._onNotesWindowMessage = (event) => this.handleNotesWindowMessage(event);
                    window.addEventListener('message', this._onNotesWindowMessage);
                },

                destroy() {
                    if (this._onNotesWindowMessage) {
                        window.removeEventListener('message', this._onNotesWindowMessage);
                    }
                },

                /**
                 * Only accept postMessages that actually come from our notes iframe (not Vite, Ignition, Zego, extensions).
                 * Do not auto-close the modal on "saved" — user closes via × or the iframe Close button to avoid phantom closes.
                 */
                handleNotesWindowMessage(event) {
                    if (event.origin !== window.location.origin || !event.data || typeof event.data.type !== 'string') {
                        return;
                    }
                    if (event.data.source !== 'justmy-session-notes-embed') {
                        return;
                    }

                    const iframe = this.$el?.querySelector?.('iframe[data-notes-iframe]');
                    if (!iframe || event.source !== iframe.contentWindow) {
                        return;
                    }

                    if (event.data.type === 'session-notes-close' && event.data.manual) {
                        this.closeNotesModal();
                        return;
                    }

                    if (event.data.type === 'session-notes-saved') {
                        if (!this.showNotesModal) return;
                        this.notesStatusMessage = event.data.message || 'Session notes saved.';
                    }
                },
                showAdmitAll: false,
                showSession: false,
                showMessageModal: false,
                currentClient: null,
                messageClient: null,
                currentCalendarID: null,
                messageText: '',
                timer: 0,
                recording: false, // This will track if recording is active
                roomID: null,
                isProcessing: false, // NEW: Prevent double clicks/triggers
                sessionEndHandled: false,
                sessionStartedManually: false,
                sessionType: 'Video',
                showNotesModal: false,
                notesModalUrl: null,
                notesStatusMessage: '',
                showOnboardingAnswersModal: false,
                showOnboardingIssueModal: false,
                onboardingLoading: false,
                onboardingPatientLabel: '',
                onboardingQa: [],
                onboardingIssue: '',

                async markTherapistEntered() {
                    if (!this.currentCalendarID) return;
                    await fetch('/therapist/session/entered-waiting-room', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            calendar_id: this.currentCalendarID
                        })
                    });
                },

                async startSession(calendarID) {
                    try {
                        const res = await fetch('/therapist/session/start', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                calendar_id: calendarID
                            })
                        });

                        if (!res.ok) {
                            const text = await res.text();
                            console.error('START SESSION FAILED:', text);
                            alert('Session start failed — check console');
                            return;
                        }

                        const data = await res.json();
                        console.log('SESSION START RESPONSE:', data);

                        this.sessionEndHandled = false;
                        this.currentCalendarID = calendarID;
                        this.roomID = data.roomID;
                        this.sessionType = data.sessionType;

                        // This calls the Zego SDK
                        this.joinVideoCall();

                    } catch (e) {
                        console.error('START SESSION ERROR:', e);
                        alert('JS error — check console');
                    }
                },

                async joinVideoCall() {
                    if (window.ZEGO_LOCK) return;
                    window.ZEGO_LOCK = true;
                    this.showSession = false;

                    try {
                        const res = await fetch(`/video/token?roomID=${this.roomID}`);
                        const data = await res.json();

                        const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                            Number(data.appID),
                            data.serverSecret,
                            this.roomID,
                            data.userID.toString(),
                            data.userName
                        );

                        const container = document.getElementById("videoContainer");
                        window.ZEGO_INSTANCE = ZegoUIKitPrebuilt.create(kitToken);

                        window.ZEGO_INSTANCE.joinRoom({
                            container,
                            scenario: {
                                //mode: ZegoUIKitPrebuilt.OneOnOneCall
                                mode: ZegoUIKitPrebuilt.GroupCall
                            },
                            showPreJoinView: false,
                            turnOnCameraWhenJoining: this.sessionType !== 'Audio',
                            turnOnMicrophoneWhenJoining: true,
                            showTextChat: true,
                            showUserList: true,
                            maxUsers: 2,

                            // 🟢 AUTO-START RECORDING WHEN ROOM IS READY
                            onJoinRoom: () => {
                                console.log('Successfully joined room...');
                                this.sessionStartedManually = true;
                                // We wait 3 seconds to ensure the media stream is stable
                                // setTimeout(() => {
                                //     this.triggerAutoRecording();
                                // }, 3000);
                            },

                            onLeaveRoom: async (reason) => {
                                console.log('Leave reason:', reason);
                                console.log('Therapist left room → ending session');
                                console.log('ON LEAVE ROOM TRIGGERED');
                                console.log('SESSION END HANDLED:', this.sessionEndHandled);
                                

                                // 🚨 detect auto-leave vs manual leave
                                if (!this.sessionStartedManually) {
                                    console.log('Auto leave detected — ignoring');
                                    window.ZEGO_LOCK = false;
                                    return;
                                }

                                if (!this.currentCalendarID || this.sessionEndHandled) {
                                    window.ZEGO_LOCK = false;
                                    return;
                                }
                            
                                this.sessionEndHandled = true; // ✅ ADD HERE

                                    // ❌ ADD THIS  LINE (IMPORTANT)
                                    if (window.ZEGO_INSTANCE) {
                                        window.ZEGO_INSTANCE = null;
                                    }

                                const res = await fetch('/therapist/session/end', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        calendar_id: this.currentCalendarID
                                    })
                                });

                                if (res.ok) {
                                   const data = await res.json();

                                    if (!this.showNotesModal) { // ✅ ADD THIS
                                        this.openNotesModal(data.embedded_notes_url || data.notes_url);
                                    }
                                }

                                window.ZEGO_LOCK = false;
                                this.showSession = false;
                            }
                        });

                    } catch (e) {
                        console.error(e);
                        alert('Failed to join session');
                        window.ZEGO_LOCK = false;
                    }
                },

                // 🟢 AUTOMATED RECORDING TRIGGER
                // async triggerAutoRecording() {
                //     // If already recording or already trying to start, STOP.
                //     if (this.recording || this.isProcessing) return;

                //     // 2. Ensure we have the Room ID
                //     if (!this.roomID) {
                //         console.error("Recording failed: No Room ID found in Alpine state");
                //         return;
                //     }

                //     this.isProcessing = true;
                //     console.log('Requesting Recording for Room:', this.roomID);

                //     try {
                //         const response = await fetch('/zego/start-recording', {
                //             method: 'POST',
                //             headers: {
                //                 'Content-Type': 'application/json',
                //                 'Accept': 'application/json',
                //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                //             },
                //             body: JSON.stringify({
                //                 room_id: this.roomID,
                //                 start: true
                //             })
                //         });

                //         const data = await response.json();

                //         if (response.ok && data.task_id) {
                //             this.recording = true;
                //             console.log('✅ Recording Started. Task ID:', data.task_id);
                //         } else {
                //             console.error('❌ Zego Rejected Storage/Params:', data.debug);
                //             // This alerts you to exactly what Zego said
                //             alert("Zego Error: " + (data.debug?.Message || "Check Storage Config"));
                //         }
                //     } catch (error) {
                //         console.error('Network Error:', error);
                //     } finally {
                //         this.isProcessing = false;
                //     }

                // },

                async endSession() {
                    console.log('END SESSION CLICKED');
                    if (!this.currentCalendarID || this.sessionEndHandled) return;

                     this.sessionEndHandled = true; // ✅ MOVE THIS UP 

                     if (window.ZEGO_INSTANCE) {
                        window.ZEGO_INSTANCE.leaveRoom();
                        window.ZEGO_INSTANCE.destroy();
                        window.ZEGO_INSTANCE = null;
                    }

                    const res = await fetch('/therapist/session/end', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            calendar_id: this.currentCalendarID
                        })
                    });

                    this.showSession = false;

                    if (res.ok) {
                        const data = await res.json();
                    
                        if (!this.showNotesModal) { // ✅ ADD THIS
                            this.openNotesModal(data.embedded_notes_url || data.notes_url);
                        }
                    }

                    window.ZEGO_LOCK = false;
                },

                openNotesModal(notesUrl) {
                    if (!notesUrl || this.showNotesModal) return; // ✅ prevent reopen

                    this.notesModalUrl = `${notesUrl}${notesUrl.includes('?') ? '&' : '?'}modal_ts=${Date.now()}`;
                    this.showNotesModal = true;
                },

                closeNotesModal() {
                    this.showNotesModal = false;
                    this.notesModalUrl = null;
                },

                openMessageModal(clientName, patientID) {
                    this.messageClient = clientName;
                    this.currentPatientID = patientID; 
                    this.messageText = '';
                    this.showMessageModal = true;
                },

                async sendMessage() {
                    if (!this.messageText.trim()) return;
                    const res = await fetch('/chat/store-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            to_user_id: this.currentPatientID,
                            to_user_type: 1,
                            message: this.messageText
                        })
                    });
                    this.showMessageModal = false;
                    this.messageText = '';
                },

                // Manual toggle if you still want the button to work
                // async toggleRecording() {
                //     const action = !this.recording;
                //     const response = await fetch('/zego/start-recording', {
                //         method: 'POST',
                //         headers: {
                //             'Content-Type': 'application/json',
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                //             'Accept': 'application/json'
                //         },
                //         body: JSON.stringify({
                //             room_id: this.roomID,
                //             start: action
                //         })
                //     });

                //     if (response.ok) {
                //         this.recording = action;
                //         alert(action ? 'Recording started' : 'Recording stopped');
                //     }
                // },

                async openOnboardingAnswers(patientId, patientUserName) {
                    this.onboardingPatientLabel = patientUserName ? `(${patientUserName})` : '';
                    this.showOnboardingAnswersModal = true;
                    this.showOnboardingIssueModal = false;
                    this.onboardingLoading = true;
                    this.onboardingQa = [];

                    try {
                        const res = await fetch("{{ route('therapist.onboarding.qa') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ patient_id: Number(patientId) })
                        });

                        const json = await res.json();
                        this.onboardingQa = json.data || [];
                    } catch (e) {
                        console.error(e);
                        alert('Failed to load onboarding answers');
                    } finally {
                        this.onboardingLoading = false;
                    }
                },

                async openOnboardingIssue(patientId, patientUserName) {
                    this.onboardingPatientLabel = patientUserName ? `(${patientUserName})` : '';
                    this.showOnboardingIssueModal = true;
                    this.showOnboardingAnswersModal = false;
                    this.onboardingLoading = true;
                    this.onboardingIssue = '';

                    try {
                        const res = await fetch("{{ route('therapist.onboarding.issue') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ patient_id: Number(patientId) })
                        });

                        const json = await res.json();
                        this.onboardingIssue = json?.data?.issue_summary || '';
                    } catch (e) {
                        console.error(e);
                        alert('Failed to load issue summary');
                    } finally {
                        this.onboardingLoading = false;
                    }
                }
            }
        }
    </script>

</x-app1>   
