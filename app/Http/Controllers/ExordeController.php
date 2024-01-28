<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ExordeController extends Controller
{
    public function index()
    {
        // Ambil data leaderboard harian dari file daily_leaderboard.json
        $dailyLeaderboardData = json_decode(Storage::disk('public')->get('data-json/daily_leaderboard.json'), true);

        // Ambil data leaderboard terbaru dari URL
        $latestLeaderboardData = json_decode(Storage::disk('public')->get('data-json/latest_leaderboard.json'), true);

        $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
        $leaderboardDatas = Http::get($leaderboardUrl)->json();

        $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";
        $bountyDatas = Http::get($bountyUrl)->json();

        $totalRep = array_sum($leaderboardDatas);
        $totalBounty = array_sum($bountyDatas['tweets']);

        // Rank Json
        $latestRank = [];

        foreach ($latestLeaderboardData as $entry) {
            $latestRank[$entry['address']] = $entry['rank'];
        }

        $dailyRank = [];

        foreach ($dailyLeaderboardData as $entry) {
            $dailyRank[$entry['address']] = $entry['rank'];
        }

        // value json
        $latestValue = [];
        foreach ($latestLeaderboardData as $entry) {
            $latestValue[$entry['address']] = $entry['value'];
        }

        $dailyValue = [];
        foreach ($dailyLeaderboardData as $entry) {
            $dailyValue[$entry['address']] = $entry['value'];
        }

        $leaderboards = [];
        foreach ($latestLeaderboardData as $entry) {

            $address = $entry['address'];

            // Peringkat harian
            $dailyRankValue = isset($dailyRank[$address]) ? $dailyRank[$address] : null;
            // Peringkat terbaru
            $latestRankValue = isset($latestRank[$address]) ? $latestRank[$address] : null;
            // Perbedaan peringkat
            $rankDifference = ($latestRankValue !== null) ? ($dailyRankValue - $latestRankValue) : null;



            // Value harian
            $dailyValueData = isset($dailyValue[$address]) ? $dailyValue[$address] : null;
            // Peringkat terbaru
            $latestValueData = isset($latestValue[$address]) ? $latestValue[$address] : null;
            // Perbedaan peringkat
            $valueDifference = ($latestRankValue !== null) ? ($latestValueData - $dailyValueData) : null;


            // Tambahkan informasi ke array $leaderboards
            $leaderboards[] = [
                'rank' => $latestRankValue,
                'address' => $address,
                'value' => $entry['value'],
                'rankDifference' => $rankDifference,
                'valueDifference' => $valueDifference
            ];
        }

        return view('exorde.index', [
            'leaderboards' => $leaderboards,
            'totalBounty' => $totalBounty,
            'totalReputation' => $totalRep
        ]);
    }
}
