<x-app1>

    <div class="space-y-6">
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- ============== HEADER (matches patient-side pages) ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- Icon + identity block -->
                <div class="flex items-center gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#EAFBFA] text-[#1C9BA0]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Patient progress</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-0.5">
                            {{ $patient->UserName ?? 'Workout history and form review' }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Review assigned exercises, rep counts, and AI-form results for this patient.
                        </p>
                    </div>
                </div>

                <!-- Stat chips -->
                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3">
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">{{ $assignments->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Plans</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        <span class="text-lg font-semibold text-slate-900">
                            {{ $assignments->sum(fn($a) => $a->sessions->count()) }}
                        </span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Sessions</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-4 text-center">
                        @php
                            $allSessions = $assignments->flatMap->sessions;
                        @endphp
                        <span class="text-lg font-semibold text-slate-900">
                            {{ $allSessions->count() ? round($allSessions->avg('AvgFormScore')) : 0 }}%
                        </span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-0.5">Avg score</span>
                    </div>
                </div>
            </div>

            <!-- Thin progress rail reflecting overall average form score -->
            <div class="h-1.5 w-full bg-slate-100">
                <div class="h-1.5 bg-[#1C9BA0] transition-all duration-300"
                    style="width: {{ $allSessions->count() ? min(100, round($allSessions->avg('AvgFormScore'))) : 0 }}%"></div>
            </div>
        </div>
        <!-- ============== END HEADER ============== -->

        @forelse($assignments as $assignment)
            <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $assignment->exercise->ExerciseName }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Target: {{ $assignment->RepsTarget }} reps &times; {{ $assignment->SetsTarget }} sets ·
                            Status: {{ ucfirst($assignment->Status) }}
                        </p>
                    </div>
                    <span class="rounded-full bg-[#E7FAF8] px-3 py-1 text-xs font-semibold text-[#1C9BA0]">Assigned plan</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full mt-4 text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2">Date</th>
                                <th class="py-2">Source</th>
                                <th class="py-2">Reps</th>
                                <th class="py-2">Good Form</th>
                                <th class="py-2">Bad Form</th>
                                <th class="py-2">Avg Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignment->sessions as $session)
                                <tr class="border-b">
                                    <td class="py-2">{{ $session->AttemptedAt->format('d M Y, H:i') }}</td>
                                    <td class="py-2">
                                        @if($session->EntryMethod === 'ai_camera')
                                            <span class="text-xs px-2 py-1 rounded bg-[#E7FAF8] text-[#1C9BA0]">AI-verified</span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-500">Self-reported</span>
                                        @endif
                                    </td>
                                    <td class="py-2">{{ $session->RepsCompleted }}</td>
                                    <td class="py-2 text-green-600">{{ $session->RepsGoodForm }}</td>
                                    <td class="py-2 text-red-500">{{ $session->RepsBadForm }}</td>
                                    <td class="py-2 font-semibold">{{ $session->AvgFormScore }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 text-gray-400">No sessions logged yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-500">
                No workouts assigned to this patient yet.
            </div>
        @endforelse
    </div>

</x-app1>