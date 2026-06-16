<x-app1>
    <div x-data="{ showCreditModal: {{ session('session_credit_required') ? 'true' : 'false' }} }" class="space-y-6">
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
        </div>

        <div x-data="purchase()" class="space-y-10">
            @foreach ([
                'INDIVIDUAL' => [
                    'title' => 'INDIVIDUAL Counselling and Therapy',
                    'description' => 'Choose a personal therapy session pack for focused one-to-one support with a matched, qualified professional therapist.',
                    'support' => '1 to 1 Professional Support',
                    'accent' => 'indigo',
                ],
                'COUPLES' => [
                    'title' => 'COUPLES Counselling and Therapy',
                    'description' => 'Choose a couples therapy session pack for relationship-focused support with a matched, qualified professional therapist.',
                    'support' => 'Relationship Focused Support',
                    'accent' => 'teal',
                ],
            ] as $sessionType => $section)
                @if (!empty($options[$sessionType]))
                    @php
                        $isCouples = $section['accent'] === 'teal';
                        $sectionAccent = $isCouples ? 'border-teal-500 bg-teal-50/70 text-teal-800' : 'border-indigo-500 bg-indigo-50/70 text-indigo-800';
                        $cardAccent = $isCouples ? 'from-teal-500 to-cyan-500' : 'from-indigo-500 to-violet-500';
                        $priceAccent = $isCouples ? 'text-teal-700 bg-teal-50 ring-teal-100' : 'text-indigo-700 bg-indigo-50 ring-indigo-100';
                        $buttonAccent = $isCouples ? 'bg-teal-600 hover:bg-teal-700 focus:ring-teal-500 shadow-teal-200/70' : 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 shadow-indigo-200/70';
                        $checkAccent = $isCouples ? 'bg-teal-100 text-teal-700' : 'bg-indigo-100 text-indigo-700';
                    @endphp

                    <section class="rounded-lg border border-gray-200 bg-white/70 p-4 shadow-sm">
                        <div class="mb-5 border-l-4 {{ $sectionAccent }} rounded-r-lg px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide">{{ $sessionType }}</p>
                            <h2 class="mt-1 text-2xl font-semibold text-gray-900">{{ $section['title'] }}</h2>
                            <p class="mt-1 max-w-4xl text-sm text-gray-600">{{ $section['description'] }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            @foreach ($options[$sessionType] as $opt)
                                @php
                                    $amount = $opt['amount'] ?? 0;
                                    $amountFormatted = number_format((float) $amount, 2);
                                @endphp

                                <div class="group relative overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">
                                    <div class="h-1.5 bg-gradient-to-r {{ $cardAccent }}"></div>

                                    <div class="p-5">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <div class="text-lg font-semibold text-gray-900">
                                                    {{ $opt['credits'] }} Sessions
                                                </div>
                                                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-gray-500">
                                                    {{ $sessionType }}
                                                </p>
                                            </div>

                                            <div class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                                {{ $opt['credits'] }} hrs
                                            </div>
                                        </div>

                                        <div class="mt-5 rounded-lg {{ $priceAccent }} px-4 py-3 ring-1">
                                            <div class="text-sm font-medium text-gray-600">Package price</div>
                                            <div class="mt-1 text-3xl font-bold">
                                                &pound;{{ $amountFormatted }}
                                            </div>
                                        </div>

                                        <p class="mt-4 text-sm text-gray-700 leading-relaxed">
                                            {{ $opt['credits'] }} x 1-hour sessions with a matched, qualified professional therapist
                                            to work through personal challenges effectively and securely.
                                        </p>

                                        <ul class="mt-4 space-y-2 text-sm text-gray-700">
                                            @foreach ([
                                                'Qualified Therapist',
                                                $section['support'],
                                                'Secure Therapy Sessions',
                                                'Issue Focused Sessions',
                                                'Secure Messaging',
                                                'Flexible Scheduling',
                                            ] as $feature)
                                                <li class="flex items-center gap-2">
                                                    <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full {{ $checkAccent }} text-xs font-bold">
                                                        &#10003;
                                                    </span>
                                                    <span>{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <form method="POST" action="{{ route('pay.sessions.checkout') }}" class="mt-5">
                                            @csrf
                                            <input type="hidden" name="credits" value="{{ $opt['credits'] }}" />
                                            <input type="hidden" name="session_type" value="{{ $opt['session_type'] }}" />

                                            <button type="submit"
                                                class="w-full rounded-lg {{ $buttonAccent }} px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 group-hover:shadow-xl">
                                                Buy {{ $opt['credits'] }} Sessions - &pound;{{ $amountFormatted }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach
        </div>

        <div
            x-show="showCreditModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div class="absolute inset-0 bg-black/50" @click="showCreditModal = false"></div>

            <div class="relative z-10 w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
                <h2 class="text-lg font-semibold text-gray-900">Session Credits Required</h2>
                <p class="mt-2 text-sm text-gray-700">
                    {{ session('session_credit_message', 'You need to purchase additional sessions before booking.') }}
                </p>
                <div class="mt-4 flex justify-end">
                    <button
                        type="button"
                        @click="showCreditModal = false"
                        class="rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function purchase() {
            return {};
        }
    </script>

</x-app1>
