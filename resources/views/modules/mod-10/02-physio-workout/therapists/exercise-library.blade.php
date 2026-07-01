<x-app1>

    <div class="space-y-6" x-data="{ showForm: false }">

        <div class="flex justify-between mb-4">
            <x-page-header />
            <button @click="showForm = !showForm"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                + New Exercise
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- New exercise form -->
        <div x-show="showForm" x-cloak class="bg-white shadow rounded-xl p-6 border border-gray-100">
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
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Save Exercise
                </button>
            </form>
        </div>

        <!-- Library list -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($exercises as $exercise)
                <div class="bg-white shadow rounded-xl p-6 border border-gray-100" x-data="{ showAssign: false }">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $exercise->ExerciseName }}</h3>
                            <p class="text-sm text-gray-500">{{ $exercise->BodyPart }} ·
                                {{ $exercise->ExerciseType }}</p>
                        </div>
                        <span
                            class="text-xs px-2 py-1 rounded {{ $exercise->IsActive ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $exercise->IsActive ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $exercise->Instructions }}</p>
                    <p class="text-xs text-gray-400 mt-2">
                        Down &le; {{ $exercise->AngleRuleConfig['down_angle_max'] }}&deg; ·
                        Up &ge; {{ $exercise->AngleRuleConfig['up_angle_min'] }}&deg; ·
                        Tolerance {{ $exercise->AngleRuleConfig['good_form_tolerance'] }}&deg;
                    </p>

                    <div class="flex gap-2 mt-4">
                        <button @click="showAssign = !showAssign"
                            class="px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">
                            Assign to Patient
                        </button>
                        <form action="{{ route('workout.library.delete', $exercise) }}" method="POST"
                            onsubmit="return confirm('Remove this exercise from your library?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded text-sm">Delete</button>
                        </form>
                    </div>

                    <!-- Assign form, pulled from this therapist's actual client list -->
                    <div x-show="showAssign" x-cloak class="mt-4 pt-4 border-t border-gray-100">
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
                                    class="px-3 py-1.5 bg-green-600 text-white rounded text-sm hover:bg-green-700">
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
