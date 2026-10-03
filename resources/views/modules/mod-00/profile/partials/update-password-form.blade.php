<section x-data="passwordForm()" x-init="init()">
    <div class="border-b border-gray-100 dark:border-gray-700 pb-5 mb-6">
        <div class="flex items-center gap-3">
            <div class="p-2.5 rounded-2xl text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Update Password') }}</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Success message --}}
    @if (request('status') === 'password-updated')
        <div id="flash-msg" class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 p-4 rounded-2xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-semibold">Password updated successfully.</span>
        </div>

        {{-- Error message --}}
    @elseif (request('status') === 'password-error')
        <div id="flash-msg" class="flex items-center gap-3 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 p-4 rounded-2xl mb-6 shadow-sm">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm font-semibold">Password could not be updated. Please try again.</span>
        </div>
    @endif

    @if (request('status'))
        <script>
            // Hide after 5 seconds
            setTimeout(() => {
                document.getElementById('flash-msg')?.remove();
            }, 5000);

            // Remove the ?status=... from the URL WITHOUT RELOADING
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('status');
                window.history.replaceState({}, document.title, url.toString());
            }
        </script>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5 max-w-xl" x-ref="form">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
            <x-text-input id="current_password" name="current_password" type="password" class="block w-full rounded-xl"
                placeholder="••••••••"
                x-model="currentPassword" @blur="checkCurrentPassword" />
            <template x-if="errors.currentPassword">
                <p class="text-red-600 dark:text-red-400 text-xs mt-1.5 flex items-center gap-1" x-text="errors.currentPassword"></p>
            </template>
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="Password" :value="__('New Password')" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
            <x-text-input id="Password" name="Password" type="password" class="block w-full rounded-xl"
                placeholder="At least 8 characters"
                x-model="newPassword"
                @input="validateNewPassword" />
            <template x-if="errors.newPassword">
                <p class="text-red-600 dark:text-red-400 text-xs mt-1.5 flex items-center gap-1" x-text="errors.newPassword"></p>
            </template>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="Password_confirmation" :value="__('Confirm Password')" class="mb-1 text-xs font-semibold text-gray-700 dark:text-gray-300" />
            <x-text-input id="Password_confirmation" name="Password_confirmation" type="password"
                placeholder="Re-enter your new password"
                class="block w-full rounded-xl" x-model="confirmPassword" @input="validateConfirmPassword" />
            <template x-if="errors.confirmPassword">
                <p class="text-red-600 dark:text-red-400 text-xs mt-1.5 flex items-center gap-1" x-text="errors.confirmPassword"></p>
            </template>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white shadow-md shadow-teal-500/10 hover:shadow-teal-500/25 transition-all duration-150 cursor-pointer"
                style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Update Password') }}
            </button>
        </div>
    </form>

    <!-- Alpine.js logic -->
    <script>
        function passwordForm() {
            return {
                currentPassword: '',
                newPassword: '',
                confirmPassword: '',
                errors: {
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: ''
                },
                init() {
                    // Called on load
                },
                checkCurrentPassword() {
                    if (this.currentPassword === '') {
                        this.errors.currentPassword = 'Current password is required.';
                        return Promise.resolve(); // still resolve
                    }
                    return fetch('{{ route('verify.current.password') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                current_password: this.currentPassword
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.errors.currentPassword = data.valid ? '' : 'Current password is incorrect.';
                        });
                },
                validateNewPassword() {
                    this.errors.newPassword = this.newPassword.length < 8 ?
                        'Password must be at least 8 characters.' : '';
                },
                validateConfirmPassword() {
                    this.errors.confirmPassword = this.newPassword !== this.confirmPassword ?
                        'Passwords do not match.' : '';
                },
                async validateBeforeSubmit(event) {
                    await this.checkCurrentPassword();
                    this.validateNewPassword();
                    this.validateConfirmPassword();

                    if (!this.errors.currentPassword && !this.errors.newPassword && !this.errors.confirmPassword) {
                        this.$refs.form.submit(); // ✅ Force full native submit
                    }
                }


            };
        }
    </script>
</section>
