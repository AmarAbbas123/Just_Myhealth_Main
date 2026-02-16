<x-app1>
    @php
        $hasBioData = false;
        if ($bio) {
            foreach (
                [
                    'BioPhotoPath',
                    'BioBackgroundPhotoPath',
                    'BioTextParagraph1',
                    'BioTextParagraph2',
                    'BioTextParagraph3',
                    'BioTextParagraph4',
                    'BioTextParagraph5',
                    'BioTextParagraph6',
                ]
                as $f
            ) {
                if (!empty($bio->{$f})) {
                    $hasBioData = true;
                    break;
                }
            }

            if (!$hasBioData) {
                $bio = null;
            } else {
                if (!empty($bio->BioPhotoPath)) {
                    $bio->BioPhotoPath = asset(
                        'storage/' . ltrim(str_replace('storage/', '', $bio->BioPhotoPath), '/'),
                    );
                }
                if (!empty($bio->BioBackgroundPhotoPath)) {
                    $bio->BioBackgroundPhotoPath = asset(
                        'storage/' . ltrim(str_replace('storage/', '', $bio->BioBackgroundPhotoPath), '/'),
                    );
                }
            }
        }
    @endphp

    <div class="container mt-3 mx-auto" x-data="bioApp(@js($bio), {
        storeUrl: '{{ route('my-bio-details.store') }}',
        updateUrl: '{{ route('my-bio-details.update') }}',
        deleteUrl: '{{ route('my-bio-details.delete') }}'
    })">

        {{-- Toast --}}
        <div x-data="{
            show: false,
            message: '',
            type: 'success',
            init() {
                window.addEventListener('notify', e => {
                    this.message = e.detail.message;
                    this.type = e.detail.type || 'success';
                    this.show = true;
                    setTimeout(() => this.show = false, 2500);
                });
            }
        }" x-show="show" x-cloak
            :class="type === 'success' ? 'bg-green-100 border border-green-400 text-green-800' :
                'bg-red-100 border border-red-400 text-red-800'"
            class="fixed top-5 right-5 z-50 px-4 py-2 rounded-lg shadow-lg transition">
            <span x-text="message"></span>
        </div>

        <!-- Header -->
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <x-page-header />

            <!-- Add button shown only when there is no data -->
            <template x-if="!hasData()" x-cloak>
                <button @click="openAddModal()"
                    class="px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    + Add Bio Details
                </button>
            </template>
        </div>

        <!-- Display Bio Info -->
        <div x-show="hasData()" x-cloak class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Photos -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm">

                <div class="flex flex-col gap-8"><!-- Stack as rows -->

                    <!-- Profile Photo (Row 1) -->
                    <div class="space-y-3" data-image-wrapper>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Profile Photo
                            </label>

                            <button @click.stop="openInlineEditImage($event, 'BioPhotoPath')"
                                class="px-3 py-1 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">
                                ✏️ Edit
                            </button>
                        </div>

                        <template x-if="bio && bio.BioPhotoPath">
                            <img :src="bio.BioPhotoPath" alt="Profile Photo"
                                class="w-28 h-28 rounded-full object-cover border border-gray-300 dark:border-gray-600
                           hover:scale-105 transition-transform">
                        </template>

                        <template x-if="!(bio && bio.BioPhotoPath)">
                            <img src="{{ asset('images/avatar-placeholder.png') }}" alt="Profile Photo"
                                class="w-28 h-28 rounded-full object-cover border border-gray-300 dark:border-gray-600">
                        </template>
                    </div>

                    <!-- Background Photo (Row 2) -->
                    <div class="space-y-3" data-image-wrapper>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Background Photo
                            </label>

                            <button @click.stop="openInlineEditImage($event, 'BioBackgroundPhotoPath')"
                                class="px-3 py-1 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">
                                ✏️ Edit
                            </button>
                        </div>

                        <template x-if="bio && bio.BioBackgroundPhotoPath">
                            <img :src="bio.BioBackgroundPhotoPath" alt="Background Photo"
                                class="w-full h-32 object-cover rounded-md border border-gray-300 dark:border-gray-600
                           hover:scale-105 transition-transform">
                        </template>

                        <template x-if="!(bio && bio.BioBackgroundPhotoPath)">
                            <div
                                class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center 
                            text-gray-400">
                                No background
                            </div>
                        </template>
                    </div>

                </div>
            </div>


            <!-- Right Column: Bio Paragraphs -->
            <div class="lg:col-span-2 space-y-6 bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                <div class="flex justify-end border-b border-gray-200 dark:border-gray-700 pb-4">
                    <button @click="deleteAll()"
                        class="px-3 py-2 bg-red-600 text-white rounded-lg font-medium shadow hover:bg-red-700 transition">
                        🗑️ Delete All
                    </button>
                </div>
                <template x-for="(paragraph, index) in paragraphs()" :key="index">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-sm text-gray-500">BIO Paragraph <span x-text="index + 1"></span></label>
                            <button @click="openEditParagraph(index)"
                                class="px-3 py-1 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition">✏️
                                Edit</button>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-snug" x-text="paragraph"></p>
                    </div>
                </template>
            </div>
        </div>

        <!-- Add Modal (centered, constrained height) -->
        <div x-show="addModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
            <div @click.away="closeAddModal()"
                class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-xl max-h-[90vh] overflow-y-auto shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Add BIO Details</h3>
                    <button @click="closeAddModal()" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>

                <form x-ref="addForm" @submit.prevent="submitAddForm" class="space-y-4" enctype="multipart/form-data">
                    <div>
                        <label class="text-sm text-gray-500">Profile Photo</label>
                        <input type="file" name="BioPhotoPath" accept="image/*" class="mt-1 block w-full text-sm">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Background Photo</label>
                        <input type="file" name="BioBackgroundPhotoPath" accept="image/*"
                            class="mt-1 block w-full text-sm">
                    </div>

                    <template x-for="i in 6" :key="i">
                        <div>
                            <label class="text-sm text-gray-500">BIO Paragraph <span x-text="i"></span></label>
                            <textarea :name="'BioTextParagraph' + i" rows="2" class="mt-1 block w-full rounded-md border-gray-200 px-3 py-2"></textarea>
                        </div>
                    </template>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" @click="closeAddModal()"
                            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                            Cancel</button>
                        <button type="submit"
                            class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Paragraph Modal -->
        <div x-show="editModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div @click.away="closeEdit()" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100" x-text="editTitle"></h3>
                    <button @click="closeEdit()" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>
                <textarea rows="4" x-model="editValue" class="w-full rounded-md border-gray-200 px-3 py-2"></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button @click="closeEdit()"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                        Cancel</button>
                    <button @click="saveEdit()" class="px-3 py-2 bg-green-600 text-white rounded-md">Save</button>
                </div>
            </div>
        </div>

        <!-- Inline Image Popup (positioned near image) -->
        <div x-show="inlineImage.editing" x-cloak
            :style="`position:absolute; top: ${inlineImage.y}px; left: ${inlineImage.x}px;`"
            class="bg-white rounded-lg shadow p-3 z-50 w-56 border" x-ref="inlinePopup">
            <form x-ref="inlineImageForm" class="space-y-2" enctype="multipart/form-data">
                <input type="file" name="value" accept="image/*" @change="inlineImagePreview($event)"
                    class="block text-sm w-full" />
                <template x-if="inlineImage.preview">
                    <img :src="inlineImage.preview" class="h-20 w-20 object-cover rounded-md" />
                </template>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="cancelInlineImage()"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌
                        Cancel</button>
                    <button type="button" @click.prevent="submitInlineImage()"
                        class="px-3 py-1 bg-green-600 text-white rounded text-sm">Save</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('bioUpdater', {
                async postData(url, data) {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: data
                    });
                    const text = await response.text();
                    const idx = text.indexOf('{');
                    try {
                        return idx !== -1 ? JSON.parse(text.slice(idx)) : {
                            success: false,
                            message: 'Invalid JSON'
                        };
                    } catch (e) {
                        return {
                            success: false,
                            message: 'Invalid JSON'
                        };
                    }
                }
            });

            Alpine.data('bioApp', (initialBio, urls) => ({
                bio: initialBio || null,
                addModal: false,
                editModal: false,
                editTitle: '',
                editValue: '',
                currentIndex: null,

                inlineImage: {
                    editing: false,
                    field: null,
                    preview: null,
                    x: 0,
                    y: 0
                },

                storeUrl: urls.storeUrl,
                updateUrl: urls.updateUrl,
                deleteUrl: urls.deleteUrl,

                hasData() {
                    if (!this.bio) return false;
                    return Boolean(
                        this.bio.BioPhotoPath ||
                        this.bio.BioBackgroundPhotoPath ||
                        this.bio.BioTextParagraph1 ||
                        this.bio.BioTextParagraph2 ||
                        this.bio.BioTextParagraph3 ||
                        this.bio.BioTextParagraph4 ||
                        this.bio.BioTextParagraph5 ||
                        this.bio.BioTextParagraph6
                    );
                },

                paragraphs() {
                    if (!this.bio) return [];
                    const arr = [];
                    for (let i = 1; i <= 6; i++) {
                        const v = this.bio['BioTextParagraph' + i] || '';
                        if (v && v.trim() !== '') arr.push(v);
                    }
                    return arr;
                },

                // Add modal
                openAddModal() {
                    this.addModal = true;
                },
                closeAddModal() {
                    this.addModal = false;
                    // reset file inputs in form if needed
                    if (this.$refs.addForm) this.$refs.addForm.reset();
                },
                async submitAddForm() {
                    const fd = new FormData(this.$refs.addForm);
                    const res = await Alpine.store('bioUpdater').postData(this.storeUrl, fd);

                    if (res.success && res.bio) {
                        // Fix: always use fresh URLs from backend
                        const cacheBuster = `?v=${Date.now()}`;
                        const safeUrl = (url) => url ? `/storage/${url}${cacheBuster}` : null;

                        // Assign URLs first
                        res.bio.BioPhotoPath = safeUrl(res.bio.BioPhotoPath);
                        res.bio.BioBackgroundPhotoPath = safeUrl(res.bio.BioBackgroundPhotoPath);

                        // Trigger Alpine reactivity properly
                        this.bio = null;
                        this.$nextTick(() => {
                            this.bio = res.bio;
                        });

                        // Close modal and notify
                        this.closeAddModal();
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: res.message || 'BIO saved successfully!',
                                type: 'success'
                            }
                        }));
                    } else {
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: res.message || 'Save failed',
                                type: 'error'
                            }
                        }));
                    }
                },

                // Inline image popup near the image wrapper
                openInlineEditImage(event, field) {
                    // find closest wrapper (we used data-image-wrapper on each image container)
                    const wrapper = event.target.closest('[data-image-wrapper]') || event.target;
                    const rect = wrapper.getBoundingClientRect();
                    // position popup right of wrapper if space, else below wrapper
                    const margin = 8;
                    const popupWidth = 220; // rough width
                    let x = rect.left + margin + window.scrollX;
                    let y = rect.top + window.scrollY;
                    // if not enough space on right, show left-aligned to wrapper left
                    if ((x + popupWidth) > (window.scrollX + window.innerWidth)) {
                        x = rect.left + window.scrollX;
                        y = rect.bottom + margin + window.scrollY;
                    }
                    this.inlineImage.editing = true;
                    this.inlineImage.field = field;
                    this.inlineImage.preview = null;
                    this.inlineImage.x = Math.round(x);
                    this.inlineImage.y = Math.round(y);
                    // clear previous file input if exists
                    if (this.$refs.inlineImageForm) this.$refs.inlineImageForm.reset?.();
                },
                inlineImagePreview(e) {
                    const f = e.target.files?.[0];
                    if (f) {
                        this.inlineImage.preview = URL.createObjectURL(f);
                    }
                },
                cancelInlineImage() {
                    this.inlineImage.editing = false;
                    this.inlineImage.preview = null;
                    this.inlineImage.field = null;
                },
                async submitInlineImage() {
                    // FormData from inline form
                    const fd = new FormData(this.$refs.inlineImageForm);
                    fd.append('field', this.inlineImage.field);
                    const res = await Alpine.store('bioUpdater').postData(this.updateUrl, fd);
                    if (res.success) {
                        // server may return newPath or full bio
                        if (res.newPath) {
                            const newPath = `/storage/${res.newPath}?v=${Date.now()}`;
                            if (!this.bio) this.bio = {};
                            this.bio[this.inlineImage.field] = newPath;
                        } else if (res.bio) {
                            console.log('Bio Response:', res.bio);

                            // Force refresh of images immediately
                            this.bio = res.bio;
                            if (this.bio.BioPhotoPath) this.bio.BioPhotoPath += `?v=${Date.now()}`;
                            if (this.bio.BioBackgroundPhotoPath) this.bio.BioBackgroundPhotoPath +=
                                `?v=${Date.now()}`;
                        }

                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: res.message || 'Image updated',
                                type: 'success'
                            }
                        }));
                    } else {
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: res.message || 'Upload failed',
                                type: 'error'
                            }
                        }));
                    }
                    this.cancelInlineImage();
                },

                // paragraph editing
                openEditParagraph(index) {
                    this.editModal = true;
                    this.editTitle = 'Edit Bio Paragraph ' + (index + 1);
                    this.editValue = (this.bio && this.bio['BioTextParagraph' + (index + 1)]) ? this
                        .bio['BioTextParagraph' + (index + 1)] : '';
                    this.currentIndex = index;
                },
                closeEdit() {
                    this.editModal = false;
                    this.editValue = '';
                    this.currentIndex = null;
                },
                async saveEdit() {
                    if (this.currentIndex === null) return this.closeEdit();
                    const fd = new FormData();
                    const field = 'BioTextParagraph' + (this.currentIndex + 1);
                    fd.append('field', field);
                    fd.append('value', this.editValue || '');
                    const res = await Alpine.store('bioUpdater').postData(this.updateUrl, fd);
                    if (res.success) {
                        if (!this.bio) this.bio = {};
                        this.bio[field] = this.editValue;
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: res.message || 'Updated',
                                type: 'success'
                            }
                        }));
                    } else {
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: res.message || 'Update failed',
                                type: 'error'
                            }
                        }));
                    }
                    this.closeEdit();
                },

                // delete all -> set bio null so Add button appears
                async deleteAll() {
                    if (!confirm('Clear all bio details?')) return;
                    try {
                        const response = await fetch(this.deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        });
                        const text = await response.text();
                        let res = {};
                        try {
                            const idx = text.indexOf('{');
                            res = idx !== -1 ? JSON.parse(text.slice(idx)) : {
                                success: false
                            };
                        } catch (e) {
                            res = {
                                success: false
                            };
                        }

                        if (res.success) {
                            this.bio = null; // this triggers Add button to show
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: res.message || 'Deleted',
                                    type: 'success'
                                }
                            }));
                        } else {
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: res.message || 'Delete failed',
                                    type: 'error'
                                }
                            }));
                        }
                    } catch (err) {
                        console.error(err);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: 'Delete error',
                                type: 'error'
                            }
                        }));
                    }
                }
            }));
        });
    </script>
</x-app1>
