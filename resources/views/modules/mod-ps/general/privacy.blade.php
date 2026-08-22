{{-- resources/views/privacy.blade.php --}}
<x-app-layout>


    <!-- Hero Section -->
    <section class="relative h-72 lg:h-80 flex items-start pt-28 lg:pt-36">
        <!-- Background Image -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/welcome-page/hero-bg.jpeg') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
    
        <div class="px-6 lg:px-20 max-w-4xl">
            <!-- Breadcrumb -->
            <div class="inline-flex items-center space-x-2 text-sm lg:text-base font-medium text-white/90 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v11.25A1.5 1.5 0 0119.5 21H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                <span>Home</span>
                <span class="text-white/60">›</span>
                <span class="text-white font-semibold">Privacy Policy</span>
            </div>
    
            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
                Privacy Policy <span class="text-teal-400">JustMy.Health</span>
            </h1>
        </div>
    </section>

    @php
        $privacySections = [
            ['title'=>'Introduction','content'=>'At JustMy.Health, your privacy is a priority. This Privacy Policy explains how we collect, use, protect, and share your personal information when you use our platform, services, and tools.'],
            ['title'=>'Information We Collect','content'=>'We collect personal information (name, email, contact), health information (goals, therapy sessions, dietary preferences), usage data (IP address, browser, interactions), and third-party data shared via our partners.'],
            ['title'=>'How We Use Your Information','content'=>'We use your information to deliver personalized services, facilitate online counselling and dietary programs, improve platform experience, communicate updates, support research and comply with legal obligations.'],
            ['title'=>'Sharing Your Information','content'=>'We may share your data with healthcare providers, NGOs, and technology partners for service delivery and public health initiatives. We do not sell your personal data.'],
            ['title'=>'Data Security','content'=>'We implement encryption, access controls, and secure storage to protect your information from unauthorized access, alteration, or disclosure.'],
            ['title'=>'Your Rights','content'=>'You have the right to access, update, or delete your personal data, withdraw consent, or opt out of marketing communications. Contact us at <a href="mailto:privacy@justmy.health" class="text-teal-500 font-medium">privacy@justmy.health</a>.'],
            ['title'=>'Cookies and Tracking','content'=>'We use cookies to enhance experience, analyze usage, and deliver personalized content. Manage cookie preferences via your browser settings.'],
            ['title'=>'International Data Transfers','content'=>'Your data may be stored or processed outside your residence. We ensure all transfers comply with applicable data protection laws.'],
            ['title'=>'Changes to This Policy','content'=>'We may update this Privacy Policy periodically. Changes will be posted on this page with an updated effective date. Continued use signifies acceptance of the revised policy.'],
            ['title'=>'Contact Us','content'=>'Email: <a href="mailto:privacy@justmy.health" class="text-teal-500 font-medium">privacy@justmy.health</a><br>Address: Burj Kalifa Business Park, Zabeel, Dubai, UAE.'],
        ];

        // Icon paths matched to each section's existing title — purely visual,
        // no new copy introduced.
        $privacyIcons = [
            'Introduction' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'Information We Collect' => 'M9 17.25v1.5m3-1.5v1.5m3-1.5v1.5M9 12h.008v.008H9V12zm3 0h.008v.008H12V12zm3 0h.008v.008H15V12zM4.5 6h15a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 16.5v-9A1.5 1.5 0 014.5 6z',
            'How We Use Your Information' => 'M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z',
            'Sharing Your Information' => 'M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z',
            'Data Security' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z',
            'Your Rights' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
            'Cookies and Tracking' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
            'International Data Transfers' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
            'Changes to This Policy' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99',
            'Contact Us' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
        ];
    @endphp

    <!-- Privacy Sections - Sidebar navigation + content card, with scroll-spy -->
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-[280px_1fr] gap-8 items-start"
                 x-data="{
                    active: '{{ \Illuminate\Support\Str::slug($privacySections[0]['title']) }}',
                    initSpy() {
                        const sections = this.$el.querySelectorAll('[data-privacy-section]');
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach((entry) => {
                                if (entry.isIntersecting) this.active = entry.target.id;
                            });
                        }, { rootMargin: '-15% 0px -70% 0px', threshold: 0 });
                        sections.forEach((el) => observer.observe(el));
                    }
                 }"
                 x-init="initSpy()">

                <!-- Sticky sidebar nav -->
                <aside class="lg:sticky lg:top-28">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-base font-semibold text-gray-900 mb-4">Quick Navigation</p>
                        <nav class="space-y-1">
                            @foreach($privacySections as $section)
                                @php $slug = \Illuminate\Support\Str::slug($section['title']); @endphp
                                <a href="#{{ $slug }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition"
                                   :class="active === '{{ $slug }}' ? 'bg-teal-500 text-white shadow-sm' : 'text-gray-600 hover:bg-teal-50 hover:text-teal-700'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $privacyIcons[$section['title']] ?? 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                    </svg>
                                    {{ $section['title'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </aside>

                <!-- Content card -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 lg:p-10 shadow-sm">
                    @foreach($privacySections as $index => $section)
                        @php $slug = \Illuminate\Support\Str::slug($section['title']); @endphp
                        <div id="{{ $slug }}" data-privacy-section
                             class="scroll-mt-28 {{ !$loop->first ? 'pt-8 mt-8 border-t border-gray-100' : '' }}">
                            <div class="flex items-center gap-2.5 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $privacyIcons[$section['title']] ?? 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                </svg>
                                <h3 class="text-xl lg:text-2xl font-bold text-gray-900">{{ $section['title'] }}</h3>
                            </div>
                            <p class="text-gray-600 text-base lg:text-lg leading-relaxed">{!! $section['content'] !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    
    
    <!-- CTA Section -->
    <section class="relative bg-gradient-to-r from-teal-50 to-blue-50 py-20 overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 lg:flex lg:items-center lg:justify-between">
            <!-- Text Section -->
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Have Privacy Concerns?</h2>
                <p class="text-gray-700 mb-6 text-lg lg:text-xl">Reach out to our team for assistance on any questions related to your privacy and personal data.</p>
               
            </div>
    
            <!-- Modern Card -->
            <div class="lg:w-1/2 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md">
                    <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-3xl shadow-2xl p-8 transform hover:-translate-y-2 hover:scale-105 transition duration-500">
                        <div class="flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0l-4 4m4-4l-4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">We Value Your Privacy</h3>
                        <p class="text-gray-600 text-center mb-4">
                            Our team is available to answer your questions about your data or this privacy policy.
                        </p>
                        <div class="flex justify-center">
                            <a href="mailto:privacy@justmy.health" class="inline-block px-6 py-2 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-600 transition transform hover:scale-105">
                                Contact Now
                            </a>
                        </div>
                    </div>
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-teal-200 rounded-full filter blur-2xl opacity-30 animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>
    
    </x-app-layout>