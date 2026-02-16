<!-- resources/views/home.blade.php -->
<x-app-layout>

    <!-- HERO AREA -->
    <section class="relative min-h-screen z-0 overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.png') }}" alt=""
                class="w-full h-full object-cover object-bottom-right">
        </div>

        <!-- Navbar   is in resources/views/layouts/app.blade.php -->

        <!-- Hero Content -->
        <div class="relative z-10 w-full px-3 max-w-4xl text-white pt-32 pb-12">

            <!-- Intro -->
            <div class="text-center">
                <div class="container px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20">
                    <h3
                        class="mb-6 text-gray-800 
                               text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl 
                               leading-snug sm:leading-snug md:leading-tight lg:leading-tight xl:leading-tight
                               tracking-normal sm:tracking-wide md:tracking-wider
                               font-bold mx-auto max-w-4xl">
                        <span class="whitespace-nowrap">WHERE SOCIAL MEDIA MEETS</span><br>
                        <span class="whitespace-nowrap">HEALTH AND WELLNESS</span>
                    </h3>
                </div>
            </div>

            <!-- Introduction -->
            <div class="pb-14 text-justify">
                <div class="container px-4 sm:px-8 xl:px-4">
                    <div class="mx-auto max-w-5xl">
                        <p class="mb-4 text-gray-800 text-lg md:text-xl lg:text-xl xl:text-2xl leading-8 md:leading-9 break-words">JustMy.Health is the dynamic online health platform where social media meets health and wellness through education, empowerment, and personalized support.</p>
                        <p class="mb-4 text-gray-800 text-lg md:text-xl lg:text-xl xl:text-2xl leading-8 md:leading-9 break-words">JustMy.Health provides consumers with preventive and curative healthcare access, online counselling and therapy services, and tailored dietary programs—giving everyone the tools they need to improve their health, wellness, and longevity.</p>
                        <p class="mb-4 text-gray-800 text-lg md:text-xl lg:text-xl xl:text-2xl leading-8 md:leading-9 break-words">With global coverage and locally tailored support, JustMy.Health serves both individuals and organizations. Our platform empowers consumers directly while also delivering scalable B2B solutions for employers, clinics, wellness providers, and community partners seeking to elevate health outcomes worldwide.</p>
                    </div>
                </div>
            </div>
            <!-- end of introduction -->


        </div>

    </section>

    
    {{-- Services  --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <a href="{{ route('online-counselling') }}">
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="rounded-2xl shadow-md text-center relative transform transition duration-300 bg-cover bg-center bg-no-repeat aspect-square"
                        style="background-image: url('{{ asset('images/welcome-page/Therapy-Counselling-Tile-Graphic-1.png') }}')"
                        :class="{ 'scale-105 shadow-xl': hover }">
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('personal-training') }}">
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="rounded-2xl shadow-md text-center relative transform transition duration-300 bg-cover bg-center bg-no-repeat aspect-square"
                        style="background-image: url('{{ asset('images/welcome-page/Personal-Training-Tile-Graphic-1.png') }}')"
                        :class="{ 'scale-105 shadow-xl': hover }">
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('eating-for-health') }}">
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="rounded-2xl shadow-md text-center relative transform transition duration-300 bg-cover bg-center bg-no-repeat aspect-square"
                        style="background-image: url('{{ asset('images/welcome-page/Dietitian-Healthy-Eating-Tile-Graphic-1.png') }}')"
                        :class="{ 'scale-105 shadow-xl': hover }">
                    </div>
                </a>

            </div>
        </div>
    </section>
    {{-- End of Services --}}


    <!-- Scripts specific to this page -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/swiper.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


</x-app-layout>
