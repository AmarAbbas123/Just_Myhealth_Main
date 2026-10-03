<x-app1>
    <div x-data="sessionHistory()" class="w-full px-1 py-4 sm:py-6 space-y-6">

        <!-- Header -->
        <x-page-header />

        <!-- CARD GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">

            @forelse($sessions as $session)
                @php
                    $attr = $session->therapist?->userAttributes;
                    $type = $session->therapist?->type30;

                    $fullName = trim(($attr->FirstName ?? '') . ' ' . ($attr->LastName ?? ''));
                    if (empty($fullName)) {
                        $fullName = $session->therapist?->UserName ?? 'Therapist';
                    }

                    $initials = strtoupper(substr($attr->FirstName ?? ($session->therapist?->UserName ?? 'T'), 0, 1) . substr($attr->LastName ?? '', 0, 1));
                    if (empty(trim($initials))) {
                        $initials = 'TH';
                    }

                    $hasPhoto = !empty($type?->BioPhotoPath) && Storage::disk('public')->exists($type->BioPhotoPath);
                    $photo = $hasPhoto ? asset('storage/' . $type->BioPhotoPath) : null;

                    $city = $attr->BaseCity ?? '';
                    $state = $attr->BaseState ?? '';
                    $country = $attr->BaseCountry ?? '';
                    $location = trim(($city ? $city : '') . ($city && ($state || $country) ? ', ' : '') . ($state ? $state : '') . ($state && $country ? ', ' : '') . ($country ? $country : ''));

                    $therapyList = [];
                    for ($i = 1; $i <= 5; $i++) {
                        $tt = $type?->{"TherapyType$i"};
                        $yy = $type?->{"TherapyYearsExperience$i"};
                        if ($tt && $yy) {
                            $therapyList[] = "$tt – $yy Years";
                        }
                    }

                    // Fallback to qualifications if no therapies listed
                    if (empty($therapyList)) {
                        for ($i = 1; $i <= 4; $i++) {
                            $qt = $type?->{"QualificationTitle$i"};
                            if ($qt) {
                                $therapyList[] = $qt;
                            }
                        }
                    }

                    $bookUrl = route('session.book', ['id' => $session->AllocatedTherapistUserID]);
                @endphp

                <!-- SINGLE THERAPIST CARD -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_32px_-6px_rgba(0,0,0,0.12)] dark:shadow-none dark:hover:shadow-[0_16px_32px_-6px_rgba(0,0,0,0.4)] rounded-2xl p-4 sm:p-6 border border-gray-100 dark:border-gray-700/80 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 group">

                    <!-- Left Accent Line (appears smoothly when card is hovered) -->
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                         style="background: linear-gradient(180deg, #1C9BA0, #127F94);"></div>

                    <div>
                        <!-- Therapist Header: Image on Left Side -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="relative shrink-0">
                                @if ($photo)
                                    <img src="{{ $photo }}" 
                                         alt="{{ $fullName }}" 
                                         class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-sm"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full items-center justify-center text-white text-base sm:text-lg font-bold shadow-sm"
                                         style="display:none; background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                        {{ $initials }}
                                    </div>
                                @else
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white text-base sm:text-lg font-bold shadow-sm"
                                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug group-hover:text-[#1C9BA0] transition-colors truncate">
                                    {{ $fullName }}
                                </h4>

                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-0.5 font-normal truncate">
                                    {{ $location ?: 'Location on request' }}
                                </p>
                            </div>
                        </div>

                        <!-- Previous Session Highlight Bar -->
                        @if($session->SessionStartedDate)
                            <div class="mt-3.5 pt-2.5 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
                                <span class="text-gray-500 dark:text-gray-400 font-medium">Last Attended</span>
                                <span class="inline-flex items-center gap-1 font-semibold text-[#1C9BA0] dark:text-[#38b2ac] bg-[#1C9BA0]/10 px-2.5 py-0.5 rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ \Carbon\Carbon::parse($session->SessionStartedDate)->format('M d, Y') }}
                                </span>
                            </div>
                        @endif

                        <!-- Therapy List with subtle brand bullets -->
                        <div class="mt-4 space-y-1.5 text-xs sm:text-sm text-gray-600 dark:text-gray-300 font-normal">
                            @foreach ($therapyList as $item)
                                <div class="flex items-start gap-2 leading-relaxed">
                                    <span class="w-1.5 h-1.5 rounded-full mt-2 shrink-0" style="background-color: #1C9BA0;"></span>
                                    <span>{{ $item }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons: Side-by-side with divider -->
                    <div class="mt-5 sm:mt-6 pt-3.5 sm:pt-4 border-t border-gray-100 dark:border-gray-700/60 grid grid-cols-2 gap-2 sm:gap-2.5">
                        <button
                            type="button"
                            class="w-full text-center py-2 px-2 sm:px-3 rounded-full border text-xs sm:text-sm font-semibold tracking-wide transition-all duration-200 active:scale-[0.99] cursor-pointer hover:bg-[#1C9BA0]/10 whitespace-nowrap truncate"
                            style="border-color: #1C9BA0; color: #1C9BA0;"
                            @click='openBioModal(@json($attr), @json($type), "{{ $photo }}", "{{ $initials }}", "{{ $bookUrl }}")'>
                            View BIO
                        </button>

                        <a href="{{ $bookUrl }}"
                            class="w-full block text-center py-2 px-2 sm:px-3 rounded-full text-white text-xs sm:text-sm font-semibold tracking-wide shadow-xs hover:shadow-md transition-all duration-200 active:scale-[0.99] cursor-pointer hover:opacity-95 whitespace-nowrap truncate"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            Book Session
                        </a>
                    </div>

                </div>

            @empty
                <div class="col-span-full py-16 px-6 text-center bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700 shadow-xs">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                         style="background: rgba(28, 155, 160, 0.1); color: #1C9BA0;">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">No Previous Therapists Found</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mt-1 mb-6">
                        You have not completed any therapy sessions yet. Browse our verified therapists to book your first session.
                    </p>
                    <a href="{{ route('therapists.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-white text-sm font-semibold shadow-sm hover:shadow-md transition hover:opacity-95"
                       style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        Find a Therapist
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            @endforelse

        </div>

        <!-- BIO MODAL -->
        <div x-show="isModalOpen" 
             x-cloak 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-2.5 sm:p-6 z-50 overflow-y-auto"
             @click.self="closeModal" 
             @keydown.escape.window="closeModal">

            <div class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden flex flex-col max-h-[92vh] sm:max-h-[90vh] my-auto"
                 @click.stop>

                <!-- Top Brand Color Strip -->
                <div class="h-1.5 w-full shrink-0" style="background: linear-gradient(90deg, #1C9BA0, #127F94);"></div>

                <!-- Modal Header: Banner Style -->
                <div class="p-4 sm:p-6 bg-slate-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 flex items-start justify-between gap-3 sm:gap-4 shrink-0">
                    <div class="flex items-center gap-3 sm:gap-5 min-w-0">
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            <template x-if="therapist.photo">
                                <img :src="therapist.photo" :alt="(therapist.user?.FirstName || '') + ' ' + (therapist.user?.LastName || '')" 
                                     class="w-13 h-13 sm:w-18 sm:h-18 rounded-full object-cover ring-2 sm:ring-3 ring-white dark:ring-gray-700 shadow-md" />
                            </template>
                            <template x-if="!therapist.photo">
                                <div class="w-13 h-13 sm:w-18 sm:h-18 rounded-full flex items-center justify-center text-white text-base sm:text-xl font-bold shadow-md"
                                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                     x-text="therapist.initials || 'TH'">
                                </div>
                            </template>
                            <!-- Verified badge -->
                            <div class="absolute bottom-0 right-0 w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-gray-800 flex items-center justify-center text-white text-[10px]" title="Verified Practitioner">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>

                        <!-- Name and Quick Badges -->
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                <h2 class="text-base sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug">
                                    <span x-text="therapist.user?.FirstName || ''"></span>
                                    <span x-text="therapist.user?.LastName || ''"></span>
                                </h2>
                                <span x-show="therapist.type30?.PreferredSalutation" 
                                      class="text-[11px] sm:text-xs font-semibold px-2 py-0.5 rounded-full" 
                                      style="background: rgba(28, 155, 160, 0.12); color: #1C9BA0;" 
                                      x-text="therapist.type30?.PreferredSalutation"></span>
                            </div>

                            <p class="flex items-center gap-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1 truncate">
                                <svg class="w-3.5 h-3.5 shrink-0" style="color: #1C9BA0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate" x-text="(therapist.user?.BaseCity ? therapist.user.BaseCity + (therapist.user?.BaseCountry ? ', ' : '') : '') + (therapist.user?.BaseCountry || 'Location on request')"></span>
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

                <!-- Modal Body: Two-Column Responsive Layout -->
                <div class="overflow-y-auto p-4 sm:p-7" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-7">

                        <!-- LEFT COLUMN: Overview & Services (md:col-span-5) -->
                        <div class="md:col-span-5 space-y-4">
                            
                            <!-- Information Card -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Overview
                                </h4>

                                <div class="space-y-2 text-xs sm:text-sm">
                                    <div class="flex items-start justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                                        <span class="text-gray-500 dark:text-gray-400">Location</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100 text-right" 
                                              x-text="(therapist.user?.BaseCity || '') + (therapist.user?.BaseCity && therapist.user?.BaseCountry ? ', ' : '') + (therapist.user?.BaseCountry || '-')"></span>
                                    </div>

                                    <div x-show="therapist.type30?.PreferredSalutation" class="flex items-center justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                                        <span class="text-gray-500 dark:text-gray-400">Salutation</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100" x-text="therapist.type30?.PreferredSalutation"></span>
                                    </div>

                                    <div x-show="therapist.type30?.LanguagePrimary" class="flex items-center justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                                        <span class="text-gray-500 dark:text-gray-400">Primary</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100" x-text="therapist.type30?.LanguagePrimary"></span>
                                    </div>

                                    <div x-show="therapist.type30?.LanguageSecondary" class="flex items-center justify-between gap-2">
                                        <span class="text-gray-500 dark:text-gray-400">Secondary</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100" x-text="therapist.type30?.LanguageSecondary"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Therapy Services Card -->
                            <div x-show="[1,2,3,4,5].some(i => therapist.type30?.['TherapyType'+i])"
                                 class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Therapy Services
                                </h4>

                                <div class="space-y-2">
                                    <template x-for="i in [1,2,3,4,5]">
                                        <div x-show="therapist.type30?.['TherapyType'+i]" 
                                             class="p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/70 flex items-center justify-between gap-2 shadow-2xs">
                                            <span class="font-semibold text-xs sm:text-sm text-gray-800 dark:text-gray-100" x-text="therapist.type30?.['TherapyType'+i]"></span>
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-md whitespace-nowrap" style="background: rgba(28, 155, 160, 0.15); color: #1C9BA0;">
                                                <span x-text="therapist.type30?.['TherapyYearsExperience'+i]"></span> Yrs
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Qualifications (if present) -->
                            <div x-show="[1,2,3,4].some(i => therapist.type30?.['QualificationTitle'+i])"
                                 class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Credentials
                                </h4>

                                <div class="space-y-2">
                                    <template x-for="i in [1,2,3,4]">
                                        <div x-show="therapist.type30?.['QualificationTitle'+i]" 
                                             class="p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/70 shadow-2xs">
                                            <div class="font-semibold text-xs sm:text-sm text-gray-900 dark:text-gray-100" x-text="therapist.type30?.['QualificationTitle'+i]"></div>
                                            <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5" x-text="therapist.type30?.['QualificationFrom'+i]"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN: BIO Reading Area (md:col-span-7) -->
                        <div class="md:col-span-7 space-y-3.5">
                            <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-700/80">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Biography & Practice</h3>
                            </div>

                            <div class="space-y-3">
                                <template x-for="i in [1,2,3,4,5,6]">
                                    <div x-show="therapist.type30?.['BioTextParagraph'+i]"
                                         class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 shadow-2xs">
                                        <p class="text-xs sm:text-sm leading-relaxed text-gray-700 dark:text-gray-300" x-text="therapist.type30?.['BioTextParagraph'+i]"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sticky Footer -->
                <div class="p-3.5 sm:px-6 sm:py-4 bg-slate-50 dark:bg-gray-800/90 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-between gap-2.5 sm:gap-3 shrink-0">
                    <button @click="closeModal"
                        class="flex-1 sm:flex-initial text-center px-4 sm:px-5 py-2.5 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-full text-xs sm:text-sm font-semibold transition cursor-pointer">
                        Close
                    </button>

                    <a :href="therapist.bookUrl"
                        x-show="therapist.bookUrl"
                        class="flex-1 sm:flex-initial text-center px-5 sm:px-7 py-2.5 text-white rounded-full text-xs sm:text-sm font-semibold shadow-sm hover:shadow-md transition cursor-pointer hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        Book Session
                    </a>
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

                therapist: {
                    user: {},
                    type30: {},
                    photo: null,
                    initials: 'TH',
                    bookUrl: ''
                },

                openBioModal(userAttributes, type30, photo, initials, bookUrl) {
                    this.isModalOpen = true;
                    this.loading = false;

                    this.therapist = {
                        user: userAttributes || {},
                        type30: type30 || {},
                        photo: photo || null,
                        initials: initials || 'TH',
                        bookUrl: bookUrl || ''
                    };
                },

                closeModal() {
                    this.isModalOpen = false;
                }
            }
        }
    </script>

</x-app1>