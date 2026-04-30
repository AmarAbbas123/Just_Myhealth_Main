{{-- resources/views/privacy.blade.php --}}
<x-app-layout>


    <!-- Hero Section -->
    <section class="relative h-72 lg:h-80 flex items-start pt-26 lg:pt-36">
        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
    
        <div class="px-6 lg:px-20 max-w-4xl">
            <!-- Breadcrumb -->
            <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <span>Home</span>
                <span class="text-white/60">›</span>
                <span class="text-white font-semibold">Privacy Policy</span>
            </div>
    
            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
                Privacy Policy <span class="text-teal-400">JustMy.Health</span>
            </h1>
            
        </div>
    </section>
    <!-- Privacy Sections - Simple Text Layout -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
    
            <!-- Section Title -->
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-12 text-center lg:text-left">
                Privacy Policy
            </h2>
    
            @php
                $privacySections = [
                    ['title'=>'Introduction','content'=>'At JustMy.Health, your privacy is a priority. This Privacy Policy explains how we collect, use, protect, and share your personal information when you use our platform, services, and tools.'],
                    ['title'=>'Information We Collect','content'=>'We collect personal information (name, email, contact), health information (goals, therapy sessions, dietary preferences), usage data (IP address, browser, interactions), and third-party data shared via our partners.'],
                    ['title'=>'How We Use Your Information','content'=>'We use your information to deliver personalized services, facilitate online counselling and dietary programs, improve platform experience, communicate updates, support research and comply with legal obligations.'],
                    ['title'=>'Sharing Your Information','content'=>'We may share your data with healthcare providers, NGOs, and technology partners for service delivery and public health initiatives. We do not sell your personal data.'],
                    ['title'=>'Data Security','content'=>'We implement encryption, access controls, and secure storage to protect your information from unauthorized access, alteration, or disclosure.'],
                    ['title'=>'Your Rights','content'=>'You have the right to access, update, or delete your personal data, withdraw consent, or opt out of marketing communications. Contact us at <a href="mailto:privacy@justmy.health" class="text-teal-500 font-medium">privacy@justmy.health</a>.'],
                    ['title'=>'Cookies and Tracking','content'=>'We use cookies to enhance experience, analyze usage, and deliver personalized content. Manage cookie preferences via your browser settings.'],
                    ['title'=>'International Data Transfers','content'=>'Your data may be stored or processed outside your residence. We ensure all transfers comply with applicable data protection laws.'],
                    ['title'=>'Changes to This Policy','content'=>'We may update this Privacy Policy periodically. Changes will be posted on this page with an updated effective date. Continued use signifies acceptance of the revised policy.'],
                    ['title'=>'Contact Us','content'=>'Email: <a href="mailto:privacy@justmy.health" class="text-teal-500 font-medium">privacy@justmy.health</a><br>Address: [Insert Business Address]'],
                ];
            @endphp
    
            <div class="space-y-12">
                @foreach($privacySections as $section)
                    <div>
                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">{{ $section['title'] }}</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">{!! $section['content'] !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    
    
    <!-- CTA Section -->
    <section class="relative bg-gradient-to-r from-teal-50 to-blue-50 py-20 overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 lg:flex lg:items-center lg:justify-between">
            <!-- Text Section -->
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Have Privacy Concerns?</h2>
                <p class="text-gray-700 mb-6 text-lg lg:text-xl">Reach out to our team for assistance on any questions related to your privacy and personal data.</p>
               
            </div>
    
            <!-- Modern Card -->
            <div class="lg:w-1/2 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md">
                    <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-3xl shadow-2xl p-8 transform hover:-translate-y-2 hover:scale-105 transition duration-500">
                        <div class="flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0l-4 4m4-4l-4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">We Value Your Privacy</h3>
                        <p class="text-gray-600 text-center mb-4">
                            Our team is available to answer your questions about your data or this privacy policy.
                        </p>
                        <div class="flex justify-center">
                            <a href="mailto:privacy@justmy.health" class="inline-block px-6 py-2 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-600 transition transform hover:scale-105">
                                Contact Now
                            </a>
                        </div>
                    </div>
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-teal-200 rounded-full filter blur-2xl opacity-30 animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>
    
    </x-app-layout>