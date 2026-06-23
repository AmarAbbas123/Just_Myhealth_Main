<!-- resources/views/home.blade.php -->
<x-app-layout>
    <!-- HERO AREA -->
<section class="relative w-full h-[80vh] md:h-[100vh] pt-20 overflow-hidden">
    <picture class="block w-full h-full">
        <source media="(max-width: 767px)" srcset="{{ asset('images/welcome-page/jmh-header-mobile.png') }}">
        <img src="{{ asset('images/welcome-page/hero-bg.png') }}"
             alt="Hero"
             class="w-full h-full object-cover object-center">
    </picture>

    <!-- Hero Content -->
    <div class="absolute inset-0 flex items-center px-6 max-w-4xl text-white">
        <!-- Your content goes here -->
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
                        Where social media meets health and wellness
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Education, empowerment, and personalized support in one connected health platform.
                    </p>
                 </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            JustMy.Health is the dynamic online health platform where social media meets health and wellness through education, empowerment, and personalized support.
                        </p>
                        <p>
                            JustMy.Health provides clients with preventive and curative healthcare access, online counselling and therapy services, and tailored dietary programs - giving everyone the tools they need to improve their health, wellness, and longevity.
                        </p>
                        <p>
                            With global coverage and locally tailored support, JustMy.Health serves both individuals and organizations. Our platform empowers clients directly while also delivering scalable B2B solutions for employers, clinics, wellness providers, and community partners seeking to elevate health outcomes worldwide.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}


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
                        <p class="mt-4 text-base leading-8">
                            Therapeutic Practitioners on JustMy.Health provide safe, supportive, and professional guidance to help clients improve their mental, emotional, and overall wellbeing.
                        </p>
                        <p class="mt-4 text-base leading-8">
                            Each Therapeutic practitioner is fully verified, qualified, and committed to delivering ethical, person-centred care.
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
                        <p class="mt-4 text-base leading-8">
                            Therapeutic Practitioners on JustMy.Health provide safe, supportive, and professional guidance to help clients improve their mental, emotional, and overall wellbeing.
                        </p>
                        <p class="mt-4 text-base leading-8">
                            Each Therapeutic practitioner is fully verified, qualified, and committed to delivering ethical, person-centred care.
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
                <a href="{{ route('online-counselling') }}" class="group block overflow-hidden transition duration-300 hover:-translate-y-1">
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
                        <p class="mt-4 text-base leading-8">
                            Therapeutic Practitioners on JustMy.Health provide safe, supportive, and professional guidance to help clients improve their mental, emotional, and overall wellbeing.
                        </p>
                        <p class="mt-4 text-base leading-8">
                            Each Therapeutic practitioner is fully verified, qualified, and committed to delivering ethical, person-centred care.
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
    {{-- End of Online Coaching --}}


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
                        Personalized nutrition plans and online consultations to support your health and wellness goals.
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


    <section class="">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="mx-auto max-w-full px-0 py-12 md:py-16">

            {{-- Header --}}
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#0f89a6]">Our Approach</p>
            <h2 class="text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl mb-4">
                The Guided Path
            </h2>
            <p class=" text-base leading-relaxed text-[#4b626b] md:text-lg mb-10">
              The Guided Path is a simple, people-centric journey designed to help you take control of your health through connection, collaboration, and shared knowledge. It begins by connecting you with peers, health providers, NGOs, and volunteers who understand your specific condition.
            </p>

            <hr class="border-t border-[#d7eceb] mb-10">

            {{-- 4 Step Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-10">

                @foreach([
                    ['num' => '1', 'label' => 'Connect',  'img' => 'jmh-guided-path-connect-1.png',  'alt' => 'Connect',  'desc' => 'Build relationships with peers, providers, NGOs and volunteers who share your journey.'],
                    ['num' => '2', 'label' => 'Engage',   'img' => 'jmh-guided-path-engage-1.png',   'alt' => 'Engage',   'desc' => 'Actively participate in trusted networks to receive real guidance and support.'],
                    ['num' => '3', 'label' => 'Educate',  'img' => 'jmh-guided-path-educate-1.png',  'alt' => 'Educate',  'desc' => 'Learn from lived experience and reliable information shared across the community.'],
                    ['num' => '4', 'label' => 'Empower',  'img' => 'jmh-guided-path-empower-1.png',  'alt' => 'Empower',  'desc' => 'Improve your wellbeing and give back by sharing knowledge with others.'],
                ] as $step)
                <div class="flex flex-col gap-3 rounded-2xl border border-[#c4e6e0] bg-[#f4fbfb] p-4 md:p-5">
                    {{-- Step number + label --}}
                    <div class="flex items-center gap-2">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-[#0f89a6] text-xs font-bold text-white">
                            {{ $step['num'] }}
                        </span>
                        <span class="text-sm font-bold text-[#102f3a]">{{ $step['label'] }}</span>
                    </div>
                    {{-- Image --}}
                    <div class="w-full overflow-hidden rounded-xl bg-[#c8eee3]">
                        <img src="{{ asset('images/welcome-page/' . $step['img']) }}"
                             alt="{{ $step['alt'] }}"
                             class="h-full w-full object-contain">
                    </div>
                    {{-- Description --}}
                    <p class="text-xs leading-relaxed text-[#4b626b] md:text-sm">{{ $step['desc'] }}</p>
                </div>
                @endforeach

            </div>

            <hr class="border-t border-[#d7eceb] mb-8">

            {{-- Body text --}}
            <div class="space-y-4 text-base leading-relaxed text-[#4b626b] md:text-lg">
                <p>Through active engagement with these trusted networks, you gain access to real guidance and support tailored to your specific condition and needs.</p>
                <p>As you learn from others' experience, you educate yourself with reliable, lived information — empowering you to improve your wellbeing and give back by sharing what you've learned with the wider community.</p>
                <p>Together, these four steps - Connect, Engage, Educate, Empower - form a <span class="font-semibold text-[#0f89a6]">continuous cycle of growth</span> that strengthens both individual health and collective resilience.</p>
            </div>

            {{-- Cycle badge --}}
            <div class="mt-6">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#a8ddd0] bg-[#e0f5ef] px-4 py-1.5 text-xs font-semibold text-[#0a6e89]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Connect → Engage → Educate → Empower → repeat
                </span>
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
