<!-- resources/views/therapdashboard/waiting-room.blade.php -->
<x-app1>
    {{-- <script> window.WAITING_ROOM_ID = @json($roomID); </script> --}}
    <script>
        window.ZEGO_LOCK = false;
        window.ZEGO_INSTANCE = null;
    </script>

    <div x-data="waitingRoomApp()" class="space-y-6">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <x-page-header />
        </div>

        <!-- Waiting List Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead>
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

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($sessions as $session)
                        <tr>
                            <td class="py-3 flex items-center gap-3">
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
                                        {{ $session->SessionDateTimeFrom->format('H:i') }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-gray-500">
                                {{ optional($session->patient->userAttributes)->FirstName }}
                                {{ optional($session->patient->userAttributes)->LastName }}
                            </td>

                            <td class="text-gray-500">
                                {{ $session->SessionDateTimeFrom->format('Y-m-d H:i') }}
                            </td>

                            <td class="text-gray-500">
                                {{ $session->SessionType }}
                            </td>

                            <td>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">
                                    Scheduled
                                </span>
                            </td>

                            @php $clientName = optional($session->patient->userAttributes)->FirstName; @endphp

                            <td class="py-3 text-right align-middle">
                                <div class="flex justify-end items-center gap-2 h-full">

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

        <!-- Start Session Modal -->
        <div x-show="showSession" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div @click.away="showSession=false"
                class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Session with <span
                            x-text="currentClient"></span></h3>
                    <button @click="showSession=false" class="text-gray-500">✕</button>
                </div>
                <div class="text-sm text-gray-500">Manage live session controls below:</div>

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
        <div x-show="showMessageModal" x-transition
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

        <div id="videoContainer" class="w-full h-[70vh] mt-4 rounded-lg overflow-hidden"></div>

    </div>

    {{-- zegocloud video Session  --}}
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt@2.9.3/zego-uikit-prebuilt.js"></script>

    <script>
        window.waitingRoomApp = function() {
            return {
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
                sessionType: 'Video',

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
                                mode: ZegoUIKitPrebuilt.OneOnOneCall
                            },
                            showPreJoinView: false,
                            turnOnCameraWhenJoining: this.sessionType !== 'Audio',
                            turnOnMicrophoneWhenJoining: true,
                            showTextChat: true,
                            showUserList: true,
                            maxUsers: 2,

                            // 🟢 TRIGGER RECORDING IMMEDIATELY UPON JOINING
                            onJoinRoom: () => {
                                console.log('Joined room. Triggering recording...');
                                // We don't wait for 'PUBLISHING' state anymore. 
                                // We fire it now, but keep the small delay in triggerAutoRecording to let Zego catch up.
                                // this.triggerAutoRecording();   // ❌ COMMENTED – disables auto recording
                            },

                            onPublisherStateUpdate: (result) => {
                                console.log('Publisher State:', result.state);
                            },

                            onReturn: (error) => {
                                console.error("ZEGO SDK ERROR:", error);
                            },

                            onLeaveRoom: async () => {
                                // Force stop recording if therapist leaves unexpectedly
                                if (this.recording && !this.isProcessing) {
                                    console.log("Unexpected leave detected, stopping recording...");
                                    // fetch('/zego/start-recording', {
                                    //     method: 'POST',
                                    //     headers: {
                                    //         'Content-Type': 'application/json',
                                    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    //     },
                                    //     body: JSON.stringify({
                                    //         room_id: this.roomID,
                                    //         start: false
                                    //     })
                                    // });
                                }

                                if (this.currentCalendarID) {
                                    await fetch('/therapist/session/end', {
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
                                }
                                window.ZEGO_LOCK = false;
                                window.ZEGO_INSTANCE = null;
                            }
                        });

                    } catch (e) {
                        console.error("JOIN CALL ERROR:", e);
                        alert('Failed to join session');
                        window.ZEGO_LOCK = false;
                    }
                },

                // 🟢 AUTOMATED RECORDING TRIGGER
                // async triggerAutoRecording() {
                //     // If already recording or already trying to start, STOP.
                //     if (this.recording || this.isProcessing) return;

                //     this.isProcessing = true;

                //     // Add a 3-second delay to ensure the stream is fully established on Zego's servers
                //     console.log('Waiting for stream stability...');
                //     await new Promise(resolve => setTimeout(resolve, 3000));

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
                //         console.error('Recording Trigger Error:', error);
                //     } finally {
                //         this.isProcessing = false;
                //     }

                // },

                async endSession() {
                    if (!this.currentCalendarID) {
                        alert('Calendar ID missing');
                        return;
                    }

                    // 1. Explicitly stop Zego Recording first
                    // if (this.recording) {
                    //     console.log("Stopping recording...");
                    //     try {
                    //         await fetch('/zego/start-recording', {
                    //             method: 'POST',
                    //             headers: {
                    //                 'Content-Type': 'application/json',
                    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    //             },
                    //             body: JSON.stringify({
                    //                 room_id: this.roomID,
                    //                 start: false // Triggers the STOP logic in controller
                    //             })
                    //         });
                    //         this.recording = false;
                    //     } catch (e) {
                    //         console.error("Stop recording failed", e);
                    //     }
                    // }

                    // 2. Mark session ended in your DB
                    await fetch('/therapist/session/end', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            calendar_id: this.currentCalendarID
                        })
                    });

                    // 3. Clean up Zego UI
                    if (window.ZEGO_INSTANCE) {
                        window.ZEGO_INSTANCE.leaveRoom();
                        window.ZEGO_INSTANCE.destroy();
                        window.ZEGO_INSTANCE = null;
                    }                    
                    location.reload(); // Refresh to show the link in the table
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
                // }
            }
        }
    </script>

</x-app1>
