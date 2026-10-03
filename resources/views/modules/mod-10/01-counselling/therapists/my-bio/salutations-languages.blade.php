<x-app1>
    <div x-data="salutationLangEditor()" class="space-y-6">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 flex items-center justify-between gap-3 text-emerald-800 dark:text-emerald-200 shadow-2xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/60 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/60 flex items-center gap-3 text-blue-800 dark:text-blue-200 shadow-2xs">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs sm:text-sm font-semibold">{{ session('info') }}</span>
            </div>
        @endif

        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <!-- Add button if no data -->
                <template x-if="!hasData()">
                    <button @click="openAddModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Salutations & Languages</span>
                    </button>
                </template>

                <!-- Delete All button if data exists -->
                <template x-if="hasData()">
                    <form method="POST" action="{{ route('my-bio-salutationsLanguages.delete') }}"
                          onsubmit="return confirm('Are you sure you want to clear your salutation and language settings?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Clear All</span>
                        </button>
                    </form>
                </template>
            </div>
        </div>

        <!-- Data Display (When data exists) -->
        <template x-if="hasData()">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- Setting Card 1: Preferred Salutation -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-xs"
                                 style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20">
                                Salutation
                            </span>
                        </div>

                        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Preferred Salutation</h3>
                        <div class="mt-2 flex items-baseline gap-2">
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100"
                               x-text="salutationData.PreferredSalutation || '—'"></p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            Formal title used in client communication and bookings.
                        </p>
                    </div>

                    <div class="pt-5 mt-4 border-t border-gray-100 dark:border-gray-700/70">
                        <button @click="openEditModal('PreferredSalutation')"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Edit Salutation</span>
                        </button>
                    </div>
                </div>

                <!-- Setting Card 2: Primary Language -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300">
                                Primary
                            </span>
                        </div>

                        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Primary Language</h3>
                        <div class="mt-2 flex items-baseline gap-2">
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100"
                               x-text="salutationData.LanguagePrimary || '—'"></p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            Main language used during consultations and notes.
                        </p>
                    </div>

                    <div class="pt-5 mt-4 border-t border-gray-100 dark:border-gray-700/70">
                        <button @click="openEditModal('LanguagePrimary')"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Edit Primary Language</span>
                        </button>
                    </div>
                </div>

                <!-- Setting Card 3: Secondary Language -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300">
                                Secondary
                            </span>
                        </div>

                        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Secondary Language</h3>
                        <div class="mt-2 flex items-baseline gap-2">
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100"
                               x-text="salutationData.LanguageSecondary || 'None'"></p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            Additional spoken language for multilingual matching.
                        </p>
                    </div>

                    <div class="pt-5 mt-4 border-t border-gray-100 dark:border-gray-700/70">
                        <button @click="openEditModal('LanguageSecondary')"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Edit Secondary Language</span>
                        </button>
                    </div>
                </div>

            </div>
        </template>

        <!-- Empty State (When no data exists) -->
        <template x-if="!hasData()">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                <div class="w-20 h-20 mx-auto mb-4 rounded-3xl flex items-center justify-center text-white shadow-lg"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Set Salutations & Languages</h3>
                <p class="text-xs sm:text-sm text-gray-400 mt-2 max-w-md mx-auto">
                    Define how clients should address you and specify the languages you offer for therapy sessions.
                </p>
                <div class="mt-6">
                    <button @click="openAddModal()"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Salutations & Languages</span>
                    </button>
                </div>
            </div>
        </template>

        <!-- Add Modal -->
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div @click.away="showAddModal = false"
                class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-y-auto max-h-[90vh]"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Add Salutations & Languages</h3>
                            <p class="text-xs text-gray-400">Configure your title and spoken languages</p>
                        </div>
                    </div>
                    <button @click="showAddModal = false" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('my-bio-salutationsLanguages.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Preferred Salutation</label>
                        <input type="text" name="PreferredSalutation"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                            placeholder="e.g. Dr., Mr., Ms., Prof.">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Primary Language</label>
                        <select name="LanguagePrimary"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="">Select a language</option>
                            <option value="English">English</option>
                            <option value="Spanish">Spanish</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Mandarin">Mandarin</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Secondary Language (Optional)</label>
                        <select name="LanguageSecondary"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="">Select a language</option>
                            <option value="English">English</option>
                            <option value="Spanish">Spanish</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Mandarin">Mandarin</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="showAddModal = false"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Save Settings</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Field Modal -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div @click.away="closeEditModal"
                class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-y-auto max-h-[80vh]"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/40 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100" x-text="'Edit ' + fieldLabel()"></h3>
                    </div>
                    <button @click="closeEditModal" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="saveField" class="space-y-4">
                    <input type="hidden" name="field" :value="editField">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5" x-text="fieldLabel()"></label>

                        <template x-if="editField === 'PreferredSalutation'">
                            <input type="text" x-model="editValue"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                placeholder="e.g. Dr., Mr., Ms., Prof." />
                        </template>

                        <template x-if="editField !== 'PreferredSalutation'">
                            <select x-model="editValue"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                                <option value="">Select a language</option>
                                <template x-for="lang in languageOptions" :key="lang">
                                    <option :value="lang" x-text="lang"></option>
                                </template>
                            </select>
                        </template>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="closeEditModal"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function salutationLangEditor() {
            return {
                salutationData: @json($salutang ?? []),
                languageOptions: ['English', 'Spanish', 'French', 'German', 'Arabic', 'Hindi', 'Mandarin', 'Other'],
                showAddModal: false,
                showEditModal: false,
                editField: '',
                editValue: '',

                hasData() {
                    const d = this.salutationData || {};
                    return Boolean(d.PreferredSalutation || d.LanguagePrimary || d.LanguageSecondary);
                },

                openAddModal() {
                    this.showAddModal = true;
                },

                openEditModal(field) {
                    this.editField = field;
                    this.editValue = (this.salutationData && this.salutationData[field]) ? this.salutationData[field] : '';
                    this.showEditModal = true;
                },

                closeEditModal() {
                    this.showEditModal = false;
                    this.editField = '';
                    this.editValue = '';
                },

                fieldLabel() {
                    const labels = {
                        PreferredSalutation: 'Preferred Salutation',
                        LanguagePrimary: 'Primary Language',
                        LanguageSecondary: 'Secondary Language'
                    };
                    return labels[this.editField] || '';
                },

                async saveField() {
                    try {
                        const res = await fetch('{{ route('my-bio-salutationsLanguages.update') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                field: this.editField,
                                value: this.editValue,
                            }),
                        });

                        const data = await res.json();
                        if (data.success) {
                            if (!this.salutationData) this.salutationData = {};
                            this.salutationData[this.editField] = this.editValue;
                            this.closeEditModal();
                        } else {
                            alert(data.message || 'Update failed');
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Server error.');
                    }
                }
            };
        }
    </script>
</x-app1>