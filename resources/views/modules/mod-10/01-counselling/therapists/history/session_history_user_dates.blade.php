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
        $videoSessions = $sessions->where('SessionMediaType', 'Video')->count();
        $audioSessions = $sessions->where('SessionMediaType', 'Audio')->count();

        $formatDateTime = function ($date, $time = null) {
            if (!$date && !$time) {
                return '-';
            }

            try {
                $value = trim(($date ?? '') . ' ' . ($time ?? ''));
                $format = $time ? 'd M Y, H:i' : 'd M Y';

                return \Carbon\Carbon::parse($value)->format($format);
            } catch (\Exception $e) {
                return trim(($date ?? '') . ' ' . ($time ?? '')) ?: '-';
            }
        };

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

        $formatDuration = function ($session) {
            if (!$session->SessionStartedDate || !$session->SessionStartedTime || !$session->SessionEndedDate || !$session->SessionEndedTime) {
                return '-';
            }

            try {
                $start = \Carbon\Carbon::parse($session->SessionStartedDate . ' ' . $session->SessionStartedTime);
                $end = \Carbon\Carbon::parse($session->SessionEndedDate . ' ' . $session->SessionEndedTime);

                if ($end->lessThanOrEqualTo($start)) {
                    return '-';
                }

                $minutes = $start->diffInMinutes($end);
                $hours = intdiv($minutes, 60);
                $remainingMinutes = $minutes % 60;

                return $hours > 0 ? "{$hours}h {$remainingMinutes}m" : "{$remainingMinutes}m";
            } catch (\Exception $e) {
                return '-';
            }
        };

        $sessionsList = $sessions->map(function($s) use ($formatDuration) {
            $ref = (string) $s->ID;
            $booked = $s->SessionBookedDate ? \Carbon\Carbon::parse($s->SessionBookedDate)->format('d M Y') : '';
            $started = $s->SessionStartedDate ? \Carbon\Carbon::parse($s->SessionStartedDate)->format('d M Y') : '';
            $duration = $formatDuration($s);
            $media = strtolower(trim($s->SessionMediaType ?? ''));
            return [
                'id' => $s->ID,
                'search' => strtolower(trim("$ref $booked $started $duration $media")),
                'media' => $media,
            ];
        })->values();
    @endphp

    <div x-data="sessionDates()" class="space-y-6">

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
                        Viewing chronological session history, room check-in logs, and duration records.
                    </p>
                </div>
            </div>

            <!-- Notes History Quick Navigation -->
            <div class="flex items-center gap-2 self-start md:self-auto">
                <a href="{{ route('therap.session.history.clients.notes', ['client_id' => $client?->ID ?? request('client_id')]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white shadow-2xs hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer"
                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>View Notes History</span>
                </a>
            </div>
        </div>

        <!-- Quick Summary Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Stat 1: Total Sessions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Total Completed</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $totalSessions }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Past therapy consultations</p>
                </div>
            </div>

            <!-- Stat 2: Video Consultations -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-teal-600 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Video Consultations</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $videoSessions }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Live video sessions</p>
                </div>
            </div>

            <!-- Stat 3: Audio Consultations -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Audio Consultations</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $audioSessions }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400">Voice-only sessions</p>
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
                    placeholder="Search by ref, date, duration, or session type..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
            </div>

            <!-- Media Filter Pills -->
            <div class="flex items-center gap-1.5 p-1 rounded-xl bg-gray-100/80 dark:bg-gray-900/80 border border-gray-200/50 dark:border-gray-700/50 self-start md:self-auto">
                <button
                    type="button"
                    @click="mediaFilter = 'all'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer"
                    :class="mediaFilter === 'all'
                        ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-2xs'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'">
                    All Sessions ({{ $totalSessions }})
                </button>
                <button
                    type="button"
                    @click="mediaFilter = 'video'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5"
                    :class="mediaFilter === 'video'
                        ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] dark:text-teal-400 shadow-2xs'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'">
                    <span>Video</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-teal-50 dark:bg-teal-900/40 text-teal-600 dark:text-teal-300 font-bold">{{ $videoSessions }}</span>
                </button>
                <button
                    type="button"
                    @click="mediaFilter = 'audio'"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5"
                    :class="mediaFilter === 'audio'
                        ? 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 shadow-2xs'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200'">
                    <span>Audio</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 font-bold">{{ $audioSessions }}</span>
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
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 whitespace-nowrap">History Ref</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 whitespace-nowrap">Session Booked</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 whitespace-nowrap">Client Waiting Room</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 whitespace-nowrap">Therapist Waiting Room</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 whitespace-nowrap">Session Started</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 whitespace-nowrap">Session Ended</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 text-center whitespace-nowrap">Session Duration</th>
                            <th scope="col" class="px-2.5 sm:px-3 py-3.5 text-center whitespace-nowrap">Session Type</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-sm">
                        @forelse($sessions as $session)
                            @php
                                $mediaType = strtolower(trim($session->SessionMediaType ?? ''));
                                $duration = $formatDuration($session);
                                $clientWaiting = $splitDateTime($session->PatientEnteredWaitingRoomDate, $session->PatientEnteredWaitingRoomTime);
                                $therapistWaiting = $splitDateTime($session->TherapistEnteredWaitingRoomDate, $session->TherapistEnteredWaitingRoomTime);
                                $sessionStart = $splitDateTime($session->SessionStartedDate, $session->SessionStartedTime);
                                $sessionEnd = $splitDateTime($session->SessionEndedDate, $session->SessionEndedTime);
                            @endphp

                            <tr x-show="isRowVisible({{ $session->ID }})" class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors group">
                                <!-- History Ref -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-gray-100 dark:bg-gray-700/60 text-gray-800 dark:text-gray-200">
                                        #{{ $session->ID }}
                                    </span>
                                </td>

                                <!-- Session Booked -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-6 h-6 rounded-md bg-[#1C9BA0]/10 flex items-center justify-center text-[#1C9BA0] shrink-0">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-800 dark:text-gray-200 text-xs">
                                            {{ $session->SessionBookedDate ? \Carbon\Carbon::parse($session->SessionBookedDate)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Client Entered Waiting Room -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap">
                                    @if ($clientWaiting['date'] !== '-')
                                        <div class="leading-tight">
                                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $clientWaiting['date'] }}</div>
                                            @if ($clientWaiting['time'])
                                                <div class="text-[11px] text-gray-400 dark:text-gray-400">{{ $clientWaiting['time'] }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Therapist Entered Waiting Room -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap">
                                    @if ($therapistWaiting['date'] !== '-')
                                        <div class="leading-tight">
                                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $therapistWaiting['date'] }}</div>
                                            @if ($therapistWaiting['time'])
                                                <div class="text-[11px] text-gray-400 dark:text-gray-400">{{ $therapistWaiting['time'] }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Session Started -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap">
                                    @if ($sessionStart['date'] !== '-')
                                        <div class="leading-tight">
                                            <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ $sessionStart['date'] }}</div>
                                            @if ($sessionStart['time'])
                                                <div class="text-[11px] font-semibold text-teal-600 dark:text-teal-400">{{ $sessionStart['time'] }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Session Ended -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap">
                                    @if ($sessionEnd['date'] !== '-')
                                        <div class="leading-tight">
                                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $sessionEnd['date'] }}</div>
                                            @if ($sessionEnd['time'])
                                                <div class="text-[11px] text-gray-400 dark:text-gray-400">{{ $sessionEnd['time'] }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Session Duration -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap text-center">
                                    @if ($duration !== '-')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $duration }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Session Type -->
                                <td class="px-2.5 sm:px-3 py-3 whitespace-nowrap text-center">
                                    @if ($mediaType === 'video')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:text-[#38b2ac]">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            Video
                                        </span>
                                    @elseif ($mediaType === 'audio')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/>
                                            </svg>
                                            Audio
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ ucfirst($session->SessionMediaType ?: 'Session') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3"
                                         style="background: rgba(28, 155, 160, 0.1); color: #1C9BA0;">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-gray-900 dark:text-gray-100">No Session Dates Recorded</h4>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                                        No session dates or waiting room logs were found for this client.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                        <!-- Empty Search Filter State -->
                        <tr x-show="!hasVisibleRows && sessionsList.length > 0" x-cloak>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No sessions match your search or filter criteria.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARD VIEW -->
            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700/70">
                @forelse($sessions as $session)
                    @php
                        $mediaType = strtolower(trim($session->SessionMediaType ?? ''));
                        $duration = $formatDuration($session);
                    @endphp

                    <div x-show="isRowVisible({{ $session->ID }})" class="p-4 space-y-3 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <!-- Top Header: Ref Badge + Media Type + Duration -->
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 dark:bg-gray-700/60 text-gray-800 dark:text-gray-200">
                                    #{{ $session->ID }}
                                </span>
                                @if ($duration !== '-')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $duration }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                @if ($mediaType === 'video')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:text-[#38b2ac]">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Video
                                    </span>
                                @elseif ($mediaType === 'audio')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                                        Audio
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ ucfirst($session->SessionMediaType ?: 'Session') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Booked Date -->
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Booked: <strong class="text-gray-900 dark:text-gray-100">{{ $formatDateTime($session->SessionBookedDate) }}</strong></span>
                        </div>

                        <!-- Waiting Room Timings Grid -->
                        <div class="p-2.5 rounded-xl bg-gray-50/80 dark:bg-gray-900/50 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                                <span>Client In Waiting Room:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $formatDateTime($session->PatientEnteredWaitingRoomDate, $session->PatientEnteredWaitingRoomTime) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                                <span>Therapist In Waiting Room:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $formatDateTime($session->TherapistEnteredWaitingRoomDate, $session->TherapistEnteredWaitingRoomTime) }}</span>
                            </div>
                        </div>

                        <!-- Session Start & End Timeline -->
                        <div class="flex items-center justify-between pt-1 text-xs text-gray-500 dark:text-gray-400">
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider text-gray-400">Started</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $formatDateTime($session->SessionStartedDate, $session->SessionStartedTime) }}</span>
                            </div>
                            <div class="text-right">
                                <span class="block text-[10px] uppercase tracking-wider text-gray-400">Ended</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $formatDateTime($session->SessionEndedDate, $session->SessionEndedTime) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                        No session dates recorded for this client.
                    </div>
                @endforelse

                <!-- Mobile Empty Filter State -->
                <div x-show="!hasVisibleRows && sessionsList.length > 0" x-cloak class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    No sessions match your search or filter criteria.
                </div>
            </div>

        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function sessionDates() {
            return {
                searchQuery: '',
                mediaFilter: 'all',
                sessionsList: @json($sessionsList),

                isRowVisible(id) {
                    const s = this.sessionsList.find(x => x.id === id);
                    if (!s) return true;
                    const q = this.searchQuery.toLowerCase().trim();
                    const matchesSearch = !q || s.search.includes(q);
                    const matchesMedia = this.mediaFilter === 'all' || s.media === this.mediaFilter.toLowerCase();
                    return matchesSearch && matchesMedia;
                },

                get hasVisibleRows() {
                    return this.sessionsList.some(s => {
                        const q = this.searchQuery.toLowerCase().trim();
                        const matchesSearch = !q || s.search.includes(q);
                        const matchesMedia = this.mediaFilter === 'all' || s.media === this.mediaFilter.toLowerCase();
                        return matchesSearch && matchesMedia;
                    });
                }
            };
        }
    </script>
</x-app1>
