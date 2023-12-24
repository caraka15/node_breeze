<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File; // Tambahkan ini
use Illuminate\Support\ServiceProvider;

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
        Gate::define('admin', function (User $user) {
            return $user->isAdmin;
        });

        $versionFile = base_path('version.php');

        if (File::exists($versionFile)) {
            $version = include $versionFile;
        } else {
            $version = '1.0.0'; // Set versi default jika file tidak ada
        }

        // Bagikan versi ke semua tampilan
        view()->share('appVersion', $version);
    }
}
