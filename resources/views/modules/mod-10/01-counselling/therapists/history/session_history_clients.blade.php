<x-app1>
    @php
        $sessionsCol = collect($sessions ?? $clients ?? []);
        $totalClients = $clients->count();
        $totalSessions = $sessionsCol->count();
        $videoSessions = $sessionsCol->where('SessionMediaType', 'Video')->count();
        $audioSessions = $sessionsCol->where('SessionMediaType', 'Audio')->count();
        $sessionsByClient = $sessionsCol->groupBy('PatientUserID');

        $clientsList = $clients->map(function($session) {
            $client = $session->patient;
            $attr = $client?->userAttributes;
            $realName = trim(($attr?->FirstName ?? '') . ' ' . ($attr?->LastName ?? ''));
            $displayName = $realName !== '' ? $realName : ($client?->UserName ?? 'Client');
            $userName = $client?->UserName ?? '';
            return [
                'id' => $session->PatientUserID,
                'search' => strtolower(trim($displayName . ' ' . $userName)),
            ];
        })->values();
    @endphp

    <div x-data="clientHistory()" class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
        </div>

        <!-- Quick Summary Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Stat 1: Total Clients -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Total Clients</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $totalClients }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Consulting patients</p>
                </div>
            </div>

            <!-- Stat 2: Total Sessions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-teal-600 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Completed Sessions</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $totalSessions }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Past therapy consultations</p>
                </div>
            </div>

            <!-- Stat 3: Consultation Modes -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Consultations</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-2xl font-extrabold text-teal-600 dark:text-teal-400">{{ $videoSessions }}</span>
                        <span class="text-xs text-gray-400 font-medium">Video</span>
                        <span class="text-gray-300 dark:text-gray-600 mx-0.5">/</span>
                        <span class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $audioSessions }}</span>
                        <span class="text-xs text-gray-400 font-medium">Audio</span>
                    </div>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Live video & voice sessions</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Search Input -->
            <div class="relative flex-1 max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 dark:text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input
                    x-model="searchQuery"
                    type="text"
                    placeholder="Search by client name or username..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
            </div>

            <!-- Count Pill -->
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gray-100/80 dark:bg-gray-900/80 border border-gray-200/50 dark:border-gray-700/50 text-xs font-semibold text-gray-600 dark:text-gray-300">
                    <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                    <span>All Clients ({{ $totalClients }})</span>
                </span>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            @forelse($clients as $session)
                @php
                    $client = $session->patient;
                    $attr = $client?->userAttributes;
                    $firstName = $attr?->FirstName ?? '';
                    $lastName = $attr?->LastName ?? '';
                    $realName = trim("$firstName $lastName");
                    $displayName = $realName !== '' ? $realName : ($client?->UserName ?? 'Client');
                    $initials = strtoupper(substr($firstName ?: ($client?->UserName ?? 'C'), 0, 1) . substr($lastName, 0, 1)) ?: 'CL';
                    $userName = $client?->UserName ?? 'Client';

                    $photo = $attr?->UserPhoto
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto)
                        : ($client?->profile_photo_url ?? ($client?->profile_photo ?? null));

                    $clientHistory = $sessionsByClient->get($session->PatientUserID) ?? collect([$session]);
                    $clientSessionCount = $clientHistory->count();
                    $latestSession = $clientHistory->first();
                    $latestDate = $latestSession?->SessionStartedDate
                        ? \Carbon\Carbon::parse($latestSession->SessionStartedDate)->format('d M Y')
                        : ($latestSession?->SessionBookedDate ? \Carbon\Carbon::parse($latestSession->SessionBookedDate)->format('d M Y') : 'N/A');
                @endphp

                <div x-show="isClientVisible({{ $session->PatientUserID }})"
                     class="bg-white dark:bg-gray-800 rounded-2xl p-5 sm:p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_12px_30px_-6px_rgba(0,0,0,0.1)] transition-all duration-300 relative overflow-hidden group flex flex-col justify-between">

                    <!-- Left Accent Hover Bar -->
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                         style="background: linear-gradient(180deg, #1C9BA0, #127F94);"></div>

                    <div>
                        <!-- Top Header: Avatar + Info + Role Badge -->
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <!-- Avatar -->
                                <div class="relative shrink-0">
                                    @if ($photo)
                                        <img src="{{ $photo }}"
                                             alt="{{ $displayName }}"
                                             class="w-14 h-14 rounded-2xl object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-2xs group-hover:ring-[#1C9BA0]/30 transition-all"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                        <div class="w-14 h-14 rounded-2xl items-center justify-center text-white text-base font-bold shadow-2xs"
                                             style="display:none; background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                            {{ $initials }}
                                        </div>
                                    @else
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-base font-bold shadow-2xs"
                                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Name and Username -->
                                <div class="min-w-0">
                                    <h3 class="font-bold text-base sm:text-lg text-gray-900 dark:text-gray-100 truncate group-hover:text-[#1C9BA0] transition-colors">
                                        {{ $displayName }}
                                    </h3>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 truncate">
                                            {{ '@' . $userName }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Client Tag -->
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-teal-600 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/30 px-2.5 py-1 rounded-full shrink-0 border border-teal-100 dark:border-teal-800/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#1C9BA0]"></span>
                                Client
                            </span>
                        </div>

                        <!-- Client Metrics Pill Row -->
                        <div class="mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-1.5">
                                <div class="w-6 h-6 rounded-lg bg-[#1C9BA0]/10 flex items-center justify-center text-[#1C9BA0] shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span>Total: <strong class="font-semibold text-gray-800 dark:text-gray-200">{{ $clientSessionCount }}</strong> {{ \Illuminate\Support\Str::plural('Session', $clientSessionCount) }}</span>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <div class="w-6 h-6 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span>Latest: <strong class="font-semibold text-gray-800 dark:text-gray-200">{{ $latestDate }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Row -->
                    <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                        <a href="{{ route('therap.session.history.clients.dates', ['client_id' => $session->PatientUserID]) }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-[#1C9BA0] text-[#1C9BA0] hover:bg-[#1C9BA0] hover:text-white dark:border-[#1C9BA0] dark:text-[#38b2ac] dark:hover:bg-[#1C9BA0] dark:hover:text-white transition-all duration-200 shadow-2xs hover:shadow-xs cursor-pointer active:scale-98 flex-1">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>View Session Dates</span>
                        </a>

                        <a href="{{ route('therap.session.history.clients.notes', ['client_id' => $session->PatientUserID]) }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white shadow-2xs hover:shadow-md transition-all duration-200 cursor-pointer active:scale-98 flex-1"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4 shrink-0 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>View Notes History</span>
                        </a>
                    </div>

                </div>
            @empty
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3"
                         style="background: rgba(28, 155, 160, 0.1); color: #1C9BA0;">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-gray-100">No Client Session History Found</h4>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                        Clients who have attended counselling consultations with you will appear here.
                    </p>
                </div>
            @endforelse

            <!-- Empty Search State -->
            <div x-show="!hasVisibleClients && clientsList.length > 0" x-cloak
                 class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] p-12 text-center">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 text-gray-400 bg-gray-100 dark:bg-gray-700/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">No matching clients found</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Try searching with a different name or username.
                </p>
            </div>
        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function clientHistory() {
            return {
                searchQuery: '',
                clientsList: @json($clientsList),

                isClientVisible(id) {
                    const c = this.clientsList.find(x => x.id === id);
                    if (!c) return true;
                    const q = this.searchQuery.toLowerCase().trim();
                    return !q || c.search.includes(q);
                },

                get hasVisibleClients() {
                    const q = this.searchQuery.toLowerCase().trim();
                    if (!q) return true;
                    return this.clientsList.some(c => c.search.includes(q));
                }
            };
        }
    </script>
</x-app1>
