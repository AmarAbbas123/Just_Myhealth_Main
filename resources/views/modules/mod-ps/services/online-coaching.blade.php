{{-- Online Coaching --}}
@section('title', 'PUB: Online Coaching')
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


    </section>
    {{-- Coming Soon Banner --}}

<section class="pb-16  md:pb-24">
    <div class="container mx-auto px-6 text-center">
        {{-- TODO: replace with final "Coming Soon" graphic --}}
        <img src="{{ asset('images/online-coaching-coming-soon.png') }}" alt="Coming Soon" class="mx-auto w-full max-w-md sm:max-w-lg md:max-w-3xl h-auto">
    </div>
</section>


{{-- End of Coming Soon Banner --}}

    <!-- Navbar is in layouts/app.blade.php -->

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Coaching
                    </p>
                    <h2 class="max-w-xl text-2xl font-semibold leading-tight text-[#102f3a] sm:text-3xl md:text-4xl">
                        Online Coaching to boost wellbeing
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">
                        Coaching focuses on helping you understand your thoughts and feelings, navigate difficult situations, and build practical tools for everyday wellbeing. Ideal for stress, relationships, grief, and emotional overwhelm.
                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Online Coaching focuses on helping you move forward with clarity and confidence. Your coach works with you to understand what’s holding you back, identify your strengths, and develop practical strategies you can apply in everyday life. It’s ideal when you want support with stress, motivation, communication, relationships, or navigating life’s challenges in a more empowered way.
                        </p>
                        <p>
                            Coaching is future‑oriented and action‑based. Instead of exploring deep emotional patterns, your coach helps you set achievable goals, build new habits, and create positive change step by step. Together, you’ll work on improving resilience, strengthening decision‑making, and developing tools that support your wellbeing in real‑world situations.
                        </p>
                        <p>
                            Online Coaching is flexible, accessible, and designed to meet you where you are. Whether you need short‑term guidance or ongoing support, your coach adapts to your pace and priorities. You get a supportive space to reflect, reset, and grow, all from the comfort of your home, at times that work for you.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Coaching
                    </p>
                    <h2 class="max-w-xl text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-4xl">
                        What You Can Expect
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">

                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Online Coaching gives you a supportive space to reflect, reset, and take meaningful steps toward the life you want. Your coach helps you understand what’s getting in the way, clarify your goals, and build practical strategies you can apply immediately, whether you’re navigating stress, relationship challenges, low motivation, or emotional overwhelm. This is a forward‑focused process designed to help you make real progress in everyday life.
                        </p>
                        <p>
                            Coaching is action‑oriented. Instead of exploring deep emotional patterns, your coach works with you to develop new habits, strengthen communication, improve decision‑making, and build emotional resilience. Together, you’ll identify what supports your wellbeing and create a personalised plan that helps you stay grounded, confident, and in control of your next steps.
                        </p>
                        <p>
                            Your coaching journey is flexible and shaped around your lifestyle. Whether you prefer short‑term guidance or ongoing support, your coach works at your pace and focuses on what matters most to you. Sessions are designed to be practical, encouraging, and easy to integrate into your daily routine, giving you the clarity and momentum to move forward with confidence.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Coaching
                    </p>
                    <h2 class="max-w-xl text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-4xl">
                        Your Coach, Matched to Your Needs
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">

                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            We match you with a coach whose style, experience, and approach align with the goals you want to work on. Whether you’re looking to improve confidence, strengthen communication, manage stress, or navigate life changes, your coach is selected to ensure they’re the right fit for your personal growth journey.
                        </p>
                        <p>
                            Your coach brings a practical, forward‑focused approach to each session. They help you clarify what you want to achieve, identify what’s getting in the way, and build strategies you can apply in real life. This is a collaborative process designed to help you gain momentum, stay accountable, and make meaningful progress.
                        </p>
                        <p>
                            From the very beginning, your coach works with you at your pace and in your preferred style, whether you thrive with structured guidance, reflective conversations, or step‑by‑step planning. You’re matched not just for compatibility, but for the type of support that helps you move forward with confidence.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Coaching
                    </p>
                    <h2 class="max-w-xl text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-4xl">
                        A Safe, Confidential Space
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">

                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Online Coaching provides a supportive, judgement‑free space where you can talk openly about what’s happening in your life. Your conversations with your coach are private and handled with care, giving you the confidence to explore challenges, reflect on your experiences, and focus on what you want to change.
                        </p>
                        <p>
                            Your coach creates a respectful, encouraging environment where you can express yourself honestly and work through everyday stress, relationship issues, communication difficulties, or moments of emotional overwhelm. This is a space designed to help you feel heard, understood, and supported, without pressure or expectation.
                        </p>
                        <p>
                            All sessions take place through secure, encrypted communication, ensuring your privacy is protected. With a coach who listens, guides, and empowers you, you can focus on building clarity, confidence, and momentum in a safe and comfortable setting.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}

    <section class="bg-gradient-to-b from-[#f4fbfb] via-white to-[#eef8f7] py-8 md:py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                <div>
                    <p class="mb-5 inline-flex rounded-full border border-[#9ed9d7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#0f89a6] shadow-sm">
                        JustMy.Health - Coaching
                    </p>
                    <h2 class="max-w-xl text-3xl font-semibold leading-tight text-[#102f3a] sm:text-4xl md:text-4xl">
                        Support That Fits Your Life
                    </h2>
                    <p class="mt-6 max-w-md text-base leading-7 text-[#4b626b]">

                    </p>
                </div>

                <div class="border-l-4 border-[#0f89a6] bg-white/75 py-2 pl-6 shadow-[0_24px_70px_-55px_rgba(16,106,124,0.65)] md:pl-8">
                    <div class="space-y-5 text-base leading-8 text-[#243b45] md:text-lg">
                        <p class="font-medium text-[#102f3a]">
                            Online Coaching is designed to fit naturally into your daily routine, giving you support that adapts to your lifestyle and goals. Whether you prefer short, focused sessions or a more steady rhythm, your coach works with you to create a structure that keeps you moving forward without adding pressure to your schedule.
                        </p>
                        <p>
                            Coaching focuses on practical steps you can apply right away. Your coach helps you build new habits, strengthen resilience, and make meaningful changes at a pace that feels realistic and sustainable. Each session is shaped around what you need most, clarity, motivation, accountability, or a space to reflect and reset.
                        </p>
                        <p>
                            With flexible scheduling, secure online access, and a supportive coach who understands your priorities, you can work on your personal growth from wherever you feel most comfortable. It’s guidance that fits your life, not the other way around, helping you build confidence, momentum, and a sense of control in your everyday world.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of Services --}}




    <div class="container-fluid mx-auto pt-10 px-4 md:px-6 lg:px-4 bg-white ">

        <p class="text-justify mb-16 mx-auto pt-2 px-4 md:px-6 lg:px-20">
            At JustMy.Health, we believe in the power of personalised coaching to help you achieve mental wellness and
            emotional balance. Our secure platform offers one-to-one coaching sessions tailored to your unique needs,
            ensuring you receive the support and guidance you deserve.
        </p>






</div>

</x-app-layout>
