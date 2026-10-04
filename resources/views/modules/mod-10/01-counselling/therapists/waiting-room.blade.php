<!-- resources/views/modules/mod-10/01-counselling/therapists/waiting-room.blade.php -->
<x-app1>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        window.ZEGO_LOCK = false;
        window.ZEGO_INSTANCE = null;
    </script>

    <div x-data="waitingRoomApp()" class="max-w-7xl mx-auto space-y-6">

        <!-- Page Header -->
        <x-page-header />

        <!-- Status & Metrics Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 flex-wrap">
            <!-- Left: Info Badges -->
            <div class="flex items-center gap-2.5 flex-wrap">
                <!-- Timezone Badge -->
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20 shadow-2xs">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $therapistTimeZone }}</span>
                </span>

                <!-- Queue Count Badge -->
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1C9BA0] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1C9BA0]"></span>
                    </span>
                    <span>{{ $sessions->count() }} Upcoming Session{{ $sessions->count() === 1 ? '' : 's' }}</span>
                </span>

                <!-- Device Compatibility Status -->
                <template x-if="therapistScreenAllowed">
                    <span class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Workstation Verified (Video Ready)</span>
                    </span>
                </template>
            </div>

            <!-- Right: Quick Navigation -->
            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <a href="{{ route('therapist.calendar.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>My Calendar</span>
                </a>

                <button type="button" @click="window.location.reload()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                    title="Refresh Queue">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Refresh</span>
                </button>
            </div>
        </div>

        <!-- Alert: Session Notes Saved Notification -->
        <div x-show="notesStatusMessage" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="rounded-2xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50/90 dark:bg-emerald-950/50 p-4 shadow-sm flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-semibold text-emerald-900 dark:text-emerald-100" x-text="notesStatusMessage"></span>
            </div>
            <button type="button" @click="notesStatusMessage = ''" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Alert: Mobile Screen Block Warning -->
        <div x-show="!therapistScreenAllowed" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50/90 dark:bg-amber-950/50 p-4 shadow-sm flex items-start gap-3">
            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-bold text-amber-900 dark:text-amber-100">Workstation Notice</h4>
                <p class="text-xs text-amber-800 dark:text-amber-200 mt-0.5" x-text="therapistScreenMessage"></p>
            </div>
        </div>

        <!-- Main Waiting Room Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden"
             x-data="{ viewMode: 'cards' }">

            <!-- Card Header & View Switcher Toolbar -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Therapist Waiting Room</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Patients booked for live Video or Audio consultations in the next 14 days.</p>
                    </div>
                </div>

                @if($sessions->isNotEmpty())
                    <!-- View Mode Toggle (Cards vs Table) -->
                    <div class="inline-flex items-center bg-gray-100 dark:bg-gray-700/60 p-1 rounded-xl border border-gray-200/80 dark:border-gray-600/60 text-xs font-semibold self-start sm:self-auto">
                        <button type="button" @click="viewMode = 'cards'"
                                :class="viewMode === 'cards' ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>Cards</span>
                        </button>

                        <button type="button" @click="viewMode = 'table'"
                                :class="viewMode === 'table' ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <span>Table</span>
                        </button>
                    </div>
                @endif
            </div>

            @php
                $sessionMap = [
                    'Video' => [
                        'label' => 'Start Video Call',
                        'bg' => 'bg-emerald-600 hover:bg-emerald-700',
                        'gradient' => 'linear-gradient(135deg, #059669, #047857)',
                        'icon' => 'video'
                    ],
                    'Audio' => [
                        'label' => 'Start Audio Call',
                        'bg' => 'bg-indigo-600 hover:bg-indigo-700',
                        'gradient' => 'linear-gradient(135deg, #4f46e5, #4338ca)',
                        'icon' => 'phone'
                    ],
                    'Message' => [
                        'label' => 'Start Chatting',
                        'bg' => 'bg-sky-600 hover:bg-sky-700',
                        'gradient' => 'linear-gradient(135deg, #0284c7, #0369a1)',
                        'icon' => 'chat'
                    ],
                ];
            @endphp

            @if($sessions->isEmpty())
                <!-- Empty State -->
                <div class="py-16 px-4 text-center">
                    <div class="w-20 h-20 rounded-full bg-[#1C9BA0]/10 text-[#1C9BA0] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Waiting Room is Empty</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-md mx-auto">
                        There are currently no patients waiting or booked for video/audio sessions in your upcoming 14-day schedule.
                    </p>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <a href="{{ route('therapist.calendar.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Manage My Availability</span>
                        </a>
                    </div>
                </div>
            @else

                <!-- ================= 1. CARD VIEW (Default Responsive Grid) ================= -->
                <div x-show="viewMode === 'cards'" class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($sessions as $session)
                        @php
                            $patient = $session->patient;
                            $attr = $patient?->userAttributes;
                            $firstName = $attr?->FirstName ?? '';
                            $lastName = $attr?->LastName ?? '';
                            $clientFullName = trim($firstName . ' ' . $lastName) ?: ($patient?->UserName ?? 'Patient');
                            $clientShortName = $firstName ?: ($patient?->UserName ?? 'Patient');
                            $userPhoto = $attr?->UserPhoto 
                                ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto) 
                                : asset('images/avatar1.jfif');
                            $sessionDate = $session->DisplaySessionDateTimeFrom;
                            $isToday = $sessionDate->isToday();
                            $map = $sessionMap[$session->SessionType] ?? $sessionMap['Video'];
                        @endphp

                        <div class="bg-gray-50/70 dark:bg-gray-900/50 rounded-2xl p-5 border border-gray-200/80 dark:border-gray-700/80 hover:border-[#1C9BA0]/50 dark:hover:border-[#1C9BA0]/50 hover:shadow-md transition-all flex flex-col justify-between group">
                            
                            <!-- Card Top: Avatar & Meta -->
                            <div>
                                <div class="flex items-start justify-between gap-3 pb-3 border-b border-gray-200/70 dark:border-gray-700/70">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="relative shrink-0">
                                            <img src="{{ $userPhoto }}" alt="{{ $clientFullName }}"
                                                class="w-12 h-12 rounded-xl object-cover border border-gray-200 dark:border-gray-700 shadow-2xs group-hover:scale-105 transition-all">
                                            <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full border-2 border-white dark:border-gray-800 {{ $isToday ? 'bg-emerald-500' : 'bg-gray-400' }}"
                                                  title="{{ $isToday ? 'Session Today' : 'Scheduled' }}"></span>
                                        </div>

                                        <div class="min-w-0">
                                            <h3 class="font-bold text-sm sm:text-base text-gray-900 dark:text-gray-100 truncate">
                                                {{ $clientFullName }}
                                            </h3>
                                            <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="truncate">@<span>{{ $patient?->UserName ?? 'anonymous' }}</span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Media Type Pill -->
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold shrink-0 {{ $session->SessionType === 'Video' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200/60' }}">
                                        @if($session->SessionType === 'Video')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                            </svg>
                                        @endif
                                        <span>{{ $session->SessionType }}</span>
                                    </span>
                                </div>

                                <!-- Date & Time Box -->
                                <div class="mt-3.5 p-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/60 shadow-2xs space-y-1.5">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1.5 font-medium">
                                            <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $sessionDate->format('D, M d, Y') }}</span>
                                        </span>
                                        <span class="font-bold font-mono text-gray-900 dark:text-gray-100 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $sessionDate->format('H:i') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between pt-1 border-t border-gray-100 dark:border-gray-700/60 text-[11px]">
                                        <span class="text-gray-400">Queue Status</span>
                                        @if($isToday)
                                            <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Today's Session
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 font-medium">
                                                Scheduled in {{ $sessionDate->diffForHumans(['parts' => 1]) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Intake & Clinical Info Buttons -->
                                <div class="grid grid-cols-2 gap-2 mt-3">
                                    <button type="button"
                                        @click="openOnboardingAnswers('{{ $session->PatientUserID }}','{{ $session->patient->UserName }}')"
                                        class="px-2.5 py-1.5 rounded-xl bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 text-xs font-semibold flex items-center justify-center gap-1.5 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                                        <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span>Answers (Q&A)</span>
                                    </button>

                                    <button type="button"
                                        @click="openOnboardingIssue('{{ $session->PatientUserID }}','{{ $session->patient->UserName }}')"
                                        class="px-2.5 py-1.5 rounded-xl bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 text-xs font-semibold flex items-center justify-center gap-1.5 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                                        <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Active Issue</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Bottom: Primary Launch & Message Buttons -->
                            <div class="mt-4 pt-3 border-t border-gray-200/70 dark:border-gray-700/70 flex items-center gap-2">
                                <button type="button"
                                    @click="prepareSessionStart({
                                        clientName: @js($clientShortName),
                                        roomID: @js($session->SessionZegoCloudConnectID),
                                        sessionType: @js($session->SessionType),
                                        calendarID: {{ $session->ID }}
                                    })"
                                    class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                                    style="background: {{ $map['gradient'] }};">
                                    @if($session->SessionType === 'Video')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                        </svg>
                                    @endif
                                    <span>{{ $map['label'] }}</span>
                                </button>

                                <button type="button"
                                    @click="openMessageModal('{{ $clientShortName }}', '{{ $session->PatientUserID }}')"
                                    class="p-2.5 rounded-xl bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-300 hover:bg-sky-100 dark:hover:bg-sky-900/50 border border-sky-200 dark:border-sky-800 transition-all shadow-2xs hover:shadow-xs active:scale-95"
                                    title="Send Message to {{ $clientShortName }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- ================= 2. TABLE VIEW (Responsive Data Table) ================= -->
                <div x-show="viewMode === 'table'" class="overflow-hidden">
                    <!-- Mobile Horizontal Scroll Helper -->
                    <div class="sm:hidden px-4 py-2 bg-gray-50 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                        <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                            <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Swipe horizontally to view all columns</span>
                        </span>
                        <span class="font-semibold text-[#1C9BA0]">{{ $sessions->count() }} sessions</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[840px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">
                                    <th class="py-3.5 px-5 whitespace-nowrap">Patient / Client</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Date & Time</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Media</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Clinical Intake</th>
                                    <th class="py-3.5 px-5 text-right whitespace-nowrap">Session Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                                @foreach($sessions as $session)
                                    @php
                                        $patient = $session->patient;
                                        $attr = $patient?->userAttributes;
                                        $firstName = $attr?->FirstName ?? '';
                                        $lastName = $attr?->LastName ?? '';
                                        $clientFullName = trim($firstName . ' ' . $lastName) ?: ($patient?->UserName ?? 'Patient');
                                        $clientShortName = $firstName ?: ($patient?->UserName ?? 'Patient');
                                        $userPhoto = $attr?->UserPhoto 
                                            ? \Illuminate\Support\Facades\Storage::disk('public')->url($attr->UserPhoto) 
                                            : asset('images/avatar1.jfif');
                                        $sessionDate = $session->DisplaySessionDateTimeFrom;
                                        $isToday = $sessionDate->isToday();
                                        $map = $sessionMap[$session->SessionType] ?? $sessionMap['Video'];
                                    @endphp

                                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors">
                                        <!-- Patient Info -->
                                        <td class="py-4 px-5 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="relative shrink-0">
                                                    <img src="{{ $userPhoto }}" alt="{{ $clientFullName }}"
                                                        class="w-10 h-10 rounded-xl object-cover border border-gray-200 dark:border-gray-700 shadow-2xs">
                                                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-gray-800 {{ $isToday ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 dark:text-gray-100">
                                                        {{ $clientFullName }}
                                                    </div>
                                                    <div class="text-[11px] text-gray-400">
                                                        @<span>{{ $patient?->UserName ?? 'anonymous' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Date & Time -->
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $sessionDate->format('D, M d, Y') }}
                                            </div>
                                            <div class="text-[11px] font-mono text-[#1C9BA0] font-medium">
                                                {{ $sessionDate->format('H:i') }} ({{ $therapistTimeZone }})
                                            </div>
                                        </td>

                                        <!-- Media -->
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $session->SessionType === 'Video' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200/60' }}">
                                                @if($session->SessionType === 'Video')
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                                    </svg>
                                                @endif
                                                <span>{{ $session->SessionType }}</span>
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            @if($isToday)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    <span>Today</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                                    <span>Scheduled</span>
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Clinical Intake -->
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5">
                                                <button type="button"
                                                    @click="openOnboardingAnswers('{{ $session->PatientUserID }}','{{ $session->patient->UserName }}')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all shadow-2xs active:scale-95"
                                                    title="View Intake Answers">
                                                    <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                    <span>Answers</span>
                                                </button>

                                                <button type="button"
                                                    @click="openOnboardingIssue('{{ $session->PatientUserID }}','{{ $session->patient->UserName }}')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all shadow-2xs active:scale-95"
                                                    title="View Active Issue Summary">
                                                    <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Issue</span>
                                                </button>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="py-4 px-5 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-2">
                                                <button type="button"
                                                    @click="prepareSessionStart({
                                                        clientName: @js($clientShortName),
                                                        roomID: @js($session->SessionZegoCloudConnectID),
                                                        sessionType: @js($session->SessionType),
                                                        calendarID: {{ $session->ID }}
                                                    })"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-white transition-all shadow-xs hover:shadow-md hover:brightness-105 active:scale-95"
                                                    style="background: {{ $map['gradient'] }};">
                                                    @if($session->SessionType === 'Video')
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                                        </svg>
                                                    @endif
                                                    <span>{{ $map['label'] }}</span>
                                                </button>

                                                <button type="button"
                                                    @click="openMessageModal('{{ $clientShortName }}', '{{ $session->PatientUserID }}')"
                                                    class="p-2 rounded-xl bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-300 hover:bg-sky-100 dark:hover:bg-sky-900/50 border border-sky-200 dark:border-sky-800 transition-all shadow-2xs hover:shadow-xs active:scale-95"
                                                    title="Message Client">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif

        </div>

        {{-- ===================== 1. START SESSION MODAL ===================== --}}
        <div x-show="showSession" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-lg shadow-2xl border border-gray-100 dark:border-gray-700"
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                                Launch Session with <span class="text-[#1C9BA0]" x-text="currentClient"></span>
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Ready to enter your encrypted live counseling room.</p>
                        </div>
                    </div>

                    <button type="button" @click="showSession = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Info Cards -->
                <div class="space-y-3 mb-6">
                    <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-2.5 text-xs text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>End-to-End Encrypted Cloud Connection</span>
                        </div>
                        <span class="text-[11px] font-mono font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">Active</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs">
                        <span class="text-gray-500 dark:text-gray-400">Selected Medium</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wide" x-text="sessionType"></span>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-gray-100 dark:border-gray-700/80">
                    <button type="button" @click="endSession()"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/50 border border-rose-200 dark:border-rose-800/60 transition-all active:scale-95">
                        Cancel / End
                    </button>

                    <button type="button" @click="startSession(currentCalendarID)"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #059669, #047857);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Start Live Session</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== 2. MESSAGE PATIENT MODAL ===================== --}}
        <div x-show="showMessageModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700"
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-950/40 text-sky-600 dark:text-sky-300 border border-sky-200 dark:border-sky-800 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                                Message <span class="text-[#1C9BA0]" x-text="messageClient"></span>
                            </h3>
                            <p class="text-xs text-gray-400">Direct message notification sent to patient.</p>
                        </div>
                    </div>

                    <button type="button" @click="showMessageModal = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Textarea -->
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Message Content
                    </label>
                    <textarea x-model="messageText" rows="4"
                        placeholder="e.g. Hello, I am ready in the waiting room whenever you are prepared to join..."
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 p-3.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all"></textarea>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-2.5">
                    <button type="button" @click="showMessageModal = false"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Cancel
                    </button>

                    <button type="button" @click="sendMessage()"
                        class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Send Message</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== 3. POST-SESSION NOTES MODAL ===================== --}}
        <div x-show="showNotesModal" x-cloak
            class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-5 bg-gray-900/70 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl w-full max-w-5xl h-[88vh] shadow-2xl border border-gray-100 dark:border-gray-700 flex flex-col overflow-hidden"
                @click.stop>
                <!-- Modal Topbar -->
                <div class="flex items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-900/40">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Post-Session Clinical Notes</h3>
                            <p class="text-xs text-gray-400">Complete clinical summary and attach up to 4 collateral resources.</p>
                        </div>
                    </div>

                    <button type="button" @click="closeNotesModal()"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Iframe Container -->
                <div class="flex-1 bg-gray-100 dark:bg-gray-900 min-h-0">
                    <template x-if="notesModalUrl">
                        <iframe data-notes-iframe :src="notesModalUrl" class="w-full h-full min-h-[50vh] border-0"
                            title="Post Session Notes"></iframe>
                    </template>
                </div>
            </div>
        </div>

        {{-- ===================== 4. ONBOARDING ANSWERS (Q1-Q39) MODAL ===================== --}}
        <div x-show="showOnboardingAnswersModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-3xl max-h-[85vh] shadow-2xl border border-gray-100 dark:border-gray-700 flex flex-col overflow-hidden"
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-4 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#1C9BA0]/10 text-[#1C9BA0] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                                Client Onboarding Assessment
                            </h3>
                            <p class="text-xs text-gray-400">Questions 1–39 completed by client <span class="font-semibold text-gray-700 dark:text-gray-200" x-text="onboardingPatientLabel"></span></p>
                        </div>
                    </div>

                    <button type="button" @click="showOnboardingAnswersModal = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content Area -->
                <div class="flex-1 overflow-y-auto pr-1">
                    <!-- Loading state -->
                    <div x-show="onboardingLoading" class="py-12 text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-2 border-[#1C9BA0] border-t-transparent mb-2"></div>
                        <p class="text-xs text-gray-400">Loading questionnaire records...</p>
                    </div>

                    <!-- Q&A List -->
                    <div x-show="!onboardingLoading" class="space-y-3">
                        <template x-for="(row, idx) in onboardingQa" :key="row.id || idx">
                            <div class="p-3.5 rounded-2xl bg-gray-50/80 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-lg bg-[#1C9BA0]/10 text-[#1C9BA0] text-xs font-bold flex items-center justify-center shrink-0 mt-0.5"
                                          x-text="idx + 1"></span>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="row.question"></div>
                                        <div class="mt-1 text-xs text-[#1C9BA0] font-medium bg-[#1C9BA0]/5 dark:bg-[#1C9BA0]/10 px-3 py-1.5 rounded-xl border border-[#1C9BA0]/15 inline-block"
                                             x-text="row.answer || '—'"></div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="onboardingQa.length === 0" class="py-8 text-center text-xs text-gray-400">
                            No answers recorded for this patient.
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700/80 flex justify-end shrink-0">
                    <button type="button" @click="showOnboardingAnswersModal = false"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== 5. ONBOARDING ACTIVE ISSUE (Q40) MODAL ===================== --}}
        <div x-show="showOnboardingIssueModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-2xl max-h-[80vh] shadow-2xl border border-gray-100 dark:border-gray-700 flex flex-col overflow-hidden"
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-4 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                                Client Active Issue Statement
                            </h3>
                            <p class="text-xs text-gray-400">Statement provided by <span class="font-semibold text-gray-700 dark:text-gray-200" x-text="onboardingPatientLabel"></span></p>
                        </div>
                    </div>

                    <button type="button" @click="showOnboardingIssueModal = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content Area -->
                <div class="flex-1 overflow-y-auto pr-1">
                    <div x-show="onboardingLoading" class="py-12 text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-2 border-[#1C9BA0] border-t-transparent mb-2"></div>
                        <p class="text-xs text-gray-400">Loading statement...</p>
                    </div>

                    <div x-show="!onboardingLoading" class="p-4 rounded-2xl bg-gray-50/80 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700/60 text-xs sm:text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-wrap font-sans"
                         x-text="onboardingIssue || 'No active issue description submitted by this user.'">
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700/80 flex justify-end shrink-0">
                    <button type="button" @click="showOnboardingIssueModal = false"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== 6. 5-MINUTE SESSION REMINDER POPUP ===================== --}}
        <div x-show="showSessionReminderPopup" x-cloak
            class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700"
                @click.stop>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Session Reminder</h3>
                        <p class="text-xs text-gray-400">Scheduled time closing soon.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-xs sm:text-sm text-amber-900 dark:text-amber-100">
                    This session is scheduled to conclude in approximately <strong>5 minutes</strong>. Please prepare to wrap up consultations and save clinical notes.
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="button" @click="showSessionReminderPopup = false"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        Understood
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== 7. PHONE BLOCKED WARNING MODAL ===================== --}}
        <div x-show="showPhoneBlockedModal" x-cloak
            class="fixed inset-0 z-[90] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700"
                @click.stop>
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Workstation Required</h3>
                            <p class="text-xs text-gray-400">Mobile phone launcher disabled.</p>
                        </div>
                    </div>

                    <button type="button" @click="showPhoneBlockedModal = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700 text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    To maintain clinical standards and video quality, live therapy sessions must be conducted from a <strong>Tablet, Laptop, or Desktop computer</strong>. Please switch devices to start this consultation.
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="button" @click="showPhoneBlockedModal = false"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        OK, Got it
                    </button>
                </div>
            </div>
        </div>

        <!-- Video Call Viewport Container -->
        <div id="videoContainer" class="w-full h-[70vh] rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-xl bg-gray-950 empty:hidden"></div>

    </div>

    {{-- ZEGOCLOUD Video Session Engine --}}
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt@2.15.0/zego-uikit-prebuilt.js"></script>
    <x-zego-virtual-background />

    <script>
        window.waitingRoomApp = function() {
            return {
                init() {
                    this.updateScreenSize();
                    this._onResize = () => this.updateScreenSize();
                    window.addEventListener('resize', this._onResize);
                    this._onNotesWindowMessage = (event) => this.handleNotesWindowMessage(event);
                    window.addEventListener('message', this._onNotesWindowMessage);
                },

                destroy() {
                    if (this._onResize) {
                        window.removeEventListener('resize', this._onResize);
                    }
                    if (this._onNotesWindowMessage) {
                        window.removeEventListener('message', this._onNotesWindowMessage);
                    }
                },

                /**
                 * Only accept postMessages that actually come from our notes iframe (not Vite, Ignition, Zego, extensions).
                 * Do not auto-close the modal on "saved" — user closes via × or the iframe Close button to avoid phantom closes.
                 */
                handleNotesWindowMessage(event) {
                    if (event.origin !== window.location.origin || !event.data || typeof event.data.type !== 'string') {
                        return;
                    }
                    if (event.data.source !== 'justmy-session-notes-embed') {
                        return;
                    }

                    const iframe = this.$el?.querySelector?.('iframe[data-notes-iframe]');
                    if (!iframe || event.source !== iframe.contentWindow) {
                        return;
                    }

                    if (event.data.type === 'session-notes-close' && event.data.manual) {
                        this.closeNotesModal();
                        return;
                    }

                    if (event.data.type === 'session-notes-saved') {
                        if (!this.showNotesModal) return;
                        this.notesStatusMessage = event.data.message || 'Session notes saved.';
                    }
                },
                showSession: false,
                showMessageModal: false,
                currentClient: null,
                messageClient: null,
                currentCalendarID: null,
                messageText: '',
                timer: 0,
                recording: false,
                roomID: null,
                isProcessing: false,
                sessionEndHandled: false,
                sessionStartedManually: false,
                sessionType: 'Video',
                showNotesModal: false,
                notesModalUrl: null,
                notesStatusMessage: '',
                showOnboardingAnswersModal: false,
                showOnboardingIssueModal: false,
                onboardingLoading: false,
                onboardingPatientLabel: '',
                onboardingQa: [],
                onboardingIssue: '',
                sessionReminderTimer: null,
                showSessionReminderPopup: false,
                minimumSessionWidth: 768,
                screenWidth: 0,
                screenHeight: 0,
                physicalScreenWidth: 0,
                physicalScreenHeight: 0,
                isPhoneDevice: false,
                showPhoneBlockedModal: false,

                get therapistScreenAllowed() {
                    return !this.isPhoneDevice && this.physicalScreenWidth >= this.minimumSessionWidth;
                },

                get therapistScreenMessage() {
                    return `Therapists can only start sessions from a tablet, laptop, or desktop. ` +
                        `Phone devices are not permitted even in desktop view mode. ` +
                        `Your device screen width is ${this.physicalScreenWidth}px.`;
                },

                updateScreenSize() {
                    this.screenWidth = window.innerWidth || 0;
                    this.screenHeight = window.innerHeight || 0;
                    this.physicalScreenWidth = window.screen?.width || 0;
                    this.physicalScreenHeight = window.screen?.height || 0;

                    const ua = navigator.userAgent || '';
                    this.isPhoneDevice =
                        /iPhone|iPod/.test(ua) ||
                        (/Android/.test(ua) && /Mobile/.test(ua)) ||
                        /Windows Phone/.test(ua);
                },

                prepareSessionStart(session) {
                    this.updateScreenSize();

                    if (!this.therapistScreenAllowed) {
                        this.showPhoneBlockedModal = true;
                        return;
                    }

                    this.currentClient = session.clientName;
                    this.roomID = session.roomID;
                    this.sessionType = session.sessionType;
                    this.currentCalendarID = session.calendarID;
                    this.markTherapistEntered();
                    this.showSession = true;
                },

                async markTherapistEntered() {
                    if (!this.currentCalendarID) return;
                    await fetch('/therapist/session/entered-waiting-room', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            calendar_id: this.currentCalendarID
                        })
                    });
                },

                async startSession(calendarID) {
                    this.updateScreenSize();

                    if (!this.therapistScreenAllowed) {
                        this.showPhoneBlockedModal = true;
                        return;
                    }

                    try {
                        const res = await fetch('/therapist/session/start', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                calendar_id: calendarID,
                                screen_width: this.screenWidth,
                                physical_screen_width: this.physicalScreenWidth,
                                is_phone_device: this.isPhoneDevice,
                                device_platform: navigator.userAgentData?.platform || navigator.platform || null
                            })
                        });

                        if (!res.ok) {
                            let errorMessage = 'Session start failed - check console';

                            try {
                                const json = await res.json();
                                errorMessage = json.message || errorMessage;
                                console.error('START SESSION FAILED:', json);
                            } catch (jsonError) {
                                const text = await res.text();
                                console.error('START SESSION FAILED:', text);
                            }

                            alert(errorMessage);
                            return;
                        }

                        const data = await res.json();
                        console.log('SESSION START RESPONSE:', data);

                        this.sessionEndHandled = false;
                        this.currentCalendarID = calendarID;
                        this.roomID = data.roomID;
                        this.sessionType = data.sessionType;

                        // Call Zego SDK
                        this.joinVideoCall();

                    } catch (e) {
                        console.error('START SESSION ERROR:', e);
                        alert('JS error — check console');
                    }
                },

                async joinVideoCall() {
                    if (window.ZEGO_LOCK) return;
                    window.ZEGO_LOCK = true;
                    this.showSession = false;

                    try {
                        const res = await fetch(`/video/token?roomID=${this.roomID}`);
                        const data = await res.json();

                        const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                            Number(data.appID),
                            data.serverSecret,
                            this.roomID,
                            data.userID.toString(),
                            data.userName
                        );

                        const container = document.getElementById("videoContainer");
                        const backgroundProcessConfig = await window.loadJmhZegoBackgroundConfig();
                        window.ZEGO_INSTANCE = ZegoUIKitPrebuilt.create(kitToken, backgroundProcessConfig);

                        window.ZEGO_INSTANCE.joinRoom({
                            container,
                            scenario: {
                                mode: ZegoUIKitPrebuilt.GroupCall
                            },
                            showPreJoinView: false,
                            turnOnCameraWhenJoining: this.sessionType !== 'Audio',
                            turnOnMicrophoneWhenJoining: true,
                            showTextChat: true,
                            showUserList: true,
                            showBackgroundProcessButton: true,
                            maxUsers: 2,

                            onLocalStreamCreated: () => {
                                window.ZEGO_INSTANCE?.openBackgroundProcess?.();
                            },

                            onJoinRoom: () => {
                                console.log('Successfully joined room...');
                                this.sessionStartedManually = true;
                                this.startSessionReminderTimer();
                            },

                            onLeaveRoom: async (reason) => {
                                console.log('Leave reason:', reason);
                                console.log('Therapist left room → ending session');
                                console.log('ON LEAVE ROOM TRIGGERED');
                                console.log('SESSION END HANDLED:', this.sessionEndHandled);

                                if (!this.sessionStartedManually) {
                                    console.log('Auto leave detected — ignoring');
                                    window.ZEGO_LOCK = false;
                                    return;
                                }

                                if (!this.currentCalendarID || this.sessionEndHandled) {
                                    window.ZEGO_LOCK = false;
                                    return;
                                }

                                if (this.sessionReminderTimer) {
                                    clearTimeout(this.sessionReminderTimer);
                                    this.sessionReminderTimer = null;
                                }

                                this.sessionEndHandled = true;

                                if (window.ZEGO_INSTANCE) {
                                    window.ZEGO_INSTANCE = null;
                                }

                                const res = await fetch('/therapist/session/end', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        calendar_id: this.currentCalendarID
                                    })
                                });

                                if (res.ok) {
                                    const data = await res.json();
                                    if (!this.showNotesModal) {
                                        this.openNotesModal(data.embedded_notes_url || data.notes_url);
                                    }
                                }

                                window.ZEGO_LOCK = false;
                                this.showSession = false;
                            }
                        });

                    } catch (e) {
                        console.error(e);
                        alert('Failed to join session');
                        window.ZEGO_LOCK = false;
                    }
                },

                startSessionReminderTimer() {
                    if (this.sessionReminderTimer) {
                        clearTimeout(this.sessionReminderTimer);
                    }

                    // 45 minutes for testing (2700000 ms)
                    this.sessionReminderTimer = setTimeout(() => {
                        this.showSessionReminderPopup = true;
                    }, 2700000);
                },

                async endSession() {
                    console.log('END SESSION CLICKED');
                    if (!this.currentCalendarID || this.sessionEndHandled) return;

                    this.sessionEndHandled = true;

                    if (this.sessionReminderTimer) {
                        clearTimeout(this.sessionReminderTimer);
                        this.sessionReminderTimer = null;
                    }

                    if (window.ZEGO_INSTANCE) {
                        window.ZEGO_INSTANCE.leaveRoom();
                        window.ZEGO_INSTANCE.destroy();
                        window.ZEGO_INSTANCE = null;
                    }

                    const res = await fetch('/therapist/session/end', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            calendar_id: this.currentCalendarID
                        })
                    });

                    this.showSession = false;

                    if (res.ok) {
                        const data = await res.json();
                        if (!this.showNotesModal) {
                            this.openNotesModal(data.embedded_notes_url || data.notes_url);
                        }
                    }

                    window.ZEGO_LOCK = false;
                },

                openNotesModal(notesUrl) {
                    if (!notesUrl || this.showNotesModal) return;
                    this.notesModalUrl = `${notesUrl}${notesUrl.includes('?') ? '&' : '?'}modal_ts=${Date.now()}`;
                    this.showNotesModal = true;
                },

                closeNotesModal() {
                    this.showNotesModal = false;
                    this.notesModalUrl = null;
                },

                openMessageModal(clientName, patientID) {
                    this.messageClient = clientName;
                    this.currentPatientID = patientID;
                    this.messageText = '';
                    this.showMessageModal = true;
                },

                async sendMessage() {
                    if (!this.messageText.trim()) return;
                    const res = await fetch('/chat/store-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            to_user_id: this.currentPatientID,
                            to_user_type: 1,
                            message: this.messageText
                        })
                    });
                    this.showMessageModal = false;
                    this.messageText = '';
                },

                async openOnboardingAnswers(patientId, patientUserName) {
                    this.onboardingPatientLabel = patientUserName ? `(${patientUserName})` : '';
                    this.showOnboardingAnswersModal = true;
                    this.showOnboardingIssueModal = false;
                    this.onboardingLoading = true;
                    this.onboardingQa = [];

                    try {
                        const res = await fetch("{{ route('therapist.onboarding.qa') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                patient_id: Number(patientId)
                            })
                        });

                        const json = await res.json();
                        this.onboardingQa = json.data || [];
                    } catch (e) {
                        console.error(e);
                        alert('Failed to load onboarding answers');
                    } finally {
                        this.onboardingLoading = false;
                    }
                },

                async openOnboardingIssue(patientId, patientUserName) {
                    this.onboardingPatientLabel = patientUserName ? `(${patientUserName})` : '';
                    this.showOnboardingIssueModal = true;
                    this.showOnboardingAnswersModal = false;
                    this.onboardingLoading = true;
                    this.onboardingIssue = '';

                    try {
                        const res = await fetch("{{ route('therapist.onboarding.issue') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                patient_id: Number(patientId)
                            })
                        });

                        const json = await res.json();
                        this.onboardingIssue = json?.data?.issue_summary || '';
                    } catch (e) {
                        console.error(e);
                        alert('Failed to load issue summary');
                    } finally {
                        this.onboardingLoading = false;
                    }
                }
            }
        }
    </script>
</x-app1>
