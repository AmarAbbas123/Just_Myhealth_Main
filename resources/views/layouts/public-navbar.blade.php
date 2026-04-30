    <nav class="absolute top-0 left-0 w-full z-20 bg-white">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('images/bg-6.png') }}" alt="Logo" class="h-12" />
            </a>

            <!-- Hamburger Button (Mobile) -->
            <button type="button" class="lg:hidden text-black focus:outline-none" @click="open = !open"
                x-data="{ open: false }" :class="{ 'fixed top-0 right-0 m-4 z-30': open }">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>

                <!-- Mobile Menu -->
                <div x-show="open"
                    class="fixed inset-0 bg-black bg-opacity-70 z-20 flex justify-center items-start pt-24 lg:hidden">
                    <div class="bg-white w-full px-6 text-center ">
                        <ul class="space-y-4 text-black text-lg font-semibold">                           
                            <li><a href="{{ route('faq') }}" @click="open = false">FAQ</a></li>
                            <li><a href="{{ route('about') }}" @click="open = false">About</a></li>
                            <li><a href="{{ route('regAccountType') }}" @click="open = false">Register</a></li>
                            <li><a href="{{ route('login') }}" @click="open = false">Login</a></li>
                        </ul>
                    </div>
                </div>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-6 text-black font-medium">               
                <a href="{{ route('faq') }}" class="hover:text-green-500">FAQ</a>
                <a href="{{ route('about') }}" class="hover:text-green-500">About</a>
                <a href="{{ route('regAccountType') }}" class="hover:text-green-500">Register</a>
                <a href="{{ route('login') }}" class="hover:text-green-500">Login</a>

                <!-- Icons -->
                <div class="ml-4 flex space-x-3">
                    <a href="#"><i class="fab fa-apple text-white hover:text-pink-500 text-xl"></i></a>
                    <a href="#"><i class="fab fa-android text-white hover:text-pink-500 text-xl"></i></a>
                </div>
            </div>

        </div>
    </nav>