{{--
    Floating help chatbot. Include this once, near the closing </body> tag of
    your main layout (e.g. resources/views/components/app1.blade.php):

        <x-chatbot />

    Requires a CSRF meta tag in <head>, which Laravel's default layouts
    already include:

        <meta name="csrf-token" content="{{ csrf_token() }}">
--}}

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
        class="mb-3 flex h-[520px] w-[360px] max-w-[90vw] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
    >
        <!-- Header -->
        <div class="flex items-center justify-between gap-3 bg-gradient-to-r from-[#1C9BA0] to-[#18848F] px-4 py-3.5">
            <div class="flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-6l-4 4v-4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Help Assistant</p>
                    <p class="text-[11px] text-white/80">Ask about bookings, payment & more</p>
                </div>
            </div>
            <button @click="open = false" class="rounded-full p-1 text-white/80 hover:bg-white/10 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Messages -->
        <div x-ref="scrollArea" class="flex-1 space-y-3 overflow-y-auto bg-[#F7FCFC] px-4 py-4">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    <div
                        class="max-w-[80%] rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed whitespace-pre-wrap"
                        :class="msg.role === 'user'
                            ? 'bg-[#1C9BA0] text-white rounded-br-md'
                            : 'bg-white text-slate-700 border border-slate-200 rounded-bl-md'"
                        x-text="msg.content"
                    ></div>
                </div>
            </template>

            <!-- Typing indicator -->
            <div x-show="loading" x-cloak class="flex justify-start">
                <div class="flex items-center gap-1 rounded-2xl rounded-bl-md border border-slate-200 bg-white px-3.5 py-3">
                    <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-slate-400" style="animation-delay:0ms"></span>
                    <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-slate-400" style="animation-delay:150ms"></span>
                    <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-slate-400" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>

        <!-- Quick suggestions (only before the conversation starts) -->
        <div x-show="messages.length <= 1" x-cloak class="flex flex-wrap gap-1.5 border-t border-slate-100 bg-white px-3 py-2.5">
            <template x-for="q in suggestions" :key="q">
                <button
                    @click="send(q)"
                    class="rounded-full border border-[#1C9BA0]/20 bg-[#EAFBFA] px-3 py-1.5 text-xs font-medium text-[#1C9BA0] hover:bg-[#1C9BA0]/10"
                    x-text="q"
                ></button>
            </template>
        </div>

        <!-- Input -->
        <form @submit.prevent="send()" class="flex items-center gap-2 border-t border-slate-100 bg-white p-3">
            <input
                x-model="draft"
                x-ref="input"
                type="text"
                placeholder="Type your question..."
                :disabled="loading"
                class="flex-1 rounded-full border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0]/30 disabled:opacity-60"
            >
            <button
                type="submit"
                :disabled="loading || !draft.trim()"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#1C9BA0] text-white transition hover:bg-[#18848F] disabled:cursor-not-allowed disabled:opacity-40"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Floating bubble toggle -->
    <button
        @click="open = !open"
        class="relative flex h-14 w-14 items-center justify-center rounded-full bg-[#1C9BA0] text-white shadow-lg shadow-[#1C9BA0]/30 transition hover:bg-[#18848F] hover:scale-105"
    >
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-6l-4 4v-4z" />
        </svg>
        <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        <span
            x-show="!open && messages.length <= 1"
            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-amber-500 text-[10px] font-bold text-white"
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
                { role: 'assistant', content: "Hi! I can help with booking sessions, payments, workouts, and account questions. What do you need help with?" },
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
