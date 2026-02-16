{{-- resources/views/dashboard.blade.php --}}

@php
    use App\Models\SysMenuDisplayOption;

    $userType = (string) auth()->user()->UserType;

    $query = SysMenuDisplayOption::query()
        ->where('ParentID', 0)
        ->where($userType, 1)

        // Global strict rules (REAL dashboards only)
        ->whereNotNull('MainPaneLabel')
        ->whereNotNull('TileText');

    /*
|--------------------------------------------------------------------------
| USER TYPE SPECIFIC RULES
|--------------------------------------------------------------------------
*/

    // USER / PATIENT (UserType = 1)
    if ($userType === '1') {
        $query
            ->where('10', 1) // user dashboard flag
            ->where('30', 0)
            ->where('31', 0)
            ->where('32', 0)
            ->where('90', 0)
            ->where('91', 0);
    }

    // THERAPIST (UserType = 30)
    if ($userType === '30') {
        $query->where('30', 1)->where('1', 0)->where('90', 0)->where('91', 0);
    }

    // ADMIN (UserType = 90 / 91)
    if (in_array($userType, ['90', '91'])) {
        $query
            ->where('90', 1)
            ->where('91', 1)

            // THIS is the key fix 👇
            ->where('TileText', '!=', 'mod-01/'); // exclude legacy admin root
    }

    $dashboardMenu = $query
        ->orderByDesc('id') // safety: newer dashboards win
        ->first();
@endphp

<x-app1> {{-- app1 component --}}
    <div class="container mt-3 px-6 mx-auto grid">

        <!-- CTA -->
        <a class="flex items-center justify-between p-2 mb-8 text-sm font-semibold text-white bg-primary rounded-lg shadow-md focus:outline-none focus:shadow-outline-primary"
            href="">
            <div class="flex items-center">

                <x-page-header :menu="$dashboardMenu" :title-only="true" textColor="text-white" />

            </div>
            <span>Welcome {{ Auth::user()->UserName }}</span>
        </a>

        <div class="flex items-center justify-center min-h-[60vh]">
            <p class="text-center text-lg font-semibold text-gray-600 bg-white px-8 py-6 rounded-lg shadow-md">
                Content will be finalized after sponsor review and approval.
            </p>
        </div>

    </div>
</x-app1>
