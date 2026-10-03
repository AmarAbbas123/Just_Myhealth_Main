<x-app1>
    <div x-data="idRegistration()" x-init="loadDocuments()" class="space-y-6">

        <!-- Toast Notification -->
        <div x-show="toast.show" x-cloak
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed bottom-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl border text-xs sm:text-sm font-semibold max-w-md"
            :class="toast.type === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/90 dark:text-emerald-200 dark:border-emerald-800' : 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/90 dark:text-rose-200 dark:border-rose-800'"
            style="display: none;">
            <template x-if="toast.type === 'success'">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </template>
            <template x-if="toast.type === 'error'">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
            <span x-text="toast.message"></span>
        </div>

        <!-- Header -->
        <x-page-header />

        <!-- Status & Actions Bar Below Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 flex-wrap">
            <!-- Left: Document Count & Progress Badge -->
            <div class="flex items-center gap-3 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                    <span class="w-2 h-2 rounded-full" :class="uploadedCount() === 4 ? 'bg-emerald-500' : 'bg-[#1C9BA0] animate-pulse'"></span>
                    <span x-text="uploadedCount() + ' / 4 Documents Uploaded'"></span>
                </span>

                <template x-if="uploadedCount() === 4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Full Verification Complete</span>
                    </span>
                </template>

                <template x-if="uploadedCount() < 4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/60">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span x-text="(4 - uploadedCount()) + ' Pending Verification'"></span>
                    </span>
                </template>
            </div>

            <!-- Right: View Toggle (Cards vs Table) -->
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <div class="inline-flex items-center bg-gray-100 dark:bg-gray-700/60 p-1 rounded-xl border border-gray-200/80 dark:border-gray-600/60 text-xs font-semibold">
                    <button type="button" @click="viewMode = 'cards'"
                            :class="viewMode === 'cards' ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Cards</span>
                    </button>
                    <button type="button" @click="viewMode = 'table'"
                            :class="viewMode === 'table' ? 'bg-white dark:bg-gray-800 text-[#1C9BA0] shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        <span>Table</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Skeleton Loader while fetching documents -->
        <div x-show="loading" class="space-y-3.5">
            <template x-for="i in 4" :key="i">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-xs animate-pulse flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="space-y-2">
                            <div class="w-48 h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            <div class="w-32 h-3 bg-gray-100 dark:bg-gray-700/60 rounded"></div>
                        </div>
                    </div>
                    <div class="w-24 h-9 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                </div>
            </template>
        </div>

        <!-- Content Area (When Loaded) -->
        <div x-show="!loading" x-cloak>

            {{-- ===================== 1. CARDS VIEW (DEFAULT) ===================== --}}
            <div x-show="viewMode === 'cards'" class="space-y-3.5">
                <template x-for="doc in documents" :key="doc.key">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 group">

                        <!-- Left: Document Icon & Details -->
                        <div class="flex items-start sm:items-center gap-4 min-w-0">
                            <!-- Thumbnail / Squircle Icon -->
                            <div class="relative shrink-0">
                                <template x-if="doc.document">
                                    <div class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 group-hover:border-[#1C9BA0]/50 transition-all cursor-pointer shadow-xs"
                                         @click="openPreview(doc)">
                                        <!-- PDF Icon Preview -->
                                        <template x-if="isPdf(doc.document)">
                                            <div class="w-full h-full flex flex-col items-center justify-center bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-[9px] font-bold uppercase tracking-wider mt-0.5">PDF</span>
                                            </div>
                                        </template>

                                        <!-- Image Preview -->
                                        <template x-if="!isPdf(doc.document)">
                                            <img :src="StorageUrl(doc.document)" :alt="doc.doc_type"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </template>

                                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="!doc.document">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                        <!-- Dynamic icon based on document key -->
                                        <template x-if="doc.key === 'VerificationPassportImagePath'">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                            </svg>
                                        </template>
                                        <template x-if="doc.key === 'VerificationBACPCardImagePath'">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                        </template>
                                        <template x-if="doc.key === 'VerificationLiabilityInsuranceImagePath'">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </template>
                                        <template x-if="doc.key === 'VerificationDBSImagePath'">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                            </svg>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <!-- Document Info & Status Badge -->
                            <div class="min-w-0 space-y-1.5">
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100" x-text="doc.doc_type"></h3>

                                    <!-- Uploaded Status Badge -->
                                    <template x-if="doc.document">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Verified & Uploaded</span>
                                        </span>
                                    </template>

                                    <!-- Pending Badge -->
                                    <template x-if="!doc.document">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Pending Upload</span>
                                        </span>
                                    </template>
                                </div>

                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="getDocSubtitle(doc.key)"></p>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                            <!-- If not uploaded: Upload Button -->
                            <template x-if="!doc.document">
                                <button type="button" @click="openModal('add', doc.key, doc.doc_type)"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span>Upload Document</span>
                                </button>
                            </template>

                            <!-- If uploaded: View, Update, Delete -->
                            <template x-if="doc.document">
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openPreview(doc)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                                        <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>View</span>
                                    </button>

                                    <button type="button" @click="openModal('edit', doc.key, doc.doc_type)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:hover:bg-[#1C9BA0]/30 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Replace</span>
                                    </button>

                                    <button type="button" @click="confirmDelete(doc.key, doc.doc_type)"
                                        class="p-2 rounded-xl text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 border border-rose-200/60 dark:border-rose-800/60 transition-all shadow-2xs active:scale-95"
                                        title="Delete Document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            {{-- ===================== 2. TABLE VIEW ===================== --}}
            <div x-show="viewMode === 'table'" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">
                                <th class="py-3.5 px-5">Document Type</th>
                                <th class="py-3.5 px-4">Verification Status</th>
                                <th class="py-3.5 px-4 text-center">Proof / File</th>
                                <th class="py-3.5 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                            <template x-for="doc in documents" :key="doc.key">
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors">
                                    <!-- Title & Description -->
                                    <td class="py-4 px-5">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100" x-text="doc.doc_type"></div>
                                        <div class="text-[11px] text-gray-400 mt-0.5" x-text="getDocSubtitle(doc.key)"></div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <template x-if="doc.document">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60">
                                                <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>Verified</span>
                                            </span>
                                        </template>
                                        <template x-if="!doc.document">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                <span>Pending</span>
                                            </span>
                                        </template>
                                    </td>

                                    <!-- Proof / Thumbnail -->
                                    <td class="py-4 px-4 text-center">
                                        <template x-if="doc.document">
                                            <button type="button" @click="openPreview(doc)" class="inline-block relative group">
                                                <template x-if="isPdf(doc.document)">
                                                    <div class="w-10 h-10 rounded-lg bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-600 flex items-center justify-center font-bold text-[9px]">
                                                        PDF
                                                    </div>
                                                </template>
                                                <template x-if="!isPdf(doc.document)">
                                                    <img :src="StorageUrl(doc.document)"
                                                         class="w-10 h-10 object-cover rounded-lg border border-gray-200 dark:border-gray-700 group-hover:scale-105 transition-all shadow-2xs cursor-pointer">
                                                </template>
                                            </button>
                                        </template>
                                        <template x-if="!doc.document">
                                            <span class="text-gray-300 dark:text-gray-600">—</span>
                                        </template>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <template x-if="!doc.document">
                                            <button type="button" @click="openModal('add', doc.key, doc.doc_type)"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition-all shadow-xs"
                                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                                <span>Upload</span>
                                            </button>
                                        </template>

                                        <template x-if="doc.document">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button type="button" @click="openPreview(doc)"
                                                    class="p-1.5 rounded-lg text-gray-500 hover:text-[#1C9BA0] hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                    title="View Document">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <button type="button" @click="openModal('edit', doc.key, doc.doc_type)"
                                                    class="p-1.5 rounded-lg text-[#1C9BA0] hover:bg-[#1C9BA0]/10 transition-colors"
                                                    title="Replace Document">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>

                                                <button type="button" @click="confirmDelete(doc.key, doc.doc_type)"
                                                    class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors"
                                                    title="Delete Document">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===================== UPLOAD / UPDATE MODAL ===================== --}}
        <div x-show="showModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div @click.away="closeModal()"
                class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-lg shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-y-auto max-h-[90vh]"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100" x-text="modalTitle"></h3>
                            <p class="text-xs text-gray-400" x-text="form.doc_type"></p>
                        </div>
                    </div>
                    <button type="button" @click="closeModal()"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitDocument">
                    <div class="space-y-4">
                        <!-- Target Document Display -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Verification Requirement
                            </label>
                            <div class="px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                                <span x-text="form.doc_type"></span>
                            </div>
                        </div>

                        <!-- File Dropzone -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Select File (PDF, PNG, JPG) <span class="text-rose-500">*</span>
                            </label>

                            <div class="p-5 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 hover:border-[#1C9BA0]/60 bg-gray-50/50 dark:bg-gray-900/40 text-center transition-all relative">
                                <!-- Preview of selected file -->
                                <template x-if="filePreview">
                                    <div class="space-y-3">
                                        <template x-if="filePreview.isPdf">
                                            <div class="w-16 h-16 rounded-xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-600 flex flex-col items-center justify-center mx-auto shadow-xs">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-[9px] font-bold uppercase mt-0.5">PDF</span>
                                            </div>
                                        </template>
                                        <template x-if="!filePreview.isPdf">
                                            <div class="w-20 h-20 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 mx-auto shadow-xs bg-white dark:bg-gray-800">
                                                <img :src="filePreview.url" alt="Selected Preview" class="w-full h-full object-cover">
                                            </div>
                                        </template>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate max-w-xs mx-auto" x-text="filePreview.name"></p>
                                            <p class="text-[11px] text-gray-400" x-text="filePreview.size"></p>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="!filePreview">
                                    <div class="space-y-2 py-2">
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                        <div class="text-xs text-gray-600 dark:text-gray-300">
                                            <span class="font-semibold text-[#1C9BA0]">Click to choose file</span> or drag & drop
                                        </div>
                                        <p class="text-[11px] text-gray-400">PDF, JPG, JPEG, or PNG up to 2MB</p>
                                    </div>
                                </template>

                                <input type="file" @change="handleFileUpload($event)" accept="image/jpeg,image/png,image/jpg,application/pdf" required
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>

                            <template x-if="uploadError">
                                <p class="text-xs text-rose-500 font-semibold mt-1.5" x-text="uploadError"></p>
                            </template>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/80">
                        <button type="button" @click="closeModal()" :disabled="isSubmitting"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            Cancel
                        </button>
                        <button type="submit" :disabled="isSubmitting || !form.document"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <template x-if="isSubmitting">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                            </template>
                            <span x-text="isSubmitting ? 'Uploading...' : modalAction"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== DELETE CONFIRMATION MODAL ===================== --}}
        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div @click.away="showDeleteModal = false"
                class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700 text-center"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-4 border border-rose-100 dark:border-rose-900/40">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Delete Document Proof?</h3>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                    Are you sure you want to delete <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deletingTitle"></span>? You will need to upload a replacement for compliance verification.
                </p>

                <div class="flex items-center justify-center gap-3">
                    <button type="button" @click="showDeleteModal = false"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Cancel
                    </button>
                    <button type="button" @click="executeDelete()"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-md hover:shadow-lg active:scale-95">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== LIGHTBOX / PREVIEW MODAL ===================== --}}
        <div x-show="showPreviewModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div @click.away="showPreviewModal = false"
                class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 w-full max-w-3xl shadow-2xl border border-gray-100 dark:border-gray-700 relative overflow-hidden"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 truncate" x-text="previewTitle"></h3>
                    <div class="flex items-center gap-2">
                        <a :href="previewUrl" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] hover:bg-[#1C9BA0]/20 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Open in New Tab</span>
                        </a>
                        <button type="button" @click="showPreviewModal = false"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Preview Display -->
                <div class="max-h-[75vh] overflow-auto flex items-center justify-center rounded-2xl bg-gray-50 dark:bg-gray-900/60 p-2">
                    <template x-if="previewIsPdf">
                        <iframe :src="previewUrl" class="w-full h-[65vh] rounded-xl border border-gray-200 dark:border-gray-700"></iframe>
                    </template>
                    <template x-if="!previewIsPdf">
                        <img :src="previewUrl" :alt="previewTitle" class="max-h-[70vh] w-auto max-w-full rounded-xl object-contain shadow-xs">
                    </template>
                </div>
            </div>
        </div>

    </div>

    {{-- AlpineJS Controller --}}
    <script>
        function idRegistration() {
            return {
                documents: [],
                loading: true,
                showModal: false,
                showDeleteModal: false,
                showPreviewModal: false,
                previewUrl: '',
                previewTitle: '',
                previewIsPdf: false,
                deletingKey: '',
                deletingTitle: '',
                isSubmitting: false,
                uploadError: '',
                viewMode: 'cards',
                modalTitle: '',
                modalAction: '',
                filePreview: null,
                toast: {
                    show: false,
                    message: '',
                    type: 'success'
                },

                form: {
                    mode: '',
                    doc_key: '',
                    doc_type: '',
                    document: null
                },

                StorageUrl(path) {
                    return path ? `/storage/${path}` : null;
                },

                isPdf(path) {
                    return path && path.toLowerCase().endsWith('.pdf');
                },

                uploadedCount() {
                    return this.documents.filter(d => !!d.document).length;
                },

                getDocSubtitle(key) {
                    const subtitles = {
                        'VerificationPassportImagePath': 'Primary photographic proof of legal identity and nationality.',
                        'VerificationBACPCardImagePath': 'Current certificate or card proving national professional registration.',
                        'VerificationLiabilityInsuranceImagePath': 'Active clinical practice indemnity & public liability insurance.',
                        'VerificationDBSImagePath': 'Enhanced criminal record certificate for adult and child counselling safety.'
                    };
                    return subtitles[key] || 'Official regulatory verification credential.';
                },

                showToast(message, type = 'success') {
                    this.toast.message = message;
                    this.toast.type = type;
                    this.toast.show = true;
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3500);
                },

                loadDocuments() {
                    this.loading = true;
                    fetch("{{ route('therap.documents.fetch') }}")
                        .then(res => res.json())
                        .then(data => {
                            this.documents = data;
                            this.loading = false;
                        })
                        .catch(err => {
                            console.error(err);
                            this.loading = false;
                            this.showToast('Failed to load verification documents', 'error');
                        });
                },

                openModal(mode, key, type) {
                    this.form = {
                        mode,
                        doc_key: key,
                        doc_type: type,
                        document: null
                    };
                    this.filePreview = null;
                    this.uploadError = '';
                    this.modalTitle = (mode === 'add') ? 'Upload Document Proof' : 'Replace Document Proof';
                    this.modalAction = (mode === 'add') ? 'Upload File' : 'Save Replacement';
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                    this.filePreview = null;
                    this.uploadError = '';
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // 2MB size limit validation (2 * 1024 * 1024 bytes)
                    if (file.size > 2097152) {
                        this.uploadError = 'File exceeds 2MB limit. Please choose a smaller document or optimize the PDF/image.';
                        this.form.document = null;
                        this.filePreview = null;
                        event.target.value = '';
                        return;
                    }

                    this.uploadError = '';
                    this.form.document = file;

                    const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
                    const sizeFormatted = (file.size / 1024).toFixed(1) + ' KB';

                    this.filePreview = {
                        name: file.name,
                        size: sizeFormatted,
                        isPdf: isPdf,
                        url: isPdf ? null : URL.createObjectURL(file)
                    };
                },

                submitDocument() {
                    if (!this.form.document) {
                        this.uploadError = 'Please select a document file to upload.';
                        return;
                    }

                    this.isSubmitting = true;
                    this.uploadError = '';

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
                    .then(res => {
                        if (!res.ok) throw new Error('Upload failed');
                        return res.json();
                    })
                    .then(() => {
                        this.isSubmitting = false;
                        this.showModal = false;
                        this.loadDocuments();
                        this.showToast(this.form.doc_type + ' uploaded successfully!');
                    })
                    .catch(err => {
                        this.isSubmitting = false;
                        this.uploadError = 'Failed to upload document. Please ensure file is valid format and under 2MB.';
                        this.showToast('Upload failed. Please try again.', 'error');
                    });
                },

                confirmDelete(key, title) {
                    this.deletingKey = key;
                    this.deletingTitle = title;
                    this.showDeleteModal = true;
                },

                executeDelete() {
                    const key = this.deletingKey;
                    fetch(`/mod-10/id-documents/${key}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(() => {
                        this.showDeleteModal = false;
                        this.loadDocuments();
                        this.showToast('Document deleted successfully.');
                    })
                    .catch(err => {
                        console.error(err);
                        this.showDeleteModal = false;
                        this.showToast('Failed to delete document', 'error');
                    });
                },

                openPreview(doc) {
                    if (!doc.document) return;
                    this.previewUrl = this.StorageUrl(doc.document);
                    this.previewTitle = doc.doc_type;
                    this.previewIsPdf = this.isPdf(doc.document);
                    this.showPreviewModal = true;
                }
            };
        }
    </script>
</x-app1>
