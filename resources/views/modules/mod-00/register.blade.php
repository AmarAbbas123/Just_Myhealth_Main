<x-guest-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @php
        $registerType = request()->query('type');
        $roleOptions = config("user_types.$registerType") ?? [];
        $roleId = array_key_first($roleOptions);
        $roleLabel = $roleOptions[$roleId] ?? null;
    @endphp

    @if (session('error'))
        <div class="mb-4 p-3 text-sm text-red-600 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    @if (session('status'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <div class="min-h-screen flex items-center bg-slate-100 py-6">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-300/40 lg:grid-cols-2">

                <!-- Visual side -->
                <div class="relative hidden overflow-hidden lg:block">
                    <img src="{{ asset('images/bg-1.jpg') }}" alt="Sign up" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent"></div>

                    <div class="absolute inset-x-0 top-0 p-5">
                        <div class="flex items-center gap-2 text-white">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 backdrop-blur">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-semibold tracking-wide">JustMy.Health</span>
                        </div>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.3em] text-white backdrop-blur">
                            Welcome to JustMy.Health
                        </span>
                        <p class="mt-3 max-w-sm text-sm leading-6 text-white/80">
                            Build your profile, manage bookings, and deliver sessions securely with simplified onboarding.
                        </p>
                    </div>
                </div>

                <!-- Form side -->
                <div class="px-6 py-5 sm:px-10 sm:py-6">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFBFA] px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#1C9BA0]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#1C9BA0]"></span>
                        Create account
                    </span>

                    <!-- Social login -->
                    <div class="mt-4">
                        <div class="grid grid-cols-3 gap-3">
                            <a href="{{ route('social.redirect', 'google') }}"
                                class="group flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-[#1C9BA0]/40 hover:bg-[#F7FCFC]">
                                <img src="{{ asset('images/google-brands.svg') }}" alt="Google" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('social.redirect', 'facebook') }}"
                                class="group flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-[#1C9BA0]/40 hover:bg-[#F7FCFC]">
                                <img src="{{ asset('images/facebook-f-brands.svg') }}" alt="Facebook" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('social.redirect', 'twitter') }}"
                                class="group flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-[#1C9BA0]/40 hover:bg-[#F7FCFC]">
                                <img src="{{ asset('images/x-twitter-brands.svg') }}" alt="Twitter" class="h-4 w-4" />
                            </a>
                        </div>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="h-px flex-1 bg-slate-200"></span>
                            <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Or register with email</span>
                            <span class="h-px flex-1 bg-slate-200"></span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-[10px] border border-red-200 bg-red-50 p-3 text-sm text-red-700 mt-3">
                            <ul class="list-disc list-inside pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}"
                        @submit.prevent="
                    validateUserName();
                    validateEmail();
                    validatePassword();
                    validateConfirmPassword();
                    if (Object.keys(errors).length === 0) {
                        checkUsernameExists().then(() => {
                            if (!errors.UserName) {
                                 $el.submit();
                            }
                        });
                    }"
                        x-data="registrationForm()"
                        class="mt-3 w-full space-y-3">
                        @csrf

                        @if ($roleId && $roleLabel)
                            <div x-data x-init="loadUserFields('{{ $roleId }}')" class="flex items-center gap-2 rounded-[10px] border border-[#1C9BA0]/20 bg-[#EAFBFA] px-4 py-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-[#1C9BA0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-slate-700">
                                    Registering as <span class="font-semibold text-[#18848F]">{{ $roleLabel }}</span>
                                </p>
                                <input type="hidden" name="UserType" id="UserType" value="{{ $roleId }}">
                            </div>
                        @endif

                        <div>
                            <label for="UserName" class="text-sm font-semibold text-slate-700">{{ __('Username') }}</label>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input id="UserName" name="UserName" placeholder="UserName e.g RedRose47" x-model="UserName"
                                    @input="validateUserName" @blur="checkUsernameExists"
                                    class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm"
                                    x-bind:class="errors.UserName ? 'border-red-400 focus:border-red-400 focus:ring-red-400' : ''"
                                    required autocomplete="username" />
                                <button type="button"
                                    class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full border border-slate-300 bg-white text-xs font-semibold text-slate-500 shadow-sm transition hover:border-[#1C9BA0]/40 hover:text-[#1C9BA0]"
                                    @click="showInfo('username')" aria-label="Username help">?</button>
                            </div>
                            <p x-text="errors.UserName" x-show="errors.UserName" class="text-red-600 text-xs mt-1.5 font-medium"></p>
                        </div>

                        <div>
                            <label for="Email" class="text-sm font-semibold text-slate-700">{{ __('Email') }}</label>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input id="Email" name="Email" placeholder="Email e.g myname@mydomain.com" x-model="Email" @input="validateEmail"
                                    @blur="() => { validateEmail(); }"
                                    class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-4 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm"
                                    x-bind:class="errors.Email ? 'border-red-400 focus:border-red-400 focus:ring-red-400' : ''"
                                    required autocomplete="email" />
                                <button type="button"
                                    class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full border border-slate-300 bg-white text-xs font-semibold text-slate-500 shadow-sm transition hover:border-[#1C9BA0]/40 hover:text-[#1C9BA0]"
                                    @click="showInfo('email')" aria-label="Email help">?</button>
                            </div>
                            <p x-text="errors.Email" x-show="errors.Email" class="text-red-600 text-xs mt-1.5 font-medium"></p>
                        </div>

                        <div class="flex flex-col gap-3 md:flex-row">
                            <div class="w-full">
                                <label for="Password" class="text-sm font-semibold text-slate-700">{{ __('Password') }}</label>
                                <div class="relative mt-1.5">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                                        </svg>
                                    </span>
                                    <input id="Password" :type="showPassword ? 'text' : 'password'" x-model="Password" name="Password"
                                        @input="validatePassword" placeholder="Password" required autocomplete="new-password"
                                        class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-12 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm"
                                        :class="{
                                            'border-red-400 focus:border-red-400 focus:ring-red-400': strength === 'weak' && Password.length > 0,
                                            'border-amber-400 focus:border-amber-400 focus:ring-amber-400': strength === 'medium',
                                            'border-emerald-400 focus:border-emerald-400 focus:ring-emerald-400': strength === 'strong'
                                        }" />
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.127-3.592M6.343 6.343A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.132 4.132M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                                <p x-text="errors.Password" x-show="errors.Password" class="text-red-600 text-xs mt-1.5 font-medium"></p>
                            </div>

                            <div class="w-full">
                                <label for="ConfirmPassword" class="text-sm font-semibold text-slate-700">{{ __('Confirm Password') }}</label>
                                <div class="relative mt-1.5">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                                        </svg>
                                    </span>
                                    <input id="ConfirmPassword" :type="showConfirmPassword ? 'text' : 'password'" name="Password_confirmation"
                                        x-model="ConfirmPassword" @input="validateConfirmPassword"
                                        placeholder="Confirm Password" required autocomplete="new-password"
                                        class="block w-full rounded-[10px] border border-slate-200 bg-slate-50/70 pl-11 pr-12 py-2 text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0] sm:text-sm"
                                        x-bind:class="errors.ConfirmPassword ? 'border-red-400 focus:border-red-400 focus:ring-red-400' : ''" />
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                                        <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.127-3.592M6.343 6.343A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.132 4.132M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                                <p x-show="errors.ConfirmPassword" x-text="errors.ConfirmPassword"
                                    class="text-red-600 text-xs mt-1.5 font-medium"></p>
                            </div>
                        </div>
                        <p class="text-xs leading-5 text-slate-500">
                            Password must contain minimum 8 characters, with at least one uppercase, lowercase, number, and special character.
                        </p>

                        <div id="dynamic-user-fields" class="grid grid-cols-1 gap-3 md:grid-cols-2"></div>

                        <div x-show="showInfoModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
                            <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm" @click="closeInfo()"></div>
                            <div class="relative w-full max-w-lg rounded-[1.5rem] bg-white p-6 shadow-2xl shadow-black/20">
                                <div class="flex items-start justify-end gap-4 mb-4">
                                    <button type="button" @click="closeInfo()" class="text-slate-400 hover:text-slate-600">✕</button>
                                </div>
                                <div class="text-sm leading-6 text-slate-600" x-html="infoText"></div>
                                <div class="mt-6 text-right">
                                    <button type="button" @click="closeInfo()" class="rounded-[10px] bg-[#1C9BA0] px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-[#1C9BA0]/25 transition hover:bg-[#18848F]">Close</button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm text-slate-600">
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="Terms" required
                                    class="h-4 w-4 rounded border-slate-300 text-[#1C9BA0] focus:ring-[#1C9BA0]" />
                                <span>Accept Terms and Conditions</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="Privacy" required
                                    class="h-4 w-4 rounded border-slate-300 text-[#1C9BA0] focus:ring-[#1C9BA0]" />
                                <span>Accept Privacy Policy</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="GDPR"
                                    class="h-4 w-4 rounded border-slate-300 text-[#1C9BA0] focus:ring-[#1C9BA0]" />
                                <span>I accept GDPR</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center rounded-[10px] bg-[#1C9BA0] px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#1C9BA0]/25 transition hover:bg-[#18848F] hover:shadow-xl hover:shadow-[#1C9BA0]/30">
                            {{ __('Register') }}
                        </button>
                    </form>

                    <p class="text-center text-sm mt-4 text-slate-500">
                        {{ __('Already registered?') }}
                        <a href="{{ route('login') }}" class="font-semibold text-[#1C9BA0] hover:text-[#18848F] hover:underline">
                            {{ __('Sign in') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<script>
    const userFieldMap = @json(config('user_fields'));
    const businessOptions = @json(config('business_options'));
    const userOptions = @json(config('user_options'));
    const timezoneCountryOptions = @json($countryOptions ?? []);
    const medicalOptions = @json(config('medical_options'));
    const professionalOptions = @json(config('professional_options'));

    const FIELD_CLASS = "w-full rounded-[10px] border border-slate-200 bg-slate-50/70 px-4 py-2 text-sm text-slate-900 shadow-sm transition focus:border-[#1C9BA0] focus:bg-white focus:ring-[#1C9BA0]";
    const LABEL_CLASS = "text-sm font-semibold text-slate-700";

    function loadUserFields(userTypeId) {
        const fields = userFieldMap[userTypeId] || [];
        const container = document.getElementById('dynamic-user-fields');
        container.innerHTML = '';

        fields.forEach(field => {
            if (field === 'BusinessPrimaryIndustry') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" onchange="handleNotListed(this, '${field}'); loadSubIndustry(this.value)" class="${FIELD_CLASS}">
                        ${businessOptions.BusinessPrimaryIndustry.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify Industry" style="display:none;" class="${FIELD_CLASS}" />
                    </div>
                `;
            } else if (field === 'BusinessSubIndustry') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" id="subindustry" onchange="handleNotListed(this, '${field}')" class="${FIELD_CLASS}"></select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify SubIndustry" style="display:none;" class="${FIELD_CLASS}" />
                    </div>
                `;
            } else if (field === 'BusinessType') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" onchange="handleNotListed(this, '${field}')" class="${FIELD_CLASS}">
                        ${businessOptions.BusinessType.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify Business Type" style="display:none;" class="${FIELD_CLASS}"/>
                    </div>
                `;
            } else if (field === 'Country') {
                const countries = (timezoneCountryOptions && timezoneCountryOptions.length > 0)
                    ? timezoneCountryOptions
                    : (userOptions.Country || []);

                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" id="country-dropdown" onchange="loadStates(this.value)" class="${FIELD_CLASS}" required>
                        <option value="">Select Country</option>
                        ${countries.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    </div>
                `;

            } else if (field === 'State') {
                if (userTypeId === '10') {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" id="state-dropdown" onchange="loadCities(this.value)"  class="${FIELD_CLASS}"></select>
                    </div>
                `;
                } else {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="${FIELD_CLASS}" placeholder="Enter ${field}" />
                    </div>
                `;
                }
            } else if (field === 'City') {
                if (userTypeId === '10') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" id="city-dropdown" class="${FIELD_CLASS}"></select>
                    </div>
                `;
                } else if (userTypeId === '1') {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="min-w-[210%] ${FIELD_CLASS}" placeholder="Enter ${field}" />
                    </div>
                `;
                } else {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="${FIELD_CLASS}" placeholder="Enter ${field}" />
                    </div>
                `;
                }
            } else if (userOptions[field]) {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" class="${FIELD_CLASS}">
                        ${userOptions[field].map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    </div>
                `;
            } else if (field === 'DOB' || field === 'DateOfBirth') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <input type="date" name="ProfileData[${field}]" class="${FIELD_CLASS}" />
                    </div>
                `;
            } else if (field === 'YearBirth') {
                const currentYear = new Date().getFullYear();
                let yearOptions = '';
                for (let y = currentYear; y >= 1920; y--) {
                    yearOptions += `<option value="${y}">${y}</option>`;
                }
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <select name="ProfileData[${field}]" class="${FIELD_CLASS}">
                        <option value="">Select Year</option>
                        ${yearOptions}
                    </select>
                    </div>
                `;
            } else {
                container.innerHTML += `
                <div class="flex flex-col space-y-1.5">
                    <label class="${LABEL_CLASS}">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="${FIELD_CLASS}" />
                    </div>
                `;
            }
        });

        const countrySelect = document.getElementById('country-dropdown');
        if (countrySelect) loadStates(countrySelect.value);
    }

    function handleNotListed(select, field) {
        const customInput = document.querySelector(`input[name="ProfileData[${field}_Custom]"]`);
        if (customInput) {
            customInput.style.display = (select.value === 'Not Listed') ? 'block' : 'none';
        }
    }

    function loadSubIndustry(industry) {
        const subindustry = document.getElementById('subindustry');
        const options = businessOptions.BusinessSubIndustry[industry] || [];
        if (subindustry) {
            subindustry.innerHTML = options.map(o => `<option value="${o}">${o}</option>`).join('');
        }
    }

    function loadStates(country) {
        const states = userOptions.State[country] || [];
        const stateDropdown = document.getElementById('state-dropdown');
        const cityDropdown = document.getElementById('city-dropdown');

        if (stateDropdown) {
            if (states.length === 0) {
                stateDropdown.innerHTML = `<option value="">N/A</option>`;
            } else {
                stateDropdown.innerHTML = states.map(s => `<option value="${s}">${s}</option>`).join('');
            }
        }

        if (cityDropdown) {
            if (states.length) {
                loadCities(states[0]);
            } else {
                cityDropdown.innerHTML = `<option value="">N/A</option>`;
            }
        }
    }

    function loadCities(state) {
        const cities = userOptions.City[state] || [];
        const cityDropdown = document.getElementById('city-dropdown');
        if (cityDropdown) {
            cityDropdown.innerHTML = cities.map(c => `<option value="${c}">${c}</option>`).join('');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('UserType');
        if (select) {
            loadUserFields(select.value);
        }
    });

    // ✅ Alpine form object
    function registrationForm() {
        return {
            type: 'user',
            UserName: '',
            Email: '',
            Password: '',
            ConfirmPassword: '',
            showPassword: false,
            showConfirmPassword: false,
            showInfoModal: false,
            infoText: '',
            errors: {},

            get strength() {
                if (this.Password.length > 12) return 'strong';
                if (this.Password.length >= 8) return 'medium';
                return 'weak';
            },

            validateUserName() {
                if (!this.UserName) {
                    this.errors.UserName = 'Username is required.';
                } else if (!/^[A-Za-z0-9]+$/.test(this.UserName)) {
                    this.errors.UserName = 'Username must be alphanumeric.';
                } else if (this.UserName.length < 4) {
                    this.errors.UserName = 'Username must be at least 4 characters.';
                } else {
                    delete this.errors.UserName;
                }
            },

            validateEmail() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!this.Email) {
                    this.errors.Email = 'Email is required.';
                } else if (!emailRegex.test(this.Email)) {
                    this.errors.Email = 'Invalid email format.';
                } else {
                    if (['Invalid email format.', 'Email is required.'].includes(this.errors.Email)) {
                        delete this.errors.Email;
                    }
                }
            },

            validatePassword() {
                if (!this.Password) {
                    this.errors.Password = 'Password is required.';
                } else if (this.Password.length < 8) {
                    this.errors.Password = 'Password must be at least 8 characters.';
                } else {
                    delete this.errors.Password;
                }
            },

            validateConfirmPassword() {
                if (!this.ConfirmPassword) {
                    this.errors.ConfirmPassword = 'Confirm your password.';
                } else if (this.Password !== this.ConfirmPassword) {
                    this.errors.ConfirmPassword = 'Passwords do not match.';
                } else {
                    delete this.errors.ConfirmPassword;
                }
            },

            async checkUsernameExists() {
                if (this.errors.UserName || !this.UserName.match(/^[A-Za-z0-9]+$/)) return;

                try {
                    const res = await fetch(`/check-username?username=${encodeURIComponent(this.UserName)}`);
                    if (!res.ok) throw new Error("Network response not ok");
                    const data = await res.json();

                    if (data.exists) {
                        this.errors.UserName = 'Username already taken.';
                    } else if (this.errors.UserName === 'Username already taken.') {
                        delete this.errors.UserName;
                    }
                } catch (e) {
                    console.error("checkUsernameExists failed:", e);
                }
            },

            showInfo(type) {
                if (type === 'username') {
                    this.infoText = `The JustMy.Health platform protects user identity using UserNames in public facing pages. As part of account creation, the user is required to choose a UserName which is then used within the platform. A UserName must be unique to the platform, contain a minimum of 8 characters and can contain uppercase and lowercase letters and numbers i.e. RedRose47, GreenTruck, BadLand1, MarthaL.`;
                } else {
                    this.infoText = `The user must provide an active email account which is used for system validation, account activation, system messages and system notifications. The provided email address is not publicly used or shown within the JustMy.Health platform.`;
                }
                this.showInfoModal = true;
            },

            closeInfo() {
                this.showInfoModal = false;
            }
        };
    }
</script>