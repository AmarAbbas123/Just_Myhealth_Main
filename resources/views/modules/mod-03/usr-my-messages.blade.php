<x-app1>
    <div class="space-y-6" x-data="userMessageApp()" x-init="init()" x-on:beforeunload.window="destroy()">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-lg p-4 shadow-sm flex flex-wrap items-center gap-3">
            <input type="text" x-model="searchName" placeholder="Search therapist name..."
                class="flex-1 rounded-md border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
            <div class="flex flex-wrap items-center gap-2">
                <input type="date" x-model="startDate" x-ref="startDate" autocomplete="off" class="border-gray-300 rounded-md text-sm px-2 py-2">
                <span class="text-gray-500 text-sm">to</span>
                <input type="date" x-model="endDate" x-ref="endDate" autocomplete="off" class="border-gray-300 rounded-md text-sm px-2 py-2">
                <button @click="applyFilters(true)"
                    class="px-3 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    Filter
                </button>
                <button @click="resetFilters()"
                    class="px-3 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition">
                    Reset
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

            <!-- Contact List -->
            <div class="lg:col-span-1 bg-white rounded-lg shadow overflow-y-auto max-h-[70vh]">
                <template x-for="therapist in filteredTherapists" :key="therapist.id">
                    <li @click="setActiveChat(therapist)" class="p-3 cursor-pointer hover:bg-gray-50 border-b"
                        :class="{ 'bg-purple-50': activeChat?.id === therapist.id }">
                        <div class="flex gap-3 items-center">
                            <img :src="therapist.avatar" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <p class="font-medium" x-text="therapist.name"></p>
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs text-gray-400" x-text="formatDateTimeLabel(therapist)"></p>
                                        <span x-show="(therapist.unread || 0) > 0"
                                            class="min-w-[18px] h-[18px] px-1 text-[10px] leading-[18px] text-center rounded-full bg-red-600 text-white"
                                            x-text="therapist.unread"></span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 truncate"
                                    x-text="therapist.lastMessage ?? 'Tap to chat'"></p>
                                <p class="text-[11px] text-gray-400" x-text="therapist.dateTime ?? ''"></p>
                            </div>
                        </div>
                    </li>
                </template>
            </div>

            <!-- Chat Window -->
            <div class="lg:col-span-3 bg-white rounded-lg shadow flex flex-col h-[70vh]">
                <template x-if="activeChat">
                    <div class="flex flex-col h-full">
                        <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center gap-3">
                            <img :src="activeChat.avatar" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-100" x-text="activeChat.name">
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatDateTimeLabel(activeChat)">
                                </p>
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

                        <div class="flex-1 overflow-y-auto p-4 space-y-3" x-ref="chatWindow" @scroll="trackScroll()">
                            <template x-for="msg in activeChat.messages" :key="msg.id">
                                <div>
                                    <div x-show="!isMine(msg)" class="flex gap-2">
                                        <img :src="activeChat.avatar" class="w-8 h-8 rounded-full">
                                        <div class="bg-gray-100 rounded p-2 max-w-xs">
                                            <p class="text-sm" x-html="formatMessage(msg.text)"></p>
                                            <p class="text-xs text-gray-400 mt-1" x-text="formatDateTimeLabel(msg)"></p>
                                        </div>
                                    </div>
                                    <div x-show="isMine(msg)" class="flex justify-end">
                                        <div class="bg-green-600 text-white rounded p-2 max-w-xs">
                                            <p class="text-sm" x-html="formatMessage(msg.text)"></p>
                                            <p class="text-xs text-gray-400 mt-1" x-text="formatDateTimeLabel(msg)"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <form @submit.prevent="sendMessage()" class="p-3 border-t flex gap-2">
                            <input x-model="newMessage" class="flex-1 border rounded px-3 py-2"
                                placeholder="Type message...">
                            <button class="bg-green-600 text-white px-4 rounded">Send</button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        let zimUser = null;
        let currentPeerID = null;
        let isZimLoggedIn = false;

        function userMessageApp() {
            return {
                searchName: '',
                startDate: '',
                endDate: '',
                filteredTherapists: [],
                filtersActive: false,
                stickToBottom: true,
                allTherapists: @json($therapists),
                activeChat: null,
                newMessage: '',
                patientData: @json($patientData),
                myUserId: @json((int) (Auth::user()->ID ?? 0)),
                myUserType: @json((int) (Auth::user()->UserType ?? 0)),

                lastMessageId: null,
                pollingTimer: null,
                previewTimer: null,
                readMap: {},

                async init() {
                    this.startDate = '';
                    this.endDate = '';
                    this.filtersActive = false;
                    this.allTherapists = Array.isArray(this.allTherapists)
                        ? this.allTherapists
                        : Object.values(this.allTherapists || {});
                    this.allTherapists = this.allTherapists.map(t => ({ ...t, unread: t.unread ?? 0 }));
                    this.sortChats();
                    this.filteredTherapists = this.allTherapists;
                    this.readMap = this.loadReadMap();
                    this.primeReadMap(this.allTherapists);
                    this.$nextTick(() => {
                        if (this.$refs.startDate) this.$refs.startDate.value = '';
                        if (this.$refs.endDate) this.$refs.endDate.value = '';
                    });
                    this.$watch('searchName', () => this.applyFilters());
                    await this.initZego();

                    // Poll list previews so new messages appear without opening the chat
                    if (this.previewTimer) clearInterval(this.previewTimer);
                    this.previewTimer = setInterval(() => {
                        this.pollContactPreviews();
                    }, 5000);
                    this.pollContactPreviews();
                },

                isMine(msg) {
                    const myLabel = this.myUserType === 1 ? 'patient' : 'therapist';
                    return msg?.sender === myLabel;
                },

                /* ===============================
                   ZEGO SIGNAL ONLY
                =============================== */
                async initZego() {
                    const res = await fetch('/zego/chat-token', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const data = await res.json();

                    if (!ZIM.getInstance()) {
                        ZIM.create({
                            appID: data.appID
                        });
                    }

                    zimUser = ZIM.getInstance();

                    // Signal only - do NOT render message
                    zimUser.on('peerMessageReceived', async (zim, { fromConversationID }) => {
                        const therapist = this.allTherapists.find(t => String(t.id) === String(
                            fromConversationID));
                        if (!therapist) return;

                        const res = await fetch(`/chat/history/${therapist.id}?t=${Date.now()}`, {
                            cache: 'no-store'
                        });
                        const messages = await res.json();

                        therapist.messages = messages;
                        this.updateChatMeta(therapist, messages);
                        this.bumpChat(therapist);

                        if (this.activeChat?.id === therapist.id) {
                            this.activeChat.messages = messages;
                            this.lastMessageId = messages.length ?
                                messages[messages.length - 1].id :
                                null;
                            if (this.lastMessageId) {
                                this.setLastReadId(therapist.id, this.lastMessageId);
                            }
                            this.$nextTick(() => {
                                if (this.stickToBottom) {
                                    this.$refs.chatWindow.scrollTop =
                                        this.$refs.chatWindow.scrollHeight;
                                }
                            });
                        } else {
                            const lastReadId = this.getLastReadId(therapist.id);
                            therapist.unread = messages.filter(m => m.id > lastReadId).length;
                        }
                    });

                    await zimUser.login(this.patientData.id, {
                        userName: this.patientData.name,
                        token: data.token
                    });

                    isZimLoggedIn = true;
                },

                /* ===============================
                   OPEN CHAT
                =============================== */
                async setActiveChat(therapist) {
                    this.activeChat = therapist;
                    currentPeerID = therapist.id;
                    therapist.unread = 0;
                    this.stickToBottom = true;

                    const res = await fetch(`/chat/history/${currentPeerID}?t=${Date.now()}`, {
                        cache: 'no-store'
                    });
                    const history = await res.json();

                    this.activeChat.messages = history;
                    this.updateChatMeta(this.activeChat, history);
                    this.bumpChat(this.activeChat);
                    this.lastMessageId = history.length ?
                        history[history.length - 1].id :
                        null;
                    if (this.lastMessageId) {
                        this.setLastReadId(currentPeerID, this.lastMessageId);
                    }

                    this.$nextTick(() => {
                        if (this.stickToBottom) {
                            this.$refs.chatWindow.scrollTop =
                                this.$refs.chatWindow.scrollHeight;
                        }
                    });

                    if (this.pollingTimer) clearInterval(this.pollingTimer);
                    this.pollingTimer = setInterval(() => {
                        this.pollForNewMessages();
                    }, 3000);
                },

                /* ===============================
                   SEND MESSAGE
                =============================== */
                async sendMessage() {
                    if (!currentPeerID || !this.newMessage.trim()) return;

                    const text = this.newMessage;
                    this.newMessage = '';

                    await fetch('/chat/store-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            to_user_id: currentPeerID,
                            to_user_type: this.activeChat?.userType ?? 30,
                            message: text
                        })
                    });

                    // Signal peer to poll
                    await zimUser.sendMessage({
                            type: 1,
                            message: ''
                        },
                        String(currentPeerID),
                        0, {
                            priority: 1
                        }
                    );

                    // Update from DB
                    await this.pollForNewMessages(true);
                    this.bumpChat(this.activeChat);
                },

                /* ===============================
                   DB IS SOURCE OF TRUTH
                =============================== */
                async pollForNewMessages(force = false) {
                    if (!currentPeerID) return;

                    const res = await fetch(`/chat/history/${currentPeerID}?t=${Date.now()}`, {
                        cache: 'no-store'
                    });
                    const messages = await res.json();

                    if (!messages.length) {
                        this.activeChat.messages = [];
                        return;
                    }

                    this.activeChat.messages = messages;
                    this.lastMessageId = messages[messages.length - 1].id;
                    this.updateChatMeta(this.activeChat, messages);
                    this.activeChat.unread = 0;
                    this.bumpChat(this.activeChat);
                    this.setLastReadId(currentPeerID, this.lastMessageId);

                    this.$nextTick(() => {
                        if (this.stickToBottom) {
                            this.$refs.chatWindow.scrollTop =
                                this.$refs.chatWindow.scrollHeight;
                        }
                    });
                },

                async pollContactPreviews() {
                    if (!this.allTherapists.length) return;
                    const activeId = this.activeChat?.id ? String(this.activeChat.id) : null;
                    const jobs = this.allTherapists
                        .filter(t => String(t.id) !== activeId)
                        .map(async (t) => {
                            const res = await fetch(`/chat/history/${t.id}?t=${Date.now()}`, {
                                cache: 'no-store'
                            });
                              const messages = await res.json();
                              if (!messages.length) return;

                              const newLastId = messages[messages.length - 1].id || 0;
                              if (newLastId && !this.hasReadEntry(t.id)) {
                                  this.setLastReadId(t.id, newLastId);
                              }
                              const lastReadId = this.getLastReadId(t.id);
                              const unreadCount = messages.filter(m => m.id > lastReadId).length;
                              t.unread = unreadCount;
                              if (newLastId && newLastId !== (t.lastMessageId || 0)) {
                                  this.updateChatMeta(t, messages);
                                this.bumpChat(t);
                            }
                        });

                    await Promise.all(jobs);
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

                escapeHtml(value) {
                    const div = document.createElement('div');
                    div.textContent = value ?? '';
                    return div.innerHTML;
                },

                fileNameFromUrl(url) {
                    try {
                        const parsed = new URL(url, window.location.origin);
                        const file = parsed.pathname.split('/').filter(Boolean).pop() || 'Resource';
                        return decodeURIComponent(file);
                    } catch (e) {
                        return 'Resource';
                    }
                },

                safeLinkHtml(url, label) {
                    try {
                        const parsed = new URL(url, window.location.origin);
                        if (!['http:', 'https:'].includes(parsed.protocol)) {
                            return this.escapeHtml(label);
                        }

                        return `<a href="${this.escapeHtml(parsed.href)}" target="_blank" rel="noopener noreferrer" class="font-semibold underline text-blue-600">${this.escapeHtml(label || this.fileNameFromUrl(url))}</a>`;
                    } catch (e) {
                        return this.escapeHtml(label);
                    }
                },

                formatMessage(text) {
                    if (!text) return '';

                    let raw = String(text);
                    raw = raw.replace(/<a\s+[^>]*href=(["'])(.*?)\1[^>]*>([\s\S]*?)<\/a>/gi, (_match, _quote, url, label) => {
                        let cleanLabel = String(label || '').replace(/<[^>]*>/g, '').trim();
                        if (!cleanLabel || /^Resource\s+\d+$/i.test(cleanLabel)) {
                            cleanLabel = this.fileNameFromUrl(url);
                        }
                        return `[${cleanLabel}](${url})`;
                    });
                    raw = raw
                        .replace(/<br\s*\/?>/gi, '\n')
                        .replace(/<\/(p|div)>/gi, '\n')
                        .replace(/<\/?strong>/gi, '')
                        .replace(/<[^>]*>/g, '');

                    const linkPattern = /\[([^\]]+)\]\(((?:https?:\/\/|\/)[^)]+)\)/g;
                    let html = '';
                    let lastIndex = 0;
                    let match;

                    while ((match = linkPattern.exec(raw)) !== null) {
                        html += this.escapeHtml(raw.slice(lastIndex, match.index)).replace(/\n/g, '<br>');
                        html += this.safeLinkHtml(match[2], match[1]);
                        lastIndex = match.index + match[0].length;
                    }

                    html += this.escapeHtml(raw.slice(lastIndex)).replace(/\n/g, '<br>');
                    return html;
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
                    this.allTherapists.sort((a, b) => this.getChatTimestamp(b) - this.getChatTimestamp(a));
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

                trackScroll() {
                    this.stickToBottom = this.isNearBottom();
                },

                isNearBottom() {
                    const el = this.$refs.chatWindow;
                    if (!el) return true;
                    return el.scrollHeight - el.scrollTop - el.clientHeight < 48;
                },

                formatDateTimeLabel(item) {
                    if (!item) return '';
                    const date = item.dateTime || item.date || '';
                    const time = item.time || '';
                    return [date, time].filter(Boolean).join(' ');
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

                applyFilters(useDate = false) {
                    if (useDate) this.filtersActive = true;
                    const name = this.searchName.toLowerCase().trim();
                    const start = this.startDate ? new Date(this.startDate + 'T00:00:00') : null;
                    const end = this.endDate ? new Date(this.endDate + 'T23:59:59') : null;

                    if (!start && !end) this.filtersActive = false;
                    const applyDate = this.filtersActive && (start || end);

                    this.filteredTherapists = this.allTherapists.filter(t => {
                        const matchesName = !name || (t.name ?? '').toLowerCase().includes(name);
                        if (!matchesName) return false;

                        if (!applyDate) return true;

                        const itemDate = this.parseDate(t.dateTime);
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
                    this.filteredTherapists = this.allTherapists;
                },

                destroy() {
                    if (this.pollingTimer) clearInterval(this.pollingTimer);
                    if (this.previewTimer) clearInterval(this.previewTimer);
                }

            };
        }
    </script>

</x-app1>
