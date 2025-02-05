<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExordeApiController extends Controller
{
    private $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
    private $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";

    public function getStats(Request $request)
    {
        $multipliers = app(MultiplierController::class)->getMultipliers()->getData();
        $userAddress = strtolower($request->user_address);

        // Fetch Data
        $leaderboardData = $this->arrayKeysToLower(
            json_decode(file_get_contents($this->leaderboardUrl), true)
        );

        $bountyData = $this->arrayKeysToLower(
            json_decode(file_get_contents($this->bountyUrl), true)
        );

        $userRep = $leaderboardData[$userAddress] ?? null;

        // Process bounty data
        $bounties = $this->processBountyData($bountyData, $userAddress);

        // Calculate totals
        $totals = $this->calculateTotals($leaderboardData, $bountyData);

        // Calculate final reps for all users
        $finalRepsLeaderboard = [];
        foreach ($leaderboardData as $address => $rep) {
            $userBounties = $this->processBountyData($bountyData, $address);
            $finalRepsLeaderboard[$address] = $this->calculateFinalReps($rep, $userBounties);
        }

        // Sort by final reps and calculate rank
        arsort($finalRepsLeaderboard);
        $sortedLeaderboard = array_keys($finalRepsLeaderboard);
        $rankedLeaderboard = array_flip($sortedLeaderboard);
        $rankedLeaderboard = array_map(fn($rank) => $rank + 1, $rankedLeaderboard);
        $userRank = $rankedLeaderboard[$userAddress] ?? null;

        // Get crypto price
        $cryptoData = $this->getCryptoData();
        $exdPrice = $cryptoData['price'];


        // Calculate final metrics
        $finalReps = $this->calculateFinalReps($userRep, $bounties);
        $totalBounty = $this->calculateTotalBounty($totals);

        // Get latest leaderboard data
        $latestLeaderboardData = $this->getLatestLeaderboardData();
        $totalFinalRep = array_sum(array_column($latestLeaderboardData, 'FinalRep'));

        // Calculate percentages and rewards
        $finalPercentage = number_format(($finalReps / $totalBounty) * 100, 2);
        $exdReward = ($finalPercentage / 100) * $multipliers->pool;
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
            'threads' => number_format($bounties['threads']),
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
            'threads' => $this->arrayKeysToLower($bountyData['threads'] ?? [])[strtolower($userAddress)] ?? 0,
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
            'totalThreads' => array_sum($bountyData['threads'] ?? []),
        ];
    }

    private function calculateFinalReps($userRep, $bounties)
    {
        $multipliers = app(MultiplierController::class)->getMultipliers()->getData();

        return $userRep +
            ($bounties['twitter'] * $multipliers->twitter) +
            ($bounties['youtube'] * $multipliers->youtube) +
            ($bounties['reddit'] * $multipliers->reddit) +
            ($bounties['news'] * $multipliers->news) +
            ($bounties['bsky'] * $multipliers->bsky) +
            ($bounties['threads'] * $multipliers->threads);
    }

    private function calculateTotalBounty($totals)
    {
        $multipliers = app(MultiplierController::class)->getMultipliers()->getData();

        return ($totals['totalTweets'] * $multipliers->twitter) +
            ($totals['totalReddit'] * $multipliers->reddit) +
            ($totals['totalNews'] * $multipliers->news) +
            ($totals['totalYoutube'] * $multipliers->youtube) +
            ($totals['totalBsky'] * $multipliers->bsky) +
            ($totals['totalThreads'] * $multipliers->threads) +
            $totals['totalRep'];
    }

    private function getCryptoData()
    {
        try {
            $path = public_path('storage/data-json/exorde_price.json');
            if (!file_exists($path)) {
                throw new \Exception('Price data file not found');
            }

            return json_decode(file_get_contents($path), true);
        } catch (\Exception $e) {
            throw new \Exception('Failed to fetch Exorde price: ' . $e->getMessage());
        }
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