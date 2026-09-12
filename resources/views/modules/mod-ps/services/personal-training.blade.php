<x-app-layout title="Personal Training (PUB) | JustMy.Health" metaDescription="JustMy.Health Personal training Overview Page.">

    <!-- Hero Section -->
    <section class="relative h-96 lg:h-[28rem] flex items-start lg:items-center pt-20 lg:pt-24 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/hero-bg.png') }}"
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
                <span class="text-white font-semibold">Personal Training</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
                Personal Training <span class="text-teal-400">JustMy.Health</span>
            </h1>

            <!-- Coming Soon Badge -->
            <span class="inline-block bg-yellow-400 text-black font-semibold px-4 py-1 rounded-full shadow-md animate-pulse">
                Coming Soon
            </span>

        </div>
    </section>

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Personal Training
                    </p>
                    <h2 class="max-w-xl text-2xl font-semibold leading-tight text-[#102f3a] sm:text-3xl md:text-4xl">
                        Personal Training Designed Around You
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Your fitness journey should feel achievable, motivating, and tailored to your life. Our Personal Training service focuses on building strength, confidence, and long‑term wellbeing through personalised workouts and supportive guidance.
                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Personal Training will be launching shortly as part of our expanded wellbeing support.
                        </p>
                        <p>
                            A Practical, Goal‑Focused Approach: Whether you’re new to exercise, returning after a break, or working toward a specific goal, your trainer creates a plan that fits your abilities, schedule, and lifestyle. Every session is designed to help you progress safely and consistently.
                        </p>
                        <p>
                            Support That Builds Momentum: Your trainer works with you to understand your goals, track your progress, and adjust your plan as your needs evolve. You’ll gain structure, motivation, and the tools to build lasting habits that improve your health and overall wellbeing.
                        </p>
                   </div>
                </div>
            </div>
        </div>
    </section>








    <!-- Coming Soon Section -->
    <section class="relative py-24 bg-gray-50 flex flex-col items-center text-center px-6 overflow-hidden">
        <!-- Message -->
        <h2 class="text-2xl lg:text-2xl font-bold text-gray-900 mb-6">Pre-Register an account!</h2>
        <p class="text-lg lg:text-lg text-gray-700 mb-8 max-w-2xl">
            Our Personal Training services are on the way. Stay tuned for updates and get ready to transform your health and wellness with JustMy.Health.
        </p>

        <!-- Optional Call to Action -->
        <a href="{{ route('register') }}"
           class="inline-block bg-teal-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-teal-600 transition transform hover:-translate-y-1">
            Register Now
        </a>

        <!-- Decorative floating shapes -->
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-teal-200 rounded-full filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute -top-20 -right-20 w-48 h-48 bg-yellow-200 rounded-full filter blur-2xl opacity-30 animate-pulse"></div>
    </section>

</x-app-layout>
