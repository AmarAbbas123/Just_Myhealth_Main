<!-- resources/views/modules/mod-01/tm/menu-display-options.blade.php -->
<x-app1>

    @php
        $columns = [
            'ParentID',
            'DisplayName',
            'MainPaneID',
            'MainPaneLabel',
            'TileText',
            'Grouping',
            '1',
            '10',
            '30',
            '31',
            '32',
            '90',
            '91',
            'MenuURL',
            'ImagePath',
        ];

        $roleColumns = ['1', '10', '30', '31', '32', '90', '91'];
    @endphp

    <div class="max-w-7xl mx-auto space-y-6" x-data="crud()" x-cloak>

        <!-- Page Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />

            <div class="flex items-center gap-2.5 flex-wrap self-start sm:self-auto">
                <!-- Add Menu Option Button -->
                <button type="button" @click="openCreate"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Menu Option</span>
                </button>
            </div>
        </div>

        <!-- Session Feedback Alerts -->
        @if (session('error'))
            <div class="rounded-2xl border border-rose-200 dark:border-rose-800 bg-rose-50/90 dark:bg-rose-950/50 p-4 shadow-sm flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-rose-900 dark:text-rose-100">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50/90 dark:bg-emerald-950/50 p-4 shadow-sm flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-emerald-900 dark:text-emerald-100">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Stat 1: Total Menu Options -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Menu Options</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-0.5">{{ $items->total() }}</p>
                    <p class="text-[11px] text-gray-400">Configured Navigation Items</p>
                </div>
            </div>

            <!-- Stat 2: Role Access Flags -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Role Tiers Covered</p>
                    <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-0.5">7 User Types</p>
                    <p class="text-[11px] text-gray-400">Types 1, 10, 30, 31, 32, 90, 91</p>
                </div>
            </div>

            <!-- Stat 3: Architecture Scope -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">System Architecture</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">MOD-01 Administration</p>
                    <p class="text-[11px] text-gray-400">Navigation & Menu Directory</p>
                </div>
            </div>
        </div>

        <!-- Main Table Card Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Menu Display Options Directory</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Master configuration for dashboard menus, pane mappings, URLs, and role access flags.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                        {{ $items->total() }} Options
                    </span>
                </div>
            </div>

            <!-- Scroll helper note -->
            <div class="px-4 py-2.5 bg-gray-50/80 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                <span class="flex items-center gap-1.5 font-medium text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Scroll horizontally to review all menu display columns</span>
                </span>
                <div class="flex items-center gap-3 font-mono text-[11px]">
                    <span class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 1
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-400 dark:text-gray-500 font-bold">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span> 0
                    </span>
                </div>
            </div>

            <!-- Table Container with Local Horizontal Scroll -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1700px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            <!-- Serial Number Column -->
                            <th class="py-3.5 pl-4 sm:pl-6 pr-3 text-center whitespace-nowrap w-12 sm:w-14">#</th>

                            <!-- Original Table Headings -->
                            @foreach ($columns as $col)
                                <th class="py-3.5 px-3 whitespace-nowrap {{ in_array($col, ['DisplayName', 'TileText', 'MainPaneLabel', 'MenuURL', 'ImagePath']) ? 'text-left' : 'text-center' }}">
                                    <a href="{{ request()->fullUrlWithQuery([
                                            'sort_by' => $col,
                                            'sort_dir' => $sortBy == $col && $sortDir == 'asc' ? 'desc' : 'asc',
                                        ]) }}"
                                        class="inline-flex items-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == $col ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                        <span>{{ $col }}</span>
                                        <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                            @if ($sortBy == $col)
                                                <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                            @endif
                                        </span>
                                    </a>
                                </th>
                            @endforeach

                            <!-- Action Column -->
                            <th class="py-3.5 pl-2 pr-4 sm:pr-6 text-right whitespace-nowrap w-24">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                        @forelse ($items as $index => $item)
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors group">
                                <!-- Serial Number -->
                                <td class="py-3.5 pl-4 sm:pl-6 pr-3 text-center font-mono font-bold text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                    {{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }}
                                </td>

                                <!-- ParentID -->
                                <td class="py-3.5 px-3 text-center whitespace-nowrap font-mono text-xs text-gray-700 dark:text-gray-300">
                                    {{ $item->ParentID }}
                                </td>

                                <!-- DisplayName -->
                                <td class="py-3.5 px-3 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#1C9BA0]"></div>
                                        <span>{{ $item->DisplayName }}</span>
                                    </div>
                                </td>

                                <!-- MainPaneID -->
                                <td class="py-3.5 px-3 text-center whitespace-nowrap font-mono text-xs text-gray-700 dark:text-gray-300">
                                    {{ $item->MainPaneID }}
                                </td>

                                <!-- MainPaneLabel -->
                                <td class="py-3.5 px-3 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                    {{ $item->MainPaneLabel }}
                                </td>

                                <!-- TileText -->
                                <td class="py-3.5 px-3 text-gray-600 dark:text-gray-300 max-w-xs whitespace-pre-line truncate" title="{{ $item->TileText }}">
                                    {{ $item->TileText }}
                                </td>

                                <!-- Grouping -->
                                <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                    @if ($item->Grouping)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-200">
                                            {{ $item->Grouping }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Role Columns: 1, 10, 30, 31, 32, 90, 91 -->
                                @foreach ($roleColumns as $rCol)
                                    <td class="py-3.5 px-3 text-center whitespace-nowrap font-mono text-xs font-bold {{ $item->$rCol == 1 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' }}">
                                        {{ $item->$rCol }}
                                    </td>
                                @endforeach

                                <!-- MenuURL -->
                                <td class="py-3.5 px-3 whitespace-nowrap font-mono text-xs text-gray-600 dark:text-gray-300">
                                    @if ($item->MenuURL)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                                            {{ $item->MenuURL }}
                                        </span>
                                    @endif
                                </td>

                                <!-- ImagePath -->
                                <td class="py-3.5 px-3 whitespace-nowrap font-mono text-xs text-gray-500 dark:text-gray-400">
                                    {{ $item->ImagePath }}
                                </td>

                                <!-- Action Buttons -->
                                <td class="py-3.5 pl-2 pr-4 sm:pr-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <!-- Edit Button -->
                                        <button type="button" @click="openEdit(@js($item))"
                                            class="p-1.5 rounded-lg text-[#1C9BA0] hover:bg-[#1C9BA0]/10 transition-colors"
                                            title="Edit Menu Option">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('menu-display-options.destroy', $item->ID) }}"
                                            onsubmit="return confirm('Delete this menu option?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors"
                                                title="Delete Menu Option">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center py-12 text-gray-400">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                        </svg>
                                    </div>
                                    <p class="font-bold text-gray-700 dark:text-gray-300">No menu display options found.</p>
                                    <p class="text-xs text-gray-400 mt-1">Click "+ Add Menu Option" above to register a new navigation item.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if ($items->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/40 dark:bg-gray-900/20">
                    {{ $items->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

        {{-- ===================== ADD / EDIT MODAL ===================== --}}
        <div x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs overflow-y-auto"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-3xl shadow-2xl border border-gray-100 dark:border-gray-700 my-8 max-h-[90vh] flex flex-col"
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100"
                                x-text="edit ? 'Edit Menu Option' : 'Add Menu Option'"></h3>
                            <p class="text-xs text-gray-400">Configure navigation structure, labels, and role access.</p>
                        </div>
                    </div>

                    <button type="button" @click="close"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Form (Scrollable content) -->
                <form :action="formAction" method="POST" class="overflow-y-auto pr-1 space-y-6 pt-5 flex-1">
                    @csrf
                    <template x-if="edit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- Section 1: Navigation Structure & Details -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                            Menu Information
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- DisplayName -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Display Name
                                </label>
                                <input type="text" name="DisplayName" x-model="form.DisplayName" maxlength="255"
                                    placeholder="e.g. My Dashboard"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- Grouping -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Grouping
                                </label>
                                <input type="text" name="Grouping" x-model="form.Grouping" maxlength="24"
                                    placeholder="e.g. User"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- ParentID -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Parent ID
                                </label>
                                <input type="number" name="ParentID" x-model="form.ParentID" min="0" max="9999"
                                    placeholder="e.g. 0"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- MainPaneID -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Main Pane ID
                                </label>
                                <input type="number" name="MainPaneID" x-model="form.MainPaneID" min="0" max="9999"
                                    placeholder="e.g. 72"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- MainPaneLabel -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Main Pane Label
                                </label>
                                <input type="text" name="MainPaneLabel" x-model="form.MainPaneLabel" maxlength="48"
                                    placeholder="e.g. User Home Dashboard"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- MenuURL -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Menu URL
                                </label>
                                <input type="text" name="MenuURL" x-model="form.MenuURL" maxlength="500"
                                    placeholder="e.g. /dashboard"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm font-mono focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- ImagePath -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Image Path
                                </label>
                                <input type="text" name="ImagePath" x-model="form.ImagePath" maxlength="255"
                                    placeholder="e.g. /images/icon.png"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                            </div>

                            <!-- TileText -->
                            <div class="sm:col-span-2 md:col-span-3">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Tile Text
                                </label>
                                <textarea name="TileText" x-model="form.TileText" rows="3" maxlength="2048"
                                    placeholder="Detailed description displayed on dashboard tiles..."
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Role Visibility Flags (0 or 1) -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Role Visibility Flags (1 = Visible, 0 = Hidden)
                            </h4>

                            <!-- Quick Toggle Helpers -->
                            <div class="flex items-center gap-2">
                                <button type="button" @click="setAllRoles(1)"
                                    class="text-[11px] font-semibold font-mono px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 transition-colors">
                                    Set All to 1
                                </button>
                                <button type="button" @click="setAllRoles(0)"
                                    class="text-[11px] font-semibold font-mono px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-colors">
                                    Set All to 0
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2.5">
                            @foreach ($roleColumns as $rKey)
                                <div>
                                    <input type="hidden" name="{{ $rKey }}" :value="form['{{ $rKey }}']">
                                    <button type="button" @click="toggle('{{ $rKey }}')"
                                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl border text-xs font-semibold transition-all"
                                        :class="form['{{ $rKey }}'] == 1
                                            ? 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 shadow-2xs'
                                            : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-gray-300'">
                                        <span class="font-bold text-gray-700 dark:text-gray-200">Role {{ $rKey }}</span>
                                        <span class="w-6 h-6 rounded-md flex items-center justify-center font-mono font-bold text-xs shrink-0 ml-1.5"
                                            :class="form['{{ $rKey }}'] == 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'">
                                            <span x-text="form['{{ $rKey }}']"></span>
                                        </span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal Actions Footer -->
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end gap-3 sticky bottom-0 bg-white dark:bg-gray-800 pb-1">
                        <button type="button" @click="close"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/60 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white shadow-md hover:shadow-lg hover:brightness-105 active:scale-95 transition-all"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <span x-text="edit ? 'Update Menu Option' : 'Create Menu Option'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function crud() {
            return {
                open: false,
                edit: false,
                form: {
                    ParentID: 0,
                    DisplayName: '',
                    MainPaneID: 0,
                    MainPaneLabel: '',
                    TileText: '',
                    Grouping: '',
                    '1': 0,
                    '10': 0,
                    '30': 0,
                    '31': 0,
                    '32': 0,
                    '90': 0,
                    '91': 0,
                    MenuURL: '',
                    ImagePath: '',
                },
                formAction: '',
                openCreate() {
                    this.edit = false;
                    this.form = {
                        ParentID: 0,
                        DisplayName: '',
                        MainPaneID: 0,
                        MainPaneLabel: '',
                        TileText: '',
                        Grouping: '',
                        '1': 0,
                        '10': 0,
                        '30': 0,
                        '31': 0,
                        '32': 0,
                        '90': 0,
                        '91': 0,
                        MenuURL: '',
                        ImagePath: '',
                    };
                    this.formAction = "{{ route('menu-display-options.store') }}";
                    this.open = true;
                },
                openEdit(item) {
                    this.edit = true;
                    this.form = {
                        ParentID: item.ParentID ?? 0,
                        DisplayName: item.DisplayName || '',
                        MainPaneID: item.MainPaneID ?? 0,
                        MainPaneLabel: item.MainPaneLabel || '',
                        TileText: item.TileText || '',
                        Grouping: item.Grouping || '',
                        '1': item['1'] ?? 0,
                        '10': item['10'] ?? 0,
                        '30': item['30'] ?? 0,
                        '31': item['31'] ?? 0,
                        '32': item['32'] ?? 0,
                        '90': item['90'] ?? 0,
                        '91': item['91'] ?? 0,
                        MenuURL: item.MenuURL || '',
                        ImagePath: item.ImagePath || '',
                    };
                    this.formAction = "/mod-01/tm/menu-display-options/" + item.ID;
                    this.open = true;
                },
                toggle(key) {
                    this.form[key] = (this.form[key] == 1) ? 0 : 1;
                },
                setAllRoles(val) {
                    ['1', '10', '30', '31', '32', '90', '91'].forEach(k => {
                        this.form[k] = val;
                    });
                },
                close() {
                    this.open = false;
                }
            }
        }
    </script>
</x-app1>
