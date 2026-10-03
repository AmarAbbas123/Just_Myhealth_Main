<section class="space-y-6">
    <div class="border-b border-gray-100 dark:border-gray-700 pb-5 mb-6">
        <div class="flex items-center gap-3">
            <div class="p-2.5 rounded-2xl text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Delete Account') }}</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Permanently remove your account and all associated personal data.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="p-5 rounded-2xl bg-red-50/50 dark:bg-red-950/20 border border-red-200/80 dark:border-red-900/40">
        <h4 class="text-sm font-bold text-red-800 dark:text-red-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Warning: This action is permanent and irreversible
        </h4>
        <p class="mt-1.5 text-xs sm:text-sm text-red-700 dark:text-red-400 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources, profiles, and data will be permanently removed. Before deleting your account, please ensure you have saved any necessary information.') }}
        </p>

        <div class="mt-4 pt-3 border-t border-red-200/60 dark:border-red-900/40">
            <button
                type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs sm:text-sm font-semibold shadow transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                {{ __('Delete Account') }}
            </button>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="Password"
                    type="password"
                    class="mt-1 block w-full sm:w-3/4 rounded-xl"
                    placeholder="{{ __('Enter your password to confirm') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('Password')" class="mt-2" />
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold shadow transition">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
