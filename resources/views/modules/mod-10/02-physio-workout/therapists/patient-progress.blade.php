<x-app1>

    <div class="space-y-6">
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @forelse($assignments as $assignment)
            <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
                <h3 class="font-semibold text-gray-800">{{ $assignment->exercise->ExerciseName }}</h3>
                <p class="text-sm text-gray-500">
                    Target: {{ $assignment->RepsTarget }} reps &times; {{ $assignment->SetsTarget }} sets ·
                    Status: {{ ucfirst($assignment->Status) }}
                </p>

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
                                        <span class="text-xs px-2 py-1 rounded bg-indigo-100 text-indigo-700">AI-verified</span>
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
        @empty
            <p class="text-gray-500">No workouts assigned to this patient yet.</p>
        @endforelse
    </div>

</x-app1>
