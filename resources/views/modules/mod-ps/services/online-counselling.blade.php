{{-- Online Counselling --}}

@section('title', 'PUB: Online Counselling')

<x-app-layout>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        .oc-page { font-family: 'Inter', sans-serif; }
        .oc-page .oc-display {
            font-family: 'Fraunces', serif;
            font-optical-sizing: auto;
            letter-spacing: -0.01em;
        }
        .oc-page .oc-eyebrow {
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.18em;
        }
    </style>

    <div class="oc-page">

        <!-- Hero Section -->
        <section class="relative h-80 flex items-start lg:items-center pt-24 lg:pt-32">
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>
            </div>

            <div class="px-6 lg:px-20 max-w-4xl">
                <!-- Breadcrumb -->
                <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                    </svg>
                    <span>Home</span>
                    <span class="text-white/60">&rsaquo;</span>
                    <span class="text-white font-semibold">Online Counselling</span>
                </div>

                <!-- Page Title -->
                <h1 class="oc-display text-4xl lg:text-5xl font-medium text-white mb-4">
                    Online Counselling
                </h1>
            </div>
        </section>

        <!-- Navbar is in layouts/app.blade.php -->

        <!-- Opening statement -->
        <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-16 md:py-24">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="max-w-3xl mx-auto text-center">
                    <p class="oc-eyebrow mb-6 inline-flex text-xs font-semibold uppercase text-[#0f89a6]">
                        JustMy.Health &middot; Counselling
                    </p>
                    <h2 class="oc-display text-3xl sm:text-4xl font-medium leading-tight mb-8 text-[#102f3a]">
                        Online Counselling to boost wellbeing
                    </h2>
                    <div class="space-y-5 text-lg leading-8 text-[#4b626b]">
                        <p>
                            Online counselling gives you a safe, supportive space to talk through what&rsquo;s on your mind and get practical guidance for everyday challenges.
                        </p>
                        <p>
                            Whether you&rsquo;re dealing with stress, relationship difficulties, grief, low mood, or emotional overwhelm, counselling helps you understand your thoughts and feelings and move toward healthier patterns and emotional stability.
                        </p>
                        <p>
                            Together, you explore what&rsquo;s affecting your wellbeing and develop tools you can use in real life, from managing stress to improving communication and building emotional resilience.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{--
            Signature element: a connected "journey thread" running through the
            four stages a client actually moves through, in order — this is a
            real sequence (understand what to expect, get matched, feel safe,
            find a rhythm), so numbering it encodes something true instead of
            decorating an arbitrary list. Echoes the "therapy journey" image
            used later on the page.
        --}}
        <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-16 md:py-24">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="max-w-3xl mx-auto mb-14 text-center">
                    <p class="oc-eyebrow mb-4 text-xs font-semibold uppercase text-[#0f89a6]">Your Journey</p>
                    <h2 class="oc-display text-3xl sm:text-4xl font-medium leading-tight text-[#102f3a]">
                        From first message to lasting change
                    </h2>
                </div>

                <div class="relative max-w-2xl mx-auto">
                    <!-- connecting thread -->
                    <div class="absolute left-7 top-2 bottom-2 w-px bg-[#9ed9d7]"></div>

                    <div class="space-y-14">

                        <!-- Step 01 -->
                        <div class="relative pl-20">
                            <span class="oc-display absolute left-0 top-0 flex h-14 w-14 items-center justify-center rounded-full text-lg font-medium bg-white border border-[#9ed9d7] text-[#0f89a6]">01</span>
                            <h3 class="oc-display text-2xl font-medium mb-3 text-[#102f3a]">What You Can Expect</h3>
                            <div class="space-y-4 text-base leading-7 text-[#243b45]">
                                <p>
                                    Online counselling gives you a private, supportive space to explore what you&rsquo;re feeling and understand what&rsquo;s affecting your wellbeing.
                                </p>
                                <p>
                                    Your Therapeutic Practitioner works with you to identify patterns, clarify your thoughts, and build practical tools you can use in everyday life, whether you&rsquo;re navigating stress, relationship challenges, grief, or emotional overwhelm.
                                </p>
                                <p>
                                    Providing lifelong tools that you can use when your encounter future life challenges.
                                </p>
                            </div>
                        </div>

                        <!-- Step 02 -->
                        <div class="relative pl-20">
                            <span class="oc-display absolute left-0 top-0 flex h-14 w-14 items-center justify-center rounded-full text-lg font-medium bg-white border border-[#9ed9d7] text-[#0f89a6]">02</span>
                            <h3 class="oc-display text-2xl font-medium mb-3 text-[#102f3a]">Your Counsellor, Matched to Your Needs</h3>
                            <div class="space-y-4 text-base leading-7 text-[#243b45]">
                                <p>
                                    We match you with a suitable Therapeutic Practitioner based on your presenting issues and preferences, ensuring you receive the right support from the very beginning.
                                </p>
                                <p>
                                    Our aim is to connect you with the right practitioner quickly, so you can start your journey without long waiting times.
                                </p>
                            </div>
                        </div>

                        <!-- Step 03 -->
                        <div class="relative pl-20">
                            <span class="oc-display absolute left-0 top-0 flex h-14 w-14 items-center justify-center rounded-full text-lg font-medium bg-white border border-[#9ed9d7] text-[#0f89a6]">03</span>
                            <h3 class="oc-display text-2xl font-medium mb-3 text-[#102f3a]">A Safe, Confidential Space</h3>
                            <div class="space-y-4 text-base leading-7 text-[#243b45]">
                                <p>
                                    Your privacy is central to the therapeutic process. Sessions take place in a secure environment with encrypted communication, verified practitioners, and strict confidentiality standards, helping you feel safe, supported, and in control from the onset of the relationship.
                                </p>
                            </div>
                        </div>

                        <!-- Step 04 -->
                        <div class="relative pl-20">
                            <span class="oc-display absolute left-0 top-0 flex h-14 w-14 items-center justify-center rounded-full text-lg font-medium bg-white border border-[#9ed9d7] text-[#0f89a6]">04</span>
                            <h3 class="oc-display text-2xl font-medium mb-3 text-[#102f3a]">Support That Fits Your Life</h3>
                            <div class="space-y-4 text-base leading-7 text-[#243b45]">
                                <p>
                                    Counselling is flexible and designed around you. Whether you prefer structured weekly sessions or a gentler pace, your practitioner works with you to create a rhythm that supports your growth and emotional balance.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- About statement -->
        <section class="bg-white py-16 md:py-20">
            <div class="container mx-auto px-6 lg:px-12">
                <p class="oc-display max-w-3xl mx-auto text-center text-xl sm:text-2xl leading-relaxed italic text-[#102f3a]">
                    &ldquo;At JustMy.Health, we believe in the power of personalised counselling to help you achieve mental wellness and
                    emotional balance. Our secure platform offers one-to-one counselling sessions tailored to your needs,
                    ensuring you receive the support and guidance you deserve.&rdquo;
                </p>
            </div>
        </section>

        {{-- Pricing (unchanged card design) --}}
        <section class="w-full bg-gradient-to-b from-[#f0fbfa] to-[#e8f8f7] py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

                {{-- Left Text --}}
                <div class="lg:col-span-2 space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Investment in Your Wellbeing</p>
                    <h2 class="mt-3 mb-5 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-4xl">Counselling Process &amp; Cost</h2>

                    <p class="text-gray-600 leading-relaxed">Counseling is an iterative process which encompasses multiple sessions arranged at a defined frequency to allow time to absorb, adjust, and benefit.</p>
                    <p class="text-gray-600 leading-relaxed">To minimise costs, we provide counselling sessions as monthly blocks containing <span class="font-semibold text-[#102f3a]">four sessions</span>.</p>
                    <p class="text-gray-600 leading-relaxed">The cost of counselling ranges from <span class="font-semibold text-[#1C9BA0]">&pound;50 to &pound;70 per week</span> (billed every 4 weeks). Variation depends on location, type of therapy, preferences, and therapist availability.</p>
                    <p class="text-gray-600 leading-relaxed">You can cancel your membership at any time, for any reason.</p>
                </div>

                {{-- Pricing Card --}}
                <div class="bg-white rounded-[20px] border border-[#b2e0dc] shadow-[0_20px_60px_-20px_rgba(28,155,160,0.22)] overflow-hidden">
                    <div class="px-6 py-6 text-center" style="background: linear-gradient(135deg, #1C9BA0, #0b7087);">
                        <p class="text-2xl font-bold text-white">&pound;50 &ndash; &pound;70</p>
                        <p class="text-sm text-white/70 mt-1">per weekly session</p>
                    </div>
                    <div class="px-6 py-6">
                        <ul class="space-y-3 mb-6">
                            @foreach(['End-to-End Encryption','Confidential Messaging','Private Scheduling','Secure Document Sharing','Session Recording Controls','Emergency Support','Virtual Waiting Rooms','Therapist Verification'] as $feature)
                                <li class="flex items-center gap-3 text-sm text-[#4b626b]">
                            <span class="w-5 h-5 flex-shrink-0 rounded-full bg-[#e0f8f6] flex items-center justify-center">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="#1C9BA0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                            </span>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('login') }}"
                           class="block w-full text-center text-sm font-semibold text-white rounded-xl py-3 transition duration-200"
                           style="background: #1C9BA0;"
                           onmouseover="this.style.background='#157c81'" onmouseout="this.style.background='#1C9BA0'">
                            Login or Register to view Availability
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Process / closing image section -->
        <section class="bg-gradient-to-b from-[#f0fbfa] to-white py-16 md:py-20">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="overflow-hidden rounded-[20px] shadow-[0_20px_60px_-20px_rgba(28,155,160,0.28)]">
                        <img src="{{ asset('images/welcome-page/therapyjourney.png') }}" alt="Therapy Journey" class="w-full h-auto object-cover">
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0] mb-2">Our Process</p>
                        <h2 class="oc-display mt-3 mb-5 text-3xl font-medium leading-tight text-[#102f3a] sm:text-4xl">Engage and Benefit</h2>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Counselling helps you make sense of your thoughts and emotions, build resilience, and take steps toward a healthier, more balanced life, at your pace, in your way.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>

</x-app-layout>