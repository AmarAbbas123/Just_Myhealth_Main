<!-- resources/views/home.blade.php -->
<x-app-layout>
    <!-- HERO AREA -->
    <section class="relative w-full min-h-[560px] sm:min-h-[620px] md:h-[80vh] flex items-center pt-24 pb-10 md:pt-20 md:pb-0 overflow-hidden">
    <img src="{{ asset('images/welcome-page/hero-bg.jpg') }}"
         alt="A therapist and client connecting during an online video session"
         class="absolute inset-0 w-full h-full object-cover object-center">

    <!-- Readability gradient across the whole photo -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#0b2a33]/85 via-[#0b2a33]/55 to-[#0b2a33]/20"></div>

    <!-- Hero Content -->
    <div class="relative z-10 w-full px-6">
        <div class="mx-auto w-full max-w-6xl">
            <div class="max-w-xl rounded-3xl bg-[#0b2a33]/55 p-6 backdrop-blur-md sm:p-8 md:bg-transparent md:p-0 md:backdrop-blur-none text-white">
                <p class="mb-4 inline-flex rounded-full border border-white/30 bg-white/10 text-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] backdrop-blur-sm">
                    JustMy.Health
                </p>
                <h1 class="text-2xl font-semibold leading-tight text-white/90  sm:text-3xl md:text-4xl lg:text-5xl">
                    Your online home for personalised emotional and mental health
                </h1>
                <p class="mt-4 text-sm leading-6 text-white/90 sm:text-base md:mt-6 md:text-lg md:leading-7">
                    Connect with trusted therapists, counsellors, and coaches for professional, client‑centred support — wherever you are.
                </p>

                <div class="mt-6 flex flex-wrap gap-3 md:mt-8 md:gap-4">
                    <a href="{{ route('regAccountType') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-[#0b7087] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#0f89a6] md:px-6 md:py-3">
                        Get started
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#services"
                       class="inline-flex items-center gap-2 rounded-full border border-white/40 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition duration-200 hover:bg-white/20 md:px-6 md:py-3">
                        Explore our services
                    </a>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-medium text-white/90 sm:text-sm md:mt-8 md:gap-x-6">
                    <span class="inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Therapy
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Counselling
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Coaching
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-16 md:py-24">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health
                    </p>
                    <h2 class="max-w-xl text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                        Your safe space for trusted health and wellbeing support
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Professional counselling, therapy, and wellbeing services delivered through a connected, client‑centred platform.
                    </p>
                 </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-xl">
                        <p class="font-medium text-[#102f3a]">
                            JustMy.Health is a professional online health and wellbeing platform providing trusted mental health, therapeutic, and lifestyle support through evidence‑based guidance and personalised care.
                        </p>
                        <p>
                            We offer clients access to counselling, therapy, coaching, dietary and nutrition programs, preventive and curative health information, and structured wellbeing pathways—giving every individual the tools they need to improve their mental, emotional, and physical health.
                        </p>
                        <p>
                            With global coverage and locally tailored support, JustMy.Health serves both individuals and organisations. Our platform empowers clients directly while also delivering scalable B2B solutions for employers, clinics, wellness providers, and community partners seeking to elevate health outcomes worldwide.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}

    {{-- Service-type assessment CTA --}}
    <section class="py-10 md:py-14 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto max-w-4xl rounded-2xl border border-[#9ed9d7] bg-gradient-to-b from-[#f4fbfb] to-white px-6 py-8 md:px-10 md:py-10 text-center shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)]">
                <h3 class="text-2xl font-semibold text-[#102f3a] sm:text-3xl">
                    Unsure of what help you need
                </h3>
                <p class="mx-auto mt-3 max-w-2xl text-base leading-7 text-[#4b626b]">
                    Answer a few questions and we will guide you to the required service
                </p>
                <div class="mt-6">
                <a 
                   class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#14b8a6] px-6 py-4 text-base font-semibold text-white shadow-md transition duration-200 hover:bg-[#0b7f70] hover:shadow-lg sm:w-auto sm:min-w-[280px]">
                    Start assessment
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                </div>
            </div>
        </div>
    </section>


    {{-- Professional Support Service Tiles --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6 lg:px-16 xl:px-24" id="services">

            <div class="mx-auto max-w-3xl text-center mb-12">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6]">
                    Professional Support
                </p>
                <h3 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                    Counselling, Therapy & Coaching
                </h3>
                <p class="mx-auto mt-4 max-w-xl text-base leading-8 text-[#4b626b]">
                    Choose the support that fits your needs—from everyday wellbeing to structured therapy and goal-focused coaching.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 xl:gap-8">

                {{-- Online Counseling Card --}}
                <a href="{{ route('online-counselling') }}"
                   class="group bg-white rounded-[18px] overflow-hidden border border-[#0f89a6]/10 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] flex flex-col h-full">
                    <div class="w-full aspect-[2/1] overflow-hidden bg-[#eef8f7]">
                        <img src="{{ asset('images/welcome-page/counseling-info-tile-1-1080x540.png') }}"
                             alt="Online Counselling"
                             class="w-full h-full object-cover object-center transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5 pb-6 flex flex-col flex-1">
                        <span class="inline-block text-[10.5px] font-semibold tracking-widest uppercase text-[#0a6e89] bg-[#dff4ef] rounded-full px-3 py-0.5 mb-2 w-fit">Professional Support</span>
                        <h4 class="text-[17px] font-semibold text-[#102f3a] mb-2 leading-snug">Online Counselling</h4>
                        <p class="text-sm text-[#4b626b] leading-relaxed mb-4">
                            Counselling focuses on helping you understand your thoughts and feelings, navigate difficult situations, and build practical tools for everyday wellbeing. Ideal for stress, relationships, grief, and emotional overwhelm.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(['Stress & anxiety', 'Relationships', 'Grief & loss', 'Emotional wellbeing'] as $topic)
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-3 py-1 text-xs font-medium text-[#0a6e89]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $topic }}
                            </span>
                            @endforeach
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#0f89a6] group-hover:gap-2.5 transition-all mt-auto">
                            Read more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Online Therapy Card --}}
                <a href="{{ route('online-therapy') }}"
                   class="group bg-white rounded-[18px] overflow-hidden border border-[#0f89a6]/10 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] flex flex-col h-full">
                    <div class="w-full aspect-[2/1] overflow-hidden bg-[#eef8f7]">
                        <img src="{{ asset('images/welcome-page/therapy-info-tile-1-1080x540.png') }}"
                             alt="Online Therapy"
                             class="w-full h-full object-cover object-center transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5 pb-6 flex flex-col flex-1">
                        <span class="inline-block text-[10.5px] font-semibold tracking-widest uppercase text-[#0a6e89] bg-[#dff4ef] rounded-full px-3 py-0.5 mb-2 w-fit">Professional Support</span>
                        <h4 class="text-[17px] font-semibold text-[#102f3a] mb-2 leading-snug">Online Therapy</h4>
                        <p class="text-sm text-[#4b626b] leading-relaxed mb-4">
                            Therapy provides structured, professional support for issues such as anxiety, depression, trauma, and long‑standing patterns that affect your wellbeing. Your therapist guides you through proven therapeutic approaches tailored to your needs.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(['Anxiety', 'Depression', 'Trauma & PTSD', 'Long-term patterns'] as $topic)
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-3 py-1 text-xs font-medium text-[#0a6e89]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $topic }}
                            </span>
                            @endforeach
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#0f89a6] group-hover:gap-2.5 transition-all mt-auto">
                            Read more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Online Coaching Card --}}
                <a href="{{ route('online-coaching') }}"
                   class="group bg-white rounded-[18px] overflow-hidden border border-[#0f89a6]/10 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] flex flex-col h-full">
                    <div class="w-full aspect-[2/1] overflow-hidden bg-[#eef8f7]">
                        <img src="{{ asset('images/welcome-page/coaching-info-tile-1-1080x540.png') }}"
                             alt="Online Coaching"
                             class="w-full h-full object-cover object-center transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5 pb-6 flex flex-col flex-1">
                        <span class="inline-block text-[10.5px] font-semibold tracking-widest uppercase text-[#0a6e89] bg-[#dff4ef] rounded-full px-3 py-0.5 mb-2 w-fit">Professional Support</span>
                        <h4 class="text-[17px] font-semibold text-[#102f3a] mb-2 leading-snug">Online Coaching</h4>
                        <p class="text-sm text-[#4b626b] leading-relaxed mb-4">
                            Coaching is future‑focused and action‑oriented. Your coach helps you set goals, stay accountable, and develop strategies for growth in areas like career, confidence, productivity, and lifestyle.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(['Career growth', 'Confidence', 'Productivity', 'Lifestyle goals'] as $topic)
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-3 py-1 text-xs font-medium text-[#0a6e89]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $topic }}
                            </span>
                            @endforeach
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#0f89a6] group-hover:gap-2.5 transition-all mt-auto">
                            Read more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>

            </div>
        </div>
    </section>
    {{-- End of Professional Support Service Tiles --}}

    {{-- Service-type assessment CTA --}}
    <section class="py-10 md:py-14 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto max-w-4xl rounded-2xl border border-[#9ed9d7] bg-gradient-to-b from-[#f4fbfb] to-white px-6 py-8 md:px-10 md:py-10 text-center shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)]">
                <h3 class="text-2xl font-semibold text-[#102f3a] sm:text-3xl">
                    Unsure of what help you need
                </h3>
                <p class="mx-auto mt-3 max-w-2xl text-base leading-7 text-[#4b626b]">
                    Answer a few questions and we will guide you to the required service
                </p>
                <div class="mt-6">
                <a 
                   class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#14b8a6] px-6 py-4 text-base font-semibold text-white shadow-md transition duration-200 hover:bg-[#0b7f70] hover:shadow-lg sm:w-auto sm:min-w-[280px]">
                    Start assessment
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                </div>
            </div>
        </div>
    </section>


   {{-- Existing Service Tiles --}}
<section class="py-16 mb-10 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
    <div class="container mx-auto px-6 lg:px-16 xl:px-24">

        <div class="mx-auto max-w-3xl text-center mb-12">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6]">
                More Services
            </p>
            <h3 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                Personal Training & Dietitian Support
            </h3>
            <p class="mx-auto mt-4 max-w-xl text-base leading-8 text-[#4b626b]">
                These existing services complement our counselling, therapy, and coaching offerings to support your full wellbeing journey.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 xl:gap-8">

            <a href="{{ route('personal-training') }}"
               class="group bg-white rounded-[18px] overflow-hidden border border-[#0f89a6]/10 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] block">
                {{-- Image: object-contain so full illustration is always visible --}}
                <div class="w-full aspect-video overflow-hidden bg-[#A3D4D3] flex items-center justify-center">
                    <img src="{{ asset('images/welcome-page/Personal-Training-Tile-Graphic-1.png') }}"
                         alt="Personal Training"
                         class="w-full h-full object-contain object-center transition duration-500 group-hover:scale-105">
                </div>
                <div class="p-5 pb-6">
                    <span class="inline-block text-[10.5px] font-semibold tracking-widest uppercase text-[#0a6e89] bg-[#dff4ef] rounded-full px-3 py-0.5 mb-2">Fitness</span>
                    <h4 class="text-[17px] font-semibold text-[#102f3a] mb-2 leading-snug">Personal Training</h4>
                    <p class="text-sm text-[#4b626b] leading-relaxed mb-4">
                        Individual personal training plans and online sessions tailored for your health and fitness goals.
                    </p>
                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#0f89a6] group-hover:gap-2.5 transition-all">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('eating-for-health') }}"
               class="group bg-white rounded-[18px] overflow-hidden border border-[#0f89a6]/10 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_52px_-12px_rgba(16,106,124,0.2)] block">
                {{-- Image: object-contain so full dietitian illustration is always visible --}}
                <div class="w-full aspect-video overflow-hidden bg-[#91D0CB] flex items-center justify-center">
                    <img src="{{ asset('images/welcome-page/Dietitian-Healthy-Eating-Tile-Graphic-1.png') }}"
                         alt="Dietitian & Healthy Eating"
                         class="w-full h-full object-contain object-center transition duration-500 group-hover:scale-105">
                </div>
                <div class="p-5 pb-6">
                    <span class="inline-block text-[10.5px] font-semibold tracking-widest uppercase text-[#0a6e89] bg-[#dff4ef] rounded-full px-3 py-0.5 mb-2">Nutrition</span>
                    <h4 class="text-[17px] font-semibold text-[#102f3a] mb-2 leading-snug">Dietitian & Healthy Eating</h4>
                    <p class="text-sm text-[#4b626b] leading-relaxed mb-4">
                        Personalised nutrition plans and online consultations to support your health and wellness goals.
                    </p>
                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#0f89a6] group-hover:gap-2.5 transition-all">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>
{{-- End of Existing Service Tiles --}}

    <!-- Scripts specific to this page -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/swiper.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


</x-app-layout>
