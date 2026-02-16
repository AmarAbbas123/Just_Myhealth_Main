<x-app1>

    <div x-data="{ open: false, therapist: {} }" class="w-full px-1 py-8">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- GRID WRAPPER -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">

            <!-- COLUMN 1 — FILTERS PANEL -->
            <div class="md:col-span-1 bg-white shadow rounded-xl p-5 border border-gray-200 min-h-screen">
                <h3 class="font-semibold text-lg mb-4">Therapy Search Criteria</h3>
            </div>

            <!-- COLUMN 2 — THERAPIST CARDS CONTAINER -->
            <div class="md:col-span-3 grid grid-cols-1 lg:grid-cols-2 gap-6">

                @foreach ($therapists as $t)
                    @php
                        $attr = $t->userAttributes;
                        $type = $t->type30;

                        $photo = $type?->BioPhotoPath
                            ? asset('storage/' . $type->BioPhotoPath)
                            : asset('images/default-user.png');

                        $therapyList = [];
                        for ($i = 1; $i <= 5; $i++) {
                            $tt = $type?->{"TherapyType$i"};
                            $yy = $type?->{"TherapyYearsExperience$i"};
                            if ($tt && $yy) {
                                $therapyList[] = "$tt – $yy Years";
                            }
                        }
                    @endphp

                    <!-- SINGLE THERAPIST CARD -->
                    <div class="bg-white shadow rounded-xl p-5 border-l-4 border-orange-500">

                        <!-- therapist header -->
                        <div class="flex items-center gap-4">
                            <img src="{{ $photo }}" class="w-20 h-20 rounded-full object-cover border" />

                            <div>
                                <div class="text-lg font-semibold">
                                    {{ $attr->FirstName ?? '' }} {{ $attr->LastName ?? '' }}
                                </div>

                                <div class="text-sm text-gray-600">
                                    {{ $attr->BaseCity ?? '' }}, {{ $attr->BaseCountry ?? '' }}
                                </div>
                            </div>
                        </div>

                        <!-- therapy list -->
                        <div class="mt-4 text-sm text-gray-700 space-y-1">
                            @foreach ($therapyList as $item)
                                <div>{{ $item }}</div>
                            @endforeach
                        </div>

                        <!-- action buttons -->
                        <div class="mt-6 space-y-3">
                            <button
                                class="w-full text-center border border-indigo-500 text-indigo-600 py-2 rounded-full text-sm"
                                @click=" open = true;
                                    therapist = {{ json_encode(['FirstName' => $attr->FirstName ?? '','LastName' => $attr->LastName ?? '','BaseCity' => $attr->BaseCity ?? '','BaseCountry' => $attr->BaseCountry ?? '','PreferredSalutation' => $type->PreferredSalutation ?? '','LanguagePrimary' => $type->LanguagePrimary ?? '','LanguageSecondary' => $type->LanguageSecondary ?? '','BioTextParagraph1' => $attr->BioTextParagraph1 ?? '','BioTextParagraph2' => $attr->BioTextParagraph2 ?? '','BioTextParagraph3' => $attr->BioTextParagraph3 ?? '','BioTextParagraph4' => $attr->BioTextParagraph4 ?? '','BioTextParagraph5' => $attr->BioTextParagraph5 ?? '','BioTextParagraph6' => $attr->BioTextParagraph6 ?? '','TherapyType1' => $type->TherapyType1 ?? '','TherapyYearsExperience1' => $type->TherapyYearsExperience1 ?? '','TherapyType2' => $type->TherapyType2 ?? '','TherapyYearsExperience2' => $type->TherapyYearsExperience2 ?? '','TherapyType3' => $type->TherapyType3 ?? '','TherapyYearsExperience3' => $type->TherapyYearsExperience3 ?? '','TherapyType4' => $type->TherapyType4 ?? '','TherapyYearsExperience4' => $type->TherapyYearsExperience4 ?? '','TherapyType5' => $type->TherapyType5 ?? '','TherapyYearsExperience5' => $type->TherapyYearsExperience5 ?? '','QualificationTitle1' => $type->QualificationTitle1 ?? '','QualificationFrom1' => $type->QualificationFrom1 ?? '','QualificationLevel1' => $type->QualificationLevel1 ?? '','QualificationGrade1' => $type->QualificationGrade1 ?? '','QualificationTitle2' => $type->QualificationTitle2 ?? '','QualificationFrom2' => $type->QualificationFrom2 ?? '','QualificationLevel2' => $type->QualificationLevel2 ?? '','QualificationGrade2' => $type->QualificationGrade2 ?? '','QualificationTitle3' => $type->QualificationTitle3 ?? '','QualificationFrom3' => $type->QualificationFrom3 ?? '','QualificationLevel3' => $type->QualificationLevel3 ?? '','QualificationGrade3' => $type->QualificationGrade3 ?? '','QualificationTitle4' => $type->QualificationTitle4 ?? '','QualificationFrom4' => $type->QualificationFrom4 ?? '','QualificationLevel4' => $type->QualificationLevel4 ?? '','QualificationGrade4' => $type->QualificationGrade4 ?? '']) }};">
                                View BIO
                            </button>

                            <a href="{{ route('session.book', ['id' => $t->ID]) }}"
                                class="w-full block text-center bg-indigo-600 text-white py-2 rounded-full text-sm">
                                Book Session
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

        <!-- BIO MODAL -->
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">

                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <span x-text="therapist.FirstName"></span>
                        <span x-text="therapist.LastName"></span>
                    </h2>

                    <button @click="open=false" class="text-gray-500 hover:text-gray-700 text-xl">×</button>
                </div>

                <!-- Basic Info -->
                <div class="space-y-2 text-gray-700 text-sm">
                    <p><strong>Location:</strong>
                        <span x-text="therapist.BaseCity"></span>,
                        <span x-text="therapist.BaseCountry"></span>
                    </p>

                    <p><strong>Preferred Salutation:</strong>
                        <span x-text="therapist.PreferredSalutation"></span>
                    </p>

                    <p><strong>Primary Language:</strong>
                        <span x-text="therapist.LanguagePrimary"></span>
                    </p>

                    <p><strong>Secondary Language:</strong>
                        <span x-text="therapist.LanguageSecondary"></span>
                    </p>
                </div>

                <hr class="my-4">

                <!-- Bio Paragraphs -->
                <div class="space-y-3 text-gray-700 leading-relaxed">
                    <template x-for="i in [1,2,3,4,5,6]">
                        <p x-show="therapist['BioTextParagraph'+i]" x-text="therapist['BioTextParagraph'+i]"></p>
                    </template>
                </div>

                <hr class="my-4">

                <!-- Therapy Services -->
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Therapy Services</h3>
                <div class="space-y-3">
                    <template x-for="i in [1,2,3,4,5]">
                        <div x-show="therapist['TherapyType'+i]" class="border rounded-lg p-3 bg-gray-50">
                            <p><strong>Type:</strong> <span x-text="therapist['TherapyType'+i]"></span></p>
                            <p><strong>Experience:</strong>
                                <span x-text="therapist['TherapyYearsExperience'+i]"></span> Years
                            </p>
                        </div>
                    </template>
                </div>

                <hr class="my-4">

                <!-- Qualification -->
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Qualification</h3>
                <div class="space-y-3">
                    <template x-for="i in [1,2,3,4]">
                        <div x-show="therapist['QualificationTitle'+i]" class="border rounded-lg p-3 bg-gray-50">
                            <p><strong>QualificationTitle:</strong>
                                <span x-text="therapist['QualificationTitle'+i]"></span>
                            </p>

                            <p><strong>QualificationFrom:</strong>
                                <span x-text="therapist['QualificationFrom'+i]"></span>
                            </p>

                            <p><strong>QualificationLevel:</strong>
                                <span x-text="therapist['QualificationLevel'+i]"></span>
                            </p>

                            <p><strong>QualificationGrade:</strong>
                                <span x-text="therapist['QualificationGrade'+i]"></span>
                            </p>
                        </div>
                    </template>
                </div>

                <div class="mt-6 text-right">
                    <button @click="open=false"
                        class="px-5 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Close
                    </button>
                </div>

            </div>
        </div>

    </div>

</x-app1>
