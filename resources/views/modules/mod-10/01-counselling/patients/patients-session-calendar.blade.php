<x-app1>

    <div x-data="patientSessions()" x-init="init()" class="bg-white border rounded-b-lg p-4 space-y-4">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>
        
        <!-- Card Container -->
        <div class="bg-white border rounded-b-lg p-4 space-y-4">

            <template x-for="session in sessions" :key="session.id">
                <div class="border rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 relative"
                    x-data="{ openBio: false, menuOpen: false, openEdit: false, openView: false, openDelete: false, editMedia: null }">

                    <div class="absolute top-3 right-3">
                        <button @click="menuOpen = !menuOpen"
                            class="p-2 rounded-full hover:bg-gray-100 focus:outline-none
                               text-2xl font-extrabold leading-none">
                            ⋮
                        </button>

                        <!-- Dropdown -->
                        <div x-show="menuOpen" @click.outside="menuOpen = false" x-transition
                            class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg text-sm z-50">

                            <button
                                @click="editMedia = session.media; openEdit = true; $root.isEditing = true; menuOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                ✏️ Edit
                            </button>

                            <button @click="openView = true; menuOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                📄 View Details
                            </button>

                            <button @click="openDelete = true; menuOpen = false"
                                class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                🗑 Cancel Session
                            </button>
                        </div>

                    </div>

                    <!-- Therapist Info -->
                    <div class="flex items-center gap-4 w-full md:w-1/3">
                        <img :src="`/storage/bio_images/${session.bio_photo}.jpg`"
                            onerror="this.src='/images/avatar1.jfif'" class="w-10 h-10 rounded-full object-cover"
                            alt="Therapist">

                        <div>
                            <p class="font-semibold text-gray-800" x-text="session.therapist_name"></p>
                            <p class="text-gray-400" x-text="session.city"></p>
                            <p class="text-gray-400" x-text="session.country"></p>

                            <button @click="openBio = true"
                                class="mt-2 text-sm px-4 py-1 border border-teal-400 rounded-full text-teal-600 hover:bg-teal-50">
                                View BIO
                            </button>

                        </div>
                    </div>

                    <!-- Session Details -->
                    <div class="w-full md:w-1/3 border-l md:pl-6 text-sm text-gray-600">
                        <p class="font-semibold text-lg text-gray-800"> Session Details</p>
                        {{-- {{'Video' => '🎥 Video','Audio' => '🎧 Audio',default}} --}}
                        <p><strong>Type:</strong> <span x-text="session.media"></span></p>
                        <p><strong>Date:</strong> <span x-text="session.date"></span></p>
                        <p><strong>Start:</strong> <span x-text="session.start"></span></p>
                        <p><strong>Duration:</strong> <span x-text="session.duration"></span> mins</p>
                    </div>

                    <!-- Join  Button-->
                    <div class="md:w-1/4 text-center">
                        <template x-if="session.session_started">
                            <a :href="session.join_url" target="_blank"
                                class="inline-block w-full bg-green-200 text-green-800 font-medium py-3 rounded-full hover:bg-green-300">
                                Join the Session
                            </a>
                        </template>

                        <template x-if="!session.session_started">
                            <div
                                class="inline-flex flex-col items-center gap-1 px-4 py-2 rounded-full 
                                        bg-yellow-50 text-yellow-700 text-sm font-medium">

                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-3 w-3">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                                    </span>
                                    Session will begin in
                                </div>

                                <div class="font-mono text-base tracking-wider text-yellow-800"
                                    x-text="formatTime(session.remainingSeconds)">
                                </div>
                            </div>
                        </template>


                        {{-- ////////////Therapist Bio MODAL////////////// --}}
                        <div x-show="openBio" x-cloak x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                            <div @click.outside="openBio = false"
                                class="bg-white w-full max-w-4xl max-h-[85vh] overflow-y-auto rounded-xl shadow-xl p-6 relative">
                                <!-- Close button -->
                                <button @click="openBio = false"
                                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">
                                    ✕
                                </button>

                                <!-- Header -->
                                <div class="flex items-center gap-4 mb-6">
                                    <img :src="`/storage/bio_images/${session.bio_photo}.jpg`"
                                        onerror="this.src='/images/avatar1.jfif'"
                                        class="w-20 h-20 rounded-full object-cover border" alt="Therapist">

                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">
                                            <span x-text="session.salutation || ''"></span>
                                            <span x-text="session.therapist_name"></span>
                                        </h3>

                                        <p class="text-gray-500 text-sm">
                                            <span x-text="session.city"></span>,
                                            <span x-text="session.country"></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">

                                    <!-- Languages -->
                                    <div>
                                        <p class="font-medium text-gray-800 mb-1">Languages</p>
                                        <span x-text="session.languageprimary || 'Not specified'"></span>
                                        <span class="ml-1" x-text="session.languagesecondary || ''"></span>
                                    </div>

                                    <!-- Therapy -->
                                    <div>
                                        <p class="font-medium text-gray-800 mb-2">Therapy</p>

                                        <div class="space-y-2">
                                            <template x-for="therapy in session.therapies" :key="therapy.name">
                                                <div class="flex justify-between bg-gray-50 px-3 py-2 rounded">
                                                    <a :href="therapy.url"
                                                        class="font-medium text-teal-700 hover:underline"
                                                        x-text="therapy.name"></a>

                                                    <template x-if="therapy.years">
                                                        <span class="text-xs text-gray-500"
                                                            x-text="therapy.years + ' yrs'"></span>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>


                                    <!-- Qualifications -->
                                    <div class="md:col-span-2 border-t pt-4">
                                        <p class="font-medium text-gray-800 mb-3">Qualifications</p>

                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex flex-wrap items-start divide-x divide-gray-300">

                                                <template x-for="q in session.qualifications" :key="q.title">
                                                    <div class="px-4 first:pl-0 last:pr-0">
                                                        <p class="font-semibold text-gray-800 whitespace-nowrap"
                                                            x-text="q.title"></p>

                                                        <template x-if="q.from">
                                                            <p class="text-gray-600 text-sm" x-text="q.from"></p>
                                                        </template>

                                                        <template x-if="q.level">
                                                            <p class="text-gray-500 text-xs">
                                                                Level: <span x-text="q.level"></span>
                                                            </p>
                                                        </template>
                                                    </div>
                                                </template>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        {{-- ////////////Edit MODAL////////////// --}}
                        <div x-show="openEdit" x-transition.opacity
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur">

                            <div @click.outside="openEdit=false; $root.isEditing=false"
                                class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    Edit Session Type
                                </h3>

                                <select x-model="editMedia"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500">
                                    <option value="Video">🎥 Video</option>
                                    <option value="Audio">🎧 Audio</option>
                                </select>

                                <div class="flex justify-end gap-3 mt-6">
                                    <button @click="openEdit=false; $root.isEditing=false;"
                                        class="px-4 py-2 rounded-lg border">
                                        Cancel
                                    </button>

                                    <button
                                        @click="session.media = editMedia; updateSession(session); openEdit = false; $root.isEditing = false;"
                                        class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>



                        {{-- ////////////Delete Cancel MODAL////////////// --}}
                        <div x-show="openDelete" x-transition.opacity
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur">

                            <div @click.outside="openDelete=false"
                                class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">

                                <h3 class="text-lg font-semibold text-red-600 mb-3">
                                    Cancel Session
                                </h3>

                                <p class="text-sm text-gray-600 mb-6">
                                    This session will be marked as <b>Available</b>.
                                </p>

                                <div class="flex justify-end gap-3">
                                    <button @click="openDelete=false" class="px-4 py-2 border rounded-lg">
                                        No
                                    </button>

                                    <button @click="cancelSession(session.id)"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Yes, Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- ////////////View Details MODAL////////////// --}}
                        <div x-show="openView" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-xl w-full max-w-4xl p-6 overflow-y-auto"
                                @click.outside="openView=false">

                                <h3 class="text-xl font-semibold mb-4">Session Details</h3>

                                <p><b>Therapist:</b> <span x-text="session.therapist_name"></span></p>
                                <p><b>Date:</b> <span x-text="session.date"></span></p>
                                <p><b>Time:</b> <span x-text="session.start"></span> – <span
                                        x-text="session.end"></span>
                                </p>

                                <!-- Therapy -->
                                <div class="mt-4">
                                    <p class="font-medium mb-2">Therapy</p>
                                    <template x-for="therapy in session.therapies" :key="therapy.name">
                                        <p>
                                            <span x-text="therapy.name"></span>
                                            <template x-if="therapy.years">
                                                (<span x-text="therapy.years"></span> yrs)
                                            </template>
                                        </p>
                                    </template>
                                </div>

                                <!-- Qualifications -->
                                <div class="mt-4">
                                    <p class="font-medium mb-2">Qualifications</p>
                                    <template x-for="q in session.qualifications" :key="q.title">
                                        <p>
                                            <b x-text="q.title"></b>
                                            <template x-if="q.from"> – <span x-text="q.from"></span></template>
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
            </template>

        </div>
    </div>

    <script>
        function patientSessions() {
            return {
                sessions: [],
                isEditing: false,
                pollingInterval: null,

                init() {
                    this.fetchSessions();

                    this.pollingInterval = setInterval(() => {
                        if (!this.isEditing) {
                            this.fetchSessions();
                        }
                    }, 5000);

                    setInterval(() => this.updateCountdowns(), 1000);
                },

                async fetchSessions() {
                    const res = await fetch('/patient/sessions/poll');
                    const data = await res.json();

                    this.sessions = data.map(s => {
                        s.remainingSeconds ??= this.calculateRemainingSeconds(s.session_start_at);
                        return s;
                    });
                },

                calculateRemainingSeconds(startAt) {
                    const now = Date.now();
                    const start = new Date(startAt).getTime();
                    return Math.max(0, Math.floor((start - now) / 1000));
                },

                updateCountdowns() {
                    this.sessions.forEach(s => {
                        if (!s.session_started && s.remainingSeconds > 0) {
                            s.remainingSeconds--;
                        }
                    });
                },

                formatTime(seconds) {
                    if (seconds <= 0) return "00 : 00 : 00";
                
                    const d = Math.floor(seconds / (3600 * 24));
                    const h = Math.floor((seconds % (3600 * 24)) / 3600);
                    const m = Math.floor((seconds % 3600) / 60);
                
                    const dd = String(d).padStart(2, '0');
                    const hh = String(h).padStart(2, '0');
                    const mm = String(m).padStart(2, '0');
                
                    return `${dd}D : ${hh}H : ${mm}M`;
                },

                /* =============================
                   UPDATE SESSION TYPE
                ============================== */
                async updateSession(session) {
                    try {
                        const res = await fetch(
                            `/mod-10/01/usr-therapy-calendar/${session.id}/update-session-type`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    SessionType: session.media
                                })
                            }
                        );

                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            throw new Error(data.message || 'Update failed');
                        }

                        this.fetchSessions();

                    } catch (e) {
                        console.error(e);
                        alert('Unable to update session type.');
                    }
                },

                /* =============================
                   CANCEL SESSION
                ============================== */
                async cancelSession(sessionId) {
                    try {
                        const res = await fetch(
                            `/mod-10/01/usr-therapy-calendar/${sessionId}/cancel`, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            }
                        );

                        if (!res.ok) throw new Error('Cancel failed');

                        this.fetchSessions();

                    } catch (e) {
                        alert('Unable to cancel session.');
                    }
                }
            }
        }
    </script>

</x-app1>
