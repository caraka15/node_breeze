<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateVersion extends Command
{
    protected $signature = 'update:version {--patch : Increase patch version} {--minor : Increase minor version} {--major : Increase major version}';
    protected $description = 'Update version based on command options';

    public function handle()
    {
        $currentVersion = $this->getCurrentVersion();

        if ($this->option('patch')) {
            $newVersion = $this->increasePatchVersion($currentVersion);
        } elseif ($this->option('minor')) {
            $newVersion = $this->increaseMinorVersion($currentVersion);
        } elseif ($this->option('major')) {
            $newVersion = $this->increaseMajorVersion($currentVersion);
        } else {
            $this->error('Please specify which version to update: --patch, --minor, or --major.');
            return;
        }

        $this->info("Version updated from {$currentVersion} to {$newVersion}");
        $this->saveNewVersion($newVersion);
    }

    private function getCurrentVersion()
    {
        // Implement logic to retrieve current version from storage (e.g., file, database)
        $versionFile = base_path('version.php');

        if (File::exists($versionFile)) {
            return include $versionFile;
        }

        return '1.5.4'; // Set initial version
    }

    private function increasePatchVersion($currentVersion)
    {
        list($major, $minor, $patch) = explode('.', $currentVersion);
        $patch = (int) $patch + 1;
        return "{$major}.{$minor}.{$patch}";
    }

    private function increaseMinorVersion($currentVersion)
    {
        list($major, $minor, $patch) = explode('.', $currentVersion);
        $minor = (int) $minor + 1;
        return "{$major}.{$minor}.0";
    }

    private function increaseMajorVersion($currentVersion)
    {
        list($major, $minor, $patch) = explode('.', $currentVersion);
        $major = (int) $major + 1;
        return "{$major}.0.0";
    }

    private function saveNewVersion($newVersion)
    {
        // Implement logic to save new version to storage (e.g., file, database)
        $versionFile = base_path('version.php');
        File::put($versionFile, "<?php\nreturn '{$newVersion}';\n");
    }
}
