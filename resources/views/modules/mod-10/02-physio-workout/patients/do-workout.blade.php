<x-app1>

<script>
    // Define the Alpine component before Alpine scans x-data.
    // MediaPipe is loaded lazily when the patient starts the camera.
    const WORKOUT_JOINT_MAP = {
        knee: {
            left: [23, 25, 27],
            right: [24, 26, 28],
        },
        shoulder: {
            left: [23, 11, 13],
            right: [24, 12, 14],
        },
        elbow: {
            left: [11, 13, 15],
            right: [12, 14, 16],
        },
        hip: {
            left: [11, 23, 25],
            right: [12, 24, 26],
        },
    };

    function workoutAngleBetween(a, b, c) {
        const radians = Math.atan2(c.y - b.y, c.x - b.x) - Math.atan2(a.y - b.y, a.x - b.x);
        let angle = Math.abs(radians * 180 / Math.PI);
        if (angle > 180) angle = 360 - angle;
        return angle;
    }

    window.workoutChecker = (config) => {
        // IMPORTANT: MediaPipe task objects must NOT live inside Alpine's
        // reactive x-data. Alpine (via @vue/reactivity) wraps everything in
        // x-data in a Proxy. MediaPipe's PoseLandmarker keeps internal state
        // (e.g. whether it's running in VIDEO vs IMAGE mode) tied to the real
        // object identity. Once you call methods on the Proxy instead of the
        // raw instance, that internal check breaks and MediaPipe throws:
        //   "Task is not initialized with video mode. 'runningMode' must be
        //    set to 'VIDEO'."
        // Fix: keep the landmarker (and the MediaPipe classes) in a plain
        // object OUTSIDE the reactive data, accessed via closure.
        const native = {
            landmarker: null,
            PoseLandmarkerClass: null,
            DrawingUtilsClass: null,
        };

        return {
            exerciseType: config.exerciseType,
            rule: typeof config.angleRule === 'string' ? JSON.parse(config.angleRule) : config.angleRule,
            repsTarget: config.repsTarget,
            submitUrl: config.submitUrl,
            csrfToken: config.csrfToken,

            cameraStarted: false,
            isLoadingCamera: false,
            cameraError: '',
            submitted: false,
            submitMessage: '',

            repsCompleted: 0,
            repsGoodForm: 0,
            repsBadForm: 0,
            currentAngle: 180,
            feedbackText: 'Position yourself so your full body is visible',
            feedbackColor: 'bg-slate-800/80 text-white',
            guidanceTitle: 'Get ready',
            guidanceText: 'Stand in frame and begin the movement slowly.',
            guidanceTone: 'bg-[#E7FAF8] text-slate-700',

            repState: 'up',
            currentRepMinAngle: 180,
            currentRepMaxAngle: 0,
            repDetails: [],
            startTime: null,

            async init() {
                this.startTime = Date.now();

                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    this.cameraError = 'Camera access is not available in this browser. Use Chrome/Edge on localhost or HTTPS.';
                }
            },

            getBodyPartLabel() {
                const joint = this.rule?.joint || 'shoulder';
                const labels = {
                    shoulder: 'arm',
                    elbow: 'arm',
                    knee: 'leg',
                    hip: 'hip',
                };
                return labels[joint] || 'body';
            },

            setGuidance(title, text, tone = 'bg-[#E7FAF8] text-slate-700') {
                this.guidanceTitle = title;
                this.guidanceText = text;
                this.guidanceTone = tone;
            },

            async startCamera() {
                this.cameraError = '';
                this.isLoadingCamera = true;
                this.submitted = false;
                this.startTime = Date.now();

                try {
                    const video = this.$refs.video;
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'user',
                            width: { ideal: 1280 },
                            height: { ideal: 720 },
                        },
                        audio: false,
                    });

                    video.srcObject = stream;
                    await new Promise((resolve) => {
                        if (video.readyState >= 2) {
                            resolve();
                            return;
                        }
                        video.onloadedmetadata = resolve;
                    });
                    await video.play();

                    const mediaPipe = await import('https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.14');
                    const vision = await mediaPipe.FilesetResolver.forVisionTasks(
                        'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.14/wasm'
                    );

                    // Store the raw (non-reactive) classes/instance in `native`,
                    // never on `this`.
                    native.PoseLandmarkerClass = mediaPipe.PoseLandmarker;
                    native.DrawingUtilsClass = mediaPipe.DrawingUtils;
                    native.landmarker = await this.createPoseLandmarker(vision, 'GPU');

                    this.cameraStarted = true;
                    this.feedbackText = 'AI model ready. Stand fully in frame.';
                    this.feedbackColor = 'bg-[#1C9BA0]/90 text-white';
                    this.setGuidance('Camera ready', 'Stand tall, keep your whole body visible, and move slowly.', 'bg-[#1C9BA0]/90 text-white');
                    this.detectLoop();
                } catch (error) {
                    this.stopCameraTracks();
                    this.cameraStarted = false;
                    this.cameraError = this.cameraMessage(error);
                    this.feedbackText = this.cameraError;
                    this.feedbackColor = 'bg-red-600/80 text-white';
                    console.error('Workout camera/AI failed:', error);
                } finally {
                    this.isLoadingCamera = false;
                }
            },

            async createPoseLandmarker(vision, delegate) {
                try {
                    return await native.PoseLandmarkerClass.createFromOptions(vision, {
                        baseOptions: {
                            modelAssetPath: 'https://storage.googleapis.com/mediapipe-models/pose_landmarker/pose_landmarker_lite/float16/1/pose_landmarker_lite.task',
                            delegate,
                        },
                        runningMode: 'VIDEO',
                        numPoses: 1,
                    });
                } catch (error) {
                    if (delegate === 'GPU') {
                        return this.createPoseLandmarker(vision, 'CPU');
                    }
                    throw error;
                }
            },

            cameraMessage(error) {
                const details = error?.message ? ` (${error.message})` : '';

                if (error?.name === 'NotAllowedError') {
                    return 'Camera permission was blocked. Allow camera access from the browser address bar and try again.';
                }

                if (error?.name === 'NotFoundError') {
                    return 'No webcam was found. Connect or enable a camera and try again.';
                }

                if (error?.name === 'NotReadableError') {
                    return 'Your webcam is already in use by another app. Close the other app and try again.';
                }

                return `Camera or AI model could not start${details}. Check internet access for MediaPipe and try again.`;
            },

            detectLoop() {
                const video = this.$refs.video;
                const canvas = this.$refs.canvas;
                const ctx = canvas.getContext('2d');
                // DrawingUtils instance is also kept local/native — never on `this`.
                const drawer = new native.DrawingUtilsClass(ctx);

                const loop = () => {
                    if (!this.cameraStarted || !native.landmarker) return;

                    if (video.videoWidth && video.videoHeight) {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                    }

                    const result = native.landmarker.detectForVideo(video, performance.now());
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    if (result.landmarks && result.landmarks.length > 0) {
                        const lm = result.landmarks[0];
                        drawer.drawLandmarks(lm, { radius: 3 });
                        drawer.drawConnectors(lm, native.PoseLandmarkerClass.POSE_CONNECTIONS);
                        this.processAngles(lm);
                    } else {
                        this.feedbackText = 'Make sure your full body is visible';
                        this.feedbackColor = 'bg-slate-800/80 text-white';
                        this.setGuidance('Full body visible', 'Step back a little so your head, torso and limbs are all visible.', 'bg-amber-600/80 text-white');
                    }

                    requestAnimationFrame(loop);
                };

                loop();
            },

            processAngles(landmarks) {
                if (!this.rule?.joint || !WORKOUT_JOINT_MAP[this.rule.joint]) {
                    this.feedbackText = 'This exercise needs an angle rule before AI checking can run.';
                    this.feedbackColor = 'bg-red-600/80 text-white';
                    return;
                }

                const sides = this.rule.side === 'both' ? ['left', 'right'] : [this.rule.side || 'left'];
                const angles = sides.map(side => {
                    const [aIdx, bIdx, cIdx] = WORKOUT_JOINT_MAP[this.rule.joint][side];
                    return workoutAngleBetween(landmarks[aIdx], landmarks[bIdx], landmarks[cIdx]);
                });
                const angle = angles.reduce((sum, a) => sum + a, 0) / angles.length;
                this.currentAngle = angle;

                this.currentRepMinAngle = Math.min(this.currentRepMinAngle, angle);
                this.currentRepMaxAngle = Math.max(this.currentRepMaxAngle, angle);

                const downMax = Number(this.rule.down_angle_max);
                const upMin = Number(this.rule.up_angle_min);
                const tolerance = Number(this.rule.good_form_tolerance ?? 0);
                const part = this.getBodyPartLabel();

                if (this.repState === 'up' && angle <= downMax) {
                    this.repState = 'down';
                    this.feedbackText = 'Good - now return to start';
                    this.feedbackColor = 'bg-[#1C9BA0]/90 text-white';
                    this.setGuidance('Move back', `Lower your ${part} slowly until it reaches about ${downMax}° or less.`, 'bg-[#1C9BA0]/90 text-white');
                } else if (this.repState === 'down' && angle >= upMin) {
                    this.repState = 'up';
                    this.completeRep(downMax, upMin, tolerance);
                } else if (this.repState === 'up') {
                    this.feedbackText = 'Begin the movement';
                    this.feedbackColor = 'bg-slate-800/80 text-white';
                    this.setGuidance('Lift up', `Raise your ${part} slowly until you reach about ${upMin}° or more.`, 'bg-[#E7FAF8] text-slate-700');
                } else {
                    this.feedbackText = 'Keep going...';
                    this.feedbackColor = 'bg-[#1C9BA0]/90 text-white';
                    this.setGuidance('Stay controlled', `Keep lowering your ${part} smoothly and hold the position briefly.`, 'bg-[#1C9BA0]/90 text-white');
                }
            },

            completeRep(downMax, upMin, tolerance) {
                const reachedDepth = this.currentRepMinAngle <= (downMax + tolerance);
                const reachedExtension = this.currentRepMaxAngle >= (upMin - tolerance);
                const isGoodForm = reachedDepth && reachedExtension;

                this.repsCompleted++;
                if (isGoodForm) {
                    this.repsGoodForm++;
                    this.feedbackText = `Rep ${this.repsCompleted} - nice form!`;
                    this.feedbackColor = 'bg-[#1C9BA0]/90 text-white';
                    this.setGuidance('Nice form', 'That rep looked smooth and controlled. Keep the same rhythm.', 'bg-[#1C9BA0]/90 text-white');
                } else {
                    this.repsBadForm++;
                    this.feedbackText = !reachedDepth
                        ? `Rep ${this.repsCompleted} - go deeper next time`
                        : `Rep ${this.repsCompleted} - extend further next time`;
                    this.feedbackColor = 'bg-amber-600/80 text-white';
                    this.setGuidance('Adjust your range', 'Try a slightly deeper or fuller movement next time for better form.', 'bg-amber-600/80 text-white');
                }

                this.repDetails.push({
                    rep: this.repsCompleted,
                    angle_min: Math.round(this.currentRepMinAngle),
                    angle_max: Math.round(this.currentRepMaxAngle),
                    verdict: isGoodForm ? 'good' : 'bad',
                });

                this.currentRepMinAngle = 180;
                this.currentRepMaxAngle = 0;

                if (this.repsCompleted >= this.repsTarget) {
                    setTimeout(() => this.finishSet(), 1200);
                }
            },

            async finishSet() {
                this.cameraStarted = false;
                this.stopCameraTracks();

                const durationSeconds = Math.round((Date.now() - this.startTime) / 1000);
                const avgFormScore = this.repsCompleted > 0
                    ? Math.round((this.repsGoodForm / this.repsCompleted) * 100)
                    : 0;

                try {
                    const res = await fetch(this.submitUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            DurationSeconds: durationSeconds,
                            RepsCompleted: this.repsCompleted,
                            RepsGoodForm: this.repsGoodForm,
                            RepsBadForm: this.repsBadForm,
                            AvgFormScore: avgFormScore,
                            RepDetails: this.repDetails,
                        }),
                    });
                    const data = await res.json();
                    this.submitted = true;
                    this.submitMessage = data.message || 'Session saved.';
                } catch (e) {
                    this.submitMessage = 'Could not save session - check your connection.';
                    this.submitted = true;
                }
            },

            stopCameraTracks() {
                const video = this.$refs.video;
                if (video?.srcObject) {
                    video.srcObject.getTracks().forEach(track => track.stop());
                    video.srcObject = null;
                }
                // Release the MediaPipe instance too, so a restart creates a
                // clean one instead of reusing a possibly-closed graph.
                if (native.landmarker) {
                    try { native.landmarker.close(); } catch (e) { /* noop */ }
                    native.landmarker = null;
                }
            },
        };
    };
