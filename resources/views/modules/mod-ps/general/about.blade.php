{{-- resources/views/about.blade.php --}}
<x-app-layout>

    <!-- Hero Section -->
    <section class="relative min-h-[22rem] sm:min-h-[18rem] lg:h-80 flex items-center lg:items-center  pb-8 lg:pt-24 lg:pb-0">
        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.jpeg') }}"
                 alt="Hero Background"
                 class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Content -->
        <div class="px-6 lg:px-20 max-w-4xl">
            <!-- Breadcrumb -->
            <div class="inline-flex items-center space-x-2 text-xs sm:text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-4 sm:px-5 py-1.5 sm:py-2 rounded-full shadow-lg mb-4 sm:mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <a href="{{ route('home') }}" class="hover:text-teal-300 transition-colors">Home</a>
                <span class="text-white/60">›</span>
                <span class="text-white font-semibold">About Us</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl sm:text-3xl lg:text-5xl font-bold text-white tracking-tight leading-tight mb-4">
                About <span class="text-teal-400">JustMy.Health</span>
            </h1>
        </div>
    </section>


    <!-- Section 1: Our Belief -->
    <section class="py-16 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <p class="mb-4 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                    Our Belief
                </p>
                <h2 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl mb-4">Our Belief</h2>
                <p class="text-base leading-8 text-[#4b626b]">
                    JustMy.Health is built on a simple belief: everyone deserves clear, accessible, and empowering support to take control of their health and wellbeing.
                    In a world overflowing with information yet short on guidance, we created a platform that brings clarity, connection, and confidence back to the center of personal health management.
                </p>
            </div>
            <div>
                <img src="{{ asset('images/welcome-page/belief.png') }}" alt="Health" class="rounded-2xl shadow-[0_20px_60px_-20px_rgba(15,137,166,0.25)] w-full object-cover">
            </div>
        </div>
    </section>

    <!-- Section 2: Our Mission -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="order-last md:order-first">
                <img src="{{ asset('images/welcome-page/mission.jpeg') }}" alt="Mission" class="rounded-2xl shadow-[0_20px_60px_-20px_rgba(15,137,166,0.25)] h-80 w-full object-cover">
            </div>
            <div>
                <p class="mb-4 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                    Our Mission
                </p>
                <h2 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl mb-4">Our Mission</h2>
                <p class="text-base leading-8 text-[#4b626b]">
                    Our mission is to put our users' health first—always. JustMy.Health is a comprehensive health and wellbeing information and engagement platform designed to guide individuals toward better choices, stronger habits, and long‑term wellness.
                    At the heart of our approach is the Guided Path, a four-step journey that helps every user move from awareness to action: Connect, Engage, Educate, and Empower.
                </p>
            </div>
        </div>
    </section>

    <!-- Section 3: Our Unique Ecosystem -->
    <section class="py-16 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <p class="mb-4 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                    Our Ecosystem
                </p>
                <h2 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl mb-4">Our Unique Ecosystem</h2>
                <p class="text-base leading-8 text-[#4b626b]">
                    What makes JustMy.Health truly unique is the ecosystem behind it. We bring together, in one unified platform, a diverse network of users, healthcare providers, government health departments, NGOs, health‑care professionals, and medical support companies.
                    This collaborative model ensures that every user benefits from credible information, trusted services, and a community of experts dedicated to improving and prolonging health and wellbeing.
                    Whether you're seeking guidance for yourself, supporting your family or community, or exploring digital health solutions, JustMy.Health provides a powerful, connected, and user-first experience.
                </p>
            </div>
            <div>
                <img src="{{ asset('images/welcome-page/ecosystem.jpeg') }}" alt="Ecosystem" class="rounded-2xl h-80 shadow-[0_20px_60px_-20px_rgba(15,137,166,0.25)] w-full object-cover">
            </div>
        </div>
    </section>

    <!-- Ecosystem Feature Cards -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Section Heading -->
            <div class="text-center mb-12">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6]">
                    What We Offer
                </p>
                <h3 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl mb-3">
                    Health Services Designed Around You
                </h3>
                <p class="text-[#4b626b] max-w-2xl mx-auto text-base leading-7">
                    A growing ecosystem of digital health services—built to support every stage of your wellbeing journey.
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                <!-- Card 1 -->
                <div class="group relative bg-[#f4fbfb] rounded-2xl p-8 border border-[#0f89a6]/10 shadow-sm hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] transition duration-300">

                    <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-[#e0f5ef] text-[#0a6e89]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.341A8 8 0 104.572 15.34" />
                        </svg>
                    </div>

                    <h4 class="text-xl font-semibold text-[#102f3a] mb-3">
                        Online Therapy &amp; Counselling
                    </h4>

                    <p class="text-[#4b626b] mb-6 leading-relaxed">
                        Confidential, one-to-one therapy and counselling sessions with certified professionals—accessible from anywhere.
                    </p>

                    <a href="{{ route('online-counselling') }}" class="inline-flex items-center font-medium text-[#0f89a6] hover:text-[#0b7087]">
                        Read More
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- Hover Line -->
                    <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-[#0f89a6] rounded-b-2xl"></span>
                </div>

                <!-- Card 2 -->
                <div class="group relative bg-[#f4fbfb] rounded-2xl p-8 border border-[#0f89a6]/10 shadow-sm hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] transition duration-300">

                    <span class="absolute top-4 right-4 text-[10.5px] font-semibold uppercase tracking-widest bg-[#dff4ef] text-[#0a6e89] px-3 py-0.5 rounded-full">
                        Coming Soon
                    </span>

                    <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-[#e0f5ef] text-[#0a6e89]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h12M6 16h12M6 8h12" />
                        </svg>
                    </div>

                    <h4 class="text-xl font-semibold text-[#102f3a] mb-3">
                        Personal Training
                    </h4>

                    <p class="text-[#4b626b] mb-6 leading-relaxed">
                        Individual personal training plans and online sessions tailored for your health and fitness goals.
                    </p>

                    <a href="{{ route('personal-training') }}" class="inline-flex items-center font-medium text-[#0f89a6] hover:text-[#0b7087]">
                        Read More
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- Hover Line -->
                    <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-[#0f89a6] rounded-b-2xl"></span>
                </div>

                <!-- Card 3 -->
                <div class="group relative bg-[#f4fbfb] rounded-2xl p-8 border border-[#0f89a6]/10 shadow-sm hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] transition duration-300">

                    <span class="absolute top-4 right-4 text-[10.5px] font-semibold uppercase tracking-widest bg-[#dff4ef] text-[#0a6e89] px-3 py-0.5 rounded-full">
                        Coming Soon
                    </span>

                    <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-[#e0f5ef] text-[#0a6e89]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                        </svg>
                    </div>

                    <h4 class="text-xl font-semibold text-[#102f3a] mb-3">
                        Dietitian &amp; Healthy Eating
                    </h4>

                    <p class="text-[#4b626b] mb-6 leading-relaxed">
                        Personalised nutrition plans and online consultations to support your health and wellness goals.
                    </p>

                    <a href="{{ route('eating-for-health') }}" class="inline-flex items-center font-medium text-[#0f89a6] hover:text-[#0b7087]">
                        Read More
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- Hover Line -->
                    <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-[#0f89a6] rounded-b-2xl"></span>
                </div>

            </div>
        </div>
    </section>

    <!-- Registration CTA Section -->
    <section class="py-16 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
        <div class="max-w-6xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- Left Content -->
                <div>
                    <p class="mb-4 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        Join JustMy.Health
                    </p>

                    <h2 class="text-3xl sm:text-4xl font-semibold leading-tight text-[#102f3a] mb-6">
                        Create Your Account &amp;<br>
                        <span class="text-[#0f89a6]">Take Control of Your Health</span>
                    </h2>

                    <p class="text-[#4b626b] text-base leading-8 mb-8">
                        Join a trusted digital health platform designed to support your wellbeing journey.
                        Register today to access personalised services, expert guidance, and upcoming health tools —
                        all in one secure place.
                    </p>

                    <!-- Benefits -->
                    <ul class="space-y-4">
                        <li class="flex items-center text-[#243b45]">
                            <span class="flex items-center justify-center w-6 h-6 mr-3 rounded-full bg-[#e0f5ef] text-[#0a6e89] flex-shrink-0">✓</span>
                            Secure and private health platform
                        </li>
                        <li class="flex items-center text-[#243b45]">
                            <span class="flex items-center justify-center w-6 h-6 mr-3 rounded-full bg-[#e0f5ef] text-[#0a6e89] flex-shrink-0">✓</span>
                            Access expert-led services &amp; resources
                        </li>
                        <li class="flex items-center text-[#243b45]">
                            <span class="flex items-center justify-center w-6 h-6 mr-3 rounded-full bg-[#e0f5ef] text-[#0a6e89] flex-shrink-0">✓</span>
                            Early access to new features and services
                        </li>
                    </ul>
                </div>

                <!-- Right CTA Card -->
                <div class="relative">
                    <div class="bg-white rounded-3xl shadow-[0_24px_70px_-30px_rgba(15,137,166,0.35)] p-10 border border-[#0f89a6]/10 text-center">

                        <h3 class="text-2xl font-semibold text-[#102f3a] mb-4">
                            Get Started in Minutes
                        </h3>

                        <p class="text-[#4b626b] mb-8">
                            Registration is quick and simple. Create your account and start exploring JustMy.Health today.
                        </p>

                       <a href="{{ route('register') }}"
   class="w-full inline-flex items-center justify-center px-8 py-4 text-white font-semibold rounded-xl bg-[#1C9BA0] hover:bg-[#18848F] transition">
    Register Now
</a>

                        <p class="mt-4 text-sm text-[#4b626b]">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-[#0f89a6] hover:underline font-medium">
                                Sign in
                            </a>
                        </p>
                    </div>

                    <!-- Soft Decorative Background -->
                    <div class="absolute -z-10 -top-6 -right-6 w-40 h-40 bg-[#9ed9d7] rounded-full blur-3xl opacity-40"></div>
                </div>

            </div>
        </div>
    </section>

    {{-- Core Values --}}
    <section class="bg-white py-16 md:py-24">
        <div class="container mx-auto px-4 md:px-6 lg:px-12">
            <div class="text-center mb-12">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6]">
                    What Guides Us
                </p>
                <h2 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl">Our Core Values</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8">
                @foreach ([
    ['title' => 'RESPECT', 'desc' => 'We have great admiration for the effort that you have made in seeking help, valuing your worth, feelings and  boundaries'],
    ['title' => 'COMMITMENT', 'desc' => 'We are dedicated to work professionally, skillfully and to communicate effectively.'],
    ['title' => 'DIVERSITY', 'desc' => 'We value your differences, of background, sexuality, age, religion, gender ethnicity, physical ability and your experiences'],
    ['title' => 'CLIENT FOCUS', 'desc' => 'Putting the client at the centre of the therapy, being present, understanding and focussing on the presenting needs'],
    ['title' => 'INTEGRITY', 'desc' => 'At justmy.health,  integrity is a part of our traits, by being honest, trustworthy and having a strong unwavering moral, and ethical principles, by doing the right thing, even when it is difficult, regardless of external pressure or a potential personal gain. It is putting the client at the centre with professional conduct'],
    ['title' => 'CONFIDENTIALITY', 'desc' => 'We at justmy.health consider confidentiality as one of the most fundamental and ethical legal obligation to protect private and sensitive information from unauthorised disclosure, ensuring that all information is kept secret and secure, such as maintaining the privacy of your identity. This is the core of building trust in professional relationships. Violation of privacy will lead to disciplinary action'],
    ['title' => 'ACCOUNTABILITY', 'desc' => 'We are obligated to accept and demonstrate responsibility, such is a core principle in data protection, and organisation governance. Complying with regulation of the governing body  ethical framework, policies, record keeping, with internal regulations'],
    ['title' => 'INCLUSIVITY', 'desc' => 'All individuals are unique , and therefore, regardless of your background, sexual differences, age, religion and identity. You are welcome atjustmyhealth, valued and respected, ensuring that equal understanding and a sense of belonging for everyone.'],
] as $card)
                    <div class="group relative bg-[#f4fbfb] rounded-2xl p-6 border border-[#0f89a6]/10 shadow-sm hover:-translate-y-1 hover:shadow-[0_20px_50px_-20px_rgba(15,137,166,0.3)] transition duration-300">
                        <span class="inline-block text-[10.5px] font-semibold tracking-widest uppercase text-[#0a6e89] bg-[#dff4ef] rounded-full px-3 py-0.5 mb-3">
                            {{ $card['title'] }}
                        </span>
                        <p class="text-[#4b626b] text-sm leading-relaxed">{{ $card['desc'] }}</p>
                        <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-[#0f89a6] rounded-b-2xl"></span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Privacy & Security Features --}}
    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-16 md:py-24">
        <div class="container mx-auto px-4 md:px-6 lg:px-12">
            <div class="text-center mb-12">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6]">
                    Trust &amp; Safety
                </p>
                <h2 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl">
                    Built With Your Privacy in Mind
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 xl:gap-8">
                @foreach ([
    ['icon' => 'authentication', 'title' => 'Secure User Authentication', 'desc' => 'Implement multi-factor authentication to protect user accounts.'],
    ['icon' => 'anonymous', 'title' => 'Anonymous Profiles', 'desc' => 'Offer the option for clients to use anonymous profiles if they prefer.'],
    ['icon' => 'message', 'title' => 'Confidential Messaging', 'desc' => 'Use encrypted messaging systems for secure communication between therapists and clients.'],
    ['icon' => 'security', 'title' => 'Regular Security Audits', 'desc' => 'Conduct regular security audits and vulnerability assessments.'],
    ['icon' => 'compliance', 'title' => 'Compliance with Regulations', 'desc' => 'Adhere to HIPAA or GDPR standards for data protection and privacy.'],
    ['icon' => 'policies', 'title' => 'Transparent Policies', 'desc' => 'Make privacy policies and terms of service easily accessible and clear.'],
    ['icon' => 'schedule', 'title' => 'Private Scheduling', 'desc' => 'Integrate secure calendar systems for booking and managing appointments.'],
    ['icon' => 'waiting-room', 'title' => 'Virtual Waiting Rooms', 'desc' => 'Use virtual waiting rooms to maintain session confidentiality.'],
    ['icon' => 'document', 'title' => 'Secure Document Sharing', 'desc' => 'Allow for the safe exchange of therapy notes and resources.'],
    ['icon' => 'verification', 'title' => 'Therapist Verification', 'desc' => 'Verify the credentials of therapists to ensure they are qualified professionals.'],
] as $card)
                    <div class="flex items-start space-x-4 bg-white rounded-2xl border border-[#0f89a6]/10 shadow-sm p-6 hover:-translate-y-1 hover:shadow-[0_20px_50px_-20px_rgba(15,137,166,0.3)] transition duration-300">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#e0f5ef] flex-shrink-0">
                            <img src="{{ asset('images/icons/' . $card['icon'] . '.png') }}" alt="{{ $card['title'] }}"
                                 class="w-6 h-6">
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-[#102f3a]">{{ $card['title'] }}</h3>
                            <p class="text-[#4b626b] mt-1.5 text-sm leading-relaxed">{{ $card['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</x-app-layout>