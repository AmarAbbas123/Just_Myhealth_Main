<x-app1>
    <div x-data="sessionHistory()" class="space-y-6">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- CARD GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">

            @forelse($sessions as $session)
                @php
                    $clientName = trim(
                        optional($session->therapist->userAttributes)->FirstName .
                            ' ' .
                            optional($session->therapist->userAttributes)->LastName,
                    );

                    $city = optional($session->therapist->userAttributes)->BaseCity;
                    $state = optional($session->therapist->userAttributes)->BaseState;
                @endphp

                <!-- SINGLE CARD -->
                <div class="bg-white border rounded-xl p-4 w-full">

                    <!-- TOP ROW -->
                    <div class="flex items-start justify-between">

                        <div class="flex gap-3">
                            <!-- Avatar -->
                            <img src="{{ asset('images/avatar1.jfif') }}" class="w-12 h-12 rounded-full object-cover">

                            <!-- Name + Qualification -->
                            <div>
                                <div class="font-semibold text-gray-800">
                                    {{ $clientName }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1 leading-tight">
                                    @for ($i = 1; $i <= 4; $i++)
                                        @php
                                            $title = $session->therapist->type30?->{'QualificationTitle' . $i};
                                        @endphp

                                        @if ($title)
                                            {{ $title }}
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <!-- Three dots -->
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            ⋮
                        </button>
                    </div>

                    <!-- BOTTOM SECTION -->
                    <div class="mt-6 grid grid-cols-[1fr_auto] items-start gap-x-4">

                        <!-- LEFT: City + State (single block, no gap) -->
                        <div class="text-sm text-gray-600 leading-tight mt-8">
                            <div>{{ $city }}</div>
                            <div>{{ $state }}</div>
                        </div>

                        <!-- RIGHT: Buttons (two rows) -->
                        <div class="flex flex-col gap-2 text-right min-w-[130px]">
                            <button @click='openBioModal(@json($session->therapist->userAttributes), @json($session->therapist->type30))'
                                class="px-4 py-1.5 text-sm border border-blue-400 text-blue-600 rounded-full hover:bg-blue-50">
                                View BIO
                            </button>

                            <a href="{{ route('session.book', ['id' => $session->AllocatedTherapistUserID]) }}"
                                class="inline-block px-4 py-1.5 text-sm bg-blue-500 text-white rounded-full hover:bg-blue-600">
                                Book Session
                            </a>
                        </div>

                    </div>


                </div>

            @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    No sessions found.
                </div>
            @endforelse

        </div>

        <!-- MODAL -->
        <div x-show="isModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeModal">

            <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-2xl p-6 shadow-xl overflow-y-auto max-h-[90vh]"
                @click.stop>

                <!-- Loading -->
                <div x-show="loading" class="text-center text-gray-500">
                    Loading Therapists Details...
                </div>

                <!-- Content -->
                <div x-show="!loading" class="space-y-3 text-sm text-gray-700 dark:text-gray-200">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">
                            <span x-text="therapist.user.FirstName"></span>
                            <span x-text="therapist.user.LastName"></span>
                        </h2>

                        <button @click="closeModal" class="text-gray-500 text-xl">×</button>
                    </div>


                    <div><strong>Location:</strong>
                        <p class="text-sm text-gray-500 mb-4">
                            <span x-text="therapist.user.BaseCity"></span>,
                            <span x-text="therapist.user.BaseState"></span>,
                            <span x-text="therapist.user.BaseCountry"></span>
                        </p>

                        <p><strong>Preferred Salutation:</strong>
                            <span x-text="therapist.type30.PreferredSalutation"></span>
                        </p>
    
                        <p><strong>Primary Language:</strong>
                            <span x-text="therapist.type30.LanguagePrimary"></span>
                        </p>
    
                        <p><strong>Secondary Language:</strong>
                            <span x-text="therapist.type30.LanguageSecondary"></span>
                        </p>

                    </div>

                    <h3 class="text-lg font-semibold mb-3">Therapy Services</h3>

                    <div class="space-y-3">
                        <template x-for="i in [1,2,3,4,5]">
                            <div x-show="therapist.type30['TherapyType'+i]" class="border rounded-lg p-3 bg-gray-50">

                                <p>
                                    <strong>Type:</strong>
                                    <span x-text="therapist.type30['TherapyType'+i]"></span>
                                </p>

                                <p>
                                    <strong>Experience:</strong>
                                    <span x-text="therapist.type30['TherapyYearsExperience'+i]"></span> years
                                </p>
                            </div>
                        </template>
                    </div>

                    

                    <h3 class="text-lg font-semibold mb-3">Bio Details</h3>
                    <div>
                        <div class="space-y-3 text-sm text-gray-700">
                            <template x-for="i in [1,2,3,4,5,6]">
                                <p x-show="therapist.type30['BioTextParagraph'+i]"
                                    x-text="therapist.type30['BioTextParagraph'+i]"></p>
                            </template>
                        </div>

                    </div>

                </div>

                <div class="mt-6 text-right">
                    <button @click="closeModal" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-lg text-sm">
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

                therapist: {
                    user: {},
                    type30: {}
                },

                async openBioModal(userAttributes, type30) {
                    this.isModalOpen = true;
                    this.loading = false;

                    this.therapist = {
                        user: userAttributes,
                        type30: type30
                    };
                },

                closeModal() {
                    this.isModalOpen = false;
                }
            }
        }
    </script>

</x-app1>