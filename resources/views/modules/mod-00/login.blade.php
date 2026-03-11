<x-guest-layout>
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

    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row mx-auto">
        <!-- Left Image -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('/images/bg-1.jpg');"></div>

        <!-- Right Form -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Sign In</h2>

            <!-- Social Icons -->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('social.redirect', 'google') }}" class="text-blue-600 hover:text-blue-800"> <img
                        src="{{ asset('images/google-brands.svg') }}" alt="Google" class="h-6 w-6" /></a>
                <a href="{{ route('social.redirect', 'facebook') }}" class="text-blue-600 hover:text-blue-800"> <img
                        src="{{ asset('images/facebook-f-brands.svg') }}" alt="Facebook" class="h-6 w-6" /></a>
                <a href="{{ route('social.redirect', 'twitter') }}" class="text-blue-600 hover:text-blue-800"> <img
                        src="{{ asset('images/x-twitter-brands.svg') }}" alt="twitter" class="h-6 w-6" /></a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.perform') }}" x-data="{ username: '', showPassword: false, error: '' }">
                @csrf

                {{-- <div class="mb-4">
                    <a href="{{ route('login.keycloak') }}"
                     class="flex w-full justify-center items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-indigo-600 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                      Login with SSO
                   </a>
                 </div>    --}}

                <!-- Username -->
                <div>
                    <x-input-label for="UserName" :value="__('Username')" />
                    <x-text-input id="UserName" class="block mt-1 w-full" type="text" name="UserName"
                        x-model="username"
                        @input="
                        if (/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(username)) {
                            error = '❌ Only Username is allowed, not Email.';
                        } else {
                            error = '';
                        }
                    "
                        x-bind:class="error.length > 0 ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''"
                        required autofocus autocomplete="username" />

                    <!-- Live validation message -->
                    <p x-show="error" x-text="error" class="text-red-600 text-sm mt-1"></p>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="Password" :value="__('Password')" />

                    <div class="relative">
                        <input id="Password"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm 
                             focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            :type="showPassword ? 'text' : 'password'" name="Password" required
                            autocomplete="current-password" />

                        <!-- Toggle button -->
                        <button type="button"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
                            @click="showPassword = !showPassword" type="button">
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.127-3.592M6.343 6.343A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.132 4.132M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Submit and Forgot Password -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3" x-bind:disabled="error.length > 0"
                        x-bind:class="{ 'opacity-50 cursor-not-allowed': error.length > 0 }">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>



            <p class="text-center text-sm mt-6 text-gray-600">
                {{ __('Not a member?') }}
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                    {{ __('Sign up') }}
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
