<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExordeController extends Controller
{
    public function index()
    {

        $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
        $leaderboardData = Http::get($leaderboardUrl)->json();

        $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";
        $bountyData = Http::get($bountyUrl)->json();

        $totalRep = array_sum($leaderboardData);
        $totalBounty = array_sum($bountyData['tweets']);

        return view('exorde.index', [
            'leaderboards' => $leaderboardData,
            'totalReputation' => $totalRep,
            'totalBounty' => $totalBounty
        ]);
    }

    public function getUserStats(Request $request)
    {
        $userAddress = $request->input('user_address');

        // Fetch Data
        $dailyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/daily_EXD_projected_rewards.json";
        $hourlyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/hourly_EXD_projected_rewards.json";
        $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
        $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";



        $dailyData = Http::get($dailyUrl)->json();
        $hourlyData = Http::get($hourlyUrl)->json();
        $leaderboardData = Http::get($leaderboardUrl)->json();
        $bountyData = Http::get($bountyUrl)->json();


        $userRep = $leaderboardData[$userAddress] ?? 0;
        $userBounty = $bountyData['tweets'][$userAddress] ?? 0;


        $sortedLeaderboard = collect($leaderboardData)
            ->sortDesc() // Mengurutkan dari yang tertinggi ke terendah berdasarkan reputasi
            ->keys() // Mengambil kunci (alamat) dari array yang sudah diurutkan
            ->values() // Mengambil nilai-nilai kunci untuk mendapatkan array baru
            ->all();

        // Menentukan urutan untuk setiap alamat
        $rankedLeaderboard = array_flip($sortedLeaderboard);

        // Menggeser urutan untuk memastikan dimulai dari 1
        $rankedLeaderboard = array_map(function ($rank) {
            return $rank + 1;
        }, $rankedLeaderboard);

        // Mendapatkan peringkat pengguna yang diminta
        $userRank = $rankedLeaderboard[$userAddress] ?? null;

        $totalRep = array_sum($leaderboardData);

        $totalBounty = array_sum($bountyData['tweets']);

        $exdPrice = 0.0647;
        $hourlyReward = $hourlyData[$userAddress] ?? 0;
        $monthlyReward = ($dailyData[$userAddress] ?? 0) * 30;
        $hourlyRepIncrease = 506;

        // Return view with data
        return view('exorde.stats', compact('userAddress', 'userRep', 'userRank', 'userBounty', 'exdPrice', 'hourlyReward', 'monthlyReward', 'hourlyRepIncrease', 'totalRep', 'totalBounty'));
    }
}
