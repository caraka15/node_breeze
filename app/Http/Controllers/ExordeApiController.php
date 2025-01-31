<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExordeApiController extends Controller
{
    private $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
    private $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";
    private $cmcApiKey = 'c278f052-8555-4544-81a5-a2d0ef287c4c';

    public function getStats(Request $request)
    {
        $userAddress = strtolower($request->user_address);

        // Fetch Data
        $leaderboardData = $this->arrayKeysToLower(
            json_decode(file_get_contents($this->leaderboardUrl), true)
        );

        $bountyData = $this->arrayKeysToLower(
            json_decode(file_get_contents($this->bountyUrl), true)
        );

        $userRep = $leaderboardData[$userAddress] ?? null;

        // Sort leaderboard data
        arsort($leaderboardData);
        $sortedLeaderboard = array_keys($leaderboardData);
        $rankedLeaderboard = array_flip($sortedLeaderboard);
        $rankedLeaderboard = array_map(fn($rank) => $rank + 1, $rankedLeaderboard);
        $userRank = $rankedLeaderboard[$userAddress] ?? null;

        // Process bounty data
        $bounties = $this->processBountyData($bountyData, $userAddress);

        // Calculate totals
        $totals = $this->calculateTotals($leaderboardData, $bountyData);

        // Get crypto price
        $cryptoData = $this->getCryptoData();
        $exdPrice = $cryptoData['data']['23638']['quote']['USD']['price'];

        // Calculate final metrics
        $finalReps = $this->calculateFinalReps($userRep, $bounties);
        $totalBounty = $this->calculateTotalBounty($totals);

        // Get latest leaderboard data
        $latestLeaderboardData = $this->getLatestLeaderboardData();
        $totalFinalRep = array_sum(array_column($latestLeaderboardData, 'FinalRep'));

        // Calculate percentages and rewards
        $finalPercentage = number_format(($finalReps / $totalBounty) * 100, 2);
        $exdReward = ($finalPercentage / 100) * 400000;
        $userPercentage = number_format(($userRep / $totals['totalRep']) * 100, 2);
        $usdReward = number_format($exdReward * $exdPrice, 2);

        return response()->json([
            'rank' => $userRank,
            'reputation' => number_format($userRep),
            'percentage' => $userPercentage,
            'twitter' => number_format($bounties['twitter']),
            'reddit' => number_format($bounties['reddit']),
            'youtube' => number_format($bounties['youtube']),
            'news' => number_format($bounties['news']),
            'final' => number_format($finalReps),
            'blueSky' => number_format($bounties['bsky']),
            'totalBounty' => number_format($totalBounty),
            'finalPresentage' => $finalPercentage,
            'exdReward' => $exdReward,
            'exd_price' => number_format($exdPrice, 4),
            'usd_monthly_reward' => $usdReward,
            'totalRep' => $totals['totalRep'],
            'totaltweets' => $totals['totalTweets'],
        ]);
    }

    private function arrayKeysToLower($array)
    {
        return array_change_key_case($array, CASE_LOWER);
    }

    private function processBountyData($bountyData, $userAddress)
    {
        return [
            'twitter' => $this->arrayKeysToLower($bountyData['tweets'] ?? [])[strtolower($userAddress)] ?? 0,
            'reddit' => $this->arrayKeysToLower($bountyData['reddit'] ?? [])[strtolower($userAddress)] ?? 0,
            'youtube' => $this->arrayKeysToLower($bountyData['youtube'] ?? [])[strtolower($userAddress)] ?? 0,
            'news' => $this->arrayKeysToLower($bountyData['news'] ?? [])[strtolower($userAddress)] ?? 0,
            'bsky' => $this->arrayKeysToLower($bountyData['bsky'] ?? [])[strtolower($userAddress)] ?? 0,
        ];
    }

    private function calculateTotals($leaderboardData, $bountyData)
    {
        return [
            'totalRep' => array_sum($leaderboardData),
            'totalTweets' => array_sum($bountyData['tweets'] ?? []),
            'totalReddit' => array_sum($bountyData['reddit'] ?? []),
            'totalNews' => array_sum($bountyData['news'] ?? []),
            'totalYoutube' => array_sum($bountyData['youtube'] ?? []),
            'totalBsky' => array_sum($bountyData['bsky'] ?? []),
        ];
    }

    private function calculateFinalReps($userRep, $bounties)
    {
        return $userRep +
            ($bounties['twitter'] * 7.5) +
            ($bounties['youtube'] * 5) +
            ($bounties['reddit'] * 13) +
            ($bounties['news'] * 25) +
            ($bounties['bsky'] * 5);
    }

    private function calculateTotalBounty($totals)
    {
        return ($totals['totalTweets'] * 7.5) +
            ($totals['totalReddit'] * 13) +
            ($totals['totalNews'] * 25) +
            ($totals['totalYoutube'] * 5) +
            ($totals['totalBsky'] * 5) +
            $totals['totalRep'];
    }

    private function getCryptoData()
    {
        $response = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => $this->cmcApiKey
        ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest', [
            'slug' => 'exorde',
            'convert' => 'USD'
        ]);

        return $response->json();
    }

    private function getLatestLeaderboardData()
    {
        $path = public_path('storage/data-json/daily_leaderboard.json');
        if (!file_exists($path)) {
            throw new \Exception('Latest leaderboard file not found');
        }
        return json_decode(file_get_contents($path), true);
    }
}
