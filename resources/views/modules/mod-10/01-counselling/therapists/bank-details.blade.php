<x-app1>
    <div class="space-y-6" x-data="{
        name: '{{ addslashes(old('NameOnAccount', $bankDetails->NameOnAccount ?? '')) }}',
        bank: '{{ addslashes(old('BankName', $bankDetails->BankName ?? '')) }}',
        account: '{{ addslashes(old('BankAccountNumber', $bankDetails->BankAccountNumber ?? '')) }}',
        currency: '{{ old('BankDefaultCurrency', $bankDetails->BankDefaultCurrency ?? 'GBP') }}',
        sort: '{{ addslashes(old('BankSort', $bankDetails->BankSort ?? '')) }}',
        iban: '{{ addslashes(old('BankIBAN', $bankDetails->BankIBAN ?? '')) }}',
        swift: '{{ addslashes(old('BankSWIFT', $bankDetails->BankSWIFT ?? '')) }}',
    }">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 flex items-center justify-between gap-3 text-emerald-800 dark:text-emerald-200 shadow-2xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/60 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex items-center gap-3 text-rose-800 dark:text-rose-200 shadow-2xs">
                <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header -->
        <x-page-header />

        <!-- Status & Payout Readiness Row (Below Header) -->
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-2.5 flex-wrap">
                @if (!empty($bankDetails?->BankAccountNumber))
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Payout Account Active</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 border border-[#1C9BA0]/20">
                        <span class="w-2 h-2 rounded-full bg-[#1C9BA0]"></span>
                        <span>Primary Settlement: {{ $bankDetails->BankDefaultCurrency }} (•••• {{ substr($bankDetails->BankAccountNumber, -4) }})</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/60">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Payout Configuration Required</span>
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Add your verified bank account details below to receive completed therapy session payouts.
                    </span>
                @endif
            </div>
        </div>

        <!-- Main Content: Virtual Card Preview & Form -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Virtual Bank Card & Security Info (lg:col-span-5) -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- Virtual Banking Card Preview -->
                <div class="relative overflow-hidden rounded-3xl p-6 sm:p-7 text-white shadow-xl transition-all duration-300 hover:shadow-2xl"
                     style="background: linear-gradient(135deg, #0d5459 0%, #167a80 45%, #1C9BA0 80%, #127F94 100%);">
                    
                    <!-- Decorative Radial Glow Overlay -->
                    <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                    <div class="absolute -left-12 -bottom-12 w-48 h-48 rounded-full bg-[#127F94]/40 blur-2xl pointer-events-none"></div>

                    <!-- Card Header: Bank Name & Chip -->
                    <div class="relative z-10 flex items-center justify-between gap-4 mb-8">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-teal-200/90 block">Settlement Bank</span>
                            <h4 class="text-base sm:text-lg font-bold tracking-tight truncate max-w-[200px]"
                                x-text="bank ? bank.toUpperCase() : 'FINANCIAL INSTITUTION'"></h4>
                        </div>

                        <!-- Contactless & Chip Icon -->
                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Contactless Waves -->
                            <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 16.5a5 5 0 010-7m3.5 9a9 9 0 000-11m3.5 13a13 13 0 000-15" />
                            </svg>
                            <!-- Smart Chip -->
                            <div class="w-10 h-7 rounded-md bg-gradient-to-tr from-amber-200 to-amber-400 border border-amber-300/60 shadow-xs flex items-center justify-center p-0.5">
                                <div class="w-full h-full border border-amber-600/30 rounded-xs flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-xs border-r border-amber-600/40"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Number (Masked Account Number) -->
                    <div class="relative z-10 mb-6">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-teal-200/90 block mb-1">Account Number</span>
                        <div class="font-mono text-xl sm:text-2xl font-bold tracking-widest text-white/95">
                            <span x-text="account ? '•••• •••• ' + account.slice(-4).padStart(account.length > 4 ? 4 : account.length, '•') : '•••• •••• •••• ••••'"></span>
                        </div>
                    </div>

                    <!-- Card Footer: Name on Account, Currency & Sort Code -->
                    <div class="relative z-10 flex items-end justify-between pt-4 border-t border-white/15 gap-4">
                        <div class="min-w-0">
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-teal-200/80 block">Account Holder</span>
                            <div class="text-xs sm:text-sm font-bold tracking-wider truncate uppercase font-mono text-white/95"
                                 x-text="name ? name : 'ACCOUNT HOLDER NAME'"></div>
                        </div>

                        <div class="text-right shrink-0">
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-teal-200/80 block">Currency</span>
                            <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-xs">
                                <span x-text="currency === 'GBP' ? '£ GBP' : (currency === 'EUR' ? '€ EUR' : '$ USD')"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Security Guarantee Card -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">Encrypted Banking Security</h4>
                            <p class="text-xs text-gray-400">Strictly used for authorized session payouts.</p>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        All bank details are stored securely using industry-standard 256-bit encryption. Your financial information is kept confidential and utilized exclusively for disbursement of earned therapy session fees.
                    </p>

                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] font-semibold text-gray-400">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Direct Bank Transfer (BACS / SEPA)
                        </span>
                        <span class="text-[#1C9BA0]">Instant Verification</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Account Information Form (lg:col-span-7) -->
            <div class="lg:col-span-7">
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-4px_rgba(0,0,0,0.05)]">
                    
                    <!-- Section Title & Subtitle -->
                    <div class="pb-5 border-b border-gray-100 dark:border-gray-700/80 mb-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Payout Account Information</h3>
                                <p class="text-xs sm:text-sm text-gray-400 mt-0.5">Please ensure all bank credentials match your official account statements.</p>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-[#1C9BA0]/10 text-[#1C9BA0] dark:bg-[#1C9BA0]/20 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('therap.bank.details.store') }}" class="space-y-5">
                        @csrf

                        <!-- Row 1: Name on Account & Bank Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Name on Account -->
                            <div>
                                <label for="NameOnAccount" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Name on Account <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        id="NameOnAccount"
                                        name="NameOnAccount"
                                        type="text"
                                        maxlength="48"
                                        required
                                        x-model="name"
                                        placeholder="e.g. Dr. Jane Doe"
                                        value="{{ old('NameOnAccount', $bankDetails->NameOnAccount ?? '') }}"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                    >
                                </div>
                                @error('NameOnAccount')
                                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bank Name -->
                            <div>
                                <label for="BankName" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Bank Name <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        id="BankName"
                                        name="BankName"
                                        type="text"
                                        maxlength="64"
                                        required
                                        x-model="bank"
                                        placeholder="e.g. Barclays Bank"
                                        value="{{ old('BankName', $bankDetails->BankName ?? '') }}"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                    >
                                </div>
                                @error('BankName')
                                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Account Number & Sort Code -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Account Number -->
                            <div>
                                <label for="BankAccountNumber" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Account Number <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        id="BankAccountNumber"
                                        name="BankAccountNumber"
                                        type="text"
                                        inputmode="numeric"
                                        maxlength="8"
                                        required
                                        x-model="account"
                                        placeholder="e.g. 12345678"
                                        value="{{ old('BankAccountNumber', $bankDetails->BankAccountNumber ?? '') }}"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 font-mono pl-3.5 pr-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                    >
                                </div>
                                <span class="text-[11px] text-gray-400 mt-1 block">Up to 8 numeric digits</span>
                                @error('BankAccountNumber')
                                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sort Code -->
                            <div>
                                <label for="BankSort" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Sort Code / Routing
                                </label>
                                <div class="relative">
                                    <input
                                        id="BankSort"
                                        name="BankSort"
                                        type="text"
                                        maxlength="32"
                                        x-model="sort"
                                        placeholder="e.g. 20-00-00"
                                        value="{{ old('BankSort', $bankDetails->BankSort ?? '') }}"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 font-mono pl-3.5 pr-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                    >
                                </div>
                                <span class="text-[11px] text-gray-400 mt-1 block">UK Sort code or routing number</span>
                                @error('BankSort')
                                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Account Default Currency -->
                        <div>
                            <label for="BankDefaultCurrency" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                Settlement Currency <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="BankDefaultCurrency"
                                    name="BankDefaultCurrency"
                                    required
                                    x-model="currency"
                                    class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 pl-3.5 pr-10 py-2.5 text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                >
                                    @foreach (['GBP' => 'GBP (£) - British Pound', 'EUR' => 'EUR (€) - Euro', 'USD' => 'USD ($) - US Dollar'] as $val => $label)
                                        <option value="{{ $val }}" @selected(old('BankDefaultCurrency', $bankDetails->BankDefaultCurrency ?? 'GBP') === $val)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('BankDefaultCurrency')
                                <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 4: International Banking (IBAN & SWIFT) -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700/80">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400 block mb-3">
                                International Payouts (Optional)
                            </span>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- IBAN -->
                                <div>
                                    <label for="BankIBAN" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                        IBAN Number
                                    </label>
                                    <input
                                        id="BankIBAN"
                                        name="BankIBAN"
                                        type="text"
                                        maxlength="32"
                                        x-model="iban"
                                        placeholder="e.g. GB29NWBK60161331926819"
                                        value="{{ old('BankIBAN', $bankDetails->BankIBAN ?? '') }}"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 font-mono uppercase tracking-wide pl-3.5 pr-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                    >
                                    @error('BankIBAN')
                                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- SWIFT / BIC -->
                                <div>
                                    <label for="BankSWIFT" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                        SWIFT / BIC Code
                                    </label>
                                    <input
                                        id="BankSWIFT"
                                        name="BankSWIFT"
                                        type="text"
                                        maxlength="16"
                                        x-model="swift"
                                        placeholder="e.g. NWBKGB2L"
                                        value="{{ old('BankSWIFT', $bankDetails->BankSWIFT ?? '') }}"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/60 font-mono uppercase tracking-wide pl-3.5 pr-4 py-2.5 text-xs sm:text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition-all shadow-2xs"
                                    >
                                    @error('BankSWIFT')
                                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-5 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end gap-3">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs sm:text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg hover:brightness-105 active:scale-95 cursor-pointer"
                                style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Save Bank Details</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</x-app1>
