<x-app1>

    @php
        // Collect unique therapy specializations for search filter
        $therapyTypes = collect();
        foreach ($therapists as $t) {
            for ($i = 1; $i <= 5; $i++) {
                $tt = $t->type30?->{"TherapyType$i"};
                if ($tt) {
                    $therapyTypes->push($tt);
                }
            }
        }
        $uniqueTherapyTypes = $therapyTypes->unique()->sort()->values();
    @endphp

    <div x-data="{ 
            open: false, 
            therapist: {},
            searchQuery: '',
            selectedType: '',
            resetFilters() {
                this.searchQuery = '';
                this.selectedType = '';
            }
        }" 
        class="w-full px-1 py-4 sm:py-6">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- THERAPY SEARCH CRITERIA (ON TOP) -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-5 border border-gray-200/80 dark:border-gray-700 mb-6 transition-colors duration-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl text-white flex items-center justify-center shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Therapy Search Criteria</h3>
                </div>

                {{-- Reset Filter Button --}}
                <button type="button"
                    x-show="searchQuery || selectedType"
                    x-cloak
                    @click="resetFilters()"
                    class="text-xs font-semibold hover:opacity-80 transition self-start md:self-auto cursor-pointer"
                    style="color: #1C9BA0;">
                    Clear Filters
                </button>
            </div>

            {{-- Filter Inputs Row --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-4">
                {{-- Keyword / Name / City search --}}
                <div>
                    <label for="therapistSearch" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Search by Name or Location
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                            </svg>
                        </div>
                        <input id="therapistSearch" type="text"
                            x-model="searchQuery"
                            placeholder="Type therapist name, city..."
                            class="w-full h-10 pl-9 pr-3 text-xs bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-800 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition" />
                    </div>
                </div>

                {{-- Specialization Dropdown --}}
                @if ($uniqueTherapyTypes->isNotEmpty())
                    <div>
                        <label for="therapyTypeFilter" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Therapy Specialization
                        </label>
                        <select id="therapyTypeFilter"
                            x-model="selectedType"
                            class="w-full h-10 px-3 text-xs bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-800 dark:text-gray-200 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                            <option value="">All Specializations</option>
                            @foreach ($uniqueTherapyTypes as $tType)
                                <option value="{{ $tType }}">{{ $tType }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>

        <!-- THERAPIST CARDS CONTAINER -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($therapists as $t)
                @php
                    $attr = $t->userAttributes;
                    $type = $t->type30;

                    $hasPhoto = !empty($type?->BioPhotoPath) && Storage::disk('public')->exists($type->BioPhotoPath);
                    $photo = $hasPhoto ? asset('storage/' . $type->BioPhotoPath) : null;

                    $fullName = trim(($attr->FirstName ?? '') . ' ' . ($attr->LastName ?? ''));
                    if (empty($fullName)) {
                        $fullName = $t->UserName ?? 'Therapist';
                    }

                    $initials = strtoupper(substr($attr->FirstName ?? ($t->UserName ?? 'T'), 0, 1) . substr($attr->LastName ?? '', 0, 1));
                    if (empty(trim($initials))) {
                        $initials = 'TH';
                    }

                    $therapyList = [];
                    $therapySearchTerms = [];
                    for ($i = 1; $i <= 5; $i++) {
                        $tt = $type?->{"TherapyType$i"};
                        $yy = $type?->{"TherapyYearsExperience$i"};
                        if ($tt && $yy) {
                            $therapyList[] = "$tt – $yy Years";
                            $therapySearchTerms[] = $tt;
                        }
                    }

                    $location = trim(($attr->BaseCity ?? '') . (($attr->BaseCity && $attr->BaseCountry) ? ', ' : '') . ($attr->BaseCountry ?? ''));
                    $cityOnly = $attr->BaseCity ?? '';
                @endphp

                <!-- SINGLE THERAPIST CARD -->
                <div x-data="{
                        name: '{{ addslashes($fullName) }}',
                        city: '{{ addslashes($cityOnly) }}',
                        specialties: {{ json_encode($therapySearchTerms) }},
                        matches() {
                            const query = $data.searchQuery.toLowerCase().trim();
                            const type = $data.selectedType;

                            const matchQuery = !query || 
                                this.name.toLowerCase().includes(query) || 
                                this.city.toLowerCase().includes(query) || 
                                this.specialties.some(s => s.toLowerCase().includes(query));

                            const matchType = !type || this.specialties.includes(type);

                            return matchQuery && matchType;
                        }
                    }"
                    x-show="matches()"
                    x-transition
                    class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_32px_-6px_rgba(0,0,0,0.12)] dark:shadow-none dark:hover:shadow-[0_16px_32px_-6px_rgba(0,0,0,0.4)] rounded-2xl p-6 sm:p-7 border border-gray-100 dark:border-gray-700/80 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 group">

                    <!-- Left Accent Strip (exact dashboard brand color #1C9BA0 -> #127F94) -->
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-2xl"
                         style="background: linear-gradient(180deg, #1C9BA0, #127F94);"></div>

                    <div>
                        <!-- Therapist Header: Image on Left Side -->
                        <div class="flex items-center gap-4">
                            <div class="relative shrink-0">
                                @if ($photo)
                                    <img src="{{ $photo }}" 
                                         alt="{{ $fullName }}" 
                                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-sm"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full items-center justify-center text-white text-xl font-bold shadow-sm"
                                         style="display:none; background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                        {{ $initials }}
                                    </div>
                                @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-sm"
                                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h4 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug group-hover:text-[#1C9BA0] transition-colors">
                                    {{ $fullName }}
                                </h4>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-normal">
                                    {{ $location ?: 'Location available upon request' }}
                                </p>
                            </div>
                        </div>

                        <!-- Therapy List -->
                        <div class="mt-5 space-y-1.5 text-sm text-gray-700 dark:text-gray-300 font-normal">
                            @foreach ($therapyList as $item)
                                <div class="leading-relaxed">{{ $item }}</div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        <button
                            type="button"
                            class="w-full text-center py-2.5 px-4 rounded-full border text-sm font-semibold tracking-wide transition-all duration-200 active:scale-[0.99] cursor-pointer hover:bg-[#1C9BA0]/10"
                            style="border-color: #1C9BA0; color: #1C9BA0;"
                            @click=" open = true;
                                therapist = {{ json_encode([
                                    'FirstName' => $attr->FirstName ?? '',
                                    'LastName' => $attr->LastName ?? '',
                                    'BaseCity' => $attr->BaseCity ?? '',
                                    'BaseCountry' => $attr->BaseCountry ?? '',
                                    'PreferredSalutation' => $type->PreferredSalutation ?? '',
                                    'LanguagePrimary' => $type->LanguagePrimary ?? '',
                                    'LanguageSecondary' => $type->LanguageSecondary ?? '',
                                    'BioTextParagraph1' => $type->BioTextParagraph1 ?? '',
                                    'BioTextParagraph2' => $type->BioTextParagraph2 ?? '',
                                    'BioTextParagraph3' => $type->BioTextParagraph3 ?? '',
                                    'BioTextParagraph4' => $type->BioTextParagraph4 ?? '',
                                    'BioTextParagraph5' => $type->BioTextParagraph5 ?? '',
                                    'BioTextParagraph6' => $type->BioTextParagraph6 ?? '',
                                    'TherapyType1' => $type->TherapyType1 ?? '',
                                    'TherapyYearsExperience1' => $type->TherapyYearsExperience1 ?? '',
                                    'TherapyType2' => $type->TherapyType2 ?? '',
                                    'TherapyYearsExperience2' => $type->TherapyYearsExperience2 ?? '',
                                    'TherapyType3' => $type->TherapyType3 ?? '',
                                    'TherapyYearsExperience3' => $type->TherapyYearsExperience3 ?? '',
                                    'TherapyType4' => $type->TherapyType4 ?? '',
                                    'TherapyYearsExperience4' => $type->TherapyYearsExperience4 ?? '',
                                    'TherapyType5' => $type->TherapyType5 ?? '',
                                    'TherapyYearsExperience5' => $type->TherapyYearsExperience5 ?? '',
                                    'QualificationTitle1' => $type->QualificationTitle1 ?? '',
                                    'QualificationFrom1' => $type->QualificationFrom1 ?? '',
                                    'QualificationLevel1' => $type->QualificationLevel1 ?? '',
                                    'QualificationGrade1' => $type->QualificationGrade1 ?? '',
                                    'QualificationTitle2' => $type->QualificationTitle2 ?? '',
                                    'QualificationFrom2' => $type->QualificationFrom2 ?? '',
                                    'QualificationLevel2' => $type->QualificationLevel2 ?? '',
                                    'QualificationGrade2' => $type->QualificationGrade2 ?? '',
                                    'QualificationTitle3' => $type->QualificationTitle3 ?? '',
                                    'QualificationFrom3' => $type->QualificationFrom3 ?? '',
                                    'QualificationLevel3' => $type->QualificationLevel3 ?? '',
                                    'QualificationGrade3' => $type->QualificationGrade3 ?? '',
                                    'QualificationTitle4' => $type->QualificationTitle4 ?? '',
                                    'QualificationFrom4' => $type->QualificationFrom4 ?? '',
                                    'QualificationLevel4' => $type->QualificationLevel4 ?? '',
                                    'QualificationGrade4' => $type->QualificationGrade4 ?? '',
                                    'Photo' => $photo,
                                    'Initials' => $initials,
                                    'BookUrl' => route('session.book', ['id' => $t->ID]),
                                ]) }};">
                            View BIO
                        </button>

                        <a href="{{ route('session.book', ['id' => $t->ID]) }}"
                            class="w-full block text-center py-2.5 px-4 rounded-full text-white text-sm font-semibold tracking-wide shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.99] cursor-pointer hover:opacity-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            Book Session
                        </a>
                    </div>

                </div>
            @endforeach

        </div>

        <!-- BIO MODAL -->
        <div x-show="open" 
             x-cloak 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 z-50 overflow-y-auto"
             @click.self="open=false" 
             @keydown.escape.window="open=false">

            <div class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden flex flex-col max-h-[90vh] my-auto"
                 @click.stop>

                <!-- Top Brand Color Strip -->
                <div class="h-1.5 w-full shrink-0" style="background: linear-gradient(90deg, #1C9BA0, #127F94);"></div>

                <!-- Modal Header: Banner Style -->
                <div class="p-5 sm:p-6 bg-slate-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 flex items-start justify-between gap-4 shrink-0">
                    <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            <template x-if="therapist.Photo">
                                <img :src="therapist.Photo" :alt="therapist.FirstName + ' ' + therapist.LastName" 
                                     class="w-16 h-16 sm:w-18 sm:h-18 rounded-full object-cover ring-3 ring-white dark:ring-gray-700 shadow-md" />
                            </template>
                            <template x-if="!therapist.Photo">
                                <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-md"
                                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                     x-text="therapist.Initials || 'TH'">
                                </div>
                            </template>
                            <!-- Verified badge -->
                            <div class="absolute bottom-0 right-0 w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-gray-800 flex items-center justify-center text-white text-[10px]" title="Verified Practitioner">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>

                        <!-- Name and Quick Badges -->
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                    <span x-text="therapist.FirstName"></span>
                                    <span x-text="therapist.LastName"></span>
                                </h2>
                                <span x-show="therapist.PreferredSalutation" 
                                      class="text-xs font-semibold px-2 py-0.5 rounded-full" 
                                      style="background: rgba(28, 155, 160, 0.12); color: #1C9BA0;" 
                                      x-text="therapist.PreferredSalutation"></span>
                            </div>

                            <p class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" style="color: #1C9BA0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span x-text="(therapist.BaseCity ? therapist.BaseCity + (therapist.BaseCountry ? ', ' : '') : '') + (therapist.BaseCountry || 'Location on request')"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button @click="open=false"
                        class="w-9 h-9 rounded-full bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-700 dark:hover:text-white flex items-center justify-center transition shadow-xs cursor-pointer shrink-0"
                        title="Close">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body: Two-Column Responsive Layout -->
                <div class="overflow-y-auto p-5 sm:p-7" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-7">

                        <!-- LEFT COLUMN: Overview & Services (md:col-span-5) -->
                        <div class="md:col-span-5 space-y-4">
                            
                            <!-- Information Card -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-gray-750/70 border border-gray-100 dark:border-gray-700/80 space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Overview
                                </h4>

                                <div class="space-y-2 text-xs sm:text-sm">
                                    <div class="flex items-start justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                                        <span class="text-gray-500 dark:text-gray-400">Location</span>
                                        <span class="font-medium text-gray-800 dark:text-gray-200 text-right" 
                                              x-text="(therapist.BaseCity || '') + (therapist.BaseCity && therapist.BaseCountry ? ', ' : '') + (therapist.BaseCountry || '-')"></span>
                                    </div>

                                    <div x-show="therapist.PreferredSalutation" class="flex items-center justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                                        <span class="text-gray-500 dark:text-gray-400">Salutation</span>
                                        <span class="font-medium text-gray-800 dark:text-gray-200" x-text="therapist.PreferredSalutation"></span>
                                    </div>

                                    <div x-show="therapist.LanguagePrimary" class="flex items-center justify-between gap-2 pb-2 border-b border-gray-200/60 dark:border-gray-700/60">
                                        <span class="text-gray-500 dark:text-gray-400">Primary</span>
                                        <span class="font-medium text-gray-800 dark:text-gray-200" x-text="therapist.LanguagePrimary"></span>
                                    </div>

                                    <div x-show="therapist.LanguageSecondary" class="flex items-center justify-between gap-2">
                                        <span class="text-gray-500 dark:text-gray-400">Secondary</span>
                                        <span class="font-medium text-gray-800 dark:text-gray-200" x-text="therapist.LanguageSecondary"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Therapy Services Card -->
                            <div x-show="[1,2,3,4,5].some(i => therapist['TherapyType'+i])"
                                 class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-gray-750/70 border border-gray-100 dark:border-gray-700/80 space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Therapy Services
                                </h4>

                                <div class="space-y-2">
                                    <template x-for="i in [1,2,3,4,5]">
                                        <div x-show="therapist['TherapyType'+i]" 
                                             class="p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/70 flex items-center justify-between gap-2 shadow-2xs">
                                            <span class="font-semibold text-xs sm:text-sm text-gray-800 dark:text-gray-200" x-text="therapist['TherapyType'+i]"></span>
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-md whitespace-nowrap" style="background: rgba(28, 155, 160, 0.12); color: #1C9BA0;">
                                                <span x-text="therapist['TherapyYearsExperience'+i]"></span> Yrs
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Qualifications (if present) -->
                            <div x-show="[1,2,3,4].some(i => therapist['QualificationTitle'+i])"
                                 class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-gray-750/70 border border-gray-100 dark:border-gray-700/80 space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Credentials
                                </h4>

                                <div class="space-y-2">
                                    <template x-for="i in [1,2,3,4]">
                                        <div x-show="therapist['QualificationTitle'+i]" 
                                             class="p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/70 shadow-2xs">
                                            <div class="font-semibold text-xs sm:text-sm text-gray-900 dark:text-gray-100" x-text="therapist['QualificationTitle'+i]"></div>
                                            <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5" x-text="therapist['QualificationFrom'+i]"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN: BIO Reading Area (md:col-span-7) -->
                        <div class="md:col-span-7 space-y-3.5">
                            <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-700/80">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Biography & Practice</h3>
                            </div>

                            <div class="space-y-3">
                                <template x-for="i in [1,2,3,4,5,6]">
                                    <div x-show="therapist['BioTextParagraph'+i]"
                                         class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700/70 shadow-2xs">
                                        <p class="text-xs sm:text-sm leading-relaxed text-gray-700 dark:text-gray-300" x-text="therapist['BioTextParagraph'+i]"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sticky Footer -->
                <div class="px-6 py-4 bg-slate-50 dark:bg-gray-800/90 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-between gap-3 shrink-0">
                    <button @click="open=false"
                        class="px-5 py-2.5 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-full text-sm font-semibold transition cursor-pointer">
                        Close
                    </button>

                    <a :href="therapist.BookUrl"
                        x-show="therapist.BookUrl"
                        class="px-7 py-2.5 text-white rounded-full text-sm font-semibold shadow-sm hover:shadow-md transition cursor-pointer hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        Book Session
                    </a>
                </div>

            </div>
        </div>

    </div>

</x-app1>