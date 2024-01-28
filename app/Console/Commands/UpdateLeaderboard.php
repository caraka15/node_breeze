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
            // Ambil data leaderboard dari URL
            $response = Http::get("https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json");

            if ($response->successful()) {
                $leaderboardData = $response->json();

                // Menentukan pilihan berdasarkan argumen yang diberikan
                if ($this->option('daily')) {
                    $this->updateDailyLeaderboard($leaderboardData);
                } elseif ($this->option('latest')) {
                    $this->updateLatestLeaderboard($leaderboardData);
                } else {
                    $this->error('Please provide either --daily or --latest option.');
                }
            } else {
                $this->error('Failed to fetch leaderboard data.');
            }
        } catch (\Exception $e) {
            $this->error('Error updating leaderboard: ' . $e->getMessage());
        }
    }

    protected function updateDailyLeaderboard($leaderboardData)
    {
        // Inisialisasi array untuk menyimpan data leaderboard harian dalam format "rank, address, value"
        $dailyLeaderboardArray = [];

        // Mendapatkan nilai terurut dari leaderboard terbaru
        arsort($leaderboardData);

        // Loop through leaderboard terbaru
        foreach ($leaderboardData as $address => $value) {
            // Menambahkan data ke array dalam format yang diinginkan
            $dailyLeaderboardArray[] = [
                'rank' => count($dailyLeaderboardArray) + 1,
                'address' => $address,
                'value' => $value,
            ];
        }

        // Simpan data leaderboard harian ke dalam file daily_leaderboard.json
        Storage::disk('public')->put('data-json/daily_leaderboard.json', json_encode($dailyLeaderboardArray));

        $this->info('Daily leaderboard updated successfully!');
    }

    protected function updateLatestLeaderboard($leaderboardData)
    {
        // Inisialisasi array untuk menyimpan data leaderboard harian dalam format "rank, address, value"
        $latestLeaderboardArray = [];

        // Mendapatkan nilai terurut dari leaderboard terbaru
        arsort($leaderboardData);

        // Loop through leaderboard terbaru
        foreach ($leaderboardData as $address => $value) {
            // Menambahkan data ke array dalam format yang diinginkan
            $latestLeaderboardArray[] = [
                'rank' => count($latestLeaderboardArray) + 1,
                'address' => $address,
                'value' => $value,
            ];
        }        // Simpan data leaderboard terbaru ke dalam file latest_leaderboard.json
        Storage::disk('public')->put('data-json/latest_leaderboard.json', json_encode($latestLeaderboardArray));

        $this->info('Latest leaderboard updated successfully!');
    }
}