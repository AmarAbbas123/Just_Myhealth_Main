{{-- resources/views/dashboard.blade.php --}}

<x-app1>
    <div class="space-y-6">
        @php
            $userType = (int) Auth::user()->UserType;
            $isTherapist = in_array($userType, [30, 31, 32]);
            $userAvatar = Auth::user()->ProfilePhotoPath ? asset('storage/' . Auth::user()->ProfilePhotoPath) : asset('images/avatar1.jfif');
            $therapistWaitingSessions = collect($therapistWaitingSessions ?? []);
            $therapistChats = collect($therapistChats ?? []);
            $patientUpcomingSessions = collect($patientUpcomingSessions ?? []);
            $patientChats = collect($patientChats ?? []);
            $showPatientOnboardingJourney = (bool) ($showPatientOnboardingJourney ?? false);

            // Dynamic label based on user type
            $userTypeLabel = match(true) {
                in_array($userType, [90, 91, 99]) => 'Administrator',
                in_array($userType, [30, 31, 32]) => 'Therapist',
                $userType === 10               => 'Business',
                in_array($userType, [1, 2, 3])  => 'User',
                default                        => 'User',
            };
        @endphp

        {{-- ── Dashboard Header ──────────────────────────────────────────── --}}
        <div class="mt-4 bg-white rounded-2xl border border-gray-200 shadow-sm px-6 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between dark:bg-gray-800 dark:border-gray-700">

            {{-- Left: Title & subtitle --}}
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl shrink-0" style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                        {{ $userTypeLabel }} Home Dashboard
                    </h2>
                    <p class="mt-0.5 text-sm text-gray-400 dark:text-gray-400">
                        Welcome to the {{ $userTypeLabel }} Home Dashboard area.
                    </p>
                </div>
            </div>

            {{-- Right: Welcome badge --}}
            <div class="flex items-center shrink-0 self-start sm:self-center bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-1.5 shadow-sm">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Welcome back, {{ Auth::user()->UserName ?? 'User' }}
                </span>
            </div>
        </div>


        @if($isTherapist)
            {{-- Quick Access Links heading --}}
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <h3 class="text-base font-bold text-gray-800 dark:text-gray-100 tracking-tight">Quick Access Links</h3>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                {{-- Card 1: Waiting Room --}}
                <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    <div class="flex items-center gap-3 p-5 pb-4">
                        <div class="p-2.5 rounded-xl bg-blue-50 dark:bg-blue-900/20 shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a2 2 0 00-2-2h-3m-4 4H7v-2a2 2 0 00-2-2H2m15-3a3 3 0 11-6 0 3 3 0 016 0zm2 3a4 4 0 00-8 0v2h8v-2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Waiting Room</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-0.5 truncate">See live patients waiting.</p>
                        </div>
                    </div>
                    <div class="mt-auto px-5 pb-5">
                        <a href="/mod-10/my-waiting-room"
                           class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-sm font-semibold text-white transition-all duration-150"
                           style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                           onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Go Now
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Card 2: Calendar --}}
                <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    <div class="flex items-center gap-3 p-5 pb-4">
                        <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 shrink-0">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Calendar</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-0.5 truncate">Manage your appointments.</p>
                        </div>
                    </div>
                    <div class="mt-auto px-5 pb-5">
                        <a href="{{ route('therapist.calendar.index') }}"
                           class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-sm font-semibold text-white transition-all duration-150"
                           style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                           onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Go Now
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Card 3: Session History --}}
                <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-400 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    <div class="flex items-center gap-3 p-5 pb-4">
                        <div class="p-2.5 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 shrink-0">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Session History</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-0.5 truncate">Review completed sessions.</p>
                        </div>
                    </div>
                    <div class="mt-auto px-5 pb-5">
                        <a href="{{ route('therap.session.history') }}"
                           class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-sm font-semibold text-white transition-all duration-150"
                           style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                           onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Go Now
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

            </div>


            <div class="grid gap-6 lg:grid-cols-[40%_60%]" x-data='therapistDashboardMessages(@json($therapistChats->values()))' x-init="init()" x-on:beforeunload.window="destroy()">
                <section class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Waiting Room</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Active patients currently waiting to begin their sessions.</p>
                        </div>
                    </div>
                    <div class="mt-6 rounded-3xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 overflow-hidden">
                        <div class="hidden gap-4 border-b border-gray-200 bg-white px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 sm:grid sm:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)_minmax(140px,auto)]">
                            <span>Session</span>
                            <span>Patient</span>
                            <span class="text-right">Date/Time</span>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($therapistWaitingSessions as $session)
                                <div class="grid grid-cols-1 gap-4 px-4 py-4 text-sm text-gray-700 dark:text-gray-200 sm:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)_minmax(140px,auto)] sm:items-center">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $session['avatar'] }}" alt="{{ $session['person_name'] }}" class="h-10 w-10 flex-shrink-0 rounded-full object-cover">
                                        <div class="min-w-0">
                                            <p class="font-semibold truncate">{{ $session['title'] }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session['subtitle'] }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 sm:hidden">Patient</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session['person_name'] }}</p>
                                    </div>
                                    <div class="space-y-1 sm:text-right">
                                        <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 sm:hidden">Date/Time</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session['date_time'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-sm text-gray-500 dark:text-gray-400">
                                    No active waiting-room sessions right now.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Messages</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Recent client conversations from your dashboard.</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-4 lg:grid-cols-[35%_65%]">
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-y-auto max-h-[70vh] sm:max-h-[60vh] p-4">
                            <div class="mb-4">
                                <input x-model="searchQuery" type="text" placeholder="Search patient name..."
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500" />
                            </div>
                            <template x-for="patient in filteredItems" :key="patient.id">
                                <button @click="setActiveChat(patient)" type="button"
                                    class="flex w-full items-start gap-3 rounded-3xl p-3 text-left transition hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-400 dark:focus:ring-purple-700"
                                    :class="activeChat?.id === patient.id ? 'bg-purple-50 dark:bg-purple-800/20' : ''">
                                    <img :src="patient.avatar" alt="" class="h-10 w-10 rounded-full object-cover">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="font-semibold text-sm text-gray-900 dark:text-gray-100 truncate" x-text="patient.name"></p>
                                            <p class="text-[10px] sm:text-xs text-gray-400" x-text="formatDateTimeLabel(patient)"></p>
                                        </div>
                                        <p class="mt-1 text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 truncate" x-text="truncateText(patient.lastMessage)"></p>
                                        <p class="mt-1 text-[10px] text-gray-400 truncate" x-text="patient.dateTime"></p>
                                    </div>
                                </button>
                            </template>
                            <template x-if="filteredItems.length === 0">
                                <p class="text-center text-gray-500 text-sm mt-3">No messages found.</p>
                            </template>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm flex flex-col h-[70vh] sm:h-[60vh]">
                            <template x-if="activeChat">
                                <div class="flex flex-col h-full">
                                    <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center gap-3">
                                        <img :src="activeChat.avatar" alt="" class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100" x-text="activeChat.name"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatDateTimeLabel(activeChat)"></p>
                                        </div>
                                    </div>
                                    <div class="flex-1 overflow-y-auto p-4 space-y-4" x-ref="chatWindow" @scroll="trackScroll()">
                                        <template x-for="msg in activeChat.messages" :key="msg.id">
                                            <div>
                                                <div x-show="msg.sender === 'patient'" class="flex items-start gap-3">
                                                    <img :src="activeChat.avatar" alt="" class="w-8 h-8 rounded-full object-cover">
                                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
                                                        <p class="text-sm text-gray-800 dark:text-gray-100" x-html="formatMessage(msg.text)"></p>
                                                        <p class="text-xs text-gray-400 mt-1" x-text="formatDateTimeLabel(msg)"></p>
                                                    </div>
                                                </div>
                                                <div x-show="msg.sender === 'therapist'" class="flex justify-end">
                                                    <div class="bg-green-600 text-white rounded-lg shadow p-3 max-w-xs">
                                                        <p class="text-sm" x-html="formatMessage(msg.text)"></p>
                                                        <p class="text-xs text-green-100 mt-1 text-right" x-text="formatDateTimeLabel(msg)"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <form @submit.prevent="sendMessage()" class="flex flex-wrap items-center gap-2 p-3 border-t border-gray-100 dark:border-gray-700">
                                        <input x-model="newMessage" placeholder="Type a message..." class="flex-1 rounded-md border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500" />
                                        <button class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">📩 Send</button>
                                    </form>
                                </div>
                            </template>
                            <template x-if="!activeChat">
                                <div class="flex items-center justify-center flex-1 text-gray-500 text-sm">
                                    Select a conversation to preview.
                                </div>
                            </template>
                        </div>
                    </div>
                </section>
            </div>
        @else
            <div class="space-y-6">
                @if($showPatientOnboardingJourney)
                    <section class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="grid gap-4 lg:grid-cols-[56%_44%] lg:items-start">
                            <div class="overflow-hidden rounded-lg border-2 border-[#8fd2cb]">
                                <img
                                    src="{{ asset('images/welcome-page/therapyjourney.png') }}"
                                    alt="Therapy onboarding journey infographic"
                                    class="h-auto w-full object-cover">
                            </div>
                            <div class="px-1">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Therapy On-Boarding Journey:</h3>
                                <p class="mt-2 text-base leading-6 text-gray-800 dark:text-gray-200">
                                    The JustMy.Health platform has been designed with your health and wellbeing at the center of our services and solutions:
                                </p>
                                <ul class="mt-3 list-disc space-y-1 pl-6 text-base leading-6 text-gray-900 dark:text-gray-200">
                                    <li>Step 1: Create Account (Completed)</li>
                                    <li>Step 2: Purchase a block of Sessions</li>
                                    <li>Step 3: Complete your profile questions</li>
                                    <li>Step 4: Describe your current issue</li>
                                    <li>Step 5: We suggest suitable therapists</li>
                                    <li>Step 6: You select your therapists</li>
                                    <li>Step 7: You book your 1<sup>st</sup> session</li>
                                    <li>Step 8: Start the wellbeing journey</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                @endif

                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <h3 class="text-base font-bold text-gray-800 dark:text-gray-100 tracking-tight">Quick Access Links</h3>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                        {{-- Card 1: Session Calendar --}}
                        <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            <div class="flex items-center gap-3 p-5 pb-4">
                                <div class="p-2.5 rounded-xl bg-blue-50 dark:bg-blue-900/20 shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Session Calendar</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-400 mt-0.5 truncate">View your upcoming sessions.</p>
                                </div>
                            </div>
                            <div class="mt-auto px-5 pb-5">
                                <a href="/mod-10/01/usr-therapy-calendar"
                                   class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-sm font-semibold text-white transition-all duration-150"
                                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                   onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    Go Now
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Card 2: Purchase Sessions --}}
                        <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            <div class="flex items-center gap-3 p-5 pb-4">
                                <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v2H6v6h12v-6h-3v-2c0-1.105-1.343-2-3-2z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Purchase Sessions</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-400 mt-0.5 truncate">Top up your available session credits.</p>
                                </div>
                            </div>
                            <div class="mt-auto px-5 pb-5">
                                <a href="/mod-10/01/usr-finances"
                                   class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-sm font-semibold text-white transition-all duration-150"
                                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                   onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    Go Now
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Card 3: Session History --}}
                        <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-pink-400 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            <div class="flex items-center gap-3 p-5 pb-4">
                                <div class="p-2.5 rounded-xl bg-pink-50 dark:bg-pink-900/20 shrink-0">
                                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Session History</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-400 mt-0.5 truncate">Review past therapy sessions.</p>
                                </div>
                            </div>
                            <div class="mt-auto px-5 pb-5">
                                <a href="/mod-10/01/usr-therapy-history"
                                   class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-sm font-semibold text-white transition-all duration-150"
                                   style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                   onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    Go Now
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-[40%_60%]" x-data='userDashboardMessages(@json($patientChats->values()))' x-init="init()" x-on:beforeunload.window="destroy()">
                    <section class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Session Calendar</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">A quick look at your next sessions.</p>
                            </div>
                        </div>
                        <div class="mt-6 overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <div class="hidden gap-4 border-b border-gray-200 bg-white px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 sm:grid sm:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)_minmax(140px,auto)]">
                                <span>Session</span>
                                <span>Therapist</span>
                                <span class="text-right">Date/Time</span>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($patientUpcomingSessions as $session)
                                    <div class="grid grid-cols-1 gap-4 px-4 py-4 text-sm text-gray-700 dark:text-gray-200 sm:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)_minmax(140px,auto)] sm:items-center">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $session['avatar'] }}" alt="{{ $session['person_name'] }}" class="h-10 w-10 flex-shrink-0 rounded-full object-cover">
                                            <div class="min-w-0">
                                                <p class="font-semibold truncate">{{ $session['title'] }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session['subtitle'] }}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 sm:hidden">Therapist</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session['person_name'] }}</p>
                                        </div>
                                        <div class="space-y-1 sm:text-right">
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 sm:hidden">Date/Time</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session['date_time'] }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-sm text-gray-500 dark:text-gray-400">
                                        No upcoming sessions booked yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    <section class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Messages </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Recent conversations from your care team.</p>
                            </div>
                           
                        </div>
                        <div class="mt-6 grid gap-4 lg:grid-cols-[35%_65%]">
                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-y-auto max-h-[70vh] sm:max-h-[60vh] p-4">
                                <div class="mb-4">
                                    <input x-model="searchQuery" type="text" placeholder="Search therapist name..."
                                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500" />
                                </div>
                                <template x-for="chat in filteredItems" :key="chat.id">
                                    <button @click="setActiveChat(chat)" type="button"
                                        class="flex w-full items-start gap-3 rounded-3xl p-3 text-left transition hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-400 dark:focus:ring-purple-700"
                                        :class="activeChat?.id === chat.id ? 'bg-purple-50 dark:bg-purple-800/20' : ''">
                                        <img :src="chat.avatar" alt="" class="h-10 w-10 rounded-full object-cover">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="font-semibold text-sm text-gray-900 dark:text-gray-100 truncate" x-text="chat.name"></p>
                                                <p class="text-[10px] sm:text-xs text-gray-400" x-text="formatDateTimeLabel(chat)"></p>
                                            </div>
                                            <p class="mt-1 text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 truncate" x-text="truncateText(chat.lastMessage)"></p>
                                            <p class="mt-1 text-[10px] text-gray-400 truncate" x-text="chat.dateTime"></p>
                                        </div>
                                    </button>
                                </template>
                                <template x-if="filteredItems.length === 0">
                                    <p class="text-center text-gray-500 text-sm mt-3">No messages found.</p>
                                </template>
                            </div>
                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm flex flex-col h-[70vh] sm:h-[60vh]">
                                <template x-if="activeChat">
                                    <div class="flex flex-col h-full">
                                        <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center gap-3">
                                            <img :src="activeChat.avatar" alt="" class="w-10 h-10 rounded-full object-cover">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-gray-100" x-text="activeChat.name"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatDateTimeLabel(activeChat)"></p>
                                            </div>
                                        </div>
                                        <div class="flex-1 overflow-y-auto p-4 space-y-4" x-ref="chatWindow" @scroll="trackScroll()">
                                            <template x-for="msg in activeChat.messages" :key="msg.id">
                                                <div>
                                                    <div x-show="msg.sender === 'therapist'" class="flex items-start gap-3">
                                                        <img :src="activeChat.avatar" alt="" class="w-8 h-8 rounded-full object-cover">
                                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
                                                            <p class="text-sm text-gray-800 dark:text-gray-100" x-html="formatMessage(msg.text)"></p>
                                                            <p class="text-xs text-gray-400 mt-1" x-text="formatDateTimeLabel(msg)"></p>
                                                        </div>
                                                    </div>
                                                    <div x-show="msg.sender === 'patient'" class="flex justify-end">
                                                        <div class="bg-green-600 text-white rounded-lg shadow p-3 max-w-xs">
                                                            <p class="text-sm" x-html="formatMessage(msg.text)"></p>
                                                            <p class="text-xs text-green-100 mt-1 text-right" x-text="formatDateTimeLabel(msg)"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <form @submit.prevent="sendMessage()" class="flex flex-wrap items-center gap-2 p-3 border-t border-gray-100 dark:border-gray-700">
                                            <input x-model="newMessage" placeholder="Type a message..." class="flex-1 rounded-md border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500" />
                                            <button class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">📩 Send</button>
                                        </form>
                                    </div>
                                </template>
                                <template x-if="!activeChat">
                                    <div class="flex items-center justify-center flex-1 text-gray-500 text-sm">
                                        Select a conversation to preview.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        @endif
    </div>

    <script>
        function buildDashboardMessenger(initialItems) {
            return {
                searchQuery: '',
                newMessage: '',
                activeChat: null,
                pollingTimer: null,
                stickToBottom: true,
                allItems: initialItems ?? [],
                filteredItems: initialItems ?? [],

                async init() {
                    this.filteredItems = this.allItems;
                    this.$watch('searchQuery', () => this.applyFilters());

                    if (this.filteredItems.length) {
                        await this.setActiveChat(this.filteredItems[0]);
                    }

                    this.pollingTimer = setInterval(async () => {
                        if (this.activeChat) {
                            await this.fetchLatestMessages();
                        }
                    }, 3000);
                },

                applyFilters() {
                    if (!this.searchQuery) {
                        this.filteredItems = this.allItems;
                        return;
                    }

                    const query = this.searchQuery.toLowerCase();
                    this.filteredItems = this.allItems.filter(item => item.name?.toLowerCase().includes(query));
                },

                async fetchLatestMessages() {
                    if (!this.activeChat) return;

                    const response = await fetch(`/chat/history/${this.activeChat.id}`);
                    const messages = await response.json();

                    this.activeChat.messages = messages;
                    this.syncPreview(this.activeChat, messages);
                    if (this.stickToBottom) {
                        this.scrollChatToBottom();
                    }
                },

                async setActiveChat(chat) {
                    this.activeChat = chat;
                    this.stickToBottom = true;
                    await this.fetchLatestMessages();
                },

                async sendMessage() {
                    const trimmed = this.newMessage.trim();
                    if (!trimmed || !this.activeChat) return;

                    await fetch('/chat/store-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            to_user_id: Number(this.activeChat.id),
                            to_user_type: Number(this.activeChat.toUserType),
                            message: trimmed
                        })
                    });

                    this.newMessage = '';
                    this.stickToBottom = true;
                    await this.fetchLatestMessages();
                },

                syncPreview(chat, messages) {
                    if (!messages.length) return;

                    const lastMessage = messages[messages.length - 1];
                    chat.lastMessage = this.truncateText(lastMessage.text ?? 'New message', 20);
                    chat.time = lastMessage.time;
                    chat.dateTime = lastMessage.dateTime || lastMessage.date || chat.dateTime;
                    chat.lastTimestamp = lastMessage.timestamp || chat.lastTimestamp;
                },

                scrollChatToBottom() {
                    this.$nextTick(() => {
                        if (this.$refs.chatWindow) {
                            this.$refs.chatWindow.scrollTop = this.$refs.chatWindow.scrollHeight;
                        }
                    });
                },

                trackScroll() {
                    this.stickToBottom = this.isNearBottom();
                },

                isNearBottom() {
                    const el = this.$refs.chatWindow;
                    if (!el) return true;
                    return el.scrollHeight - el.scrollTop - el.clientHeight < 48;
                },

                formatDateTimeLabel(item) {
                    if (!item) return '';
                    const date = item.dateTime || item.date || '';
                    const time = item.time || '';
                    return [date, time].filter(Boolean).join(' ');
                },

                truncateText(text, limit = 20) {
                    if (!text) return '';
                    const clean = String(text)
                        .replace(/<a\s+[^>]*href=(["'])(.*?)\1[^>]*>([\s\S]*?)<\/a>/gi, '$3')
                        .replace(/\[([^\]]+)\]\(((?:https?:\/\/|\/)[^)]+)\)/gi, '$1')
                        .replace(/<br\s*\/?>/gi, ' ')
                        .replace(/<[^>]*>/g, '')
                        .trim();
                    if (clean.length <= limit) return clean;
                    return clean.slice(0, limit) + '...';
                },

                escapeHtml(value) {
                    const div = document.createElement('div');
                    div.textContent = value ?? '';
                    return div.innerHTML;
                },

                fileNameFromUrl(url) {
                    try {
                        const parsed = new URL(url, window.location.origin);
                        const file = parsed.pathname.split('/').filter(Boolean).pop() || 'Resource';
                        return decodeURIComponent(file);
                    } catch (e) {
                        return 'Resource';
                    }
                },

                safeLinkHtml(url, label) {
                    try {
                        const parsed = new URL(url, window.location.origin);
                        if (!['http:', 'https:'].includes(parsed.protocol)) {
                            return this.escapeHtml(label);
                        }

                        return `<a href="${this.escapeHtml(parsed.href)}" target="_blank" rel="noopener noreferrer" class="font-semibold underline text-blue-600 dark:text-blue-300">${this.escapeHtml(label || this.fileNameFromUrl(url))}</a>`;
                    } catch (e) {
                        return this.escapeHtml(label);
                    }
                },

                formatMessage(text) {
                    if (!text) return '';

                    let raw = String(text);
                    raw = raw.replace(/<a\s+[^>]*href=(["'])(.*?)\1[^>]*>([\s\S]*?)<\/a>/gi, (_match, _quote, url, label) => {
                        let cleanLabel = String(label || '').replace(/<[^>]*>/g, '').trim();
                        if (!cleanLabel || /^Resource\s+\d+$/i.test(cleanLabel)) {
                            cleanLabel = this.fileNameFromUrl(url);
                        }
                        return `[${cleanLabel}](${url})`;
                    });
                    raw = raw
                        .replace(/<br\s*\/?>/gi, '\n')
                        .replace(/<\/(p|div)>/gi, '\n')
                        .replace(/<\/?strong>/gi, '')
                        .replace(/<[^>]*>/g, '');

                    const linkPattern = /\[([^\]]+)\]\(((?:https?:\/\/|\/)[^)]+)\)/g;
                    let html = '';
                    let lastIndex = 0;
                    let match;

                    while ((match = linkPattern.exec(raw)) !== null) {
                        html += this.escapeHtml(raw.slice(lastIndex, match.index)).replace(/\n/g, '<br>');
                        html += this.safeLinkHtml(match[2], match[1]);
                        lastIndex = match.index + match[0].length;
                    }

                    html += this.escapeHtml(raw.slice(lastIndex)).replace(/\n/g, '<br>');
                    return html;
                },

                destroy() {
                    if (this.pollingTimer) {
                        clearInterval(this.pollingTimer);
                    }
                }
            };
        }

        function therapistDashboardMessages(initialPatients) {
            return {
                ...buildDashboardMessenger(initialPatients),
                patients: initialPatients ?? []
            };
        }

        function userDashboardMessages(initialChats) {
            return {
                ...buildDashboardMessenger(initialChats),
                chats: initialChats ?? []
            };
        }
    </script>
</x-app1>
