<!-- resources/views/modules/mod-01/tm/report-access.blade.php -->
<x-app1>

    @php
        $roleGroups = [
            'JMH Corporate' => [
                'color' => 'indigo',
                'roles' => [
                    'JMH_Super_Admin_90' => ['name' => 'Super Admin', 'code' => '90'],
                    'JMH_System_Admin_91' => ['name' => 'System Admin', 'code' => '91'],
                    'JMH_Finance_Admin_92' => ['name' => 'Finance Admin', 'code' => '92'],
                    'JMH_Regional_Admin_93' => ['name' => 'Regional Admin', 'code' => '93'],
                    'JMH_National_Admin_94' => ['name' => 'National Admin', 'code' => '94'],
                    'JMH_Group_Admin_95' => ['name' => 'Group Admin', 'code' => '95'],
                ]
            ],
            'Provider Group' => [
                'color' => 'amber',
                'roles' => [
                    'PRO_Group_Admin_40' => ['name' => 'Group Admin', 'code' => '40'],
                    'PRO_Group_Manager_41' => ['name' => 'Group Manager', 'code' => '41'],
                    'PRO_Group_Team_Leader_42' => ['name' => 'Team Leader', 'code' => '42'],
                ]
            ],
            'Medical Group' => [
                'color' => 'emerald',
                'roles' => [
                    'MED_Group_Admin_20' => ['name' => 'Group Admin', 'code' => '20'],
                    'MED_Group_Manager_21' => ['name' => 'Group Manager', 'code' => '21'],
                    'MED_Group_Team_leader_22' => ['name' => 'Team Leader', 'code' => '22'],
                ]
            ],
        ];

        $columns = [
            'ReportName',
            'ReportCells',
            'ReportStyle',
            'JMH_Super_Admin_90',
            'JMH_System_Admin_91',
            'JMH_Finance_Admin_92',
            'JMH_Regional_Admin_93',
            'JMH_National_Admin_94',
            'JMH_Group_Admin_95',
            'PRO_Group_Admin_40',
            'PRO_Group_Manager_41',
            'PRO_Group_Team_Leader_42',
            'MED_Group_Admin_20',
            'MED_Group_Manager_21',
            'MED_Group_Team_leader_22',
        ];
    @endphp

    <div class="max-w-7xl mx-auto space-y-6" x-data="crud()" x-cloak>

        <!-- Page Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />

            <div class="flex items-center gap-2.5 flex-wrap self-start sm:self-auto">
                <!-- Add Report Permission Button -->
                <button type="button" @click="openCreate"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Report Permission</span>
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
            <!-- Stat 1: Total Reports Configured -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Configured Reports</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-0.5">{{ $items->total() }}</p>
                    <p class="text-[11px] text-gray-400">Registered Access Rules</p>
                </div>
            </div>

            <!-- Stat 2: Roles Covered -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Role Tiers Matrix</p>
                    <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-0.5">12 Roles</p>
                    <p class="text-[11px] text-gray-400">JMH, Provider & Medical</p>
                </div>
            </div>

            <!-- Stat 3: Scope Badge -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Security Control</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 mt-0.5">MOD-01 Administration</p>
                    <p class="text-[11px] text-gray-400">Role-Based Access Control</p>
                </div>
            </div>
        </div>

        <!-- Main Permission Matrix Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                         style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Report Access Permissions Matrix</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Configure report generation rights across Corporate, Provider, and Medical roles.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                        {{ $items->total() }} Report Rules
                    </span>
                </div>
            </div>

            <!-- Scroll helper note -->
            <div class="px-4 py-2.5 bg-gray-50/80 dark:bg-gray-900/40 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                <span class="flex items-center gap-1.5 font-medium text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Scroll horizontally to review all 12 role access columns</span>
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

            <!-- Table Container with Horizontal Scroll -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1360px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/60 dark:bg-gray-900/40 text-[11px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            <th class="py-3.5 pl-4 sm:pl-6 pr-3 text-center whitespace-nowrap">#</th>

                            @foreach ($columns as $col)
                                <th class="py-3.5 px-3 whitespace-nowrap {{ in_array($col, ['ReportName']) ? 'text-left' : 'text-center' }}">
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

                            <th class="py-3.5 pl-2 pr-4 sm:pr-6 text-right whitespace-nowrap">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-xs sm:text-sm">
                        @forelse ($items as $index => $item)
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-colors group">
                                <!-- # -->
                                <td class="py-3.5 pl-4 sm:pl-6 pr-3 text-center font-mono font-bold text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                    {{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }}
                                </td>

                                <!-- ReportName -->
                                <td class="py-3.5 px-3 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ $item->ReportName }}
                                </td>

                                <!-- ReportCells -->
                                <td class="py-3.5 px-3 text-center whitespace-nowrap font-mono font-bold text-xs text-gray-700 dark:text-gray-200">
                                    {{ $item->ReportCells }}
                                </td>

                                <!-- ReportStyle -->
                                <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                                        {{ $item->ReportStyle }}
                                    </span>
                                </td>

                                <!-- 12 Role Columns -->
                                @foreach ([
                                    'JMH_Super_Admin_90', 'JMH_System_Admin_91', 'JMH_Finance_Admin_92',
                                    'JMH_Regional_Admin_93', 'JMH_National_Admin_94', 'JMH_Group_Admin_95',
                                    'PRO_Group_Admin_40', 'PRO_Group_Manager_41', 'PRO_Group_Team_Leader_42',
                                    'MED_Group_Admin_20', 'MED_Group_Manager_21', 'MED_Group_Team_leader_22'
                                ] as $colKey)
                                    <td class="py-3.5 px-3 text-center whitespace-nowrap font-mono text-xs font-bold {{ $item->$colKey == 1 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' }}">
                                        {{ $item->$colKey }}
                                    </td>
                                @endforeach

                                <!-- Action Buttons -->
                                <td class="py-3.5 pl-2 pr-4 sm:pr-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <!-- Edit Button -->
                                        <button type="button" @click="openEdit(@js($item))"
                                            class="p-1.5 rounded-lg text-[#1C9BA0] hover:bg-[#1C9BA0]/10 transition-colors"
                                            title="Edit Permission">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('report-access.destroy', $item->ID) }}"
                                            onsubmit="return confirm('Delete this report permission?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors"
                                                title="Delete Permission">
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
                                <td colspan="17" class="text-center py-12 text-gray-400">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="font-bold text-gray-700 dark:text-gray-300">No report permissions found.</p>
                                    <p class="text-xs text-gray-400 mt-1">Click "+ Add Report Permission" above to register access rules.</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100"
                                x-text="edit ? 'Edit Report Permission' : 'Add Report Permission'"></h3>
                            <p class="text-xs text-gray-400">Configure report details and assign role permissions.</p>
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

                    <!-- Section 1: General Report Info -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                            Report Information
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Report Name -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Report Name <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="ReportName" x-model="form.ReportName" maxlength="48" required
                                    placeholder="e.g. Therapist Monthly Activity"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                                <p class="text-[11px] text-gray-400 mt-1">Unique report title (max 48 characters)</p>
                            </div>

                            <!-- Report Cells -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Report Cells <span class="text-rose-500">*</span>
                                </label>
                                <select name="ReportCells" x-model="form.ReportCells" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm font-mono font-bold focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                                    <option :value="1">1</option>
                                    <option :value="0">0</option>
                                </select>
                                <p class="text-[11px] text-gray-400 mt-1">Value (0 or 1)</p>
                            </div>

                            <!-- Report Style -->
                            <div class="sm:col-span-3">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">
                                    Report Style <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="ReportStyle" x-model="form.ReportStyle" maxlength="16" required
                                    placeholder="e.g. Pie Chart, Grid, Summary"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#1C9BA0]/30 focus:border-[#1C9BA0] transition-all">
                                <p class="text-[11px] text-gray-400 mt-1">Presentation style (max 16 characters)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Role Permissions Matrix -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Role Access Permissions
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

                        <!-- JMH Corporate Group (6 roles) -->
                        <div class="mb-4 p-4 rounded-2xl bg-indigo-50/30 dark:bg-indigo-950/15 border border-indigo-100/60 dark:border-indigo-900/40">
                            <p class="text-xs font-bold text-indigo-900 dark:text-indigo-200 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                JMH Corporate Roles (90 - 95)
                            </p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                @foreach ($roleGroups['JMH Corporate']['roles'] as $colKey => $role)
                                    <div>
                                        <input type="hidden" name="{{ $colKey }}" :value="form['{{ $colKey }}']">
                                        <button type="button" @click="toggle('{{ $colKey }}')"
                                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl border text-xs font-semibold transition-all"
                                            :class="form['{{ $colKey }}'] == 1
                                                ? 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 shadow-2xs'
                                                : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-gray-300'">
                                            <span class="truncate">{{ $role['name'] }} ({{ $role['code'] }})</span>
                                            <span class="w-6 h-6 rounded-md flex items-center justify-center font-mono font-bold text-xs shrink-0 ml-1.5"
                                                :class="form['{{ $colKey }}'] == 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'">
                                                <span x-text="form['{{ $colKey }}']"></span>
                                            </span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Provider Group (3 roles) -->
                        <div class="mb-4 p-4 rounded-2xl bg-amber-50/30 dark:bg-amber-950/15 border border-amber-100/60 dark:border-amber-900/40">
                            <p class="text-xs font-bold text-amber-900 dark:text-amber-200 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Provider Group (40 - 42)
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                @foreach ($roleGroups['Provider Group']['roles'] as $colKey => $role)
                                    <div>
                                        <input type="hidden" name="{{ $colKey }}" :value="form['{{ $colKey }}']">
                                        <button type="button" @click="toggle('{{ $colKey }}')"
                                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl border text-xs font-semibold transition-all"
                                            :class="form['{{ $colKey }}'] == 1
                                                ? 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 shadow-2xs'
                                                : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-gray-300'">
                                            <span class="truncate">{{ $role['name'] }} ({{ $role['code'] }})</span>
                                            <span class="w-6 h-6 rounded-md flex items-center justify-center font-mono font-bold text-xs shrink-0 ml-1.5"
                                                :class="form['{{ $colKey }}'] == 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'">
                                                <span x-text="form['{{ $colKey }}']"></span>
                                            </span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Medical Group (3 roles) -->
                        <div class="p-4 rounded-2xl bg-emerald-50/30 dark:bg-emerald-950/15 border border-emerald-100/60 dark:border-emerald-900/40">
                            <p class="text-xs font-bold text-emerald-900 dark:text-emerald-200 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Medical Group (20 - 22)
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                @foreach ($roleGroups['Medical Group']['roles'] as $colKey => $role)
                                    <div>
                                        <input type="hidden" name="{{ $colKey }}" :value="form['{{ $colKey }}']">
                                        <button type="button" @click="toggle('{{ $colKey }}')"
                                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl border text-xs font-semibold transition-all"
                                            :class="form['{{ $colKey }}'] == 1
                                                ? 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 shadow-2xs'
                                                : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-gray-300'">
                                            <span class="truncate">{{ $role['name'] }} ({{ $role['code'] }})</span>
                                            <span class="w-6 h-6 rounded-md flex items-center justify-center font-mono font-bold text-xs shrink-0 ml-1.5"
                                                :class="form['{{ $colKey }}'] == 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'">
                                                <span x-text="form['{{ $colKey }}']"></span>
                                            </span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
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
                            <span x-text="edit ? 'Update Permissions' : 'Save Permissions'"></span>
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
                    ReportName: '',
                    ReportCells: 1,
                    ReportStyle: 'Standard',
                    JMH_Super_Admin_90: 1,
                    JMH_System_Admin_91: 0,
                    JMH_Finance_Admin_92: 0,
                    JMH_Regional_Admin_93: 0,
                    JMH_National_Admin_94: 0,
                    JMH_Group_Admin_95: 0,
                    PRO_Group_Admin_40: 0,
                    PRO_Group_Manager_41: 0,
                    PRO_Group_Team_Leader_42: 0,
                    MED_Group_Admin_20: 0,
                    MED_Group_Manager_21: 0,
                    MED_Group_Team_leader_22: 0,
                },
                formAction: '',
                openCreate() {
                    this.edit = false;
                    this.form = {
                        ReportName: '',
                        ReportCells: 1,
                        ReportStyle: 'Standard',
                        JMH_Super_Admin_90: 1,
                        JMH_System_Admin_91: 0,
                        JMH_Finance_Admin_92: 0,
                        JMH_Regional_Admin_93: 0,
                        JMH_National_Admin_94: 0,
                        JMH_Group_Admin_95: 0,
                        PRO_Group_Admin_40: 0,
                        PRO_Group_Manager_41: 0,
                        PRO_Group_Team_Leader_42: 0,
                        MED_Group_Admin_20: 0,
                        MED_Group_Manager_21: 0,
                        MED_Group_Team_leader_22: 0,
                    };
                    this.formAction = "{{ route('report-access.store') }}";
                    this.open = true;
                },
                openEdit(item) {
                    this.edit = true;
                    this.form = {
                        ReportName: item.ReportName || '',
                        ReportCells: item.ReportCells !== undefined ? item.ReportCells : 1,
                        ReportStyle: item.ReportStyle || 'Standard',
                        JMH_Super_Admin_90: item.JMH_Super_Admin_90 ?? 0,
                        JMH_System_Admin_91: item.JMH_System_Admin_91 ?? 0,
                        JMH_Finance_Admin_92: item.JMH_Finance_Admin_92 ?? 0,
                        JMH_Regional_Admin_93: item.JMH_Regional_Admin_93 ?? 0,
                        JMH_National_Admin_94: item.JMH_National_Admin_94 ?? 0,
                        JMH_Group_Admin_95: item.JMH_Group_Admin_95 ?? 0,
                        PRO_Group_Admin_40: item.PRO_Group_Admin_40 ?? 0,
                        PRO_Group_Manager_41: item.PRO_Group_Manager_41 ?? 0,
                        PRO_Group_Team_Leader_42: item.PRO_Group_Team_Leader_42 ?? 0,
                        MED_Group_Admin_20: item.MED_Group_Admin_20 ?? 0,
                        MED_Group_Manager_21: item.MED_Group_Manager_21 ?? 0,
                        MED_Group_Team_leader_22: item.MED_Group_Team_leader_22 ?? 0,
                    };
                    this.formAction = "/mod-01/tm/report-access/" + item.ID;
                    this.open = true;
                },
                toggle(key) {
                    this.form[key] = (this.form[key] == 1) ? 0 : 1;
                },
                setAllRoles(val) {
                    const roleKeys = [
                        'JMH_Super_Admin_90', 'JMH_System_Admin_91', 'JMH_Finance_Admin_92',
                        'JMH_Regional_Admin_93', 'JMH_National_Admin_94', 'JMH_Group_Admin_95',
                        'PRO_Group_Admin_40', 'PRO_Group_Manager_41', 'PRO_Group_Team_Leader_42',
                        'MED_Group_Admin_20', 'MED_Group_Manager_21', 'MED_Group_Team_leader_22'
                    ];
                    roleKeys.forEach(k => { this.form[k] = val; });
                },
                close() {
                    this.open = false;
                }
            }
        }
    </script>
</x-app1>