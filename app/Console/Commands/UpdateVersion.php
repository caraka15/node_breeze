<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateVersion extends Command
{
    protected $signature = 'update:version';
    protected $description = 'Update version based on GitHub commit count';

    public function handle()
    {
        $repositoryOwner = 'caraka15';  // Ganti dengan pemilik repositori GitHub Anda
        $repositoryName = 'node_breeze';  // Ganti dengan nama repositori GitHub Anda

        // Ambil jumlah commit dari GitHub API
        $apiUrl = "https://api.github.com/repos/{$repositoryOwner}/{$repositoryName}/commits";
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $commits = $response->json();
            $commitCount = count($commits);

            $this->info("Jumlah commit dari GitHub API: {$commitCount}");

            // Logika pembaruan versi menggunakan commit count (ganti sesuai kebutuhan)
            $newVersion = $this->updateVersion($commitCount);

            if ($newVersion !== null) {
                $this->info("Versi diperbarui: {$newVersion}");
                // Simpan versi baru ke file atau tempat lain yang sesuai
                // Misalnya, untuk menyimpan versi dalam file version.php
                file_put_contents(base_path('version.php'), "<?php\nreturn '{$newVersion}';\n");
            } else {
                $this->error("Invalid version format.");
            }
        } else {
            $this->error("Error: " . $response->status());
        }
    }

    private function updateVersion($commitCount)
    {
        // Menambahkan leading zero pada commit count jika kurang dari 100
        $commitCountFormatted = str_pad($commitCount, 3, '0', STR_PAD_LEFT);

        // Menggunakan commit count untuk membuat versi baru
        $major = substr($commitCountFormatted, 0, 1);
        $minor = substr($commitCountFormatted, 1, 1);
        $patch = substr($commitCountFormatted, 2, 1);

        $newVersion = "{$major}.{$minor}.{$patch}";

        return $newVersion;
    }
}
