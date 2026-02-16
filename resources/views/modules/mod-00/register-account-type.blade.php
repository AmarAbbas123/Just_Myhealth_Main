<x-app-layout>

    {{-- PAGE WRAPPER (OFFSET FOR FIXED HEADER) --}}
    <main class="pt-20 min-h-screen ">

        <!-- Hero Section -->
<section class="relative h-72 lg:h-80 flex items-start lg:items-center ">
    
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
            <span class="text-white font-semibold">Register</span>
        </div>

        <!-- Page Title -->
        <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
            Register <span class="text-teal-400">JustMy.Health</span>
        </h1>

       

    </div>
</section>


        <!-- PAGE HEADING -->
        <section class="py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                Select Account Type
            </h1>
            <p class="mt-3 text-gray-500 max-w-2xl mx-auto">
                Choose the account type that best fits your needs and get started today.
            </p>
        </section>

        {{-- MAIN CONTENT --}}
        <section class="py-16 px-6">
            <div class="max-w-7xl mx-auto">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- USER ACCOUNT --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-2xl transition">
                        <h2 class="text-xl font-semibold text-gray-800">USER Account</h2>
                        <p class="text-4xl font-bold text-indigo-600 mt-4">£<span class="text-3xl">FREE</span></p>
                        <p class="mt-2 text-gray-500">The Standard User account allows access to:</p>
                        <ul class="mt-4 space-y-2 text-gray-700 text-left list-inside">
                            <li>✔ Social Communications</li>
                            <li>✔ Medical Data Feeds</li>
                            <li>✔ Medical Practitioners</li>
                            <li>✔ Therapy Services</li>
                            <li>✔ Peer Support</li>
                            <li>✔ Business Services</li>
                            <li>✔ eCommerce</li>
                        </ul>
                        <a href="{{ route('register', ['type' => 'user']) }}"
                           class="mt-6 bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                            Create Account
                        </a>
                    </div>

                    {{-- THERAPIST ACCOUNT --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-2xl transition border-t-4 border-indigo-600">
                        <h2 class="text-xl font-semibold text-gray-800">THERAPIST</h2>
                        <p class="text-sm text-gray-500">(Professional Services)</p>
                        <p class="text-4xl font-bold text-indigo-600 mt-4">
                            £{{ $feeTherapist->CurrencyGBP }}
                            <span class="text-base text-gray-500">/ annual</span>
                        </p>
                        <p class="mt-2 text-gray-500">The Professional Therapist account allows:</p>
                        <ul class="mt-4 space-y-2 text-gray-700 text-left list-inside">
                            <li>✔ Professional Presence</li>
                            <li>✔ Personal BIO</li>
                            <li>✔ Availability Calendar</li>
                            <li>✔ Booking Engine</li>
                            <li>✔ Secure Online Sessions</li>
                            <li>✔ Session Recordings</li>
                        </ul>
                        <a href="{{ route('register', ['type' => 'therapist']) }}"
                           class="mt-6 bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                            Create Account
                        </a>
                    </div>

                    {{-- BUSINESS ACCOUNT --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-2xl transition">
                        <h2 class="text-xl font-semibold text-gray-800">BUSINESS</h2>
                        <p class="text-sm text-gray-500">(Local Business Account)</p>
                        <p class="text-4xl font-bold text-indigo-600 mt-4">
                            £{{ $feeBusiness->CurrencyGBP }}
                            <span class="text-base text-gray-500">/ annual</span>
                        </p>
                        <p class="mt-2 text-gray-500">The Local Business account provides access to:</p>
                        <ul class="mt-4 space-y-2 text-gray-700 text-left list-inside">
                            <li>✔ Social Communications</li>
                            <li>✔ B2B / B2C / G2B / G2C</li>
                            <li>✔ eCommerce Store</li>
                            <li>✔ Services Provision</li>
                            <li>✔ Peer Support</li>
                        </ul>
                        <a href="{{ route('register', ['type' => 'business']) }}"
                           class="mt-6 bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                            Create Account
                        </a>
                    </div>

                </div>
            </div>
        </section>

    </main>

</x-app-layout>