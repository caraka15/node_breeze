<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";
        $finalData = json_decode(file_get_contents($bountyUrl), true);

        function arrayKeysToLower($array)
        {
            return array_change_key_case($array, CASE_LOWER);
        }

        $finalData = arrayKeysToLower($finalData);
        $twitter = is_array($bountyData['tweets']) ? arrayKeysToLower($bountyData['tweets']) : [];
        $reddit = is_array($bountyData['reddit']) ? arrayKeysToLower($bountyData['reddit']) : [];
        $youtube = is_array($bountyData['youtube']) ? arrayKeysToLower($bountyData['youtube']) : [];
        $news = is_array($bountyData['news']) ? arrayKeysToLower($bountyData['news']) : [];
        // Initialize array for storing leaderboard data in the format "rank, address, Rep, FinalRep"
        $leaderboardArray = [];

        // Get sorted values from the latest leaderboard
        arsort($leaderboardData);

        // Loop through the latest leaderboard
        foreach ($leaderboardData as $address => $userRep) {
            // Only process if userRep is greater than 0
            if ($userRep > 0) {
                // Calculate stats for the address
                $twitterBounty = $twitter[$address] ?? 0;
                $redditBounty = $reddit[$address] ?? 0;
                $youtubeBounty = $youtube[$address] ?? 0;
                $newsBounty = $news[$address] ?? 0;

                // Debug statements to check bounty values
                $this->info("Address: $address, Twitter: $twitterBounty, Reddit: $redditBounty, YouTube: $youtubeBounty, News: $newsBounty");

                $finalRep = $userRep + ($twitterBounty * 4) + ($redditBounty * 10) + ($youtubeBounty * 3) + ($newsBounty * 25);

                // Add data to the array in the desired format
                $leaderboardArray[] = [
                    'rank' => count($leaderboardArray) + 1,
                    'address' => $address,
                    'Rep' => $userRep,
                    'FinalRep' => $finalRep,
                ];

                // Debug statement to check the calculation
                // $this->info("Address: $address, Rep: $userRep, FinalRep: $finalRep");
            }
        }

        // Save leaderboard data to the appropriate file
        $filename = $type == 'daily' ? 'data-json/daily_leaderboard.json' : 'data-json/latest_leaderboard.json';
        Storage::disk('public')->put($filename, json_encode($leaderboardArray));

        $this->info(ucfirst($type) . ' leaderboard updated successfully!');
    }
}
