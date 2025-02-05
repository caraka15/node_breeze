<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\ExordeApiController;
use Illuminate\Http\Request;

class TrackExordeReputation extends Command
{
    protected $signature = 'exorde:track-reputation';
    protected $description = 'Track reputation changes for all addresses in the Exorde leaderboard and cleanup old data';

    private $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
    private $storageFile = 'reputation-tracking/reputation-history.json';
    private $exordeController;

    public function __construct(ExordeApiController $exordeController)
    {
        parent::__construct();
        $this->exordeController = $exordeController;
    }

    public function handle()
    {
        try {
            if (!Storage::exists('reputation-tracking')) {
                Storage::makeDirectory('reputation-tracking');
            }

            $leaderboardData = $this->fetchLeaderboard();
            if (empty($leaderboardData)) {
                $this->error('Failed to fetch valid leaderboard data');
                return 1;
            }

            $currentTime = Carbon::now();
            $history = $this->loadAndCleanHistory($currentTime);
            $previousReputation = $this->getPreviousReputation($history);

            $updatedReputation = [];
            $processedCount = 0;

            foreach ($leaderboardData as $address => $leaderboardReputation) {
                $address = strtolower($address);
                usleep(100000);

                try {
                    $currentReputation = $this->fetchReputationWithRetry($address, $previousReputation);

                    $previousValue = $previousReputation[$address] ?? 0;
                    $reputationChange = $currentReputation - $previousValue;

                    $updatedReputation[] = [
                        'address' => $address,
                        'current_reputation' => $currentReputation,
                        'change' => $reputationChange
                    ];

                    $processedCount++;
                } catch (\Exception $e) {
                    continue;
                }
            }

            if (!empty($updatedReputation)) {
                $this->saveHistory($history, $currentTime, $updatedReputation);
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Error during tracking: ' . $e->getMessage());
            return 1;
        }
    }

    private function fetchLeaderboard()
    {
        try {
            $response = Http::timeout(30)->get($this->leaderboardUrl);
            if (!$response->successful()) {
                throw new \Exception("HTTP request failed with status: " . $response->status());
            }
            $data = $response->json();
            if (!is_array($data)) {
                throw new \Exception("Invalid JSON response");
            }
            return $data;
        } catch (\Exception $e) {
            $this->error("Error fetching leaderboard: " . $e->getMessage());
            return [];
        }
    }

    private function fetchReputationWithRetry($address, $previousReputation)
    {
        try {
            $request = new Request();
            $request->merge(['user_address' => $address]);

            $this->info("Processing address: " . $address);

            $response = $this->exordeController->getStats($request);
            $reputationData = json_decode($response->getContent(), true);

            if (!isset($reputationData['final'])) {
                throw new \Exception("Invalid response format");
            }

            $this->info("OK\n");
            return (int) str_replace([',', ' '], '', $reputationData['final']);
        } catch (\Exception $e) {
            $this->error("FAILED: " . $e->getMessage() . "\n");
            return $previousReputation[$address] ?? 0;
        }
    }

    private function loadAndCleanHistory(Carbon $currentTime)
    {
        $history = $this->loadHistory();
        return array_values(array_filter($history, function ($entry) use ($currentTime) {
            return isset($entry['timestamp']) && $currentTime->diffInHours(Carbon::parse($entry['timestamp'])) < 24;
        }));
    }

    private function getPreviousReputation($history)
    {
        if (empty($history)) return [];
        $latestSnapshot = end($history);
        if (!isset($latestSnapshot['data'])) return [];
        return array_column($latestSnapshot['data'], 'current_reputation', 'address');
    }

    private function loadHistory()
    {
        if (!Storage::exists($this->storageFile)) return [];
        try {
            return json_decode(Storage::get($this->storageFile), true) ?? [];
        } catch (\Exception $e) {
            $this->error("Error loading history: " . $e->getMessage());
            return [];
        }
    }

    private function saveHistory($history, Carbon $timestamp, $updatedReputation)
    {
        $history[] = [
            'timestamp' => $timestamp->toIso8601String(),
            'data' => $updatedReputation,
            'metadata' => [
                'total_addresses' => count($updatedReputation),
                'snapshot_number' => count($history) + 1
            ]
        ];
        Storage::put($this->storageFile, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return $history;
    }
}