</script>

    <div class="space-y-6" x-data="workoutChecker({
        exerciseType: @js($assignment->exercise->ExerciseType),
        angleRule: @js($assignment->exercise->AngleRuleConfig),
        repsTarget: {{ $assignment->RepsTarget }},
        submitUrl: '{{ route('workout.result.store', $assignment) }}',
        csrfToken: '{{ csrf_token() }}'
    })" x-init="init()">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- ============== NEW HEADER ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- Icon + identity block -->
                <div class="flex items-center gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#EAFBFA] text-[#1C9BA0]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">AI-guided exercise</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-0.5 truncate">
                            {{ $assignment->exercise->ExerciseName }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1 line-clamp-2">
                            {{ $assignment->exercise->Instructions }}
                        </p>
                    </div>
                </div>

                <!-- Stat chips -->
                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3">
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $assignment->RepsTarget }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Reps</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $assignment->SetsTarget }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Sets</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $assignment->exercise->BodyPart ?? '—' }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Focus</span>
                    </div>
                </div>
            </div>

            <!-- Thin progress rail tied to live rep count -->
            <div class="h-1.5 w-full bg-slate-100">
                <div class="h-1.5 bg-[#1C9BA0] transition-all duration-300"
                    :style="`width:${Math.min(100, (repsCompleted / repsTarget) * 100)}%`"></div>
            </div>
        </div>
        <!-- ============== END NEW HEADER ============== -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Camera + skeleton overlay -->
            <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-black overflow-hidden relative shadow-sm" style="aspect-ratio:4/3;">
                <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline muted></video>
                <canvas x-ref="canvas" class="absolute top-0 left-0 w-full h-full"></canvas>

                <!-- Live feedback banner -->
                <div class="absolute bottom-0 left-0 right-0 p-4 text-center font-semibold text-lg backdrop-blur-sm"
                    :class="feedbackColor"
                    x-text="feedbackText"></div>

                <template x-if="!cameraStarted">
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 bg-slate-900/80">
                        <button @click="startCamera()"
                            :disabled="isLoadingCamera || !!cameraError && !navigator.mediaDevices"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#1C9BA0] text-white font-medium rounded-xl shadow-lg shadow-[#1C9BA0]/20 hover:bg-[#18848F] transition disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span x-text="isLoadingCamera ? 'Starting camera and AI...' : 'Start Camera & Begin'"></span>
                        </button>
                        <p x-show="cameraError" x-text="cameraError"
                            class="max-w-md px-4 text-center text-sm font-medium text-red-100"></p>
                        <button @click="$refs.manualEntryBlock.scrollIntoView({behavior:'smooth'})"
                            class="text-sm text-slate-300 underline decoration-slate-500 underline-offset-2 hover:text-white">
                            Camera not working? Log this set manually
                        </button>
                    </div>
                </template>
            </div>

            <!-- Live stats -->
            <div class="bg-white shadow-sm rounded-2xl p-5 border border-slate-200 space-y-4">

                <div class="rounded-xl border border-[#1C9BA0]/15 p-4" :class="guidanceTone">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Live guidance</p>
                    <h3 class="text-base font-semibold mt-1 text-slate-800" x-text="guidanceTitle"></h3>
                    <p class="text-sm mt-1.5 text-slate-600" x-text="guidanceText"></p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Reps completed</p>
                        <span class="text-xs font-semibold text-[#1C9BA0]" x-text="`${repsCompleted}/${repsTarget}`"></span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-2 rounded-full bg-[#1C9BA0] transition-all"
                            :style="`width:${Math.min(100, (repsCompleted / repsTarget) * 100)}%`"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-3">
                        <p class="text-xs text-emerald-700/80">Good form</p>
                        <p class="text-2xl font-semibold text-emerald-700 mt-0.5" x-text="repsGoodForm"></p>
                    </div>
                    <div class="rounded-xl border border-rose-100 bg-rose-50 px-3 py-3">
                        <p class="text-xs text-rose-700/80">Needs work</p>
                        <p class="text-2xl font-semibold text-rose-600 mt-0.5" x-text="repsBadForm"></p>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 px-4 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-400">Current angle</p>
                        <p class="text-xl font-semibold text-slate-800"><span x-text="Math.round(currentAngle)"></span>&deg;</p>
                    </div>
                    <p class="text-[11px] text-slate-400 text-right leading-tight">
                        Target<br>
                        up <span x-text="rule?.up_angle_min ?? 0"></span>&deg; · down <span x-text="rule?.down_angle_max ?? 0"></span>&deg;
                    </p>
                </div>

                <button @click="finishSet()" x-show="cameraStarted"
                    class="w-full px-4 py-2.5 bg-slate-900 text-white font-medium rounded-xl hover:bg-slate-800 transition">
                    Finish Set & Save
                </button>

                <template x-if="submitted">
                    <div class="rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 px-3 py-2.5 text-sm" x-text="submitMessage"></div>
                </template>
            </div>
        </div>

        <!-- Manual fallback: for patients without a usable camera/lighting -->
        <div x-ref="manualEntryBlock" class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800">Log this set manually</h3>
                    <p class="text-sm text-slate-500 mt-0.5">
                        No AI form-checking with this option — your therapist will see it marked as self-reported.
                    </p>
                </div>
            </div>

            <form action="{{ route('workout.result.manual.store', $assignment) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-600">Reps completed</label>
                    <input type="number" name="RepsCompleted" min="0" max="500" required
                        class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">How many felt like good form?</label>
                    <input type="number" name="RepsGoodForm" min="0" max="500" required
                        class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Notes (optional)</label>
                    <input type="text" name="Notes" maxlength="1000"
                        class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                </div>
                <div class="md:col-span-3">
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#1C9BA0] text-white font-medium rounded-xl shadow-sm hover:bg-[#18848F] transition">
                        Save Self-Reported Set
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app1>