<x-app1>

    <div class="space-y-6">

        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="relative overflow-hidden rounded-3xl border border-[#1C9BA0]/20 bg-gradient-to-r from-[#1C9BA0] via-[#24B5B8] to-[#59D4C7] p-6 text-white shadow-[0_12px_40px_rgba(28,155,160,0.2)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.28),_transparent_45%)]"></div>
            <div class="relative">
                <h2 class="text-xl font-semibold">Your physiotherapy plan</h2>
                <p class="text-sm text-white/90 mt-1">Use the progress view to track your reps and see how each session is improving.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($assignments as $assignment)
                <div class="group relative overflow-hidden rounded-3xl border border-[#1C9BA0]/15 bg-white p-6 shadow-[0_10px_30px_rgba(28,155,160,0.08)] transition hover:-translate-y-1 hover:shadow-[0_14px_36px_rgba(28,155,160,0.16)]">
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7]"></div>
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $assignment->exercise->ExerciseName }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $assignment->exercise->BodyPart }}</p>
                        </div>
                        <span class="rounded-full bg-[#E7FAF8] px-2.5 py-1 text-xs font-semibold text-[#1C9BA0]">Active</span>
                    </div>

                    <div class="mt-4 rounded-2xl bg-[#F7FCFC] p-3">
                        <p class="text-sm text-gray-500">Plan</p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">
                            {{ $assignment->SetsTarget }} sets &times; {{ $assignment->RepsTarget }} reps ·
                            {{ $assignment->FrequencyPerWeek }}x/week
                        </p>
                    </div>

                    @if ($assignment->TherapistNotes)
                        <div class="mt-4 rounded-2xl border border-[#1C9BA0]/10 bg-[#F7FCFC] p-3">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Therapist note</p>
                            <p class="text-sm text-gray-600 mt-1">"{{ $assignment->TherapistNotes }}"</p>
                        </div>
                    @endif

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('workout.do', $assignment) }}"
                            class="px-4 py-2 bg-[#1C9BA0] text-white rounded-lg hover:bg-[#18848F] transition text-sm font-semibold">
                            Start Exercise
                        </a>
                        <a href="{{ route('workout.history', $assignment) }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-semibold">
                            View Progress
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
