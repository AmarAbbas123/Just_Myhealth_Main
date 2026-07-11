<x-app1>

<script>
    const FACE_MODELS_URL = '/models/face-api';
    const REQUIRED_SAMPLES = 3;

    window.faceRegistration = (config) => {
        // Kept out of Alpine's reactive object on purpose (same reason as the
        // workout AI page): face-api.js internal model state and detection
        // results should not be wrapped in a reactivity Proxy.
        let modelsLoaded = false;
        let stream = null;
        let detectTimer = null;

        return {
            alreadyRegistered: config.alreadyRegistered,
            registeredAt: config.registeredAt,

            cameraStarted: false,
            isLoading: false,
            statusMessage: '',
            statusIsError: false,
            samples: [],       // plain arrays (not Float32Array) of 128 numbers
            required: REQUIRED_SAMPLES,
            saving: false,
            saved: false,

            async startCamera() {
                this.statusMessage = '';
                this.statusIsError = false;
                this.isLoading = true;
                this.samples = [];

                try {
                    if (!modelsLoaded) {
                        this.statusMessage = 'Loading face model…';
                        await faceapi.nets.tinyFaceDetector.loadFromUri(FACE_MODELS_URL);
                        await faceapi.nets.faceLandmark68Net.loadFromUri(FACE_MODELS_URL);
                        await faceapi.nets.faceRecognitionNet.loadFromUri(FACE_MODELS_URL);
                        modelsLoaded = true;
                    }

                    const video = this.$refs.video;
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                        audio: false,
                    });
                    video.srcObject = stream;
                    await video.play();

                    this.cameraStarted = true;
                    this.statusMessage = `Look straight at the camera, then capture ${this.required} samples.`;
                } catch (error) {
                    console.error('Face registration camera/model failed:', error);
                    this.statusMessage = this.friendlyError(error);
                    this.statusIsError = true;
                    this.stopCamera();
                } finally {
                    this.isLoading = false;
                }
            },

            friendlyError(error) {
                if (error?.name === 'NotAllowedError') {
                    return 'Camera permission was blocked. Allow camera access and try again.';
                }
                if (error?.name === 'NotFoundError') {
                    return 'No webcam was found.';
                }
                return 'Could not start the camera or face model (' + (error?.message || 'unknown error') + '). Check your internet connection and try again.';
            },

            async captureSample() {
                if (this.samples.length >= this.required) return;

                this.statusIsError = false;
                const video = this.$refs.video;

                const detection = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!detection) {
                    this.statusMessage = 'No face detected — make sure your face is well lit and centered.';
                    this.statusIsError = true;
                    return;
                }

                this.samples.push(Array.from(detection.descriptor));
                this.statusMessage = this.samples.length < this.required
                    ? `Sample ${this.samples.length}/${this.required} captured. Move slightly and capture again.`
                    : `All ${this.required} samples captured. Click "Save Face" to finish.`;
            },

            async saveFace() {
                if (this.samples.length < this.required) return;
                this.saving = true;
                this.statusIsError = false;

                try {
                    const res = await fetch('{{ route('settings.face-login.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ samples: this.samples }),
                    });
                    const data = await res.json();

                    if (!res.ok) throw new Error(data.message || 'Could not save face.');

                    this.saved = true;
                    this.alreadyRegistered = true;
                    this.statusMessage = data.message;
                    this.stopCamera();
                } catch (error) {
                    this.statusMessage = error.message;
                    this.statusIsError = true;
                } finally {
                    this.saving = false;
                }
            },

            async removeFace() {
                if (!confirm('Turn off face login for your account?')) return;

                try {
                    const res = await fetch('{{ route('settings.face-login.destroy') }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();
                    this.alreadyRegistered = false;
                    this.saved = false;
                    this.statusMessage = data.message;
                    this.statusIsError = false;
                } catch (error) {
                    this.statusMessage = 'Could not remove face login. Try again.';
                    this.statusIsError = true;
                }
            },

            stopCamera() {
                this.cameraStarted = false;
                clearTimeout(detectTimer);
                if (stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                }
                const video = this.$refs.video;
                if (video) video.srcObject = null;
            },
        };
    };
</script>

<script src="/js/face-api.min.js"></script>

<div class="space-y-6" x-data="faceRegistration({
    alreadyRegistered: @js($faceRegistered),
    registeredAt: @js($registeredAt),
})">

    <div class="flex justify-between mb-4">
        <x-page-header />
    </div>

    <div class="bg-white shadow rounded-xl p-6 border border-gray-100 max-w-2xl">
        <h2 class="text-xl font-semibold text-gray-800">Face Login</h2>
        <p class="text-gray-500 text-sm mt-1">
            Register your face so you can log in with a camera scan instead of typing your password.
            You can still log in with your password at any time.
        </p>

        <template x-if="alreadyRegistered && !cameraStarted">
            <div class="mt-4 flex items-center gap-3">
                <span class="inline-flex items-center gap-1 text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm font-medium">
                    ✓ Face login is set up
                </span>
                <button @click="startCamera()" class="text-sm text-indigo-600 underline hover:text-indigo-800">
                    Re-scan face
                </button>
                <button @click="removeFace()" class="text-sm text-red-600 underline hover:text-red-800">
                    Turn off
                </button>
            </div>
        </template>

        <template x-if="!alreadyRegistered && !cameraStarted">
            <button @click="startCamera()" :disabled="isLoading"
                class="mt-4 px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition disabled:opacity-60">
                <span x-text="isLoading ? 'Starting…' : 'Register My Face'"></span>
            </button>
        </template>

        {{-- The video element must always stay mounted (x-show, not x-if/template)
             so that $refs.video already exists the moment startCamera() runs.
             With x-if, the element (and the ref) doesn't exist until AFTER
             cameraStarted flips true — but startCamera() needs the ref
             BEFORE that point, causing "Cannot set properties of undefined". --}}
        <div class="mt-4 space-y-3" x-show="cameraStarted" style="display:none;">
            <div class="relative bg-black rounded-lg overflow-hidden" style="max-width:480px; aspect-ratio:4/3;">
                <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline muted></video>
            </div>

            <div class="flex items-center gap-3">
                <button @click="captureSample()" :disabled="samples.length >= required"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition disabled:opacity-50">
                    Capture Sample (<span x-text="samples.length"></span>/<span x-text="required"></span>)
                </button>
                <button x-show="samples.length >= required" @click="saveFace()" :disabled="saving"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-60">
                    <span x-text="saving ? 'Saving…' : 'Save Face'"></span>
                </button>
                <button @click="stopCamera()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
            </div>
        </div>

        <p x-show="statusMessage" x-text="statusMessage"
            :class="statusIsError ? 'text-red-600' : 'text-gray-600'"
            class="mt-3 text-sm"></p>
    </div>
</div>

</x-app1>