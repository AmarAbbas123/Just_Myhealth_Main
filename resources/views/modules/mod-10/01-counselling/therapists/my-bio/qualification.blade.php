<x-app1>
    <div class="space-y-6" x-data="qualificationModal()">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        @php
            $hasQualData = false;
            if ($qualf) {
                for ($i = 1; $i <= 4; $i++) {
                    if (
                        $qualf->{'QualificationTitle' . $i} ||
                        $qualf->{'QualificationLevel' . $i} ||
                        $qualf->{'QualificationFrom' . $i} ||
                        $qualf->{'QualificationGrade' . $i} ||
                        $qualf->{'QualificationDateComplete' . $i} ||
                        $qualf->{'QualificationImagePath' . $i}
                    ) {
                        $hasQualData = true;
                        break;
                    }
                }
            }
        @endphp

        {{-- ===================== TABLE VIEW ===================== --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">

            <div class="flex justify-end items-center mb-4 space-x-3">
                <button type="button" @click="openAddModal()"
                    class="px-3 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    ➕ Add
                </button>
                @if ($hasQualData)
                    <form method="POST" action="{{ route('my-bio-qualifications.delete') }}" class="inline-block">
                        @csrf @method('DELETE')
                        <button type="button" @click="openDeleteModal()"
                            class="px-3 py-2 bg-red-600 text-white rounded-lg font-medium shadow hover:bg-red-700 transition">
                            🗑️ Delete All
                        </button>
                    </form>
                @endif
            </div>

            @if ($hasQualData)
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Level</th>
                                <th class="px-4 py-2 text-left">From</th>
                                <th class="px-4 py-2 text-left">Grade</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Image</th>
                                <th class="px-4 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 4; $i++)
                                @if (
                                    $qualf->{'QualificationTitle' . $i} ||
                                        $qualf->{'QualificationLevel' . $i} ||
                                        $qualf->{'QualificationFrom' . $i} ||
                                        $qualf->{'QualificationGrade' . $i} ||
                                        $qualf->{'QualificationDateComplete' . $i} ||
                                        $qualf->{'QualificationImagePath' . $i})
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $qualf->{'QualificationTitle' . $i} }}</td>
                                        <td class="px-4 py-2">{{ $qualf->{'QualificationLevel' . $i} }}</td>
                                        <td class="px-4 py-2">{{ $qualf->{'QualificationFrom' . $i} }}</td>
                                        <td class="px-4 py-2">{{ $qualf->{'QualificationGrade' . $i} }}</td>
                                        <td class="px-4 py-2">{{ $qualf->{'QualificationDateComplete' . $i} }}</td>
                                        <td class="px-4 py-2">
                                            @if ($qualf->{'QualificationImagePath' . $i})
                                                @if ($qualf->{'QualificationImagePath' . $i})
                                                    <a href="{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $qualf->{'QualificationImagePath' . $i}) }}"
                                                            class="w-16 h-16 object-cover rounded border cursor-pointer hover:scale-105 transition">
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button @click="openEditModal({{ $i }})"
                                                class="px-3 py-1 bg-amber-600 text-white rounded shadow hover:bg-amber-700">
                                                ✏️ Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No qualifications saved yet.</p>
            @endif
        </div>

        {{-- ===================== ADD / EDIT MODAL ===================== --}}
        <div x-show="showModal" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="closeModal"
                class="bg-white dark:bg-gray-800 w-full max-w-3xl p-6 rounded-2xl shadow-xl overflow-y-auto max-h-[90vh]">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4"
                    x-text="modalMode === 'add' ? 'Add Qualifications' : 'Edit Qualification ' + editIndex"></h2>

                <form
                    :action="modalMode === 'add' ? '{{ route('my-bio-qualifications.store') }}' :
                        '{{ route('my-bio-qualifications.update') }}'"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                                <input :id="'QualificationTitle' + currentIndex"
                                    :name="'QualificationTitle' + currentIndex" type="text"
                                    class="w-full mb-3 border-gray-300 rounded-md" placeholder="Qualification Title"
                                    x-model="form.QualificationTitle">

                                <input :id="'QualificationLevel' + currentIndex"
                                    :name="'QualificationLevel' + currentIndex" type="text"
                                    class="w-full mb-3 border-gray-300 rounded-md" placeholder="Qualification Level"
                                    x-model="form.QualificationLevel">

                                <input :id="'QualificationFrom' + currentIndex"
                                    :name="'QualificationFrom' + currentIndex" type="text"
                                    class="w-full mb-3 border-gray-300 rounded-md" placeholder="College/University"
                                    x-model="form.QualificationFrom">

                                <input :id="'QualificationGrade' + currentIndex"
                                    :name="'QualificationGrade' + currentIndex" type="text"
                                    class="w-full mb-3 border-gray-300 rounded-md" placeholder="Grade"
                                    x-model="form.QualificationGrade">

                                <input :id="'QualificationDateComplete' + currentIndex"
                                    :name="'QualificationDateComplete' + currentIndex" type="date"
                                    class="w-full mb-3 border-gray-300 rounded-md"
                                    x-model="form.QualificationDateComplete">
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                                <input type="file" :name="'QualificationImagePath' + currentIndex" accept="image/*"
                                    class="block w-full text-sm text-gray-900 dark:text-gray-200 border border-gray-300 dark:border-gray-600 cursor-pointer rounded-md file:py-2 file:px-3 file:bg-indigo-50 dark:file:bg-gray-600 file:text-indigo-700 dark:file:text-gray-200">
                            </div>
                        </div>
                    </div>


                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" @click="closeModal"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                            Cancel
                        </button>
                        <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== DELETE MODAL ===================== --}}
        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="closeDeleteModal"
                class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-xl w-full max-w-md text-center">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
                    Confirm Deletion
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Are you sure you want to delete all qualifications? This action cannot be undone.
                </p>
                <form method="POST" action="{{ route('my-bio-qualifications.delete') }}">
                    @csrf @method('DELETE')
                    <div class="flex justify-center gap-4">
                        <button type="button" @click="closeDeleteModal"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                            Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes,
                            Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- AlpineJS State --}}
    <script>
        function qualificationModal() {
            return {
                showModal: false,
                showDeleteModal: false,
                modalMode: 'add',
                editIndex: null,
                currentIndex: 1,

                // ✅ All qualifications data from backend (PHP → JS)
                qualifications: @json($qualf),

                // Form data for currently open modal
                form: {
                    QualificationTitle: '',
                    QualificationLevel: '',
                    QualificationFrom: '',
                    QualificationGrade: '',
                    QualificationDateComplete: '',
                },

                openAddModal() {
                    this.modalMode = 'add';
                    this.currentIndex = this.getNextAvailableIndex();
                    if (this.currentIndex === null) {
                        alert("All 4 qualification slots are already filled.");
                        return;
                    }

                    // clear form
                    this.form = {
                        QualificationTitle: '',
                        QualificationLevel: '',
                        QualificationFrom: '',
                        QualificationGrade: '',
                        QualificationDateComplete: '',
                    };

                    this.showModal = true;
                },

                openEditModal(index) {
                    this.modalMode = 'edit';
                    this.currentIndex = index;
                    this.editIndex = index;

                    // ✅ Prefill data from existing qualifications
                    this.form = {
                        QualificationTitle: this.qualifications['QualificationTitle' + index] || '',
                        QualificationLevel: this.qualifications['QualificationLevel' + index] || '',
                        QualificationFrom: this.qualifications['QualificationFrom' + index] || '',
                        QualificationGrade: this.qualifications['QualificationGrade' + index] || '',
                        QualificationDateComplete: this.qualifications['QualificationDateComplete' + index] || '',
                    };

                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                    this.editIndex = null;
                },
                openDeleteModal() {
                    this.showDeleteModal = true;
                },
                closeDeleteModal() {
                    this.showDeleteModal = false;
                },

                getNextAvailableIndex() {
                    const q = this.qualifications;
                    for (let i = 1; i <= 4; i++) {
                        const title = q ? q['QualificationTitle' + i] : null;
                        const level = q ? q['QualificationLevel' + i] : null;
                        const from = q ? q['QualificationFrom' + i] : null;
                        const grade = q ? q['QualificationGrade' + i] : null;
                        const date = q ? q['QualificationDateComplete' + i] : null;
                        const image = q ? q['QualificationImagePath' + i] : null;

                        if (!title && !level && !from && !grade && !date && !image) {
                            return i;
                        }
                    }
                    return null;
                }
            }
        }
    </script>


</x-app1>
