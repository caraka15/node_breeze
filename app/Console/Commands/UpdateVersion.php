<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class UpdateVersion extends Command
{
    protected $signature = 'update:version {--patch : Increase patch version} {--minor : Increase minor version} {--major : Increase major version}';
    protected $description = 'Update version and HTML URL based on command options';

    public function handle()
    {
        $currentVersionData = $this->getCurrentVersion();

        if ($this->option('patch')) {
            $newVersion = $this->increasePatchVersion($currentVersionData['version']);
        } elseif ($this->option('minor')) {
            $newVersion = $this->increaseMinorVersion($currentVersionData['version']);
        } elseif ($this->option('major')) {
            $newVersion = $this->increaseMajorVersion($currentVersionData['version']);
        } else {
            $this->error('Please specify which version to update: --patch, --minor, or --major.');
            return;
        }

        // Panggil fungsi untuk mendapatkan HTML URL
        $htmlUrl = $this->getLatestCommitHtmlUrl();

        $this->info("Version updated from {$currentVersionData['version']} to {$newVersion}");
        $this->saveNewVersion($newVersion, $htmlUrl);
    }

    private function getCurrentVersion()
    {
        $versionFile = base_path('version.php');

        if (File::exists($versionFile)) {
            return include $versionFile;
        }

        return ['version' => '1.5.4', 'html_url' => '#']; // Set initial version
    }

    private function increasePatchVersion($currentVersion)
    {
        $newVersion = $this->handleOverflow($currentVersion, 'patch');
        return $newVersion;
    }

    private function increaseMinorVersion($currentVersion)
    {
        $newVersion = $this->handleOverflow($currentVersion, 'minor');
        return $newVersion;
    }

    private function increaseMajorVersion($currentVersion)
    {
        $newVersion = $this->handleOverflow($currentVersion, 'major');
        return $newVersion;
    }

    private function handleOverflow($currentVersion, $type)
    {
        list($major, $minor, $patch) = explode('.', $currentVersion);

        // Menaikkan versi sesuai tipe (patch, minor, major)
        switch ($type) {
            case 'patch':
                $patch = ($patch < 9) ? $patch + 1 : 0;
                $minor = ($patch === 0) ? ($minor < 9 ? $minor + 1 : 0) : $minor;
                $major = ($minor === 0 && $patch === 0) ? $major + 1 : $major;
                break;
            case 'minor':
                $minor = ($minor < 9) ? $minor + 1 : 0;
                $major = ($minor === 0) ? $major + 1 : $major;
                break;
            case 'major':
                $major = (int) $major + 1;
                break;
        }

        return "{$major}.{$minor}.{$patch}";
    }

    private function saveNewVersion($newVersion, $htmlUrl)
    {
        $versionFile = base_path('version.php');
        File::put($versionFile, "<?php\nreturn ['version' => '{$newVersion}', 'html_url' => '{$htmlUrl}'];\n");
    }

    private function getLatestCommitHtmlUrl(): ?string
    {
        $apiUrl = 'https://api.github.com/repos/caraka15/node_breeze/commits';
        $accessToken = config('services.github.token'); // Fetch the token from config

        $response = Http::withToken($accessToken)->get($apiUrl);

        $data = $response->json();

        if (!empty($data) && is_array($data)) {
            $latestCommit = $data[0];
            return $latestCommit['html_url'];
        }

        return null;
    }
}
