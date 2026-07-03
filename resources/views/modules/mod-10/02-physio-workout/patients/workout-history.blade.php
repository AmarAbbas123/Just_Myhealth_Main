<x-app1>

    <div class="space-y-6">
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- ============== HEADER (unified style) ============== -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-stretch">

                <!-- Icon + identity block -->
                <div class="flex items-start gap-4 p-6 md:w-2/3">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAFBFA] text-[#1C9BA0] ring-1 ring-[#1C9BA0]/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="min-w-0 pt-0.5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">History log</p>
                        <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-1 leading-snug truncate">
                            {{ $assignment->exercise->ExerciseName }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed line-clamp-2">
                            A clear view of each session, form quality, and exercise duration.
                        </p>
                    </div>
                </div>

                <!-- Stat chips -->
                <div class="grid grid-cols-3 divide-x divide-slate-100 border-t md:border-t-0 md:border-l border-slate-100 md:w-1/3 bg-slate-50/60 md:bg-transparent">
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $sessions->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Sessions</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ round($sessions->avg('AvgFormScore') ?? 0) }}%</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Avg score</span>
                    </div>
                    <div class="flex flex-col items-center justify-center px-3 py-5 text-center">
                        <span class="text-xl font-semibold text-slate-900">{{ $sessions->max('AvgFormScore') ?? 0 }}%</span>
                        <span class="text-[11px] uppercase tracking-wide text-slate-400 mt-1">Best score</span>
                    </div>
                </div>
            </div>

            <!-- Thin progress rail reflecting average form score -->
            <div class="h-1.5 w-full bg-slate-100">
                <div class="h-1.5 bg-[#1C9BA0] transition-all duration-300"
                    style="width: {{ min(100, round($sessions->avg('AvgFormScore') ?? 0)) }}%"></div>
            </div>
        </div>
        <!-- ============== END HEADER ============== -->

        <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.06)]">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm leading-6">
                    <thead class="border-b border-gray-100 bg-[#F7FCFC] text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3">Date</th>
                            <th scope="col" class="py-3.5 px-3">Reps</th>
                            <th scope="col" class="py-3.5 px-3 text-emerald-600">Good Form</th>
                            <th scope="col" class="py-3.5 px-3 text-rose-500">Bad Form</th>
                            <th scope="col" class="py-3.5 px-3">Avg Score</th>
                            <th scope="col" class="py-3.5 pl-3 pr-6 text-right">Duration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($sessions as $session)
                            <tr class="transition-colors duration-150 hover:bg-[#F7FCFC]">
                                <td class="py-4 pl-6 pr-3 font-medium text-gray-900">
                                    {{ $session->AttemptedAt->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-3 font-semibold text-gray-700">
                                    {{ $session->RepsCompleted }}
                                </td>
                                <td class="py-4 px-3">
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                        {{ $session->RepsGoodForm }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                        {{ $session->RepsBadForm }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $session->AvgFormScore >= 80 ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' : ($session->AvgFormScore >= 50 ? 'bg-amber-50 text-amber-700 ring-amber-600/10' : 'bg-rose-50 text-rose-700 ring-rose-600/10') }}">
                                        {{ $session->AvgFormScore }}%
                                    </span>
                                </td>
                                <td class="py-4 pl-3 pr-6 text-right text-gray-500">
                                    {{ $session->DurationSeconds }}s
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full border border-gray-100 bg-gray-50 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">No sessions logged yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app1>