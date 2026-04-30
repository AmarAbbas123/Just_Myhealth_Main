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

    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your profile based on your user type.') }}
            <span class="font-semibold text-indigo-700">({{ $userType }})</span>
        </p>
    </header>

    {{-- Success Message/Notification/ALert --}}
    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
            <strong class="font-bold">Success:</strong>
            <span class="block sm:inline">Profile updated successfully.</span>
        </div>
    @endif


    <form method="POST" action="{{ route('profile.update') }}"
        x-on:submit="if (emailEditMode) { if (!confirm('Are you sure?')) return false; }">
        @csrf
        @method('PATCH')

        <input type="hidden" name="UserType" value="{{ Auth::user()->UserType }}">

        {{-- USERNAME --}}
        <div>
            <x-input-label for="UserName" value="User Name" />
            <x-text-input id="UserName" name="UserName" type="text"
                class="mt-1 block w-full bg-gray-100 cursor-not-allowed" value="{{ $user->UserName }}" readonly />
        </div>


        {{-- EMAIL (toggle-editable) --}}
        <div>
            <x-input-label for="Email" value="Email Address" />
            <div class="relative">
                <x-text-input id="Email" name="Email" type="email" class="mt-1 block w-full pr-24"
                    x-bind:class="emailEditMode ? 'bg-white cursor-text' : 'bg-gray-100 cursor-not-allowed'"
                    x-bind:readonly="!emailEditMode" x-bind:disabled="!emailEditMode"
                    value="{{ old('Email', $user->Email) }}" required />
                <button type="button" class="absolute top-0 right-0 h-full px-3 text-sm text-blue-600 hover:underline"
                    x-on:click="emailEditMode = !emailEditMode">
                    <span x-show="!emailEditMode">Change</span>
                    <span x-show="emailEditMode">Cancel</span>
                </button>
            </div>
            @if ($user->Pending_Email)
                <p class="text-sm text-yellow-600 mt-1">
                    Pending email: <strong>{{ $user->Pending_Email }}</strong> (awaiting verification)
                </p>
            @endif
        </div>

        {{-- DYNAMIC PROFILE DATA FIELDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-model="country"
                            @change="state = ''; city = ''">
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
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-model="state"
                            @change="city = ''">
                            <option value="">-- Select State --</option>
                            <template x-for="option in filteredStates" :key="option">
                                <option :value="option" x-text="option" :selected="option === state"></option>
                            </template>
                        </select>

                    </div>

                    {{-- City --}}
                @elseif ($isCity)
                    <div>
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-model="city">
                            <option value="">-- Select City --</option>
                            <template x-for="option in filteredCities" :key="option">
                                <option :value="option" x-text="option" :selected="option === city"></option>
                            </template>
                        </select>

                    </div>

                    {{-- Business Industry --}}
                @elseif ($isIndustry)
                    <div>
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-model="industry"
                            @change="subIndustry = ''">
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
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-model="subIndustry">
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
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}"
                            name="ProfileData[{{ $field }}]{{ $isMulti ? '[]' : '' }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
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
                        <x-input-label :for="$field" :value="$label" />
                        <input type="date" id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            value="{{ $value }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    </div>
                @elseif($field === 'YearOfBirth')
                    <div>
                        <x-input-label :for="$field" :value="$label" />
                        <select id="{{ $field }}" name="ProfileData[{{ $field }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                        <x-input-label :for="$field" :value="$label" />
                        <x-text-input id="{{ $field }}" name="ProfileData[{{ $field }}]" type="text"
                            value="{{ $value }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    </div>
                @endif
            @endforeach
        </div>

        {{-- SAVE BUTTON --}}
        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>


    </form>


</section>
