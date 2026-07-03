{{--
    Floating help chatbot. Include this once, near the closing </body> tag of
    your main layout (e.g. resources/views/components/app1.blade.php):

        <x-chatbot />

    Requires a CSRF meta tag in <head>, which Laravel's default layouts
    already include:

        <meta name="csrf-token" content="{{ csrf_token() }}">
--}}

<style>
    /* Hide the native scrollbar in the chat messages area (scroll still works) */
    .chatbot-scroll {
        scrollbar-width: none;      /* Firefox */
        -ms-overflow-style: none;   /* IE / old Edge */
    }
    .chatbot-scroll::-webkit-scrollbar {
        display: none;              /* Chrome, Safari, new Edge */
    }
</style>

<div
    x-data="chatbotWidget()"
    x-init="init()"
    class="fixed bottom-5 right-5 z-50 flex flex-col items-end"
>
    <!-- Chat panel -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        x-cloak
        class="mb-3 flex h-[440px] max-h-[70vh] w-[360px] max-w-[90vw] flex-col overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-[0_20px_60px_-15px_rgba(15,23,42,0.35)]"
    >
        <!-- Header -->
        <div class="relative overflow-hidden bg-gradient-to-br from-[#22B3B8] via-[#1C9BA0] to-[#136E73] px-5 py-4">
            <!-- decorative glow -->
            <div class="pointer-events-none absolute -right-8 -top-10 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
            <div class="pointer-events-none absolute -left-6 bottom-0 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>

            <div class="relative flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.456-2.456L14.25 6l1.035-.259a3.375 3.375 0 002.456-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
                        </svg>
                        <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-[#1C9BA0] bg-emerald-400"></span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-wide text-white">Coach Assistant</p>
                        <p class="text-[11px] text-white/80">Online · usually replies in seconds</p>
                    </div>
                </div>
                <button @click="open = false" class="rounded-full p-1.5 text-white/80 transition hover:bg-white/15 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div x-ref="scrollArea" class="chatbot-scroll flex-1 space-y-3 overflow-y-auto bg-[#F5FBFB] bg-[radial-gradient(circle_at_1px_1px,rgba(28,155,160,0.07)_1px,transparent_0)] bg-[length:18px_18px] px-4 pb-5 pt-4">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex items-end gap-2" :class="msg.role === 'user' ? 'flex-row-reverse' : 'flex-row'">
                    <!-- avatar -->
                    <div
                        class="mb-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[10px] font-semibold"
                        :class="msg.role === 'user' ? 'bg-slate-700 text-white' : 'bg-[#1C9BA0]/15 text-[#136E73]'"
                        x-text="msg.role === 'user' ? 'You' : 'AI'"
                    ></div>
                    <div
                        class="max-w-[76%] rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed whitespace-pre-wrap shadow-sm"
                        :class="msg.role === 'user'
                            ? 'bg-gradient-to-br from-[#1FA6AB] to-[#18848F] text-white rounded-br-sm'
                            : 'bg-white text-slate-700 border border-slate-200 rounded-bl-sm'"
                        x-text="msg.content"
                    ></div>
                </div>
            </template>

            <!-- Typing indicator -->
            <div x-show="loading" x-cloak class="flex items-end gap-2">
                <div class="mb-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#1C9BA0]/15 text-[10px] font-semibold text-[#136E73]">AI</div>
                <div class="flex items-center gap-1 rounded-2xl rounded-bl-sm border border-slate-200 bg-white px-3.5 py-3 shadow-sm">
                    <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#1C9BA0]" style="animation-delay:0ms"></span>
                    <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#1C9BA0]" style="animation-delay:150ms"></span>
                    <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#1C9BA0]" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>

        <!-- Quick suggestions (only before the conversation starts) -->
        <div x-show="messages.length <= 1" x-cloak class="border-t border-slate-100 bg-white px-3 pb-2.5 pt-5.5">
            <p class="mb-2 px-1 text-[10px] font-medium uppercase tracking-wide text-slate-400">Popular questions</p>
            <div class="flex flex-wrap gap-1.5">
                <template x-for="q in suggestions" :key="q">
                    <button
                        @click="send(q)"
                        class="rounded-full border border-[#1C9BA0]/25 bg-[#EAFBFA] px-3 py-1.5 text-xs font-medium text-[#136E73] transition hover:border-[#1C9BA0]/50 hover:bg-[#1C9BA0]/10"
                        x-text="q"
                    ></button>
                </template>
            </div>
        </div>

        <!-- Input -->
        <form @submit.prevent="send()" class="flex items-center gap-2 border-t border-slate-100 bg-white p-3">
            <input
                x-model="draft"
                x-ref="input"
                type="text"
                placeholder="Ask me anything about your bookings..."
                :disabled="loading"
                class="flex-1 rounded-full border-slate-200 bg-slate-50 px-4 py-2.5 text-sm placeholder:text-slate-400 focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0]/30 disabled:opacity-60"
            >
            <button
                type="submit"
                :disabled="loading || !draft.trim()"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#1FA6AB] to-[#18848F] text-white shadow-md shadow-[#1C9BA0]/30 transition hover:brightness-105 disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none"
            >
                <!-- Send / paper-plane icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 translate-x-[-1px]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3.4 20.6a.75.75 0 01-.99-.94l2.4-7.16 8.1-1.5-8.1-1.5-2.4-7.16a.75.75 0 01.99-.94l18.4 8.6a.75.75 0 010 1.36l-18.4 8.6a.75.75 0 01-.4.14z" />
                </svg>
            </button>
        </form>
        <p class="border-t border-slate-50 bg-white px-4 py-1.5 text-center text-[10px] text-slate-400">
            Answers may be inaccurate — for account issues, contact support.
        </p>
    </div>

    <!-- Floating bubble toggle -->
    <button
        @click="open = !open"
        class="relative flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-[#22B3B8] to-[#136E73] text-white shadow-lg shadow-[#1C9BA0]/40 transition hover:scale-105 hover:shadow-xl"
    >
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
        </svg>
        <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        <span
            x-show="!open && messages.length <= 1"
            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-amber-500 text-[10px] font-bold text-white ring-2 ring-white"
        >!</span>
    </button>
</div>

<script>
    function chatbotWidget() {
        return {
            open: false,
            draft: '',
            loading: false,
            suggestions: [
                'How do I book a session?',
                'How do I pay?',
                'How do I cancel a booking?',
            ],
            messages: [
                { role: 'assistant', content: "Hi there \ud83d\udc4b I'm your coaching assistant. I can help with bookings, payments, workouts, and account questions — what do you need help with?" },
            ],

            init() {
                // Nothing to preload for now — kept as a hook for future
                // persistence (e.g. restoring history from window.storage).
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const el = this.$refs.scrollArea;
                    if (el) el.scrollTop = el.scrollHeight;
                });
            },

            async send(preset = null) {
                const text = (preset ?? this.draft).trim();
                if (!text || this.loading) return;

                this.messages.push({ role: 'user', content: text });
                this.draft = '';
                this.loading = true;
                this.scrollToBottom();

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

                    const res = await fetch('{{ route('chatbot.ask') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            message: text,
                            // Send prior turns (excluding the greeting) so the bot has context.
                            history: this.messages.slice(1, -1),
                        }),
                    });

                    const data = await res.json();
                    this.messages.push({ role: 'assistant', content: data.reply || "Sorry, I couldn't get an answer just now." });
                } catch (e) {
                    this.messages.push({ role: 'assistant', content: 'Sorry, I could not reach the server. Please check your connection and try again.' });
                } finally {
                    this.loading = false;
                    this.scrollToBottom();
                    this.$nextTick(() => this.$refs.input?.focus());
                }
            },
        };
    }
</script>