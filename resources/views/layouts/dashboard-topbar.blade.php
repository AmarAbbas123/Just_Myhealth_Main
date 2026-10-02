<header class="z-10 bg-white border-b border-gray-200 shadow-sm h-14 flex items-center">
    <div class="flex items-center justify-between w-full h-full px-4 sm:px-6">

        {{-- Mobile hamburger --}}
        <button
            class="flex md:hidden items-center justify-center w-9 h-9 rounded-xl text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition focus:outline-none"
            @click="isSideMenuOpen = !isSideMenuOpen" aria-label="Open menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Search --}}
        <div class="flex-1 max-w-sm mx-4 hidden sm:block">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                </div>
                <input id="tableSearch" type="text" placeholder="Search…" aria-label="Search"
                    class="w-full h-9 pl-9 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400
                           focus:outline-none focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition" />
            </div>
        </div>

        {{-- Right actions --}}
        <ul class="flex items-center gap-1.5 shrink-0">

            {{-- Dark / Light toggle --}}
            <li>
                <button @click="$store.theme.toggle()" aria-label="Toggle color mode"
                    class="flex items-center justify-center w-9 h-9 rounded-xl text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition focus:outline-none">
                    <svg x-show="!$store.theme.dark" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z" />
                    </svg>
                    <svg x-show="$store.theme.dark" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36-6.36-.7.7M6.34 17.66l-.7.7M17.66 17.66l-.7-.7M6.34 6.34l-.7-.7M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z" />
                    </svg>
                </button>
            </li>

            @php
                $hideNotifications = in_array((int) optional(Auth::user())->UserType, [1, 30]);
            @endphp

            @if (!$hideNotifications)
            {{-- Notifications --}}
            <li class="relative" x-data="{ isNotificationsMenuOpen: false }" @keydown.escape.window="isNotificationsMenuOpen = false">
                <button @click="isNotificationsMenuOpen = !isNotificationsMenuOpen" aria-label="Notifications"
                    class="relative flex items-center justify-center w-9 h-9 rounded-xl text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition focus:outline-none">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>

                <div x-show="isNotificationsMenuOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="isNotificationsMenuOpen = false"
                    class="absolute right-0 mt-2 w-60 origin-top-right rounded-2xl bg-white border border-gray-100 shadow-xl z-50 overflow-hidden">

                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-xs font-semibold uppercase tracking-widest text-teal-600">Notifications</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <a href="#" class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-800 transition">
                            <span>Messages</span>
                            <span class="text-xs font-bold text-white bg-red-500 rounded-full px-1.5 py-0.5">13</span>
                        </a>
                        <a href="#" class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-800 transition">
                            <span>Sales</span>
                            <span class="text-xs font-bold text-white bg-red-500 rounded-full px-1.5 py-0.5">2</span>
                        </a>
                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-800 transition">Alerts</a>
                    </div>
                </div>
            </li>
            @endif

            {{-- Divider --}}
            <li class="h-5 w-px bg-gray-200 mx-0.5 hidden sm:block"></li>

            {{-- Profile --}}
            <li class="relative" x-data="{ isProfileMenuOpen: false }" @keydown.escape.window="isProfileMenuOpen = false">
                <button @click="isProfileMenuOpen = !isProfileMenuOpen" aria-label="Account"
                    class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-2xl bg-gray-50 border border-gray-100 hover:border-teal-200 hover:bg-teal-50/60 shadow-sm transition-all duration-200 focus:outline-none group">

                    @if (!empty(Auth::user()->ProfilePhotoPath) && Storage::disk('public')->exists(Auth::user()->ProfilePhotoPath))
                        <img class="object-cover w-8 h-8 rounded-xl ring-2 ring-white shadow"
                            src="{{ asset('storage/' . Auth::user()->ProfilePhotoPath) }}" alt="User" />
                    @else
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-bold shrink-0 shadow"
                            style="background: linear-gradient(135deg, #1F9CA1, #0e7490);">
                            {{ strtoupper(substr(Auth::user()->UserName ?? 'U', 0, 1)) }}
                        </div>
                    @endif

                    <div class="hidden sm:flex flex-col text-left leading-none gap-0.5">
                        <p class="text-xs font-semibold text-gray-800 max-w-[90px] truncate">{{ Auth::user()->UserName ?? 'Account' }}</p>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-500 inline-block"></span>
                            <span class="text-[10px] text-teal-600 font-medium">Online</span>
                        </span>
                    </div>
                    <svg class="hidden sm:block w-3 h-3 text-gray-400 group-hover:text-teal-600 transition shrink-0 ml-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="isProfileMenuOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="isProfileMenuOpen = false"
                    class="absolute right-0 mt-2 w-52 origin-top-right rounded-2xl bg-white border border-gray-100 shadow-xl overflow-hidden z-50"
                    aria-label="submenu">

                    {{-- Profile header --}}
                    <div class="px-4 py-3 border-b border-gray-100 bg-teal-50 flex items-center gap-3">
                        @if (!empty(Auth::user()->ProfilePhotoPath) && Storage::disk('public')->exists(Auth::user()->ProfilePhotoPath))
                            <img class="object-cover w-9 h-9 rounded-full ring-2 ring-white shrink-0"
                                src="{{ asset('storage/' . Auth::user()->ProfilePhotoPath) }}" alt="User" />
                        @else
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold ring-2 ring-white shrink-0"
                                style="background: linear-gradient(135deg, #1F9CA1, #0e7490);">
                                {{ strtoupper(substr(Auth::user()->UserName ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->UserName ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                    </div>

                    <div class="p-1.5">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-gray-700 font-medium hover:bg-teal-50 hover:text-teal-800 transition">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z" />
                            </svg>
                            My Profile
                        </a>
                        <a href="#"
                            class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-gray-700 font-medium hover:bg-teal-50 hover:text-teal-800 transition">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317a1.724 1.724 0 013.35 0 1.724 1.724 0 002.573 1.066 1.724 1.724 0 012.37 2.37 1.724 1.724 0 001.066 2.573 1.724 1.724 0 010 3.35 1.724 1.724 0 00-1.066 2.573 1.724 1.724 0 01-2.37 2.37 1.724 1.724 0 00-2.573 1.066 1.724 1.724 0 01-3.35 0 1.724 1.724 0 00-2.573-1.066 1.724 1.724 0 01-2.37-2.37 1.724 1.724 0 00-1.066-2.573 1.724 1.724 0 010-3.35 1.724 1.724 0 001.066-2.573 1.724 1.724 0 012.37-2.37 1.724 1.724 0 002.573-1.066z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            </svg>
                            Settings
                        </a>

                        <div class="my-1 mx-1 border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2.5 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
