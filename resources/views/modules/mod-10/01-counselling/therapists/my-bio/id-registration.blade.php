<x-app1>
    <div x-data="idRegistration()" x-init="loadDocuments()" class="space-y-8">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- Table -->
        <div>
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-x-auto border border-gray-100 dark:border-gray-700">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="py-3 px-4">Document Type</th>
                            <th class="py-3 px-4 text-center">Proof</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="doc in documents" :key="doc.key">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                <td class="py-3 px-4" x-text="doc.doc_type"></td>
                                <td class="py-3 px-4 text-center">
                                    <template x-if="doc.document">
                                        <a :href="StorageUrl(doc.document)" target="_blank">
                                            <img :src="StorageUrl(doc.document)"
                                                class="w-12 h-12 object-cover rounded-md border mx-auto cursor-pointer">
                                        </a>

                                    </template>
                                    <template x-if="!doc.document">
                                        <span class="text-gray-400 italic">Not uploaded</span>
                                    </template>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <template x-if="!doc.document">
                                        <button @click="openModal('add', doc.key, doc.doc_type)"
                                            class="px-3 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg shadow hover:bg-teal-700 transition">⬆️
                                            Upload</button>
                                    </template>
                                    <template x-if="doc.document">
                                        <div class="space-x-3">
                                            <button @click="openModal('edit', doc.key, doc.doc_type)"
                                                class="text-indigo-600 text-sm hover:underline">Edit</button>
                                            <button @click="deleteDocument(doc.key)"
                                                class="text-red-600 text-sm hover:underline">Delete</button>
                                        </div>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="showModal" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm p-4">
            <div @click.away="showModal=false"
                class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md shadow-2xl">
                <h3 class="text-lg font-semibold mb-4" x-text="modalTitle"></h3>

                <form @submit.prevent="submitDocument">
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500">Document Type</label>
                            <input type="text" x-model="form.doc_type" readonly
                                class="w-full bg-gray-50 rounded-md border-gray-300 dark:border-gray-700 px-3 py-2">
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Upload Document (Image / PDF)</label>
                            <input type="file" @change="handleFileUpload" accept="image/*,.pdf" required
                                class="w-full text-sm text-gray-600">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showModal=false"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                            Cancel</button>
                        <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                            x-text="modalAction"></button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function idRegistration() {
            return {
                documents: [],
                showModal: false,
                modalTitle: '',
                modalAction: '',
                form: {
                    mode: '',
                    doc_key: '',
                    doc_type: '',
                    document: null
                },

                // ⭐ ADD THIS FUNCTION HERE
                StorageUrl(path) {
                    return path ? `/storage/${path}` : null;
                },

                loadDocuments() {
                    fetch("{{ route('therap.documents.fetch') }}")
                        .then(res => res.json())
                        .then(data => this.documents = data);
                },

                openModal(mode, key, type) {
                    this.form = {
                        mode,
                        doc_key: key,
                        doc_type: type,
                        document: null
                    };
                    this.modalTitle = (mode === 'add') ? 'Upload Document' : 'Update Document';
                    this.modalAction = (mode === 'add') ? 'Save' : 'Update';
                    this.showModal = true;
                },

                handleFileUpload(event) {
                    this.form.document = event.target.files[0];
                },

                submitDocument() {
                    const formData = new FormData();
                    formData.append('doc_key', this.form.doc_key);
                    formData.append('document', this.form.document);

                    const url = this.form.mode === 'add' ?
                        "{{ route('therap.documents.store') }}" :
                        "{{ route('therap.documents.update') }}";

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(() => {
                            this.showModal = false;
                            this.loadDocuments();
                        });
                },

                deleteDocument(key) {
                    if (!confirm('Are you sure you want to delete this document?')) return;

                    fetch(`/mod-10/id-documents/${key}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(() => this.loadDocuments());
                }
            };
        }
    </script>

</x-app1>
