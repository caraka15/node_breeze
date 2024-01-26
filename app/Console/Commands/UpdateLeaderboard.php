<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateLeaderboard extends Command
{
    protected $signature = 'leaderboard:update';
    protected $description = 'Update daily leaderboard data';

    public function handle()
    {
        try {
            // Ambil data leaderboard dari URL
            // $response = Http::get("https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json");

            $response = Http::get("https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/7f98f36b706714b41b2428abf603ed35e0d61866/Stats/leaderboard.json");

            if ($response->successful()) {
                $latestLeaderboardData = $response->json();

                // Inisialisasi array untuk menyimpan data leaderboard harian dalam format "rank, address, value"
                $dailyLeaderboardArray = [];

                // Mendapatkan nilai terurut dari leaderboard terbaru
                arsort($latestLeaderboardData);

                // Loop through leaderboard terbaru
                foreach ($latestLeaderboardData as $address => $value) {
                    // Menambahkan data ke array dalam format yang diinginkan
                    $dailyLeaderboardArray[] = [
                        'rank' => count($dailyLeaderboardArray) + 1,
                        'address' => $address,
                        'value' => $value,
                    ];
                }

                // Simpan data leaderboard harian ke dalam file daily_leaderboard.json
                Storage::disk('public')->put('php/daily_leaderboard.json', json_encode($dailyLeaderboardArray));

                $this->info('Daily leaderboard updated successfully!');
            } else {
                $this->error('Failed to fetch leaderboard data.');
            }
        } catch (\Exception $e) {
            $this->error('Error updating daily leaderboard: ' . $e->getMessage());
        }
    }
}
