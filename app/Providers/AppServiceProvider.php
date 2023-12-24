<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http; // Tambahkan ini
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

        $apiUrl = 'https://api.github.com/repos/caraka15/node_breeze/commits';
        $response = Http::get($apiUrl);

        // Mengonversi data JSON ke dalam bentuk array
        $data = $response->json();

        // Mendapatkan html_url dari commit terbaru
        $htmlUrl = null;
        if (!empty($data) && is_array($data)) {
            $latestCommit = $data[0]; // Mengambil commit terbaru dari indeks 0
            $htmlUrl = $latestCommit['html_url'];
        }

        view()->share('messageVersion', $htmlUrl);
    }
}
