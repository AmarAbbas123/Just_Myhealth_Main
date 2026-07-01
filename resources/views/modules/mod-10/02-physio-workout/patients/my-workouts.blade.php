<x-app1>

    <div class="space-y-6">

        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($assignments as $assignment)
                <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
                    <h3 class="font-semibold text-gray-800">{{ $assignment->exercise->ExerciseName }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $assignment->exercise->BodyPart }}</p>
                    <p class="text-sm text-gray-400 mt-2">
                        {{ $assignment->SetsTarget }} sets &times; {{ $assignment->RepsTarget }} reps ·
                        {{ $assignment->FrequencyPerWeek }}x/week
                    </p>
                    @if ($assignment->TherapistNotes)
                        <p class="text-sm text-gray-600 mt-2 italic">"{{ $assignment->TherapistNotes }}"</p>
                    @endif
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('workout.do', $assignment) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                            Start Exercise
                        </a>
                        <a href="{{ route('workout.history', $assignment) }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                            History
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-2">No workouts assigned yet. Check back once your therapist assigns
                    one.</p>
            @endforelse
        </div>
    </div>

</x-app1>
