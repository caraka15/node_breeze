<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
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
            $versionData = include $versionFile;

            if (is_array($versionData)) {
                $version = $versionData['version'] ?? '1.0.0';
                $htmlUrl = $versionData['html_url'] ?? '#';
            } else {
                // Handle jika $versionData bukan array
                $version = '1.0.0';
                $htmlUrl = '#';
            }
        } else {
            $version = '1.0.0'; // Set versi default jika file tidak ada
            $htmlUrl = '#';
        }


        // Bagikan versi dan HTML URL ke semua tampilan
        view()->share('appVersion', $version);
        view()->share('messageVersion', $htmlUrl);
    }
}
