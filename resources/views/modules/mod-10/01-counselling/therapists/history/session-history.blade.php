<x-app1>
    @php
        $resourceGroups = collect($sessionNoteResources ?? [])
            ->groupBy('folder_key')
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'folder_key' => $first['folder_key'] ?? 'group::' . md5((string) ($first['folder'] ?? 'Root')),
                    'folder' => $first['folder'] ?? 'Root',
                    'type' => $first['type'] ?? 'private',
                    'items' => $items->values(),
                ];
            })
            ->values();

        $isTherapist = in_array((int)(auth()->user()->UserType ?? 0), [30, 31, 32]);
        $totalSessions = $sessions->count();
        $videoSessions = $sessions->where('SessionMediaType', 'Video')->count();
        $audioSessions = $sessions->where('SessionMediaType', 'Audio')->count();

        $sessionsList = $sessions->map(function($s) use ($isTherapist) {
            $targetUser = $isTherapist ? $s->patient : ($s->therapist ?? $s->patient);
            $attr = $targetUser?->userAttributes;
            $name = trim(($attr?->FirstName ?? '') . ' ' . ($attr?->LastName ?? ''));
            $dateFormatted = $s->SessionStartedDate ? \Carbon\Carbon::parse($s->SessionStartedDate)->format('d M Y') : '';
            return [
                'id' => $s->ID,
                'search' => strtolower(trim(($targetUser?->UserName ?? '') . ' ' . $name . ' ' . $dateFormatted)),
                'media' => strtolower($s->SessionMediaType ?? ''),
            ];
        })->values();
    @endphp

    <div x-data="sessionHistory()" class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <x-page-header />
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

            <!-- Stat 2: Video Sessions -->
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

            <!-- Stat 3: Audio Sessions -->
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
                    placeholder="Search by client name, username, or date..."
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

        <!-- Table / Card Container (Design matching screenshot) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 overflow-hidden">
            
            <!-- DESKTOP TABLE VIEW (hidden on mobile, visible on md and up) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-left border-collapse">

                    <!-- Table Head -->
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="px-5 sm:px-6 py-4">Date & Time</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">{{ $isTherapist ? 'Patient' : 'Therapist' }}</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">Screen Name</th>
                            <th scope="col" class="px-5 sm:px-6 py-4 text-center">Media</th>
                            <th scope="col" class="px-5 sm:px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-sm">
                        @forelse($sessions as $session)
                            @php
                                $targetUser = $isTherapist ? $session->patient : ($session->therapist ?? $session->patient);
                                $attr = $targetUser?->userAttributes;
                                $photo = $attr?->UserPhoto
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto)
                                    : ($targetUser?->profile_photo_url ?? null);

                                $firstName = $attr?->FirstName ?? '';
                                $lastName = $attr?->LastName ?? '';
                                $fullName = trim("$firstName $lastName") ?: ($targetUser?->UserName ?? ($isTherapist ? 'Patient' : 'Therapist'));
                                $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) ?: ($isTherapist ? 'PT' : 'TH');
                                $screenName = $targetUser?->UserName ?? ($isTherapist ? 'Patient' : 'Therapist');
                                $mediaType = strtolower(trim($session->SessionMediaType ?? ''));
                            @endphp

                            <tr x-show="isRowVisible({{ $session->ID }})" class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors group">

                                <!-- Date / Time -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-[#1C9BA0]/10 flex items-center justify-center text-[#1C9BA0] shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 leading-tight">
                                                {{ \Carbon\Carbon::parse($session->SessionStartedDate)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ \Carbon\Carbon::parse($session->SessionStartedTime)->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Patient/Therapist Name & Photo / Initials -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="relative shrink-0">
                                            @if ($photo)
                                                <img src="{{ $photo }}"
                                                     alt="{{ $fullName }}"
                                                     class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-2xs"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                                <div class="w-10 h-10 rounded-full items-center justify-center text-white text-xs font-bold shadow-2xs"
                                                     style="display:none; background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                                    {{ $initials }}
                                                </div>
                                            @else
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-2xs"
                                                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-[#1C9BA0] transition-colors">
                                            {{ $fullName }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Screen Name -->
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300">
                                        {{ $screenName }}
                                    </span>
                                </td>

                                <!-- Media Type Badge -->
                                <td class="px-5 sm:px-6 py-4 text-center whitespace-nowrap">
                                    @if ($mediaType === 'video')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:text-[#38b2ac]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            Video
                                        </span>
                                    @elseif ($mediaType === 'audio')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/>
                                            </svg>
                                            Audio
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ ucfirst($session->SessionMediaType ?: 'Session') }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions Button -->
                                <td class="px-5 sm:px-6 py-4 text-right whitespace-nowrap">
                                    <button @click="openDetailsModal({{ $session->ID }}, '{{ addslashes($fullName) }}')"
                                        type="button"
                                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border border-[#1C9BA0] text-[#1C9BA0] hover:bg-[#1C9BA0] hover:text-white dark:border-[#1C9BA0] dark:text-[#38b2ac] dark:hover:bg-[#1C9BA0] dark:hover:text-white text-xs font-semibold transition-all duration-200 shadow-2xs hover:shadow-sm cursor-pointer active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View Details
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3"
                                         style="background: rgba(28, 155, 160, 0.1); color: #1C9BA0;">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-gray-900 dark:text-gray-100">No Completed Sessions Yet</h4>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                                        Completed therapy and counselling sessions will be documented here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                        <!-- Filter No Match Row -->
                        <tr x-show="!hasVisibleRows && sessionsList.length > 0" x-cloak>
                            <td colspan="5" class="py-14 px-4 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 flex items-center justify-center mx-auto mb-3 shadow-2xs">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">No matching sessions</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Try adjusting your search query or media filter.</p>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <!-- MOBILE CARD VIEW (visible on mobile only, hidden on md and up) -->
            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700/70">
                @forelse($sessions as $session)
                    @php
                        $targetUser = $isTherapist ? $session->patient : ($session->therapist ?? $session->patient);
                        $attr = $targetUser?->userAttributes;
                        $photo = $attr?->UserPhoto
                            ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto)
                            : ($targetUser?->profile_photo_url ?? null);

                        $firstName = $attr?->FirstName ?? '';
                        $lastName = $attr?->LastName ?? '';
                        $fullName = trim("$firstName $lastName") ?: ($targetUser?->UserName ?? ($isTherapist ? 'Patient' : 'Therapist'));
                        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) ?: ($isTherapist ? 'PT' : 'TH');
                        $screenName = $targetUser?->UserName ?? ($isTherapist ? 'Patient' : 'Therapist');
                        $mediaType = strtolower(trim($session->SessionMediaType ?? ''));
                    @endphp

                    <div x-show="isRowVisible({{ $session->ID }})" class="p-4 space-y-3 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <!-- Top Row: Avatar & Info + Media Badge -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="relative shrink-0">
                                    @if ($photo)
                                        <img src="{{ $photo }}"
                                             alt="{{ $fullName }}"
                                             class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-2xs"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                        <div class="w-11 h-11 rounded-full items-center justify-center text-white text-xs font-bold shadow-2xs"
                                             style="display:none; background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                            {{ $initials }}
                                        </div>
                                    @else
                                        <div class="w-11 h-11 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-2xs"
                                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-gray-900 dark:text-gray-100 truncate text-sm">
                                        {{ $fullName }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-400 truncate mt-0.5">
                                        {{ '@' . $screenName }}
                                    </div>
                                </div>
                            </div>

                            <!-- Media Badge -->
                            <div class="shrink-0">
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
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ ucfirst($session->SessionMediaType ?: 'Session') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Date & Time + Action Button Row -->
                        <div class="flex items-center justify-between pt-1">
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($session->SessionStartedDate)->format('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ \Carbon\Carbon::parse($session->SessionStartedTime)->format('H:i') }}</span>
                            </div>

                            <button @click="openDetailsModal({{ $session->ID }}, '{{ addslashes($fullName) }}')"
                                type="button"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full border border-[#1C9BA0] text-[#1C9BA0] hover:bg-[#1C9BA0] hover:text-white dark:border-[#1C9BA0] dark:text-[#38b2ac] dark:hover:bg-[#1C9BA0] dark:hover:text-white text-xs font-semibold transition-all duration-200 shadow-2xs hover:shadow-sm cursor-pointer active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">No sessions recorded yet</p>
                    </div>
                @endforelse

                <!-- Mobile Filter No Match Row -->
                <div x-show="!hasVisibleRows && sessionsList.length > 0" x-cloak class="p-8 text-center">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">No matching sessions</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Try adjusting your search query or media filter.</p>
                </div>
            </div>

        </div>

        <!-- Session Details & Notes Modal -->
        <div
            x-show="isMessageModalOpen"
            x-cloak
            @click.self="closeModal"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4 transition-all duration-200"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl w-full max-w-xl sm:max-w-2xl shadow-2xl border border-gray-100 dark:border-gray-700/80 flex flex-col max-h-[90vh] overflow-hidden"
                @click.stop
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <!-- Modal Header -->
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-800/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Session Details & Clinical Notes</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Complete summary, notes and shared collateral for this session.</p>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="closeModal"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="text-center py-16 flex flex-col items-center justify-center gap-3">
                    <div class="w-8 h-8 border-3 border-[#1C9BA0] border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium">Loading session details...</p>
                </div>

                <!-- Scrollable Modal Body -->
                <div x-show="!loading" class="overflow-y-auto flex-1 p-5 sm:p-6 space-y-5 text-sm">

                    <!-- 4-Card Summary Key-Values -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="p-3 rounded-xl bg-gray-50/80 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Date</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-gray-100 mt-0.5 truncate" x-text="selectedSession.session_started_date"></p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/80 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Patient</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-gray-100 mt-0.5 truncate" x-text="selectedSession.patient"></p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/80 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Media</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-gray-100 mt-0.5 truncate" x-text="selectedSession.media_type"></p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/80 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Duration</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-gray-100 mt-0.5 truncate" x-text="selectedSession.duration"></p>
                        </div>
                    </div>

                    <!-- Therapy Notes Section -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <h4 class="font-bold text-xs sm:text-sm text-gray-900 dark:text-gray-100">Clinical & Session Notes</h4>
                            </div>
                        </div>

                        <!-- VIEW mode -->
                        <template x-if="!editMode">
                            <div class="rounded-xl sm:rounded-2xl p-4 bg-gray-50/70 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap min-h-[80px]">
                                <span x-text="selectedSession.therapist_notes || 'No clinical notes recorded for this session yet.'"></span>
                            </div>
                        </template>

                        <!-- EDIT mode -->
                        <template x-if="editMode">
                            <textarea
                                x-model="editNotes"
                                rows="5"
                                class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-3 text-xs sm:text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs leading-relaxed"
                                placeholder="Write clinical notes for this session…"></textarea>
                        </template>
                    </div>

                    <!-- Support Collateral Links Section -->
                    <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                <h4 class="font-bold text-xs sm:text-sm text-gray-900 dark:text-gray-100">Support Collateral & Attached Resources</h4>
                            </div>
                        </div>

                        <!-- VIEW mode -->
                        <template x-if="!editMode">
                            <div class="space-y-2">
                                <template x-if="selectedSession.session_note_resources.length === 0">
                                    <div class="p-3.5 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 text-xs text-gray-400 dark:text-gray-500">
                                        No documents attached to this session.
                                    </div>
                                </template>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <template x-for="(resource, index) in selectedSession.session_note_resources" :key="index">
                                        <a
                                            :href="resource.url"
                                            target="_blank"
                                            class="flex items-center justify-between gap-3 p-3 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60 hover:border-[#1C9BA0]/50 hover:bg-[#1C9BA0]/5 transition-all group">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <div class="w-7 h-7 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-[#1C9BA0] flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate group-hover:text-[#1C9BA0] transition-colors" x-text="resource.name"></span>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#1C9BA0] shrink-0 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- EDIT mode -->
                        <template x-if="editMode">
                            <div class="space-y-3">
                                <!-- Currently attached -->
                                <template x-if="selectedResourcePaths.length > 0">
                                    <div class="space-y-1.5">
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Currently attached</p>
                                        <div class="space-y-1.5">
                                            <template x-for="resource in selectedResourcesForDisplay()" :key="resource.path">
                                                <div class="flex items-center justify-between gap-2 rounded-xl bg-gray-50 dark:bg-gray-700/60 px-3 py-2 border border-gray-100 dark:border-gray-700">
                                                    <div class="flex items-center gap-2 min-w-0">
                                                        <svg class="w-3.5 h-3.5 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                        <span class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate" x-text="resource.name"></span>
                                                    </div>
                                                    <button
                                                        type="button"
                                                        @click="toggleResource(resource.path, false)"
                                                        class="text-[11px] font-semibold px-2 py-0.5 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 rounded-lg hover:bg-red-100 transition cursor-pointer shrink-0">
                                                        Remove
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <!-- Type toggle: Common / Private -->
                                <div class="flex items-center gap-2 pt-1">
                                    <button
                                        type="button"
                                        @click="selectedResourceType = 'common'"
                                        :class="selectedResourceType === 'common'
                                            ? 'bg-[#1C9BA0] text-white shadow-xs'
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'"
                                        class="px-4 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                                        🌐 Common Resources
                                    </button>
                                    <button
                                        type="button"
                                        @click="selectedResourceType = 'private'"
                                        :class="selectedResourceType === 'private'
                                            ? 'bg-[#1C9BA0] text-white shadow-xs'
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'"
                                        class="px-4 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                                        🔒 Private Resources
                                    </button>
                                </div>

                                <!-- File list for selected type -->
                                <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                                    <template x-if="itemsForSelectedType().length === 0">
                                        <p class="text-xs text-gray-400 py-2">No files available in this category.</p>
                                    </template>
                                    <template x-for="resource in itemsForSelectedType()" :key="resource.path">
                                        <label class="flex items-center justify-between gap-3 rounded-xl border border-gray-100 dark:border-gray-700/80 px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <input
                                                    type="checkbox"
                                                    :checked="isResourceSelected(resource.path)"
                                                    :disabled="!isResourceSelected(resource.path) && selectedResourcePaths.length >= 8"
                                                    @change="toggleResource(resource.path, $event.target.checked)"
                                                    class="rounded border-gray-300 text-[#1C9BA0] focus:ring-[#1C9BA0]">
                                                <span class="text-xs text-gray-800 dark:text-gray-200 truncate" x-text="resource.name"></span>
                                            </div>
                                            <a
                                                :href="resource.url"
                                                target="_blank"
                                                class="text-[11px] text-[#1C9BA0] hover:underline shrink-0 font-medium">
                                                Preview
                                            </a>
                                        </label>
                                    </template>
                                </div>

                                <div class="flex items-center justify-between text-xs text-gray-400 pt-1">
                                    <span x-text="`${selectedResourcePaths.length} of 8 attachments selected`"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Save error alert -->
                    <div x-show="saveError" class="p-3 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 text-red-600 dark:text-red-300 text-xs">
                        <span x-text="saveError"></span>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-5 sm:px-6 py-4 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/80 flex items-center justify-between gap-2">
                    <!-- Left: Edit / Cancel -->
                    <div>
                        <template x-if="!editMode">
                            <button
                                type="button"
                                @click="startEdit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs transition active:scale-[0.98] cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                <span>Edit Notes</span>
                            </button>
                        </template>
                        <template x-if="editMode">
                            <button
                                type="button"
                                @click="cancelEdit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer">
                                Cancel
                            </button>
                        </template>
                    </div>

                    <!-- Right: Save / Close -->
                    <div class="flex items-center gap-2">
                        <template x-if="editMode">
                            <button
                                type="button"
                                @click="saveEdits"
                                :disabled="saving"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs hover:opacity-95 transition disabled:opacity-50 cursor-pointer"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg x-show="saving" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="saving ? 'Saving…' : 'Save Changes'"></span>
                            </button>
                        </template>
                        <button
                            type="button"
                            @click="closeModal"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer">
                            Close
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        function sessionHistory() {
            return {
                isMessageModalOpen: false,
                loading: false,
                editMode: false,
                saving: false,
                saveError: '',

                // Live search and filter
                searchQuery: '',
                mediaFilter: 'all',
                sessionsList: @json($sessionsList),

                // Edit state
                editNotes: '',
                selectedResourceType: 'common',
                availableResourceGroups: @json($resourceGroups),
                selectedResourceGroupKey: @json($resourceGroups->first()['folder_key'] ?? ''),
                selectedResourcePaths: [],

                selectedSession: {
                    id: null,
                    patient: '',
                    media_type: '',
                    session_started_date: '',
                    duration: '',
                    recording: '',
                    therapist_notes: '',
                    session_note_resources: [] // [{url, name, index}]
                },

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
                },

                async openDetailsModal(calendarId, patientName) {
                    this.isMessageModalOpen = true;
                    this.loading = true;
                    this.editMode = false;
                    this.saveError = '';
                    this.selectedResourcePaths = [];

                    this.selectedSession = {
                        id: calendarId,
                        patient: patientName,
                        media_type: '',
                        session_started_date: '',
                        duration: '',
                        recording: '',
                        therapist_notes: '',
                        session_note_resources: []
                    };

                    try {
                        const res = await fetch('/therapist/session-history/details', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                calendar_id: calendarId
                            })
                        });

                        const json = await res.json();
                        const d = json.data;

                        this.selectedSession.media_type = d.media_type ?? 'N/A';
                        this.selectedSession.session_started_date = d.session_started_date ?? 'N/A';
                        this.selectedSession.recording = d.recording ?? '';
                        this.selectedSession.therapist_notes = d.therapist_notes ?? '';
                        this.selectedSession.session_note_resources =
                            Array.isArray(d.session_note_resources) ? d.session_note_resources : [];

                        // Duration
                        if (d.session_started_time && d.session_ended_time) {
                            const start = new Date(`1970-01-01T${d.session_started_time}`);
                            const end = new Date(`1970-01-01T${d.session_ended_time}`);
                            const diffMs = end - start;
                            if (diffMs > 0) {
                                const mins = Math.floor(diffMs / 60000);
                                const hrs = Math.floor(mins / 60);
                                const remM = mins % 60;
                                this.selectedSession.duration = hrs > 0 ? `${hrs}h ${remM}m` : `${remM}m`;
                            } else {
                                this.selectedSession.duration = 'Not entered';
                            }
                        } else {
                            this.selectedSession.duration = 'Not entered';
                        }

                    } catch (e) {
                        console.error(e);
                        alert('Failed to load session details');
                    } finally {
                        this.loading = false;
                    }
                },

                startEdit() {
                    this.editNotes = this.selectedSession.therapist_notes;
                    this.selectedResourceType = 'common';
                    this.selectedResourcePaths = this.selectedSession.session_note_resources
                        .map(resource => resource.path)
                        .filter(Boolean);
                    if (!this.selectedResourceGroupKey && this.availableResourceGroups.length > 0) {
                        this.selectedResourceGroupKey = this.availableResourceGroups[0].folder_key;
                    }
                    this.saveError = '';
                    this.editMode = true;
                },

                cancelEdit() {
                    this.editMode = false;
                    this.selectedResourceType = 'common';
                    this.selectedResourcePaths = [];
                    this.saveError = '';
                },

                currentResourceGroupItems() {
                    const group = this.availableResourceGroups.find(
                        item => item.folder_key === this.selectedResourceGroupKey
                    );

                    return group?.items ?? [];
                },

                allAvailableResources() {
                    return this.availableResourceGroups.flatMap(group => group.items ?? []);
                },

                selectedResourcesForDisplay() {
                    const resourcesByPath = new Map(
                        this.allAvailableResources().map(resource => [resource.path, resource])
                    );

                    return this.selectedResourcePaths.map(path => {
                        const resource = resourcesByPath.get(path) ?? {
                            path,
                            name: path
                        };
                        return {
                            ...resource,
                            name: resource.path.split('/').pop() || resource.name
                        };
                    });
                },

                isResourceSelected(path) {
                    return this.selectedResourcePaths.includes(path);
                },

                toggleResource(path, checked) {
                    if (checked) {
                        if (this.selectedResourcePaths.length >= 8 || this.isResourceSelected(path)) {
                            return;
                        }

                        this.selectedResourcePaths.push(path);
                        return;
                    }

                    this.selectedResourcePaths = this.selectedResourcePaths.filter(item => item !== path);
                },

                async saveEdits() {
                    this.saving = true;
                    this.saveError = '';

                    try {
                        const form = new FormData();
                        form.append('history_id', this.selectedSession.id);
                        form.append('therapist_notes', this.editNotes);

                        this.selectedResourcePaths.forEach(path => {
                            form.append('selected_resources[]', path);
                        });

                        const res = await fetch('/mod-10/my-session-history/update-notes', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: form
                        });

                        const json = await res.json();

                        if (json.success) {
                            // Reflect notes change locally
                            this.selectedSession.therapist_notes = this.editNotes;
                            this.selectedResourcePaths = [];
                            this.editMode = false;
                            // Reload resources from server to get fresh URLs
                            await this.refreshResources();
                        } else {
                            this.saveError = json.message ?? 'Could not save changes.';
                        }

                    } catch (e) {
                        console.error(e);
                        this.saveError = 'An error occurred while saving.';
                    } finally {
                        this.saving = false;
                    }
                },

                async refreshResources() {
                    try {
                        const res = await fetch('/therapist/session-history/details', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                calendar_id: this.selectedSession.id
                            })
                        });
                        const json = await res.json();
                        if (json.success) {
                            this.selectedSession.session_note_resources =
                                Array.isArray(json.data.session_note_resources) ?
                                json.data.session_note_resources : [];
                        }
                    } catch (e) {
                        console.error('Failed to refresh resources', e);
                    }
                },

                itemsForSelectedType() {
                    return this.availableResourceGroups
                        .flatMap(group => group.items ?? [])
                        .filter(resource => resource.type === this.selectedResourceType)
                        .map(resource => ({
                            ...resource,
                            name: resource.path.split('/').pop() || resource.name
                        }));
                },

                closeModal() {
                    this.isMessageModalOpen = false;
                    this.editMode = false;
                    this.selectedResourceType = 'common';
                    this.selectedResourcePaths = [];
                    this.saveError = '';
                }
            };
        }
    </script>
</x-app1>
