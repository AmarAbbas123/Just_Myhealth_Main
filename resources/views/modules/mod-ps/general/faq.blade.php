{{-- resources/views/faq.blade.php --}}
<x-app-layout>

    @php
    // Left Column FAQs with dynamic icons
    $faqsLeft = [
        [
            'q' => '1. What is JustMy.Health?',
            'a' => 'JustMy.Health is a digital health and wellbeing platform designed to help individuals improve their health through connection, engagement, education, and empowerment. It brings together users, healthcare providers, government health departments, NGOs, and medical support companies in one unified ecosystem.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3v4h6v-4c0-1.657-1.343-3-3-3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 4a8 8 0 100 16 8 8 0 000-16z" /></svg>'
        ],
        [
            'q' => '2. How does the platform work?',
            'a' => 'The platform follows a structured four‑step model called the Guided Path: Connect with trusted health resources and professionals; Engage with tools, programs, and community support; Educate yourself through credible, accessible health information; Empower your journey with personalized insights and services.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>'
        ],
        [
            'q' => '3. Who can use JustMy.Health?',
            'a' => 'Anyone looking to improve their health, wellbeing, or lifestyle can use the platform. We support individuals, families, communities, and organizations through both B2C and B2B services.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1112 21v-5" /></svg>'
        ],
        [
            'q' => '4. What services are available on the platform?',
            'a' => 'JustMy.Health offers online counselling and therapy, dietary and nutrition programs, preventive and curative health information, access to healthcare professionals, wellness tools and engagement programs, community and social support features.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12v4m0 0v4m0-4h4m-4 0H8" /></svg>'
        ],
        [
            'q' => '5. Is JustMy.Health a replacement for medical care?',
            'a' => 'No. While the platform provides access to licensed professionals and health information, it does not replace medical diagnosis or treatment. Users should always consult their personal healthcare provider for medical decisions.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-12.728 12.728" /><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636l12.728 12.728" /></svg>'
        ],
    ];
    
    // Right Column FAQs with dynamic icons
    $faqsRight = [
        [
            'q' => '6. Is my personal information secure?',
            'a' => 'Yes. We use industry‑standard security measures to protect your data. Your information is handled in accordance with our Privacy Policy, and we never sell your personal data.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z" /></svg>'
        ],
        [
            'q' => '7. Can organizations use JustMy.Health for their employees or members?',
            'a' => 'Yes. We offer scalable B2B solutions for employers, clinics, NGOs, and government partners. These solutions support workforce wellness, community health initiatives, and integrated care programs.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8M8 8v8M12 4v16" /></svg>'
        ],
        [
            'q' => '8. How do I get started?',
            'a' => 'Simply create an account, complete your profile, and begin exploring the Guided Path. You can connect with professionals, join programs, or browse health content immediately.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M12 4h9M3 12h18" /></svg>'
        ],
        [
            'q' => '9. Is the platform available globally?',
            'a' => 'Yes. JustMy.Health provides global coverage with locally tailored support. Services may vary by region depending on available partners and providers.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>'
        ],
        [
            'q' => '10. Who do I contact for support?',
            'a' => 'You can reach our support team at support@justmy.health for help with your account, services, or general questions.',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" /></svg>'
        ],
    ];
    @endphp
    
    <!-- Hero Section -->
    <section class="relative h-80 flex items-start lg:items-center pt-24 lg:pt-32">
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/20"></div>
        </div>
    
        <div class="px-6 lg:px-20 max-w-4xl">
            <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <span>Home</span>
                <span class="text-white/60">›</span>
                <span class="text-white font-semibold">FAQ</span>
            </div>
    
            <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
                FAQ <span class="text-teal-400">JustMy.Health</span>
            </h1>
            
        </div>
    </section>
    
    <!-- Intro Section with Icons -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Your Questions Answered</h2>
            <p class="text-gray-600 mb-12 text-lg lg:text-xl">We’ve compiled the most common questions to help you understand JustMy.Health better.</p>
    
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div class="flex flex-col items-center">
                    <div class="bg-teal-100 text-teal-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3v4h6v-4c0-1.657-1.343-3-3-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 4a8 8 0 100 16 8 8 0 000-16z"/></svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Health Guidance</h4>
                    <p class="text-gray-600 text-center">Reliable tips and expert advice for your wellbeing.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-teal-100 text-teal-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Fast Answers</h4>
                    <p class="text-gray-600 text-center">Get quick, clear explanations to your questions.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-teal-100 text-teal-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.84 6.344L12 14z"/></svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Trusted Platform</h4>
                    <p class="text-gray-600 text-center">A safe, professional, and verified digital health environment.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Accordion Section -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid gap-8 lg:grid-cols-2">
    
                <!-- Left Column -->
                <div class="space-y-6">
                    @foreach ($faqsLeft as $faq)
                        <details class="group rounded-2xl border border-gray-200 bg-gray-50 shadow hover:shadow-lg transition overflow-hidden">
                            <summary class="flex justify-between items-center font-semibold text-gray-900 cursor-pointer px-6 py-5">
                                <div class="flex items-center gap-3">
                                    {!! $faq['icon'] !!}
                                    <span>{{ $faq['q'] }}</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-open:rotate-180"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="faq-content px-6 pb-6 text-gray-600 text-base leading-relaxed">
                                {!! nl2br(e($faq['a'])) !!}
                            </div>
                        </details>
                    @endforeach
                </div>
    
                <!-- Right Column -->
                <div class="space-y-6">
                    @foreach ($faqsRight as $faq)
                        <details class="group rounded-2xl border border-gray-200 bg-gray-50 shadow hover:shadow-lg transition overflow-hidden">
                            <summary class="flex justify-between items-center font-semibold text-gray-900 cursor-pointer px-6 py-5">
                                <div class="flex items-center gap-3">
                                    {!! $faq['icon'] !!}
                                    <span>{{ $faq['q'] }}</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-open:rotate-180"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="faq-content px-6 pb-6 text-gray-600 text-base leading-relaxed">
                                {!! nl2br(e($faq['a'])) !!}
                            </div>
                        </details>
                    @endforeach
                </div>
    
            </div>
        </div>
    </section>
    
    <!-- Modern CTA Section -->
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
                            <h2 class="text-xl font-bold text-slate-900">Get Instant Support</h2>
                            <p class="mt-1.5 text-sm text-slate-600 leading-relaxed">
                              Reach out to our experts for fast, secure, and personalized answers.
                            </p>
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
                    <input type="hidden" name="FormLocation" value="FAQ Page">

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
                            <textarea id="Message" name="MessageBody" rows="6" required
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