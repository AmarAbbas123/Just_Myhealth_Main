<x-guest-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row mx-auto">
        <!-- Left Image -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('/images/bg-1.jpg');"></div>

        <!-- Right Form -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Sign Up</h2>

            <!-- Social Icons -->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('social.redirect', 'google') }}" class="text-blue-600 hover:text-blue-800"> <img
                        src="{{ asset('images/google-brands.svg') }}" alt="Google" class="h-6 w-6" /></a>
                <a href="{{ route('social.redirect', 'facebook') }}" class="text-blue-600 hover:text-blue-800"> <img
                        src="{{ asset('images/facebook-f-brands.svg') }}" alt="Facebook" class="h-6 w-6" /></a>
                <a href="{{ route('social.redirect', 'twitter') }}" class="text-blue-600 hover:text-blue-800"> <img
                        src="{{ asset('images/x-twitter-brands.svg') }}" alt="twitter" class="h-6 w-6" /></a>
            </div>

            <!-- Registration Form -->
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
                x-data="registrationForm()" class="w-full h-full bg-white p-6 rounded-lg shadow space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="text-red-600">
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
                    <!-- User Type (auto-selected) -->
                    <div x-data x-init="loadUserFields('{{ $roleId }}')">
                        <p>
                            Register as <span
                                class="mt-1 text-lg font-semibold text-blue-900">{{ $roleLabel }}</span>
                        </p>

                        <!-- Hidden input so the value still submits -->
                        <input type="hidden" name="UserType" id="UserType" value="{{ $roleId }}">
                    </div>
                @endif


                <!-- Common Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative col-span-2">
                        <x-text-input name="UserName" placeholder="UserName e.g RedRose47" x-model="UserName"
                            @input="validateUserName" @blur="checkUsernameExists"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                            required />
                        <button type="button"
                            class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 inline-flex h-7 w-7 items-center justify-center rounded-full border border-slate-500 bg-slate-100 text-sm font-bold leading-none text-slate-700 shadow-sm transition hover:bg-slate-200"
                            @click="showInfo('username')" aria-label="Username help">
                            ?
                        </button>
                        
                        <p x-text="errors.UserName" x-show="errors.UserName" class="text-red-600 text-sm mt-1"></p>
                    </div>

                    <div class="relative col-span-2">
                        <x-text-input name="Email" placeholder="Email e.g myname@mydomain.com" x-model="Email" @input="validateEmail"
                            @blur="() => { validateEmail(); }"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                            required />
                        <button type="button"
                            class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 inline-flex h-7 w-7 items-center justify-center rounded-full border border-slate-500 bg-slate-100 text-sm font-bold leading-none text-slate-700 shadow-sm transition hover:bg-slate-200"
                            @click="showInfo('email')" aria-label="Email help">
                            ?
                        </button>
                        <p x-text="errors.Email" x-show="errors.Email" class="text-red-600 text-sm mt-1"></p>
                    </div>

                    <!-- Password + Confirm Password matching full width (like username/email) -->
                    <div class="col-span-2">
                        <div class="flex flex-col md:flex-row gap-4 w-full">
                            <!-- Password Field -->
                            <div class="w-full relative">
                                <input :type="showPassword ? 'text' : 'password'" x-model="Password" name="Password"
                                    @input="validatePassword" placeholder="Password" required
                                    class="block w-full h-12 rounded-md border border-gray-300 px-4 pr-12 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    :class="{
                                        'border-red-500': strength === 'weak' && Password.length > 0,
                                        'border-yellow-500': strength === 'medium',
                                        'border-green-500': strength === 'strong'
                                    }" />
                                <p x-text="errors.Password" x-show="errors.Password" class="text-red-600 text-sm mt-1">
                                </p>
                                <!-- Toggle icon -->
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute top-3 right-3 text-gray-600">
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

                            <!-- Confirm Password Field with Toggle -->
                            <div class="w-full relative">
                                <input :type="showConfirmPassword ? 'text' : 'password'" name="Password_confirmation"
                                    x-model="ConfirmPassword" @input="validateConfirmPassword"
                                    placeholder="Confirm Password" required
                                    class="h-12 w-full rounded-md border border-gray-300 px-4 pr-12 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <p x-show="errors.ConfirmPassword" x-text="errors.ConfirmPassword"
                                    class="text-sm text-red-600 mt-1"></p>

                                <!-- Eye Toggle -->
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute top-3 right-3 text-gray-600">
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
                        <p class="text-gray-500 text-xs mt-2">
                            Password must contain minimum 8 characters, with at least one uppercase, lowercase, number, and special character.
                        </p>
                    </div>


                </div>

                <!-- Dynamic Fields Placeholder -->
                <div id="dynamic-user-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

                <!-- Guidance Modal -->
                <div x-show="showInfoModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/40" @click="closeInfo()"></div>
                    <div class="relative bg-white rounded-lg shadow-lg max-w-lg w-full p-6">
                        <div class="flex items-start justify-end gap-4 mb-4">
                            <button type="button" @click="closeInfo()" class="text-gray-500 hover:text-gray-900">✕</button>
                        </div>
                        <div class="text-sm text-gray-700" x-html="infoText"></div>
                        <div class="mt-6 text-right">
                            <button type="button" @click="closeInfo()" class="px-4 py-2 rounded bg-indigo-600 text-white">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="space-y-2 text-sm text-gray-700">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="Terms" required
                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary focus:ring-2" />
                        <span>Accept Terms and Conditions</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="Privacy" required
                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary focus:ring-2" />
                        <span>Accept Privacy Policy</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="GDPR"
                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary focus:ring-2" />
                        <span>I accept GDPR</span>
                    </label>
                </div>

                <!-- Button -->
                <div class="flex items-center justify-between mt-4">
                    <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

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