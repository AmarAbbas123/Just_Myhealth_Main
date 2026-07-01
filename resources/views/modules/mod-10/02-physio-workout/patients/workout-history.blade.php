<x-app1>

    <div class="space-y-6">
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <h2 class="text-xl font-semibold text-gray-800">{{ $assignment->exercise->ExerciseName }} — History</h2>

        <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Date</th>
                        <th class="py-2">Reps</th>
                        <th class="py-2">Good Form</th>
                        <th class="py-2">Bad Form</th>
                        <th class="py-2">Avg Score</th>
                        <th class="py-2">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        <tr class="border-b">
                            <td class="py-2">{{ $session->AttemptedAt->format('d M Y, H:i') }}</td>
                            <td class="py-2">{{ $session->RepsCompleted }}</td>
                            <td class="py-2 text-green-600">{{ $session->RepsGoodForm }}</td>
                            <td class="py-2 text-red-500">{{ $session->RepsBadForm }}</td>
                            <td class="py-2 font-semibold">{{ $session->AvgFormScore }}%</td>
                            <td class="py-2">{{ $session->DurationSeconds }}s</td>
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

</x-app1>
