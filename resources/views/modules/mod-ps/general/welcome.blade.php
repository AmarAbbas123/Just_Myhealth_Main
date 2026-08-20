<!-- resources/views/home.blade.php -->
<x-app-layout>
    <!-- HERO AREA -->
{{--
    Uses the same new photo on all screen sizes (no separate mobile swap) —
    the old jmh-header-mobile.png had the logo/tagline baked directly into
    the image, which caused it to visually double up with the HTML text
    overlay below. Text now sits in a solid/blurred panel so it stays
    legible regardless of what's happening in the photo behind it.
--}}
<section class="relative w-full min-h-[560px] sm:min-h-[620px] md:h-[80vh] flex items-center pt-24 pb-10 md:pt-20 md:pb-0 overflow-hidden">
    <img src="{{ asset('images/welcome-page/hero-bg.jfif') }}"
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


    <section  class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-16 md:py-24">
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
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
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

    {{-- CTA Banner: helps undecided visitors choose a service. Most first-time
         visitors don't know whether they need Counselling, Therapy, or
         Coaching — this banner names that uncertainty directly and offers a
         low-friction way forward before asking them to pick between the
         three tiles below. --}}
    <section id="services" class="py-10 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto max-w-4xl rounded-2xl border border-[#9ed9d7] bg-[#f4fbfb] px-6 py-8 text-center shadow-[0_20px_50px_-30px_rgba(15,137,166,0.4)] sm:px-10">
                <h3 class="text-xl font-semibold text-[#102f3a] sm:text-2xl">
                    Not sure which service is right for you?
                </h3>
                <p class="mx-auto mt-3 max-w-2xl text-base leading-7 text-[#4b626b]">
                    That's completely normal — most people aren't sure where to start. Take a look at Counselling, Therapy, and Coaching below to see which fits what you're going through, or reach out and we'll help you find the right fit.
                </p>
                <div class="mt-6">
                    <a href="{{ route('contact-us') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-[#0f89a6] px-6 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-[#0b7087]">
                        Help me choose
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- End of CTA Banner --}}


    {{-- Online Counseling --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
                <a href="{{ route('online-counselling') }}" class="group block overflow-hidden transition duration-300 hover:-translate-y-1">
                    <div class="relative w-full overflow-hidden rounded-[10px] shadow-[0_20px_60px_-20px_rgba(15,137,166,0.25)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_64px_-20px_rgba(15,137,166,0.35)]" style="aspect-ratio: 2 / 1;">
                        <img src="{{ asset('images/welcome-page/counseling-info-tile-1-1080x540.png') }}"
                             alt="Online Counseling"
                             class="absolute inset-0 h-full w-full ">
                    </div>
                </a>

                <div class="space-y-6 border-l-4 border-[#9ed9d7] pl-6 text-[#243b45] md:text-lg">
                    <div class="max-w-2xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#0f89a6]">
                            Professional Support
                        </p>
                        <h3 class="mt-3 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                            Online Counseling
                        </h3>
                        
                        <p class="mt-6 text-base leading-8 text-[#4b626b]">
                            Counseling focuses on helping you understand your thoughts and feelings, navigate difficult situations, and build practical tools for everyday wellbeing. Ideal for stress, relationships, grief, and emotional overwhelm.
                        </p>
                        
                    </div>

                   {{-- Topic pills --}}
                <div class="flex flex-wrap gap-2 mb-7">
                    @foreach(['Stress & anxiety', 'Relationships', 'Grief & loss', 'Emotional wellbeing'] as $topic)
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-3.5 py-1.5 text-xs font-medium text-[#0a6e89]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $topic }}
                    </span>
                    @endforeach
                </div>
                {{-- CTA --}}
                <div>
                    <a href="{{ route('online-counselling') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-[#0f89a6] px-6 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-[#0b7087]">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Online Counseling --}}


    {{-- Online Therapy --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
                <a href="{{ route('online-therapy') }}" class="group block overflow-hidden transition duration-300 hover:-translate-y-1">
                    <div class="relative w-full overflow-hidden rounded-[10px] shadow-[0_20px_60px_-20px_rgba(15,137,166,0.25)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_64px_-20px_rgba(15,137,166,0.35)]" style="aspect-ratio: 2 / 1;">
                        <img src="{{ asset('images/welcome-page/therapy-info-tile-1-1080x540.png') }}"
                             alt="Online Therapy"
                             class="absolute inset-0 h-full w-full object-cover">
                    </div>
                </a>

                <div class="space-y-6 border-l-4 border-[#0f89a6] pl-6 text-[#243b45] md:text-lg">
                    <div class="max-w-2xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#0f89a6]">
                            Professional Support
                        </p>
                        <h3 class="mt-3 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                            Online Therapy
                        </h3>
                        <p class="mt-6 text-base leading-8 text-[#4b626b]">
                            Therapy provides structured, professional support for issues such as anxiety, depression, trauma, and long‑standing patterns that affect your wellbeing. Your therapist guides you through proven therapeutic approaches tailored to your needs.
                        </p>
                       
                    </div>
{{-- Topic pills --}}
                <div class="flex flex-wrap gap-2 mb-7">
                    @foreach(['Anxiety', 'Depression', 'Trauma & PTSD', 'Long-term patterns'] as $topic)
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-3.5 py-1.5 text-xs font-medium text-[#0a6e89]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $topic }}
                    </span>
                    @endforeach
                </div>
                {{-- CTA --}}
                <div>
                    <a href="{{ route('online-therapy') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-[#0f89a6] px-6 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-[#0b7087]">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                    
                </div>
            </div>
        </div>
    </section>
    {{-- End of Online Therapy --}}


    {{-- Online Coaching --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
                <a href="{{ route('online-coaching') }}" class="group block overflow-hidden transition duration-300 hover:-translate-y-1">
                    <div class="relative w-full overflow-hidden rounded-[10px] shadow-[0_20px_60px_-20px_rgba(15,137,166,0.25)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_64px_-20px_rgba(15,137,166,0.35)]" style="aspect-ratio: 2 / 1;">
                        <img src="{{ asset('images/welcome-page/coaching-info-tile-1-1080x540.png') }}"
                             alt="Online Coaching"
                             class="absolute inset-0 h-full w-full object-cover">
                    </div>
                </a>

                <div class="space-y-6 border-l-4 border-[#9ed9d7] pl-6 text-[#243b45] md:text-lg">
                    <div class="max-w-2xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#0f89a6]">
                            Professional Support
                        </p>
                        <h3 class="mt-3 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                            Online Coaching
                        </h3>
                        <p class="mt-6 text-base leading-8 text-[#4b626b]">
                            Coaching is future‑focused and action‑oriented. Your coach helps you set goals, stay accountable, and develop strategies for growth in areas like career, confidence, productivity, and lifestyle.
                        </p>
                       
                    </div>
                    {{-- Topic pills --}}
                <div class="flex flex-wrap gap-2 mb-7">
                    @foreach(['Career growth', 'Confidence', 'Productivity', 'Lifestyle goals'] as $topic)
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-3.5 py-1.5 text-xs font-medium text-[#0a6e89]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $topic }}
                    </span>
                    @endforeach
                </div>
                {{-- CTA --}}
                <div>
                    <a href="{{ route('online-coaching') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-[#0f89a6] px-6 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-[#0b7087]">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                    
                </div>
            </div>
        </div>
    </section>
    {{-- End of Online Coaching --}}

    {{-- CTA Banner: bridges the mental/emotional services above with the
         physical/nutritional services below, since visitors browsing
         Counselling/Therapy/Coaching may not realise Personal Training and
         Dietitian support are also part of the platform. --}}
    <section class="py-10 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto max-w-4xl rounded-2xl border border-[#0f89a6]/20 bg-white px-6 py-8 text-center shadow-[0_20px_50px_-30px_rgba(15,137,166,0.4)] sm:px-10">
                <h3 class="text-xl font-semibold text-[#102f3a] sm:text-2xl">
                    Wellbeing isn't just mental — it's physical too
                </h3>
                <p class="mx-auto mt-3 max-w-2xl text-base leading-7 text-[#4b626b]">
                    Your mind and body are connected. Explore our Personal Training and Dietitian services below to support the physical side of your health journey too.
                </p>
                <div class="mt-6">
                    <a href="{{ route('regAccountType') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-[#0f89a6] px-6 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-[#0b7087]">
                        Get started today
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- End of CTA Banner --}}


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