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
    <section class="relative bg-gradient-to-r from-teal-50 to-blue-50 py-20 overflow-hidden">
        <!-- Decorative Background Circles -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-teal-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 translate-x-1/4 translate-y-1/4"></div>
    
        <div class="max-w-6xl mx-auto px-6 lg:flex lg:items-center lg:justify-between">
            <!-- Text Section -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Still have questions?</h2>
                <p class="text-gray-700 mb-8 text-lg lg:text-xl">
                    Our support team is ready to help you with any questions about JustMy.Health, our services, or your health journey. Don’t wait—get personalized guidance today!
                </p>
               
            </div>
    
            <!-- Modern Right Card -->
            <div class="lg:w-1/2 mt-10 lg:mt-0 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md">
                    <!-- Glassmorphism Card -->
                    <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-3xl shadow-2xl p-8 transform hover:-translate-y-2 hover:scale-105 transition duration-500">
                        <div class="flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0l-4 4m4-4l-4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">Get Instant Support</h3>
                        <p class="text-gray-600 text-center mb-4">
                            Reach out to our experts for fast, secure, and personalized answers.
                        </p>
                        <div class="flex justify-center">
                            <a href="mailto:support@justmy.health"
                               class="inline-block px-6 py-2 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-600 transition transform hover:scale-105">
                               Contact Now
                            </a>
                        </div>
                    </div>
    
                    <!-- Floating Shadow Circle -->
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-teal-200 rounded-full filter blur-2xl opacity-30 animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>
    
    
    </x-app-layout>