<x-app1>
    <div x-data="sessionHistory()" class="space-y-6">

        <!-- Header -->
        <x-page-header />

        <!-- Table / Card Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 overflow-hidden">
            
            <!-- DESKTOP TABLE VIEW (hidden on mobile, visible on md and up) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-left border-collapse">

                    <!-- Table Head -->
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="px-5 sm:px-6 py-4">Date & Time</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">Therapist</th>
                            <th scope="col" class="px-5 sm:px-6 py-4">Screen Name</th>
                            <th scope="col" class="px-5 sm:px-6 py-4 text-center">Media</th>
                            <th scope="col" class="px-5 sm:px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-sm">
                        @forelse($sessions as $session)
                            @php
                                $attr = $session->therapist?->userAttributes;
                                $photo = $attr?->UserPhoto
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto)
                                    : ($session->therapist?->profile_photo_url ?? null);

                                $firstName = $attr?->FirstName ?? '';
                                $lastName = $attr?->LastName ?? '';
                                $fullName = trim("$firstName $lastName") ?: ($session->therapist?->UserName ?? 'Therapist');
                                $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) ?: 'TH';
                                $screenName = $session->therapist?->UserName ?? 'Therapist';
                                $mediaType = strtolower(trim($session->SessionMediaType ?? ''));
                            @endphp

                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition-colors group">

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

                                <!-- Therapist Name & Photo -->
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
                                    <h4 class="text-base font-bold text-gray-900 dark:text-gray-100">No Therapy Sessions Yet</h4>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                                        Your completed therapy and counselling sessions will be documented here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- MOBILE CARD VIEW (visible on mobile only, hidden on md and up) -->
            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700/70">
                @forelse($sessions as $session)
                    @php
                        $attr = $session->therapist?->userAttributes;
                        $photo = $attr?->UserPhoto
                            ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto)
                            : ($session->therapist?->profile_photo_url ?? null);

                        $firstName = $attr?->FirstName ?? '';
                        $lastName = $attr?->LastName ?? '';
                        $fullName = trim("$firstName $lastName") ?: ($session->therapist?->UserName ?? 'Therapist');
                        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) ?: 'TH';
                        $screenName = $session->therapist?->UserName ?? 'Therapist';
                        $mediaType = strtolower(trim($session->SessionMediaType ?? ''));
                    @endphp

                    <div class="p-4 space-y-3 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <!-- Top Row: Therapist Avatar & Info + Media Badge -->
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

                        <!-- Bottom Row: Date & Time + Action Button -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100/80 dark:border-gray-700/50">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-3.5 h-3.5 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($session->SessionStartedDate)->format('d M Y') }}
                                </span>
                                <span>•</span>
                                <span>{{ \Carbon\Carbon::parse($session->SessionStartedTime)->format('H:i') }}</span>
                            </div>

                            <button @click="openDetailsModal({{ $session->ID }}, '{{ addslashes($fullName) }}')"
                                type="button"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-[#1C9BA0] text-[#1C9BA0] hover:bg-[#1C9BA0] hover:text-white dark:border-[#1C9BA0] dark:text-[#38b2ac] dark:hover:bg-[#1C9BA0] dark:hover:text-white text-xs font-semibold transition-all duration-200 cursor-pointer active:scale-95 shadow-2xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No therapy sessions found.</p>
                    </div>
                @endforelse
            </div>

        </div>

        <!-- SESSION DETAILS MODAL -->
        <div x-show="isModalOpen" 
             x-cloak 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-2.5 sm:p-4" 
             @click.self="closeModal" 
             @keydown.escape.window="closeModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-xl bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden flex flex-col max-h-[92vh] sm:max-h-[90vh] my-auto"
                 @click.stop
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Top Brand Color Strip -->
                <div class="h-1.5 w-full shrink-0" style="background: linear-gradient(90deg, #1C9BA0, #127F94);"></div>

                <!-- Modal Header -->
                <div class="p-4 sm:p-6 bg-slate-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 flex items-start justify-between gap-3 sm:gap-4 shrink-0">
                    <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-base sm:text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug">
                                Session Details
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5 truncate">
                                Consultation with <span class="font-semibold text-gray-700 dark:text-gray-300" x-text="selectedSession.therapist"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button @click="closeModal"
                        class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-700 dark:hover:text-white flex items-center justify-center transition shadow-xs cursor-pointer shrink-0"
                        title="Close">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="overflow-y-auto p-4 sm:p-6 space-y-4" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
                    <!-- Loading Indicator -->
                    <div x-show="loading" class="py-12 flex flex-col items-center justify-center gap-3 text-gray-400">
                        <svg class="animate-spin w-8 h-8 text-[#1C9BA0]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <p class="text-sm font-medium">Loading session details...</p>
                    </div>

                    <!-- Content -->
                    <div x-show="!loading" class="space-y-4">
                        <!-- 4 Metrics Cards Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-2.5">
                            <!-- Date -->
                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70">
                                <div class="text-[10px] sm:text-[11px] font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Date</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800 dark:text-gray-100 mt-0.5 sm:mt-1 truncate" x-text="selectedSession.session_started_date || 'N/A'"></div>
                            </div>
                            <!-- Therapist -->
                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70">
                                <div class="text-[10px] sm:text-[11px] font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Therapist</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800 dark:text-gray-100 mt-0.5 sm:mt-1 truncate" x-text="selectedSession.therapist || 'N/A'"></div>
                            </div>
                            <!-- Media Type -->
                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70">
                                <div class="text-[10px] sm:text-[11px] font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Media</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800 dark:text-gray-100 mt-0.5 sm:mt-1 truncate" x-text="selectedSession.media_type || 'N/A'"></div>
                            </div>
                            <!-- Duration -->
                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70">
                                <div class="text-[10px] sm:text-[11px] font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Duration</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800 dark:text-gray-100 mt-0.5 sm:mt-1 truncate" x-text="selectedSession.duration || 'Not entered'"></div>
                            </div>
                        </div>

                        <!-- Therapy Notes -->
                        <div class="rounded-2xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 p-3.5 sm:p-5 space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Therapist Notes
                            </h4>
                            <div class="mt-2 text-xs sm:text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap rounded-xl bg-white dark:bg-gray-800 p-3 sm:p-3.5 border border-gray-100 dark:border-gray-700/70 shadow-2xs">
                                <template x-if="selectedSession.therapist_notes && selectedSession.therapist_notes.trim()">
                                    <span x-text="selectedSession.therapist_notes"></span>
                                </template>
                                <template x-if="!selectedSession.therapist_notes || !selectedSession.therapist_notes.trim()">
                                    <span class="text-gray-400 dark:text-gray-500 italic">No notes were recorded for this session.</span>
                                </template>
                            </div>
                        </div>

                        <!-- Support Collateral Links -->
                        <div class="rounded-2xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 p-3.5 sm:p-5 space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                Support Resources & Collateral
                            </h4>

                            <template x-if="selectedSession.session_note_resources.length === 0">
                                <p class="text-xs sm:text-sm text-gray-400 dark:text-gray-500 italic pt-1">No resource links attached to this session.</p>
                            </template>

                            <div class="mt-2 space-y-2" x-show="selectedSession.session_note_resources.length > 0">
                                <template x-for="(resource, index) in selectedSession.session_note_resources" :key="index">
                                    <a :href="resource.url" target="_blank"
                                        class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/70 hover:border-[#1C9BA0] transition-colors group shadow-2xs">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <svg class="w-4 h-4 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200 group-hover:text-[#1C9BA0] truncate" x-text="resource.name"></span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-[#1C9BA0] shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sticky Footer -->
                <div class="p-3.5 sm:px-6 sm:py-4 bg-slate-50 dark:bg-gray-800/90 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end shrink-0">
                    <button @click="closeModal"
                        class="w-full sm:w-auto px-5 py-2.5 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-full text-xs sm:text-sm font-semibold transition cursor-pointer text-center">
                        Close
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Alpine JS -->
    <script>
        function sessionHistory() {
            return {
                isModalOpen: false,
                loading: false,

                selectedSession: {
                    therapist: '',
                    media_type: '',
                    session_started_date: '',
                    duration: '',
                    recording: '',
                    therapist_notes: '',
                    session_note_resources: []
                },

                async openDetailsModal(calendarId, therapistName) {
                    this.isModalOpen = true;
                    this.loading = true;

                    this.selectedSession = {
                        therapist: therapistName,
                        media_type: '',
                        session_started_date: '',
                        duration: '',
                        recording: '',
                        therapist_notes: '',
                        session_note_resources: []
                    };

                    try {
                        const res = await fetch('/mod-10/01/usr-therapy-history', {
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

                        this.selectedSession.recording = d.recording ?? '';
                        this.selectedSession.therapist_notes = d.therapist_notes ?? '';
                        this.selectedSession.session_note_resources = Array.isArray(d.session_note_resources) ? d.session_note_resources : [];

                    } catch (e) {
                        console.error(e);
                        alert('Failed to load session details');
                    } finally {
                        this.loading = false;
                    }
                },

                closeModal() {
                    this.isModalOpen = false;
                }
            }
        }
    </script>
</x-app1>
