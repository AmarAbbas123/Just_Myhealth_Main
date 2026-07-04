<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full  mx-auto text-primary dark:text-primary">

        <!-- Mobile hamburger -->
        <button
            class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
            @click="isSideMenuOpen = !isSideMenuOpen" aria-label="Menu">

            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Search input -->
        <div class="flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-primary">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input id="tableSearch" type="text" placeholder="Search for projects" aria-label="Search"
                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md 
                   dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 
                   dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white 
                   focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 form-input" />
            </div>
        </div>

        <!-- Right-side menus -->
        <ul class="flex items-center flex-shrink-0 space-x-6">


            <!-- Theme toggler button -->
            <li class="flex">
                <button class="rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    @click="$store.theme.toggle()" aria-label="Toggle color mode">

                    <!-- Moon icon (light mode) -->
                    <svg x-show="!$store.theme.dark" class="w-5 h-5" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>

                    <!-- Sun icon (dark mode) -->
                    <svg x-show="$store.theme.dark" class="w-5 h-5" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </li>

            @php
                $hideNotifications = in_array((int) optional(Auth::user())->UserType, [1, 30]);
            @endphp

            @if (!$hideNotifications)
                <!-- Notifications menu -->
                <li class="relative" x-data="{ isNotificationsMenuOpen: false }" @keydown.escape.window="isNotificationsMenuOpen = false">

                    <button @click="isNotificationsMenuOpen = !isNotificationsMenuOpen"
                        class="relative align-middle rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                        aria-label="Notifications" aria-haspopup="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                        <span aria-hidden="true"
                            class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 
                         bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="isNotificationsMenuOpen" x-transition @click.outside="isNotificationsMenuOpen = false"
                        class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border 
                          border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
                        <a href="#"
                            class="flex justify-between w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span>Messages</span>
                            <span
                                class="px-2 py-1 text-xs font-bold text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">13</span>
                        </a>
                        <a href="#"
                            class="flex justify-between w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span>Sales</span>
                            <span
                                class="px-2 py-1 text-xs font-bold text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">2</span>
                        </a>
                        <a href="#"
                            class="flex w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">Alerts</a>
                    </div>
                </li>
            @endif

            <!-- Profile menu -->
            <li class="relative" x-data="{ isProfileMenuOpen: false }" @keydown.escape.window="isProfileMenuOpen = false">

                <button @click="isProfileMenuOpen = !isProfileMenuOpen"
                    class="align-middle rounded-full focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none"
                    aria-label="Account" aria-haspopup="true">

                    @if (!empty(Auth::user()->ProfilePhotoPath) && Storage::disk('public')->exists(Auth::user()->ProfilePhotoPath))
                        {{-- Show uploaded photo --}}
                        <img class="object-cover w-8 h-8 rounded-full"
                            src="{{ asset('storage/' . Auth::user()->ProfilePhotoPath) }}" alt="User" />
                    @else
                        {{-- Show placeholder silhouette / dotted border   2, 6 --}}
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-semibold"
                            style="background-color:#1F9CA1;">
                            {{ strtoupper(substr(Auth::user()->UserName ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                </button>


                <div x-show="isProfileMenuOpen" x-transition @click.outside="isProfileMenuOpen = false"
                    class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border 
                      border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                    aria-label="submenu">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                    <a href="#"
                        class="flex items-center w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M10.325 4.317a1.724 1.724 0 013.35 0 1.724 1.724 0 002.573 1.066 1.724 1.724 0 012.37 2.37 1.724 1.724 0 001.066 2.573 1.724 1.724 0 010 3.35 1.724 1.724 0 00-1.066 2.573 1.724 1.724 0 01-2.37 2.37 1.724 1.724 0 00-2.573 1.066 1.724 1.724 0 01-3.35 0 1.724 1.724 0 00-2.573-1.066 1.724 1.724 0 01-2.37-2.37 1.724 1.724 0 00-1.066-2.573 1.724 1.724 0 010-3.35 1.724 1.724 0 001.066-2.573 1.724 1.724 0 012.37-2.37 1.724 1.724 0 002.573-1.066z" />
                        </svg>
                        Settings
                    </a>
                    <a href="{{ route('settings.face-login.edit') }}"
                        class="flex items-center w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                        <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 9V7a3 3 0 016 0v2m-8 0h10a1 1 0 011 1v9a1 1 0 01-1 1H7a1 1 0 01-1-1v-9a1 1 0 011-1zM12 13.5v2" />
                        </svg>
                        Face Login
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-2 py-1 text-sm font-semibold rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                            <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6 a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log out
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>