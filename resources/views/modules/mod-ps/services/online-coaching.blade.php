{{-- Online Therapy --}}
<x-app-layout>

<!-- Hero Section -->
<section class="relative h-80 flex items-start items-center pt-24 lg:pt-32" style="background: linear-gradient(135deg, #0a4a5c 0%, #1C9BA0 100%);">
    <div class="absolute inset-0" style="background: radial-gradient(circle at 75% 50%, rgba(255,255,255,0.07), transparent 60%), radial-gradient(circle at 15% 80%, rgba(0,0,0,0.18), transparent 50%);"></div>
    <div class="relative px-6 lg:px-20 max-w-4xl">
        <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md border border-white/20 px-5 py-2 rounded-full shadow-lg mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
            </svg>
            <span>Home</span>
            <span class="text-white/40">&rsaquo;</span>
            <span class="text-white font-semibold">Online Coaching</span>
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">Online Coaching </h1>
    </div>
</section>

<div class="container-fluid mx-auto bg-white min-h-screen">

    {{-- Intro Band --}}
    <div class="border-b border-[#d4f0ee] py-8 px-4 md:px-6 lg:px-20">
        <p class="max-w-4xl mx-auto text-center text-base leading-relaxed text-[#4b626b]">
            At JustMy.Health, we believe in the power of personalized therapy to help you achieve mental wellness and
            emotional balance. Our secure platform offers one-to-one therapy sessions tailored to your unique needs,
            ensuring you receive the support and guidance you deserve.
        </p>
    </div>

    {{-- Why Choose Us + Feature Cards --}}
    <section class="bg-gradient-to-b from-[#f0fbfa] to-white py-16">
        <div class="container mx-auto px-4 md:px-6 lg:px-12">

            {{-- Why grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center mb-14">
                <div class="overflow-hidden rounded-[20px] shadow-[0_20px_60px_-20px_rgba(28,155,160,0.28)]">
                    <img src="{{ asset('images/welcome-page/therapyjourney.png') }}" alt="Therapy Journey" class="w-full h-auto object-cover">
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0] mb-2">Our Promise</p>
                    <h2 class="mt-3 mb-5 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">Why Choose Us?</h2>
                    
                    <p class="text-gray-600 text-base leading-relaxed">
                        Our aim is to be one of the most outstanding online therapy provisions. We aim to match
                        you with a client within 15 minutes of you signing up. We understand that there can be long waiting
                        times to see a therapist — such experience can sometimes escalate the distress you are experiencing.
                        We further aim for you to be able to access therapy within two days of signing up. We work with you
                        according to your presenting issues, and therefore the best therapist is allocated to facilitate your needs.
                        We aim to have resources such as worksheets which will explain more about the issues you are experiencing.
                        Please know we have your interest at heart — use the accessible email to reach out if there is a complaint or concern.
                    </p>
                </div>
            </div>

            {{-- Feature Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                @foreach ([
                    ['emoji' => '🔐', 'icon' => 'authentication', 'title' => 'Secure User Authentication', 'desc' => 'Implement multi-factor authentication to protect user accounts.'],
                    ['emoji' => '🎭', 'icon' => 'anonymous',       'title' => 'Anonymous Profiles',          'desc' => 'Offer the option for clients to use anonymous profiles if they prefer.'],
                    ['emoji' => '💬', 'icon' => 'message',         'title' => 'Confidential Messaging',      'desc' => 'Use encrypted messaging systems for secure communication between therapists and clients.'],
                    ['emoji' => '🛡️', 'icon' => 'security',       'title' => 'Regular Security Audits',     'desc' => 'Conduct regular security audits and vulnerability assessments.'],
                    ['emoji' => '📋', 'icon' => 'compliance',      'title' => 'Compliance with Regulations', 'desc' => 'Adhere to HIPAA or GDPR standards for data protection and privacy.'],
                    ['emoji' => '📄', 'icon' => 'policies',        'title' => 'Transparent Policies',        'desc' => 'Make privacy policies and terms of service easily accessible and clear.'],
                    ['emoji' => '📅', 'icon' => 'schedule',        'title' => 'Private Scheduling',          'desc' => 'Integrate secure calendar systems for booking and managing appointments.'],
                    ['emoji' => '🚪', 'icon' => 'waiting-room',    'title' => 'Virtual Waiting Rooms',       'desc' => 'Use virtual waiting rooms to maintain session confidentiality.'],
                    ['emoji' => '📁', 'icon' => 'document',        'title' => 'Secure Document Sharing',     'desc' => 'Allow for the safe exchange of therapy notes and resources.'],
                    ['emoji' => '✅', 'icon' => 'verification',    'title' => 'Therapist Verification',      'desc' => 'Verify the credentials of therapists to ensure they are qualified professionals.'],
                ] as $card)
                <div class="flex items-start gap-4 bg-white border border-[#b2e0dc] rounded-2xl p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_12px_32px_-8px_rgba(28,155,160,0.18)]">
                    <div class="w-11 h-11 flex-shrink-0 rounded-[12px] flex items-center justify-center text-lg shadow-[0_6px_14px_-4px_rgba(28,155,160,0.35)]"
                         style="background: linear-gradient(135deg, #1C9BA0, #34c5bb);">
                        {{ $card['emoji'] }}
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-[#102f3a] mb-1">{{ $card['title'] }}</h3>
                        <p class="text-xs text-[#4b626b] leading-relaxed">{{ $card['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- Core Values --}}
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 md:px-6 lg:px-12">
            <div class="text-center mb-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0] mb-2">What We Stand For</p>
                <h2 class="mt-3 mb-5 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">Our Core Values</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ([
                    ['title' => 'RESPECT',         'desc' => 'We have great admiration for the effort that you have made in seeking help, valuing your worth, feelings and boundaries.',
                     'icon' => '<path d="M12 21C12 21 4 13.5 4 8.5a5 5 0 0 1 8-4 5 5 0 0 1 8 4c0 5-8 12.5-8 12.5z"/>'],
                    ['title' => 'COMMITMENT',      'desc' => 'We are dedicated to work professionally, skillfully and to communicate effectively.',
                     'icon' => '<polyline points="20 6 9 17 4 12"/>'],
                    ['title' => 'DIVERSITY',       'desc' => 'We value your differences of background, sexuality, age, religion, gender, ethnicity, physical ability and your experiences.',
                     'icon' => '<circle cx="9" cy="7" r="3"/><circle cx="15" cy="7" r="3"/><path d="M3 20c0-4 3-6 6-6"/><path d="M21 20c0-4-3-6-6-6"/>'],
                    ['title' => 'CLIENT FOCUS',   'desc' => 'Putting the client at the centre of the therapy, being present, understanding and focussing on the presenting needs.',
                     'icon' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>'],
                    ['title' => 'INTEGRITY',       'desc' => 'Being honest, trustworthy and having strong unwavering moral and ethical principles — doing the right thing even when difficult.',
                     'icon' => '<path d="M12 3l2.5 5.5L20 9.5l-4 4 1 5.5L12 16.5 7 19l1-5.5-4-4 5.5-1z"/>'],
                    ['title' => 'CONFIDENTIALITY','desc' => 'One of our most fundamental obligations — protecting private and sensitive information to build trust in professional relationships.',
                     'icon' => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>'],
                    ['title' => 'ACCOUNTABILITY', 'desc' => 'We are obligated to accept and demonstrate responsibility — a core principle in data protection and organisation governance.',
                     'icon' => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>'],
                    ['title' => 'INCLUSIVITY',    'desc' => 'All individuals are unique and welcome at JustMy.Health — valued, respected, with a sense of belonging for everyone.',
                     'icon' => '<circle cx="12" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/><path d="M12 7v4m0 0L6 18m6-7l6 11"/>'],
                ] as $card)
                <div class="relative overflow-hidden bg-white border border-[#b2e0dc] rounded-[18px] p-5 transition duration-200 hover:-translate-y-1 hover:shadow-[0_16px_36px_-10px_rgba(28,155,160,0.2)]">
                    {{-- Top accent bar --}}
                    <div class="absolute top-0 left-0 right-0 h-[3px] rounded-t-[18px]" style="background: linear-gradient(90deg, #1C9BA0, #34c5bb);"></div>
                    {{-- Icon --}}
                    <div class="w-11 h-11 rounded-[12px] flex items-center justify-center mb-4 shadow-[0_6px_14px_-4px_rgba(28,155,160,0.35)]"
                         style="background: linear-gradient(135deg, #1C9BA0, #34c5bb);">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            {!! $card['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-[#102f3a] ">{{ $card['title'] }}</h3>
                    <p class="text-xs text-[#4b626b] leading-relaxed">{{ $card['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Pricing --}}
    <section class="w-full bg-gradient-to-b from-[#f0fbfa] to-[#e8f8f7] py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            {{-- Left Text --}}
            <div class="lg:col-span-2 space-y-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#1C9BA0]">Investment in Your Wellbeing</p>
                <h2 class="mt-3 mb-5 text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-5xl">Therapy Process &amp; Cost</h2>
                
                <p class="text-gray-600 leading-relaxed">Therapy is an iterative process which encompasses multiple sessions arranged at a defined frequency to allow time to absorb, adjust, and benefit.</p>
                <p class="text-gray-600 leading-relaxed">To minimize costs, we provide therapy sessions as monthly blocks containing <span class="font-semibold text-[#102f3a]">four sessions</span>.</p>
                <p class="text-gray-600 leading-relaxed">The cost of therapy ranges from <span class="font-semibold text-[#1C9BA0]">&pound;50 to &pound;70 per week</span> (billed every 4 weeks). Variation depends on location, type of therapy, preferences, and therapist availability.</p>
                <p class="text-gray-600 leading-relaxed">You can cancel your membership at any time, for any reason.</p>
            </div>

            {{-- Pricing Card --}}
            <div class="bg-white rounded-[20px] border border-[#b2e0dc] shadow-[0_20px_60px_-20px_rgba(28,155,160,0.22)] overflow-hidden">
                <div class="px-6 py-6 text-center" style="background: linear-gradient(135deg, #1C9BA0, #0b7087);">
                    <p class="text-2xl font-bold text-white">&pound;50 – &pound;70</p>
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

</div>

</x-app-layout>