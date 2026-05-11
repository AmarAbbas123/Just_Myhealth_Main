<x-app1>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow rounded-lg p-4">
            <!-- Header -->
            <div class="flex justify-between mb-4">
                <x-page-header />
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <span>{{ session('success') }} If you want its details visit this </span>
                    <a href="/mod-10/01/usr-therapy-calendar" class="font-semibold underline">
                        Booked Session Details
                    </a>
                </div>
            @endif

            <!-- Timezone Notification -->
            <div class="mb-4">
                <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-4 py-2 rounded text-sm">
                    <strong> {{ $displayTimeZone }} </strong>
                </div>
            </div>

            <div x-data="calendarApp({{ $therapistCard['id'] ?? 'null' }}, '{{ $selectedDate }}')" x-init="init()" class="flex gap-6">

                <!-- RIGHT COLUMN 66% -->
                <div class="w-full">
                    <div class="bg-white p-6 rounded shadow-sm">

                        <div class="flex items-center justify-between mb-4">
                            <a
                                href="?view=week&date={{ \Carbon\Carbon::parse($selectedDate)->subWeek()->toDateString() }}">
                                Previous Week
                            </a>

                            <a
                                href="?view=week&date={{ \Carbon\Carbon::parse($selectedDate)->addWeek()->toDateString() }}">
                                Next Week
                            </a>

                            <a
                                href="?view=month&date={{ \Carbon\Carbon::parse($selectedDate)->subMonth()->toDateString() }}">
                                Previous Month
                            </a>

                            <a
                                href="?view=month&date={{ \Carbon\Carbon::parse($selectedDate)->addMonth()->toDateString() }}">
                                Next Month
                            </a>

                            <b> {{ $selectedDate }} </b>
                        </div>

                        <!-- WEEKLY TABLE (REPLACE previous table) -->
                        <div class="relative border rounded h-[calc(var(--rows)*3rem+2.5rem)]">
                            <div class="relative">
                                <table class="min-w-full border text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-2 py-2 text-left w-24">Time</th>

                                            <!-- Dynamic day names -->
                                            <template x-for="d in weekDates" :key="d">
                                                <th class="border px-2 py-2 text-center">
                                                    <div
                                                        x-text="new Date(d).toLocaleDateString('en-US', { weekday: 'short' })">
                                                    </div>
                                                    <div x-text="d" class="text-xs text-gray-600"></div>
                                                </th>
                                            </template>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <!-- rows (30-min steps) -->
                                        <template x-for="row in timeRows" :key="row.time">
                                            <tr class="relative">
                                                <td class="border px-2 py-2 font-medium bg-gray-50" x-text="row.label">
                                                </td>

                                                <!-- 7 day columns -->
                                                <template x-for="(d, idx) in weekDates" :key="d">
                                                    <td class="border border-gray-400 px-1 py-1 relative overflow-visible"
                                                        :class="isPastDateTime(d, row.time) ? 'bg-gray-100' : ''"
                                                        style="height: 48px; position: relative;">
                                                        <!-- Container to hold blocks positioned absolutely -->
                                                        <div class="relative w-full h-full">
                                                            <!-- Render a block for any slot that STARTS at this cell -->
                                                            <template x-for="slot in slotsForDate(d)"
                                                                :key="slot.id">
                                                                <template x-if="slotStartsAt(slot, row.time)">
                                                                    <div @click.stop="slot.type === 'Available' && !isPastSlot(slot) && 
                                                                    $store.booking.open({
                                                                        date: slot.date,
                                                                        start: slot.time_from,
                                                                        end: slot.time_to,
                                                                        displayEnd: slot.display_time_to,
                                                                        duration: slot.display_duration_minutes,
                                                                        therapy_types: ['Video','Audio','Message'],
                                                                        type: slot.type
                                                                    }, therapistId)"
                                                                        class="absolute left-1 right-1 rounded-md overflow-hidden flex items-center justify-center text-xs font-semibold cursor-pointer z-50"
                                                                        :class="isPastSlot(slot) ?
                                                                            'bg-gray-300 text-gray-700 border border-gray-500 cursor-not-allowed' :
                                                                            (slot.type === 'Available' ?
                                                                            'bg-green-200 text-green-800 border border-green-600' :
                                                                            (slot.type === 'Busy' ?
                                                                                'bg-red-200 text-red-800 border border-red-600' :
                                                                                (slot.type === 'Blocked' ?
                                                                                    'bg-gray-300 text-gray-800' :
                                                                                    'bg-yellow-200 text-yellow-800')))"
                                                                        :style="blockStyle(slot)">
                                                                        <div class="text-center leading-tight">
                                                                            <div x-text="slot.type"></div>

                                                                            {{-- <template x-if="slot.session_type">
                                                                                <div class="text-[10px] opacity-70"
                                                                                    x-text="slot.session_type"></div>
                                                                            </template> --}}
                                                                        </div>

                                                                    </div>


                                                                </template>
                                                            </template>

                                                            <!-- Render carry-over from previous day at 00:00 -->
                                                            <template x-if="row.time === '00:00'">
                                                                <template x-for="slot in carryOverSlotsForDate(d)" :key="`carry-${slot.id}-${d}`">
                                                                    <div @click.stop="slot.type === 'Available' && !isPastSlot(slot) && 
                                                                    $store.booking.open({
                                                                        date: slot.date,
                                                                        start: slot.time_from,
                                                                        end: slot.time_to,
                                                                        displayEnd: slot.display_time_to,
                                                                        duration: slot.display_duration_minutes,
                                                                        therapy_types: ['Video','Audio','Message'],
                                                                        type: slot.type
                                                                    }, therapistId)"
                                                                        class="absolute left-1 right-1 rounded-md overflow-hidden flex items-center justify-center text-xs font-semibold cursor-pointer z-50"
                                                                        :class="isPastSlot(slot) ?
                                                                            'bg-gray-300 text-gray-700 border border-gray-500 cursor-not-allowed' :
                                                                            (slot.type === 'Available' ?
                                                                            'bg-green-200 text-green-800 border border-green-600' :
                                                                            (slot.type === 'Busy' ?
                                                                                'bg-red-200 text-red-800 border border-red-600' :
                                                                                (slot.type === 'Blocked' ?
                                                                                    'bg-gray-300 text-gray-800' :
                                                                                    'bg-yellow-200 text-yellow-800')))"
                                                                        :style="carryOverBlockStyle(slot)">
                                                                        <div class="text-center leading-tight">
                                                                            <div x-text="slot.type"></div>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </template>
                                                        </div>
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>

            </div> <!-- x-data -->


            <!-- Hidden form modal - Alpine controlled root -->
            <div x-show="$store.booking.isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black opacity-40" @click="$store.booking.close()"></div>

                <div class="bg-white rounded-lg shadow-lg p-6 z-50 w-full max-w-lg">
                    <h3 class="text-lg font-semibold mb-4">
                        Book session with {{ $therapistCard['name'] ?? 'null' }}
                    </h3>

                    <form method="POST" :action="`/patients/${$store.booking.therapistId}/book`">
                        @csrf

                        <input type="hidden" name="date" :value="$store.booking.slot.date">
                        <input type="hidden" name="time_to" :value="$store.booking.slot.end">

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm">From</label>
                                <input required name="time_from" type="time" class="w-full border p-2 rounded"
                                    :value="$store.booking.slot.start" readonly>
                            </div>

                            <div>
                                <label class="text-sm">To</label>
                                <input required type="time" class="w-full border p-2 rounded"
                                    :value="$store.booking.slot.displayEnd" readonly>
                            </div>
                        </div>

                        <div class="mt-3 rounded border border-indigo-100 bg-indigo-50 px-3 py-2 text-sm text-indigo-800">
                            Session duration: <strong x-text="`${$store.booking.slot.duration} minutes`"></strong>
                        </div>

                        <div class="mt-3">
                            <label class="text-sm">Session type</label>
                            <select required name="session_type" class="w-full border p-2 rounded">
                                <template x-for="t in $store.booking.slot.therapy_types">
                                    <option :value="t" x-text="t"></option>
                                </template>
                            </select>
                        </div>

                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" @click="$store.booking.close()"
                                class="px-4 py-2 rounded border">Cancel</button>

                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">
                                Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {

            // Shared global store
            Alpine.store('booking', {
                isOpen: false,
                slot: {
                    date: null,
                    start: null,
                    end: null,
                    displayEnd: null,
                    duration: 50,
                },
                therapistId: null,

                open(slot, therapistId) {
                    this.slot = {
                        ...slot,
                        displayEnd: slot.displayEnd || slot.end,
                        duration: slot.duration || 50,
                    };
                    this.therapistId = therapistId;
                    this.isOpen = true;
                },

                close() {
                    this.isOpen = false;
                }
            });

        });
    </script>

    <script>
        function calendarApp(therapistId, initialDate) {
            return {
                therapistId: therapistId,
                selectedDate: initialDate || new Date().toISOString().slice(0, 10),
                displayDate: initialDate || new Date().toISOString().slice(0, 10),
                userTimeZone: @json($userTimeZone ?? 'UTC'),

                // weekSlots provided by controller (object: { '2025-12-08': [ {...}, ... ], ... })
                slots: @json($slots),

                message: null,
                error: null,

                // 30-minute rows 00:00 - 23:30
                timeRows: (function() {
                    const rows = [];
                    let totalMinutes = 0;

                    while (totalMinutes < 24 * 60) {
                        const hour = Math.floor(totalMinutes / 60);
                        const minute = totalMinutes % 60;
                        const hh = String(hour).padStart(2, '0');
                        const mm = String(minute).padStart(2, '0');

                        rows.push({
                            label: `${hh}:${mm}`,
                            time: `${hh}:${mm}`
                        });
                        totalMinutes += 30;
                    }

                    return rows;
                })(),

                // computed: Monday..Sunday dates for the week that includes selectedDate
                // Inside calendarApp
                weekDates: [], // initially empty

                updateWeekDates() {
                    const sel = new Date(this.selectedDate);
                    const day = sel.getDay(); // 0 Sun .. 6 Sat
                    const monday = new Date(sel);
                    const offset = (day === 0) ? -6 : (1 - day);
                    monday.setDate(sel.getDate() + offset);

                    const dates = [];
                    for (let i = 0; i < 7; i++) {
                        const d = new Date(monday);
                        d.setDate(monday.getDate() + i);
                        dates.push(d.toISOString().slice(0, 10));
                    }

                    this.weekDates = dates;
                },

                init() {
                    // convert weekSlots to ensure keys exist for all days
                    this.ensureSlotsKeys();
                    this.updateWeekDates(); // ensure weekDates is filled on page load
                },

                ensureSlotsKeys() {
                    // fill missing keys with empty array
                    for (const d of this.weekDates) {
                        if (!this.slots[d]) this.slots[d] = [];
                    }
                },

                // returns array of slot objects for a given date string (Y-m-d)
                slotsForDate(date) {
                    return this.slots[date] || [];
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
                    const [hh, mm] = time.split(':').map(Number);
                    return hh * 60 + mm;
                },

                durationMinutes(slot) {
                    let duration = this.toMinutes(slot.time_to) - this.toMinutes(slot.time_from);
                    if (duration <= 0) duration += 24 * 60;
                    return duration;
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

                // returns true if slot starts exactly at the given time (H:i)
                slotStartsAt(slot, time) {
                    return slot.time_from === time;
                },

                // compute style for block: height based on duration (rows * 48px row height) and top offset 0
                blockStyle(slot) {
                    const duration = this.startDayMinutes(slot);

                    // each table row is 30 minutes and 48px high
                    const blocks = duration / 30;
                    const height = blocks * 48;

                    return `top: 0; height: ${height}px;`;
                },

                carryOverBlockStyle(slot) {
                    const duration = this.carryOverMinutes(slot);
                    const blocks = duration / 30;
                    const height = blocks * 48;
                    return `top: 0; height: ${height}px;`;
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

                // Reload weekSlots from server for the selectedDate (full week)
                fetchWeek() {
                    fetch(`/patients/${this.therapistId}/calendar/slots?date=${this.selectedDate}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(r => r.json())
                        .then(json => {
                            // server returns { date: 'YYYY-MM-DD', slots: { 'YYYY-MM-DD': [...] } } OR our controller returns weekSlots
                            // normalize: if response.slots is an object mapping date => array, use it; otherwise, build from array
                            if (json.slots && typeof json.slots === 'object' && !Array.isArray(json.slots)) {
                                this.slots = json.slots;
                            } else if (Array.isArray(json.slots)) {
                                // convert array entries to map: group by date
                                const map = {};
                                for (const e of json.slots) {
                                    map[e.date] = map[e.date] || [];
                                    map[e.date].push(e);
                                }
                                this.slots = map;
                            }
                            this.displayDate = this.selectedDate;
                            this.ensureSlotsKeys();
                        })
                        .catch(err => {
                            this.error = 'Failed to load week slots';
                        });
                },

                onDateChange() {
                    this.displayDate = this.selectedDate;
                    this.updateWeekDates(); // update reactive weekDates
                    this.ensureSlotsKeys();
                    this.fetchWeek();
                },

                // existing functions for booking modal
                openBookingModal() {
                    this.isOpen = true;
                    this.form.date = this.selectedSlot.date;
                    this.form.time_from = this.selectedSlot.start;
                    this.form.time_to = this.selectedSlot.end;
                },

                prefillBook(slot) {
                    window.__bookingModalRef.open({
                        date: slot.date || this.selectedDate,
                        time_from: slot.time_from,
                        time_to: slot.time_to,
                    });
                }
            }
        }


        function miniCalendar() {
            return {
                today: new Date(),
                selectedDate: null,
                month: null,
                year: null,
                days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                monthDays: [],

                init() {
                    const d = new Date();
                    this.month = d.getMonth();
                    this.year = d.getFullYear();
                    this.selectedDate = this.$root.selectedDate;
                    this.generate();
                },

                get monthLabel() {
                    return new Date(this.year, this.month).toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    });
                },

                generate() {
                    const first = new Date(this.year, this.month, 1);
                    const last = new Date(this.year, this.month + 1, 0);

                    const firstDay = ((first.getDay() + 6) % 7); // Monday-based
                    const total = last.getDate();

                    const days = [];

                    for (let i = 0; i < firstDay; i++) {
                        days.push({
                            label: '',
                            full: '',
                            current: false
                        });
                    }

                    for (let i = 1; i <= total; i++) {
                        const full = `${this.year}-${String(this.month+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;
                        days.push({
                            label: i,
                            full: full,
                            current: true
                        });
                    }

                    this.monthDays = days;
                },

                prevMonth() {
                    if (this.month === 0) {
                        this.month = 11;
                        this.year--;
                    } else this.month--;
                    this.generate();
                },

                nextMonth() {
                    if (this.month === 11) {
                        this.month = 0;
                        this.year++;
                    } else this.month++;
                    this.generate();
                },

                choose(full) {
                    if (!full) return;

                    // Set selected date in both mini calendar and root calendarApp
                    this.selectedDate = full;
                    if (typeof onDateSelected === 'function') onDateSelected(full);

                }

            };
        }
    </script>

</x-app1>
