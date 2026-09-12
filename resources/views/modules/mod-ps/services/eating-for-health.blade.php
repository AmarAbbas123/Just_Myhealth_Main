<x-app-layout title="Dietitian & Healthy Eating (PUB) | JustMy.Health" metaDescription="JustMy.Health Dietitian & Healthy Eating Overview Page.">

    <!-- Premium Hero Section -->
    <section class="relative min-h-[26rem] flex items-center pt-24 pb-4 overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.jpg') }}"
                 alt="Dietitian & Healthy Eating Hero Background"
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
                    <span class="text-white font-semibold">Dietitian &amp; Healthy Eating</span>
                </div>

                <!-- Page Title -->
                <h1 class="text-5xl lg:text-5xl font-extrabold text-white tracking-tight mb-4" style="line-height:1.1;">
                    Dietitian &amp; Healthy Eating<br>
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


    {{-- Descriptive Section --}}
    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Dietitian
                    </p>
                    <h2 class="max-w-xl text-2xl font-semibold leading-tight text-[#102f3a] sm:text-3xl md:text-4xl">
                        Healthy Eating Guidance Designed Around You
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Healthy eating isn't about strict rules or complicated diets, it's about understanding your body, your habits, and the choices that support long-term wellbeing.
                    </p>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Our Dietitian service helps you build a healthier relationship with food through personalised guidance, practical strategies, and ongoing support tailored to your lifestyle.
                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Dietitian and Healthy Eating will be launching shortly as part of our expanded wellbeing support.
                        </p>
                        <p>
                            A healthier relationship with food starts with understanding what your body truly needs. Your Dietitian helps you cut through the noise of conflicting nutrition advice and focus on what works for you. Together, you'll explore your current habits, identify simple improvements, and build confidence in making choices that support your energy, mood, and long-term wellbeing.
                        </p>
                        <p>
                            Every plan is personalised and practical. Instead of restrictive diets or one-size-fits-all rules, your Dietitian creates guidance that fits your lifestyle, culture, and daily routine. Whether you're managing a health condition, working toward a specific goal, or simply wanting to feel better day-to-day, you'll receive clear steps you can start using immediately.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- PRE-REGISTER SECTION --}}
    <section id="efh-pre-register"
             class="relative overflow-hidden py-20 lg:py-28"
             style="background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 45%, #ecfeff 100%);">

        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:500px;height:500px;border-radius:50%;
                        background:radial-gradient(circle,rgba(20,184,166,0.12) 0%,transparent 70%);
                        top:-150px;left:-100px;"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;
                        background:radial-gradient(circle,rgba(15,137,166,0.08) 0%,transparent 70%);
                        bottom:-120px;right:-80px;"></div>
            <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:0.035;" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="efhDots" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="#0f89a6"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#efhDots)"/>
            </svg>
        </div>

        <div class="relative z-10 container mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center max-w-6xl mx-auto">

                {{-- LEFT --}}
                <div>
                    <h2 style="font-size:clamp(2rem,4.5vw,3.2rem);font-weight:800;color:#0c2830;letter-spacing:-0.025em;line-height:1.12;" class="mb-4">
                        Pre-Register an<br>
                        <span style="background:linear-gradient(90deg,#0f89a6,#14b8a6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">account!</span>
                    </h2>
                    <div style="width:64px;height:4px;border-radius:2px;background:linear-gradient(90deg,#0f89a6,#14b8a6);margin-bottom:1.5rem;"></div>
                    <p style="color:#4b6a74;font-size:1.05rem;line-height:1.75;max-width:420px;" class="mb-8">
                        Our Dietitian &amp; Healthy Eating services are on the way. Stay tuned for updates and get ready to transform your health and wellness with JustMy.Health.
                    </p>
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

                {{-- RIGHT — Card --}}
                <div class="relative">
                    <div style="position:absolute;inset:-1px;border-radius:1.5rem;background:linear-gradient(135deg,rgba(15,137,166,0.2),rgba(20,184,166,0.15),transparent);filter:blur(20px);z-index:0;"></div>
                    <div style="position:relative;z-index:1;background:#ffffff;border:1px solid rgba(15,137,166,0.15);
                                border-radius:1.5rem;padding:2.5rem;
                                box-shadow:0 25px 60px -15px rgba(15,137,166,0.2),0 10px 30px -10px rgba(0,0,0,0.06);">
                        <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#0f89a6;margin-bottom:0.75rem;">Why pre-register?</p>
                        <h3 style="font-size:1.55rem;font-weight:800;color:#0c2830;margin-bottom:1.75rem;line-height:1.2;">Pre-Register Today</h3>
                        <ul style="list-style:none;padding:0;margin:0 0 2rem;display:flex;flex-direction:column;gap:1rem;">
                            @foreach([
                                ['Early Access',        'Be among the first when we go live.'],
                                ['Exclusive Discounts', 'Pre-registered members receive launch pricing.'],
                                ['Priority Booking',    'Lock in your preferred session slots first.'],
                            ] as [$title, $desc])
                            <li style="display:flex;align-items:flex-start;gap:0.9rem;">
                                <span style="flex-shrink:0;width:24px;height:24px;border-radius:50%;background:linear-gradient(135deg,#0f89a6,#14b8a6);display:flex;align-items:center;justify-content:center;margin-top:2px;">
                                    <svg style="width:13px;height:13px;fill:none;stroke:#fff;stroke-width:2.5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <span style="font-size:0.9rem;font-weight:700;color:#0c2830;display:block;">{{ $title }}</span>
                                    <span style="font-size:0.82rem;color:#6b8c96;line-height:1.5;">{{ $desc }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('register') }}"
                           style="display:flex;align-items:center;justify-content:center;gap:0.5rem;
                                  background:linear-gradient(90deg,#0f89a6,#14b8a6);color:#fff;font-size:1rem;font-weight:700;
                                  padding:0.9rem 2rem;border-radius:999px;box-shadow:0 8px 25px -5px rgba(15,137,166,0.5);
                                  text-decoration:none;transition:transform 0.2s,box-shadow 0.2s;"
                           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 32px -5px rgba(15,137,166,0.6)';"
                           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 25px -5px rgba(15,137,166,0.5)';">
                            Register Now
                            <svg style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <p style="text-align:center;font-size:0.75rem;color:#9bb5bc;margin-top:1rem;">Free to register · No credit card required</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- COUNTDOWN TIMER --}}
    <section id="efh-launch-countdown" class="relative py-24 overflow-hidden"
             style="background: radial-gradient(ellipse at 50% 0%, #0b2d3d 0%, #051420 60%, #030d14 100%);">

        <div class="pt-particles" aria-hidden="true">
            <span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span>
        </div>

        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle, rgba(15,137,166,0.18) 0%, transparent 70%);top:-180px;left:50%;transform:translateX(-50%);"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle, rgba(20,184,166,0.12) 0%, transparent 70%);bottom:-100px;left:10%;"></div>
            <div style="position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle, rgba(15,137,166,0.1) 0%, transparent 70%);bottom:-60px;right:8%;"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 lg:px-12 text-center">

            <div class="inline-flex items-center gap-2 mb-8 px-5 py-2 rounded-full text-xs font-bold uppercase tracking-[0.25em]"
                 style="background:rgba(15,137,166,0.15);border:1px solid rgba(15,137,166,0.4);color:#5ee7df;">
                <span style="width:6px;height:6px;border-radius:50%;background:#5ee7df;box-shadow:0 0 8px #5ee7df;display:inline-block;animation:ptPulse 1.5s ease-in-out infinite;"></span>
                Official Launch Countdown
            </div>

            <h2 class="font-extrabold text-white mb-3"
                style="font-size:clamp(1.9rem,4vw,3rem);letter-spacing:-0.02em;line-height:1.15;">
                Dietitian &amp; Healthy Eating <span style="background:linear-gradient(90deg,#5ee7df,#38bdf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Launches In</span>
            </h2>
            <p style="color:rgba(255,255,255,0.5);font-size:1rem;max-width:480px;margin:0 auto 3.5rem;">
                Get ready to transform your relationship with food. Our expert-led Dietitian service is launching soon, offering personalised guidance to help you reach your goals.
            </p>

            <div id="efh-countdown-grid"
                 style="display:flex;justify-content:center;align-items:center;gap:clamp(12px,3vw,40px);flex-wrap:wrap;">

                {{-- DAYS --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="efh-ring-days" cx="75" cy="75" r="65" fill="none" stroke="url(#efhGradD)" stroke-width="6" stroke-linecap="round" stroke-dasharray="408.4" stroke-dashoffset="0" style="transition:stroke-dashoffset 0.8s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(94,231,223,0.7));"/>
                            <defs><linearGradient id="efhGradD" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#5ee7df"/><stop offset="100%" stop-color="#38bdf8"/></linearGradient></defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;border-radius:50%;">
                            <span id="efh-days" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;text-shadow:0 0 30px rgba(94,231,223,0.6);">49</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(94,231,223,0.55);">Days</span>
                </div>

                <div class="pt-colon" style="font-size:clamp(1.6rem,4vw,2.5rem);font-weight:800;color:rgba(94,231,223,0.35);margin-bottom:14px;animation:ptBlink 1s step-end infinite;">:</div>

                {{-- HOURS --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="efh-ring-hours" cx="75" cy="75" r="65" fill="none" stroke="url(#efhGradH)" stroke-width="6" stroke-linecap="round" stroke-dasharray="408.4" stroke-dashoffset="0" style="transition:stroke-dashoffset 0.8s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(94,231,223,0.7));"/>
                            <defs><linearGradient id="efhGradH" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#5ee7df"/><stop offset="100%" stop-color="#38bdf8"/></linearGradient></defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;border-radius:50%;">
                            <span id="efh-hours" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;text-shadow:0 0 30px rgba(94,231,223,0.6);">00</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(94,231,223,0.55);">Hours</span>
                </div>

                <div class="pt-colon" style="font-size:clamp(1.6rem,4vw,2.5rem);font-weight:800;color:rgba(94,231,223,0.35);margin-bottom:14px;animation:ptBlink 1s step-end infinite;">:</div>

                {{-- MINUTES --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="efh-ring-minutes" cx="75" cy="75" r="65" fill="none" stroke="url(#efhGradM)" stroke-width="6" stroke-linecap="round" stroke-dasharray="408.4" stroke-dashoffset="0" style="transition:stroke-dashoffset 0.8s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(94,231,223,0.7));"/>
                            <defs><linearGradient id="efhGradM" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#5ee7df"/><stop offset="100%" stop-color="#38bdf8"/></linearGradient></defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;border-radius:50%;">
                            <span id="efh-minutes" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;text-shadow:0 0 30px rgba(94,231,223,0.6);">00</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(94,231,223,0.55);">Minutes</span>
                </div>

                <div class="pt-colon" style="font-size:clamp(1.6rem,4vw,2.5rem);font-weight:800;color:rgba(94,231,223,0.35);margin-bottom:14px;animation:ptBlink 1s step-end infinite;">:</div>

                {{-- SECONDS --}}
                <div class="pt-unit" style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                    <div style="position:relative;width:clamp(110px,16vw,150px);height:clamp(110px,16vw,150px);">
                        <svg viewBox="0 0 150 150" style="position:absolute;inset:0;width:100%;height:100%;transform:rotate(-90deg);">
                            <circle cx="75" cy="75" r="65" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                            <circle id="efh-ring-seconds" cx="75" cy="75" r="65" fill="none" stroke="url(#efhGradS)" stroke-width="6" stroke-linecap="round" stroke-dasharray="408.4" stroke-dashoffset="0" style="transition:stroke-dashoffset 0.5s linear;filter:drop-shadow(0 0 8px rgba(250,204,21,0.8));"/>
                            <defs><linearGradient id="efhGradS" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#facc15"/><stop offset="100%" stop-color="#f97316"/></linearGradient></defs>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;border-radius:50%;">
                            <span id="efh-seconds" class="pt-num" style="font-size:clamp(2rem,5vw,2.8rem);font-weight:800;color:#fff;letter-spacing:-0.02em;line-height:1;text-shadow:0 0 30px rgba(250,204,21,0.7);">00</span>
                        </div>
                    </div>
                    <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(250,204,21,0.5);">Seconds</span>
                </div>

            </div>

            <div id="efh-launched-msg" class="hidden" style="margin-top:2.5rem;">
                <p style="font-size:1.3rem;font-weight:700;color:#5ee7df;animation:ptPulse 1.5s ease-in-out infinite;">
                    🎉 Dietitian & Healthy Eating is now LIVE!
                </p>
            </div>

        </div>
    </section>

    <script>
    (function () {
        var CIRCUMFERENCE = 2 * Math.PI * 65;
        var target = new Date(2026, 9, 31, 23, 59, 0);
        function pad(n) { return String(n).padStart(2, '0'); }
        function setRing(id, value, max) {
            var el = document.getElementById(id);
            if (!el) return;
            el.style.strokeDashoffset = CIRCUMFERENCE * (1 - Math.max(0, Math.min(1, value / max)));
        }
        function setNum(id, val) {
            var el = document.getElementById(id);
            if (!el) return;
            var s = pad(val);
            if (el.textContent !== s) {
                el.textContent = s;
                el.classList.remove('pt-pop');
                void el.offsetWidth;
                el.classList.add('pt-pop');
            }
        }
        function tick() {
            var diff = target - new Date();
            if (diff <= 0) {
                ['efh-days','efh-hours','efh-minutes','efh-seconds'].forEach(function(id){ document.getElementById(id).textContent = '00'; });
                ['efh-ring-days','efh-ring-hours','efh-ring-minutes','efh-ring-seconds'].forEach(function(id){ setRing(id, 0, 1); });
                document.getElementById('efh-launched-msg').classList.remove('hidden');
                return;
            }
            var totalSec = Math.floor(diff / 1000);
            var days    = Math.floor(totalSec / 86400);
            var hours   = Math.floor((totalSec % 86400) / 3600);
            var minutes = Math.floor((totalSec % 3600)  / 60);
            var seconds = totalSec % 60;
            setNum('efh-days', days);    setRing('efh-ring-days',    days % 365, 365);
            setNum('efh-hours', hours);  setRing('efh-ring-hours',   hours,       24);
            setNum('efh-minutes', minutes); setRing('efh-ring-minutes', minutes,   60);
            setNum('efh-seconds', seconds); setRing('efh-ring-seconds', seconds,   60);
            setTimeout(tick, 1000);
        }
        tick();
    })();
    </script>

</x-app-layout>
