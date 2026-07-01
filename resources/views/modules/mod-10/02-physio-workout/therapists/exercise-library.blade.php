<x-app1>

    <div class="space-y-6" x-data="{ showForm: false }">

        <div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <x-page-header />
            <div class="flex flex-wrap items-center gap-2">
                @if($clients->isNotEmpty())
                    <a href="{{ route('workout.patient.progress', ['patientId' => $clients->first()->ID]) }}"
                        class="inline-flex items-center rounded-full border border-[#1C9BA0]/20 bg-white px-4 py-2 text-sm font-semibold text-[#1C9BA0] shadow-sm transition hover:bg-[#E7FAF8]">
                        Patient Progress
                    </a>
                    <select onchange="if(this.value) window.location.href=this.value"
                        class="rounded-full border border-[#1C9BA0]/20 bg-white px-8 py-2 text-sm font-semibold text-[#1C9BA0] shadow-sm focus:border-[#1C9BA0] focus:ring-[#1C9BA0]/30">
                        @foreach($clients as $client)
                            <option value="{{ route('workout.patient.progress', ['patientId' => $client->ID]) }}">
                                {{ $client->UserName }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <span class="inline-flex items-center rounded-full border border-[#1C9BA0]/20 bg-white px-4 py-2 text-sm font-semibold text-[#1C9BA0] shadow-sm">
                        No patients available yet
                    </span>
                @endif
                <button @click="showForm = !showForm"
                    class="inline-flex items-center rounded-full bg-[#1C9BA0] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#18848F]">
                    + New Exercise
                </button>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#1C9BA0] via-[#24B5B8] to-[#59D4C7] p-6 text-white shadow-[0_12px_36px_rgba(28,155,160,0.22)] border border-[#1C9BA0]/20">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7] z-10"></div>
            <div class="relative overflow-hidden rounded-3xl bg-white/10 p-6">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.3),_transparent_45%)]"></div>
                <div class="relative">
                    <p class="text-sm uppercase tracking-[0.28em] text-white/80">Therapist workspace</p>
                    <h2 class="mt-2 text-3xl font-semibold">Exercise library</h2>
                    <p class="mt-3 max-w-2xl text-sm text-white/90">Create AI-guided exercises, assign them to patients, and review performance in one place.</p>
                </div>
            </div>
        </div>

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
