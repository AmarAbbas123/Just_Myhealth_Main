<x-app1>

    <div class="max-w-7xl mx-auto space-y-6" x-data="therapistCalendar()" x-init="init()" :style="`--rows:${timeRows.length}`">

        <!-- Page Header -->
        <x-page-header />

        <!-- Status Bar & Actions (Below Header) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 flex-wrap">
            <!-- Left: Timezone Chip & Slot Legend -->
            <div class="flex items-center gap-3 flex-wrap">
                <!-- Timezone Badge -->
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $displayTimeZone }}</span>
                </span>

                <!-- Legend -->
                <div class="hidden md:flex items-center gap-2.5 text-xs text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Available
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border border-rose-200/60 dark:border-rose-800/60 font-medium">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Booked
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 font-medium">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        Past / Expired
                    </span>
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <button type="button" @click="goToday()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 transition-all shadow-2xs hover:shadow-xs active:scale-95">
                    <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Today</span>
                </button>

                <button type="button" @click="openManualCreateModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Availability</span>
                </button>
            </div>
        </div>

        <!-- Main Calendar Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl p-2.5 sm:p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)]">

            <!-- Week Controls Toolbar -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pb-3 mb-3 border-b border-gray-100 dark:border-gray-700/80">
                <div class="flex items-center justify-between sm:justify-start gap-2">
                    <div class="flex items-center gap-1.5">
                        <button type="button" @click="moveWeek(-1)"
                            class="p-2 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/60 text-gray-600 dark:text-gray-300 transition-all shadow-2xs active:scale-95"
                            title="Previous Week">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <button type="button" @click="moveWeek(1)"
                            class="p-2 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/60 text-gray-600 dark:text-gray-300 transition-all shadow-2xs active:scale-95"
                            title="Next Week">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <span class="text-xs sm:text-sm font-bold text-gray-800 dark:text-gray-200" x-text="formatWeekRange()"></span>
                </div>

                <!-- Mobile-Only Guidance Helper -->
                <div class="sm:hidden text-[11px] text-gray-400 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Swipe horizontally to view all days. Tap a cell to add 1h availability.</span>
                </div>
            </div>

            <!-- Mobile Quick-Jump Day Pills -->
            <div class="sm:hidden flex items-center gap-1.5 overflow-x-auto pb-2 mb-2 no-scrollbar">
                <template x-for="(date, idx) in weekDates" :key="'chip-' + date">
                    <button type="button" @click="scrollToDay(date)"
                        class="px-2.5 py-1 rounded-xl text-[11px] font-semibold transition-all shrink-0 border"
                        :class="isSameDay(date, nowInUserTimeZone().date) 
                            ? 'bg-[#1C9BA0] text-white border-[#1C9BA0] shadow-xs' 
                            : 'bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-100'">
                        <span x-text="new Date(date + 'T12:00:00').toLocaleDateString('en-US', { weekday: 'short' })"></span>
                        <span class="opacity-80 ml-0.5" x-text="new Date(date + 'T12:00:00').getDate()"></span>
                    </button>
                </template>
            </div>

            <!-- Calendar Grid Container -->
            <div id="calendar-grid-container" class="overflow-x-auto rounded-2xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 scroll-smooth">
                <div class="flex min-w-[780px] sm:min-w-[840px]">

                    <!-- Sticky Left Time Column -->
                    <div class="sticky left-0 z-30 shrink-0 w-16 sm:w-20 bg-gray-50 dark:bg-gray-900 border-r border-gray-300 dark:border-gray-600 shadow-[2px_0_6px_-1px_rgba(0,0,0,0.06)]">
                        <!-- Top-Left Corner Header -->
                        <div class="h-12 bg-gray-100 dark:bg-gray-900 border-b border-gray-300 dark:border-gray-600 flex items-center justify-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            <svg class="w-3.5 h-3.5 mr-1 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Time
                        </div>
                        <!-- Time Cells -->
                        <template x-for="time in timeRows" :key="time">
                            <div class="h-12 text-[11px] font-mono font-semibold text-gray-600 dark:text-gray-300 pr-2 border-b border-gray-300 dark:border-gray-600 flex items-center justify-end"
                                 x-text="time"></div>
                        </template>
                    </div>

                    <!-- 7 Days Grid Columns -->
                    <div class="flex-1 grid grid-cols-7 min-w-[700px]">
                        <template x-for="date in weekDates" :key="date">
                            <div :id="'day-col-' + date"
                                 class="flex flex-col border-r border-gray-300 dark:border-gray-600 last:border-r-0 min-w-[100px] sm:min-w-0"
                                 :class="isSameDay(date, nowInUserTimeZone().date) ? 'bg-[#1C9BA0]/[0.03]' : ''">

                                <!-- Day Header Cell -->
                                <div class="h-12 bg-gray-100 dark:bg-gray-900 border-b border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center relative"
                                     :class="isSameDay(date, nowInUserTimeZone().date) ? 'bg-[#1C9BA0]/10 dark:bg-[#1C9BA0]/20' : ''">
                                    <div class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-gray-100"
                                         x-text="new Date(date + 'T12:00:00').toLocaleDateString('en-US', { weekday: 'short' })"></div>
                                    <div class="text-[11px] font-semibold text-gray-600 dark:text-gray-300"
                                         x-text="new Date(date + 'T12:00:00').toLocaleDateString('en-US', { day: '2-digit', month: 'short' })"></div>
                                    <template x-if="isSameDay(date, nowInUserTimeZone().date)">
                                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#1C9BA0]"></div>
                                    </template>
                                </div>

                                <!-- Day Body with Slots -->
                                <div class="relative">
                                    <!-- Grid 30-min Cells -->
                                    <template x-for="time in timeRows" :key="time">
                                        <div class="h-12 border-b border-gray-300 dark:border-gray-600 transition-colors"
                                             :class="isPastDateTime(date, time) ? 'bg-gray-100/70 dark:bg-gray-900/50 cursor-not-allowed opacity-70' : 'cursor-pointer hover:bg-[#1C9BA0]/10 dark:hover:bg-[#1C9BA0]/20'"
                                             @click="openCreateModal(date, time)"></div>
                                    </template>

                                    <!-- Carry-over slots from previous day -->
                                    <template x-for="slot in carryOverSlotsForDate(date)" :key="`carry-${slot.id}-${date}`">
                                        <div class="absolute left-1 right-1 rounded-xl p-2 text-xs transition-all shadow-xs"
                                            :class="[slotClass(slot), (isReadOnlySlot(slot.type) || isPastSlot(slot)) ? 'cursor-not-allowed opacity-90' : 'cursor-pointer hover:shadow-md hover:scale-[1.01] active:scale-95']"
                                            :title="isPastSlot(slot) ? 'Past slot (read-only)' : (isReadOnlySlot(slot.type) ? 'Booked slot (read-only)' : 'Click to edit or remove')"
                                            :style="carryOverSlotStyle(slot)"
                                            @click.stop="editSlot(slot)">
                                            <div class="font-bold flex items-center justify-between gap-1">
                                                <span class="truncate" x-text="slot.type === 'Available' ? 'Available' : 'Booked'"></span>
                                                <template x-if="slot.type === 'Busy'">
                                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                </template>
                                            </div>
                                            <div class="text-[10px] font-mono opacity-90 truncate mt-0.5" x-text="slot.time_from + ' - ' + slot.time_to"></div>
                                        </div>
                                    </template>

                                    <!-- Regular Slots -->
                                    <template x-for="slot in slotsForDate(date)" :key="slot.id">
                                        <div class="absolute left-1 right-1 rounded-xl p-2 text-xs transition-all shadow-xs"
                                            :class="[slotClass(slot), (isReadOnlySlot(slot.type) || isPastSlot(slot)) ? 'cursor-not-allowed opacity-90' : 'cursor-pointer hover:shadow-md hover:scale-[1.01] active:scale-95']"
                                            :title="isPastSlot(slot) ? 'Past slot (read-only)' : (isReadOnlySlot(slot.type) ? 'Booked slot (read-only)' : 'Click to edit or remove')"
                                            :style="slotStyle(slot)"
                                            @click.stop="editSlot(slot)">
                                            <div class="font-bold flex items-center justify-between gap-1">
                                                <span class="truncate" x-text="slot.type === 'Available' ? 'Available' : 'Booked'"></span>
                                                <template x-if="slot.type === 'Busy'">
                                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                </template>
                                            </div>
                                            <div class="text-[10px] font-mono opacity-90 truncate mt-0.5" x-text="slot.time_from + ' - ' + slot.time_to"></div>
                                        </div>
                                    </template>
                                </div>

                            </div>
                        </template>
                    </div>

                </div>
            </div>

            {{-- ===================== ADD / EDIT SLOT MODAL ===================== --}}
            <div x-show="modalOpen" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="display: none;">

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700"
                    @click.stop
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">

                    <!-- Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                                 style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100"
                                    x-text="editing ? 'Edit Availability Slot' : 'Add Availability Slot'"></h3>
                                <p class="text-xs text-gray-400">Define a 1-hour session opening on your calendar.</p>
                            </div>
                        </div>

                        <button type="button" @click="closeModal()"
                            class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="space-y-4">
                        <!-- Date -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Date</label>
                            <input type="date" x-model="form.date" readonly
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-not-allowed">
                        </div>

                        <!-- Time Selection -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Start Time (30-min steps)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select x-model="form.time_hour" @change="syncStartFromParts()"
                                    :disabled="isReadOnlyEditing()"
                                    :class="isReadOnlyEditing() ? 'bg-gray-100 dark:bg-gray-900/60 cursor-not-allowed' : 'bg-gray-50/70 dark:bg-gray-900/60'"
                                    class="rounded-xl border border-gray-200 dark:border-gray-700 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20">
                                    <option value="">Hour</option>
                                    <template x-for="hour in hourOptions" :key="'edit-hour-' + hour">
                                        <option :value="hour" x-text="hour + ':00'"></option>
                                    </template>
                                </select>

                                <select x-model="form.time_minute" @change="syncStartFromParts()"
                                    :disabled="isReadOnlyEditing()"
                                    :class="isReadOnlyEditing() ? 'bg-gray-100 dark:bg-gray-900/60 cursor-not-allowed' : 'bg-gray-50/70 dark:bg-gray-900/60'"
                                    class="rounded-xl border border-gray-200 dark:border-gray-700 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20">
                                    <template x-for="minute in minuteOptions" :key="'edit-minute-' + minute">
                                        <option :value="minute" x-text="':' + minute"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- End Time (Computed) -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">End Time (1 hour fixed duration)</label>
                            <input type="text" x-model="form.time_to" readonly
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm font-semibold font-mono text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        </div>

                        <!-- Read Only Notice -->
                        <div x-show="isReadOnlyEditing()" class="p-3 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200/60 dark:border-amber-800/60 text-amber-800 dark:text-amber-200 text-xs flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>This slot is booked by a client and cannot be modified or deleted.</span>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-between gap-2">
                        <div>
                            <button x-show="editing && !isReadOnlyEditing()" @click="deleteSlot()" type="button"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/50 border border-rose-200/60 dark:border-rose-800/60 transition-all shadow-2xs active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Delete Slot</span>
                            </button>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                Cancel
                            </button>
                            <button x-show="!isReadOnlyEditing()" type="button" @click="saveSlot()"
                                class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <span>Save Slot</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===================== MANUAL ADD AVAILABILITY MODAL ===================== --}}
            <div x-show="manualModalOpen" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="display: none;">

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700"
                    @click.stop
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">

                    <!-- Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700/80 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                                 style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">Add Availability</h3>
                                <p class="text-xs text-gray-400">Choose date and start time for your slot.</p>
                            </div>
                        </div>

                        <button type="button" @click="closeManualModal()"
                            class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="space-y-4">
                        <!-- Date -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Date</label>
                            <input type="date" x-model="manualForm.date"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20">
                        </div>

                        <!-- Time Selection -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Start Time (30-min steps)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select x-model="manualForm.time_hour" @change="syncManualStartFromParts()"
                                    class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20">
                                    <option value="">Hour</option>
                                    <template x-for="hour in hourOptions" :key="'manual-hour-' + hour">
                                        <option :value="hour" x-text="hour + ':00'"></option>
                                    </template>
                                </select>

                                <select x-model="manualForm.time_minute" @change="syncManualStartFromParts()"
                                    class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20">
                                    <template x-for="minute in minuteOptions" :key="'manual-minute-' + minute">
                                        <option :value="minute" x-text="':' + minute"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- End Time -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">End Time (1 hour fixed duration)</label>
                            <input type="text" x-model="manualForm.time_to" readonly
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/60 px-3.5 py-2.5 text-xs sm:text-sm font-semibold font-mono text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end gap-2.5">
                        <button type="button" @click="closeManualModal()"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            Cancel
                        </button>
                        <button type="button" @click="saveManualSlot()"
                            class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95"
                            style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <span>Create Slot</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>

    </div>

    {{-- Alpine Calendar Logic --}}
    <script>
        function therapistCalendar() {
            return {
                selectedDate: '{{ $selectedDate }}',
                userTimeZone: @json($userTimeZone ?? 'UTC'),
                weeklySlots: @json($weeklySlots),
                weekDates: @json($weekDates),
                timeRows: @json($timeRows),
                hourOptions: Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0')),
                minuteOptions: ['00', '30'],
                rowHeight: 48,

                modalOpen: false,
                manualModalOpen: false,
                editing: false,
                form: {},
                manualForm: {},
                monthDays: [],

                init() {
                    this.buildMonthDays();
                    setTimeout(() => {
                        const today = this.nowInUserTimeZone().date;
                        if (this.weekDates.includes(today)) {
                            this.scrollToDay(today);
                        }
                    }, 100);
                },

                scrollToDay(date) {
                    const col = document.getElementById('day-col-' + date);
                    const container = document.getElementById('calendar-grid-container');
                    if (col && container) {
                        const targetLeft = Math.max(0, col.offsetLeft - 64);
                        container.scrollTo({ left: targetLeft, behavior: 'smooth' });
                    }
                },

                buildMonthDays() {
                    let date = new Date(this.selectedDate);
                    let year = date.getFullYear();
                    let month = date.getMonth();
                    let daysInMonth = new Date(year, month + 1, 0).getDate();
                    this.monthDays = [];
                    for (let d = 1; d <= daysInMonth; d++) {
                        this.monthDays.push({
                            d,
                            date: `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`
                        });
                    }
                },

                formatWeekRange() {
                    if (!this.weekDates || this.weekDates.length === 0) return this.selectedDate;
                    const start = new Date(this.weekDates[0] + 'T12:00:00');
                    const end = new Date(this.weekDates[this.weekDates.length - 1] + 'T12:00:00');
                    const startStr = start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    const endStr = end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    return `${startStr} – ${endStr}`;
                },

                isSameDay(date1, date2) {
                    const d1 = new Date(date1 + 'T12:00:00');
                    const d2 = new Date(date2 + 'T12:00:00');
                    return d1.getFullYear() === d2.getFullYear() &&
                        d1.getMonth() === d2.getMonth() &&
                        d1.getDate() === d2.getDate();
                },

                slotsForDate(date) {
                    return Object.values(this.weeklySlots[date] || {})
                        .filter((v, i, a) => a.findIndex(s => s.id === v.id) === i);
                },

                formatLocalDate(d) {
                    const y = d.getFullYear();
                    const m = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `${y}-${m}-${day}`;
                },

                prevDate(date) {
                    const d = new Date(date + 'T12:00:00');
                    d.setDate(d.getDate() - 1);
                    return this.formatLocalDate(d);
                },

                toMinutes(time) {
                    const [h, m] = time.split(':').map(Number);
                    return h * 60 + m;
                },

                durationMinutes(slot) {
                    let minutes = this.diffMinutes(slot.time_from, slot.time_to);
                    if (minutes <= 0) minutes += 24 * 60;
                    return minutes;
                },

                startDayMinutes(slot) {
                    const from = this.toMinutes(slot.time_from);
                    const availableUntilMidnight = 24 * 60 - from;
                    return Math.min(this.durationMinutes(slot), availableUntilMidnight);
                },

                carryOverMinutes(slot) {
                    return Math.max(0, this.durationMinutes(slot) - this.startDayMinutes(slot));
                },

                isCrossDaySlot(slot) {
                    return this.carryOverMinutes(slot) > 0;
                },

                carryOverSlotsForDate(date) {
                    const previous = this.prevDate(date);
                    return this.slotsForDate(previous).filter(slot => this.isCrossDaySlot(slot));
                },

                slotStyle(slot) {
                    const startIndex = this.timeRows.indexOf(slot.time_from);
                    const minutes = this.startDayMinutes(slot);
                    return `top:${startIndex * this.rowHeight}px;height:${(minutes/30)*this.rowHeight}px;`;
                },

                carryOverSlotStyle(slot) {
                    const minutes = this.carryOverMinutes(slot);
                    return `top:0px;height:${(minutes/30)*this.rowHeight}px;`;
                },

                diffMinutes(a, b) {
                    const [ah, am] = a.split(':');
                    const [bh, bm] = b.split(':');
                    let minutes = (bh * 60 + +bm) - (ah * 60 + +am);
                    if (minutes <= 0) minutes += 24 * 60;
                    return minutes;
                },

                slotClass(slot) {
                    if (this.isPastSlot(slot)) {
                        return 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700';
                    }

                    const type = slot.type;
                    return {
                        'Available': 'bg-emerald-50 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-200 border-2 border-emerald-500/80 dark:border-emerald-500',
                        'Busy': 'bg-rose-50 dark:bg-rose-950/80 text-rose-800 dark:text-rose-200 border-2 border-rose-500/80 dark:border-rose-500',
                        'Blocked': 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-400'
                    }[type] || 'bg-gray-100';
                },

                isPastDateTime(date, time) {
                    const now = this.nowInUserTimeZone();
                    const targetDate = String(date || '');
                    const targetTime = String(time || '').slice(0, 5);

                    if (!targetDate || !targetTime) {
                        return false;
                    }
                    if (targetDate < now.date) {
                        return true;
                    }
                    if (targetDate > now.date) {
                        return false;
                    }

                    return targetTime <= now.time;
                },

                nowInUserTimeZone() {
                    const parts = new Intl.DateTimeFormat('en-CA', {
                        timeZone: this.userTimeZone || 'UTC',
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }).formatToParts(new Date());

                    const get = (type) => parts.find(p => p.type === type)?.value || '00';

                    return {
                        date: `${get('year')}-${get('month')}-${get('day')}`,
                        time: `${get('hour')}:${get('minute')}`,
                    };
                },

                isPastSlot(slot) {
                    return this.isPastDateTime(slot.date, slot.time_from);
                },

                openCreateModal(date = '', time = '') {
                    if (date && time && this.isPastDateTime(date, time)) {
                        alert('You can only create future time slots.');
                        return;
                    }
                    this.manualModalOpen = false;
                    this.editing = false;
                    const [hour = '', minute = '00'] = (time || '').split(':');
                    this.form = {
                        date,
                        time_from: time,
                        time_hour: hour,
                        time_minute: minute,
                        time_to: ''
                    };
                    this.syncEndTime();
                    this.modalOpen = true;
                },

                openManualCreateModal() {
                    this.modalOpen = false;
                    this.editing = false;
                    this.manualForm = {
                        date: this.selectedDate || '',
                        time_hour: '',
                        time_minute: '00',
                        time_from: '',
                        time_to: ''
                    };
                    this.syncManualEndTime();
                    this.manualModalOpen = true;
                },

                editSlot(slot) {
                    if (this.isPastSlot(slot)) {
                        alert('Past slots cannot be edited.');
                        return;
                    }
                    this.manualModalOpen = false;
                    this.editing = true;
                    const [hour = '', minute = '00'] = (slot.time_from || '').split(':');
                    this.form = {
                        id: slot.id,
                        date: slot.date,
                        time_from: slot.time_from,
                        time_hour: hour,
                        time_minute: minute,
                        time_to: slot.time_to,
                        type: slot.type
                    };
                    this.syncEndTime();
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                },

                closeManualModal() {
                    this.manualModalOpen = false;
                },

                saveSlot() {
                    if (this.isReadOnlyEditing()) {
                        alert('Booked slots are read-only and cannot be edited.');
                        return;
                    }
                    this.syncStartFromParts();

                    const payload = {
                        date: this.form.date,
                        time_from: this.form.time_from
                    };

                    const url = this.editing ? `/therapist/calendar/slots/${this.form.id}` : `/therapist/calendar/slots`;
                    const method = this.editing ? 'PUT' : 'POST';

                    this.submitSlot(url, method, payload);
                },

                deleteSlot() {
                    if (!this.editing || !this.form.id) return;
                    if (this.isReadOnlyEditing()) {
                        alert('Booked slots are read-only and cannot be deleted.');
                        return;
                    }

                    if (!confirm('Remove this availability slot? This action cannot be undone.')) return;

                    fetch(`/therapist/calendar/slots/${this.form.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async r => {
                            const data = await r.json();
                            if (!r.ok) throw data;
                            return data;
                        })
                        .then(res => {
                            if (res.success) {
                                location.reload();
                            } else {
                                alert(res.error || 'Failed to delete slot.');
                            }
                        })
                        .catch(err => {
                            alert(err.error || 'Error deleting slot.');
                            console.error(err);
                        });
                },

                isReadOnlySlot(type) {
                    return type === 'Busy';
                },

                isReadOnlyEditing() {
                    return this.editing && this.isReadOnlySlot(this.form.type);
                },

                saveManualSlot() {
                    this.syncManualStartFromParts();

                    const payload = {
                        date: this.manualForm.date,
                        time_from: this.manualForm.time_from
                    };

                    this.submitSlot('/therapist/calendar/slots', 'POST', payload);
                },

                submitSlot(url, method, payload) {
                    if (!this.isHalfHourSlot(payload.time_from)) {
                        alert('Start time must be in 30-minute steps (HH:00 or HH:30).');
                        return;
                    }
                    if (this.isPastDateTime(payload.date, payload.time_from)) {
                        alert('You can only create or edit future time slots.');
                        return;
                    }

                    fetch(url, {
                            method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(async r => {
                            const data = await r.json();
                            if (!r.ok) throw data;
                            return data;
                        })
                        .then(res => {
                            if (res.success) {
                                location.reload();
                            } else {
                                alert(res.error || 'Failed to save slot.');
                            }
                        })
                        .catch(err => {
                            alert(err.error || 'Error saving slot.');
                            console.error(err);
                        });
                },

                moveWeek(dir) {
                    const d = new Date(this.selectedDate + 'T12:00:00');
                    d.setDate(d.getDate() + dir * 7);
                    this.selectedDate = this.formatLocalDate(d);
                    this.reloadWeek();
                },

                goToday() {
                    this.selectedDate = this.nowInUserTimeZone().date;
                    this.reloadWeek();
                },

                reloadWeek() {
                    window.location = `?date=${this.selectedDate}`;
                },

                syncEndTime() {
                    if (!this.form.time_from) {
                        this.form.time_to = '';
                        return;
                    }
                    this.form.time_to = this.addHour(this.form.time_from);
                },

                syncStartFromParts() {
                    if (!this.form.time_hour) {
                        this.form.time_from = '';
                        this.form.time_to = '';
                        return;
                    }

                    this.form.time_from = `${this.form.time_hour}:${this.form.time_minute || '00'}`;
                    this.syncEndTime();
                },

                syncManualStartFromParts() {
                    if (!this.manualForm.time_hour) {
                        this.manualForm.time_from = '';
                        this.manualForm.time_to = '';
                        return;
                    }

                    this.manualForm.time_from = `${this.manualForm.time_hour}:${this.manualForm.time_minute || '00'}`;
                    this.syncManualEndTime();
                },

                syncManualEndTime() {
                    if (!this.manualForm.time_from) {
                        this.manualForm.time_to = '';
                        return;
                    }
                    this.manualForm.time_to = this.addHour(this.manualForm.time_from);
                },

                isHalfHourSlot(time) {
                    return /^\d{2}:(00|30)$/.test(time || '');
                },

                addHour(time) {
                    const [h, m] = time.split(':').map(Number);
                    const date = new Date(2000, 0, 1, h, m);
                    date.setHours(date.getHours() + 1);
                    return date.toTimeString().slice(0, 5);
                }
            }
        }
    </script>

</x-app1>
