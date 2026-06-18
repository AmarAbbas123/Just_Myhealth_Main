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
        $pageLabel = $roleLabel ? "$roleLabel Sign Up" : 'Create Account';
        $heroTagline = $roleLabel ? "Create your {$roleLabel} account" : 'Start your account on JustMy.Health';
    @endphp

    <div class="min-h-screen bg-slate-100 text-slate-900 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-lg shadow-slate-200/60 lg:grid-cols-[1.05fr_0.95fr]">

                <div class="relative hidden overflow-hidden  lg:block">
                    <img src="{{ asset('images/bg-1.jpg') }}" alt="Sign up" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-white/90 via-white/60 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-10">
                        <span class="inline-flex rounded-full bg-indigo-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-indigo-600">
                            Welcome to JustMy.Health
                        </span>
                        <h2 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950">
                            {{ $heroTagline }}
                        </h2>
                        <p class="mt-4 max-w-lg text-sm leading-7 text-slate-600">
                            Build your profile, manage bookings, and deliver sessions securely with simplified onboarding.
                        </p>
                    </div>
                </div>

                <div class="px-6 py-8 sm:px-10 sm:py-10">
                    <div class="max-w-2xl">
                        <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-indigo-600">
                            Create account
                        </span>
                        <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                            {{ $pageLabel }}
                        </h1>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-slate-600">
                            Fill in your details below to register and start serving clients on JustMy.Health.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ route('social.redirect', 'google') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-900 shadow-sm transition hover:bg-slate-200">
                            <img src="{{ asset('images/google-brands.svg') }}" alt="Google" class="h-5 w-5" />
                        </a>
                        <a href="{{ route('social.redirect', 'facebook') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-900 shadow-sm transition hover:bg-slate-200">
                            <img src="{{ asset('images/facebook-f-brands.svg') }}" alt="Facebook" class="h-5 w-5" />
                        </a>
                        <a href="{{ route('social.redirect', 'twitter') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-900 shadow-sm transition hover:bg-slate-200">
                            <img src="{{ asset('images/x-twitter-brands.svg') }}" alt="Twitter" class="h-5 w-5" />
                        </a>
                        <span class="ml-auto text-sm text-slate-500">Or register with email</span>
                    </div>

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
                        class="mt-10 w-full rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 shadow-lg shadow-slate-200/50 space-y-6">
                        @csrf

                        @if ($errors->any())
                            <div class="rounded-3xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @php
                            $type = request()->query('type'); // "user", "therapist", "business"
                            $roleOptions = config("user_types.$type") ?? [];
                            $roleId = array_key_first($roleOptions); // first (and only) role id
                            $roleLabel = $roleOptions[$roleId] ?? null;
                        @endphp

                        @if ($roleId && $roleLabel)
                            <div x-data x-init="loadUserFields('{{ $roleId }}')" class="rounded-3xl border border-slate-200 bg-white p-4">
                                <p class="text-sm text-slate-600">
                                    Register as
                                    <span class="font-semibold text-slate-950">{{ $roleLabel }}</span>
                                </p>
                                <input type="hidden" name="UserType" id="UserType" value="{{ $roleId }}">
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="relative col-span-2">
                                <x-text-input name="UserName" placeholder="UserName e.g RedRose47" x-model="UserName"
                                    @input="validateUserName" @blur="checkUsernameExists"
                                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required />
                                <button type="button"
                                    class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 bg-white text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100"
                                    @click="showInfo('username')" aria-label="Username help">?</button>
                                <p x-text="errors.UserName" x-show="errors.UserName" class="mt-2 text-sm text-red-600"></p>
                            </div>

                            <div class="relative col-span-2">
                                <x-text-input name="Email" placeholder="Email e.g myname@mydomain.com" x-model="Email" @input="validateEmail"
                                    @blur="() => { validateEmail(); }"
                                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required />
                                <button type="button"
                                    class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 bg-white text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100"
                                    @click="showInfo('email')" aria-label="Email help">?</button>
                                <p x-text="errors.Email" x-show="errors.Email" class="mt-2 text-sm text-red-600"></p>
                            </div>

                            <div class="col-span-2">
                                <div class="flex flex-col gap-4 md:flex-row">
                                    <div class="w-full relative">
                                        <input :type="showPassword ? 'text' : 'password'" x-model="Password" name="Password"
                                            @input="validatePassword" placeholder="Password" required
                                            class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 pr-12 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :class="{
                                                'border-red-500': strength === 'weak' && Password.length > 0,
                                                'border-yellow-500': strength === 'medium',
                                                'border-green-500': strength === 'strong'
                                            }" />
                                        <p x-text="errors.Password" x-show="errors.Password" class="mt-2 text-sm text-red-600"></p>
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5..." />
                                            </svg>
                                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19..." />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3l18 18" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="w-full relative">
                                        <input :type="showConfirmPassword ? 'text' : 'password'" name="Password_confirmation"
                                            x-model="ConfirmPassword" @input="validateConfirmPassword"
                                            placeholder="Confirm Password" required
                                            class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 pr-12 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                        <p x-show="errors.ConfirmPassword" x-text="errors.ConfirmPassword"
                                            class="mt-2 text-sm text-red-600"></p>
                                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                            class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                                            <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268..." />
                                            </svg>
                                            <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19..." />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3l18 18" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-500 mt-2">
                                    Password must contain minimum 8 characters, with at least one uppercase, lowercase, number, and special character.
                                </p>
                            </div>
                        </div>

                        <div id="dynamic-user-fields" class="grid grid-cols-1 gap-4 md:grid-cols-2"></div>

                        <div x-show="showInfoModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
                            <div class="absolute inset-0 bg-slate-900/20" @click="closeInfo()"></div>
                            <div class="relative w-full max-w-lg rounded-[1.5rem] bg-white p-6 shadow-2xl shadow-slate-200/60">
                                <div class="flex items-start justify-end gap-4 mb-4">
                                    <button type="button" @click="closeInfo()" class="text-slate-500 hover:text-slate-900">✕</button>
                                </div>
                                <div class="text-sm text-slate-700" x-html="infoText"></div>
                                <div class="mt-6 text-right">
                                    <button type="button" @click="closeInfo()" class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">Close</button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm text-slate-700">
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="Terms" required
                                    class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-500 focus:ring-indigo-500" />
                                <span>Accept Terms and Conditions</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="Privacy" required
                                    class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-500 focus:ring-indigo-500" />
                                <span>Accept Privacy Policy</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="GDPR"
                                    class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-500 focus:ring-indigo-500" />
                                <span>I accept GDPR</span>
                            </label>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <a class="text-sm text-slate-600 transition hover:text-slate-900 underline" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                            <x-primary-button class="w-full sm:w-auto px-6 py-3 text-sm font-semibold">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
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

    function loadUserFields(userTypeId) {
        const fields = userFieldMap[userTypeId] || [];
        const container = document.getElementById('dynamic-user-fields');
        container.innerHTML = '';

        fields.forEach(field => {
            if (field === 'BusinessPrimaryIndustry') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" onchange="handleNotListed(this, '${field}'); loadSubIndustry(this.value)" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        ${businessOptions.BusinessPrimaryIndustry.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify Industry" style="display:none;" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                `;
            } else if (field === 'BusinessSubIndustry') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" id="subindustry" onchange="handleNotListed(this, '${field}')" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify SubIndustry" style="display:none;" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                `;
            } else if (field === 'BusinessType') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" onchange="handleNotListed(this, '${field}')" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        ${businessOptions.BusinessType.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify Business Type" style="display:none;" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                    </div>
                `;
            } else if (field === 'Country') {
                const countries = (timezoneCountryOptions && timezoneCountryOptions.length > 0)
                    ? timezoneCountryOptions
                    : (userOptions.Country || []);

                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" id="country-dropdown" onchange="loadStates(this.value)" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Select Country</option>
                        ${countries.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    </div>
                `;

            } else if (field === 'State') {
                if (userTypeId === '10') {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" id="state-dropdown" onchange="loadCities(this.value)"  class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></select>
                    </div>
                `;
                } else {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter ${field}" />
                    </div>
                `;
                }
            } else if (field === 'City') {
                if (userTypeId === '10') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" id="city-dropdown" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></select>
                    </div>
                `;
                } else if (userTypeId === '1') {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="min-w-[210%] rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter ${field}" />
                    </div>
                `;
                } else {
                    container.innerHTML += `
                    <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter ${field}" />
                    </div>
                `;
                }
            } else if (userOptions[field]) {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        ${userOptions[field].map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    </div>
                `;
            } else if (field === 'DOB' || field === 'DateOfBirth') {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <input type="date" name="ProfileData[${field}]" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                `;
            } else if (field === 'YearBirth') {
                const currentYear = new Date().getFullYear();
                let yearOptions = '';
                for (let y = currentYear; y >= 1920; y--) {
                    yearOptions += `<option value="${y}">${y}</option>`;
                }
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <select name="ProfileData[${field}]" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Year</option>
                        ${yearOptions}
                    </select>
                    </div>
                `;
            } else {
                container.innerHTML += `
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
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