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

        <div x-data="purchase()" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($options as $opt)
                @php
                    $amount = $opt['amount'] ?? 0;
                    $amountFormatted = number_format((float) $amount, 2);
                @endphp

                <div class="bg-white p-5 rounded-lg shadow hover:shadow-2xl transition border-t-4 border-indigo-300">
                    <div class="text-lg font-semibold">
                        {{ $opt['credits'] }} Sessions
                    </div>

                    <div class="text-3xl font-bold text-indigo-600 mt-3">
                        £{{ $amountFormatted }}
                    </div>

                    <p class="mt-3 text-sm text-gray-700 leading-relaxed">
                        {{ $opt['credits'] }} × 1-hour sessions with a matched, qualified professional therapist to work
                        through personal challenges effectively and securely.
                    </p>


                    <ul class="text-sm text-gray-600 mt-3 space-y-1">
                        <li>✔ Qualified Therapist </li>
                        <li>✔ 1 to 1 Professional Support </li>
                        <li> ✔ Secure Therapy Sessions </li>
                        <li> ✔ Issue Focused Sessions </li>
                        <li> ✔ Secure Messaging</li>
                        <li> ✔ Flexible Scheduling</li>

                    </ul>

                    <form method="POST" action="{{ route('pay.sessions.checkout') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="credits" value="{{ $opt['credits'] }}" />
                        <input type="hidden" name="amount" value="{{ $amount }}" />

                        <button type="submit"
                            class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded">
                            Buy {{ $opt['credits'] }} Sessions — £{{ $amountFormatted }}
                        </button>
                    </form>
                </div>
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
