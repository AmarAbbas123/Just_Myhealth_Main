<x-guest-layout>
    @if (session('error'))
        <div class="mb-4 p-3 text-sm text-red-600 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    @if (session('status'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <script>
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
                            await faceapi.nets.tinyFaceDetector.loadFromUri('/models/face-api');
                            await faceapi.nets.faceLandmark68Net.loadFromUri('/models/face-api');
                            await faceapi.nets.faceRecognitionNet.loadFromUri('/models/face-api');
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

    <div class="min-h-screen flex items-center bg-slate-100 py-6">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-300/40 lg:grid-cols-2">

                <!-- Visual side -->
                <div class="relative hidden overflow-hidden lg:block">
                    <img src="{{ asset('images/bg-1.jpg') }}" alt="Sign in" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent"></div>

                    <div class="absolute inset-x-0 top-0 p-5">
                        <div class="flex items-center gap-2 text-white">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 backdrop-blur">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-semibold tracking-wide">JustMy.Health</span>
                        </div>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.3em] text-white backdrop-blur">
                            Welcome back
                        </span>
                        <p class="mt-3 max-w-sm text-sm leading-6 text-white/80">
                            Your health records, appointments, and care team — all in one secure place. Sign in to pick up right where you left off.
                        </p>
                    </div>
                </div>

                <!-- Form side -->
                <div class="px-6 py-5 sm:px-10 sm:py-6">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFBFA] px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#1C9BA0]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#1C9BA0]"></span>
                        Sign in
                    </span>

                    <!-- Social login -->
                    <div class="mt-4">
                        <div class="grid grid-cols-3 gap-3">
                            <a href="{{ route('social.redirect', 'google') }}"
                                class="group flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-[#1C9BA0]/40 hover:bg-[#F7FCFC]">
                                <img src="{{ asset('images/google-brands.svg') }}" alt="Google" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('social.redirect', 'facebook') }}"
                                class="group flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-[#1C9BA0]/40 hover:bg-[#F7FCFC]">
                                <img src="{{ asset('images/facebook-f-brands.svg') }}" alt="Facebook" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('social.redirect', 'twitter') }}"
                                class="group flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-[#1C9BA0]/40 hover:bg-[#F7FCFC]">
                                <img src="{{ asset('images/x-twitter-brands.svg') }}" alt="Twitter" class="h-4 w-4" />
                            </a>
                        </div>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="h-px flex-1 bg-slate-200"></span>
                            <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Or sign in with email</span>
                            <span class="h-px flex-1 bg-slate-200"></span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-[10px] border border-red-200 bg-red-50 p-3 text-sm text-red-700 mt-3">
                            <ul class="list-disc list-inside pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.perform') }}" x-data="{ username: '', showPassword: false, error: '' }"
                        class="mt-3 w-full space-y-3">
                        @csrf

                        <div>
                            <label for="UserName" class="text-sm font-semibold text-slate-700">{{ __('Username') }}</label>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input id="UserName" type="text" name="UserName" value="{{ old('UserName') }}"
                                    class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm"
                                    x-model="username"
                                    @input="
                                        if (/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(username)) {
                                            error = '❌ Only Username is allowed, not Email.';
                                        } else {
                                            error = '';
                                        }
                                    "
                                    x-bind:class="error.length > 0 ? 'border-red-400 focus:border-red-400 focus:ring-red-400' : ''"
                                    required autofocus autocomplete="username" />
                            </div>
                            <p x-show="error" x-text="error" class="text-red-600 text-xs mt-1.5 font-medium"></p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="Password" class="text-sm font-semibold text-slate-700">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a class="text-xs font-medium text-[#1C9BA0] hover:text-[#18848F] hover:underline" href="{{ route('password.request') }}">
                                        {{ __('Forgot password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input id="Password"
                                    class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-12 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm"
                                    :type="showPassword ? 'text' : 'password'" name="Password" required autocomplete="current-password" />
                                <button type="button"
                                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                                    @click="showPassword = !showPassword">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.127-3.592M6.343 6.343A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.132 4.132M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <input id="remember_me" type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-[#1C9BA0] focus:ring-[#1C9BA0]" name="remember">
                            <label for="remember_me" class="text-sm text-slate-600">{{ __('Remember me') }}</label>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center rounded-[10px] bg-[#1C9BA0] px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#1C9BA0]/25 transition hover:bg-[#18848F] hover:shadow-xl hover:shadow-[#1C9BA0]/30"
                            x-bind:disabled="error.length > 0"
                            x-bind:class="{ 'opacity-50 cursor-not-allowed': error.length > 0 }">
                            {{ __('Log in') }}
                        </button>
                    </form>

                    <!-- Face login: real logic wired to window.faceLogin() above -->
                    <div class="mt-4" x-data="faceLogin()">
                        <div class="flex items-center gap-3">
                            <span class="h-px flex-1 bg-slate-200"></span>
                            <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Or use face login</span>
                            <span class="h-px flex-1 bg-slate-200"></span>
                        </div>

                        <button type="button" @click="openModal()"
                            class="mt-3 flex w-full items-center justify-center gap-2 rounded-[10px] border border-[#1C9BA0]/30 bg-[#EAFBFA] px-4 py-2.5 text-sm font-semibold text-[#18848F] shadow-sm transition hover:bg-[#1C9BA0]/10 hover:border-[#1C9BA0]/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7V5a1 1 0 011-1h2M4 17v2a1 1 0 001 1h2m10-14h2a1 1 0 011 1v2m-4 12h2a1 1 0 001-1v-2M9 10h.01M15 10h.01M9.5 15c.7.6 1.6 1 2.5 1s1.8-.4 2.5-1" />
                            </svg>
                            Sign in with Face ID
                        </button>

                        <!-- Modal -->
                        <template x-if="modalOpen">
                            <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4">
                                <div class="bg-white rounded-[1.5rem] shadow-xl w-full max-w-sm p-6 relative">
                                    <button @click="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">✕</button>
                                    <h3 class="font-semibold text-slate-800 mb-3">Face Login</h3>

                                    <div class="relative bg-slate-900 rounded-2xl overflow-hidden" style="aspect-ratio:4/3;">
                                        <video x-ref="loginVideo" class="w-full h-full object-cover" autoplay playsinline muted></video>
                                    </div>

                                    <p x-show="statusMessage" x-text="statusMessage"
                                        :class="statusIsError ? 'text-red-600' : 'text-slate-500'"
                                        class="mt-3 text-sm text-center"></p>

                                    <button @click="closeModal()"
                                        class="w-full mt-4 px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-[10px] hover:bg-slate-200 transition">
                                        Use password instead
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <p class="text-center text-sm mt-4 text-slate-500">
                        {{ __('Not a member?') }}
                        <a href="{{ route('register') }}" class="font-semibold text-[#1C9BA0] hover:text-[#18848F] hover:underline">
                            {{ __('Sign up') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>