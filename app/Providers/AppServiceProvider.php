<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\SysMenuDisplayOption;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        if (Schema::hasTable('sys_menu_display_options')) {
            $this->ensurePhysioWorkoutMenuOptions();
        }

        // Share dynamic menu with all views
        View::composer('*', function ($view) {
            $userType = auth()->check() ? auth()->user()->UserType : null;
        
            if ($userType) {
                $menuItems = SysMenuDisplayOption::where('ParentID', 0)
                    ->where($userType, 1) // 👈 Only take items allowed for this userType
                    ->with(['children' => function ($query) use ($userType) {
                        $query->where($userType, 1);
                    }])
                    ->get();
            } else {
                $menuItems = collect(); // empty if not logged in
            }
        
            $view->with('menuItems', $menuItems);
        });
    }

    private function ensurePhysioWorkoutMenuOptions(): void
    {
        if (! Schema::hasTable('sys_menu_display_options')) {
            return;
        }

        try {
            DB::transaction(function () {
                $therapistParent = SysMenuDisplayOption::firstOrCreate(
                    ['DisplayName' => 'Physio Workouts', 'ParentID' => 0],
                    [
                        'MenuURL' => null,
                        '1' => 0,
                        '10' => 0,
                        '30' => 1,
                        '31' => 0,
                        '32' => 0,
                        '90' => 0,
                        '91' => 0,
                    ]
                );

                $therapistParent->update([
                    'MenuURL' => null,
                    '1' => 0,
                    '10' => 0,
                    '30' => 1,
                    '31' => 0,
                    '32' => 0,
                    '90' => 0,
                    '91' => 0,
                ]);

                $this->upsertMenuOption(
                    'Exercise Library',
                    '/mod-10/02/exercise-library',
                    $therapistParent->ID,
                    ['1' => 0, '10' => 0, '30' => 1, '31' => 0, '32' => 0, '90' => 0, '91' => 0]
                );

                $wellnessParent = SysMenuDisplayOption::where('ParentID', 0)
                    ->where('DisplayName', 'Wellness Services')
                    ->where('1', 1)
                    ->first();

                $patientParentId = $wellnessParent ? $wellnessParent->ID : 0;

                $this->upsertMenuOption(
                    'My Workouts',
                    '/mod-10/02/usr-my-workouts',
                    $patientParentId,
                    ['1' => 1, '10' => 0, '30' => 0, '31' => 0, '32' => 0, '90' => 0, '91' => 0]
                );
            });
        } catch (\Throwable $e) {
            Log::error('Failed to ensure physio workout menu options: ' . $e->getMessage());
        }
    }

    private function normalizeMenuUrl(string $menuUrl): string
    {
        return '/' . ltrim($menuUrl, '/');
    }

    private function upsertMenuOption(string $displayName, string $menuUrl, int $parentId, array $flags): void
    {
        $normalizedUrl = $this->normalizeMenuUrl($menuUrl);
        $menu = SysMenuDisplayOption::where(function ($query) use ($normalizedUrl, $displayName) {
            $query->where('MenuURL', $normalizedUrl)
                ->orWhere('MenuURL', ltrim($normalizedUrl, '/'))
                ->orWhere('DisplayName', $displayName);
        })->first();

        // User-type columns are numeric strings (for example, "1" and "30").
        // array_merge reindexes numeric keys, which silently drops these flags.
        $data = array_replace([
            'ParentID' => $parentId,
            'DisplayName' => $displayName,
            'MenuURL' => $normalizedUrl,
            'MainPaneID' => null,
            'MainPaneLabel' => null,
            'TileText' => null,
            'Grouping' => null,
            'ImagePath' => null,
        ], $flags);

        if ($menu) {
            $menu->update($data);
        } else {
            SysMenuDisplayOption::create($data);
        }
    }
}
