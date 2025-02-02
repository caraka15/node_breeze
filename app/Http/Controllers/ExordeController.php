<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExordeController extends Controller
{
    public function index()
    {
        // Load daily leaderboard data from file
        $dailyLeaderboardData = json_decode(Storage::disk('public')->get('data-json/daily_leaderboard.json'), true);

        // Load latest leaderboard data from file
        $latestLeaderboardData = json_decode(Storage::disk('public')->get('data-json/latest_leaderboard.json'), true);

        // Calculate total reputation and total bounty
        $totalRep = array_sum(array_column($latestLeaderboardData, 'Rep'));
        $totalBounty = array_sum(array_column($latestLeaderboardData, 'FinalRep'));

        // Prepare rank data for latest and daily leaderboards
        $latestRank = [];
        foreach ($latestLeaderboardData as $entry) {
            $latestRank[$entry['address']] = $entry['rank'];
        }

        $dailyRank = [];
        foreach ($dailyLeaderboardData as $entry) {
            $dailyRank[$entry['address']] = $entry['rank'];
        }

        // Prepare value data for latest and daily leaderboards
        $latestValue = [];
        foreach ($latestLeaderboardData as $entry) {
            $latestValue[$entry['address']] = $entry['Rep'];
        }

        $dailyValue = [];
        foreach ($dailyLeaderboardData as $entry) {
            $dailyValue[$entry['address']] = $entry['Rep'];
        }

        // Construct the leaderboards array
        $leaderboards = [];
        foreach ($latestLeaderboardData as $entry) {
            $address = $entry['address'];

            // Daily rank and value
            $dailyRankValue = $dailyRank[$address] ?? null;
            $dailyValueData = $dailyValue[$address] ?? null;

            // Latest rank and value
            $latestRankValue = $latestRank[$address] ?? null;
            $latestValueData = $latestValue[$address] ?? null;

            // Differences
            $rankDifference = ($latestRankValue !== null && $dailyRankValue !== null) ? ($dailyRankValue - $latestRankValue) : null;
            $valueDifference = ($latestValueData !== null && $dailyValueData !== null) ? ($latestValueData - $dailyValueData) : null;

            // Add information to the leaderboards array
            $leaderboards[] = [
                'rank' => $latestRankValue,
                'address' => $address,
                'rep' => $entry['Rep'],
                'totalRep' => $entry['FinalRep'], // Always take FinalRep from latest leaderboard
                'rankDifference' => $rankDifference,
                'valueDifference' => $valueDifference
            ];
        }

        $multipliers = app(MultiplierController::class)->getMultipliers()->getData();

        return view('exorde.index', [
            'multipliers' => $multipliers,
            'leaderboards' => $leaderboards,
            'totalBounty' => $totalBounty,
            'totalReputation' => $totalRep
        ]);
    }
}
