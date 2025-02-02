<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MultiplierController;

class UpdateLeaderboard extends Command
{
    protected $signature = 'leaderboard:update {--daily : Update daily leaderboard data} {--latest : Update latest leaderboard data}';
    protected $description = 'Update leaderboard data';

    public function handle()
    {
        try {
            // Fetch leaderboard and bounty data from the URL
            $leaderboardResponse = Http::get("https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json");
            $bountyResponse = Http::get("https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json");

            if ($leaderboardResponse->successful() && $bountyResponse->successful()) {
                $leaderboardData = array_change_key_case($leaderboardResponse->json(), CASE_LOWER);
                $bountyData = array_change_key_case($bountyResponse->json(), CASE_LOWER);

                // Determine which leaderboard to update based on the provided option
                if ($this->option('daily')) {
                    $this->updateLeaderboard($leaderboardData, $bountyData, 'daily');
                } elseif ($this->option('latest')) {
                    $this->updateLeaderboard($leaderboardData, $bountyData, 'latest');
                } else {
                    $this->error('Please provide either --daily or --latest option.');
                }
            } else {
                $this->error('Failed to fetch leaderboard or bounty data.');
            }
        } catch (\Exception $e) {
            $this->error('Error updating leaderboard: ' . $e->getMessage());
        }
    }

    protected function updateLeaderboard($leaderboardData, $bountyData, $type)
    {
        $multipliers = app(MultiplierController::class)->getMultipliers()->getData();
        // Initialize array for storing leaderboard data
        $leaderboardArray = [];

        // Process bounty data
        $twitter = is_array($bountyData['tweets']) ? $this->arrayKeysToLower($bountyData['tweets']) : [];
        $reddit = is_array($bountyData['reddit']) ? $this->arrayKeysToLower($bountyData['reddit']) : [];
        $youtube = is_array($bountyData['youtube']) ? $this->arrayKeysToLower($bountyData['youtube']) : [];
        $news = is_array($bountyData['news']) ? $this->arrayKeysToLower($bountyData['news']) : [];
        $bsky = is_array($bountyData['bsky']) ? $this->arrayKeysToLower($bountyData['bsky']) : [];
        $threads = is_array($bountyData['threads']) ? $this->arrayKeysToLower($bountyData['threads']) : [];

        // Calculate final reps for all addresses
        $finalRepsData = [];
        foreach ($leaderboardData as $address => $userRep) {
            if ($userRep > 0) {
                $twitterBounty = $twitter[$address] ?? 0;
                $redditBounty = $reddit[$address] ?? 0;
                $youtubeBounty = $youtube[$address] ?? 0;
                $newsBounty = $news[$address] ?? 0;
                $bskyBounty = $bsky[$address] ?? 0;
                $threadsBounty = $threads[$address] ?? 0;

                $finalRep = $userRep +
                    ($twitterBounty * $multipliers->twitter) +
                    ($redditBounty * $multipliers->reddit) +
                    ($youtubeBounty * $multipliers->youtube) +
                    ($newsBounty * $multipliers->news) +
                    ($bskyBounty * $multipliers->bsky) +
                    ($threadsBounty * $multipliers->threads);

                $finalRepsData[$address] = [
                    'address' => $address,
                    'Rep' => $userRep,
                    'FinalRep' => $finalRep
                ];

                // Debug output if needed
                $this->info("Address: $address");
                $this->info("Base Rep: $userRep");
                $this->info("Twitter ($twitterBounty * $multipliers->twitter), Reddit ($redditBounty * $multipliers->reddit), YouTube ($youtubeBounty * $multipliers->youtube)");
                $this->info("News ($newsBounty * $multipliers->news), BlueSky ($bskyBounty * $multipliers->bsky), Threads ($threadsBounty * $multipliers->threads)");
                $this->info("Final Rep: $finalRep");
                $this->info("------------------------");
            }
        }

        // Sort by FinalRep
        uasort($finalRepsData, function ($a, $b) {
            return $b['FinalRep'] <=> $a['FinalRep'];
        });

        // Create final array with rankings
        $rank = 1;
        foreach ($finalRepsData as $data) {
            $leaderboardArray[] = [
                'rank' => $rank++,
                'address' => $data['address'],
                'Rep' => $data['Rep'],
                'FinalRep' => $data['FinalRep']
            ];
        }

        // Save leaderboard data
        $filename = $type == 'daily' ? 'data-json/daily_leaderboard.json' : 'data-json/latest_leaderboard.json';
        Storage::disk('public')->put($filename, json_encode($leaderboardArray));

        $this->info(ucfirst($type) . ' leaderboard updated successfully!');
    }

    private function arrayKeysToLower($array)
    {
        return array_change_key_case($array, CASE_LOWER);
    }
}
