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

    <div class="bg-slate-100 text-slate-900 py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-lg shadow-slate-200/50 lg:grid-cols-2">

                <div class="relative hidden overflow-hidden  lg:block">
                    <img src="{{ asset('images/bg-1.jpg') }}" alt="Sign in" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-white/90 via-white/60 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6">
                        <span class="inline-flex rounded-full bg-indigo-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-indigo-600">
                            Welcome back
                        </span>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">
                            Sign in to your account
                        </h2>
                        <p class="mt-2 max-w-lg text-sm leading-6 text-slate-600">
                            Access your dashboard, manage clients, and continue with your services.
                        </p>
                    </div>
                </div>

                <div class="px-6 py-5 sm:px-10 sm:py-7">
                    <div class="max-w-2xl">
                        <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-indigo-600">
                            Sign in
                        </span>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                            Sign In
                        </h1>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">
                            Enter your username and password to continue on JustMy.Health.
                        </p>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <a href="{{ route('social.redirect', 'google') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-900 shadow-sm transition hover:bg-slate-200">
                            <img src="{{ asset('images/google-brands.svg') }}" alt="Google" class="h-5 w-5" />
                        </a>
                        <a href="{{ route('social.redirect', 'facebook') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-900 shadow-sm transition hover:bg-slate-200">
                            <img src="{{ asset('images/facebook-f-brands.svg') }}" alt="Facebook" class="h-5 w-5" />
                        </a>
                        <a href="{{ route('social.redirect', 'twitter') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-900 shadow-sm transition hover:bg-slate-200">
                            <img src="{{ asset('images/x-twitter-brands.svg') }}" alt="Twitter" class="h-5 w-5" />
                        </a>
                        <span class="ml-auto text-sm text-slate-500">Or sign in with email</span>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-3xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 mt-5">
                            <ul class="list-disc list-inside pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.perform') }}" x-data="{ username: '', showPassword: false, error: '' }"
                        class="mt-8 w-full rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5 shadow-lg shadow-slate-200/50 space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="UserName" :value="__('Username')" />
                            <x-text-input id="UserName" class="block mt-1 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="UserName"
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
                            <p x-show="error" x-text="error" class="text-red-600 text-sm mt-1"></p>
                        </div>

                        <div>
                            <x-input-label for="Password" :value="__('Password')" />
                            <div class="relative mt-1">
                                <input id="Password"
                                    class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 pr-12 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :type="showPassword ? 'text' : 'password'" name="Password" required autocomplete="current-password" />
                                <button type="button"
                                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                                    @click="showPassword = !showPassword">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.127-3.592M6.343 6.343A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.132 4.132M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <input id="remember_me" type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                            <label for="remember_me" class="text-sm text-slate-700">{{ __('Remember me') }}</label>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="w-full sm:w-auto px-6 py-3 text-sm font-semibold"
                                x-bind:disabled="error.length > 0"
                                x-bind:class="{ 'opacity-50 cursor-not-allowed': error.length > 0 }">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <p class="text-center text-sm mt-6 text-slate-600">
                        {{ __('Not a member?') }}
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                            {{ __('Sign up') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
