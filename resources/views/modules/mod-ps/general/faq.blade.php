{{-- resources/views/faq.blade.php --}}
<x-app-layout>

    @php
    // Default icons for FAQs
    $faqIcons = [
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3v4h6v-4c0-1.657-1.343-3-3-3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 4a8 8 0 100 16 8 8 0 000-16z" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1112 21v-5" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12v4m0 0v4m0-4h4m-4 0H8" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-12.728 12.728" /><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636l12.728 12.728" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8M8 8v8M12 4v16" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M12 4h9M3 12h18" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" /></svg>',
    ];
    @endphp

    {{-- ═══════════════ INLINE STYLES ═══════════════ --}}
    <style>
        /* ── Google Font ── */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        .faq-page * { font-family: 'Inter', sans-serif; }

        /* ── Hero ── */
        .faq-hero {
            position: relative;
            min-height: 280px;
            display: flex;
            align-items: flex-start;
            padding-top: 4rem;
            padding-bottom: 2rem;
            overflow: hidden;
        }
        @media (min-width: 640px) {
            .faq-hero {
                min-height: 300px;
                padding-top: 5rem;
                padding-bottom: 2.5rem;
            }
        }
        @media (min-width: 1024px) {
            .faq-hero {
                min-height: 320px;
                align-items: center;
                padding-top: 8rem;
                padding-bottom: 3.5rem;
            }
        }

        /* Breadcrumb pill */
        .faq-breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
            padding: 0.35rem 1rem;
            border-radius: 999px;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.85);
            margin-bottom: 1rem;
        }
        @media (min-width: 640px) {
            .faq-breadcrumb {
                font-size: 0.8rem;
                margin-bottom: 1.5rem;
            }
        }

        /* ── Intro Feature Cards ── */
        .faq-intro {
            position: relative;
            overflow: hidden;
            padding: 5rem 0;
            background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 45%, #ecfeff 100%);
        }

        /* white card */
        .faq-feature-card {
            background: #ffffff;
            border: 1.5px solid #e5edf0;
            border-radius: 18px;
            padding: 26px 24px 28px;
            text-align: left;
            box-shadow: 0 2px 14px rgba(0,0,0,0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .faq-feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 32px rgba(11,112,135,0.12);
            border-color: #a5d8d8;
        }
        .faq-feature-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .faq-feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0b7087, #14b8a6);
            color: #ffffff;
            box-shadow: 0 4px 14px -4px rgba(11,112,135,0.4);
            flex-shrink: 0;
            margin-bottom: 0;
        }
        .faq-feature-label {
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
        .faq-feature-card h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px;
            line-height: 1.3;
        }
        .faq-feature-card p {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        /* ── FAQ Accordion Section ── */
        .faq-section {
            background: #ffffff;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 768px) {
            .faq-section {
                padding: 6rem 0;
            }
        }

        .faq-header-wrapper {
            position: relative;
            text-align: center;
            margin-bottom: 3rem;
        }
        @media (min-width: 768px) {
            .faq-header-wrapper {
                margin-bottom: 4rem;
            }
        }
        .faq-header-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: clamp(2rem, 8vw, 5rem);
            font-weight: 800;
            color: rgba(0,0,0,0.03);
            white-space: nowrap;
            z-index: 0;
            pointer-events: none;
        }
        .faq-header-content {
            position: relative;
            z-index: 1;
        }
        .faq-header-content h2 {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        .faq-header-content p {
            font-size: 1rem;
            color: #109b91;
            font-weight: 500;
            margin: 0;
        }

        /* ── Left Column: Accordion ── */
        .faq-layout-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: start;
        }
        @media (min-width: 768px) {
            .faq-layout-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
        }
        @media (min-width: 1024px) {
            .faq-layout-grid {
                grid-template-columns: 1.3fr 1fr; /* Approx 55% and 45% */
                gap: 4rem;
            }
        }

        .faq-accordion-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .faq-accordion-item {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .faq-accordion-item:hover {
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.1);
            transform: translateY(-2px);
        }
        .faq-accordion-trigger {
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            text-align: left;
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .faq-accordion-trigger {
                padding: 1.25rem 1.5rem;
            }
        }
        .faq-trigger-question {
            font-size: 0.9rem;
            font-weight: 500;
            color: #475569;
            line-height: 1.5;
        }
        @media (min-width: 768px) {
            .faq-trigger-question {
                font-size: 0.95rem;
            }
        }
        .faq-chevron {
            flex-shrink: 0;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #0b877d 0%, #15c3b2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            transition: transform 0.3s ease;
        }
        @media (min-width: 768px) {
            .faq-chevron {
                width: 1.75rem;
                height: 1.75rem;
            }
        }
        .faq-accordion-item.is-open .faq-chevron {
            transform: rotate(135deg);
        }
        .faq-accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease;
            opacity: 0;
        }
        .faq-accordion-body.is-open {
            max-height: 600px;
            opacity: 1;
        }
        .faq-accordion-body-inner {
            padding: 0 1.25rem 1.25rem 1.25rem;
        }
        @media (min-width: 768px) {
            .faq-accordion-body-inner {
                padding: 0 1.5rem 1.5rem 1.5rem;
            }
        }
        .faq-accordion-body-inner p {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }
        @media (min-width: 768px) {
            .faq-accordion-body-inner p {
                font-size: 0.9rem;
            }
        }

        /* Pagination dots/arrows */
        .faq-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        .faq-nav-btn {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #0b877d 0%, #15c3b2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            border: none;
            transition: opacity 0.3s ease, transform 0.2s ease;
        }
        .faq-nav-btn:hover:not(:disabled) { transform: scale(1.05); }
        .faq-nav-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        /* ── Right Column: Form Area ── */
        .faq-contact-area {
            text-align: center;
            padding: 1.5rem 1rem;
        }
        @media (min-width: 768px) {
            .faq-contact-area {
                padding: 1rem 2rem;
            }
        }
        .faq-contact-img {
            max-width: 240px;
            margin: 0 auto 1.5rem;
        }
        @media (min-width: 768px) {
            .faq-contact-img {
                max-width: 280px;
                margin: 0 auto 2rem;
            }
        }
        .faq-contact-area h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        @media (min-width: 768px) {
            .faq-contact-area h3 {
                font-size: 1.75rem;
            }
        }
        .faq-contact-area p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 768px) {
            .faq-contact-area p {
                font-size: 0.9rem;
                margin-bottom: 2rem;
            }
        }
        .faq-form-group {
            text-align: left;
            margin-bottom: 2rem;
        }
        .faq-form-label {
            display: block;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }
        .faq-input-wrapper {
            position: relative;
        }
        .faq-input {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            font-size: 0.95rem;
            color: #334155;
            outline: none;
            transition: border-color 0.3s;
        }
        .faq-input:focus {
            border-color: #15c3b2;
        }
        .faq-input-clear {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .faq-gradient-btn {
            background: linear-gradient(to right, #118b96 0%, #1bc4a6 100%);
            color: white;
            border: none;
            border-radius: 999px;
            padding: 0.85rem 3rem;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 25px rgba(27, 196, 166, 0.35);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
        }
        .faq-gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(27, 196, 166, 0.45);
        }

        /* ── CTA Section ── */
        .faq-cta { background: #f8fafc; padding: 5rem 0; position: relative; overflow: hidden; }

        /* Glow ring for form card */
        .faq-form-card {
            border-radius: 1.5rem;
            background: #fff;
            padding: 2rem 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08), 0 0 0 1px rgba(28,155,160,0.07);
            border: 1px solid #e2e8f0;
        }
        .faq-info-card {
            border-radius: 1.5rem;
            background: linear-gradient(135deg, #0f766e 0%, #1C9BA0 60%, #22d3ee 120%);
            padding: 2.5rem 2rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .faq-info-card::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -20%;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            pointer-events: none;
        }
        .faq-info-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }

        /* Input styles */
        .faq-input {
            display: block;
            width: 100%;
            border-radius: 0.625rem;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            padding: 0.6rem 1rem 0.6rem 2.75rem;
            font-size: 0.875rem;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .faq-input:focus {
            border-color: #1C9BA0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(28,155,160,0.12);
        }
        select.faq-input { appearance: none; }

        .faq-input-wrap { position: relative; margin-top: 0.375rem; }
        .faq-input-icon {
            position: absolute;
            inset-y: 0;
            left: 0;
            display: flex;
            align-items: center;
            padding-left: 0.875rem;
            pointer-events: none;
            color: #94a3b8;
        }
        .faq-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.125rem;
        }

        /* Submit button */
        .faq-submit-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.625rem;
            background: linear-gradient(135deg, #1C9BA0 0%, #0f766e 100%);
            padding: 0.7rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(28,155,160,0.30);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .faq-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(28,155,160,0.38);
        }
        .faq-submit-btn:active { transform: translateY(0); }

        /* Section label pill */
        .faq-section-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(28,155,160,0.08);
            color: #0f766e;
            border: 1px solid rgba(28,155,160,0.18);
            border-radius: 999px;
            padding: 0.25rem 0.85rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .faq-section-pill span.dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #1C9BA0;
        }

        /* Fade-in on scroll */
        .faq-fade { opacity: 0; transform: translateY(20px); transition: opacity 0.55s ease, transform 0.55s ease; }
        .faq-fade.visible { opacity: 1; transform: none; }
    </style>

    <div class="faq-page">

    {{-- ════════════════ HERO ════════════════ --}}
    <section class="faq-hero">
        {{-- Background image (full visible) --}}
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.jpeg') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/25"></div>
        </div>

        <div class="px-4 sm:px-6 lg:px-20 max-w-4xl" style="position:relative;z-index:1;">
            {{-- Breadcrumb pill --}}
            <div class="faq-breadcrumb">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <span>Home</span>
                <span style="color:rgba(255,255,255,0.4)">›</span>
                <span style="color:#fff;font-weight:600;">FAQ</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white tracking-tight leading-tight mb-4" style="letter-spacing:-0.02em;">
                Frequently Asked<br>
                <span style="background:linear-gradient(90deg,#2dd4bf,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Questions</span>
            </h1>
            <p class="text-white/60 text-sm sm:text-base lg:text-lg max-w-xl" style="font-weight:400;">
                Everything you need to know about JustMy.Health — answered clearly and concisely.
            </p>
        </div>
    </section>

    {{-- ════════════════ INTRO FEATURE CARDS ════════════════ --}}
    <section class="faq-intro">

        {{-- Decorative blobs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(20,184,166,0.12) 0%,transparent 70%);top:-150px;left:-100px;"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(15,137,166,0.08) 0%,transparent 70%);bottom:-120px;right:-80px;"></div>
            <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:0.035;" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="faqDots" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="#0f89a6"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#faqDots)"/>
            </svg>
        </div>

        <div class="max-w-6xl mx-auto px-6 lg:px-8" style="position:relative;z-index:1;">
            <div class="text-center mb-12 faq-fade">
                <div class="faq-section-pill"><span class="dot"></span>Support Centre</div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3" style="letter-spacing:-0.01em;">Your Questions, Answered</h2>
                <p class="text-gray-500 text-base lg:text-lg max-w-xl mx-auto">We've compiled the most common questions to help you understand JustMy.Health better.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                {{-- Card 1: Health Guidance --}}
                <div class="faq-feature-card faq-fade" style="transition-delay:0.05s">
                    <div class="faq-feature-card-top">
                        <div class="faq-feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.1"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <span class="faq-feature-label">Expert Care</span>
                    </div>
                    <h4>Health Guidance</h4>
                    <p>Reliable tips and expert advice for your wellbeing.</p>
                </div>

                {{-- Card 2: Fast Answers --}}
                <div class="faq-feature-card faq-fade" style="transition-delay:0.1s">
                    <div class="faq-feature-card-top">
                        <div class="faq-feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.1"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="faq-feature-label">Instant</span>
                    </div>
                    <h4>Fast Answers</h4>
                    <p>Get quick, clear explanations to your questions.</p>
                </div>

                {{-- Card 3: Trusted Platform --}}
                <div class="faq-feature-card faq-fade" style="transition-delay:0.15s">
                    <div class="faq-feature-card-top">
                        <div class="faq-feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <span class="faq-feature-label">Verified</span>
                    </div>
                    <h4>Trusted Platform</h4>
                    <p>A safe, professional, and verified digital health environment.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ════════════════ FAQ ACCORDION AND FORM ════════════════ --}}
    <section class="faq-section">
        <div class="faq-header-watermark">Frequently Ask Question</div>
        <div class="max-w-7xl mx-auto px-3 lg:px-12">
            
            <div class="faq-header-wrapper faq-fade">
                <div class="faq-header-content">
                    <h2>Frequently Ask Question</h2>
                    <p>Find answers to common questions about our platform and services.</p>
                </div>
            </div>

            <div class="faq-layout-grid">
                
                {{-- Left Column: FAQ List --}}
                <div>
                    <div class="faq-accordion-list">
                        @foreach ($faqs as $index => $faq)
                        <div
                            id="{{ $faq->HashTag ?: 'faq-item-' . $index }}"
                            class="faq-accordion-item faq-fade"
                            style="transition-delay:{{ min($index * 0.05, 0.5) }}s"
                            data-faq
                        >
                            <button class="faq-accordion-trigger" aria-expanded="false" onclick="toggleFaq(this)">
                                <span class="faq-trigger-question">{{ $faq->Question }}</span>
                                <span class="faq-chevron" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-accordion-body" aria-hidden="true">
                                <div class="faq-accordion-body-inner">
                                    <p>{!! nl2br(e($faq->Answer)) !!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination (Visual & Functional) --}}
                    <div class="faq-pagination faq-fade" style="transition-delay: 0.3s">
                        <button id="faq-prev-btn" class="faq-nav-btn" aria-label="Previous" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button id="faq-next-btn" class="faq-nav-btn" aria-label="Next">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Right Column: Form Area --}}
                <div>
                    <div class="faq-contact-area faq-fade" style="transition-delay: 0.2s">
                        {{-- Illustration placeholder --}}
                        <div class="faq-contact-img">
                            <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
                                <!-- Base abstract shape -->
                                <path d="M 30 140 C 40 60, 140 20, 230 40 C 320 60, 380 120, 360 200 C 340 280, 220 300, 130 270 C 40 240, 20 220, 30 140 Z" fill="#f1f5f9" opacity="0.8"/>
                                <!-- Question mark -->
                                <text x="185" y="145" font-family="Arial, sans-serif" font-weight="900" font-size="140" fill="#06b6d4">?</text>
                                <!-- Person silhouette -->
                                <path d="M 230 180 C 230 160, 245 150, 265 150 C 285 150, 300 160, 300 180 L 300 280 L 230 280 Z" fill="#334155"/>
                                <circle cx="265" cy="120" r="22" fill="#334155"/>
                                <!-- Small decorative elements -->
                                <circle cx="80" cy="100" r="5" fill="#06b6d4" opacity="0.4"/>
                                <circle cx="340" cy="160" r="7" fill="#06b6d4" opacity="0.4"/>
                                <path d="M 120 220 L 130 230 L 110 230 Z" fill="#06b6d4" opacity="0.6"/>
                            </svg>
                        </div>
                        
                        <h3>Any Question?</h3>
                        <p>You can ask anything you want to know about Feedback.</p>

                        
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════════════════ CTA SECTION ════════════════ --}}
    <section class="faq-cta">
        {{-- Decorative blobs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div style="position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(20,184,166,0.12) 0%,transparent 70%);top:-150px;left:-100px;"></div>
            <div style="position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(15,137,166,0.08) 0%,transparent 70%);bottom:-120px;right:-80px;"></div>
            <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:0.035;" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="faqDotsCTA" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="#0f89a6"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#faqDotsCTA)"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start" style="position:relative;z-index:1;">

            {{-- Left: Info card --}}
            <div class="faq-info-card faq-fade">
                <div style="position:relative;z-index:1;">
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:999px;padding:4px 12px;font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#fff;margin-bottom:1.25rem;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#a7f3d0;display:inline-block;"></span>
                        Let's Talk
                    </span>
                    <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem;">
                        <div style="flex-shrink:0;width:3rem;height:3rem;border-radius:0.875rem;background:rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                        </div>
                        <div>
                            <h2 style="font-size:1.375rem;font-weight:800;color:#fff;line-height:1.25;margin-bottom:0.5rem;">Get Instant Support</h2>
                            <p style="font-size:0.875rem;color:rgba(255,255,255,0.75);line-height:1.7;">Reach out to our experts for fast, secure, and personalized answers.</p>
                        </div>
                    </div>

                    {{-- Trust badges --}}
                    <div style="display:flex;flex-direction:column;gap:0.75rem;position:relative;z-index:1;">
                        @foreach([
                            ['icon'=>'M5 13l4 4L19 7','label'=>'Licensed healthcare professionals'],
                            ['icon'=>'M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm0 0c0 1.657 1.343 3 3 3s3-1.343 3-3-1.343-3-3-3-3 1.343-3 3z','label'=>'Private & encrypted sessions'],
                            ['icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6','label'=>'Available globally, 24/7'],
                        ] as $badge)
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <span style="width:1.75rem;height:1.75rem;flex-shrink:0;border-radius:0.5rem;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $badge['icon'] }}"/></svg>
                            </span>
                            <span style="font-size:0.8125rem;color:rgba(255,255,255,0.88);font-weight:500;">{{ $badge['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Form --}}
            <div class="rounded-[2rem] bg-white p-8 shadow-xl border border-slate-200">
                @if (session('status'))
                    <div class="rounded-[10px] border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700 mb-6">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact-us.submit') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="FormLocation" value="FAQ Page">

                    <div>
                        <label for="Name" class="text-sm font-semibold text-slate-700">Name</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input id="Name" name="Name" value="{{ old('Name') }}" required
                                placeholder="e.g. John Smith"
                                class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm" />
                        </div>
                        @error('Name')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="Email" class="text-sm font-semibold text-slate-700">Email</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input id="Email" name="Email" type="email" value="{{ old('Email') }}" required
                                placeholder="you@example.com"
                                class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm" />
                        </div>
                        @error('Email')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="Subject" class="text-sm font-semibold text-slate-700">Subject</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h9m-9 3.75h5.25M6.75 3.75h10.5A2.25 2.25 0 0119.5 6v14.25a.75.75 0 01-1.09.67L12 17.44l-6.41 3.48a.75.75 0 01-1.09-.67V6a2.25 2.25 0 012.25-2.25z" />
                                </svg>
                            </span>
                            <select id="Subject" name="Subject" required
                                class="block w-full appearance-none rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm">
                                <option value="">Select a subject</option>
                                <option value="General enquiry" {{ old('Subject') === 'General enquiry' ? 'selected' : '' }}>General enquiry</option>
                                <option value="Product support" {{ old('Subject') === 'Product support' ? 'selected' : '' }}>Product support</option>
                                <option value="Partnership request" {{ old('Subject') === 'Partnership request' ? 'selected' : '' }}>Partnership request</option>
                                <option value="Feedback / suggestions" {{ old('Subject') === 'Feedback / suggestions' ? 'selected' : '' }}>Feedback / suggestions</option>
                                <option value="Other" {{ old('Subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        @error('Subject')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="Message" class="text-sm font-semibold text-slate-700">Message</label>
                        <div class="relative mt-1.5">
                            <textarea id="Message" name="MessageBody" rows="6" required
                                placeholder="Tell us how we can help..."
                                class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 px-4 py-2.5 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm">{{ old('Message') }}</textarea>
                        </div>
                        @error('Message')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    @include('partials.anti-bot-fields')

                    <button type="submit" class="faq-gradient-btn mt-8">
                        Send message
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </section>

    </div>{{-- .faq-page --}}

    {{-- ════════════════ SCRIPTS ════════════════ --}}
    <script>
        /* ── Accordion toggle ── */
        function toggleFaq(btn) {
            var item  = btn.closest('[data-faq]');
            var body  = item.querySelector('.faq-accordion-body');
            var isOpen = item.classList.contains('is-open');

            // Collapse all siblings in same column
            var column = item.parentElement;
            column.querySelectorAll('[data-faq].is-open').forEach(function(open) {
                if (open !== item) {
                    open.classList.remove('is-open');
                    open.querySelector('.faq-accordion-body').classList.remove('is-open');
                    open.querySelector('.faq-accordion-trigger').setAttribute('aria-expanded', 'false');
                    open.querySelector('.faq-accordion-body').setAttribute('aria-hidden', 'true');
                }
            });

            if (!isOpen) {
                item.classList.add('is-open');
                body.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
                body.setAttribute('aria-hidden', 'false');
            } else {
                item.classList.remove('is-open');
                body.classList.remove('is-open');
                btn.setAttribute('aria-expanded', 'false');
                body.setAttribute('aria-hidden', 'true');
            }
        }

        /* ── Hash auto-open (linked from Trust Bar) ── */
        (function () {
            function openFaqFromHash() {
                var hash = window.location.hash;
                if (!hash) return;
                var el = document.querySelector(hash + '[data-faq]');
                if (!el) return;
                var btn = el.querySelector('.faq-accordion-trigger');
                if (btn) {
                    toggleFaq(btn);
                    setTimeout(function () {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 150);
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', openFaqFromHash);
            } else {
                openFaqFromHash();
            }
            window.addEventListener('hashchange', openFaqFromHash);
        })();

        /* ── Scroll fade-in ── */
        (function () {
            var items = document.querySelectorAll('.faq-fade');
            if (!('IntersectionObserver' in window)) {
                items.forEach(function(el){ el.classList.add('visible'); });
                return;
            }
            var io = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            items.forEach(function(el){ io.observe(el); });
        })();
        /* ── Pagination Logic ── */
        (function () {
            var itemsPerPage = 6;
            var currentPage = 1;
            var items = Array.from(document.querySelectorAll('.faq-accordion-item'));
            var totalPages = Math.ceil(items.length / itemsPerPage);
            
            var prevBtn = document.getElementById('faq-prev-btn');
            var nextBtn = document.getElementById('faq-next-btn');
            
            if (!prevBtn || !nextBtn || items.length === 0) return;

            function renderPage() {
                var startIndex = (currentPage - 1) * itemsPerPage;
                var endIndex = startIndex + itemsPerPage;
                
                items.forEach(function(item, index) {
                    if (index >= startIndex && index < endIndex) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                        // also close it if it was open
                        item.classList.remove('is-open');
                        var body = item.querySelector('.faq-accordion-body');
                        var btn = item.querySelector('.faq-accordion-trigger');
                        if(body) { body.classList.remove('is-open'); body.setAttribute('aria-hidden', 'true'); }
                        if(btn) { btn.setAttribute('aria-expanded', 'false'); }
                    }
                });
                
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages || totalPages === 0;
            }
            
            prevBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage();
                }
            });
            
            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage();
                }
            });
            
            // Initial render
            renderPage();
        })();
    </script>

</x-app-layout>