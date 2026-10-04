<!-- resources/views/modules/mod-01/tm/auto-emails.blade.php -->
<x-app1>

    <div class="max-w-7xl mx-auto space-y-6" x-data="crud()" x-cloak>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />
            
            <div class="flex items-center gap-2.5 flex-wrap self-start sm:self-auto">
                

                <button type="button" @click="openCreate"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Configuration</span>
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
            <!-- Stat 1: Total Email Rules -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Email Rules</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">{{ $items->total() }}</p>
                    <p class="text-[11px] text-gray-400">Configured triggers</p>
                </div>
            </div>

            <!-- Stat 2: Active Modules -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[#1C9BA0] bg-[#1C9BA0]/10 dark:bg-[#1C9BA0]/20 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pagination</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">Page {{ $items->currentPage() }} <span class="text-sm font-normal text-gray-400">of {{ $items->lastPage() }}</span></p>
                    <p class="text-[11px] text-gray-400">10 entries per view</p>
                </div>
            </div>

            <!-- Stat 3: Scope Badge -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">System Scope</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">MOD-01 Administration</p>
                    <p class="text-[11px] text-gray-400">Automated Mail Trigger Matrix</p>
                </div>
            </div>
        </div>

        <!-- Main Table Container Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Configured Automated Emails</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">System email triggers mapped across platform modules and events.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                        {{ $items->total() }} Registered Rules
                    </span>
                </div>
            </div>

            <!-- Mobile Horizontal Scroll Helper -->
            <div class="sm:hidden px-4 py-2 bg-gray-50 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                    <svg class="w-3.5 h-3.5 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Swipe horizontally to view all columns</span>
                </span>
                <span class="font-mono text-gray-400">{{ $items->count() }} shown</span>
            </div>

            <!-- Data Table: 100% Fluid & Responsive with zero horizontal scrollbar on laptops/desktops -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed min-w-[720px] lg:min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">
                            <!-- Serial Number Column -->
                            <th class="py-3.5 pl-4 sm:pl-6 pr-2 text-center w-12 sm:w-14">#</th>

                            <!-- Module Ref -->
                            <th class="py-3.5 px-2 text-center w-16 sm:w-20">
                                <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'ModuleRef',
                                        'sort_dir' => $sortBy == 'ModuleRef' && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                    class="inline-flex items-center justify-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == 'ModuleRef' ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                    <span>Mod Ref</span>
                                    <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                        @if ($sortBy == 'ModuleRef')
                                            <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                        @endif
                                    </span>
                                </a>
                            </th>

                            <!-- Sub Ref -->
                            <th class="py-3.5 px-2 text-center w-16 sm:w-20">
                                <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'ModuleSubRef',
                                        'sort_dir' => $sortBy == 'ModuleSubRef' && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                    class="inline-flex items-center justify-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == 'ModuleSubRef' ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                    <span>Sub Ref</span>
                                    <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                        @if ($sortBy == 'ModuleSubRef')
                                            <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                        @endif
                                    </span>
                                </a>
                            </th>

                            <!-- Module Full -->
                            <th class="py-3.5 px-2 text-center w-20 sm:w-24">
                                <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'ModuleFull',
                                        'sort_dir' => $sortBy == 'ModuleFull' && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                    class="inline-flex items-center justify-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == 'ModuleFull' ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                    <span>Module</span>
                                    <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                        @if ($sortBy == 'ModuleFull')
                                            <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                        @endif
                                    </span>
                                </a>
                            </th>

                            <!-- Email Sub Ref -->
                            <th class="py-3.5 px-2 text-center w-20 sm:w-24">
                                <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'EmailSubRef',
                                        'sort_dir' => $sortBy == 'EmailSubRef' && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                    class="inline-flex items-center justify-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == 'EmailSubRef' ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                    <span>Email Ref</span>
                                    <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                        @if ($sortBy == 'EmailSubRef')
                                            <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                        @endif
                                    </span>
                                </a>
                            </th>

                            <!-- Short Description -->
                            <th class="py-3.5 px-3 w-40 sm:w-48 lg:w-56">
                                <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'EmailShortDesc',
                                        'sort_dir' => $sortBy == 'EmailShortDesc' && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                    class="inline-flex items-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == 'EmailShortDesc' ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                    <span>Short Description</span>
                                    <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                        @if ($sortBy == 'EmailShortDesc')
                                            <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                        @endif
                                    </span>
                                </a>
                            </th>

                            <!-- Long Description -->
                            <th class="py-3.5 px-3">
                                <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'EamilLongDesc',
                                        'sort_dir' => $sortBy == 'EamilLongDesc' && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                    class="inline-flex items-center gap-1 hover:text-[#1C9BA0] transition-colors {{ $sortBy == 'EamilLongDesc' ? 'text-[#1C9BA0] font-extrabold' : '' }}">
                                    <span>Long Description</span>
                                    <span class="inline-flex flex-col text-[9px] leading-none opacity-80">
                                        @if ($sortBy == 'EamilLongDesc')
                                            <span>{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">⇅</span>
                                        @endif
                                    </span>
                                </a>
                            </th>

                            <!-- Actions -->
                            <th class="py-3.5 pl-2 pr-4 sm:pr-6 text-right w-20 sm:w-24">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                        @forelse ($items as $index => $item)
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors group">
                                <!-- Serial Number -->
                                <td class="py-3 pl-4 sm:pl-6 pr-2 text-center font-mono font-bold text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                    {{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }}
                                </td>

                                <!-- Module Ref -->
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-200">
                                        {{ $item->ModuleRef }}
                                    </span>
                                </td>

                                <!-- Sub Ref -->
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300">
                                        {{ $item->ModuleSubRef }}
                                    </span>
                                </td>

                                <!-- Module Full -->
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold font-mono bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                                        {{ $item->ModuleFull }}
                                    </span>
                                </td>

                                <!-- Email Sub Ref -->
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold font-mono bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60">
                                        {{ $item->EmailSubRef }}
                                    </span>
                                </td>

                                <!-- Short Description -->
                                <td class="py-3 px-3 font-semibold text-gray-900 dark:text-gray-100">
                                    <div class="truncate" title="{{ $item->EmailShortDesc }}">
                                        {{ $item->EmailShortDesc }}
                                    </div>
                                </td>

                                <!-- Long Description -->
                                <td class="py-3 px-3 text-gray-600 dark:text-gray-300">
                                    <p class="truncate" title="{{ $item->EamilLongDesc }}">
                                        {{ $item->EamilLongDesc }}
                                    </p>
                                </td>

                                <!-- Action Buttons -->
                                <td class="py-3 pl-2 pr-4 sm:pr-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <!-- Edit Button -->
                                        <button type="button" @click="openEdit(@js($item))"
                                            class="p-1.5 rounded-lg text-[#1C9BA0] hover:bg-[#1C9BA0]/10 transition-colors"
                                            title="Edit Configuration">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('auto-emails.destroy', $item->ID) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this auto-email configuration?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors"
                                                title="Delete Configuration">
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
                                <td colspan="8" class="text-center py-12 text-gray-400">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="font-bold text-gray-700 dark:text-gray-300">No email configurations found.</p>
                                    <p class="text-xs text-gray-400 mt-1">Click "+ Add Configuration" above to register an automated email rule.</p>
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
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-2xl shadow-2xl border border-gray-100 dark:border-gray-700"
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <template x-if="!edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </template>
                            <template x-if="edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </template>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100"
                                x-text="edit ? 'Edit Email Configuration' : 'Add New Email Configuration'"></h3>
                            <p class="text-xs text-gray-400">Configure automated notification trigger and descriptive identifiers.</p>
                        </div>
                    </div>

                    <button type="button" @click="close"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form :action="formAction" method="POST">
                    @csrf
                    <template x-if="edit">
                        @method('PUT')
                    </template>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Module Ref -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Module Ref (0–99) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="ModuleRef" x-model="form.ModuleRef" min="0" max="99" required
                                placeholder="e.g. 1"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>

                        <!-- Module Sub Ref -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Module Sub Ref (0–99) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="ModuleSubRef" x-model="form.ModuleSubRef" min="0" max="99" required
                                placeholder="e.g. 0"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>

                        <!-- Module Full -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Module Full Code (Max 4 chars) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="ModuleFull" x-model="form.ModuleFull" maxlength="4" required
                                placeholder="e.g. M01A"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 font-mono px-3.5 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>

                        <!-- Email Sub Ref -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Email Sub Ref (Max 3 chars) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="EmailSubRef" x-model="form.EmailSubRef" maxlength="3" required
                                placeholder="e.g. E01"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 font-mono px-3.5 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>

                        <!-- Email Short Description -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Short Description (Max 32 chars) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="EmailShortDesc" x-model="form.EmailShortDesc" maxlength="32" required
                                placeholder="e.g. Patient Booking Confirmation"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>

                        <!-- Email Long Description -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Long Description (Max 255 chars) <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="EamilLongDesc" x-model="form.EamilLongDesc" rows="3" maxlength="255" required
                                placeholder="Detailed operational explanation of when and why this automated mail is dispatched..."
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 p-3 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"></textarea>
                        </div>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end gap-2.5">
                        <button type="button" @click="close"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <span x-text="edit ? 'Save Changes' : 'Create Configuration'"></span>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <!-- Alpine CRUD Logic -->
    <script>
        function crud() {
            return {
                open: false,
                edit: false,
                form: {
                    ModuleRef: '',
                    ModuleSubRef: '',
                    ModuleFull: '',
                    EmailSubRef: '',
                    EmailShortDesc: '',
                    EamilLongDesc: ''
                },
                formAction: '',

                openCreate() {
                    this.edit = false;
                    this.form = {
                        ModuleRef: '',
                        ModuleSubRef: '',
                        ModuleFull: '',
                        EmailSubRef: '',
                        EmailShortDesc: '',
                        EamilLongDesc: ''
                    };
                    this.formAction = "{{ route('auto-emails.store') }}";
                    this.open = true;
                },

                openEdit(item) {
                    this.edit = true;
                    this.form = {
                        ModuleRef: item.ModuleRef ?? '',
                        ModuleSubRef: item.ModuleSubRef ?? '',
                        ModuleFull: item.ModuleFull ?? '',
                        EmailSubRef: item.EmailSubRef ?? '',
                        EmailShortDesc: item.EmailShortDesc ?? '',
                        EamilLongDesc: item.EamilLongDesc ?? ''
                    };
                    this.formAction = "/mod-01/tm/auto-emails/" + item.ID;
                    this.open = true;
                },

                close() {
                    this.open = false;
                }
            };
        }
    </script>
</x-app1>
