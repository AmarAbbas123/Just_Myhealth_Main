{{-- Online Counselling --}}
<x-app-layout>

    <!-- Hero Section -->
<section class="relative h-80 flex items-start lg:items-center pt-24 lg:pt-32">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover object-center">
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
        <h1 class="text-4xl lg:text-5xl font-bold text-white tracking-tight mb-4">
            Online Counselling 
        </h1>
        
    </div>
</section>

    <!-- Navbar is in layouts/app.blade.php -->   

    <div class="container-fluid mx-auto pt-10 px-4 md:px-6 lg:px-4 bg-white min-h-screen">
        
        <p class="text-justify mx-auto pt-2 px-4 md:px-6 lg:px-20">
            At JustMy.Health, we believe in the power of personalized therapy to help you achieve mental wellness and
            emotional balance. Our secure platform offers one-to-one therapy sessions tailored to your unique needs,
            ensuring you receive the support and guidance you deserve.
        </p>

        <section class="bg-gradient-to-b from-gray-50 to-white py-16">
            <div class="container mx-auto px-4 md:px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start mb-14">
                    <div class="overflow-hidden rounded-3xl shadow-lg">
                        <img
                            src="{{ asset('images/welcome-page/therapyjourney.png') }}"
                            alt="Therapy Journey"
                            class="w-full h-auto object-cover">
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Why Choose Us?</h2>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed text-justify">
                            "Our aim is to be one of the most outstanding online therapy provision. Therefore, we aim to match
                            you with a client within 15 minutes of you signing up. We understand that there can be long waiting
                            times to see a therapist. Such experience can sometimes escalate the distress that you are
                            experiencing. We at Justmyhealth, further aim for you to be able to access therapy within two days
                            of signing up. We work with you according to your presenting issues, and therefore the best
                            therapist is allocated, to facilitate your needs. We aim to have resources, such as worksheets,
                            which will explain more about the issues that you are experiencing. Please acknowledge that we do
                            have your interest at heart, therefore please use the accessible email to reach out to us, if there
                            is a complaint or any other concerns. "
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                    @foreach ([
        ['icon' => 'authentication', 'title' => 'Secure User Authentication', 'desc' => 'Implement multi-factor authentication to protect user accounts.'],
        ['icon' => 'anonymous', 'title' => 'Anonymous Profiles', 'desc' => 'Offer the option for clients to use anonymous profiles if they prefer.'],
        ['icon' => 'message', 'title' => 'Confidential Messaging', 'desc' => 'Use encrypted messaging systems for secure communication between therapists and clients.'],
        ['icon' => 'security', 'title' => 'Regular Security Audits', 'desc' => 'Conduct regular security audits and vulnerability assessments.'],
        ['icon' => 'compliance', 'title' => 'Compliance with Regulations', 'desc' => 'Adhere to HIPAA or GDPR standards for data protection and privacy.'],
        ['icon' => 'policies', 'title' => 'Transparent Policies', 'desc' => 'Make privacy policies and terms of service easily accessible and clear.'],
        ['icon' => 'schedule', 'title' => 'Private Scheduling', 'desc' => 'Integrate secure calendar systems for booking and managing appointments.'],
        ['icon' => 'waiting-room', 'title' => 'Virtual Waiting Rooms', 'desc' => 'Use virtual waiting rooms to maintain session confidentiality.'],
        ['icon' => 'document', 'title' => 'Secure Document Sharing', 'desc' => 'Allow for the safe exchange of therapy notes and resources.'],
        ['icon' => 'verification', 'title' => 'Therapist Verification', 'desc' => 'Verify the credentials of therapists to ensure they are qualified professionals.'],
    ] as $card)
                        <div
                            class="flex items-start space-x-4 bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                            <img src="{{ asset('images/icons/' . $card['icon'] . '.png') }}" alt="{{ $card['title'] }}"
                                class="w-12 h-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $card['title'] }}:</h3>
                                <p class="text-gray-600 mt-2 text-sm leading-relaxed">{{ $card['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Core Values --}}
        <section class="bg-white py-16">
            <div class="container mx-auto px-4 md:px-6 lg:px-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Our Core Values</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ([
        ['title' => 'RESPECT', 'desc' => 'We have great admiration for the effort that you have made in seeking help, valuing your worth, feelings and  boundaries'],
        ['title' => 'COMMITMENT', 'desc' => 'We are dedicated to work professionally, skillfully and to communicate effectively.'],
        ['title' => 'DIVERSITY', 'desc' => 'We value your differences, of background, sexuality, age, religion, gender ethnicity, physical ability and your experiences'],
        ['title' => 'CLIENT FOCUS', 'desc' => 'Putting the client at the centre of the therapy, being present, understanding and focussing on the presenting needs'],
        ['title' => 'INTEGRITY', 'desc' => 'At justmyhealth,  integrity is a part of our traits, by being honest, trustworthy and having a strong unwavering moral, and ethical principles, by doing the right thing, even when it is difficult, regardless of external pressure or a potential personal gain. It is putting the client at the centre with professional conduct'],
        ['title' => 'CONFIDENTIALITY', 'desc' => 'We at justmyhealth consider confidentiality as one of the most fundamental and ethical legal obligation to protect private and sensitive information from unauthorised disclosure, ensuring that all information is kept secret and secure, such as maintaining the privacy of your identity. This is the core of building trust in professional relationships. Violation of privacy will lead to disciplinary action'],
        ['title' => 'ACCOUNTABILITY', 'desc' => 'We are obligated to accept and demonstrate responsibility, such is a core principle in data protection, and organisation governance. Complying with regulation of the governing body  ethical framework, policies, record keeping, with internal regulations'],
        ['title' => 'INCLUSIVITY', 'desc' => 'All individuals are unique , and therefore, regardless of your background, sexual differences, age, religion and identity. You are welcome atjustmyhealth, valued and respected, ensuring that equal understanding and a sense of belonging for everyone.'],
    ] as $card)
                        <div class="bg-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $card['title'] }}</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $card['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Pricing --}}
        <section class="w-full bg-gradient-to-b from-[#66BBAE]/30 via-[#66BBAE]/10 to-white py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

                <!-- Left Text -->
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-3xl font-bold text-gray-800">Therapy Process & Cost</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Therapy is an iterative process which encompasses multiple sessions
                        arranged at a defined frequency to allow time to absorb, adjust, and benefit.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        To minimize costs, we provide therapy sessions as monthly blocks
                        containing <span class="font-semibold text-gray-800">four sessions</span>.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        The cost of therapy ranges from
                        <span class="font-semibold text-indigo-600">&pound;50 to &pound;70 per week</span>
                        (billed every 4 weeks). Variation depends on location, type of therapy,
                        preferences, and therapist availability.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        You can cancel your membership at any time, for any reason.
                    </p>
                </div>

                <!-- Right Pricing Card -->
                <div
                    class="bg-white rounded-2xl shadow-lg border-t-4 border-indigo-600 p-6 flex flex-col justify-between hover:shadow-2xl transition">
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-gray-800">&pound;50 to &pound;70</h3>
                        <p class="text-gray-500">per weekly session</p>
                    </div>

                    <ul class="mt-6 space-y-3 text-gray-700">
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> End-to-End Encryption
                        </li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Confidential Messaging
                        </li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Private Scheduling
                        </li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Secure Document
                            Sharing</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Session Recording
                            Controls</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Emergency Support</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Virtual Waiting Rooms
                        </li>
                        <li class="flex items-center gap-2"><span class="text-green-500">&#10004;</span> Therapist Verification
                        </li>
                    </ul>

                    <!-- Button -->
                    <div class="mt-8">
                        <a href="{{ route('login') }}"
                            class="block w-full py-3 px-5 text-center text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl font-medium transition">
                            Login or Register to view Availability
                        </a>
                    </div>
                </div>
            </div>
        </section>



    </div>

</x-app-layout>