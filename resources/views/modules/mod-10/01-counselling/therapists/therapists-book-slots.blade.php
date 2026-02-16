<x-app1>


    <div class="max-w-7xl mx-auto space-y-6" x-data="therapistCalendar()" x-init="init()" :style="`--rows:${timeRows.length}`">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <x-page-header />
            <div class="flex items-center gap-2">
                <button @click="openCreateModal()"
                    class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">
                    + Add Availability
                </button>
                <button @click="goToday()" class="px-3 py-2 bg-gray-100 rounded-md text-sm">Today</button>
            </div>
        </div>

        <!-- Main layout -->
        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            <!-- Left mini calendar -->
            <aside class="bg-white rounded-xl p-4 border space-y-3">
                <div class="flex items-center justify-between">
                    <div class="font-semibold" x-text="formatMonth(selectedDate)"></div>
                    <div class="flex gap-1">
                        <button @click="moveMonth(-1)">‹</button>
                        <button @click="moveMonth(1)">›</button>
                    </div>
                </div>

                <div class="grid grid-cols-7 text-xs text-center text-gray-500">
                    <template x-for="d in ['Su','Mo','Tu','We','Th','Fr','Sa']">
                        <div x-text="d"></div>
                    </template>
                </div>

                <div class="grid grid-cols-7 gap-1">
                    <template x-for="day in monthDays">
                        <button @click="selectDate(day.date)" class="p-2 rounded text-sm"
                            :class="isSameDay(day.date, selectedDate) ? 'bg-indigo-600 text-white' : 'hover:bg-gray-100'"
                            x-text="day.d">
                        </button>
                    </template>
                </div>
            </aside>

            <!-- Right main calendar -->
            <div class="bg-white rounded-xl p-4 border">

                <!-- Week controls -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex gap-2">
                        <button @click="moveWeek(-1)" class="px-2 py-1 border rounded">Prev</button>
                        <button @click="moveWeek(1)" class="px-2 py-1 border rounded">Next</button>
                    </div>
                    <div class="text-sm font-medium" x-text="selectedDate"></div>
                </div>

                <!-- Calendar grid,  overflow-y-auto -->
                <div class="relative border rounded h-[calc(var(--rows)*3rem+2.5rem)]">

                    <!-- Time header -->
                    <div class="absolute left-0 top-0 w-20 h-10 bg-gray-100 border-b border-r flex items-center justify-center text-sm font-semibold z-30 pointer-events-none">
                        Time
                    </div>

                    <!-- Day names header -->
                    <div
                        class="absolute left-20 right-0 top-0 h-10 grid grid-cols-7 bg-gray-100 border-b z-20 pointer-events-none">
                        <template x-for="date in weekDates" :key="date">
                            <div class="flex flex-col items-center justify-center text-sm font-semibold border-r">
                                <div x-text="new Date(date).toLocaleDateString('en-US',{ weekday:'long' })"></div>
                                <div class="text-xs text-gray-500"
                                    x-text="new Date(date).toLocaleDateString('en-US',{ day:'2-digit', month:'short' })">
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Time column -->
                    <div class="absolute left-0 top-10 w-20 bottom-0 border-r bg-gray-50">
                        <template x-for="time in timeRows" :key="time">
                            <div class="h-12 text-xs text-right pr-2 border-b flex items-center justify-end"
                                x-text="time"></div>
                        </template>
                    </div>

                    <!-- Days grid -->
                    <div class="absolute left-20 right-0 top-10 bottom-0 grid grid-cols-7">
                        <template x-for="date in weekDates" :key="date">
                            <div class="relative border-r">

                                <!-- Grid cells -->
                                <template x-for="time in timeRows" :key="time">
                                    <div class="h-12 border-b hover:bg-blue-50 cursor-pointer"
                                        @click="openCreateModal(date, time)"></div>
                                </template>

                                <!-- Slots -->
                                <template x-for="slot in slotsForDate(date)" :key="slot.id">
                                    <div class="absolute left-1 right-1 rounded p-2 text-xs cursor-pointer"
                                        :class="slotClass(slot.type)" :style="slotStyle(slot)"
                                        @click.stop="editSlot(slot)">
                                        <div class="font-semibold" x-text="slot.type"></div>
                                        <div x-text="slot.time_from + ' – ' + slot.time_to"></div>
                                    </div>
                                </template>

                            </div>
                        </template>
                    </div>

                </div>


                <!-- Modal -->
                <div x-show="modalOpen" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white w-96 p-5 rounded" @click.stop>
                        <h3 class="font-semibold mb-3" x-text="editing ? 'Edit Availability' : 'Add Availability'">
                        </h3>

                        <input type="date" x-model="form.date" class="w-full border p-2 rounded mb-2">

                        <div class="flex gap-2 mb-2">
                            <input type="time" x-model="form.time_from" class="w-1/2 border p-2 rounded">
                            <input type="time" x-model="form.time_to" class="w-1/2 border p-2 rounded">
                        </div>

                        <div class="flex justify-end gap-2">
                            <button @click="closeModal" class="px-3 py-1 border rounded">❌ Cancel</button>
                            <button @click="saveSlot" class="px-3 py-1 bg-indigo-600 text-white rounded">Save</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script>
        function therapistCalendar() {
            return {
                selectedDate: '{{ $selectedDate }}',
                weeklySlots: @json($weeklySlots),
                weekDates: @json($weekDates),
                timeRows: @json($timeRows),

                modalOpen: false,
                editing: false,
                form: {},

                monthDays: [],

                init() {
                    this.buildMonthDays();
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

                formatMonth(date) {
                    const d = new Date(date);
                    return d.toLocaleString('en-US', {
                        month: 'long',
                        year: 'numeric'
                    });
                },

                isSameDay(date1, date2) {
                    const d1 = new Date(date1);
                    const d2 = new Date(date2);
                    return d1.getFullYear() === d2.getFullYear() &&
                        d1.getMonth() === d2.getMonth() &&
                        d1.getDate() === d2.getDate();
                },

                slotsForDate(date) {
                    return Object.values(this.weeklySlots[date] || {})
                        .filter((v, i, a) => a.findIndex(s => s.id === v.id) === i);
                },

                slotStyle(slot) {
                    const startIndex = this.timeRows.indexOf(slot.time_from);
                    const minutes = this.diffMinutes(slot.time_from, slot.time_to);
                    return `top:${startIndex * 48}px;height:${(minutes/60)*48}px;`;
                },

                diffMinutes(a, b) {
                    const [ah, am] = a.split(':');
                    const [bh, bm] = b.split(':');
                    return (bh * 60 + +bm) - (ah * 60 + +am);
                },

                slotClass(type) {
                    return {
                        'Available': 'bg-green-100 border border-green-200 text-green-800',
                        'Busy': 'bg-red-200 border border-red-600',
                        'Blocked': 'bg-gray-200 border border-gray-600'
                    } [type] || 'bg-gray-100';
                },

                openCreateModal(date = '', time = '') {
                    this.editing = false;
                    this.form = {
                        date,
                        time_from: time,
                        time_to: ''
                    };
                    this.modalOpen = true;
                },

                editSlot(slot) {
                    this.editing = true;
                    this.form = JSON.parse(JSON.stringify(slot));
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                },

                saveSlot() {
                    const payload = {
                        date: this.form.date,
                        time_from: this.form.time_from,
                        time_to: this.form.time_to
                    };

                    const url = this.editing ?
                        `/therapist/calendar/slots/${this.form.id}` :
                        `/therapist/calendar/slots`;

                    const method = this.editing ? 'PUT' : 'POST';

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
                    const d = new Date(this.selectedDate);
                    d.setDate(d.getDate() + dir * 7);
                    this.selectedDate = d.toISOString().slice(0, 10);
                    this.reloadWeek();
                },

                reloadWeek() {
                    window.location = `?date=${this.selectedDate}`;
                }
            }
        }
    </script>

</x-app1>
