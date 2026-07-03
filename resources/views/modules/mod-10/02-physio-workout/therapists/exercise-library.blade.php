<x-app1>

    <div class="space-y-6"
        x-data="{
            newExerciseOpen: false,
            assignOpen: false,
            assignExercise: { id: null, name: '', sets: 3, reps: 10 },
            presets: {
                knee_squat: {
                    label: 'Knee Squat',
                    joint: 'knee',
                    side: 'both',
                    down: 100,
                    up: 160,
                    tolerance: 15,
                    body: 'Knee',
                    help: 'Good for squats, sit-to-stand, and leg-strengthening exercises. The AI watches the angle at the knee (hip-knee-ankle) as the patient bends and straightens their legs.'
                },
                shoulder_raise: {
                    label: 'Shoulder Raise',
                    joint: 'shoulder',
                    side: 'both',
                    down: 20,
                    up: 90,
                    tolerance: 15,
                    body: 'Shoulder',
                    help: 'Good for arm raises to the side or front. The AI watches the angle at the shoulder (hip-shoulder-elbow) as the patient lifts and lowers their arm.'
                },
                elbow_curl: {
                    label: 'Elbow Curl',
                    joint: 'elbow',
                    side: 'both',
                    down: 150,
                    up: 50,
                    tolerance: 15,
                    body: 'Elbow',
                    help: 'Good for bicep curls and elbow flexion/extension. The AI watches the angle at the elbow (shoulder-elbow-wrist) as the patient bends and straightens their arm.'
                },
                generic_angle: {
                    label: 'Custom / Other',
                    joint: 'knee',
                    side: 'both',
                    down: 100,
                    up: 160,
                    tolerance: 15,
                    body: '',
                    help: 'Use this if none of the presets fit. Pick the joint yourself and set your own angle thresholds below — you know your patient\'s movement best.'
                }
            },
            form: { ExerciseType: '', Joint: '', Side: 'both', DownAngleMax: '', UpAngleMin: '', GoodFormTolerance: 15, BodyPart: '' },
            applyPreset(type) {
                const p = this.presets[type];
                if (!p) return;
                this.form.ExerciseType = type;
                this.form.Joint = p.joint;
                this.form.Side = p.side;
                this.form.DownAngleMax = p.down;
                this.form.UpAngleMin = p.up;
                this.form.GoodFormTolerance = p.tolerance;
                if (!this.form.BodyPart) this.form.BodyPart = p.body;
            },
            openAssign(exercise) {
                this.assignExercise = exercise;
                this.assignOpen = true;
            }
        }">

        <!-- Top action bar: page title + single primary action -->
        <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-page-header />
            <button @click="newExerciseOpen = true"
                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#1C9BA0] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#18848F] sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>New Exercise</span>
            </button>
        </div>

        <!-- Patient progress lookup -->
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                x-data="{ selectedPatientUrl: '' }">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#EAFBFA] text-[#1C9BA0]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Check a patient's progress</p>
                        <p class="text-xs text-slate-500">Choose a patient to review their AI-tracked sessions.</p>
                    </div>
                </div>

                @if($clients->isNotEmpty())
                    <div class="flex items-center gap-2">
                        <select x-model="selectedPatientUrl"
                            class="min-w-[200px] rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]/30">
                            <option value="">Select a patient...</option>
                            @foreach($clients as $client)
                                <option value="{{ route('workout.patient.progress', ['patientId' => $client->ID]) }}">
                                    {{ $client->UserName }}
                                </option>
                            @endforeach
                        </select>
                        <button @click="if (selectedPatientUrl) window.location.href = selectedPatientUrl"
                            :disabled="!selectedPatientUrl"
                            class="rounded-full bg-[#1C9BA0] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#18848F] disabled:cursor-not-allowed disabled:bg-slate-200 disabled:text-slate-400 disabled:shadow-none">
                            View Progress
                        </button>
                    </div>
                @else
                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-400">
                        No patients available yet
                    </span>
                @endif
            </div>
        </div>

        <!-- ============== HEADER (unified style) ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-stretch">
                <div class="flex items-start gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAFBFA] text-[#1C9BA0] ring-1 ring-[#1C9BA0]/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="min-w-0 pt-0.5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Therapist workspace</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-1 leading-snug">Exercise Library</h2>
                        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed line-clamp-2">
                            Create AI-guided exercises, assign them to patients, and review performance in one place.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3 bg-slate-50/60 md:bg-transparent">
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $exercises->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Exercises</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $exercises->where('IsActive', true)->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Active</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $clients->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Clients</span>
                    </div>
                </div>
            </div>
            <div class="h-1.5 w-full bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7]"></div>
        </div>
        <!-- ============== END HEADER ============== -->

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded">{{ session('success') }}</div>
        @endif

        <!-- Library list -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @forelse($exercises as $exercise)
                <div class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <!-- Accent bar -->
                    <div class="absolute  left-0 w-1 bg-gradient-to-b from-[#1C9BA0] to-[#59D4C7]"></div>

                    <!-- Header row: icon, name, status -->
                    <div class="flex items-start gap-4 p-5 pl-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#EAFBFA] text-[#1C9BA0]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-semibold text-slate-900 truncate">{{ $exercise->ExerciseName }}</h3>
                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset
                                    {{ $exercise->IsActive ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/10' : 'bg-slate-100 text-slate-500 ring-slate-500/10' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $exercise->IsActive ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $exercise->IsActive ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 mt-0.5">{{ $exercise->BodyPart }} · {{ $exercise->ExerciseType }}</p>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="px-5 pl-6">
                        <div class="rounded-xl bg-slate-50 px-3 py-2.5">
                            <p class="text-xs text-slate-600 line-clamp-2">{{ $exercise->Instructions }}</p>
                        </div>
                    </div>

                    <!-- Angle rule pills -->
                    <div class="mt-3 flex flex-wrap gap-1.5 px-5 pl-6">
                        <span class="inline-flex items-center rounded-full bg-[#EAFBFA] px-2.5 py-1 text-[11px] font-medium text-[#1C9BA0]">
                            Down ≤ {{ $exercise->AngleRuleConfig['down_angle_max'] }}°
                        </span>
                        <span class="inline-flex items-center rounded-full bg-[#EAFBFA] px-2.5 py-1 text-[11px] font-medium text-[#1C9BA0]">
                            Up ≥ {{ $exercise->AngleRuleConfig['up_angle_min'] }}°
                        </span>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-500">
                            Tolerance {{ $exercise->AngleRuleConfig['good_form_tolerance'] }}°
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex items-center gap-2 border-t border-slate-100 p-5 pl-6 pt-4">
                        <button @click="openAssign({ id: {{ $exercise->ID }}, name: @js($exercise->ExerciseName), sets: {{ $exercise->DefaultSets }}, reps: {{ $exercise->DefaultReps }} })"
                            class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-[#1C9BA0] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#18848F]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Assign
                        </button>
                        <form action="{{ route('workout.library.delete', $exercise) }}" method="POST"
                            onsubmit="return confirm('Remove this exercise from your library?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl border border-rose-100 bg-rose-50 px-3.5 py-2.5 text-rose-600 transition hover:bg-rose-100"
                                title="Delete exercise">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-2 rounded-2xl border border-dashed border-[#1C9BA0]/20 bg-[#F7FCFC] p-10 text-center">
                    <p class="text-sm font-medium text-gray-900">No exercises yet.</p>
                    <p class="text-sm text-gray-500 mt-1">Click "New Exercise" above to add your first one.</p>
                </div>
            @endforelse
        </div>

        <!-- ============================================================ -->
        <!-- MODAL: New Exercise                                          -->
        <!-- ============================================================ -->
        <div x-show="newExerciseOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4"
            @keydown.escape.window="newExerciseOpen = false">
            <div @click.outside="newExerciseOpen = false"
                class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-3xl bg-white shadow-2xl">

                <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-slate-100 bg-white px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">New AI exercise</p>
                        <h3 class="text-lg font-semibold text-slate-900 mt-0.5">Add exercise to your library</h3>
                    </div>
                    <button @click="newExerciseOpen = false" class="rounded-full p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('workout.library.store') }}" method="POST" class="space-y-6 px-6 py-6">
                    @csrf

                    <!-- Step 1: what kind of movement -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">1. What type of movement is this?</label>
                        <p class="text-xs text-slate-500 mt-0.5">Pick the closest match — it fills in sensible AI settings for you, which you can fine-tune below.</p>
                        <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <template x-for="(preset, key) in presets" :key="key">
                                <button type="button" @click="applyPreset(key)"
                                    class="rounded-xl border-2 px-3 py-3 text-left text-sm font-medium transition"
                                    :class="form.ExerciseType === key ? 'border-[#1C9BA0] bg-[#EAFBFA] text-[#1C9BA0]' : 'border-slate-200 text-slate-600 hover:border-slate-300'">
                                    <span x-text="preset.label"></span>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="ExerciseType" x-model="form.ExerciseType">

                        <!-- Plain-language explanation of the chosen preset -->
                        <div x-show="form.ExerciseType" x-cloak class="mt-3 rounded-xl border border-[#1C9BA0]/15 bg-[#F7FCFC] p-3">
                            <p class="text-xs text-slate-600" x-text="presets[form.ExerciseType]?.help"></p>
                        </div>
                    </div>

                    <!-- Step 2: basic info -->
                    <div x-show="form.ExerciseType" x-cloak class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-slate-600">2. Exercise name</label>
                            <input type="text" name="ExerciseName" required placeholder="e.g. Seated Knee Extension"
                                class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600">Body part</label>
                            <input type="text" name="BodyPart" x-model="form.BodyPart" placeholder="e.g. Knee"
                                class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-slate-600">Instructions the patient will see</label>
                            <textarea name="Instructions" rows="2" placeholder="e.g. Sit tall, slowly straighten your leg, then lower it back down with control."
                                class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]"></textarea>
                        </div>
                    </div>

                    <!-- Step 3: AI detection rules, explained -->
                    <div x-show="form.ExerciseType" x-cloak class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-700">3. How the AI recognizes a "good" rep</p>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            The camera watches one joint angle. A rep is counted once the patient bends past the
                            <span class="font-medium text-slate-700">"down" angle</span> and then straightens past the
                            <span class="font-medium text-slate-700">"up" angle</span>. The
                            <span class="font-medium text-slate-700">tolerance</span> is how many degrees of wiggle-room
                            counts as still "good form" — a lower number is stricter.
                        </p>

                        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <div>
                                <label class="text-xs font-medium text-slate-500">Joint tracked</label>
                                <select name="Joint" x-model="form.Joint" required
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                                    <option value="knee">Knee</option>
                                    <option value="shoulder">Shoulder</option>
                                    <option value="elbow">Elbow</option>
                                    <option value="hip">Hip</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">Side</label>
                                <select name="Side" x-model="form.Side" required
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                                    <option value="both">Both sides</option>
                                    <option value="left">Left only</option>
                                    <option value="right">Right only</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">"Down" angle (°)</label>
                                <input type="number" name="DownAngleMax" x-model="form.DownAngleMax" required min="0" max="180"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">"Up" angle (°)</label>
                                <input type="number" name="UpAngleMin" x-model="form.UpAngleMin" required min="0" max="180"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <div>
                                <label class="text-xs font-medium text-slate-500">Good-form tolerance (°)</label>
                                <input type="number" name="GoodFormTolerance" x-model="form.GoodFormTolerance" required min="1" max="60"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">Default sets</label>
                                <input type="number" name="DefaultSets" min="1" max="20" value="3"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">Default reps</label>
                                <input type="number" name="DefaultReps" min="1" max="100" value="10"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4">
                        <button type="button" @click="newExerciseOpen = false"
                            class="rounded-full px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                            Cancel
                        </button>
                        <button type="submit" :disabled="!form.ExerciseType"
                            class="rounded-full bg-[#1C9BA0] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#18848F] disabled:cursor-not-allowed disabled:bg-slate-200 disabled:text-slate-400">
                            Save Exercise
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- MODAL: Assign to Patient                                     -->
        <!-- ============================================================ -->
        <div x-show="assignOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4"
            @keydown.escape.window="assignOpen = false">
            <div @click.outside="assignOpen = false" class="w-full max-w-md rounded-3xl bg-white shadow-2xl">

                <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Assign exercise</p>
                        <h3 class="text-lg font-semibold text-slate-900 mt-0.5" x-text="assignExercise.name"></h3>
                    </div>
                    <button @click="assignOpen = false" class="rounded-full p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @if($clients->isEmpty())
                    <div class="px-6 py-8 text-center">
                        <p class="text-sm text-slate-500">
                            You don't have any clients yet — a patient must have had a session with you before you can assign a workout.
                        </p>
                    </div>
                @else
                    <form action="{{ route('workout.assign') }}" method="POST" class="space-y-4 px-6 py-6">
                        @csrf
                        <input type="hidden" name="ExerciseID" :value="assignExercise.id">

                        <div>
                            <label class="text-sm font-medium text-slate-600">Patient</label>
                            <select name="PatientID" required
                                class="w-full rounded-lg border-slate-300 mt-1 focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                                <option value="">Select a patient...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->ID }}">
                                        {{ $client->UserName }} ({{ $client->Email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs font-medium text-slate-500">Sets</label>
                                <input type="number" name="SetsTarget" min="1" max="20"
                                    :value="assignExercise.sets"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">Reps</label>
                                <input type="number" name="RepsTarget" min="1" max="100"
                                    :value="assignExercise.reps"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500">Times/week</label>
                                <input type="number" name="FrequencyPerWeek" min="1" max="14" value="3"
                                    class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-slate-500">Notes for patient (optional)</label>
                            <input type="text" name="TherapistNotes" maxlength="500"
                                class="w-full rounded-lg border-slate-300 mt-1 text-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="assignOpen = false"
                                class="rounded-full px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                                Cancel
                            </button>
                            <button type="submit"
                                class="rounded-full bg-[#1C9BA0] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#18848F]">
                                Confirm Assignment
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

</x-app1>