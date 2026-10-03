@php
    $userType = Auth::user()->UserType;
    $profileData = Auth::user()->ProfileData ?? [];
    $userFields = config("user_fields.$userType", []);
    $userOptions = config('user_options');
    $businessOptions = config('business_options');
    $medicalOptions = config('medical_options');
    $professionalOptions = config('professional_options');
    $allOptions = array_merge($userOptions, $businessOptions, $medicalOptions, $professionalOptions);
    use Illuminate\Support\Str;
    $normalizedState = Str::ucfirst($profileData['BaseState'] ?? ($profileData['State'] ?? ''));
@endphp

<section x-data="{
    emailEditMode: false,
    profileData: {{ Js::from($profileData) }},
    industry: '{{ $profileData['BusinessPrimaryIndustry'] ?? '' }}',
    subIndustry: '{{ $profileData['BusinessSubIndustry'] ?? '' }}',
    country: '{{ $profileData['BaseCountry'] ?? ($profileData['Country'] ?? '') }}',
    state: '{{ $profileData['BaseState'] ?? ($profileData['State'] ?? '') }}',
    city: '{{ $profileData['BaseCity'] ?? ($profileData['City'] ?? '') }}',
    statesByCountry: {{ Js::from($userOptions['State'] ?? []) }},
    citiesByState: {{ Js::from($userOptions['City'] ?? []) }},
    businessSubIndustriesByIndustry: {{ Js::from($businessOptions['BusinessSubIndustry'] ?? []) }},
    get filteredStates() {
        return this.statesByCountry[this.country] || [];
    },
    get filteredCities() {
        return this.citiesByState[this.state] || [];
    },
    get filteredSubIndustries() {
        return this.businessSubIndustriesByIndustry[this.industry] || [];
    }
}">

    <div class="border-b border-gray-100 dark:border-gray-700 pb-5 mb-6">
        <div class="flex items-center gap-3">
            <div class="p-2.5 rounded-2xl text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Profile Information') }}</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Update your personal details and contact preferences.') }}
                    <span class="font-semibold text-teal-600 dark:text-teal-400">(User Type: {{ $userType }})</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Success Message/Notification/Alert --}}
    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-2xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong class="font-semibold text-sm">Success!</strong>
                <span class="text-xs sm:text-sm ml-1">Profile updated successfully.</span>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}"
        x-on:submit="if (emailEditMode) { if (!confirm('Are you sure you want to change your email?')) return false; }">
        @csrf
        @method('PATCH')

        <input type="hidden" name="UserType" value="{{ Auth::user()->UserType }}">

        {{-- USERNAME & EMAIL CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-6 p-4 sm:p-5 rounded-2xl bg-gray-50/70 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-700/60 w-full min-w-0">
            {{-- USERNAME --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <x-input-label for="UserName" value="User Name" class="text-xs font-semibold text-gray-700 dark:text-gray-300" />
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Fixed
                    </span>
                </div>
                <x-text-input id="UserName" name="UserName" type="text"
                    class="block w-full bg-gray-100 dark:bg-gray-900/60 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 cursor-not-allowed text-sm rounded-xl"
                    value="{{ $user->UserName }}" readonly />
            </div>

            {{-- EMAIL (toggle-editable) --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <x-input-label for="Email" value="Email Address" class="text-xs font-semibold text-gray-700 dark:text-gray-300" />
                </div>
                <div class="relative">
                    <x-text-input id="Email" name="Email" type="email" class="block w-full pr-20 text-sm rounded-xl transition"
                        x-bind:class="emailEditMode ? 'bg-white dark:bg-gray-900 border-teal-500 ring-2 ring-teal-500/20' : 'bg-gray-100 dark:bg-gray-900/60 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 cursor-not-allowed'"
                        x-bind:readonly="!emailEditMode" x-bind:disabled="!emailEditMode"
                        value="{{ old('Email', $user->Email) }}" required />
                    <button type="button" class="absolute top-0 right-0 h-full px-3 text-xs font-semibold text-teal-600 dark:text-teal-400 hover:text-teal-700 transition"
                        x-on:click="emailEditMode = !emailEditMode">
                        <span x-show="!emailEditMode">Edit</span>
                        <span x-show="emailEditMode" class="text-red-500 hover:text-red-600">Cancel</span>
                    </button>
                </div>
                @if ($user->Pending_Email)
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1.5 flex items-center gap-1">
                        Pending verification: <strong>{{ $user->Pending_Email }}</strong>
                    </p>
                @endif
            </div>
        </div>

        {{-- DYNAMIC PROFILE DATA FIELDS --}}
        @if (!empty($userFields))
            <div class="mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400 mb-3">Additional Information</h3>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 w-full min-w-0">
            @foreach ($userFields as $field)
                @php
                    $value = old("ProfileData.$field", $profileData[$field] ?? '');
                    $isMulti = is_array($profileData[$field] ?? null);
                    $valueArray = $isMulti ? $profileData[$field] ?? [] : [$value];

                    $label = \Illuminate\Support\Str::headline($field);

                    $isCountry = in_array($field, ['BaseCountry', 'Country']);
                    $isState = in_array($field, ['BaseState', 'State']);
                    $isCity = in_array($field, ['BaseCity', 'City']);
                    $isIndustry = $field === 'BusinessPrimaryIndustry';
                    $isSubIndustry = $field === 'BusinessSubIndustry';
                @endphp

                {{-- Country --}}
                @if ($isCountry)
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            x-model="country" @change="state = ''; city = ''">
                            <option value="">-- Select Country --</option>
                            @foreach ($userOptions['Country'] ?? [] as $option)
                                <option value="{{ $option }}" :selected="'{{ $option }}' === country">
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- State --}}
                @elseif ($isState)
                    @php
                        $countryKey = $profileData['BaseCountry'] ?? ($profileData['Country'] ?? null);
                        $statesForCountry = $userOptions['State'][$countryKey] ?? [];
                    @endphp
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            x-model="state" @change="city = ''">
                            <option value="">-- Select State --</option>
                            <template x-for="option in filteredStates" :key="option">
                                <option :value="option" x-text="option" :selected="option === state"></option>
                            </template>
                        </select>
                    </div>

                    {{-- City --}}
                @elseif ($isCity)
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            x-model="city">
                            <option value="">-- Select City --</option>
                            <template x-for="option in filteredCities" :key="option">
                                <option :value="option" x-text="option" :selected="option === city"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Business Industry --}}
                @elseif ($isIndustry)
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            x-model="industry" @change="subIndustry = ''">
                            <option value="">-- Select Industry --</option>
                            @foreach ($businessOptions['BusinessPrimaryIndustry'] ?? [] as $option)
                                <option value="{{ $option }}" :selected="'{{ $option }}' === industry">
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Business SubIndustry --}}
                @elseif ($isSubIndustry)
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            x-model="subIndustry">
                            <option value="">-- Select Sub Industry --</option>
                            <template x-for="option in filteredSubIndustries" :key="option">
                                <option :value="option" x-text="option" :selected="option === subIndustry">
                                </option>
                            </template>
                        </select>
                    </div>

                    {{-- Generic Dropdown --}}
                @elseif (isset($allOptions[$field]))
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}"
                            name="ProfileData[{{ $field }}]{{ $isMulti ? '[]' : '' }}"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            {{ $isMulti ? 'multiple' : '' }}>
                            @foreach ($allOptions[$field] as $option)
                                @php
                                    $optionValue = is_array($option) ? $option['value'] ?? '' : $option;
                                    $optionLabel = is_array($option) ? $option['label'] ?? $optionValue : $option;
                                @endphp
                                <option value="{{ $optionValue }}" @selected(in_array($optionValue, $valueArray))>
                                    {{ $optionLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Handle Special Field Types --}}
                @elseif(in_array($field, ['DoB', 'DateOfBirth']))
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <input type="date" id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            value="{{ $value }}"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" />
                    </div>
                @elseif($field === 'YearOfBirth')
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                            <option value="">Select Year</option>
                            @php
                                $currentYear = now()->year;
                                for ($y = $currentYear; $y >= 1920; $y--) {
                                    echo '<option value="' .
                                        $y .
                                        '"' .
                                        ($value == $y ? ' selected' : '') .
                                        '>' .
                                        $y .
                                        '</option>';
                                }
                            @endphp
                        </select>
                    </div>

                    {{-- Default Text Input --}}
                @else
                    <div>
                        <x-input-label :for="$field" :value="$label" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
                        <x-text-input id="{{ $field }}" name="ProfileData[{{ $field }}]" type="text"
                            value="{{ $value }}"
                            class="block w-full rounded-xl" />
                    </div>
                @endif
            @endforeach
        </div>

        {{-- SAVE BUTTON --}}
        <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white shadow-md shadow-teal-500/10 hover:shadow-teal-500/25 transition-all duration-150 cursor-pointer"
                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Save Changes') }}
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>

    </form>

</section>
