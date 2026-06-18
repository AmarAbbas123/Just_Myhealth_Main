    <nav x-data="{ open: false }" class="fixed top-0 left-0 w-full z-30">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between bg-white/90 backdrop-blur-xl shadow-sm border-b border-slate-200">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('images/bg-6.png') }}" alt="Logo" class="h-12" />
            </a>

            <!-- Hamburger Button (Mobile) -->
            <button type="button" class="lg:hidden text-slate-800 focus:outline-none" @click="open = !open">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-6 text-slate-700 font-medium">               
                <a href="{{ route('faq') }}" class="transition hover:text-slate-900">FAQ</a>
                <a href="{{ route('about') }}" class="transition hover:text-slate-900">About</a>
                <a href="{{ route('regAccountType') }}" class="transition hover:text-slate-900">Register</a>
                <a href="{{ route('login') }}" class="transition hover:text-slate-900">Login</a>

                <!-- Icons -->
                <div class="ml-4 flex items-center gap-3 text-slate-600">
                    <a href="#" class="transition hover:text-slate-900"><i class="fab fa-apple text-xl"></i></a>
                    <a href="#" class="transition hover:text-slate-900"><i class="fab fa-android text-xl"></i></a>
                </div>
            </div>

            <!-- Mobile menu overlay -->
            <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-40 lg:hidden">
                <div class="absolute inset-0 bg-slate-950/70" @click="open = false"></div>
                <div class="absolute inset-x-0 top-0 mt-20 ">
                    <div class="mx-auto w-full max-w-md overflow-hidden  bg-white p-6 shadow-2xl shadow-slate-950/20 ring-1 ring-slate-200">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                            <span class="text-xl font-semibold text-slate-900"></span>
                            <button type="button" @click="open = false" class="text-slate-600 hover:text-slate-900 focus:outline-none">
                                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <nav class="mt-6 space-y-2 text-slate-700">
                            <a href="{{ route('faq') }}" @click="open = false" class="block rounded-xl px-4 py-2 transition hover:bg-slate-100">FAQ</a>
                            <a href="{{ route('about') }}" @click="open = false" class="block rounded-xl px-4 py-2 transition hover:bg-slate-100">About</a>
                            <a href="{{ route('regAccountType') }}" @click="open = false" class="block rounded-xl px-4 py-2 transition hover:bg-slate-100">Register</a>
                            <a href="{{ route('login') }}" @click="open = false" class="block rounded-xl px-4 py-2 transition hover:bg-slate-100">Login</a>
                        </nav>
                        
                    </div>
                </div>
            </div>

        </div>
    </nav>