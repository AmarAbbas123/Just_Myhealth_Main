<x-app1>
    <div x-data="salutationLangEditor()" class="space-y-6">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- Add button if no data -->
        <template x-if="!hasData()">
            <button @click="openAddModal()"
                class="px-3 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                + Add Salutations & Languages
            </button>
        </template>

        <!-- Data Display -->
        <template x-if="hasData()">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-4">
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Preferred Salutation</h2>
                        <p class="text-gray-800 dark:text-gray-300" x-text="salutationData.PreferredSalutation || '—'">
                        </p>
                    </div>
                    <button @click="openEditModal('PreferredSalutation')"
                        class="px-3 py-1 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">✏️
                        Edit</button>
                </div>

                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Primary Language</h2>
                        <p class="text-gray-800 dark:text-gray-300" x-text="salutationData.LanguagePrimary || '—'"></p>
                    </div>
                    <button @click="openEditModal('LanguagePrimary')"
                        class="px-3 py-1 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">✏️
                        Edit</button>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Secondary Language</h2>
                        <p class="text-gray-800 dark:text-gray-300" x-text="salutationData.LanguageSecondary || '—'">
                        </p>
                    </div>
                    <button @click="openEditModal('LanguageSecondary')"
                        class="px-3 py-1 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">✏️
                        Edit</button>
                </div>

                <div class="pt-4 text-right dark:border-gray-700">
                    <form method="POST" action="{{ route('my-bio-salutationsLanguages.delete') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-2 bg-red-600 text-white rounded-lg font-medium shadow hover:bg-red-700 transition">
                            🗑️ Delete All
                        </button>
                    </form>
                </div>
            </div>
        </template>

        <!-- Add Modal -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-transition>
            <div
                class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-2xl shadow-xl relative overflow-y-auto max-h-[90vh]">
                <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Add Salutations & Languages</h2>
                <form method="POST" action="{{ route('my-bio-salutationsLanguages.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-gray-600">Preferred Salutation</label>
                        <input type="text" name="PreferredSalutation"
                            class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2 dark:bg-gray-900"
                            placeholder="e.g. Mr., Dr., Ms.">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Primary Language</label>
                        <input type="text" name="LanguagePrimary"
                            class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2 dark:bg-gray-900"
                            placeholder="e.g. English">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Secondary Language</label>
                        <input type="text" name="LanguageSecondary"
                            class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2 dark:bg-gray-900"
                            placeholder="e.g. Urdu">
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" @click="showAddModal = false"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                            Cancel</button>
                        <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            x-transition>
            <div
                class="bg-white w-full max-w-sm p-6 rounded-2xl shadow-xl relative overflow-y-auto max-h-[80vh] dark:bg-gray-800">
                <h2 class="text-lg font-semibold mb-4 dark:text-white" x-text="'Edit ' + fieldLabel()"></h2>

                <form @submit.prevent="saveField">
                    <input type="hidden" name="field" :value="editField">
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-600 dark:text-white" x-text="fieldLabel()"></label>
                        <input type="text" x-model="editValue"
                            class="w-full border rounded-lg p-2 mt-1 dark:bg-gray-600 dark:text-gray-300" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeEditModal"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                            Cancel</button>
                        <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function salutationLangEditor() {
            return {
                salutationData: @json($salutang),
                showAddModal: false,
                showEditModal: false,
                editField: '',
                editValue: '',

                hasData() {
                    const d = this.salutationData || {};
                    return d.PreferredSalutation || d.LanguagePrimary || d.LanguageSecondary;
                },

                openAddModal() {
                    this.showAddModal = true;
                },

                openEditModal(field) {
                    this.editField = field;
                    this.editValue = this.salutationData[field] || '';
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
