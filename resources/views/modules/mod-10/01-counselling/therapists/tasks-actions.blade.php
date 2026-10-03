<x-app1>
    <div x-data="taskManager()" class="space-y-6">

        <!-- Page Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <x-page-header />
            <div>
                <button @click="openAdd = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Create New Task</span>
                </button>
            </div>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Tasks -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Total Tasks</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-0.5 truncate" x-text="tasks.length"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">All recorded action items</p>
                </div>
            </div>

            <!-- Card 2: Active / In Progress -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Pending & In Progress</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-0.5 truncate" x-text="activeTasksCount"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Requires attention</p>
                </div>
            </div>

            <!-- Card 3: Completed Tasks -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">Completed</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-0.5 truncate" x-text="completedTasksCount"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Successfully closed</p>
                </div>
            </div>

            <!-- Card 4: High & Urgent Priority -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400">High / Urgent</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-rose-600 dark:text-rose-400 mt-0.5 truncate" x-text="urgentTasksCount"></p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-400 truncate">Critical priority items</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 lg:gap-5 items-end">
                <!-- Search Task Title -->
                <div class="w-full lg:col-span-3">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Task Title</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search title..." x-model="filters.title"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                    </div>
                </div>

                <!-- Assigned To -->
                <div class="w-full lg:col-span-2">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Assigned To</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search assigned to..." x-model="filters.assignedTo"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                    </div>
                </div>

                <!-- Date Range (From - To) -->
                <div class="w-full sm:col-span-2 lg:col-span-4">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Due Date Range</label>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1 min-w-0">
                            <input type="date" x-model="filters.dateFrom" title="From Date"
                                class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                        </div>
                        <span class="text-gray-400 text-xs font-semibold shrink-0">to</span>
                        <div class="relative flex-1 min-w-0">
                            <input type="date" x-model="filters.dateTo" title="To Date"
                                class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs" />
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:col-span-1 lg:col-span-2">
                    <label class="block mb-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">Status</label>
                    <select x-model="filters.status"
                        class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        <option value="">All Statuses</option>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Closed">Completed</option>
                    </select>
                </div>

                <!-- Actions: Clear Filters -->
                <div class="w-full sm:col-span-1 lg:col-span-1">
                    <button @click="clearFilters"
                        class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Task List Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
            <!-- Header bar inside task container -->
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/30">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm sm:text-base">Task Queue</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20"
                          x-text="filteredTasks.length + ' ' + (filteredTasks.length === 1 ? 'task' : 'tasks')">
                    </span>
                </div>
                <!-- Quick Filter Tabs -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                    <button @click="filters.status = ''"
                        :class="filters.status === '' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        All
                    </button>
                    <button @click="filters.status = 'Open'"
                        :class="filters.status === 'Open' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        Open
                    </button>
                    <button @click="filters.status = 'In Progress'"
                        :class="filters.status === 'In Progress' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        In Progress
                    </button>
                    <button @click="filters.status = 'Closed'"
                        :class="filters.status === 'Closed' ? 'bg-[#1C9BA0] text-white shadow-xs' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition-all">
                        Completed
                    </button>
                </div>
            </div>

            <!-- Task Items List -->
            <div class="divide-y divide-gray-100 dark:divide-gray-700/70">
                <template x-for="task in filteredTasks" :key="task.id">
                    <div class="p-4 sm:p-5 hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                        <!-- Left Details -->
                        <div class="flex-1 min-w-0 space-y-2">
                            <!-- Badges Row -->
                            <div class="flex items-center gap-2 flex-wrap text-xs">
                                <!-- Status Badge -->
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full font-medium"
                                      :class="{
                                          'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60': task.status === 'Closed',
                                          'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60': task.status === 'Open',
                                          'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/60': task.status === 'In Progress',
                                          'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60': task.status === 'On Hold'
                                      }">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                          :class="{
                                              'bg-emerald-500': task.status === 'Closed',
                                              'bg-blue-500': task.status === 'Open',
                                              'bg-indigo-500': task.status === 'In Progress',
                                              'bg-amber-500': task.status === 'On Hold'
                                          }"></span>
                                    <span x-text="task.status === 'Closed' ? 'Completed' : task.status"></span>
                                </span>

                                <!-- Priority Badge -->
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md font-semibold text-[11px]"
                                      :class="{
                                          'bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300 border border-red-200 dark:border-red-800/60': task.priority === 'Urgent',
                                          'bg-orange-50 text-orange-700 dark:bg-orange-950/40 dark:text-orange-300 border border-orange-200 dark:border-orange-800/60': task.priority === 'High',
                                          'bg-teal-50 text-[#1C9BA0] dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-teal-800/60': task.priority === 'Medium',
                                          'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600': task.priority === 'Low' || !task.priority
                                      }">
                                    <span x-text="(task.priority || 'Medium') + ' Priority'"></span>
                                </span>

                                <!-- Due Date Badge with Overdue Indicator -->
                                <template x-if="task.dueDate">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium"
                                          :class="isOverdue(task)
                                              ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60'
                                              : 'bg-gray-50 text-gray-600 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-200 dark:border-gray-700'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Due: <span x-text="task.dueDate"></span></span>
                                        <span x-show="isOverdue(task)" class="font-bold text-rose-600 dark:text-rose-400">(Overdue)</span>
                                    </span>
                                </template>

                                <!-- Assigned To -->
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-50 text-gray-600 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-200 dark:border-gray-700 text-[11px] font-medium">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Assigned: <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="task.assignedTo || 'Unassigned'"></span></span>
                                </span>
                            </div>

                            <!-- Title -->
                            <h4 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 transition-colors"
                                x-text="task.title || 'Untitled Task'">
                            </h4>

                            <!-- Notes Preview -->
                            <template x-if="task.notes">
                                <div class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-3 border border-gray-100 dark:border-gray-800 text-xs text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-wrap break-words max-w-3xl"
                                     x-text="task.notes.length > 220 ? task.notes.substring(0, 220) + '...' : task.notes">
                                </div>
                            </template>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-2 self-start md:self-center shrink-0 pt-2 md:pt-0">
                            <!-- Quick Mark Complete Button -->
                            <template x-if="task.status !== 'Closed'">
                                <button @click="quickMarkComplete(task)" title="Mark as Completed"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Complete</span>
                                </button>
                            </template>

                            <!-- View Details Button -->
                            <button @click="openStart(task)" title="View Task Details"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 dark:bg-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Details</span>
                            </button>

                            <!-- Edit Button -->
                            <button @click="openEdit(task)" title="Edit Task"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1C9BA0]/10 hover:bg-[#1C9BA0]/20 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 dark:text-teal-300 border border-[#1C9BA0]/30 rounded-xl text-xs font-semibold transition-all shadow-2xs active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="filteredTasks.length === 0" class="py-16 text-center px-4">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-gray-800 dark:text-gray-200">No tasks found</h4>
                    <p class="text-xs sm:text-sm text-gray-400 mt-1 max-w-sm mx-auto">
                        No tasks match your current filter criteria. Try resetting filters or create a new task.
                    </p>
                    <div class="mt-4 flex items-center justify-center gap-3">
                        <button @click="clearFilters"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-2xs">
                            Clear Filters
                        </button>
                        <button @click="openAdd = true"
                            class="px-4 py-2 bg-[#1C9BA0] text-white rounded-xl text-xs font-semibold hover:brightness-105 transition shadow-2xs">
                            + Add Task
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Task Modal -->
        <div x-show="openAdd" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto"
                 @click.away="openAdd = false"
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Create New Task</h3>
                            <p class="text-xs text-gray-400">Add an action item or reminder to your schedule</p>
                        </div>
                    </div>
                    <button @click="openAdd = false" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form @submit.prevent="addTask" class="space-y-4 mt-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">
                            Task Title <span class="text-rose-500">*</span>
                        </label>
                        <input x-model="newTask.TaskTitle" required placeholder="e.g. Prepare therapy notes for review"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Notes / Instructions</label>
                        <textarea x-model="newTask.TaskNotes" rows="3" placeholder="Add any details, context or instructions..."
                                  class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Assign To</label>
                        <select x-model="newTask.TaskAssignedTo"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="Self">Self (Me)</option>
                            <option value="Patient">Patient</option>
                            <option value="Assistant">Assistant</option>
                            <option value="Team Leader">Team Leader</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Due Date</label>
                            <input x-model="newTask.DueDate" type="date"
                                   class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Priority</label>
                            <select x-model="newTask.TaskPrioity"
                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Initial Status</label>
                        <select x-model="newTask.TaskStatus"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Closed">Completed</option>
                        </select>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="openAdd = false"
                            class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Create Task</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Task Details / View Modal -->
        <div x-show="openStartModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto"
                 @click.away="openStartModal = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/40 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Task Overview</h3>
                            <p class="text-xs text-gray-400">Detailed task parameters and progress status</p>
                        </div>
                    </div>
                    <button @click="openStartModal = false" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content Details -->
                <div class="space-y-4 mt-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Title</span>
                        <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 mt-0.5" x-text="selectedTask.title || 'Untitled'"></h4>
                    </div>

                    <div class="grid grid-cols-2 gap-3 bg-gray-50 dark:bg-gray-900/40 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Status</span>
                            <span class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                  :class="{
                                      'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300': selectedTask.status === 'Closed',
                                      'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300': selectedTask.status === 'Open',
                                      'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300': selectedTask.status === 'In Progress',
                                      'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300': selectedTask.status === 'On Hold'
                                  }"
                                  x-text="selectedTask.status === 'Closed' ? 'Completed' : (selectedTask.status || 'Open')">
                            </span>
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Priority</span>
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1 inline-block" x-text="selectedTask.priority || 'Medium'"></span>
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Assigned To</span>
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1 inline-block" x-text="selectedTask.assignedTo || 'Unassigned'"></span>
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Due Date</span>
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1 inline-block" x-text="selectedTask.dueDate || 'No date set'"></span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-1">Notes & Instructions</span>
                        <div class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-3.5 border border-gray-100 dark:border-gray-800 text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap break-words min-h-[60px]"
                             x-text="selectedTask.notes || 'No notes provided for this task.'">
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-between gap-3 pt-5 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" @click="openStartModal = false"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                        Close
                    </button>

                    <div class="flex items-center gap-2">
                        <!-- Mark as Completed button for unclosed tasks -->
                        <button x-show="selectedTask.status !== 'Closed'" @click="markCompleted()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Mark Completed</span>
                        </button>

                        <button @click="openStartModal = false; openEdit(selectedTask)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#1C9BA0] hover:brightness-105 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Edit</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto"
                 @click.away="openEditModal = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/40 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Edit Task</h3>
                            <p class="text-xs text-gray-400">Modify task attributes, status or due date</p>
                        </div>
                    </div>
                    <button @click="openEditModal = false" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form @submit.prevent="updateTask" class="space-y-4 mt-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">
                            Task Title <span class="text-rose-500">*</span>
                        </label>
                        <input x-model="editTask.TaskTitle" required
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Notes / Instructions</label>
                        <textarea x-model="editTask.TaskNotes" rows="3"
                                  class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Assign To</label>
                        <select x-model="editTask.TaskAssignedTo"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="Self">Self (Me)</option>
                            <option value="Patient">Patient</option>
                            <option value="Assistant">Assistant</option>
                            <option value="Team Leader">Team Leader</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Due Date</label>
                            <input x-model="editTask.DueDate" type="date"
                                   class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Priority</label>
                            <select x-model="editTask.TaskPrioity"
                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Status</label>
                        <select x-model="editTask.TaskStatus"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Closed">Completed</option>
                        </select>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="deleteTask()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Delete</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="openEditModal = false"
                                class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-95">
                                Cancel
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:brightness-105 active:scale-95"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function taskManager() {
            return {
                openAdd: false,
                openStartModal: false,
                openEditModal: false,
                selectedTask: {},
                editTask: {},
                filters: { title: '', assignedTo: '', dateFrom: '', dateTo: '', status: '' },
                newTask: { TaskTitle: '', TaskNotes: '', TaskAssignedTo: 'Self', DueDate: '', TaskPrioity: 'Medium', TaskStatus: 'Open' },
                tasks: (function () {
                    const raw = @json($tasks ?? []);
                    return raw.map(t => ({
                        id: t.ID,
                        TaskModel: t,
                        title: t.TaskTitle || '',
                        assignedTo: t.TaskAssignedTo || '',
                        dueDate: t.DueDate || '',
                        priority: t.TaskPrioity || '',
                        status: t.TaskStatus || '',
                        notes: t.TaskNotes || '',
                        PatientUserID: t.PatientUserID || null,
                    }));
                })(),
                patients: @json($patients ?? []),

                // Computed metrics
                get activeTasksCount() {
                    return this.tasks.filter(t => t.status === 'Open' || t.status === 'In Progress').length;
                },
                get completedTasksCount() {
                    return this.tasks.filter(t => t.status === 'Closed').length;
                },
                get urgentTasksCount() {
                    return this.tasks.filter(t => t.priority === 'Urgent' || t.priority === 'High').length;
                },

                // Overdue helper
                isOverdue(task) {
                    if (!task.dueDate || task.status === 'Closed') return false;
                    const due = new Date(task.dueDate + 'T23:59:59');
                    return due < new Date();
                },

                // Filtered tasks list
                get filteredTasks() {
                    return this.tasks.filter(t => {
                        const match = (val, term) => (val || '').toLowerCase().includes(term.toLowerCase());
                        const matchesTitle = !this.filters.title || match(t.title, this.filters.title);
                        const matchesAssigned = !this.filters.assignedTo || match(t.assignedTo, this.filters.assignedTo);
                        const matchesStatus = !this.filters.status || t.status === this.filters.status;

                        const from = this.filters.dateFrom ? new Date(this.filters.dateFrom + 'T00:00:00') : null;
                        const to = this.filters.dateTo ? new Date(this.filters.dateTo + 'T23:59:59') : null;
                        const due = t.dueDate ? new Date(t.dueDate + 'T12:00:00') : null;
                        const matchesDate = !due || ((!from || due >= from) && (!to || due <= to));

                        return matchesTitle && matchesAssigned && matchesStatus && matchesDate;
                    });
                },

                clearFilters() {
                    this.filters = { title: '', assignedTo: '', dateFrom: '', dateTo: '', status: '' };
                },

                async addTask() {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const payload = {
                            TaskTitle: this.newTask.TaskTitle,
                            TaskNotes: this.newTask.TaskNotes || null,
                            TaskAssignedTo: this.newTask.TaskAssignedTo,
                            DueDate: this.newTask.DueDate || null,
                            TaskPrioity: this.newTask.TaskPrioity || 'Medium',
                            TaskStatus: this.newTask.TaskStatus || 'Open',
                        };

                        const res = await fetch('/mod-10/my-tasks/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        const data = await res.json();
                        if (!res.ok) throw new Error(data.error || 'Create failed');

                        const t = data.task;
                        this.tasks.unshift({
                            id: t.ID,
                            TaskModel: t,
                            title: t.TaskTitle,
                            assignedTo: t.TaskAssignedTo,
                            dueDate: t.DueDate,
                            priority: t.TaskPrioity,
                            status: t.TaskStatus,
                            notes: t.TaskNotes,
                            PatientUserID: t.PatientUserID || null,
                        });

                        this.newTask = { TaskTitle: '', TaskNotes: '', TaskAssignedTo: 'Self', DueDate: '', TaskPrioity: 'Medium', TaskStatus: 'Open' };
                        this.openAdd = false;
                    } catch (err) {
                        alert('Error creating task: ' + err.message);
                    }
                },

                openStart(task) {
                    this.selectedTask = task;
                    this.openStartModal = true;
                },

                async markCompleted() {
                    const task = this.selectedTask;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const payload = { ID: task.id, TaskStatus: 'Closed' };
                        const res = await fetch('/mod-10/my-tasks/update', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.error || 'Update failed');
                        task.status = 'Closed';
                        this.openStartModal = false;
                    } catch (err) {
                        alert('Error updating task: ' + err.message);
                    }
                },

                async quickMarkComplete(task) {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const payload = { ID: task.id, TaskStatus: 'Closed' };
                        const res = await fetch('/mod-10/my-tasks/update', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.error || 'Update failed');
                        task.status = 'Closed';
                    } catch (err) {
                        alert('Error completing task: ' + err.message);
                    }
                },

                openEdit(task) {
                    this.editTask = {
                        ID: task.id,
                        TaskTitle: task.title,
                        TaskAssignedTo: task.assignedTo,
                        DueDate: task.dueDate,
                        TaskPrioity: task.priority || 'Medium',
                        TaskStatus: task.status || 'Open',
                        TaskNotes: task.notes || '',
                        PatientUserID: task.PatientUserID || null,
                    };
                    this.openEditModal = true;
                },

                async updateTask() {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const payload = { ...this.editTask };
                        const res = await fetch('/mod-10/my-tasks/update', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.error || 'Update failed');

                        const idx = this.tasks.findIndex(t => t.id === this.editTask.ID);
                        if (idx !== -1) {
                            const t = data.task;
                            this.tasks[idx] = {
                                id: t.ID,
                                TaskModel: t,
                                title: t.TaskTitle,
                                assignedTo: t.TaskAssignedTo,
                                dueDate: t.DueDate,
                                priority: t.TaskPrioity,
                                status: t.TaskStatus,
                                notes: t.TaskNotes,
                                PatientUserID: t.PatientUserID || null,
                            };
                            if (this.selectedTask && this.selectedTask.id === t.ID) {
                                this.selectedTask = this.tasks[idx];
                            }
                        }

                        this.openEditModal = false;
                    } catch (err) {
                        alert('Error updating task: ' + err.message);
                    }
                },

                async deleteTask() {
                    if (!confirm('Are you sure you want to delete this task?')) return;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const res = await fetch('/mod-10/my-tasks/delete', {
                            method: 'DELETE',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                            body: JSON.stringify({ ID: this.editTask.ID })
                        });
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.error || 'Delete failed');

                        this.tasks = this.tasks.filter(t => t.id !== this.editTask.ID);
                        this.openEditModal = false;
                    } catch (err) {
                        alert('Error deleting task: ' + err.message);
                    }
                }
            };
        }
    </script>
</x-app1>
