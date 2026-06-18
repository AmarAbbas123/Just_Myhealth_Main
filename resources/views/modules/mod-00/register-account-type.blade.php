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
            <span class="text-white/60">â€º</span>
            <span class="text-white font-semibold">Register</span>
        </div>

        <!-- Page Title -->
        <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
            Register <span class="text-teal-400">JustMy.Health</span>
        </h1>
      

    </div>
</section>


        <!-- PAGE HEADING -->
        <section class="py-12">
            <div class="mx-auto max-w-3xl rounded-3xl border border-indigo-200 bg-indigo-50/80 px-8 py-10 text-center shadow-xl shadow-indigo-100">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                    Select Account Type
                </h1>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Choose the account type that best fits your needs and get started today.
                </p>
            </div>
        </section>

        {{-- MAIN CONTENT --}}
        <section class="py-16 px-6">
            <div class="max-w-7xl mx-auto">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- CLIENT ACCOUNT --}}
                    <div class="group relative overflow-hidden rounded-3xl border border-indigo-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-col gap-3">
                                <div class="inline-flex items-center justify-between gap-3">
                                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-700">Client</span>
                                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Personal</span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-semibold text-slate-900">CLIENT Account</h3>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">The Standard CLIENT account allows access to:</p>
                                </div>
                                <div class="mt-5 rounded-3xl bg-indigo-50 px-5 py-4 ring-1 ring-indigo-100">
                                    <div class="text-sm text-indigo-700">Pricing</div>
                                    <div class="mt-2 text-4xl font-bold text-slate-900">£Free</div>
                                </div>
                            </div>

                            <div class="mt-7 space-y-3 text-sm text-slate-700">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Social Communications</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Medical Data Feeds</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Medical Practitioners</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Therapy Services</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Peer Support</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Business Services</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>eCommerce</span>
                                </div>
                            </div>

                            <a href="{{ route('register', ['type' => 'user']) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition duration-300 hover:bg-indigo-700">Create Account</a>
                        </div>
                    </div>

                    {{-- THERAPIST ACCOUNT --}}
                    <div class="group relative overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-col gap-3">
                                <div class="inline-flex items-center justify-between gap-3">
                                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-700">Therapist</span>
                                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Professional</span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-semibold text-slate-900">THERAPIST Account</h3>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">The Professional Therapist account allows:</p>
                                </div>
                                <div class="mt-5 rounded-3xl bg-indigo-50 px-5 py-4 ring-1 ring-indigo-100 text-slate-900">
                                    <div class="text-sm text-indigo-700">Annual fee</div>
                                    <div class="mt-2 text-4xl font-bold">
                                        @if ($therapistFeeWaived ?? false)
                                            £Free
                                        @else
                                            &pound;{{ $therapistFeeAmount }}<span class="text-base font-medium text-slate-500">/ annual</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-7 space-y-3 text-sm text-slate-700">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Professional Presence</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Personal BIO</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Availability Calendar</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Booking Engine</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Secure Online Sessions</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Session Recordings</span>
                                </div>
                            </div>

                            <a href="{{ route('register', ['type' => 'therapist']) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition duration-300 hover:bg-indigo-700">Create Account</a>
                        </div>
                    </div>

                    {{-- BUSINESS ACCOUNT --}}
                    <div class="group relative overflow-hidden rounded-3xl border border-indigo-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-col gap-3">
                                <div class="inline-flex items-center justify-between gap-3">
                                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-700">Business</span>
                                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Local Trade</span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-semibold text-slate-900">BUSINESS Account</h3>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">The Local Business account provides access to:</p>
                                </div>
                                <div class="mt-5 rounded-3xl bg-indigo-50 px-5 py-4 ring-1 ring-indigo-100">
                                    <div class="text-sm text-indigo-700">Annual fee</div>
                                    <div class="mt-2 text-4xl font-bold text-slate-900">&pound;{{ $feeBusiness->CurrencyGBP }}<span class="text-base font-medium text-slate-500">/ annual</span></div>
                                </div>
                            </div>

                            <div class="mt-7 space-y-3 text-sm text-slate-700">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Social Communications</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>B2B / B2C / G2B / G2C</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>eCommerce Store</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Services Provision</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">✓</span>
                                    <span>Peer Support</span>
                                </div>
                            </div>
                            <a href="{{ route('register', ['type' => 'business']) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition duration-300 hover:bg-indigo-700">Create Account</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

</x-app-layout>



