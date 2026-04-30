{{-- resources/views/about.blade.php --}}
<x-app-layout>

    <!-- Hero Section -->
<section class="relative h-72 lg:h-80 flex items-start lg:items-center pt-20 lg:pt-24">
    
    <!-- Background Image -->
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/welcome-page/hero-bg.png') }}"
             alt="Hero Background"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <!-- Content -->
    <div class="px-6 lg:px-20 max-w-4xl">

        <!-- Breadcrumb -->
        <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
            </svg>
            <span>Home</span>
            <span class="text-white/60">›</span>
            <span class="text-white font-semibold">About Us</span>
        </div>

        <!-- Page Title -->
        <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
            About <span class="text-teal-400">JustMy.Health</span>
        </h1>

       

    </div>
</section>


    <!-- Section 1 -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Belief</h2>
                <p class="text-gray-700 leading-relaxed">
                    JustMy.Health is built on a simple belief: everyone deserves clear, accessible, and empowering support to take control of their health and wellbeing. 
                    In a world overflowing with information yet short on guidance, we created a platform that brings clarity, connection, and confidence back to the center of personal health management.
                </p>
            </div>
            <div>
                <img src="{{ asset('images/welcome-page/belief.png') }}" alt="Health" class="rounded-2xl shadow-lg w-full object-cover">
            </div>
        </div>
    </section>

    <!-- Section 2 -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="order-last md:order-first">
                <img src="{{ asset('images/welcome-page/mission.jpeg') }}" alt="Mission" class="rounded-2xl shadow-lg h-80 w-full object-cover">
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                <p class="text-gray-700 leading-relaxed">
                    Our mission is to put our users’ health first—always. JustMy.Health is a comprehensive health and wellbeing information and engagement platform designed to guide individuals toward better choices, stronger habits, and long‑term wellness.
                    At the heart of our approach is the Guided Path, a four-step journey that helps every user move from awareness to action: Connect, Engage, Educate, and Empower.
                </p>
            </div>
        </div>
    </section>

    <!-- Section 3 -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Unique Ecosystem</h2>
                <p class="text-gray-700 leading-relaxed">
                    What makes JustMy.Health truly unique is the ecosystem behind it. We bring together, in one unified platform, a diverse network of users, healthcare providers, government health departments, NGOs, health‑care professionals, and medical support companies. 
                    This collaborative model ensures that every user benefits from credible information, trusted services, and a community of experts dedicated to improving and prolonging health and wellbeing.
                    Whether you’re seeking guidance for yourself, supporting your family or community, or exploring digital health solutions, JustMy.Health provides a powerful, connected, and user-first experience.
                </p>
            </div>
            <div>
                <img src="{{ asset('images/welcome-page/ecosystem.jpeg') }}" alt="Ecosystem" class="rounded-2xl h-80 shadow-lg w-full object-cover">
            </div>
        </div>
    </section>
     <!-- Ecosystem Feature Cards -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">

        <!-- Section Heading -->
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-gray-900 mb-3">
                Health Services Designed Around You
            </h3>
            <p class="text-gray-600 max-w-2xl mx-auto">
                A growing ecosystem of digital health services—built to support every stage of your wellbeing journey.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

            <!-- Card 1 -->
            <div class="group relative bg-gray-50 rounded-2xl p-8 shadow-sm hover:shadow-xl transition duration-300">
                
                <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-teal-100 text-teal-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.341A8 8 0 104.572 15.34" />
                    </svg>
                </div>

                <h4 class="text-xl font-semibold text-gray-900 mb-3">
                    Online Therapy & Counselling
                </h4>

                <p class="text-gray-600 mb-6 leading-relaxed">
                    Confidential, one-to-one therapy and counselling sessions with certified professionals—accessible from anywhere.
                </p>

                <a href="{{ route('online-counselling') }}" class="inline-flex items-center font-medium text-teal-600 hover:text-teal-700">
                    Read More
                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <!-- Hover Line -->
                <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-teal-500 rounded-b-2xl"></span>
            </div>

            <!-- Card 2 -->
