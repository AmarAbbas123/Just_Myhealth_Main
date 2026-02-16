<x-guest-layout>
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row mx-auto">
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
                        <x-text-input name="UserName" placeholder="UserName" x-model="UserName"
                            @input="validateUserName" @blur="checkUsernameExists"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 pr-10"
                            required />
                        <p x-text="errors.UserName" x-show="errors.UserName" class="text-red-600 text-sm mt-1"></p>
                    </div>

                    <div class="relative col-span-2">
                        <x-text-input name="Email" placeholder="Email" x-model="Email" @input="validateEmail"
                            @blur="() => { validateEmail(); }"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 pr-10"
                            required />
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
                                <!-- Strength -->
                                <div class="text-sm mt-1" x-show="Password.length > 0">
                                    <template x-if="strength === 'weak'">
                                        <span class="text-red-600">Weak Password</span>
                                    </template>
                                    <template x-if="strength === 'medium'">
                                        <span class="text-yellow-600">Medium strength</span>
                                    </template>
                                    <template x-if="strength === 'strong'">
                                        <span class="text-green-600">Strong Password</span>
                                    </template>
                                </div>
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
                    </div>


                </div>

                <!-- Dynamic Fields Placeholder -->
                <div id="dynamic-user-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

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
    const medicalOptions = @json(config('medical_options'));
    const professionalOptions = @json(config('professional_options'));

    function loadUserFields(userTypeId) {
        const fields = userFieldMap[userTypeId] || [];
        const container = document.getElementById('dynamic-user-fields');
        container.innerHTML = '';

        fields.forEach(field => {
            if (field === 'BusinessPrimaryIndustry') {
                container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" onchange="handleNotListed(this, '${field}'); loadSubIndustry(this.value)">
                        ${businessOptions.BusinessPrimaryIndustry.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify Industry" style="display:none;" />
                `;
            } else if (field === 'BusinessSubIndustry') {
                container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" id="subindustry" onchange="handleNotListed(this, '${field}')"></select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify SubIndustry" style="display:none;" />
                `;
            } else if (field === 'BusinessType') {
                container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" onchange="handleNotListed(this, '${field}')">
                        ${businessOptions.BusinessType.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                    <input type="text" name="ProfileData[${field}_Custom]" placeholder="Specify Business Type" style="display:none;" />
                `;
            } else if (field === 'Country') {
                if (userTypeId === '10') {
                    container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" id="country-dropdown" onchange="loadStates(this.value)">
                        ${userOptions.Country.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                `;

                } else {
                    // For standard/therapy users -> text input
                    container.innerHTML += `
                    <label>${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="border rounded px-2 py-1" placeholder="Enter ${field}" />
                 `;
                }


            } else if (field === 'State') {
                if (userTypeId === '10') {
                    container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" id="state-dropdown" onchange="loadCities(this.value)"></select>
                `;
                } else {
                    container.innerHTML += `
                    <label>${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="border rounded px-2 py-1" placeholder="Enter ${field}" />
                `;
                }
            } else if (field === 'City') {
                if (userTypeId === '10') {
                container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" id="city-dropdown"></select>
                `;
                } else {
                    container.innerHTML += `
                    <label>${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="border rounded px-2 py-1" placeholder="Enter ${field}" />
                `;
                }
            } else if (userOptions[field]) {
                container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]">
                        ${userOptions[field].map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                    </select>
                `;
            } else if (field === 'DOB' || field === 'DateOfBirth') {
                container.innerHTML += `
                    <label>${field}</label>
                    <input type="date" name="ProfileData[${field}]" class="border rounded px-2 py-1" />
                `;
            } else if (field === 'YearBirth') {
                const currentYear = new Date().getFullYear();
                let yearOptions = '';
                for (let y = currentYear; y >= 1920; y--) {
                    yearOptions += `<option value="${y}">${y}</option>`;
                }
                container.innerHTML += `
                    <label>${field}</label>
                    <select name="ProfileData[${field}]" class="border rounded px-2 py-1">
                        <option value="">Select Year</option>
                        ${yearOptions}
                    </select>
                `;
            } else {
                container.innerHTML += `
                    <label>${field}</label>
                    <input type="text" name="ProfileData[${field}]" class="border rounded px-2 py-1" />
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
            stateDropdown.innerHTML = states.map(s => `<option value="${s}">${s}</option>`).join('');
        }

        if (states.length && cityDropdown) {
            loadCities(states[0]);
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
            }
        };
    }
</script>
