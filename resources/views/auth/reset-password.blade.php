<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Username -->
        <div>
            <x-input-label for="UserName" :value="__('Username')" />
            <x-text-input id="UserName" class="block mt-1 w-full bg-gray-100 cursor-not-allowed"  type="text" name="UserName" :value="old('UserName', $request->username)" readonly />
            <x-input-error :messages="$errors->get('UserName')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="Password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="Password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="Password_confirmation" class="block mt-1 w-full" type="password"
                name="Password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('Password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
