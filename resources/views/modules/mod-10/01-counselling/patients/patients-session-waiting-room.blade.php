<x-app1>
    <div x-data="patientWaitingRoom(@js($session))" x-init="init()" class="bg-white border rounded-b-lg p-4 space-y-4">
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <div class="bg-white border rounded-xl p-5 space-y-5">
            <div class="border rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4 w-full md:w-1/3">
                    <img :src="`/storage/bio_images/${session.bio_photo}.jpg`"
                        onerror="this.src='/images/avatar1.jfif'"
                        class="w-10 h-10 rounded-full object-cover"
                        alt="Therapist">

                    <div>
                        <p class="font-semibold text-gray-800" x-text="session.therapist_name"></p>
                        <p class="text-gray-400" x-text="session.city"></p>
                        <p class="text-gray-400" x-text="session.country"></p>
                        <button type="button"
                            @click="openBioModal(session.therapist_user_attributes, session.therapist_type30)"
                            class="inline-block mt-2 text-sm px-4 py-1 border border-teal-400 rounded-full text-teal-600 hover:bg-teal-50">
                            View BIO
                        </button>
                    </div>
                </div>

                <div class="w-full md:w-1/3 border-l md:pl-6 text-sm text-gray-600">
                    <p class="font-semibold text-lg text-gray-800">Session Details</p>
                    <p><strong>Type:</strong> <span x-text="session.media"></span></p>
                    <p><strong>Date:</strong> <span x-text="session.date"></span></p>
                    <p><strong>Start:</strong> <span x-text="session.start"></span></p>
                    <p><strong>Duration:</strong> <span x-text="session.duration"></span> mins</p>
                </div>

                <div class="w-full md:w-1/4 text-center">
                    <template x-if="session.session_started && session.join_url">
                        <a :href="session.join_url"
                            class="inline-block w-full bg-green-600 text-white font-semibold py-3 rounded-full hover:bg-green-700">
                            Session Opened
                        </a>
                    </template>

                    <template x-if="!session.session_started || !session.join_url">
                        <button type="button" disabled
                            class="inline-block w-full bg-gray-200 text-gray-400 font-semibold py-3 rounded-full cursor-not-allowed">
                            Session Opened
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div x-show="isBioModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeBioModal">
            <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-2xl p-6 shadow-xl overflow-y-auto max-h-[90vh]"
                @click.stop>

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                        <span x-text="therapist.user.FirstName"></span>
                        <span x-text="therapist.user.LastName"></span>
                    </h2>

                    <button @click="closeBioModal" class="text-gray-500 text-xl">×</button>
                </div>

                <div class="space-y-3 text-sm text-gray-700 dark:text-gray-200">
                    <div>
                        <strong>Location:</strong>
                        <p class="text-sm text-gray-500 mb-4">
                            <span x-text="therapist.user.BaseCity"></span>,
                            <span x-text="therapist.user.BaseState"></span>,
                            <span x-text="therapist.user.BaseCountry"></span>
                        </p>

                        <p><strong>Preferred Salutation:</strong>
                            <span x-text="therapist.user.PreferredSalutation || therapist.type30.PreferredSalutation"></span>
                        </p>

                        <p><strong>Primary Language:</strong>
                            <span x-text="therapist.user.LanguagePrimary || therapist.type30.LanguagePrimary"></span>
                        </p>

                        <p><strong>Secondary Language:</strong>
                            <span x-text="therapist.user.LanguageSecondary || therapist.type30.LanguageSecondary"></span>
                        </p>
                    </div>

                    <h3 class="text-lg font-semibold mb-3">Therapy Services</h3>

                    <div class="space-y-3">
                        <template x-for="i in [1,2,3,4,5]">
                            <div x-show="therapist.type30['TherapyType'+i]" class="border rounded-lg p-3 bg-gray-50 dark:bg-gray-900">
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
                    <div class="space-y-3 text-sm text-gray-700 dark:text-gray-200">
                        <template x-for="i in [1,2,3,4,5,6]">
                            <p x-show="therapist.type30['BioTextParagraph'+i]"
                                x-text="therapist.type30['BioTextParagraph'+i]"></p>
                        </template>
                    </div>
                </div>

                <div class="mt-6 text-right">
                    <button @click="closeBioModal" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-lg text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function patientWaitingRoom(initialSession) {
            return {
                session: initialSession,
                poller: null,
                isBioModalOpen: false,
                therapist: {
                    user: {},
                    type30: {}
                },

                init() {
                    this.poller = setInterval(() => this.refreshSession(), 5000);
                    this.refreshSession();
                },

                async refreshSession() {
                    try {
                        const res = await fetch('/patient/sessions/poll');
                        const sessions = await res.json();
                        const updated = sessions.find(item => Number(item.id) === Number(this.session.id));

                        if (updated) {
                            this.session = {
                                ...this.session,
                                ...updated
                            };
                        }
                    } catch (error) {
                        console.error('Unable to refresh waiting room session.', error);
                    }
                },

                openBioModal(userAttributes, type30) {
                    this.therapist = {
                        user: userAttributes || {},
                        type30: type30 || {}
                    };
                    this.isBioModalOpen = true;
                },

                closeBioModal() {
                    this.isBioModalOpen = false;
                }
            }
        }
    </script>
</x-app1>
