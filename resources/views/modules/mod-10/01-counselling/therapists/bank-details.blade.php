<x-app1>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <x-page-header />
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-l-4 border-teal-500 bg-teal-50 px-6 py-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-teal-700">Payment account</p>
                        <h2 class="mt-1 text-2xl font-semibold text-gray-900">Bank Details</h2>
                        <p class="mt-2 max-w-2xl text-sm text-gray-600">
                            Add the account details used for therapist session payments.
                        </p>
                    </div>

                    
                </div>
            </div>

            <form method="POST" action="{{ route('therap.bank.details.store') }}" class="bg-gray-50/70 p-5">
                @csrf

                <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-3">
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm lg:col-span-1">
                        
                        <h3 class=" text-lg font-semibold text-gray-900">Payout Profile</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Keep these details accurate so completed session payments can be processed without delay.
                        </p>

                        <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                            Bank details are saved against your therapist account.
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm lg:col-span-2">
                        <div class="mb-5 flex items-center justify-between border-b border-gray-200 pb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                                <p class="mt-1 text-sm text-gray-500">Enter the bank account used for payouts.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="NameOnAccount" class="block text-sm font-semibold text-gray-700">Name on Account</label>
                                <input
                                    id="NameOnAccount"
                                    name="NameOnAccount"
                                    type="text"
                                    maxlength="48"
                                    value="{{ old('NameOnAccount', $bankDetails->NameOnAccount ?? '') }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                    required
                                >
                                @error('NameOnAccount')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="BankName" class="block text-sm font-semibold text-gray-700">Bank Name</label>
                                <input
                                    id="BankName"
                                    name="BankName"
                                    type="text"
                                    maxlength="64"
                                    value="{{ old('BankName', $bankDetails->BankName ?? '') }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                    required
                                >
                                @error('BankName')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="BankIBAN" class="block text-sm font-semibold text-gray-700">IBAN</label>
                                <input
                                    id="BankIBAN"
                                    name="BankIBAN"
                                    type="text"
                                    maxlength="32"
                                    value="{{ old('BankIBAN', $bankDetails->BankIBAN ?? '') }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm uppercase tracking-wide shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                >
                                @error('BankIBAN')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="BankSWIFT" class="block text-sm font-semibold text-gray-700">Swift ID</label>
                                <input
                                    id="BankSWIFT"
                                    name="BankSWIFT"
                                    type="text"
                                    maxlength="16"
                                    value="{{ old('BankSWIFT', $bankDetails->BankSWIFT ?? '') }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm uppercase tracking-wide shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                >
                                @error('BankSWIFT')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="BankSort" class="block text-sm font-semibold text-gray-700">Sort Code</label>
                                <input
                                    id="BankSort"
                                    name="BankSort"
                                    type="text"
                                    maxlength="32"
                                    value="{{ old('BankSort', $bankDetails->BankSort ?? '') }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                >
                                @error('BankSort')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="BankAccountNumber" class="block text-sm font-semibold text-gray-700">Account Number</label>
                                <input
                                    id="BankAccountNumber"
                                    name="BankAccountNumber"
                                    type="text"
                                    inputmode="numeric"
                                    maxlength="8"
                                    value="{{ old('BankAccountNumber', $bankDetails->BankAccountNumber ?? '') }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                    required
                                >
                                @error('BankAccountNumber')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="BankDefaultCurrency" class="block text-sm font-semibold text-gray-700">Account Currency</label>
                                <select
                                    id="BankDefaultCurrency"
                                    name="BankDefaultCurrency"
                                    class="mt-1 block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-teal-500 focus:ring-teal-500"
                                    required
                                >
                                    @foreach (['GBP', 'EUR', 'USD'] as $currency)
                                        <option
                                            value="{{ $currency }}"
                                            @selected(old('BankDefaultCurrency', $bankDetails->BankDefaultCurrency ?? 'GBP') === $currency)
                                        >
                                            {{ $currency }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('BankDefaultCurrency')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col gap-3  border-gray-200  sm:flex-row sm:items-center sm:justify-between">
                            

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-200/70 transition hover:-translate-y-0.5 hover:bg-teal-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                            >
                                Save Bank Details
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app1>
