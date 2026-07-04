{{--
    Add this block to your existing login.blade.php, next to the normal
    email/password form. It works as an alternative login method — the
    regular form stays untouched.
--}}

<script>
    const FACE_LOGIN_MODELS_URL = '/models/face-api';

    window.faceLogin = () => {
        let modelsLoaded = false;
        let stream = null;
        let scanning = false;
        let scanTimer = null;

        return {
            modalOpen: false,
            cameraStarted: false,
            isLoading: false,
            statusMessage: '',
            statusIsError: false,
            attemptsWithoutMatch: 0,

            openModal() {
                this.modalOpen = true;
                this.statusMessage = '';
                this.statusIsError = false;
                this.attemptsWithoutMatch = 0;
                this.startCamera();
            },

            closeModal() {
                this.modalOpen = false;
                this.stopEverything();
            },

            async startCamera() {
                this.isLoading = true;
                try {
                    if (!modelsLoaded) {
                        this.statusMessage = 'Loading face model…';
                        await faceapi.nets.tinyFaceDetector.loadFromUri(FACE_LOGIN_MODELS_URL);
                        await faceapi.nets.faceLandmark68Net.loadFromUri(FACE_LOGIN_MODELS_URL);
                        await faceapi.nets.faceRecognitionNet.loadFromUri(FACE_LOGIN_MODELS_URL);
                        modelsLoaded = true;
                    }

                    const video = this.$refs.loginVideo;
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                        audio: false,
                    });
                    video.srcObject = stream;
                    await video.play();

                    this.cameraStarted = true;
                    this.statusMessage = 'Hold still and look at the camera…';
                    this.scanLoop();
                } catch (error) {
                    console.error('Face login camera/model failed:', error);
                    this.statusMessage = this.friendlyError(error);
                    this.statusIsError = true;
                    this.stopEverything();
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
                return 'Could not start face login (' + (error?.message || 'unknown error') + '). Please use your password instead.';
            },

            // Scans roughly every 900ms while the modal is open.
            scanLoop() {
                if (scanning) return;
                scanning = true;

                const tick = async () => {
                    if (!this.modalOpen || !this.cameraStarted) {
                        scanning = false;
                        return;
                    }

                    const video = this.$refs.loginVideo;
                    const detection = await faceapi
                        .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                    if (detection) {
                        await this.tryLogin(Array.from(detection.descriptor));
                    }

                    if (this.modalOpen && this.cameraStarted) {
                        scanTimer = setTimeout(tick, 900);
                    } else {
                        scanning = false;
                    }
                };

                tick();
            },

            async tryLogin(descriptor) {
                this.statusIsError = false;
                this.statusMessage = 'Checking…';

                try {
                    const res = await fetch('{{ route('login.face') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ descriptor }),
                    });
                    const data = await res.json();

                    if (res.ok) {
                        this.statusMessage = data.message;
                        this.stopEverything();
                        window.location.href = data.redirect;
                        return;
                    }

                    this.attemptsWithoutMatch++;
                    this.statusMessage = data.message;
                    this.statusIsError = true;

                    if (res.status === 429 || this.attemptsWithoutMatch >= 6) {
                        this.statusMessage += ' Please use your password to log in.';
                        this.stopEverything();
                        this.modalOpen = false;
                    }
                } catch (error) {
                    this.statusMessage = 'Connection error. Please use your password instead.';
                    this.statusIsError = true;
                }
            },

            stopEverything() {
                this.cameraStarted = false;
                clearTimeout(scanTimer);
                scanning = false;
                if (stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                }
                const video = this.$refs.loginVideo;
                if (video) video.srcObject = null;
            },
        };
    };
</script>

<script src="/js/face-api.min.js"></script>

<div x-data="faceLogin()">
    <button type="button" @click="openModal()"
        class="w-full mt-3 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-2">
        📷 Login with Face
    </button>

    <template x-if="modalOpen">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 relative">
                <button @click="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>
                <h3 class="font-semibold text-gray-800 mb-3">Face Login</h3>

                <div class="relative bg-black rounded-lg overflow-hidden" style="aspect-ratio:4/3;">
                    <video x-ref="loginVideo" class="w-full h-full object-cover" autoplay playsinline muted></video>
                </div>

                <p x-show="statusMessage" x-text="statusMessage"
                    :class="statusIsError ? 'text-red-600' : 'text-gray-600'"
                    class="mt-3 text-sm text-center"></p>

                <button @click="closeModal()" class="w-full mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Use password instead
                </button>
            </div>
        </div>
    </template>
</div>
