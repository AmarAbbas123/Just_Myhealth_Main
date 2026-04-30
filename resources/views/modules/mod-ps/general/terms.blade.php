{{-- resources/views/terms.blade.php --}}
<x-app-layout>

    <!-- Hero Section -->
    <section class="relative h-80 flex items-start lg:items-center pt-24 lg:pt-32">
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>
        </div>
    
        <div class="px-6 lg:px-20 max-w-4xl">
            <!-- Breadcrumb -->
            <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <span>Home</span>
                <span class="text-white/60">›</span>
                <span class="text-white font-semibold">Terms & Conditions</span>
            </div>
    
            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
                Terms & Conditions <span class="text-teal-400">JustMy.Health</span>
            </h1>
            
        </div>
    </section>
    
    <!-- Terms Content Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
    
            <!-- Section Title -->
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-10 text-center lg:text-left">
                Terms & Conditions
            </h2>
    
            <!-- Intro Paragraph -->
            <div class="mb-12 text-gray-700 text-lg lg:text-xl leading-relaxed">
                Effective Date: [Insert Date] <br>
                Welcome to JustMy.Health. By accessing or using our platform, services, or content, you agree to be bound by the following Terms and Conditions. Please read them carefully.
            </div>
    
            <!-- Terms Sections -->
            @php
                $terms = [
                    [
                        'title' => 'Overview',
                        'icon' => '📖',
                        'content' => 'JustMy.Health is a health and wellbeing information and engagement platform designed to support users through a structured “Guided Path”: Connect, Engage, Educate, and Empower. Our services include access to health-related content, online counselling, therapy, dietary programs, and tools for preventive and curative care.'
                    ],
                    [
                        'title' => 'Eligibility',
                        'icon' => '✅',
                        'content' => 'You must be at least 18 years old or have the consent of a legal guardian to use our services. By using the platform, you confirm that you meet these requirements.'
                    ],
                    [
                        'title' => 'User Responsibilities',
                        'icon' => '🛡️',
                        'content' => 'You agree to use JustMy.Health for lawful purposes only. You are responsible for maintaining the confidentiality of your account credentials. You agree not to misuse, copy, or distribute any content or services without permission.'
                    ],
                    [
                        'title' => 'Health Disclaimer',
                        'icon' => '⚕️',
                        'content' => 'JustMy.Health provides general health and wellness information and access to licensed professionals. However, the platform does not replace personalized medical advice, diagnosis, or treatment from your healthcare provider. Always consult a qualified professional before making health decisions.'
                    ],
                    [
                        'title' => 'Data Privacy',
                        'icon' => '🔒',
                        'content' => 'We are committed to protecting your privacy. All personal data is handled in accordance with our Privacy Policy. By using our services, you consent to the collection and use of your data as described.'
                    ],
                    [
                        'title' => 'Third-Party Services',
                        'icon' => '🤝',
                        'content' => 'Our platform may connect you with third-party providers, including healthcare professionals, NGOs, and support companies. JustMy.Health is not responsible for the accuracy, reliability, or conduct of these third parties.'
                    ],
                    [
                        'title' => 'Intellectual Property',
                        'icon' => '💡',
                        'content' => 'All content, branding, and technology on JustMy.Health are the intellectual property of JustMy.Health or its partners. You may not reproduce, modify, or distribute any part of the platform without prior written consent.'
                    ],
                    [
                        'title' => 'B2C and B2B Engagement',
                        'icon' => '🏢',
                        'content' => 'JustMy.Health serves both individual users and organizational clients. Businesses using our platform must ensure their employees or members comply with these Terms. Custom agreements may apply for enterprise services.'
                    ],
                    [
                        'title' => 'Termination',
                        'icon' => '⛔',
                        'content' => 'We reserve the right to suspend or terminate access to our platform for any user who violates these Terms or engages in harmful behavior.'
                    ],
                    [
                        'title' => 'Changes to Terms',
                        'icon' => '✏️',
                        'content' => 'We may update these Terms from time to time. Continued use of the platform after changes are posted constitutes acceptance of the revised Terms.'
                    ],
                    [
                        'title' => 'Contact Us',
                        'icon' => '📬',
                        'content' => 'Email: <a href="mailto:support@justmy.health" class="text-teal-500 font-medium">support@justmy.health</a><br>Address: [Insert Business Address]'
                    ],
                ];
            @endphp
    
            <div class="grid gap-8">
                @foreach ($terms as $term)
                    <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="text-3xl mr-4">{{ $term['icon'] }}</div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $term['title'] }}</h3>
                        </div>
                        <p class="text-gray-700 text-lg leading-relaxed">{!! $term['content'] !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Optional CTA Section -->
    <section class="bg-gradient-to-r from-teal-50 to-blue-50 py-20 overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 lg:flex lg:items-center lg:justify-between">
            <!-- Text Section -->
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Have Questions About Terms?</h2>
                <p class="text-gray-700 mb-6 text-lg lg:text-xl">Reach out to our support team for clarity on any of our Terms & Conditions. We are here to help.</p>
                
            </div>
    
            <!-- Right-side Modern Card -->
            <div class="lg:w-1/2 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md">
                    <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-3xl shadow-2xl p-8 transform hover:-translate-y-2 hover:scale-105 transition duration-500">
                        <div class="flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0l-4 4m4-4l-4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">Get Support Anytime</h3>
                        <p class="text-gray-600 text-center mb-4">
                            Our experts are available to answer your questions about your account or terms.
                        </p>
                        <div class="flex justify-center">
                            <a href="mailto:support@justmy.health" class="inline-block px-6 py-2 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-600 transition transform hover:scale-105">
                                Contact Now
                            </a>
                        </div>
                    </div>
    
                    <!-- Floating Decorative Circle -->
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-teal-200 rounded-full filter blur-2xl opacity-30 animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>
    
    </x-app-layout>