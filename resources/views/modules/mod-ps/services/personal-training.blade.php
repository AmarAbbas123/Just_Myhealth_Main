<x-app-layout title="Personal Training (PUB) | JustMy.Health" metaDescription="JustMy.Health Personal training Overview Page.">

    <!-- Premium Hero Section -->
    <section class="relative min-h-[26rem] flex items-center pt-24 pb-4 overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.jpg') }}"
                 alt="Personal Training Hero Background"
                 class="w-full h-full object-cover object-center">
            <!-- Dark overlay with teal tint -->
            <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(5,20,31,0.80) 0%, rgba(12,56,72,0.65) 50%, rgba(5,20,31,0.75) 100%);"></div>
        </div>

        <!-- Content (Left Side) -->
        <div class="relative z-10 container mx-auto px-6 lg:px-12 flex items-center h-full">
            <div class="max-w-2xl">

                <!-- Breadcrumb -->
                <div class="inline-flex items-center space-x-2 text-sm font-medium mb-8 px-4 py-1.5 rounded-full"
                     style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); backdrop-filter:blur(10px);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#5ee7df]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                    </svg>
                    <span style="color:rgba(255,255,255,0.7);">Home</span>
                    <span style="color:rgba(255,255,255,0.3);">›</span>
                    <span class="text-white font-semibold">Personal Training</span>
                </div>

                <!-- Page Title -->
                <h1 class="text-5xl lg:text-5xl font-extrabold text-white tracking-tight mb-4" style="line-height:1.1;">
                    Personal Training<br>
                    <span style="background:linear-gradient(90deg,#5ee7df,#38bdf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">JustMy.Health</span>
                </h1>

                <!-- Coming Soon Badge -->
                <div class="mt-8 inline-flex items-center gap-3 px-6 py-2.5 rounded-full font-bold uppercase tracking-widest text-sm"
                     style="background:rgba(250,204,21,0.1); border:1px solid rgba(250,204,21,0.35); color:#facc15; box-shadow:0 0 20px rgba(250,204,21,0.15); backdrop-filter:blur(8px);">
                    <span style="width:8px;height:8px;border-radius:50%;background:#facc15;box-shadow:0 0 10px #facc15;animation:ptPulse 2s infinite;display:inline-block;"></span>
                    Coming Soon
                </div>

            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Personal Training
                    </p>
                    <h2 class="max-w-xl text-2xl font-semibold leading-tight text-[#102f3a] sm:text-3xl md:text-4xl">
                        Personal Training Designed Around You
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Your fitness journey should feel achievable, motivating, and tailored to your life. Our Personal Training service focuses on building strength, confidence, and long‑term wellbeing through personalised workouts and supportive guidance.
                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Personal Training will be launching shortly as part of our expanded wellbeing support.
                        </p>
                        <p>
                            A Practical, Goal‑Focused Approach: Whether you’re new to exercise, returning after a break, or working toward a specific goal, your trainer creates a plan that fits your abilities, schedule, and lifestyle. Every session is designed to help you progress safely and consistently.
                        </p>
                        <p>
                            Support That Builds Momentum: Your trainer works with you to understand your goals, track your progress, and adjust your plan as your needs evolve. You’ll gain structure, motivation, and the tools to build lasting habits that improve your health and overall wellbeing.
                        </p>
                   </div>
                </div>
            </div>
        </div>
    </section>






    {{-- ============================================================ --}}
    {{-- PRE-REGISTER SECTION — Premium redesign                       --}}
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
                        Pre-Register an<br>
                        <span style="background:linear-gradient(90deg,#0f89a6,#14b8a6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">account!</span>
                    </h2>

                    {{-- Teal underline accent --}}
                    <div style="width:64px;height:4px;border-radius:2px;background:linear-gradient(90deg,#0f89a6,#14b8a6);margin-bottom:1.5rem;"></div>

                    <p style="color:#4b6a74;font-size:1.05rem;line-height:1.75;max-width:420px;" class="mb-8">
                      Our Personal Training services are on the way. Stay tuned for updates and get ready to transform your health and wellness with JustMy.Health.
                    </p>

                    {{-- Social proof avatars --}}
                    <div class="flex items-center gap-3">
                        <div style="display:flex;">
                            @foreach(['#0f89a6','#14b8a6','#facc15','#f97316'] as $i => $color)
                            <div style="width:38px;height:38px;border-radius:50%;border:2px solid #fff;
                                        background:{{ $color }};margin-left:{{ $loop->first ? '0' : '-10px' }};
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:0.7rem;font-weight:700;color:#fff;z-index:{{ 4 - $i }};">
                                {{ ['JD','AM','SK','PR'][$i] }}
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <span style="font-size:0.85rem;font-weight:700;color:#0c2830;">Join 200+ early members</span><br>
                            <span style="font-size:0.78rem;color:#6b8c96;">Pre-registrations are now open</span>
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
                            Why pre-register?
                        </p>
                        <h3 style="font-size:1.55rem;font-weight:800;color:#0c2830;margin-bottom:1.75rem;line-height:1.2;">
                            Pre-Register Today
                        </h3>

                        {{-- Benefits list --}}
                        <ul style="list-style:none;padding:0;margin:0 0 2rem;display:flex;flex-direction:column;gap:1rem;">
                            @foreach([
                                ['Early Access',         'Be among the first when we go live in October.'],
                                ['Exclusive Discounts',  'Pre-registered members receive launch pricing.'],
                                ['Priority Booking',     'Lock in your preferred session slots first.'],
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
                        <a href="{{ route('register') }}"
                           style="display:flex;align-items:center;justify-content:center;gap:0.5rem;
                                  background:linear-gradient(90deg,#0f89a6,#14b8a6);
                                  color:#fff;font-size:1rem;font-weight:700;
                                  padding:0.9rem 2rem;border-radius:999px;
                                  box-shadow:0 8px 25px -5px rgba(15,137,166,0.5);
                                  text-decoration:none;transition:transform 0.2s,box-shadow 0.2s;"
                           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 32px -5px rgba(15,137,166,0.6)';"
                           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 25px -5px rgba(15,137,166,0.5)';">
                            Register Now
                            <svg style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>

                        {{-- Subtle footnote --}}
                        <p style="text-align:center;font-size:0.75rem;color:#9bb5bc;margin-top:1rem;">
                            Free to register · No credit card required
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- COUNTDOWN TIMER — Launch: 31 Oct 2026 at 23:59  (REDESIGN)   --}}
    {{-- ============================================================ --}}
    <section id="pt-launch-countdown" class="relative py-24 overflow-hidden"
             style="background: radial-gradient(ellipse at 50% 0%, #0b2d3d 0%, #051420 60%, #030d14 100%);">

        {{-- Animated bokeh particles (pure CSS) --}}
        <div class="pt-particles" aria-hidden="true">
            <span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span>
        </div>

        {{-- Glow orbs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:600px;height:600px;border-radius:50%;
                        background:radial-gradient(circle, rgba(15,137,166,0.18) 0%, transparent 70%);
                        top:-180px;left:50%;transform:translateX(-50%);"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;
                        background:radial-gradient(circle, rgba(20,184,166,0.12) 0%, transparent 70%);
                        bottom:-100px;left:10%;"></div>
            <div style="position:absolute;width:300px;height:300px;border-radius:50%;
                        background:radial-gradient(circle, rgba(15,137,166,0.1) 0%, transparent 70%);
                        bottom:-60px;right:8%;"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 lg:px-12 text-center">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 mb-8 px-5 py-2 rounded-full text-xs font-bold uppercase tracking-[0.25em]"
                 style="background:rgba(15,137,166,0.15);border:1px solid rgba(15,137,166,0.4);color:#5ee7df;">
                <span style="width:6px;height:6px;border-radius:50%;background:#5ee7df;box-shadow:0 0 8px #5ee7df;display:inline-block;animation:ptPulse 1.5s ease-in-out infinite;"></span>
                Official Launch Countdown
            </div>

            {{-- Heading --}}
            <h2 class="font-extrabold text-white mb-3"
                style="font-size:clamp(1.9rem,4vw,3rem);letter-spacing:-0.02em;line-height:1.15;">
                Personal Training <span style="background:linear-gradient(90deg,#5ee7df,#38bdf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Launches In</span>
            </h2>
            <p style="color:rgba(255,255,255,0.5);font-size:1rem;max-width:480px;margin:0 auto 3.5rem;">
                Get ready to transform your health and wellness. Our expert-led Personal Training service is launching soon, offering tailored programs to help you reach your goals.
            </p>

            {{-- ---- Four circular ring timers ---- --}}
            <div id="pt-countdown-grid"
                 style="display:flex;justify-content:center;align-items:center;gap:clamp(12px,3vw,40px);flex-wrap:wrap;">

                {{-- DAYS --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div class="pt-ring-wrap" style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg class="pt-ring-svg" viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="pt-ring-days" cx="75" cy="75" r="65" fill="none"
                                    stroke="url(#ptGradD)" stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-dasharray="408.4" stroke-dashoffset="0"
                                    style="transition:stroke-dashoffset 0.8s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(94,231,223,0.7));"/>
                            <defs>
                                <linearGradient id="ptGradD" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#5ee7df"/>
                                    <stop offset="100%" stop-color="#38bdf8"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;
                                    background:radial-gradient(circle at 50% 40%,rgba(94,231,223,0.07),transparent 70%);
                                    border-radius:50%;">
                            <span id="pt-days" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;
                                                                      text-shadow:0 0 30px rgba(94,231,223,0.6);">49</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(94,231,223,0.55);">Days</span>
                </div>

                {{-- colon --}}
                <div class="pt-colon" style="font-size:clamp(1.6rem,4vw,2.5rem);font-weight:800;color:rgba(94,231,223,0.35);
                                             margin-bottom:14px;animation:ptBlink 1s step-end infinite;">:</div>

                {{-- HOURS --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div class="pt-ring-wrap" style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg class="pt-ring-svg" viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="pt-ring-hours" cx="75" cy="75" r="65" fill="none"
                                    stroke="url(#ptGradH)" stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-dasharray="408.4" stroke-dashoffset="0"
                                    style="transition:stroke-dashoffset 0.8s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(94,231,223,0.7));"/>
                            <defs>
                                <linearGradient id="ptGradH" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#5ee7df"/>
                                    <stop offset="100%" stop-color="#38bdf8"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;
                                    background:radial-gradient(circle at 50% 40%,rgba(94,231,223,0.07),transparent 70%);
                                    border-radius:50%;">
                            <span id="pt-hours" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;
                                                                       text-shadow:0 0 30px rgba(94,231,223,0.6);">00</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(94,231,223,0.55);">Hours</span>
                </div>

                {{-- colon --}}
                <div class="pt-colon" style="font-size:clamp(1.6rem,4vw,2.5rem);font-weight:800;color:rgba(94,231,223,0.35);
                                             margin-bottom:14px;animation:ptBlink 1s step-end infinite;">:</div>

                {{-- MINUTES --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div class="pt-ring-wrap" style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg class="pt-ring-svg" viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="pt-ring-minutes" cx="75" cy="75" r="65" fill="none"
                                    stroke="url(#ptGradM)" stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-dasharray="408.4" stroke-dashoffset="0"
                                    style="transition:stroke-dashoffset 0.8s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(94,231,223,0.7));"/>
                            <defs>
                                <linearGradient id="ptGradM" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#5ee7df"/>
                                    <stop offset="100%" stop-color="#38bdf8"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;
                                    background:radial-gradient(circle at 50% 40%,rgba(94,231,223,0.07),transparent 70%);
                                    border-radius:50%;">
                            <span id="pt-minutes" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;
                                                                         text-shadow:0 0 30px rgba(94,231,223,0.6);">00</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(94,231,223,0.55);">Minutes</span>
                </div>

                {{-- colon --}}
                <div class="pt-colon" style="font-size:clamp(1.6rem,4vw,2.5rem);font-weight:800;color:rgba(94,231,223,0.35);
                                             margin-bottom:14px;animation:ptBlink 1s step-end infinite;">:</div>

                {{-- SECONDS --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div class="pt-ring-wrap" style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg class="pt-ring-svg" viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="pt-ring-seconds" cx="75" cy="75" r="65" fill="none"
                                    stroke="url(#ptGradS)" stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-dasharray="408.4" stroke-dashoffset="0"
                                    style="transition:stroke-dashoffset 0.5s linear;filter:drop-shadow(0 0 8px rgba(250,204,21,0.8));"/>
                            <defs>
                                <linearGradient id="ptGradS" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#facc15"/>
                                    <stop offset="100%" stop-color="#f97316"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;
                                    background:radial-gradient(circle at 50% 40%,rgba(250,204,21,0.06),transparent 70%);
                                    border-radius:50%;">
                            <span id="pt-seconds" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;
                                                                         text-shadow:0 0 30px rgba(250,204,21,0.7);">00</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(250,204,21,0.5);">Seconds</span>
                </div>

            </div>



            {{-- Post-launch message --}}
            <div id="pt-launched-msg" class="hidden" style="margin-top:2.5rem;">
                <p style="font-size:1.3rem;font-weight:700;color:#5ee7df;animation:ptPulse 1.5s ease-in-out infinite;">
                    🎉 Personal Training is now LIVE!
                </p>
            </div>

        </div>

        {{-- Inline styles for particles + animations --}}
        <style>
        /* ---- Bokeh particles ---- */
        .pt-particles {
            position: absolute; inset: 0; overflow: hidden; pointer-events: none;
        }
        .pt-particles span {
            position: absolute;
            border-radius: 50%;
            background: rgba(94, 231, 223, 0.25);
            animation: ptFloat linear infinite;
        }
        .pt-particles span:nth-child(1)  { width:6px;  height:6px;  left:10%;  bottom:-20px; animation-duration:14s; animation-delay:0s;   }
        .pt-particles span:nth-child(2)  { width:4px;  height:4px;  left:22%;  bottom:-20px; animation-duration:18s; animation-delay:2s;   }
        .pt-particles span:nth-child(3)  { width:8px;  height:8px;  left:35%;  bottom:-20px; animation-duration:12s; animation-delay:4s;   }
        .pt-particles span:nth-child(4)  { width:5px;  height:5px;  left:50%;  bottom:-20px; animation-duration:20s; animation-delay:1s;   }
        .pt-particles span:nth-child(5)  { width:3px;  height:3px;  left:63%;  bottom:-20px; animation-duration:16s; animation-delay:3s;   background:rgba(56,189,248,0.3); }
        .pt-particles span:nth-child(6)  { width:7px;  height:7px;  left:75%;  bottom:-20px; animation-duration:11s; animation-delay:0.5s; }
        .pt-particles span:nth-child(7)  { width:4px;  height:4px;  left:88%;  bottom:-20px; animation-duration:15s; animation-delay:5s;   background:rgba(250,204,21,0.3);}
        .pt-particles span:nth-child(8)  { width:6px;  height:6px;  left:5%;   bottom:-20px; animation-duration:22s; animation-delay:6s;   }
        .pt-particles span:nth-child(9)  { width:3px;  height:3px;  left:42%;  bottom:-20px; animation-duration:13s; animation-delay:7s;   background:rgba(56,189,248,0.25);}
        .pt-particles span:nth-child(10) { width:5px;  height:5px;  left:58%;  bottom:-20px; animation-duration:17s; animation-delay:8s;   }
        .pt-particles span:nth-child(11) { width:4px;  height:4px;  left:80%;  bottom:-20px; animation-duration:19s; animation-delay:2.5s; background:rgba(250,204,21,0.25);}
        .pt-particles span:nth-child(12) { width:6px;  height:6px;  left:18%;  bottom:-20px; animation-duration:14s; animation-delay:9s;   }

        @keyframes ptFloat {
            0%   { transform: translateY(0) scale(1);   opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.6; }
            100% { transform: translateY(-100vh) scale(0.5); opacity: 0; }
        }
        @keyframes ptBlink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }
        @keyframes ptPulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.6; }
        }

        /* Number pop on change */
        .pt-num.pt-pop {
            animation: ptPop 0.3s cubic-bezier(.36,.07,.19,.97);
        }
        @keyframes ptPop {
            0%   { transform: scale(1); }
            40%  { transform: scale(1.18); }
            100% { transform: scale(1); }
        }
        </style>

    </section>

    <script>
    (function () {
        var CIRCUMFERENCE = 2 * Math.PI * 65; // ≈ 408.4

        var target = new Date(2026, 9, 31, 23, 59, 0);

        function pad(n) { return String(n).padStart(2, '0'); }

        function setRing(id, value, max) {
            var el = document.getElementById(id);
            if (!el) return;
            var fraction = Math.max(0, Math.min(1, value / max));
            el.style.strokeDashoffset = CIRCUMFERENCE * (1 - fraction);
        }

        function setNum(id, val) {
            var el = document.getElementById(id);
            if (!el) return;
            var s = pad(val);
            if (el.textContent !== s) {
                el.textContent = s;
                el.classList.remove('pt-pop');
                void el.offsetWidth; // reflow
                el.classList.add('pt-pop');
            }
        }

        function tick() {
            var now  = new Date();
            var diff = target - now;

            if (diff <= 0) {
                ['pt-days','pt-hours','pt-minutes','pt-seconds'].forEach(function(id){
                    document.getElementById(id).textContent = '00';
                });
                setRing('pt-ring-days',    0, 1);
                setRing('pt-ring-hours',   0, 1);
                setRing('pt-ring-minutes', 0, 1);
                setRing('pt-ring-seconds', 0, 1);
                document.getElementById('pt-launched-msg').classList.remove('hidden');
                return;
            }

            var totalSec = Math.floor(diff / 1000);
            var days    = Math.floor(totalSec / 86400);
            var hours   = Math.floor((totalSec % 86400) / 3600);
            var minutes = Math.floor((totalSec % 3600)  / 60);
            var seconds = totalSec % 60;

            setNum('pt-days',    days);
            setNum('pt-hours',   hours);
            setNum('pt-minutes', minutes);
            setNum('pt-seconds', seconds);

            // Max values for ring arcs
            // Days ring: fraction of the remaining days out of total days (fixed to show progress)
            // We'll use a rolling window: days ring relative to 365, hours/24, min/60, sec/60
            setRing('pt-ring-days',    days % 365,   365);
            setRing('pt-ring-hours',   hours,         24);
            setRing('pt-ring-minutes', minutes,        60);
            setRing('pt-ring-seconds', seconds,        60);

            setTimeout(tick, 1000);
        }

        tick();
    })();
    </script>

</x-app-layout>
