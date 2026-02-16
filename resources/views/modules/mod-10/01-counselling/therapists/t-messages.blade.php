<x-app1>

    <div class="space-y-6" x-data="therapistMessageApp()" x-init="init()" x-on:beforeunload.window="destroy()">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- Filter Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm flex flex-wrap items-center gap-3">
            <input type="text" x-model="searchName" placeholder="Search patient name..."
                class="flex-1 rounded-md border-gray-300 dark:border-gray-700 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
            <div class="flex flex-wrap items-center gap-2">
                <input type="date" x-model="startDate" x-ref="startDate" autocomplete="off"
                    class="border-gray-300 dark:border-gray-700 rounded-md text-sm px-2 py-2">
                <span class="text-gray-500 text-sm">to</span>
                <input type="date" x-model="endDate" x-ref="endDate" autocomplete="off"
                    class="border-gray-300 dark:border-gray-700 rounded-md text-sm px-2 py-2">
                <button @click="applyFilters(true)"
                    class="px-3 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    🔍 Filter
                </button>
                <button @click="resetFilters()"
                    class="px-3 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition">
                    ♻️ Reset
                </button>
            </div>
        </div>

        <!-- Chat Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

            <!-- Patient List -->
            <div
                class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-y-auto max-h-[70vh] sm:max-h-[60vh]">
                <template x-for="patient in filteredPatients" :key="patient.id">
                    <li @click="setActiveChat(patient)"
                        class="flex items-center gap-3 p-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 transition"
                        :class="{ 'bg-purple-50 dark:bg-purple-800/20': activeChat?.id === patient.id }">
                        <img :src="patient.avatar" class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <p class="font-medium text-gray-800 dark:text-gray-100" x-text="patient.name"></p>
                                <div class="flex items-center gap-2">
                                    <p class="text-xs text-gray-400" x-text="patient.time ?? ''"></p>
                                    <span x-show="(patient.unread || 0) > 0"
                                        class="min-w-[18px] h-[18px] px-1 text-[10px] leading-[18px] text-center rounded-full bg-red-600 text-white"
                                        x-text="patient.unread"></span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate"
                                x-text="patient.lastMessage ?? 'Start a conversation'"></p>
                            <p class="text-[11px] text-gray-400" x-text="patient.dateTime ?? ''"></p>
                        </div>
                    </li>
                </template>
                <template x-if="filteredPatients.length === 0">
                    <p class="text-center text-gray-500 text-sm p-4">No results found.</p>
                </template>
            </div>

            <!-- Chat Window -->
            <div
                class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex flex-col h-[70vh] sm:h-[60vh]">
                <template x-if="activeChat">
                    <div class="flex flex-col h-full">
                        <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center gap-3">
                            <img :src="activeChat.avatar" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-100" x-text="activeChat.name"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="activeChat.dateTime"></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 text-xs text-gray-500 border-b">
                            <span
                                x-text="activeChat?.messages?.length ? `Messages: ${activeChat.messages.length}` : ''">
                            </span>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="scrollToTop()"
                                    class="px-2 py-1 rounded bg-gray-100 hover:bg-gray-200">Oldest</button>
                                <button type="button" @click="scrollToBottom()"
                                    class="px-2 py-1 rounded bg-gray-100 hover:bg-gray-200">Latest</button>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-4 space-y-4" x-ref="chatWindow">
                            <template x-for="msg in activeChat.messages" :key="msg.id">
                                <div>
                                    <div x-show="msg.sender === 'patient'" class="flex items-start gap-3">
                                        <img :src="activeChat.avatar" class="w-8 h-8 rounded-full">
                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
                                            <p class="text-sm" x-text="msg.text"></p>
                                            <p class="text-xs text-gray-400 mt-1" x-text="msg.time"></p>
                                        </div>
                                    </div>
                                    <div x-show="msg.sender === 'therapist'" class="flex justify-end">
                                        <div class="bg-green-600 text-white rounded-lg shadow p-3 max-w-xs">
                                            <p class="text-sm" x-text="msg.text"></p>
                                            <p class="text-xs text-purple-200 mt-1 text-right" x-text="msg.time"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <form @submit.prevent="sendMessage()"
                            class="flex flex-wrap items-center gap-2 p-3 border-t border-gray-100 dark:border-gray-700">
                            <input x-model="newMessage" placeholder="Type a message..."
                                class="flex-1 rounded-md border-gray-300 dark:border-gray-700 px-3 py-2 focus:ring-2 focus:ring-purple-500">
                            <button
                                class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">📩
                                Send</button>
                        </form>
                    </div>
                </template>
                <template x-if="!activeChat">
                    <div class="flex items-center justify-center flex-1 text-gray-500 text-sm">
                        Select a patient to start chatting.
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        let zimTherapist = null;
        let currentPeerID = null;
        let isZimLoggedIn = false;

        function therapistMessageApp() {
            return {
                searchName: '',
                startDate: '',
                endDate: '',
                filteredPatients: [],
                filtersActive: false,
                stickToBottom: true,
                activeChat: null,
                newMessage: '',
                allPatients: @json($patients),
                previewTimer: null,
                myUserId: @json((int) (Auth::user()->ID ?? 0)),
                readMap: {},

                async init() {
                    this.startDate = '';
                    this.endDate = '';
                    this.filtersActive = false;
                    this.allPatients = Array.isArray(this.allPatients)
                        ? this.allPatients
                        : Object.values(this.allPatients || {});
                    this.allPatients = this.allPatients.map(p => ({ ...p, unread: p.unread ?? 0 }));
                    this.sortChats();
                    this.filteredPatients = this.allPatients;
                    this.readMap = this.loadReadMap();
                    this.primeReadMap(this.allPatients);
                    this.$nextTick(() => {
                        if (this.$refs.startDate) this.$refs.startDate.value = '';
                        if (this.$refs.endDate) this.$refs.endDate.value = '';
                    });
                    await this.initZego();
                    this.$watch('searchName', () => this.applyFilters());

                    // Start polling active chat messages every 2-3s
                    this.pollingTimer = setInterval(async () => {
                        if (this.activeChat) {
                            await this.fetchLatestMessages();
                        }
                    }, 3000);

                    // Poll list previews so new messages appear without opening the chat
                    if (this.previewTimer) clearInterval(this.previewTimer);
                    this.previewTimer = setInterval(() => {
                        this.pollContactPreviews();
                    }, 5000);
                    this.pollContactPreviews();
                },

                async fetchLatestMessages() {
                    if (!this.activeChat) return;
                    const res = await fetch(`/chat/history/${this.activeChat.id}?t=${Date.now()}`, {
                        cache: 'no-store'
                    });
                    const messages = await res.json();
                    this.activeChat.messages = messages;
                    this.updateChatMeta(this.activeChat, messages);
                    this.bumpChat(this.activeChat);
                    if (messages.length) {
                        const lastId = messages[messages.length - 1].id;
                        this.setLastReadId(this.activeChat.id, lastId);
                        this.activeChat.unread = 0;
                    }
                    this.$nextTick(() => {
                        if (this.stickToBottom) {
                            this.$refs.chatWindow.scrollTop = this.$refs.chatWindow.scrollHeight;
                        }
                    });
                },

                async initZego() {
                    const res = await fetch('/zego/chat-token', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const data = await res.json();

                    if (!ZIM.getInstance()) ZIM.create({
                        appID: data.appID
                    });
                    zimTherapist = ZIM.getInstance();

                    zimTherapist.on('error', (zim, err) => console.error('ZIM error', err));
                    zimTherapist.on('peerMessageReceived', async (zim, {
                        fromConversationID
                    }) => {
                        const patient = this.allPatients.find(p => String(p.id) === String(
                            fromConversationID));
                        if (!patient) return;

                        // Always fetch latest messages for this patient, whether chat is active or not
                        const res = await fetch(`/chat/history/${patient.id}?t=${Date.now()}`, {
                            cache: 'no-store'
                        });
                        const messages = await res.json();
                        patient.messages = messages;
                        this.updateChatMeta(patient, messages);
                        this.bumpChat(patient);

                        // If this patient is active, scroll chat
                        if (this.activeChat?.id === patient.id) {
                            if (messages.length) {
                                const lastId = messages[messages.length - 1].id;
                                this.setLastReadId(patient.id, lastId);
                                patient.unread = 0;
                            }
                            this.$nextTick(() => {
                                if (this.stickToBottom) {
                                    this.$refs.chatWindow.scrollTop = this.$refs.chatWindow
                                        .scrollHeight;
                                }
                            });
                        } else {
                            const lastReadId = this.getLastReadId(patient.id);
                            patient.unread = messages.filter(m => m.id > lastReadId).length;
                        }
                    });

                    await zimTherapist.login(data.userID, {
                        userName: data.userName,
                        token: data.token
                    });
                    isZimLoggedIn = true;
                },

                async setActiveChat(patient) {
                    this.activeChat = patient;
                    currentPeerID = patient.id;
                    patient.unread = 0;
                    this.stickToBottom = true;
                    await this.fetchLatestMessages();
                    this.bumpChat(patient);
                },

                async sendMessage() {
                    if (!isZimLoggedIn || !currentPeerID || !this.newMessage.trim()) return;
                    const text = this.newMessage;
                    const now = new Date();
                    const timeLabel = this.formatTimeLabel(now);
                    const dateLabel = this.formatDateLabel(now);

                    await fetch('/chat/store-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            to_user_id: currentPeerID,
                            to_user_type: this.activeChat?.userType ?? 1,
                            message: text
                        })
                    });

                    this.activeChat.messages.push({
                        id: Date.now(),
                        sender: 'therapist',
                        text,
                        time: timeLabel,
                        date: dateLabel,
                        dateTime: dateLabel,
                        timestamp: now.toISOString(),
                    });

                    this.newMessage = '';
                    this.updateChatMeta(this.activeChat, this.activeChat.messages);
                    this.bumpChat(this.activeChat);

                    await zimTherapist.sendMessage({
                        type: 1,
                        message: '' // signal only
                    }, String(currentPeerID), 0, {
                        priority: 1
                    });


                    this.$nextTick(() => this.$refs.chatWindow.scrollTop = this.$refs.chatWindow.scrollHeight);
                },

                formatDateLabel(dateObj) {
                    return dateObj.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                },

                formatTimeLabel(dateObj) {
                    return dateObj.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },

                truncateText(text, limit = 20) {
                    if (!text) return '';
                    const clean = String(text).replace(/<[^>]*>/g, '');
                    if (clean.length <= limit) return clean;
                    return clean.slice(0, limit) + '...';
                },

                getReadKey() {
                    return `chat_read_${this.myUserId || 'user'}`;
                },

                loadReadMap() {
                    try {
                        const raw = localStorage.getItem(this.getReadKey());
                        return raw ? JSON.parse(raw) : {};
                    } catch (e) {
                        return {};
                    }
                },

                saveReadMap() {
                    try {
                        localStorage.setItem(this.getReadKey(), JSON.stringify(this.readMap || {}));
                    } catch (e) {
                        // ignore storage errors
                    }
                },

                getLastReadId(peerId) {
                    if (!peerId) return 0;
                    return Number(this.readMap?.[String(peerId)] || 0);
                },

                hasReadEntry(peerId) {
                    if (!peerId) return false;
                    return Object.prototype.hasOwnProperty.call(this.readMap || {}, String(peerId));
                },

                setLastReadId(peerId, id) {
                    if (!peerId || !id) return;
                    this.readMap = this.readMap || {};
                    this.readMap[String(peerId)] = id;
                    this.saveReadMap();
                },

                primeReadMap(list) {
                    if (!Array.isArray(list)) return;
                    list.forEach((item) => {
                        if (!item || !item.id) return;
                        if (!this.hasReadEntry(item.id) && item.lastMessageId) {
                            this.setLastReadId(item.id, item.lastMessageId);
                        }
                    });
                },

                getChatTimestamp(chat) {
                    if (!chat) return 0;
                    const ts = chat.lastTimestamp || chat.timestamp || chat.dateTime || chat.date;
                    const time = ts ? Date.parse(ts) : NaN;
                    return Number.isNaN(time) ? 0 : time;
                },

                sortChats() {
                    this.allPatients.sort((a, b) => this.getChatTimestamp(b) - this.getChatTimestamp(a));
                },

                refreshFiltered() {
                    this.applyFilters(false);
                },

                bumpChat(chat) {
                    if (!chat) return;
                    this.sortChats();
                    this.refreshFiltered();
                },

                scrollToTop() {
                    if (this.$refs.chatWindow) {
                        this.stickToBottom = false;
                        this.$refs.chatWindow.scrollTop = 0;
                    }
                },

                scrollToBottom() {
                    if (this.$refs.chatWindow) {
                        this.stickToBottom = true;
                        this.$refs.chatWindow.scrollTop = this.$refs.chatWindow.scrollHeight;
                    }
                },

                updateChatMeta(chat, messages) {
                    if (!chat || !messages || !messages.length) return;
                    const last = messages[messages.length - 1];
                    chat.lastMessage = this.truncateText(last.text ?? 'New message', 20);
                    chat.lastMessageId = last.id ?? chat.lastMessageId ?? null;
                    if (last.time) chat.time = last.time;
                    if (last.timestamp) chat.lastTimestamp = last.timestamp;
                    const ts = last.timestamp || last.dateTime || last.date;
                    if (ts) {
                        const dt = new Date(ts);
                        if (!isNaN(dt)) {
                            chat.dateTime = this.formatDateLabel(dt);
                            if (!chat.time) chat.time = this.formatTimeLabel(dt);
                            if (!chat.lastTimestamp) chat.lastTimestamp = dt.toISOString();
                        }
                    }
                },

                async pollContactPreviews() {
                    if (!this.allPatients.length) return;
                    const activeId = this.activeChat?.id ? String(this.activeChat.id) : null;
                    const jobs = this.allPatients
                        .filter(p => String(p.id) !== activeId)
                        .map(async (p) => {
                            const res = await fetch(`/chat/history/${p.id}?t=${Date.now()}`, {
                                cache: 'no-store'
                            });
                              const messages = await res.json();
                              if (!messages.length) return;

                              const newLastId = messages[messages.length - 1].id || 0;
                              if (newLastId && !this.hasReadEntry(p.id)) {
                                  this.setLastReadId(p.id, newLastId);
                              }
                              const lastReadId = this.getLastReadId(p.id);
                              const unreadCount = messages.filter(m => m.id > lastReadId).length;
                              p.unread = unreadCount;
                              if (newLastId && newLastId !== (p.lastMessageId || 0)) {
                                  this.updateChatMeta(p, messages);
                                this.bumpChat(p);
                            }
                        });

                    await Promise.all(jobs);
                },

                applyFilters(useDate = false) {
                    if (useDate) this.filtersActive = true;
                    const name = this.searchName.toLowerCase().trim();
                    const start = this.startDate ? new Date(this.startDate + 'T00:00:00') : null;
                    const end = this.endDate ? new Date(this.endDate + 'T23:59:59') : null;

                    if (!start && !end) this.filtersActive = false;
                    const applyDate = this.filtersActive && (start || end);

                    this.filteredPatients = this.allPatients.filter(p => {
                        const matchesName = !name || (p.name ?? '').toLowerCase().includes(name);
                        if (!matchesName) return false;

                        if (!applyDate) return true;

                        const itemDate = this.parseDate(p.dateTime);
                        if (!itemDate) return false;
                        if (start && itemDate < start) return false;
                        if (end && itemDate > end) return false;
                        return true;
                    });
                },

                parseDate(value) {
                    if (!value) return null;

                    const parsed = new Date(value);
                    if (!isNaN(parsed)) {
                        return new Date(parsed.getFullYear(), parsed.getMonth(), parsed.getDate());
                    }

                    const parts = String(value).trim().split(/\s+/);
                    if (parts.length < 3) return null;

                    const day = parseInt(parts[0], 10);
                    const year = parseInt(parts[2], 10);
                    const monthKey = parts[1].toLowerCase().slice(0, 3);
                    const monthMap = {
                        jan: 1,
                        feb: 2,
                        mar: 3,
                        apr: 4,
                        may: 5,
                        jun: 6,
                        jul: 7,
                        aug: 8,
                        sep: 9,
                        oct: 10,
                        nov: 11,
                        dec: 12
                    };
                    const month = monthMap[monthKey];
                    if (!day || !year || !month) return null;

                    return new Date(year, month - 1, day);
                },

                resetFilters() {
                    this.searchName = '';
                    this.startDate = '';
                    this.endDate = '';
                    this.filtersActive = false;
                    this.filteredPatients = this.allPatients;
                },

                destroy() {
                    if (this.pollingTimer) clearInterval(this.pollingTimer);
                    if (this.previewTimer) clearInterval(this.previewTimer);
                }
            }
        }
    </script>
</x-app1>
