<x-app1>

    <div class="space-y-6">

        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- ============== HEADER (matches do-workout.blade.php) ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- Icon + identity block -->
                <div class="flex items-center gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#EAFBFA] text-[#1C9BA0]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Your physiotherapy plan</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-0.5">My Workouts</h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Track your reps and see how each AI-checked session is improving.
                        </p>
                    </div>
                </div>

                <!-- Stat chips -->
                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3">
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $assignments->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Active</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $assignments->sum('FrequencyPerWeek') }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Sessions/wk</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">
                            {{ $assignments->pluck('exercise.BodyPart')->filter()->unique()->count() }}
                        </span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Focus areas</span>
                    </div>
                </div>
            </div>

            <div class="h-1.5 w-full bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7]"></div>
        </div>
        <!-- ============== END HEADER ============== -->

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
                <div class="col-span-2 rounded-3xl border border-dashed border-[#1C9BA0]/20 bg-[#F7FCFC] p-10 text-center">
                    <p class="text-sm font-medium text-gray-900">No workouts assigned yet.</p>
                    <p class="text-sm text-gray-500 mt-1">Check back once your therapist assigns one.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-app1>