<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\SysMenuDisplayOption;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

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
}
