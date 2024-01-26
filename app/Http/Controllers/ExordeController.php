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
        $dailyLeaderboardData = json_decode(Storage::disk('public')->get('php/daily_leaderboard.json'), true);

        // Ambil data leaderboard terbaru dari URL
        $latestLeaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";

        $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
        $leaderboardDatas = Http::get($leaderboardUrl)->json();

        $bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";
        $bountyDatas = Http::get($bountyUrl)->json();

        $totalRep = array_sum($leaderboardDatas);
        $totalBounty = array_sum($bountyDatas['tweets']);

        // Loop through leaderboard terbaru
        $latestLeaderboardData = Http::get($latestLeaderboardUrl)->json();

        // Inisialisasi array untuk menyimpan data leaderboard harian dalam format "rank, address, value"
        $latestLeaderboardArray = [];

        // Mendapatkan nilai terurut dari leaderboard terbaru
        arsort($latestLeaderboardData);

        // Loop through leaderboard terbaru
        foreach ($latestLeaderboardData as $address => $value) {
            // Menambahkan data ke array dalam format yang diinginkan
            $latestLeaderboardArray[] = [
                'rank' => count($latestLeaderboardArray) + 1,
                'address' => $address,
                'value' => $value,
            ];
        }

        $latestRank = [];

        foreach ($latestLeaderboardArray as $entry) {
            $latestRank[$entry['address']] = $entry['rank'];
        }

        $dailyRank = [];

        foreach ($dailyLeaderboardData as $entry) {
            $dailyRank[$entry['address']] = $entry['rank'];
        }

        $leaderboards = [];

        foreach ($latestLeaderboardArray as $entry) {
            $address = $entry['address'];

            // Peringkat harian
            $dailyRankValue = isset($dailyRank[$address]) ? $dailyRank[$address] : null;

            // Peringkat terbaru
            $latestRankValue = isset($latestRank[$address]) ? $latestRank[$address] : null;

            // Perbedaan peringkat
            $rankDifference = ($latestRankValue !== null) ? ($dailyRankValue - $latestRankValue) : null;

            // Tambahkan informasi ke array $leaderboards
            $leaderboards[] = [
                'rank' => $latestRankValue,
                'address' => $address,
                'value' => $entry['value'],
                'rankDifference' => $rankDifference,
            ];
        }

        return view('exorde.index', [
            'leaderboards' => $leaderboards,
            'totalBounty' => $totalBounty,
            'totalReputation' => $totalRep
        ]);
    }
}
