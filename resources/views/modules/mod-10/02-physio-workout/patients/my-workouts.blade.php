<x-app1>

    <div class="space-y-6">

        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- ============== HEADER (unified style) ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-stretch">

                <!-- Icon + identity block -->
                <div class="flex items-start gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAFBFA] text-[#1C9BA0] ring-1 ring-[#1C9BA0]/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="min-w-0 pt-0.5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Your physiotherapy plan</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-1 leading-snug">My Workouts</h2>
                        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed line-clamp-2">
                            Track your reps and see how each AI-checked session is improving.
                        </p>
                    </div>
                </div>

                <!-- Stat chips -->
                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3 bg-slate-50/60 md:bg-transparent">
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $assignments->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Active</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $assignments->sum('FrequencyPerWeek') }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Sessions/wk</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">
                            {{ $assignments->pluck('exercise.BodyPart')->filter()->unique()->count() }}
                        </span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Focus areas</span>
                    </div>
                </div>
            </div>

            <div class="h-1.5 w-full bg-gradient-to-r from-[#1C9BA0] to-[#59D4C7]"></div>
        </div>
        <!-- ============== END HEADER ============== -->

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($assignments as $assignment)
                <div class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <!-- Accent bar -->
                    <div class="absolute inset-y-0 left-0 w-0 bg-gradient-to-b from-[#1C9BA0] to-[#59D4C7]"></div>

                    <!-- Header row: icon, name, status -->
                    <div class="flex items-start gap-4 p-5 pl-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#EAFBFA] text-[#1C9BA0]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-semibold text-slate-900 truncate">{{ $assignment->exercise->ExerciseName }}</h3>
                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 mt-0.5">{{ $assignment->exercise->BodyPart }}</p>
                        </div>
                    </div>

                    <!-- Stat strip -->
                    <div class="px-5 pl-6">
                        <div class="grid grid-cols-3 divide-x divide-slate-200 rounded-xl bg-slate-50 py-2.5">
                            <div class="text-center px-2">
                                <p class="text-sm font-semibold text-slate-800">{{ $assignment->SetsTarget }}</p>
                                <p class="text-[10px] uppercase tracking-wide text-slate-400 mt-0.5">Sets</p>
                            </div>
                            <div class="text-center px-2">
                                <p class="text-sm font-semibold text-slate-800">{{ $assignment->RepsTarget }}</p>
                                <p class="text-[10px] uppercase tracking-wide text-slate-400 mt-0.5">Reps</p>
                            </div>
                            <div class="text-center px-2">
                                <p class="text-sm font-semibold text-slate-800">{{ $assignment->FrequencyPerWeek }}x</p>
                                <p class="text-[10px] uppercase tracking-wide text-slate-400 mt-0.5">Per week</p>
                            </div>
                        </div>
                    </div>

                    @if ($assignment->TherapistNotes)
                        <div class="mx-5 ml-6 mt-3 rounded-xl border border-[#1C9BA0]/10 bg-[#F7FCFC] px-3 py-2.5">
    
                            <p class="text-xs text-slate-600 mt-1 italic">"{{ $assignment->TherapistNotes }}"</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-4 flex gap-2 border-t border-slate-100 p-5 pl-6 pt-4">
                        <a href="{{ route('workout.do', $assignment) }}"
                            class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-[#1C9BA0] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#18848F]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            Start
                        </a>
                        <a href="{{ route('workout.history', $assignment) }}"
                            class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14" />
                            </svg>
                            Progress
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 rounded-2xl border border-dashed border-[#1C9BA0]/20 bg-[#F7FCFC] p-10 text-center">
                    <p class="text-sm font-medium text-gray-900">No workouts assigned yet.</p>
                    <p class="text-sm text-gray-500 mt-1">Check back once your therapist assigns one.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-app1>