<x-app1>
    <div class="space-y-6">
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
    </div>

    <script>
        function purchase() {
            return {};
        }
    </script>

</x-app1>
