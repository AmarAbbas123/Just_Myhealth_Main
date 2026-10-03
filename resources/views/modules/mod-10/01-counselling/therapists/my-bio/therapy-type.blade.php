<x-app1>
    <div class="space-y-6" x-data="therapyManager()">

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

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex items-center gap-3 text-rose-800 dark:text-rose-200 shadow-2xs">
                <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header -->
        <x-page-header />

        <!-- Actions / Counter Row (Below Header) -->
        <div class="flex items-center justify-end gap-3 flex-wrap">
            <!-- Specialisation Counter Badge -->
            <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                <span x-text="therapies.length + ' / 8 Modalities Added'"></span>
            </span>

            <!-- Add Button -->
            <button @click="openModal('add')" x-show="therapies.length < 8"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add Therapy Type</span>
            </button>
        </div>

        <!-- Therapy Cards List (Single Column) -->
        <div x-show="therapies.length > 0" class="space-y-3.5">
            <template x-for="(therapy, index) in therapies" :key="therapy.index">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                    <!-- Left: Icon & Info -->
                    <div class="flex items-center gap-4 min-w-0">
                        <!-- Icon Squircle -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base break-words" x-text="therapy.type"></h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 dark:bg-gray-700/60 dark:text-gray-400"
                                      x-text="'Slot #' + therapy.index">
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="therapy.years + (therapy.years === '1.0' || therapy.years === '1' ? ' Year Experience' : ' Years Experience')"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-2 self-end sm:self-center shrink-0 pt-2 sm:pt-0">
                        <button @click="openModal('edit', index)" title="Edit Therapy Type"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-50 dark:bg-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Edit</span>
                        </button>

                        <form action="{{ route('therap.profile.therapytypes.delete') }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this therapy type?');" class="inline">
                            @csrf
                            <input type="hidden" name="Index" :value="therapy.index">
                            <button type="submit" title="Delete Therapy Type"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State (When no therapy types are configured) -->
        <div x-show="therapies.length === 0" class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="w-20 h-20 mx-auto mb-4 rounded-3xl flex items-center justify-center text-white shadow-lg"
                 style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">No Therapy Types Added Yet</h3>
            <p class="text-xs sm:text-sm text-gray-400 mt-2 max-w-md mx-auto">
                Add the clinical modalities and therapy approaches you specialize in. You can specify up to 8 therapy types along with your years of experience.
            </p>
            <div class="mt-6">
                <button @click="openModal('add')"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add First Therapy Type</span>
                </button>
            </div>
        </div>

        <!-- Add / Edit Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div @click.away="closeModal()"
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-y-auto max-h-[90vh]"
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100"
                                x-text="modalType === 'add' ? 'Add Therapy Specialisation' : 'Edit Therapy Specialisation'">
                            </h3>
                            <p class="text-xs text-gray-400">Select modality and practice experience</p>
                        </div>
                    </div>
                    <button @click="closeModal()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form :action="modalType === 'add' ? '{{ route('therap.profile.therapytypes.store') }}' : '{{ route('therap.profile.therapytypes.update') }}'"
                      method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="Index" x-model="editIndex">

                    <!-- Therapy Type Select -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Therapy Modality <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="TherapyType" x-model="form.type" required
                                class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                                <option value="">Select a therapy modality</option>
                                <template x-for="type in availableTypes()" :key="type">
                                    <option :value="type" x-text="type" :selected="form.type === type"></option>
                                </template>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Select -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Years of Experience <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="TherapyYearsExperience" x-model="form.years" required
                                class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                                <option value="">Select years of experience</option>
                                <template x-for="year in ['0.5','1.0','1.5','2.0','3.0','4.0','5.0','6.0','7.0','8.0','9.0','10+']" :key="year">
                                    <option :value="year" x-text="year + (year === '1.0' ? ' Year' : ' Years')" :selected="form.years === year"></option>
                                </template>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-text="modalType === 'add' ? 'Add Specialisation' : 'Save Changes'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function therapyManager() {
            return {
                therapies: @json($therapySets),
                showModal: false,
                modalType: 'add',
                editIndex: null,
                form: {
                    type: '',
                    years: ''
                },

                openModal(type, index = null) {
                    this.modalType = type;
                    this.showModal = true;

                    if (type === 'edit' && index !== null) {
                        this.editIndex = this.therapies[index].index;
                        this.form.type = this.therapies[index].type;
                        this.form.years = this.therapies[index].years;
                        this.$nextTick(() => {});
                    } else {
                        this.editIndex = null;
                        this.form.type = '';
                        this.form.years = '';
                    }
                },

                closeModal() {
                    this.showModal = false;
                },

                availableTypes() {
                    const allTypes = [
                        'Cognitive Behavioral Therapy',
                        'Gestalt Therapy',
                        'Humanistic Therapy',
                        'Integrative Therapy',
                        'Mindfulness-Based Therapy',
                        'Narrative Therapy',
                        'Person-Centred Therapy',
                        'Psychodynamic Therapy',
                        'Solution-Focused Therapy',
                        'Transactional Analysis'
                    ];
                    const selected = this.therapies.map(t => t.type);
                    return allTypes.filter(t => !selected.includes(t) || t === this.form.type);
                },

                routeDelete(index) {
                    return '{{ route('therap.profile.therapytypes.delete') }}';
                }
            };
        }
    </script>
</x-app1>
