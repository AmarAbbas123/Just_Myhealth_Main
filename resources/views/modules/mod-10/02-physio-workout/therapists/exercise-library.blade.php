<x-app1>

    <div class="space-y-6" x-data="{ showForm: false, selectedPatientUrl: '' }">

        <!-- Top action bar: page title + single primary action -->
        <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-page-header />
            <button @click="showForm = !showForm"
                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#1C9BA0] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#18848F] sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span x-text="showForm ? 'Close Form' : 'New Exercise'"></span>
            </button>
        </div>

        <!-- Patient progress lookup: one clear control, doesn't navigate until you choose AND confirm -->
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
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

        <!-- ============== HEADER (matches patient-side pages) ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- Icon + identity block -->
                <div class="flex items-center gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#EAFBFA] text-[#1C9BA0]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Therapist workspace</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-0.5">Exercise Library</h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Create AI-guided exercises, assign them to patients, and review performance in one place.
                        </p>
                    </div>
                </div>

                <!-- Stat chips -->
                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3">
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $exercises->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Exercises</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $exercises->where('IsActive', true)->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Active</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $clients->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Clients</span>
                    </div>
                </div>
            </div>

            <div class="h-1.5 w-full bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7]"></div>
        </div>
        <!-- ============== END HEADER ============== -->

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- New exercise form -->
        <div x-show="showForm" x-cloak class="rounded-3xl border border-gray-100 bg-white p-6 shadow-[0_10px_30px_rgba(15,23,42,0.06)]">
            <form action="{{ route('workout.library.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Exercise Name</label>
                        <input type="text" name="ExerciseName" required
                            class="w-full border-gray-300 rounded-lg mt-1">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Body Part</label>
                        <input type="text" name="BodyPart" placeholder="e.g. Knee, Shoulder"
                            class="w-full border-gray-300 rounded-lg mt-1">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Exercise Type (AI checker)</label>
                        <select name="ExerciseType" required class="w-full border-gray-300 rounded-lg mt-1">
                            <option value="knee_squat">Knee Squat</option>
                            <option value="shoulder_raise">Shoulder Raise</option>
                            <option value="elbow_curl">Elbow Curl</option>
                            <option value="generic_angle">Generic Angle Exercise</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Joint Tracked</label>
                        <select name="Joint" required class="w-full border-gray-300 rounded-lg mt-1">
                            <option value="knee">Knee</option>
                            <option value="shoulder">Shoulder</option>
                            <option value="elbow">Elbow</option>
                            <option value="hip">Hip</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Side</label>
                        <select name="Side" required class="w-full border-gray-300 rounded-lg mt-1">
                            <option value="both">Both</option>
                            <option value="left">Left only</option>
                            <option value="right">Right only</option>
                        </select>
                    </div>
                    <div></div>

                    <div>
                        <label class="text-sm text-gray-600">
                            "Down" angle threshold (&deg;) — angle must drop below this
                        </label>
                        <input type="number" name="DownAngleMax" required min="0" max="180" value="100"
                            class="w-full border-gray-300 rounded-lg mt-1">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">
                            "Up" angle threshold (&deg;) — angle must rise above this to complete rep
                        </label>
                        <input type="number" name="UpAngleMin" required min="0" max="180" value="160"
                            class="w-full border-gray-300 rounded-lg mt-1">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Good-form tolerance (&deg;)</label>
                        <input type="number" name="GoodFormTolerance" required min="1" max="60" value="15"
                            class="w-full border-gray-300 rounded-lg mt-1">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Default sets / reps</label>
                        <div class="flex gap-2 mt-1">
                            <input type="number" name="DefaultSets" min="1" max="20" value="3"
                                class="w-1/2 border-gray-300 rounded-lg">
                            <input type="number" name="DefaultReps" min="1" max="100" value="10"
                                class="w-1/2 border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Instructions for patient</label>
                        <textarea name="Instructions" rows="3" class="w-full border-gray-300 rounded-lg mt-1"></textarea>
                    </div>
                </div>

                <button type="submit"
                    class="px-4 py-2 bg-[#1C9BA0] text-white rounded-lg hover:bg-[#18848F] transition">
                    Save Exercise
                </button>
            </form>
        </div>

        <!-- Library list -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @forelse($exercises as $exercise)
                <div class="relative overflow-hidden rounded-[24px] border border-gray-100 bg-white p-6 shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition hover:-translate-y-0.5" x-data="{ showAssign: false }">
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7]"></div>
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $exercise->ExerciseName }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $exercise->BodyPart }} · {{ $exercise->ExerciseType }}</p>
                        </div>
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $exercise->IsActive ? 'bg-[#E7FAF8] text-[#1C9BA0]' : 'bg-gray-100 text-gray-500' }}">
                            {{ $exercise->IsActive ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="mt-4 rounded-2xl bg-[#F7FCFC] p-3">
                        <p class="text-sm text-gray-600">{{ $exercise->Instructions }}</p>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-gray-500">
                        <span class="rounded-full bg-gray-100 px-2.5 py-1">Down ≤ {{ $exercise->AngleRuleConfig['down_angle_max'] }}°</span>
                        <span class="rounded-full bg-gray-100 px-2.5 py-1">Up ≥ {{ $exercise->AngleRuleConfig['up_angle_min'] }}°</span>
                        <span class="rounded-full bg-gray-100 px-2.5 py-1">Tolerance {{ $exercise->AngleRuleConfig['good_form_tolerance'] }}°</span>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <button @click="showAssign = !showAssign"
                            class="rounded-lg bg-[#1C9BA0] px-3 py-2 text-sm font-semibold text-white hover:bg-[#18848F]">
                            Assign to Patient
                        </button>
                        <form action="{{ route('workout.library.delete', $exercise) }}" method="POST"
                            onsubmit="return confirm('Remove this exercise from your library?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete</button>
                        </form>
                    </div>

                    <!-- Assign form, pulled from this therapist's actual client list -->
                    <div x-show="showAssign" x-cloak class="mt-4 border-t border-gray-100 pt-4">
                        @if($clients->isEmpty())
                            <p class="text-sm text-gray-400">
                                You don't have any clients yet — a patient must have had a session with you before
                                you can assign a workout.
                            </p>
                        @else
                            <form action="{{ route('workout.assign') }}" method="POST" class="space-y-3">
                                @csrf
                                <input type="hidden" name="ExerciseID" value="{{ $exercise->ID }}">

                                <div>
                                    <label class="text-sm text-gray-600">Patient</label>
                                    <select name="PatientID" required class="w-full border-gray-300 rounded-lg mt-1">
                                        <option value="">Select a patient...</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->ID }}">
                                                {{ $client->UserName }} ({{ $client->Email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="text-xs text-gray-500">Sets</label>
                                        <input type="number" name="SetsTarget" min="1" max="20"
                                            value="{{ $exercise->DefaultSets }}"
                                            class="w-full border-gray-300 rounded-lg mt-1 text-sm">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500">Reps</label>
                                        <input type="number" name="RepsTarget" min="1" max="100"
                                            value="{{ $exercise->DefaultReps }}"
                                            class="w-full border-gray-300 rounded-lg mt-1 text-sm">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500">Times/week</label>
                                        <input type="number" name="FrequencyPerWeek" min="1" max="14" value="3"
                                            class="w-full border-gray-300 rounded-lg mt-1 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs text-gray-500">Notes for patient (optional)</label>
                                    <input type="text" name="TherapistNotes" maxlength="500"
                                        class="w-full border-gray-300 rounded-lg mt-1 text-sm">
                                </div>

                                <button type="submit"
                                    class="px-3 py-2 bg-[#1C9BA0] text-white rounded-lg shadow hover:bg-[#18848F] transition">
                                    Confirm Assignment
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-2">No exercises yet — add your first one above.</p>
            @endforelse
        </div>
    </div>

</x-app1>