<x-app1>
    <script>
        window.ZEGO_PATIENT = null;
        window.ZEGO_PATIENT_LOCK = false;
    </script>


    <div class="min-h-[80vh] flex items-center justify-center px-4">
        <div class="w-full max-w-xl bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 text-center">

            <!-- Header -->
            <div class="flex justify-between mb-4">
                <x-page-header />
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Please wait until your therapist starts the session.
            </p>

            <div id="patientVideoContainer"
                class="w-full h-[55vh] rounded-lg border border-dashed border-gray-300 dark:border-gray-700
                       flex items-center justify-center bg-gray-50 dark:bg-gray-800">

                <button id="joinSessionBtn" onclick="startPatientSession('{{ request('roomID') }}')"
                    class="px-8 py-3 bg-green-600 hover:bg-green-700
                           text-white text-base font-medium rounded-lg
                           transition-all duration-200 shadow-md">
                    Join Session
                </button>

            </div>

        </div>
    </div>


    {{-- zegocloud video Session  --}}
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt@2.9.3/zego-uikit-prebuilt.js"></script>
    {{-- <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script> --}}
    {{-- <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt@latest/zego-uikit-prebuilt.js"></script> --}}

    <script>
        const sessionID = @json($sessionId);
        async function startPatientSession() {

            if (window.ZEGO_PATIENT_LOCK) return;
            window.ZEGO_PATIENT_LOCK = true;

            const roomID = @json($roomID);
            const sessionType = 'Video';

            if (!roomID) {
                alert("Invalid session link.");
                return;
            }

            try {
                // 1️⃣ Get Zego token
                const res = await fetch(`/video/token?roomID=${roomID}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) throw new Error('Token fetch failed');

                const data = await res.json();

                // 2️⃣ Create Zego instance
                const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                    Number(data.appID),
                    data.serverSecret,
                    roomID,
                    data.userID,
                    data.userName || 'Patient'
                );

                window.ZEGO_PATIENT = ZegoUIKitPrebuilt.create(kitToken);

                document.getElementById('joinSessionBtn')?.remove();

                // 3️⃣ Join Zego room
                window.ZEGO_PATIENT.joinRoom({
                    container: document.getElementById("patientVideoContainer"),
                    scenario: {
                        mode: ZegoUIKitPrebuilt.OneOnOneCall
                    },
                    showPreJoinView: false,
                    turnOnCameraWhenJoining: sessionType !== 'Audio',
                    turnOnMicrophoneWhenJoining: true,
                    showTextChat: true,
                    showUserList: true,
                    maxUsers: 2,
                });

                // 4️⃣ Notify backend (DB update ONLY)
                const joinRes = await fetch('/patient/session/joined', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        roomID,
                        sessionID
                    })
                });

                if (!joinRes.ok) {
                    throw new Error('Failed to record patient entry');
                }

                console.log('Patient successfully joined & recorded');

            } catch (err) {
                console.error("Patient join error:", err);
                alert("Failed to join session.");
                window.ZEGO_PATIENT_LOCK = false;
            }
        }
    </script>


</x-app1>
