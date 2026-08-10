<x-app-layout title="Contact Us | JustMy.Health" metaDescription="Contact JustMy.Health for questions, feedback, or support.">
    <section class="relative min-h-[22rem] sm:min-h-[18rem] lg:h-80 flex lg:items-center pt-24 pb-10 lg:pt-24 lg:pb-0">
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.png') }}" alt="Contact Us Background" class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 bg-slate-950/50"></div>
        </div>

        <div class="px-6 lg:px-20 max-w-4xl">
            <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <span>Home</span>
                <span class="text-white/60">›</span>
                <span class="text-white font-semibold">Contact Us</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">Contact <span class="text-teal-400">JustMy.Health</span></h1>
         
        </div>
    </section>

    <section class="pt-14 pb-4 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Contact Us</h2>
            <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                Have a question or need help? Send us a message and our team will respond as soon as possible.
            </p>
        </div>
    </section>

    <section class="py-16 bg-gray-50 overflow-x-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">

            <!-- Left side: redesigned info panel -->
            <div class="space-y-6">

                <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-200/50">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFBFA] px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#1C9BA0]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#1C9BA0]"></span>
                        Let's talk
                    </span>

                    <div class="mt-5 flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAFBFA] text-[#1C9BA0]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Get in touch</h2>
                            <p class="mt-1.5 text-sm text-slate-600 leading-relaxed">
                                Whether you're already using JustMy.Health or just finding out what we offer, we want to hear from you. Use the form to ask a question, share feedback, or start a conversation.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-200/50">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAFBFA] text-[#1C9BA0]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Not sure where to start?</h3>
                            <p class="mt-1 text-sm text-slate-600">New to JustMy.Health and have a question before signing up? Email us directly and a real person will reply.</p>
                        </div>
                    </div>

                    <a href="mailto:website@justmy.health"
                        class="mt-5 flex items-center justify-center gap-2 rounded-[10px] border border-[#1C9BA0]/30 bg-[#EAFBFA] px-4 py-3 text-sm font-semibold text-[#18848F] shadow-sm transition hover:bg-[#1C9BA0]/10 hover:border-[#1C9BA0]/50">
                        website@justmy.health
                    </a>

                    <div class="mt-7">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400 mb-3">Available subjects</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700">General enquiry</span>
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700">Product support</span>
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700">Partnership request</span>
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700">Feedback / suggestions</span>
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700">Other</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right side: form -->
            <div class="rounded-[2rem] bg-white p-8 shadow-xl border border-slate-200">
                @if (session('status'))
                    <div class="rounded-[10px] border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700 mb-6">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact-us.submit') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label for="Name" class="text-sm font-semibold text-slate-700">Name</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input id="Name" name="Name" value="{{ old('Name') }}" required
                                placeholder="e.g. John Smith"
                                class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm" />
                        </div>
                        @error('Name')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="Email" class="text-sm font-semibold text-slate-700">Email</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input id="Email" name="Email" type="email" value="{{ old('Email') }}" required
                                placeholder="you@example.com"
                                class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm" />
                        </div>
                        @error('Email')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="Subject" class="text-sm font-semibold text-slate-700">Subject</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h9m-9 3.75h5.25M6.75 3.75h10.5A2.25 2.25 0 0119.5 6v14.25a.75.75 0 01-1.09.67L12 17.44l-6.41 3.48a.75.75 0 01-1.09-.67V6a2.25 2.25 0 012.25-2.25z" />
                                </svg>
                            </span>
                            <select id="Subject" name="Subject" required
                                class="block w-full appearance-none rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm">
                                <option value="">Select a subject</option>
                                <option value="General enquiry" {{ old('Subject') === 'General enquiry' ? 'selected' : '' }}>General enquiry</option>
                                <option value="Product support" {{ old('Subject') === 'Product support' ? 'selected' : '' }}>Product support</option>
                                <option value="Partnership request" {{ old('Subject') === 'Partnership request' ? 'selected' : '' }}>Partnership request</option>
                                <option value="Feedback / suggestions" {{ old('Subject') === 'Feedback / suggestions' ? 'selected' : '' }}>Feedback / suggestions</option>
                                <option value="Other" {{ old('Subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        @error('Subject')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="Message" class="text-sm font-semibold text-slate-700">Message</label>
                        <div class="relative mt-1.5">
                            <textarea id="Message" name="Message" rows="6" required
                                placeholder="Tell us how we can help..."
                                class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 px-4 py-2.5 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm">{{ old('Message') }}</textarea>
                        </div>
                        @error('Message')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    @include('partials.anti-bot-fields')

                    <button type="submit"
                        class="w-full flex justify-center rounded-[10px] bg-[#1C9BA0] px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#1C9BA0]/25 transition hover:bg-[#18848F] hover:shadow-xl hover:shadow-[#1C9BA0]/30">
                        Send message
                    </button>
                </form>
            </div>

        </div>
    </section>
</x-app-layout>