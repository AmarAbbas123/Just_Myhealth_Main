<x-app1>
    @php
        $attr = $client?->userAttributes;
        $firstName = $attr?->FirstName ?? '';
        $lastName = $attr?->LastName ?? '';
        $clientRealName = trim("$firstName $lastName");
        $clientName = $clientRealName !== '' ? $clientRealName : ($client?->UserName ?? 'Client');
        $initials = strtoupper(substr($firstName ?: ($client?->UserName ?? 'C'), 0, 1) . substr($lastName, 0, 1)) ?: 'CL';
        $userName = $client?->UserName ?? 'Client';

        $photo = $attr?->UserPhoto
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto)
            : ($client?->profile_photo_url ?? ($client?->profile_photo ?? null));

        $totalSessions = $sessions->count();
        $notesCount = $sessions->filter(fn($s) => !empty(trim($s->TherapistNotes ?? '')))->count();
        $withResourcesCount = $sessions->filter(fn($s) => count($s->session_resource_links ?? []) > 0)->count();
        $totalResources = $sessions->sum(fn($s) => count($s->session_resource_links ?? []));

        $splitDateTime = function ($date, $time = null) {
            if (!$date && !$time) {
                return ['date' => '-', 'time' => null];
            }
            try {
                $raw = trim(($date ?? '') . ' ' . ($time ?? ''));
                $d = \Carbon\Carbon::parse($raw);
                $hasTime = $time || (strpos((string)$date, ':') !== false);
                return [
                    'date' => $d->format('d M Y'),
                    'time' => $hasTime ? $d->format('H:i') : null,
                ];
            } catch (\Exception $e) {
                return ['date' => trim(($date ?? '') . ' ' . ($time ?? '')) ?: '-', 'time' => null];
            }
        };

        $sessionsList = $sessions->map(function($s) {
            $ref = (string) $s->ID;
            $date = $s->SessionStartedDate ? \Carbon\Carbon::parse($s->SessionStartedDate)->format('d M Y') : '';
            $notes = strtolower($s->TherapistNotes ?? '');
            $resourceNames = collect($s->session_resource_links ?? [])->pluck('name')->implode(' ');
            $hasNotes = !empty(trim($s->TherapistNotes ?? ''));
            $hasResources = count($s->session_resource_links ?? []) > 0;

            return [
                'id' => $s->ID,
                'search' => strtolower(trim("$ref $date $notes $resourceNames")),
                'has_notes' => $hasNotes,
                'has_resources' => $hasResources,
            ];
        })->values();
    @endphp

    <div x-data="sessionNotes()" class="space-y-6">

        <!-- Page Header & Back Button -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
            <a href="{{ route('therap.session.history.clients') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs hover:shadow-xs active:scale-95 self-start md:self-auto">
                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Clients</span>
            </a>
        </div>

        <!-- Client Overview Header Banner -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <!-- Avatar -->
                <div class="relative shrink-0">
                    @if ($photo)
                        <img src="{{ $photo }}"
                             alt="{{ $clientName }}"
                             class="w-14 h-14 rounded-2xl object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-2xs"
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

                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $clientName }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300">
                            {{ '@' . $userName }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-teal-600 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/30 px-2.5 py-0.5 rounded-full border border-teal-100 dark:border-teal-800/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#1C9BA0]"></span>
                            Client
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-400 mt-1">
                        Viewing therapist session notes, clinical observations, and attached collateral resources.
                    </p>
                </div>
            </div>

            <!-- Session Dates Quick Navigation -->
            <div class="flex items-center gap-2 self-start md:self-auto">
                <a href="{{ route('therap.session.history.clients.dates', ['client_id' => $client?->ID ?? request('client_id')]) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white shadow-2xs hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer"
                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>View Session Dates</span>
                </a>
            </div>
        </div>

        <!-- Quick Summary Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Stat 1: Total Completed -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Total Consultations</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $totalSessions }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Completed consultations</p>
                </div>
            </div>

            <!-- Stat 2: Documented Notes -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-teal-600 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Documented Notes</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $notesCount }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Sessions with clinical notes</p>
                </div>
            </div>

            <!-- Stat 3: Attached Resources -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Attached Collateral</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $totalResources }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Resources across {{ $withResourcesCount }} {{ \Illuminate\Support\Str::plural('session', $withResourcesCount) }}</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col md:flex-row md:items-center justify-between gap-4">
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
                    placeholder="Search notes by keyword, ref, date, or document..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
            </div>

            <!-- Filter Pills -->
            <div class="flex items-center gap-1.5 p-1 rounded-xl bg-gray-100/80 dark:bg-gray-900/80 border border-gray-200/50 dark:border-gray-700/50 self-start md:self-auto">
                <button
                    type="button"
                    @click="filterType = 'all'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer"
                    :class="filterType === 'all'
                        ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-2xs'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'">
                    All Sessions ({{ $totalSessions }})
                </button>
                <button
                    type="button"
                    @click="filterType = 'notes'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5"
                    :class="filterType === 'notes'
                        ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] dark:text-teal-400 shadow-2xs'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'">
                    <span>With Notes</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-teal-50 dark:bg-teal-900/40 text-teal-600 dark:text-teal-300 font-bold">{{ $notesCount }}</span>
                </button>
                <button
                    type="button"
                    @click="filterType = 'resources'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5"
                    :class="filterType === 'resources'
                        ? 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 shadow-2xs'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'">
                    <span>With Documents</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 font-bold">{{ $withResourcesCount }}</span>
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 overflow-hidden">

            <!-- DESKTOP TABLE VIEW -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="px-5 py-4 w-28 whitespace-nowrap">History Ref</th>
                            <th scope="col" class="px-5 py-4 w-44 whitespace-nowrap">Session Start</th>
                            <th scope="col" class="px-5 py-4">Session Notes</th>
                            <th scope="col" class="px-5 py-4 w-80">Collateral Links</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-sm">
                        @forelse($sessions as $session)
                            @php
                                $sessionStart = $splitDateTime($session->SessionStartedDate, $session->SessionStartedTime);
                                $hasNotes = !empty(trim($session->TherapistNotes ?? ''));
                                $resources = $session->session_resource_links ?? [];
                            @endphp

                            <tr x-show="isRowVisible({{ $session->ID }})" class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors group align-top">
                                <!-- History Ref -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 dark:bg-gray-700/60 text-gray-800 dark:text-gray-200">
                                        #{{ $session->ID }}
                                    </span>
                                </td>

                                <!-- Session Start -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-[#1C9BA0]/10 flex items-center justify-center text-[#1C9BA0] shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-gray-100 text-xs sm:text-sm">
                                                {{ $sessionStart['date'] }}
                                            </div>
                                            @if ($sessionStart['time'])
                                                <div class="text-[11px] text-teal-600 dark:text-teal-400 font-semibold mt-0.5">
                                                    {{ $sessionStart['time'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Session Notes -->
                                <td class="px-5 py-4">
                                    @if ($hasNotes)
                                        <div class="flex items-start gap-2.5">
                                            <div class="w-1 self-stretch rounded-full bg-[#1C9BA0]/50 shrink-0"></div>
                                            <div class="text-xs sm:text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line py-0.5 max-w-xl">{{ trim($session->TherapistNotes) }}</div>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">No notes recorded for this session.</span>
                                    @endif
                                </td>

                                <!-- Collateral Links -->
                                <td class="px-5 py-4">
                                    @if(count($resources))
                                        <div class="space-y-2">
                                            @foreach($resources as $resource)
                                                <a href="{{ $resource['url'] }}"
                                                    class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50/80 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 hover:border-[#1C9BA0] transition-colors group/link shadow-2xs">
                                                    <div class="flex items-center gap-2 min-w-0">
                                                        <svg class="w-4 h-4 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                        <span class="text-xs font-medium text-gray-800 dark:text-gray-200 group-hover/link:text-[#1C9BA0] truncate">
                                                            {{ $resource['name'] }}
                                                        </span>
                                                    </div>
                                                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover/link:text-[#1C9BA0] shrink-0 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">No documents attached.</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3"
                                         style="background: rgba(28, 155, 160, 0.1); color: #1C9BA0;">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-gray-900 dark:text-gray-100">No Notes Recorded</h4>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                                        No session notes or attached documents were found for this client.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                        <!-- Empty Search Filter State -->
                        <tr x-show="!hasVisibleRows && sessionsList.length > 0" x-cloak>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No session notes match your search or filter criteria.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARD VIEW -->
            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700/70">
                @forelse($sessions as $session)
                    @php
                        $sessionStart = $splitDateTime($session->SessionStartedDate, $session->SessionStartedTime);
                        $hasNotes = !empty(trim($session->TherapistNotes ?? ''));
                        $resources = $session->session_resource_links ?? [];
                    @endphp

                    <div x-show="isRowVisible({{ $session->ID }})" class="p-4 space-y-3.5 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <!-- Top Header: Ref Badge + Start Time -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 dark:bg-gray-700/60 text-gray-800 dark:text-gray-200">
                                #{{ $session->ID }}
                            </span>
                            <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-300">
                                <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $sessionStart['date'] }}</span>
                                @if ($sessionStart['time'])
                                    <span>•</span>
                                    <span class="text-teal-600 dark:text-teal-400 font-semibold">{{ $sessionStart['time'] }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Notes Body -->
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Session Notes</span>
                            @if ($hasNotes)
                                <div class="flex items-start gap-2 pl-1">
                                    <div class="w-1 self-stretch rounded-full bg-[#1C9BA0]/50 shrink-0"></div>
                                    <div class="text-xs text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line py-0.5">{{ trim($session->TherapistNotes) }}</div>
                                </div>
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500 italic">No notes recorded for this session.</p>
                            @endif
                        </div>

                        <!-- Collateral Links -->
                        @if(count($resources))
                            <div class="space-y-1.5 pt-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Attached Documents ({{ count($resources) }})</span>
                                <div class="space-y-1.5">
                                    @foreach($resources as $resource)
                                        <a href="{{ $resource['url'] }}"
                                            class="flex items-center justify-between p-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/70 hover:border-[#1C9BA0] transition-colors shadow-2xs">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <svg class="w-3.5 h-3.5 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate">
                                                    {{ $resource['name'] }}
                                                </span>
                                            </div>
                                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                        No session notes recorded for this client.
                    </div>
                @endforelse

                <!-- Mobile Empty Filter State -->
                <div x-show="!hasVisibleRows && sessionsList.length > 0" x-cloak class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    No session notes match your search or filter criteria.
                </div>
            </div>

        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function sessionNotes() {
            return {
                searchQuery: '',
                filterType: 'all',
                sessionsList: @json($sessionsList),

                isRowVisible(id) {
                    const s = this.sessionsList.find(x => x.id === id);
                    if (!s) return true;
                    const q = this.searchQuery.toLowerCase().trim();
                    const matchesSearch = !q || s.search.includes(q);
                    const matchesFilter = this.filterType === 'all'
                        || (this.filterType === 'notes' && s.has_notes)
                        || (this.filterType === 'resources' && s.has_resources);
                    return matchesSearch && matchesFilter;
                },

                get hasVisibleRows() {
                    return this.sessionsList.some(s => {
                        const q = this.searchQuery.toLowerCase().trim();
                        const matchesSearch = !q || s.search.includes(q);
                        const matchesFilter = this.filterType === 'all'
                            || (this.filterType === 'notes' && s.has_notes)
                            || (this.filterType === 'resources' && s.has_resources);
                        return matchesSearch && matchesFilter;
                    });
                }
            };
        }
    </script>
</x-app1>
