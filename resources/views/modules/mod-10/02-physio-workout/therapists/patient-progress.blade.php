<x-app1>

    <div class="space-y-6">
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <div class="relative overflow-hidden rounded-3xl border border-[#1C9BA0]/20 bg-gradient-to-r from-[#1C9BA0] via-[#24B5B8] to-[#59D4C7] p-6 text-white shadow-[0_12px_40px_rgba(28,155,160,0.2)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.28),_transparent_45%)]"></div>
            <div class="relative">
                <p class="text-sm uppercase tracking-[0.24em] text-white/80">Patient progress</p>
                <h2 class="text-2xl font-semibold mt-1">Workout history and form review</h2>
                <p class="text-sm text-white/90 mt-2">Review assigned exercises, rep counts, and AI-form results for this patient.</p>
            </div>
        </div>

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
