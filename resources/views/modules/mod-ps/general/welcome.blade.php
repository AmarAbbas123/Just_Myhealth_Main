<!-- resources/views/home.blade.php -->
<x-app-layout>
    <!-- HERO AREA -->
    <section class="relative w-full min-h-[560px] sm:min-h-[620px] md:h-[80vh] flex items-center pt-24 pb-10 md:pt-20 md:pb-0 overflow-hidden">
    <img src="{{ asset('images/welcome-page/hero-bg.jpeg') }}"
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
         TRUST BAR — social proof, redesigned with FAQ-card style
         ═══════════════════════════════════════════════════════════ --}}
    <style>
        /* ── Trust-bar section ── */
        .trust-var-section {
            width: 100%;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 45%, #ecfeff 100%);
            border-top: 1px solid rgba(15,137,166,0.08);
            border-bottom: 1px solid rgba(15,137,166,0.08);
        }
        .trust-var-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 84px 24px;
            text-align: center;
        }
        /* section badge */
        .trust-var-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #b2e0de;
            border-radius: 999px;
            padding: 5px 16px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: #0b7087;
            background: #ffffff;
            margin-bottom: 18px;
        }
        .trust-var-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #14b8a6;
            flex-shrink: 0;
        }
        /* heading */
        .trust-var-heading {
            font-size: clamp(1.75rem, 3.5vw, 2.5rem);
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            margin: 0 0 12px;
        }
        /* subtitle */
        .trust-var-sub {
            font-size: 15px;
            color: #64748b;
            line-height: 1.65;
            max-width: 500px;
            margin: 0 auto 44px;
        }
        /* 4-column card grid */
        .trust-var-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        @media (max-width: 900px) {
            .trust-var-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .trust-var-grid { grid-template-columns: 1fr; }
        }
        /* individual card */
        .trust-var-card {
            background: #ffffff;
         
            border-radius: 18px;
            padding: 26px 22px 28px;
            text-align: left;
            box-shadow: 0 2px 14px rgba(0,0,0,0.06);
          
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            cursor: default;
        }
        .trust-var-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 32px rgba(11,112,135,0.12);
            border-color: #a5d8d8;
        }
        /* top row: icon + pill */
        .trust-var-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .trust-var-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0b7087, #14b8a6);
            box-shadow: 0 4px 14px -4px rgba(11,112,135,0.4);
            flex-shrink: 0;
        }
        .trust-var-pill {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: #0b7087;
            background: #e6f6f5;
            border: 1px solid #b2e0de;
            border-radius: 999px;
            padding: 3px 10px;
        }
        /* card text */
        .trust-var-card h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1px;
          margin-top:20px;
            line-height: 1.3;
        }
        .trust-var-card p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }
        .trust-var-card p a {
            color: #0b7087;
            text-decoration: none;
        }
        .trust-var-card p a:hover { text-decoration: underline; }
    </style>

    <section class="trust-var-section" role="region" aria-label="Trust credentials">

        {{-- Background decorative blobs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(20,184,166,0.12) 0%,transparent 70%);top:-150px;left:-100px;"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(15,137,166,0.08) 0%,transparent 70%);bottom:-120px;right:-80px;"></div>
            {{-- Grid dot pattern --}}
            <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:0.035;" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="trustDots" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="#0f89a6"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#trustDots)"/>
            </svg>
        </div>

        <div class="trust-var-inner" style="position:relative;z-index:1;">

            {{-- Badge --}}
            <div class="trust-var-badge">
                <span class="trust-var-badge-dot"></span>
                Why Trust Us
            </div>

            {{-- Heading --}}
            <h2 class="trust-var-heading">Built on Trust &amp; Integrity</h2>

            {{-- Subtitle --}}
            <p class="trust-var-sub">
                Every practitioner on JustMy.Health is verified, accredited, and held to the highest professional standards.
            </p>

            {{-- 4-column card grid — original trust bar content --}}
            <ul class="trust-var-grid" role="list">

                {{-- Card 1 — Licensed & Accredited --}}
                <li class="trust-var-card" role="listitem">
                    <div class="trust-var-card-top">
                        <span class="trust-var-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </span>
                        <span class="trust-var-pill">Licensed</span>
                    </div>
                    <h4>Licensed &amp; Accredited</h4>
                    <p><a href="{{ route('faq') }}#faq-licensed">Verified practitioners only</a></p>
                </li>

                {{-- Card 2 — BACP Ethical Framework --}}
                <li class="trust-var-card" role="listitem">
                    <div class="trust-var-card-top">
                        <span class="trust-var-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </span>
                        <span class="trust-var-pill">Ethical</span>
                    </div>
                    <h4>BACP Ethical Framework</h4>
                    <p><a href="{{ route('faq') }}#faq-medical">Evidence-based standards</a></p>
                </li>

                {{-- Card 3 — Confidential & Secure --}}
                <li class="trust-var-card" role="listitem">
                    <div class="trust-var-card-top">
                        <span class="trust-var-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <span class="trust-var-pill">Secure</span>
                    </div>
                    <h4>Confidential &amp; Secure</h4>
                    <p>Your <a href="{{ route('faq') }}#faq-secure">Your privacy protected</a></p>
                </li>

                {{-- Card 4 — Global Coverage --}}
                <li class="trust-var-card" role="listitem">
                    <div class="trust-var-card-top">
                        <span class="trust-var-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.1">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                            </svg>
                        </span>
                        <span class="trust-var-pill">Global</span>
                    </div>
                    <h4>Global Coverage</h4>
                    <p><a href="{{ route('faq') }}#faq-global">Local support, worldwide</a></p>
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
    

    {{-- Professional Support Service Tiles --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7]">
        <div class="container mx-auto px-6 lg:px-16 xl:px-20" id="services">

            <div class="mx-auto max-w-4xl text-center mb-12">
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
                    <div class="w-full overflow-hidden bg-[#eef8f7] flex items-center justify-center" style="height:220px;">
                        <img src="{{ asset('images/welcome-page/counselling-info-tile-2-1024x1024.png') }}"
                             alt="Online Counselling"
                             style="max-height:200px; width:auto; max-width:100%; object-fit:contain;"
                             class="transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5 pb-6 flex flex-col flex-1">
                      
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
                    <div class="w-full overflow-hidden bg-[#eef8f7] flex items-center justify-center" style="height:220px;">
                        <img src="{{ asset('images/welcome-page/therapy-info-tile-2-1024x1024.png') }}"
                             alt="Online Therapy"
                             style="max-height:200px; width:auto; max-width:100%; object-fit:contain;"
                             class="transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5 pb-6 flex flex-col flex-1">
                       
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
                    <div class="w-full overflow-hidden bg-[#eef8f7] flex items-center justify-center" style="height:220px;">
                        <img src="{{ asset('images/welcome-page/coaching-info-tile-2-1024x1024.png') }}"
                             alt="Online Coaching"
                             style="max-height:200px; width:auto; max-width:100%; object-fit:contain;"
                             class="transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5 pb-6 flex flex-col flex-1">
                       
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

    {{-- ============================================================ --}}
    {{-- Service-type assessment CTA                      --}}
    {{-- ============================================================ --}}
    <section id="pt-pre-register"
             class="relative overflow-hidden py-20 lg:py-28"
             style="background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 45%, #ecfeff 100%);">

        {{-- Background decorative blobs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:500px;height:500px;border-radius:50%;
                        background:radial-gradient(circle,rgba(20,184,166,0.12) 0%,transparent 70%);
                        top:-150px;left:-100px;"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;
                        background:radial-gradient(circle,rgba(15,137,166,0.08) 0%,transparent 70%);
                        bottom:-120px;right:-80px;"></div>
            {{-- Grid dot pattern --}}
            <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:0.035;" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="ptDots" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="#0f89a6"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#ptDots)"/>
            </svg>
        </div>

        <div class="relative z-10 container mx-auto px-6 lg:px-12">

            
            {{-- Two-column layout --}}
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center max-w-6xl mx-auto">

                {{-- LEFT — Headline + social proof --}}
                <div>
                    <h2 style="font-size:clamp(2rem,4.5vw,3.2rem);font-weight:800;color:#0c2830;letter-spacing:-0.025em;line-height:1.12;" class="mb-4">
                        Not sure which<br>
                        <span style="background:linear-gradient(90deg,#0f89a6,#14b8a6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">service is right</span>
                        for you?
                    </h2>                  

                    <p style="color:#4b6a74;font-size:1.05rem;line-height:1.75;max-width:420px;" class="mb-8">
                      Answer a few simple questions and we'll match you with the right practitioner and service. Personalised to your needs, in under 2 minutes.

                    </p>
                {{-- Social proof --}}
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="display:flex;">
                        @foreach(['JD','AM','SK','PR'] as $initials)
                        <span style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#0b7087,#14b8a6); border:2.5px solid #ffffff; display:inline-flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:#fff; margin-left:{{ $loop->first ? '0' : '-10px' }}; position:relative; z-index:{{ 10 - $loop->index }};">{{ $initials }}</span>
                        @endforeach
                    </div>
                    <div>
                        <p style="font-size:13px; font-weight:700; color:#0c2f3a; margin:0;">Become a service user....</p>
                        <p style="font-size:11.5px; color:#5a7a87; margin:2px 0 0;">Get the support you need....</p>
                    </div>
                </div>
                    
                </div>

                {{-- Vertical divider (desktop only) --}}
                {{-- RIGHT — Floating benefits card --}}
                <div class="relative">

                    {{-- Glow shadow behind card --}}
                    <div style="position:absolute;inset:-1px;border-radius:1.5rem;background:linear-gradient(135deg,rgba(15,137,166,0.2),rgba(20,184,166,0.15),transparent);filter:blur(20px);z-index:0;"></div>

                    <div style="position:relative;z-index:1;background:#ffffff;border:1px solid rgba(15,137,166,0.15);
                                border-radius:1.5rem;padding:2.5rem;
                                box-shadow:0 25px 60px -15px rgba(15,137,166,0.2),0 10px 30px -10px rgba(0,0,0,0.06);">

                        <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#0f89a6;margin-bottom:0.75rem;">
                            How it works
                        </p>
                        <h3 style="font-size:1.55rem;font-weight:800;color:#0c2830;margin-bottom:1.75rem;line-height:1.2;">
                            Start your free assessment
                        </h3>

                        {{-- Benefits list --}}
                        <ul style="list-style:none;padding:0;margin:0 0 2rem;display:flex;flex-direction:column;gap:1rem;">
                            @foreach([
                                ['Tell us what you are experiencing',         'Answer a short set of simple questions'],
                                ['We recommend the right service',  'Therapy, Counselling or Coaching'],
                                ['Register for a free account',     'Start your Health and Wellbeing Journey

'],
                            ] as [$title, $desc])
                            <li style="display:flex;align-items:flex-start;gap:0.9rem;">
                                <span style="flex-shrink:0;width:24px;height:24px;border-radius:50%;
                                             background:linear-gradient(135deg,#0f89a6,#14b8a6);
                                             display:flex;align-items:center;justify-content:center;margin-top:2px;">
                                    <svg style="width:13px;height:13px;fill:none;stroke:#fff;stroke-width:2.5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <span style="font-size:0.9rem;font-weight:700;color:#0c2830;display:block;">{{ $title }}</span>
                                    <span style="font-size:0.82rem;color:#6b8c96;line-height:1.5;">{{ $desc }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        {{-- CTA button --}}
                        <a href="{{ route('therapy.service-type.start') }}"
                           style="display:flex;align-items:center;justify-content:center;gap:0.5rem;
                                  background:linear-gradient(90deg,#0f89a6,#14b8a6);
                                  color:#fff;font-size:1rem;font-weight:700;
                                  padding:0.9rem 2rem;border-radius:999px;
                                  box-shadow:0 8px 25px -5px rgba(15,137,166,0.5);
                                  text-decoration:none;transition:transform 0.2s,box-shadow 0.2s;"
                           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 32px -5px rgba(15,137,166,0.6)';"
                           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 25px -5px rgba(15,137,166,0.5)';">
                            Start assessment
                            <svg style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>

                        {{-- Subtle footnote --}}
                        <p style="text-align:center;font-size:0.75rem;color:#9bb5bc;margin-top:1rem;">
                            Free to use service evaluation · No account required for evaluation
                        </p>
                    </div>
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
