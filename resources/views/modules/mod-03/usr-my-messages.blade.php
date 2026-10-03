<x-app1>
    <div class="space-y-6" x-data="userMessageApp()" x-init="init()" x-on:beforeunload.window="destroy()">

        <!-- Header -->
        <x-page-header />

        <!-- Filter Bar Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none p-4 sm:p-5 transition-all">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3 sm:gap-4">
                
                <!-- Search by Therapist Name -->
                <div class="relative flex-1 min-w-[240px]">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 dark:text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        x-model="searchName"
                        placeholder="Search therapist name..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 text-xs sm:text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs">
                </div>

                <!-- Date Range & Action Buttons -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <div class="relative">
                            <input
                                type="date"
                                x-model="startDate"
                                x-ref="startDate"
                                autocomplete="off"
                                class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3 py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs cursor-pointer">
                        </div>
                        <span class="text-xs font-medium text-gray-400 dark:text-gray-500">to</span>
                        <div class="relative">
                            <input
                                type="date"
                                x-model="endDate"
                                x-ref="endDate"
                                autocomplete="off"
                                class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-3 py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs cursor-pointer">
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <button
                        type="button"
                        @click="applyFilters(true)"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-white font-semibold text-xs sm:text-sm tracking-wide shadow-xs hover:shadow-md transition-all active:scale-[0.98] cursor-pointer hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter</span>
                    </button>

                    <!-- Reset Button -->
                    <button
                        type="button"
                        @click="resetFilters()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/60 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold text-xs sm:text-sm tracking-wide transition-all active:scale-[0.98] cursor-pointer shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Messaging Workspace Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-start">

            <!-- Contact List (Therapists) -->
            <div class="lg:col-span-4 xl:col-span-4 bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none overflow-hidden flex flex-col max-h-56 sm:max-h-64 lg:max-h-none lg:h-[72vh]">
                
                <!-- Contact List Header -->
                <div class="p-3.5 sm:p-4 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/80">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-xs sm:text-sm uppercase tracking-wider text-gray-700 dark:text-gray-200">Therapists</h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#1C9BA0]/15 text-[#1C9BA0] dark:bg-[#1C9BA0]/25 dark:text-[#2DD4BF]" x-text="filteredTherapists.length"></span>
                    </div>
                </div>

                <!-- Contact List Scrollable Body -->
                <ul class="divide-y divide-gray-100 dark:divide-gray-700/60 overflow-y-auto flex-1">
                    <template x-for="therapist in filteredTherapists" :key="therapist.id">
                        <li @click="setActiveChat(therapist)"
                            class="p-3.5 sm:p-4 cursor-pointer transition-all relative flex items-center gap-3.5 select-none"
                            :class="activeChat?.id === therapist.id
                                ? 'bg-[#1C9BA0]/10 dark:bg-[#1C9BA0]/20'
                                : 'hover:bg-gray-50/90 dark:hover:bg-gray-700/40'">

                            <!-- Active Indicator Bar -->
                            <div x-show="activeChat?.id === therapist.id"
                                 class="absolute left-0 top-0 bottom-0 w-1"
                                 style="background: linear-gradient(180deg, #1C9BA0, #127F94);"></div>

                            <!-- Avatar with Ring -->
                            <div class="relative shrink-0">
                                <img :src="therapist.avatar" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-2xs">
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-gray-800"></span>
                            </div>

                            <!-- Text Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1 mb-1">
                                    <p class="font-semibold text-xs sm:text-sm text-gray-900 dark:text-gray-100 truncate" x-text="therapist.name"></p>
                                    <span class="text-[11px] text-gray-400 dark:text-gray-500 whitespace-nowrap shrink-0" x-text="formatDateTimeLabel(therapist)"></span>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate"
                                        x-text="therapist.lastMessage ?? 'Tap to chat'"></p>
                                    <span x-show="(therapist.unread || 0) > 0"
                                        class="min-w-[18px] h-[18px] px-1.5 text-[10px] font-bold leading-[18px] text-center rounded-full text-white shrink-0 shadow-2xs"
                                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                                        x-text="therapist.unread"></span>
                                </div>
                                <p x-show="therapist.dateTime" class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5" x-text="therapist.dateTime"></p>
                            </div>
                        </li>
                    </template>

                    <!-- Empty State for Contact List -->
                    <template x-if="filteredTherapists.length === 0">
                        <li class="p-8 text-center text-gray-400 dark:text-gray-500 flex flex-col items-center justify-center">
                            <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="text-xs">No therapists found</span>
                        </li>
                    </template>
                </ul>
            </div>

            <!-- Chat Window -->
            <div class="lg:col-span-8 xl:col-span-8 bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none overflow-hidden flex flex-col h-[60vh] sm:h-[65vh] lg:h-[72vh] relative">
                
                <!-- Chat Window Active View -->
                <template x-if="activeChat">
                    <div class="flex flex-col h-full">

                        <!-- Active Chat Header -->
                        <div class="border-b border-gray-100 dark:border-gray-700/80 px-4 sm:px-6 py-3.5 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/80">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img :src="activeChat.avatar" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 shadow-2xs">
                                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-gray-800"></span>
                                </div>
                                <div>
                                    <p class="font-bold text-xs sm:text-sm text-gray-900 dark:text-gray-100 tracking-tight" x-text="activeChat.name"></p>
                                    <p class="text-[11px] text-gray-400 dark:text-gray-500" x-text="formatDateTimeLabel(activeChat)"></p>
                                </div>
                            </div>

                            <!-- Header Controls (Message Count & Jump to Oldest/Latest) -->
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400 dark:text-gray-500 hidden sm:inline"
                                    x-text="activeChat?.messages?.length ? `Messages: ${activeChat.messages.length}` : ''">
                                </span>
                                <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700/60 p-0.5 rounded-xl">
                                    <button type="button" @click="scrollToTop()"
                                        class="px-2.5 py-1 text-[11px] font-semibold rounded-lg text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600 transition shadow-2xs cursor-pointer">Oldest</button>
                                    <button type="button" @click="scrollToBottom()"
                                        class="px-2.5 py-1 text-[11px] font-semibold rounded-lg text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600 transition shadow-2xs cursor-pointer">Latest</button>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages Window Body -->
                        <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 bg-gray-50/30 dark:bg-gray-900/20" x-ref="chatWindow" @scroll="trackScroll()">
                            <template x-for="msg in activeChat.messages" :key="msg.id">
                                <div>
                                    <!-- Incoming Message (Therapist) -->
                                    <div x-show="!isMine(msg)" class="flex items-end gap-2.5 max-w-[85%] sm:max-w-[70%]">
                                        <img :src="activeChat.avatar" class="w-7 h-7 rounded-full object-cover shrink-0 mb-1 ring-1 ring-gray-200 dark:ring-gray-700">
                                        <div class="bg-white dark:bg-gray-700/80 text-gray-800 dark:text-gray-100 rounded-2xl rounded-bl-xs p-3.5 shadow-2xs border border-gray-100 dark:border-gray-600/50">
                                            <p class="text-xs sm:text-sm leading-relaxed" x-html="formatMessage(msg.text)"></p>
                                            <p class="text-[10px] text-gray-400 dark:text-gray-400 mt-1.5 text-right font-medium" x-text="formatDateTimeLabel(msg)"></p>
                                        </div>
                                    </div>

                                    <!-- Outgoing Message (Patient) -->
                                    <div x-show="isMine(msg)" class="flex justify-end">
                                        <div class="text-white rounded-2xl rounded-br-xs p-3.5 max-w-[85%] sm:max-w-[70%] shadow-2xs"
                                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                            <p class="text-xs sm:text-sm leading-relaxed text-white" x-html="formatMessage(msg.text)"></p>
                                            <p class="text-[10px] text-teal-100/80 mt-1.5 text-right font-medium" x-text="formatDateTimeLabel(msg)"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Chat Message Input Form -->
                        <form @submit.prevent="sendMessage()" class="p-3 sm:p-4 border-t border-gray-100 dark:border-gray-700/80 bg-white dark:bg-gray-800 flex items-center gap-2 sm:gap-3">
                            <input
                                x-model="newMessage"
                                class="flex-1 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 px-4 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                placeholder="Type message...">
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl sm:rounded-2xl text-white font-semibold text-xs sm:text-sm tracking-wide shadow-xs hover:shadow-md transition-all active:scale-[0.98] cursor-pointer hover:opacity-95 shrink-0"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <span>Send</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </form>

                    </div>
                </template>

                <!-- Empty State (When no conversation is selected) -->
                <template x-if="!activeChat">
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50/20 dark:bg-gray-900/10 h-full">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white mb-4 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-800 dark:text-gray-100">Select a Conversation</h3>
                        <p class="text-xs sm:text-sm text-gray-400 dark:text-gray-500 mt-1 max-w-sm leading-relaxed">
                            Choose a therapist from the list to view your message history or start a conversation.
                        </p>
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
