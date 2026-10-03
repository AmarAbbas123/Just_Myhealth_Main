{{-- resources/views/modules/mod-00/profile/edit.blade.php -------------------------------- --}}
<x-app1>
    <div class="space-y-6 max-w-6xl mx-auto pb-10 w-full min-w-0 max-w-full">

        {{-- Top navigation / Back link --}}
        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700 shadow-sm text-xs font-semibold text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:border-teal-400 dark:hover:border-teal-500 transition group">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Dashboard</span>
            </a>
        </div>

        {{-- ── HERO & PROFILE CARD ─────────────────────────────────────────── --}}
        <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden border border-gray-200/80 dark:border-gray-700 shadow-sm bg-white dark:bg-gray-800 transition-colors duration-200 w-full min-w-0">
            
            {{-- Cover photo container --}}
            <div class="h-36 sm:h-56 lg:h-64 w-full relative bg-cover bg-center overflow-hidden"
                style="background: linear-gradient(135deg, #0e7490 0%, #0d9488 40%, #14b8a6 75%, #0284c7 100%); {{ Auth::user()->HeaderPhotoPath ? "background-image: url('" . asset('storage/' . Auth::user()->HeaderPhotoPath) . "');" : '' }}">
                
                {{-- Decorative gradient overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/15 to-transparent"></div>

                {{-- Subtle decorative SVG geometric shapes for default cover --}}
                @if (!Auth::user()->HeaderPhotoPath)
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <svg class="w-full h-full" viewBox="0 0 800 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="700" cy="50" r="180" stroke="white" stroke-width="40" opacity="0.3" />
                            <circle cx="100" cy="300" r="140" stroke="white" stroke-width="30" opacity="0.3" />
                            <path d="M400 -50 L550 200 L250 200 Z" stroke="white" stroke-width="20" opacity="0.2" />
                        </svg>
                    </div>
                @endif

                {{-- Change cover btn --}}
                <form action="{{ route('profile.header.upload') }}" method="POST" enctype="multipart/form-data"
                    x-data="{ preview: null }" class="absolute bottom-3 right-3 sm:bottom-4 sm:right-4 z-10">
                    @csrf
                    <input type="file" name="header" accept="image/*" class="hidden" x-ref="headerInput"
                        @change="preview = URL.createObjectURL($event.target.files[0]); $el.form.submit()">

                    <button type="button"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-black/40 hover:bg-black/60 text-white backdrop-blur-md border border-white/20 text-xs font-semibold shadow transition cursor-pointer"
                        x-on:click.prevent="$refs.headerInput.click()">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Change Cover</span>
                    </button>
                </form>
            </div>

            {{-- Profile Details Bar --}}
            <div class="px-4 sm:px-8 py-5 sm:py-6 bg-white dark:bg-gray-800 w-full min-w-0">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 sm:gap-6 w-full min-w-0">
                    
                    {{-- Avatar & Identity --}}
                    <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 w-full sm:w-auto min-w-0">
                        
                        {{-- Avatar container (Centered on mobile, reserved height for smooth vertical centering) --}}
                        <div class="relative w-24 h-14 sm:w-28 sm:h-16 md:w-32 md:h-18 shrink-0 mx-auto sm:mx-0" x-data="{ preview: null }">
                            <div class="absolute bottom-0 left-0 w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 rounded-2xl ring-4 ring-white dark:ring-gray-800 shadow-xl overflow-hidden bg-white dark:bg-gray-800 flex items-center justify-center group">
                                @php
                                    $hasAvatar = !empty(Auth::user()->ProfilePhotoPath) && Storage::disk('public')->exists(Auth::user()->ProfilePhotoPath);
                                @endphp
                                @if ($hasAvatar)
                                    <img :src="preview ? preview : '{{ asset('storage/' . Auth::user()->ProfilePhotoPath) }}'"
                                        class="w-full h-full object-cover">
                                @else
                                    <template x-if="preview">
                                        <img :src="preview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!preview">
                                        <div class="w-full h-full flex items-center justify-center text-white text-3xl sm:text-4xl font-extrabold shadow-inner"
                                            style="background: linear-gradient(135deg, #1F9CA1, #0e7490);">
                                            {{ strtoupper(substr(Auth::user()->UserName ?? 'U', 0, 1)) }}
                                        </div>
                                    </template>
                                @endif

                                {{-- Change photo hover overlay --}}
                                <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="avatar" accept="image/*" class="hidden" x-ref="avatarInput"
                                        @change="preview = URL.createObjectURL($event.target.files[0]); $el.form.submit()">

                                    <button type="button"
                                        class="absolute inset-0 rounded-2xl bg-black/60 text-white opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center gap-1 transition-all duration-200 cursor-pointer backdrop-blur-[2px]"
                                        x-on:click.prevent="$refs.avatarInput.click()" aria-label="Change photo">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-[10px] sm:text-xs font-semibold tracking-wide uppercase">Edit Photo</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Name, Email, and Badges (Centered on mobile, fluid wrapping) --}}
                        <div class="text-center sm:text-left min-w-0 w-full sm:w-auto">
                            @php
                                $uType = (int) Auth::user()->UserType;
                                $roleLabel = match(true) {
                                    in_array($uType, [90, 91, 99]) => 'Administrator',
                                    in_array($uType, [30, 31, 32]) => 'Therapist',
                                    $uType === 10                  => 'Business',
                                    in_array($uType, [1, 2, 3])    => 'Member',
                                    default                        => 'User',
                                };
                            @endphp

                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                <h1 class="text-xl sm:text-2xl lg:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight break-words">
                                    {{ Auth::user()->UserName }}
                                </h1>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 border border-teal-200/80 dark:border-teal-700/50 shadow-xs shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                                    {{ $roleLabel }}
                                </span>
                            </div>

                            <div class="mt-2.5 flex flex-wrap items-center justify-center sm:justify-start gap-2 text-xs w-full">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200/70 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-medium max-w-full">
                                    <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate max-w-[170px] sm:max-w-xs">{{ Auth::user()->Email }}</span>
                                </span>

                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/70 dark:border-emerald-800/50 text-emerald-700 dark:text-emerald-300 font-medium shrink-0">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>Active Account</span>
                                </span>
                            </div>
                        </div>

                    </div>

                    {{-- Right side verified badge --}}
                    <div class="flex items-center justify-center lg:justify-end shrink-0 pt-1 lg:pt-0 w-full lg:w-auto">
                        <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-teal-50/60 dark:bg-teal-950/30 border border-teal-200/80 dark:border-teal-800/50 text-xs font-semibold text-teal-700 dark:text-teal-300 shadow-xs">
                            <svg class="w-4 h-4 text-teal-600 dark:text-teal-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Verified Member</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── TABBED NAVIGATION & FORMS ──────────────────────────────────── --}}
        <div x-data="{ activeTab: 'profile' }" class="space-y-6 w-full min-w-0 max-w-full">

            {{-- Segmented Tabs (Grid-based so all 3 tabs are always visible on mobile) --}}
            <div class="w-full max-w-full rounded-2xl bg-gray-100 dark:bg-gray-800/80 border border-gray-200/80 dark:border-gray-700/80 p-1.5">
                <div class="grid grid-cols-3 gap-1 sm:gap-2 w-full">
                    <button type="button"
                        @click="activeTab = 'profile'"
                        :class="activeTab === 'profile' ? 'bg-white dark:bg-gray-700 text-teal-700 dark:text-teal-300 shadow-sm font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 font-medium'"
                        class="inline-flex items-center justify-center gap-1.5 sm:gap-2 px-1.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-150">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="sm:hidden">Profile</span>
                        <span class="hidden sm:inline">Profile Information</span>
                    </button>

                    <button type="button"
                        @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'bg-white dark:bg-gray-700 text-teal-700 dark:text-teal-300 shadow-sm font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 font-medium'"
                        class="inline-flex items-center justify-center gap-1.5 sm:gap-2 px-1.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-150">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="sm:hidden">Security</span>
                        <span class="hidden sm:inline">Security & Password</span>
                    </button>

                    <button type="button"
                        @click="activeTab = 'danger'"
                        :class="activeTab === 'danger' ? 'bg-white dark:bg-gray-700 text-red-600 dark:text-red-400 shadow-sm font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 font-medium'"
                        class="inline-flex items-center justify-center gap-1.5 sm:gap-2 px-1.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-150">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="sm:hidden">Account</span>
                        <span class="hidden sm:inline">Account Settings</span>
                    </button>
                </div>
            </div>

            {{-- Tab 1: Profile Information --}}
            <div x-show="activeTab === 'profile'"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-200/80 dark:border-gray-700 shadow-sm p-4 sm:p-8 transition-colors duration-200 w-full min-w-0 max-w-full overflow-hidden">
                @include('modules.mod-00.profile.partials.update-profile-information-form')
            </div>

            {{-- Tab 2: Security & Password --}}
            <div x-show="activeTab === 'security'"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-200/80 dark:border-gray-700 shadow-sm p-4 sm:p-8 transition-colors duration-200 w-full min-w-0 max-w-full overflow-hidden">
                @include('modules.mod-00.profile.partials.update-password-form')
            </div>

            {{-- Tab 3: Account Deletion (Danger Zone) --}}
            <div x-show="activeTab === 'danger'"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-200/80 dark:border-gray-700 shadow-sm p-4 sm:p-8 transition-colors duration-200 w-full min-w-0 max-w-full overflow-hidden">
                @include('modules.mod-00.profile.partials.delete-user-form')
            </div>

        </div>

    </div>
</x-app1>
