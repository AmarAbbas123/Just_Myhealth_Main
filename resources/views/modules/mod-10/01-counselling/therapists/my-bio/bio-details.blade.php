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
                ] as $f
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

    <div class="space-y-6" x-data="bioApp(@js($bio), {
        storeUrl: '{{ route('my-bio-details.store') }}',
        updateUrl: '{{ route('my-bio-details.update') }}',
        deleteUrl: '{{ route('my-bio-details.delete') }}'
    })">

        <!-- Modern Toast Notification -->
        <div x-data="{
            show: false,
            message: '',
            type: 'success',
            init() {
                window.addEventListener('notify', e => {
                    this.message = e.detail.message;
                    this.type = e.detail.type || 'success';
                    this.show = true;
                    setTimeout(() => this.show = false, 3000);
                });
            }
        }" x-show="show" x-cloak
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            :class="type === 'success' ? 'bg-emerald-600 text-white shadow-emerald-500/20' : 'bg-rose-600 text-white shadow-rose-500/20'"
            class="fixed top-6 right-6 z-50 px-4 py-3 rounded-2xl shadow-xl flex items-center gap-2.5 text-xs sm:text-sm font-semibold max-w-sm">
            <template x-if="type === 'success'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </template>
            <template x-if="type !== 'success'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </template>
            <span x-text="message"></span>
        </div>

        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <!-- Add button shown only when there is no bio data yet -->
                <template x-if="!hasData()" x-cloak>
                    <button @click="openAddModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Bio Details</span>
                    </button>
                </template>

                <!-- Actions when data exists -->
                <template x-if="hasData()" x-cloak>
                    <div class="flex items-center gap-2">
                        <button x-show="hasAvailableParagraphSlot()" @click="addNextParagraph()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-sm hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Add Paragraph</span>
                        </button>

                        <button @click="deleteAll()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Clear All</span>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Display Bio Info (when data exists) -->
        <div x-show="hasData()" x-cloak class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Left Column: Visual Media (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Profile Photo Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]" data-image-wrapper>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700/70 mb-4">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base">Profile Portrait</h4>
                            <p class="text-xs text-gray-400">Therapist headshot avatar</p>
                        </div>
                        <button @click.stop="openInlineEditImage($event, 'BioPhotoPath')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:text-teal-300 border border-[#1C9BA0]/30 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Change</span>
                        </button>
                    </div>

                    <div class="flex flex-col items-center justify-center p-4">
                        <div class="relative group cursor-pointer" @click="openInlineEditImage($event, 'BioPhotoPath')">
                            <template x-if="bio && bio.BioPhotoPath">
                                <img :src="bio.BioPhotoPath" alt="Profile Photo"
                                    class="w-32 h-32 rounded-full object-cover ring-4 ring-offset-2 ring-[#1C9BA0]/20 dark:ring-offset-gray-800 shadow-md group-hover:scale-105 transition-all">
                            </template>
                            <template x-if="!(bio && bio.BioPhotoPath)">
                                <div class="w-32 h-32 rounded-full bg-gray-100 dark:bg-gray-700 flex flex-col items-center justify-center text-gray-400 ring-4 ring-offset-2 ring-gray-200 dark:ring-offset-gray-800">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-[11px] mt-1 font-medium">No Portrait</span>
                                </div>
                            </template>
                            <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold transition-opacity">
                                <span>Edit Photo</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 text-center mt-3 max-w-xs">
                            Recommended size: 500x500px square (JPG, PNG, max 3MB).
                        </p>
                    </div>
                </div>

                <!-- Background Cover Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]" data-image-wrapper>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700/70 mb-4">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base">Cover Banner</h4>
                            <p class="text-xs text-gray-400">Profile header background</p>
                        </div>
                        <button @click.stop="openInlineEditImage($event, 'BioBackgroundPhotoPath')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:text-teal-300 border border-[#1C9BA0]/30 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Change</span>
                        </button>
                    </div>

                    <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 shadow-2xs"
                         @click="openInlineEditImage($event, 'BioBackgroundPhotoPath')">
                        <template x-if="bio && bio.BioBackgroundPhotoPath">
                            <img :src="bio.BioBackgroundPhotoPath" alt="Background Photo"
                                class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-300">
                        </template>
                        <template x-if="!(bio && bio.BioBackgroundPhotoPath)">
                            <div class="w-full h-36 bg-gray-100 dark:bg-gray-700/60 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs mt-1 font-medium">No cover image uploaded</span>
                            </div>
                        </template>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold transition-opacity">
                            <span>Update Cover Banner</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2.5">
                        Wide landscape banner (Recommended: 1200x400px, max 5MB).
                    </p>
                </div>
            </div>

            <!-- Right Column: Narrative Paragraphs (8 cols) -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/30">
                        <div class="flex items-center gap-3">
                            <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base">Professional Story & Narrative</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20"
                                  x-text="paragraphs().length + ' / 6 sections'">
                            </span>
                        </div>
                        <template x-if="hasAvailableParagraphSlot()">
                            <button @click="addNextParagraph()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white transition-all shadow-xs hover:brightness-105 active:scale-95"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Add Section</span>
                            </button>
                        </template>
                    </div>

                    <!-- Paragraph List Items -->
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/60 p-5 space-y-4">
                        <template x-for="(paragraph, index) in paragraphs()" :key="index">
                            <div class="pt-4 first:pt-0 group">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-lg bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 text-xs font-bold flex items-center justify-center"
                                              x-text="index + 1">
                                        </span>
                                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">
                                            Paragraph <span x-text="index + 1"></span>
                                        </span>
                                    </div>
                                    <button @click="openEditParagraph(index)"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 dark:bg-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                </div>
                                <div class="bg-gray-50/70 dark:bg-gray-900/40 rounded-xl p-4 border border-gray-100 dark:border-gray-800 text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap break-words"
                                     x-text="paragraph">
                                </div>
                            </div>
                        </template>

                        <!-- Available Slots Info -->
                        <template x-if="hasAvailableParagraphSlot()">
                            <div class="pt-4 border-t border-dashed border-gray-200 dark:border-gray-700 text-center">
                                <button @click="addNextParagraph()"
                                    class="inline-flex items-center gap-2 px-4 py-2 border-2 border-dashed border-gray-300 dark:border-gray-700 hover:border-[#1C9BA0] dark:hover:border-[#1C9BA0] rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#1C9BA0] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Add Another Paragraph (<span x-text="6 - paragraphs().length"></span> slots remaining)</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State View (when no bio data exists) -->
        <div x-show="!hasData()" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="w-20 h-20 mx-auto mb-4 rounded-3xl flex items-center justify-center text-white shadow-lg"
                 style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Setup Your Therapist Bio</h3>
            <p class="text-xs sm:text-sm text-gray-400 mt-2 max-w-md mx-auto">
                Your professional bio, headshot, and narrative help prospective clients connect with your practice and expertise.
            </p>
            <div class="mt-6">
                <button @click="openAddModal()"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Create Your Bio Profile</span>
                </button>
            </div>
        </div>

        <!-- Add Bio Modal -->
        <div x-show="addModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div @click.away="closeAddModal()"
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-100 dark:border-gray-700"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Add Bio Details</h3>
                            <p class="text-xs text-gray-400">Configure your photos and introduction paragraphs</p>
                        </div>
                    </div>
                    <button @click="closeAddModal()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form x-ref="addForm" @submit.prevent="submitAddForm" class="space-y-4 mt-4" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Profile Photo</label>
                            <input type="file" name="BioPhotoPath" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1C9BA0]/10 file:text-[#1C9BA0] hover:file:bg-[#1C9BA0]/20 cursor-pointer">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Background Banner</label>
                            <input type="file" name="BioBackgroundPhotoPath" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1C9BA0]/10 file:text-[#1C9BA0] hover:file:bg-[#1C9BA0]/20 cursor-pointer">
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <template x-for="i in 6" :key="i">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">
                                    Bio Paragraph <span x-text="i"></span>
                                </label>
                                <textarea :name="'BioTextParagraph' + i" rows="2"
                                    placeholder="Write paragraph content..."
                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"></textarea>
                            </div>
                        </template>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="closeAddModal()"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Save Bio Profile</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Paragraph Modal -->
        <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div @click.away="closeEdit()" class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-100 dark:border-gray-700"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/40 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100" x-text="editTitle"></h3>
                            <p class="text-xs text-gray-400">Update paragraph narrative for your profile</p>
                        </div>
                    </div>
                    <button @click="closeEdit()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Paragraph Content</label>
                        <textarea rows="7" x-model="editValue"
                            placeholder="Enter paragraph text..."
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 p-3.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs leading-relaxed"></textarea>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span x-text="(editValue ? editValue.length : 0) + ' characters'"></span>
                        <span x-text="(editValue ? editValue.trim().split(/\s+/).filter(Boolean).length : 0) + ' words'"></span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <button @click="closeEdit()"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                        Cancel
                    </button>
                    <button @click="saveEdit()"
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Save Paragraph</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Inline Image Update Modal / Popup -->
        <div x-show="inlineImage.editing" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700"
                 @click.away="cancelInlineImage()"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100"
                        x-text="inlineImage.field === 'BioPhotoPath' ? 'Update Profile Portrait' : 'Update Cover Banner'">
                    </h3>
                    <button type="button" @click="cancelInlineImage()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form x-ref="inlineImageForm" class="space-y-4" enctype="multipart/form-data">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Choose New Image</label>
                        <input type="file" name="value" accept="image/*" @change="inlineImagePreview($event)"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1C9BA0]/10 file:text-[#1C9BA0] hover:file:bg-[#1C9BA0]/20 cursor-pointer" />
                    </div>

                    <!-- Live Image Preview -->
                    <template x-if="inlineImage.preview">
                        <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-2">
                            <img :src="inlineImage.preview" class="max-h-48 object-contain rounded-lg shadow-xs" />
                        </div>
                    </template>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="cancelInlineImage()"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            Cancel
                        </button>
                        <button type="button" @click.prevent="submitInlineImage()"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Save Image</span>
                        </button>
                    </div>
                </form>
            </div>
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
                    if (this.$refs.addForm) this.$refs.addForm.reset();
                },

                addNextParagraph() {
                    for (let i = 1; i <= 6; i++) {
                        if (!this.bio?.['BioTextParagraph' + i]) {
                            this.openEditParagraph(i - 1);
                            return;
                        }
                    }
                },

                hasAvailableParagraphSlot() {
                    for (let i = 1; i <= 6; i++) {
                        if (!this.bio?.['BioTextParagraph' + i]) {
                            return true;
                        }
                    }
                    return false;
                },

                async submitAddForm() {
                    const fd = new FormData(this.$refs.addForm);
                    const res = await Alpine.store('bioUpdater').postData(this.storeUrl, fd);

                    if (res.success && res.bio) {
                        const cacheBuster = `?v=${Date.now()}`;
                        const safeUrl = (url) => url ? `/storage/${url.replace(/^storage\//, '')}${cacheBuster}` : null;

                        res.bio.BioPhotoPath = safeUrl(res.bio.BioPhotoPath);
                        res.bio.BioBackgroundPhotoPath = safeUrl(res.bio.BioBackgroundPhotoPath);

                        this.bio = null;
                        this.$nextTick(() => {
                            this.bio = res.bio;
                        });

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

                // Image modal
                openInlineEditImage(event, field) {
                    this.inlineImage.editing = true;
                    this.inlineImage.field = field;
                    this.inlineImage.preview = null;
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
                    const fd = new FormData(this.$refs.inlineImageForm);
                    fd.append('field', this.inlineImage.field);
                    const res = await Alpine.store('bioUpdater').postData(this.updateUrl, fd);
                    if (res.success) {
                        if (res.newPath) {
                            const newPath = `/storage/${res.newPath.replace(/^storage\//, '')}?v=${Date.now()}`;
                            if (!this.bio) this.bio = {};
                            this.bio[this.inlineImage.field] = newPath;
                        } else if (res.bio) {
                            this.bio = res.bio;
                            if (this.bio.BioPhotoPath) this.bio.BioPhotoPath += `?v=${Date.now()}`;
                            if (this.bio.BioBackgroundPhotoPath) this.bio.BioBackgroundPhotoPath += `?v=${Date.now()}`;
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

                // Paragraph editing
                openEditParagraph(index) {
                    this.editModal = true;
                    this.editTitle = 'Edit Bio Paragraph ' + (index + 1);
                    this.editValue = (this.bio && this.bio['BioTextParagraph' + (index + 1)]) ? this.bio['BioTextParagraph' + (index + 1)] : '';
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
                            this.bio = null;
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
