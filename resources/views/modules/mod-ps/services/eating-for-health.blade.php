<x-app-layout>

    <!-- Hero Section -->
    <section class="relative h-96 lg:h-[28rem] flex items-start lg:items-center pt-20 lg:pt-24 overflow-hidden">
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
                <span class="text-white font-semibold">Dietitian & Healthy Eating</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
                Dietitian & Healthy Eating <span class="text-teal-400">JustMy.Health</span>
            </h1>

            <!-- Coming Soon Badge -->
            <span class="inline-block bg-yellow-400 text-black font-semibold px-4 py-1 rounded-full shadow-md animate-pulse">
                Coming Soon
            </span>

        </div>
    </section>


    <!-- Coming Soon Section -->
    <section class="relative py-24 bg-gray-50 flex flex-col items-center text-center px-6 overflow-hidden">
        <!-- Illustration -->
         <div class="mb-12">
            <img src="{{ asset('images/welcome-page/coming-soon.png') }}" alt="Coming Soon Illustration" class="w-72 lg:w-96 mx-auto">
        </div>

        <!-- Message -->
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">We're Coming Soon!</h2>
        <p class="text-lg lg:text-xl text-gray-700 mb-8 max-w-2xl">
            Our Dietitian & Healthy Eating services are on the way. Stay tuned for updates and get ready to transform your health and wellness with JustMy.Health.
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