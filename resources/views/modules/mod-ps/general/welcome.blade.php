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

    {{-- ═══════════════════════════════════════════════════════════
         TRUST BAR — social proof directly below hero
         ═══════════════════════════════════════════════════════════ --}}
    <section role="region" aria-label="Trust credentials"
             class="w-full"
             style="background:#ffffff; border-top:1px solid rgba(15,137,166,0.1); border-bottom:1px solid rgba(15,137,166,0.1); box-shadow:0 2px 16px -6px rgba(15,137,166,0.08);">
        <div class="mx-auto max-w-6xl px-4 py-5 sm:px-6 sm:py-6 lg:px-12">

            {{-- Single-row grid, scrollable on tiny screens --}}
            <div class="overflow-x-auto">
                <ul class="grid grid-cols-4 gap-3 sm:gap-5 min-w-[560px]" role="list">

                    {{-- Card 1 — Licensed & Accredited --}}
                    <li role="listitem"
                        class="flex flex-col items-center text-center gap-2.5 rounded-2xl py-5 px-3 cursor-default select-none"
                        style="background:#f7fdfc; border:1.5px solid rgba(15,137,166,0.16); box-shadow:0 2px 10px -3px rgba(15,137,166,0.1); transition:transform 0.18s, box-shadow 0.18s;"
                        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px -6px rgba(15,137,166,0.22)';"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 2px 10px -3px rgba(15,137,166,0.1)';">
                        <span class="flex items-center justify-center rounded-full"
                              style="width:44px;height:44px;background:linear-gradient(135deg,#0b7087,#14b8a6);box-shadow:0 4px 14px -4px rgba(11,112,135,0.45);"
                              aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12.5px] font-bold leading-tight" style="color:#0c2f3a;">Licensed &amp; Accredited</p>
                            <p class="text-[11px] leading-snug mt-0.5" style="color:#5a7a87;">Verified practitioners only</p>
                        </div>
                    </li>

                    {{-- Card 2 — BACP --}}
                    <li role="listitem"
                        class="flex flex-col items-center text-center gap-2.5 rounded-2xl py-5 px-3 cursor-default select-none"
                        style="background:#f7fdfc; border:1.5px solid rgba(15,137,166,0.16); box-shadow:0 2px 10px -3px rgba(15,137,166,0.1); transition:transform 0.18s, box-shadow 0.18s;"
                        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px -6px rgba(15,137,166,0.22)';"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 2px 10px -3px rgba(15,137,166,0.1)';">
                        <span class="flex items-center justify-center rounded-full"
                              style="width:44px;height:44px;background:linear-gradient(135deg,#0b7087,#14b8a6);box-shadow:0 4px 14px -4px rgba(11,112,135,0.45);"
                              aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12.5px] font-bold leading-tight" style="color:#0c2f3a;">BACP Ethical Framework</p>
                            <p class="text-[11px] leading-snug mt-0.5" style="color:#5a7a87;">Evidence-based standards</p>
                        </div>
                    </li>

                    {{-- Card 3 — Confidential --}}
                    <li role="listitem"
                        class="flex flex-col items-center text-center gap-2.5 rounded-2xl py-5 px-3 cursor-default select-none"
                        style="background:#f7fdfc; border:1.5px solid rgba(15,137,166,0.16); box-shadow:0 2px 10px -3px rgba(15,137,166,0.1); transition:transform 0.18s, box-shadow 0.18s;"
                        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px -6px rgba(15,137,166,0.22)';"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 2px 10px -3px rgba(15,137,166,0.1)';">
                        <span class="flex items-center justify-center rounded-full"
                              style="width:44px;height:44px;background:linear-gradient(135deg,#0b7087,#14b8a6);box-shadow:0 4px 14px -4px rgba(11,112,135,0.45);"
                              aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12.5px] font-bold leading-tight" style="color:#0c2f3a;">Confidential &amp; Secure</p>
                            <p class="text-[11px] leading-snug mt-0.5" style="color:#5a7a87;">Your privacy protected</p>
                        </div>
                    </li>

                    {{-- Card 4 — Global --}}
                    <li role="listitem"
                        class="flex flex-col items-center text-center gap-2.5 rounded-2xl py-5 px-3 cursor-default select-none"
                        style="background:#f7fdfc; border:1.5px solid rgba(15,137,166,0.16); box-shadow:0 2px 10px -3px rgba(15,137,166,0.1); transition:transform 0.18s, box-shadow 0.18s;"
                        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px -6px rgba(15,137,166,0.22)';"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 2px 10px -3px rgba(15,137,166,0.1)';">
                        <span class="flex items-center justify-center rounded-full"
                              style="width:44px;height:44px;background:linear-gradient(135deg,#0b7087,#14b8a6);box-shadow:0 4px 14px -4px rgba(11,112,135,0.45);"
                              aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12.5px] font-bold leading-tight" style="color:#0c2f3a;">Global Coverage</p>
                            <p class="text-[11px] leading-snug mt-0.5" style="color:#5a7a87;">Local support, worldwide</p>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </section>
    {{-- ═══════════════════════════════════════════════════════════
         END TRUST BAR
         ═══════════════════════════════════════════════════════════ --}}

                {{-- Card 1 — Licensed & accredited --}}
                <li role="listitem"
                    class="flex items-center gap-3.5 bg-white rounded-2xl px-5 py-4 cursor-default"
                    style="border:1.5px solid rgba(15,137,166,0.18); box-shadow:0 2px 12px -4px rgba(15,137,166,0.14); transition:box-shadow 0.2s, transform 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px -6px rgba(15,137,166,0.24)';"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px -4px rgba(15,137,166,0.14)';">
                    <span class="flex-shrink-0 flex items-center justify-center rounded-xl"
                          style="width:40px;height:40px;background:linear-gradient(135deg,#0b7087 0%,#14b8a6 100%);"
                          aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-[13px] font-semibold leading-tight" style="color:#0d2f39;">Licensed &amp; Accredited</p>
                        <p class="text-[11.5px] leading-tight mt-0.5" style="color:#5a7a87;">Verified practitioners only</p>
                    </div>
                </li>

                {{-- Card 2 — BACP --}}
                <li role="listitem"
                    class="flex items-center gap-3.5 bg-white rounded-2xl px-5 py-4 cursor-default"
                    style="border:1.5px solid rgba(15,137,166,0.18); box-shadow:0 2px 12px -4px rgba(15,137,166,0.14); transition:box-shadow 0.2s, transform 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px -6px rgba(15,137,166,0.24)';"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px -4px rgba(15,137,166,0.14)';">
                    <span class="flex-shrink-0 flex items-center justify-center rounded-xl"
                          style="width:40px;height:40px;background:linear-gradient(135deg,#0b7087 0%,#14b8a6 100%);"
                          aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-[13px] font-semibold leading-tight" style="color:#0d2f39;">BACP Ethical Framework</p>
                        <p class="text-[11.5px] leading-tight mt-0.5" style="color:#5a7a87;">Evidence-based practice</p>
                    </div>
                </li>

                {{-- Card 3 — Confidential --}}
                <li role="listitem"
                    class="flex items-center gap-3.5 bg-white rounded-2xl px-5 py-4 cursor-default"
                    style="border:1.5px solid rgba(15,137,166,0.18); box-shadow:0 2px 12px -4px rgba(15,137,166,0.14); transition:box-shadow 0.2s, transform 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px -6px rgba(15,137,166,0.24)';"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px -4px rgba(15,137,166,0.14)';">
                    <span class="flex-shrink-0 flex items-center justify-center rounded-xl"
                          style="width:40px;height:40px;background:linear-gradient(135deg,#0b7087 0%,#14b8a6 100%);"
                          aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-[13px] font-semibold leading-tight" style="color:#0d2f39;">Confidential &amp; Secure</p>
                        <p class="text-[11.5px] leading-tight mt-0.5" style="color:#5a7a87;">Your privacy protected</p>
                    </div>
                </li>

                {{-- Card 4 — Global --}}
                <li role="listitem"
                    class="flex items-center gap-3.5 bg-white rounded-2xl px-5 py-4 cursor-default"
                    style="border:1.5px solid rgba(15,137,166,0.18); box-shadow:0 2px 12px -4px rgba(15,137,166,0.14); transition:box-shadow 0.2s, transform 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px -6px rgba(15,137,166,0.24)';"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px -4px rgba(15,137,166,0.14)';">
                    <span class="flex-shrink-0 flex items-center justify-center rounded-xl"
                          style="width:40px;height:40px;background:linear-gradient(135deg,#0b7087 0%,#14b8a6 100%);"
                          aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                            <circle cx="12" cy="12" r="10"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-[13px] font-semibold leading-tight" style="color:#0d2f39;">Global Coverage</p>
                        <p class="text-[11.5px] leading-tight mt-0.5" style="color:#5a7a87;">Local support, worldwide</p>
                    </div>
                </li>

            </ul>
        </div>
    </section>
    {{-- ═══════════════════════════════════════════════════════════
         END TRUST BAR
         ═══════════════════════════════════════════════════════════ --}}

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-16 md:py-24">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health
                    </p>
                    <h2 class="max-w-xl text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">
                        Trusted professionals supporting your health and wellbeing. All in one place.
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
    <section class="py-14 md:py-20 ">
        <div class="container mx-auto px-6 lg:px-12 text-center">

            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#9ed9d7] bg-white px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-[#0f89a6] shadow-sm">
                Find Your Support
            </p>

            <h3 class="text-2xl font-bold text-[#102f3a] sm:text-3xl mb-3">
                Unsure of what help you need
            </h3>
            <p class="mx-auto mb-8 max-w-xl text-base leading-7 text-[#4b626b]">
                Answer a few questions and we will guide you to the required service
            </p>

            <a class="inline-flex items-center justify-center gap-2 rounded-full px-8 py-4 text-base font-semibold text-white transition-all duration-200 hover:-translate-y-0.5 sm:min-w-[280px]"
               style="background:linear-gradient(90deg,#0f89a6,#14b8a6);box-shadow:0 8px 28px -6px rgba(15,137,166,0.4);"
               onmouseover="this.style.boxShadow='0 14px 36px -6px rgba(15,137,166,0.55)';"
               onmouseout="this.style.boxShadow='0 8px 28px -6px rgba(15,137,166,0.4)';">
                Start assessment
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

        </div>
    </section>



    {{-- Professional Support Service Tiles --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
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
    <section class="py-14 md:py-20 ">
        <div class="container mx-auto px-6 lg:px-12 text-center">

            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#9ed9d7] bg-white px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-[#0f89a6] shadow-sm">
                Find Your Support
            </p>

            <h3 class="text-2xl font-bold text-[#102f3a] sm:text-3xl mb-3">
                Unsure of what help you need
            </h3>
            <p class="mx-auto mb-8 max-w-xl text-base leading-7 text-[#4b626b]">
                Answer a few questions and we will guide you to the required service
            </p>

            <a class="inline-flex items-center justify-center gap-2 rounded-full px-8 py-4 text-base font-semibold text-white transition-all duration-200 hover:-translate-y-0.5 sm:min-w-[280px]"
               style="background:linear-gradient(90deg,#0f89a6,#14b8a6);box-shadow:0 8px 28px -6px rgba(15,137,166,0.4);"
               onmouseover="this.style.boxShadow='0 14px 36px -6px rgba(15,137,166,0.55)';"
               onmouseout="this.style.boxShadow='0 8px 28px -6px rgba(15,137,166,0.4)';">
                Start assessment
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

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
