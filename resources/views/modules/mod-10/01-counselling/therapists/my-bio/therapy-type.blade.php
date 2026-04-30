<x-app1>

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-3 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div x-data="therapyManager()">

            <!-- Therapy Cards -->
            <template x-for="(therapy, index) in therapies" :key="therapy.index">
                <div
                    class="bg-white shadow rounded-xl p-6 mb-4 border border-gray-100 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-700" x-text="therapy.type"></p>
                        <p class="text-gray-500 text-sm" x-text="therapy.years + ' Years Experience'"></p>
                    </div>
                    <div class="flex gap-2">
                        <button @click="openModal('edit', index)"
                            class="px-3 py-2 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">Edit</button>
                        <form action="{{ route('therap.profile.therapytypes.delete') }}" method="POST"
                            onsubmit="return confirm('Delete this therapy set?')">
                            @csrf
                            <input type="hidden" name="Index" :value="therapy.index">
                            <button type="submit"
                                class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </template>

            <!-- Add Button -->
            <div class="mt-4">
                <button @click="openModal('add')" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                    x-show="therapies.length < 8">
                    + Add Therapy Type
                </button>
            </div>

            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl w-full max-w-md p-6" @click.away="closeModal()">
                    <h2 class="text-lg font-semibold mb-4"
                        x-text="modalType === 'add' ? 'Add Therapy Set' : 'Edit Therapy Set'"></h2>

                    <form
                        :action="modalType === 'add' ? '{{ route('therap.profile.therapytypes.store') }}' :
                            '{{ route('therap.profile.therapytypes.update') }}'"
                        method="POST">
                        @csrf
                        <input type="hidden" name="Index" x-model="editIndex">

                        <!-- Therapy Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Therapy Type</label>
                            <select name="TherapyType" x-model="form.type" class="w-full border-gray-300 rounded-lg">
                                <option value="">Select Therapy</option>
                                <template x-for="type in availableTypes()" :key="type">
                                    <option :value="type" x-text="type" :selected="form.type === type">
                                    </option>
                                </template>
                            </select>
                        </div>

                        <!-- Experience -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Experience (Years)</label>
                            <select name="TherapyYearsExperience" x-model="form.years"
                                class="w-full border-gray-300 rounded-lg">
                                <option value="">Select Years</option>
                                <template
                                    x-for="year in ['0.5','1.0','1.5','2.0','3.0','4.0','5.0','6.0','7.0','8.0','9.0','10+']"
                                    :key="year">
                                    <option x-text="year" :value="year"></option>
                                </template>
                            </select>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="closeModal()"
                                class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                                Cancel</button>
                            <button type="submit"
                                class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                <span x-text="modalType === 'add' ? 'Add' : 'Update'"></span>
                            </button>
                        </div>
                    </form>
                </div>
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

                        // FIX: Force Alpine to re-evaluate dropdown AFTER data is set
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
                    const allTypes = ['Cognitive Behavioral Therapy', 'Gestalt Therapy',
                        'Humanistic Therapy', 'Integrative Therapy', 'Mindfulness-Based Therapy',
                         'Narrative Therapy', 'Person-Centred Therapy', 'Psychodynamic Therapy', 
                          'Solution-Focused Therapy', 'Transactional Analysis'
                    ];
                    const selected = this.therapies.map(t => t.type);
                    return allTypes.filter(t => !selected.includes(t) || t === this.form.type);
                },

                routeDelete(index) {
                    return '{{ route('therap.profile.therapytypes.delete') }}';
                }
            }
        }
    </script>

</x-app1>
