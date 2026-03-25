<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\RuntimeConfigService;

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

        Gate::define('access-admin', function ($user) {
            return $user->roles()->where('name', 'Admin')->exists();
        });

        Gate::define('access-website-admin', function ($user) {
            return $user->roles()->where('name', 'Website-admin')->exists();
        });

        Gate::define('access-developer', function ($user) {
            return $user->roles()->where('name', 'Developer')->exists();
        });

        Gate::define('access-admin-or-webadmin', function ($user) {
            return $user->roles()
                ->whereIn('name', ['Admin', 'Website-admin'])
                ->exists();
        });

    }
}
