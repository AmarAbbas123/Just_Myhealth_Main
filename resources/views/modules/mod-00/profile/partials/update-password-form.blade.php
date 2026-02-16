<section x-data="passwordForm()" x-init="init()">
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    {{-- Success message --}}
    @if (request('status') === 'password-updated')
        <div id="flash-msg" class="bg-green-500 text-white p-4">
            ✅ Password updated successfully.
        </div>

        {{-- Error message --}}
    @elseif (request('status') === 'password-error')
        <div id="flash-msg" class="bg-red-500 text-white p-4">
            ❌ Password could not be updated. Please try again.
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


    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6" x-ref="form">

        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full"
                x-model="currentPassword" @blur="checkCurrentPassword" />
            <template x-if="errors.currentPassword">
                <p class="text-red-600 text-sm mt-1" x-text="errors.currentPassword"></p>
            </template>
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="Password" :value="__('New Password')" />
            <x-text-input id="Password" name="Password" type="password" class="mt-1 block w-full" x-model="newPassword"
                @input="validateNewPassword" />
            <template x-if="errors.newPassword">
                <p class="text-red-600 text-sm mt-1" x-text="errors.newPassword"></p>
            </template>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="Password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="Password_confirmation" name="Password_confirmation" type="password"
                class="mt-1 block w-full" x-model="confirmPassword" @input="validateConfirmPassword" />
            <template x-if="errors.confirmPassword">
                <p class="text-red-600 text-sm mt-1" x-text="errors.confirmPassword"></p>
            </template>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
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
