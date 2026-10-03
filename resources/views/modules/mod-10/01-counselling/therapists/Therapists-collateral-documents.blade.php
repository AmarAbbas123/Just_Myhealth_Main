<x-app1>
    @php
        $totalFiles = count($files);
        $privateFiles = collect($files)->where('type', 'private')->count();
        $commonFiles = collect($files)->where('type', 'common')->count();
        $totalFolders = count($folders);

        $filesList = collect($files)->map(function ($f, $i) {
            $exists = \Illuminate\Support\Facades\Storage::disk('therapy_docs')->exists($f['path']);
            $meta = $exists ? \Illuminate\Support\Facades\Storage::disk('therapy_docs')->lastModified($f['path']) : time();
            $size = $exists ? \Illuminate\Support\Facades\Storage::disk('therapy_docs')->size($f['path']) : 0;
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));

            return [
                'index' => $i + 1,
                'name' => $f['name'],
                'type' => $f['type'],
                'folder' => $f['folder'] ?? '-',
                'folder_slug' => $f['folder_slug'],
                'date' => date('d M Y', $meta),
                'timestamp' => $meta,
                'size' => $size >= 1048576 ? round($size / 1048576, 2) . ' MB' : round($size / 1024, 1) . ' KB',
                'ext' => $ext,
                'download_url' => route('collateral.download', [
                    'type' => $f['type'],
                    'folder' => $f['folder_slug'],
                    'file' => $f['name'],
                ]),
                'delete_url' => route('collateral.delete', [
                    'type' => $f['type'],
                    'folder' => $f['folder_slug'],
                    'file' => $f['name'],
                ]),
            ];
        })->values();
    @endphp

    <div x-data="collateralApp()" class="space-y-6">

        <!-- Flash Notifications -->
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
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex items-center justify-between gap-3 text-rose-800 dark:text-rose-200 shadow-2xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Header & Upload Bar -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <x-page-header />

            <!-- Upload Controls Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-2.5 sm:p-3 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <!-- Type Selection -->
                <div class="relative min-w-[130px]">
                    <select x-model="uploadType"
                        class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-8 py-2 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        <option value="private">🔒 Private</option>
                        <option value="common">🌐 Common</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Folder / Category Dropdown -->
                <div class="relative min-w-[180px] sm:max-w-xs">
                    <select x-model="uploadFolder"
                        class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-8 py-2 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs truncate">
                        @foreach ($folders as $f)
                            <option value="{{ \Illuminate\Support\Str::slug($f) }}">
                                📁 {{ $f }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Upload Trigger Button -->
                <button @click="$refs.fileInput.click()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95 shrink-0"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span>Upload File</span>
                </button>

                <!-- Hidden Native Upload Form -->
                <form x-ref="uploadForm" method="POST" action="{{ route('collateral.upload') }}" enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="hidden" name="type" :value="uploadType">
                    <input type="hidden" name="folder" :value="uploadFolder">
                    <input type="file" name="file" x-ref="fileInput" @change="$refs.uploadForm.submit()">
                </form>
            </div>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Documents -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Total Files</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5 truncate">{{ $totalFiles }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Collateral library assets</p>
                </div>
            </div>

            <!-- Card 2: Private Documents -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Private Files</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-0.5 truncate">{{ $privateFiles }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Therapist-only storage</p>
                </div>
            </div>

            <!-- Card 3: Common Resources -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Common Resources</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-0.5 truncate">{{ $commonFiles }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Shared with clients</p>
                </div>
            </div>

            <!-- Card 4: Categories -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Categories</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-0.5 truncate">{{ $totalFolders }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Topic folders configured</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 lg:gap-5 items-end">
                <!-- Search by File Name -->
                <div class="w-full sm:col-span-2 lg:col-span-5">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Search Document</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search by file name or extension..." x-model="filters.search"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                    </div>
                </div>

                <!-- Filter by Folder / Category -->
                <div class="w-full sm:col-span-1 lg:col-span-4">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Category / Topic</label>
                    <div class="relative">
                        <select x-model="filters.folder"
                            class="w-full appearance-none py-2 pl-3 pr-8 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="">All Categories</option>
                            @foreach ($folders as $f)
                                <option value="{{ $f }}">{{ $f }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Scope / Type -->
                <div class="w-full sm:col-span-1 lg:col-span-2">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Access Scope</label>
                    <div class="relative">
                        <select x-model="filters.type"
                            class="w-full appearance-none py-2 pl-3 pr-8 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="">All Scopes</option>
                            <option value="private">Private</option>
                            <option value="common">Common</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Reset Button -->
                <div class="w-full sm:col-span-2 lg:col-span-1">
                    <button @click="clearFilters" title="Clear Filters"
                        class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Documents Table & Cards Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
            <!-- Header bar with Counter & Quick Filters -->
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/30">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base">Document Repository</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20"
                          x-text="filteredFiles.length + ' ' + (filteredFiles.length === 1 ? 'file' : 'files')">
                    </span>
                </div>

                <!-- Scope Quick-Filter Tabs -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                    <button @click="filters.type = ''"
                        :class="filters.type === '' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        All
                    </button>
                    <button @click="filters.type = 'private'"
                        :class="filters.type === 'private' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        Private
                    </button>
                    <button @click="filters.type = 'common'"
                        :class="filters.type === 'common' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        Common
                    </button>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/30 dark:bg-gray-900/20 text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            <th scope="col" class="py-3.5 px-5 w-12 text-center">#</th>
                            <th scope="col" class="py-3.5 px-5">Document Name</th>
                            <th scope="col" class="py-3.5 px-5">Scope</th>
                            <th scope="col" class="py-3.5 px-5">Category / Folder</th>
                            <th scope="col" class="py-3.5 px-5">Date Modified</th>
                            <th scope="col" class="py-3.5 px-5">Size</th>
                            <th scope="col" class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                        <template x-for="(file, idx) in filteredFiles" :key="file.name + file.folder_slug + file.type">
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-all group">
                                <!-- Index -->
                                <td class="py-4 px-5 text-center text-xs font-bold text-gray-400 dark:text-gray-500" x-text="idx + 1"></td>

                                <!-- File Name with File Icon -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <!-- Extension Icon Badge -->
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-[11px] shrink-0 uppercase tracking-tighter"
                                             :class="{
                                                 'bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60': file.ext === 'pdf',
                                                 'bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-800/60': ['doc', 'docx'].includes(file.ext),
                                                 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60': ['xls', 'xlsx', 'csv'].includes(file.ext),
                                                 'bg-purple-50 text-purple-600 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-800/60': ['png', 'jpg', 'jpeg', 'webp'].includes(file.ext),
                                                 'bg-teal-50 text-[#1C9BA0] dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-teal-800/60': !['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'png', 'jpg', 'jpeg', 'webp'].includes(file.ext)
                                             }"
                                             x-text="file.ext || 'doc'">
                                        </div>
                                        <div class="min-w-0 max-w-sm">
                                            <p class="font-bold text-gray-900 dark:text-gray-100 truncate" x-text="file.name"></p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Scope Badge -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                          :class="file.type === 'common'
                                              ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60'
                                              : 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60'">
                                        <span class="w-1.5 h-1.5 rounded-full"
                                              :class="file.type === 'common' ? 'bg-blue-500' : 'bg-amber-500'"></span>
                                        <span x-text="file.type === 'common' ? 'Common' : 'Private'"></span>
                                    </span>
                                </td>

                                <!-- Category / Folder -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 text-xs font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                        <span x-text="file.folder"></span>
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="py-4 px-5 whitespace-nowrap font-medium text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span x-text="file.date"></span>
                                    </div>
                                </td>

                                <!-- Size -->
                                <td class="py-4 px-5 whitespace-nowrap font-medium text-gray-500 dark:text-gray-400">
                                    <span x-text="file.size"></span>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <!-- Download Button -->
                                        <a :href="file.download_url" title="Download Document"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>Download</span>
                                        </a>

                                        <!-- Delete Form -->
                                        <form :action="file.delete_url" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Document"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards View -->
            <div class="md:hidden divide-y divide-gray-100 dark:divide-gray-700/60">
                <template x-for="(file, idx) in filteredFiles" :key="file.name + file.folder_slug + file.type">
                    <div class="p-4 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-[11px] shrink-0 uppercase tracking-tighter"
                                     :class="{
                                         'bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60': file.ext === 'pdf',
                                         'bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-800/60': ['doc', 'docx'].includes(file.ext),
                                         'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60': ['xls', 'xlsx', 'csv'].includes(file.ext),
                                         'bg-purple-50 text-purple-600 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-800/60': ['png', 'jpg', 'jpeg', 'webp'].includes(file.ext),
                                         'bg-teal-50 text-[#1C9BA0] dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-teal-800/60': !['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'png', 'jpg', 'jpeg', 'webp'].includes(file.ext)
                                     }"
                                     x-text="file.ext || 'doc'">
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-sm text-gray-900 dark:text-gray-100 break-words" x-text="file.name"></p>
                                    <div class="flex items-center gap-2 text-xs text-gray-400 mt-0.5">
                                        <span x-text="file.date"></span>
                                        <span>•</span>
                                        <span x-text="file.size"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold shrink-0"
                                  :class="file.type === 'common'
                                      ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60'
                                      : 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60'">
                                <span class="w-1.5 h-1.5 rounded-full"
                                      :class="file.type === 'common' ? 'bg-blue-500' : 'bg-amber-500'"></span>
                                <span x-text="file.type === 'common' ? 'Common' : 'Private'"></span>
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 text-xs font-medium text-gray-600 dark:text-gray-300">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span x-text="file.folder"></span>
                            </span>

                            <div class="flex items-center gap-2">
                                <a :href="file.download_url"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 rounded-xl text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Download</span>
                                </a>

                                <form :action="file.delete_url" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredFiles.length === 0" class="py-16 text-center px-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h4 class="text-base font-bold text-gray-800 dark:text-gray-200">No documents found</h4>
                <p class="text-xs sm:text-sm text-gray-400 mt-1 max-w-sm mx-auto">
                    No collateral documents match your selected criteria. You can clear filters or upload a new file above.
                </p>
                <div class="mt-4">
                    <button @click="clearFilters"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-2xs">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Alpine Store -->
    <script>
        function collateralApp() {
            return {
                uploadType: 'private',
                uploadFolder: '{{ \Illuminate\Support\Str::slug($folders[0] ?? "general") }}',
                filters: {
                    search: '',
                    folder: '',
                    type: ''
                },
                files: @json($filesList),

                get filteredFiles() {
                    return this.files.filter(f => {
                        const matchSearch = !this.filters.search ||
                            f.name.toLowerCase().includes(this.filters.search.toLowerCase()) ||
                            f.ext.toLowerCase().includes(this.filters.search.toLowerCase());

                        const matchFolder = !this.filters.folder || f.folder === this.filters.folder;
                        const matchType = !this.filters.type || f.type === this.filters.type;

                        return matchSearch && matchFolder && matchType;
                    });
                },

                clearFilters() {
                    this.filters = {
                        search: '',
                        folder: '',
                        type: ''
                    };
                }
            };
        }
    </script>
</x-app1>
