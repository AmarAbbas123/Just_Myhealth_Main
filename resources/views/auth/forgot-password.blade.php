<x-guest-layout>
    <div class="w-full max-w-4xl bg-white/95 backdrop-blur rounded-lg shadow-xl overflow-hidden flex flex-col md:flex-row mx-auto mt-10 md:mt-16 border border-indigo-50">
        <!-- Left Image (same style as Sign In) -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('/images/bg-1.jpg');"></div>

        <!-- Right Content -->
        <div class="w-full md:w-1/2 p-8 md:p-10 bg-gradient-to-br from-white via-indigo-50/40 to-white">
            <p class="text-xs font-semibold tracking-wide text-indigo-500 uppercase mb-2">
                {{ __('Account security') }}
            </p>

            <h2 class="text-3xl md:text-3xl font-semibold text-gray-900 mb-3">
                {{ __('Reset your password') }}
            </h2>

            <p class="mb-6 text-sm md:text-base text-gray-600 leading-relaxed">
                {{ __('Enter the username or email associated with your account and we’ll send you a secure link to create a new password.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Username or Email -->
                <div>
                    <x-input-label for="LoginField" :value="__('Username or Email')" />
                    <x-text-input
                        id="LoginField"
                        class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="text"
                        name="LoginField"
                        :value="old('LoginField')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('LoginField')" class="mt-2" />
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                    <a href="{{ route('login') }}" class="text-sm text-indigo-500 hover:text-indigo-600 hover:underline transition-colors">
                        {{ __('Back to Sign In') }}
                    </a>

                    <x-primary-button class="w-full sm:w-auto justify-center">
                        {{ __('Send reset link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>