<div class="group relative bg-gray-50 rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300">
    
    <span class="absolute top-4 right-4 text-xs font-semibold uppercase tracking-wide bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
        Coming Soon
    </span>

    <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-blue-100 text-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h12M6 16h12M6 8h12" />
        </svg>
    </div>

    <h4 class="text-xl font-semibold text-gray-900 mb-3">
        Personal Training
    </h4>

    <p class="text-gray-600 mb-6 leading-relaxed">
        Individual personal training plans and online sessions tailored for your health and fitness goals.
    </p>

    <a href="{{ route('personal-training') }}" class="inline-flex items-center font-medium text-blue-600 hover:text-blue-700">
        Read More
        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </a>

    <!-- Hover Line -->
    <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-blue-500 rounded-b-2xl"></span>
</div>


           <!-- Card 3 -->
<div class="group relative bg-gray-50 rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300">
    
    <span class="absolute top-4 right-4 text-xs font-semibold uppercase tracking-wide bg-purple-100 text-purple-700 px-3 py-1 rounded-full">
        Coming Soon
    </span>

    <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-purple-100 text-purple-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
        </svg>
    </div>

    <h4 class="text-xl font-semibold text-gray-900 mb-3">
        Dietitian & Healthy Eating
    </h4>

    <p class="text-gray-600 mb-6 leading-relaxed">
        Personalized nutrition plans and online consultations to support your health and wellness goals.
    </p>

    <a href="{{ route('eating-for-health') }}" class="inline-flex items-center font-medium text-purple-600 hover:text-purple-700">
        Read More
        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </a>

    <!-- Hover Line -->
    <span class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-purple-500 rounded-b-2xl"></span>
</div>


        </div>
    </div>
</section>
<!-- Registration CTA Section -->
<section class="py-20 bg-gradient-to-br from-teal-50 via-white to-blue-50">
    <div class="max-w-6xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Left Content -->
            <div>
                <span class="inline-block mb-4 px-4 py-1 text-sm font-semibold text-teal-700 bg-teal-100 rounded-full">
                    Join JustMy.Health
                </span>

                <h2 class="text-4xl font-bold text-gray-900 leading-tight mb-6">
                    Create Your Account &<br>
                    <span class="text-teal-600">Take Control of Your Health</span>
                </h2>

                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    Join a trusted digital health platform designed to support your wellbeing journey.
                    Register today to access personalised services, expert guidance, and upcoming health tools —
                    all in one secure place.
                </p>

                <!-- Benefits -->
                <ul class="space-y-4 mb-10">
                    <li class="flex items-center text-gray-700">
                        <span class="flex items-center justify-center w-6 h-6 mr-3 rounded-full bg-teal-100 text-teal-600">✓</span>
                        Secure and private health platform
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="flex items-center justify-center w-6 h-6 mr-3 rounded-full bg-teal-100 text-teal-600">✓</span>
                        Access expert-led services & resources
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="flex items-center justify-center w-6 h-6 mr-3 rounded-full bg-teal-100 text-teal-600">✓</span>
                        Early access to new features and services
                    </li>
                </ul>

                
            </div>

            <!-- Right CTA Card -->
            <div class="relative">
                <div class="bg-white rounded-3xl shadow-xl p-10 border border-gray-100 text-center">
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Get Started in Minutes
                    </h3>

                    <p class="text-gray-600 mb-8">
                        Registration is quick and simple. Create your account and start exploring JustMy.Health today.
                    </p>

                    <a href="{{ route('register') }}"
                       class="w-full inline-flex items-center justify-center px-8 py-4 text-white font-semibold rounded-xl bg-teal-600 hover:bg-teal-700 transition">
                        Register Now
                    </a>

                    <p class="mt-4 text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-teal-600 hover:underline font-medium">
                            Sign in
                        </a>
                    </p>
                </div>

                <!-- Soft Decorative Background -->
                <div class="absolute -z-10 -top-6 -right-6 w-40 h-40 bg-teal-200 rounded-full blur-3xl opacity-40"></div>
            </div>

        </div>
    </div>
</section>


</x-app-layout>