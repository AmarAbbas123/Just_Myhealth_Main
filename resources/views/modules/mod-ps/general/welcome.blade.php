<!-- resources/views/home.blade.php -->
<x-app-layout>
    <!-- HERO AREA -->
    <section class="relative min-h-screen flex flex-col justify-end z-0">

        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.png') }}" alt=""
                class="w-full h-full object-cover object-bottom-right">
        </div>

        <!-- Navbar   is in resources/views/layouts/app.blade.php -->

        <!-- Hero Content -->
        <div class="absolute top-32 left-0 z-10 w-full px-3 max-w-4xl text-white">

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
                    <p class="mb-4 text-gray-800 text-lg md:text-xl lg:text-lg xl:text-xl leading-8 md:leading-9 break-words">JustMy.Health is the dynamic online health platform where social media meets health and wellness through education, empowerment, and personalized support.</p>
                    <p class="mb-4 text-gray-800 text-lg md:text-xl lg:text-lg xl:text-xl leading-8 md:leading-9 break-words">JustMy.Health provides consumers with preventive and curative healthcare access, online counselling and therapy services, and tailored dietary programs—giving everyone the tools they need to improve their health, wellness, and longevity.</p>                    
                    <p class="mb-4 text-gray-800 text-lg md:text-xl lg:text-lg xl:text-xl leading-8 md:leading-9 break-words">With global coverage and locally tailored support, JustMy.Health serves both individuals and organizations. Our platform empowers consumers directly while also delivering scalable B2B solutions for employers, clinics, wellness providers, and community partners seeking to elevate health outcomes worldwide.</p>
                </div>
            </div>
            <!-- end of introduction -->


        </div>

    </section>

    {{-- Services  --}}
    <section class="pt-20 pb-14">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="max-w-5xl mx-auto text-center mb-12 lg:mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold tracking-tight mb-6">
                    Therapeutic Practitioners
                </h2>
                <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed text-[#243b45] mb-6 max-w-4xl mx-auto">
                    Therapeutic Practitioners on JustMy.Health provide safe, supportive, and professional guidance to help users improve their mental, emotional, and overall wellbeing.
                </p>
                <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed text-[#243b45] max-w-5xl mx-auto">
                    Each practitioner is fully verified, qualified, and committed to delivering ethical, person-centred care. Whether users need short-term support, structured therapy, or ongoing wellbeing guidance, our practitioners offer trusted, confidential services designed to empower healthier, more resilient lives.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 xl:gap-10">

                <!-- Card 1 -->
                <a href="{{ route('online-counselling') }}" class="group">
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="rounded-[1.75rem] shadow-[0_24px_60px_-28px_rgba(16,106,124,0.45)] text-center relative transform transition duration-300 bg-cover bg-center bg-no-repeat aspect-square overflow-hidden ring-1 ring-[#9ed9d7]/40"
                        style="background-image: url('{{ asset('images/welcome-page/Therapy-Counselling-Tile-Graphic-1.png') }}')"
                        :class="{ 'scale-[1.03] shadow-xl': hover }">
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('personal-training') }}" class="group">
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="rounded-[1.75rem] shadow-[0_24px_60px_-28px_rgba(16,106,124,0.45)] text-center relative transform transition duration-300 bg-cover bg-center bg-no-repeat aspect-square overflow-hidden ring-1 ring-[#9ed9d7]/40"
                        style="background-image: url('{{ asset('images/welcome-page/Personal-Training-Tile-Graphic-1.png') }}')"
                        :class="{ 'scale-[1.03] shadow-xl': hover }">
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('eating-for-health') }}" class="group">
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="rounded-[1.75rem] shadow-[0_24px_60px_-28px_rgba(16,106,124,0.45)] text-center relative transform transition duration-300 bg-cover bg-center bg-no-repeat aspect-square overflow-hidden ring-1 ring-[#9ed9d7]/40"
                        style="background-image: url('{{ asset('images/welcome-page/Dietitian-Healthy-Eating-Tile-Graphic-1.png') }}')"
                        :class="{ 'scale-[1.03] shadow-xl': hover }">
                    </div>
                </a>

            </div>
        </div>
    </section>
    {{-- End of Services --}}

    <section class="pb-24">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto max-w-6xl rounded-[2rem] bg-white px-6 py-10 md:px-10 md:py-12 shadow-[0_32px_90px_-48px_rgba(20,97,109,0.45)] ring-1 ring-[#d7eceb]">
            <div class="max-w-5xl">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-semibold mb-4">The Guided Path:</h2>
                <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed text-[#243b45] mb-8">
                    The Guided Path is a simple, people-centric journey designed to help you take control of your health through connection, collaboration, and shared knowledge. It begins by connecting you with peers, health providers, NGOs, and volunteers who understand your specific condition.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-10">
                <div class="bg-gradient-to-br from-[#0f89a6] to-[#0b7087] rounded-2xl p-4 md:p-5 shadow-[0_18px_40px_-24px_rgba(15,137,166,0.9)]">
                    <img src="{{ asset('images/welcome-page/jmh-guided-path-engage-1.png') }}" alt="Engage" class="w-full h-auto rounded-sm bg-white">
                </div>
                <div class="bg-gradient-to-br from-[#0f89a6] to-[#0b7087] rounded-2xl p-4 md:p-5 shadow-[0_18px_40px_-24px_rgba(15,137,166,0.9)]">
                    <img src="{{ asset('images/welcome-page/jmh-guided-path-empower-1.png') }}" alt="Empower" class="w-full h-auto rounded-sm bg-white">
                </div>
                <div class="bg-gradient-to-br from-[#0f89a6] to-[#0b7087] rounded-2xl p-4 md:p-5 shadow-[0_18px_40px_-24px_rgba(15,137,166,0.9)]">
                    <img src="{{ asset('images/welcome-page/jmh-guided-path-educate-1.png') }}" alt="Educate" class="w-full h-auto rounded-sm bg-white">
                </div>
                <div class="bg-gradient-to-br from-[#0f89a6] to-[#0b7087] rounded-2xl p-4 md:p-5 shadow-[0_18px_40px_-24px_rgba(15,137,166,0.9)]">
                    <img src="{{ asset('images/welcome-page/jmh-guided-path-connect-1.png') }}" alt="Connect" class="w-full h-auto rounded-sm bg-white">
                </div>
            </div>

            <div class="max-w-6xl space-y-6 text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed text-[#243b45]">
                <p>
                    Through active engagement with these trusted networks, you gain access to real guidance and support.
                </p>
                <p>
                    As you learn from their experience, you educate yourself with reliable, lived information - empowering you to improve your wellbeing and give back by sharing what you've learned with the wider community.
                </p>
                <p>
                    Together, these four steps - Connect, Engage, Educate, Empower - form a continuous cycle of growth that strengthens both individual health and collective resilience.
                </p>
            </div>
            </div>
        </div>
    </section>


    <!-- Scripts specific to this page -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/swiper.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


</x-app-layout>