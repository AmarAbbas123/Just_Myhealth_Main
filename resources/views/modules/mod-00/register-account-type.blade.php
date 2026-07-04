<x-app-layout>

    {{-- PAGE WRAPPER (OFFSET FOR FIXED HEADER) --}}
    <main class="pt-20 min-h-screen">

        <!-- Hero Section -->
        <section class="relative flex h-56 items-end sm:h-64 sm:items-center lg:h-80">

            <!-- Background Image -->
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset('images/welcome-page/hero-bg.png') }}"
                     alt="Hero Background"
                     class="h-full w-full object-cover object-center">
                <div class="absolute inset-0 bg-black/55"></div>
            </div>

            <!-- Content -->
            <div class="w-full max-w-4xl px-5 pb-6 sm:px-8 sm:pb-0 lg:px-20">

                <!-- Breadcrumb -->
                <div class="inline-flex max-w-full items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-medium text-white/90 shadow-lg backdrop-blur-md sm:px-5 sm:py-2 sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-teal-400 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                    </svg>
                    <span class="truncate">Home</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="truncate font-semibold text-white">Register</span>
                </div>

                <!-- Page Title -->
                <h1 class="mt-4 text-2xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:mt-6 lg:text-5xl">
                    Register <span class="text-teal-400">JustMy.Health</span>
                </h1>
            </div>
        </section>


        <!-- PAGE HEADING -->
        <section class="px-5 pt-10 sm:pt-14">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFBFA] px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#1C9BA0]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#1C9BA0]"></span>
                    Get started
                </span>
                <h2 class="mt-4 text-2xl font-bold text-slate-900 sm:text-3xl lg:text-4xl">
                    Select your account type
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-500 sm:text-base">
                    Choose the account type that best fits your needs and get started today.
                </p>
            </div>
        </section>

        {{-- MAIN CONTENT --}}
        <section class="px-5 py-10 sm:py-14">
            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-6 md:grid-cols-3 lg:gap-7">

                {{-- CLIENT ACCOUNT --}}
                <div class="group relative flex flex-col overflow-hidden rounded-3xl border border-[#1C9BA0]/15 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#1C9BA0]/10">
                    <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-[#1C9BA0]/5 transition-transform duration-500 group-hover:scale-150"></div>

                    <div class="relative flex flex-1 flex-col p-6">
                        <div class="flex items-start justify-between gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#1C9BA0] to-[#59D4C7] text-white shadow-lg shadow-[#1C9BA0]/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-400">Personal</span>
                        </div>

                        <h3 class="mt-4 text-xl font-semibold text-slate-900">CLIENT Account</h3>
                        

                        <div class="mt-4 flex items-baseline gap-1.5">
                            <span class="text-3xl font-bold text-slate-900">&pound;Free</span>

                        </div>

                        <div class="mt-5 space-y-2 border-t border-slate-100 pt-5 text-sm text-slate-600">
                        <p class=" text-sm leading-6 text-slate-800">The Standard CLIENT account allows access to:</p>   
                        @foreach ([
                                'Social Communications',
                                'Medical Data Feeds',
                                'Medical Practitioners',
                                'Therapy Services',
                                'Peer Support',
                                'Business Services',
                                'eCommerce',
                            ] as $feature)
                                <div class="flex items-center gap-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-[#1C9BA0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('register', ['type' => 'user']) }}"
                            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1C9BA0] px-5 py-3 text-sm font-semibold text-white shadow-md shadow-[#1C9BA0]/25 transition hover:bg-[#18848F]">
                            Create Account
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- THERAPIST ACCOUNT --}}
                <div class="group relative flex flex-col overflow-hidden rounded-3xl border-2 border-[#1C9BA0]/30 bg-white shadow-md shadow-[#1C9BA0]/10 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#1C9BA0]/15">
                    <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-[#1C9BA0]/5 transition-transform duration-500 group-hover:scale-150"></div>

                    <span class="absolute right-5 top-5 rounded-full bg-[#1C9BA0] px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
                        Most Popular
                    </span>

                    <div class="relative flex flex-1 flex-col p-6">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#1C9BA0] to-[#59D4C7] text-white shadow-lg shadow-[#1C9BA0]/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4.5-2.5-8-6-8-10.5A5.5 5.5 0 0112 6a5.5 5.5 0 018 4.5c0 4.5-3.5 8-8 10.5z" />
                            </svg>
                        </span>

                        <h3 class="mt-4 text-xl font-semibold text-slate-900">THERAPIST</h3>
                        <p class="text-sm font-medium text-slate-400">(Professional Services)</p>
                       

                        <div class="mt-4 flex items-baseline gap-1.5">
                            @if ($therapistFeeWaived ?? false)
                                <span class="text-3xl font-bold text-slate-900">&pound;Free</span>
                            @else
                                <span class="text-3xl font-bold text-slate-900">&pound;{{ $therapistFeeAmount }}</span>
                                <span class="text-sm font-medium text-slate-400">/ annual</span>
                            @endif
                        </div>

                        <div class="mt-5 space-y-2 border-t border-slate-100 pt-5 text-sm text-slate-600">
                             <p class=" text-sm leading-6 text-slate-800">The Professional Therapist account allows:</p>
                            @foreach ([
                                'Professional Presence',
                                'Personal BIO',
                                'Availability Calendar',
                                'Booking Engine',
                                'Secure Online Sessions',
                                'Session Recordings',
                            ] as $feature)
                                <div class="flex items-center gap-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-[#1C9BA0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('register', ['type' => 'therapist']) }}"
                            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1C9BA0] px-5 py-3 text-sm font-semibold text-white shadow-md shadow-[#1C9BA0]/25 transition hover:bg-[#18848F]">
                            Create Account
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- BUSINESS ACCOUNT --}}
                <div class="group relative flex flex-col overflow-hidden rounded-3xl border border-[#1C9BA0]/15 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#1C9BA0]/10">
                    <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-[#1C9BA0]/5 transition-transform duration-500 group-hover:scale-150"></div>

                    <div class="relative flex flex-1 flex-col p-6">
                        <div class="flex items-start justify-between gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#1C9BA0] to-[#59D4C7] text-white shadow-lg shadow-[#1C9BA0]/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M13 21V11l6 3v7M9 9v.01M9 12v.01M9 15v.01" />
                                </svg>
                            </span>
                            <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-400">Local trade</span>
                        </div>

                        <h3 class="mt-4 text-xl font-semibold text-slate-900">BUSINESS</h3>
                        <p class="text-sm font-medium text-slate-400">(Local Business Account)</p>
                        

                        <div class="mt-4 flex items-baseline gap-1.5">
                            <span class="text-3xl font-bold text-slate-900">&pound;{{ $feeBusiness->CurrencyGBP }}</span>
                            <span class="text-sm font-medium text-slate-400">/ annual</span>
                        </div>

                        <div class="mt-5 space-y-2 border-t border-slate-100 pt-5 text-sm text-slate-600">
                            <p class=" text-sm  leading-6 text-slate-800">The Local Business account provides access to:</p>
                            @foreach ([
                                'Social Communications',
                                'B2B / B2C / G2B / G2C',
                                'eCommerce Store',
                                'Services Provision',
                                'Peer Support',
                            ] as $feature)
                                <div class="flex items-center gap-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-[#1C9BA0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('register', ['type' => 'business']) }}"
                            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1C9BA0] px-5 py-3 text-sm font-semibold text-white shadow-md shadow-[#1C9BA0]/25 transition hover:bg-[#18848F]">
                            Create Account
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </section>

    </main>

</x-app-layout>