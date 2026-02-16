{{-- for some dashboard pages with scrollable table --}}
<!DOCTYPE html>
<html lang="en" x-data x-bind:class="{ 'dark': $store.theme.dark }" class="scroll">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JustMy Health</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GS5QSJH6M9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-GS5QSJH6M9');
    </script>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/css/tailwind.output.css') }}" rel="stylesheet" />

    <!-- Initialize Dark Mode Preference BEFORE Alpine loads -->
    <script>
        // On page load, set theme from localStorage (before Alpine & Tailwind apply)
        if (
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Define Alpine Stores before Alpine loads -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: document.documentElement.classList.contains('dark'),

                toggle() {
                    this.dark = !this.dark;
                    localStorage.theme = this.dark ? 'dark' : 'light';
                    document.documentElement.classList.toggle('dark', this.dark);
                }
            });
        });
    </script>

    <!-- Zego ZIM SDK (MUST be before Alpine) -->
    <script src="https://unpkg.com/zego-zim-web@2.25.1/index.js"></script>

    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-900 " x-data="{ isSidebarOpen: true, isSideMenuOpen: false }">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">

        {{-- Sidebar (both desktop + mobile handled) --}}
        <aside
            class="z-20 w-64 overflow-y-auto bg-white dark:bg-gray-800 transition-all duration-300 ease-in-out transform
                fixed inset-y-0 left-0 md:translate-x-0"
            :class="{
                '-translate-x-full': !isSideMenuOpen && window.innerWidth < 768,
                'translate-x-0': isSideMenuOpen || window.innerWidth >= 768,
                'w-16': !isSidebarOpen && window.innerWidth >= 768,
                'w-64': isSidebarOpen && window.innerWidth >= 768
            }">
            <div class="py-4 text-gray-500 dark:text-gray-400 ml-3">
                <div class="flex items-center justify-between">
                    @php $userType = auth()->user()?->UserType; @endphp
                    <a href="/dashboard" class="text-lg font-bold text-gray-800 dark:text-gray-200"
                        x-show="isSidebarOpen" x-transition>
                        JustMy.Health
                    </a>

                    <button
                        @click="window.innerWidth < 768 ? (isSideMenuOpen = !isSideMenuOpen) : (isSidebarOpen = !isSidebarOpen)"
                        class="hidden md:flex items-center justify-center rounded-md focus:outline-none">
                        <svg class="w-7 h-7" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M16.65 3.85938H7.35C3.25 3.85938 2 5.10938 2 9.20938V14.7894C2 18.8894 3.25 20.1394 7.35 20.1394H16.65C20.75 20.1394 22 18.8894 22 14.7894V9.20938C22 5.10938 20.75 3.85938 16.65 3.85938ZM18.74 13.1194C18.74 15.3694 17.69 16.4194 15.44 16.4194H13.21C10.96 16.4194 9.91 15.3694 9.91 13.1194V10.8894C9.91 8.63938 10.96 7.58938 13.21 7.58938H15.44C17.69 7.58938 18.74 8.63938 18.74 10.8894V13.1194Z"
                                fill="#292D32" />
                        </svg>
                    </button>
                </div>

                @php
                    use Illuminate\Support\Facades\Log;
                    use App\Services\CounsellingOnboardingService;
                    use App\Models\SysMenuDisplayOption;
                    use App\Models\SysUserType30OnboardQuestionsAnswers;

                    $onboardRow = SysUserType30OnboardQuestionsAnswers::where('PatientUserID', auth()->id())->first();

                    $qcStatus = optional($onboardRow)->QuestionCompletionStatus; // null | 0 | 1
                    $hasOnboardRow = !is_null($onboardRow);

                    $routePrefix = request()->route() ? explode('.', request()->route()->getName())[0] : null;
                    $userType = optional(auth()->user())->UserType ?? null;

                    $sidebarFile = 'layouts.dashboard-sidebar1';
                    $menuItems = collect();

                    if ($userType) {
                        $userTypeCol = (string) $userType;

                        try {
                            // ✅ Fetch items for the current user type column (1-based access)
                            $allItems = SysMenuDisplayOption::where($userTypeCol, 1)->orderBy('DisplayName')->get();

                            // ✅ Inline recursive closure (no redeclare issue)
                            $buildTree = function ($items, $parentId = 0) use (&$buildTree) {
                                return $items
                                    ->where('ParentID', $parentId)
                                    ->map(function ($menu) use ($items, &$buildTree) {
                                        $menu->children = $buildTree($items, $menu->ID);
                                        return $menu;
                                    })
                                    ->values();
                            };

                            $menuItems = $buildTree($allItems);
                        } catch (\Throwable $e) {
                            Log::error("Menu load failed for userType={$userType}: " . $e->getMessage());
                            $menuItems = collect();
                        }
                        $sidebarFile = 'layouts.dashboard-sidebar1';
                    }
                @endphp

                <aside class="h-full">
                    @include($sidebarFile, [
                        'menuItems' => $menuItems,
                        'qcStatus' => $qcStatus,
                        'hasOnboardRow' => $hasOnboardRow,
                        'userType' => $userType,
                    ])
                </aside>

            </div>
        </aside>

        {{-- Overlay for mobile --}}
        <div x-show="isSideMenuOpen && window.innerWidth < 768" @click="isSideMenuOpen = false"
            x-transition.opacity.duration.200ms class="fixed inset-0 z-10 bg-black bg-opacity-50 md:hidden"></div>

        {{-- Main Content --}}
        <div class="flex flex-col flex-1 min-h-screen transition-all duration-300 ease-in-out overflow-x-scroll"
            :class="{
                'md:ml-64': isSidebarOpen && window.innerWidth >= 768,
                'md:ml-20': !isSidebarOpen && window.innerWidth >= 768,
                'ml-0': window.innerWidth < 768
            }">

            @include('layouts.dashboard-topbar')

            <main class="flex-1 overflow-y-auto p-2 md:p-2 transition-all duration-300">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>

</html>
