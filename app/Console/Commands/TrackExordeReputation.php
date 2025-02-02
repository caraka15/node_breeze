<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TrackExordeReputation extends Command
{
    protected $signature = 'exorde:track-reputation';
    protected $description = 'Track reputation changes for all addresses in the Exorde leaderboard and cleanup old data';

    private $leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
    private $localApiUrl = "https://crxanode.xyz/exorde-api?user_address=";
    private $storageFile = 'reputation-tracking/reputation-history.json';

    public function handle()
    {
        $this->info('Starting reputation tracking...');

        try {
            // Get current leaderboard data
            $leaderboardData = $this->fetchLeaderboard();
            if (empty($leaderboardData)) {
                $this->error('Failed to fetch valid leaderboard data');
                return 1;
            }

            $this->info('Fetched leaderboard data: ' . count($leaderboardData) . ' entries');

            // Load and clean history
            $currentTime = Carbon::now();
            $history = $this->loadAndCleanHistory($currentTime);
            $previousReputation = $this->getPreviousReputation($history);

            // Fetch reputation data for each address
            $updatedReputation = [];
            $processedCount = 0;

            // Process each address in the leaderboard
            foreach ($leaderboardData as $address => $leaderboardReputation) {
                $address = strtolower($address);

                // Add delay to prevent overwhelming the API
                usleep(100000); // 100ms delay

                $reputationData = $this->fetchReputation($address);

                $this->line("Processing address: $address");

                // Use leaderboard reputation as fallback if API fails
                $currentReputation = isset($reputationData['final'])
                    ? (int) str_replace([',', ' '], '', $reputationData['final'])
                    : $leaderboardReputation;

                $previousValue = $previousReputation[$address] ?? 0;
                $reputationChange = $currentReputation - $previousValue;

                $updatedReputation[] = [
                    'address' => $address,
                    'current_reputation' => $currentReputation,
                    'change' => $reputationChange
                ];

                $processedCount++;

                if ($processedCount % 10 === 0) {
                    $this->info("Processed $processedCount addresses...");
                }
            }

            // Save history
            if (!empty($updatedReputation)) {
                $history = $this->saveHistory($history, $currentTime, $updatedReputation);
                $this->info('History saved successfully.');
            } else {
                $this->warn('No reputation data was collected.');
            }

            $this->info('Reputation tracking completed successfully.');
            $this->info('Total addresses processed: ' . count($updatedReputation));

            return 0;
        } catch (\Exception $e) {
            $this->error('Error during tracking: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
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

    private function fetchReputation($address)
    {
        try {
            $response = Http::timeout(10)->get($this->localApiUrl . $address);

            if (!$response->successful()) {
                throw new \Exception("HTTP request failed with status: " . $response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            $this->warn("Error fetching reputation for $address: " . $e->getMessage());
            return [];
        }
    }

    private function loadAndCleanHistory(Carbon $currentTime)
    {
        $history = $this->loadHistory();

        // Filter entries less than 24 hours old
        $cleanedHistory = array_filter($history, function ($entry) use ($currentTime) {
            if (!isset($entry['timestamp'])) {
                return false;
            }

            $entryTime = Carbon::parse($entry['timestamp']);
            return $currentTime->diffInHours($entryTime) < 24;
        });

        return array_values($cleanedHistory);
    }

    private function getPreviousReputation($history)
    {
        if (empty($history)) return [];

        $latestSnapshot = end($history);
        $previousReputation = [];

        if (!isset($latestSnapshot['data'])) {
            return [];
        }

        foreach ($latestSnapshot['data'] as $entry) {
            if (!isset($entry['address']) || !isset($entry['current_reputation'])) {
                continue;
            }
            $previousReputation[$entry['address']] = $entry['current_reputation'];
        }

        return $previousReputation;
    }

    private function loadHistory()
    {
        if (!Storage::exists($this->storageFile)) {
            return [];
        }

        try {
            $content = Storage::get($this->storageFile);
            $data = json_decode($content, true);

            return is_array($data) ? $data : [];
        } catch (\Exception $e) {
            $this->error("Error loading history: " . $e->getMessage());
            return [];
        }
    }

    private function saveHistory($history, Carbon $timestamp, $updatedReputation)
    {
        $newSnapshot = [
            'timestamp' => $timestamp->toIso8601String(),
            'data' => $updatedReputation,
            'metadata' => [
                'total_addresses' => count($updatedReputation),
                'snapshot_number' => count($history) + 1
            ]
        ];

        $history[] = $newSnapshot;

        // Ensure directory exists
        $directory = dirname(Storage::path($this->storageFile));
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        Storage::put($this->storageFile, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $history;
    }
}
