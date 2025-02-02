<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExordeHistoryService
{
    private $storageFile = 'reputation-tracking/reputation-history.json';

    public function getHistory($address)
    {
        $snapshots = $this->loadAllSnapshots();
        if (empty($snapshots)) {
            return [];
        }

        $addressHistory = [];
        $cutoffTime = Carbon::now()->subHours(24);

        foreach ($snapshots as $snapshot) {
            $snapshotTime = Carbon::parse($snapshot['timestamp']);

            // Skip if older than 24 hours
            if ($snapshotTime->lt($cutoffTime)) {
                continue;
            }

            // Find the address data in the snapshot's data array
            $addressData = null;
            foreach ($snapshot['data'] as $data) {
                if (strtolower($data['address']) === strtolower($address)) {
                    $addressData = $data;
                    break;
                }
            }

            if ($addressData) {
                $addressHistory[] = [
                    'timestamp' => $snapshotTime->toIso8601String(),
                    'reputation' => $addressData['current_reputation']
                ];
            }
        }

        return $addressHistory;
    }

    public function getReputationChanges($address)
    {
        $history = $this->getHistory($address);
        if (count($history) < 2) {
            return [];
        }

        $changes = [];
        for ($i = 1; $i < count($history); $i++) {
            $current = $history[$i];
            $previous = $history[$i - 1];

            $changes[] = [
                'timestamp' => $current['timestamp'],
                'change' => $current['reputation'] - $previous['reputation'],
                'from' => $previous['reputation'],
                'to' => $current['reputation']
            ];
        }

        return $changes;
    }

    private function loadAllSnapshots()
    {
        if (!Storage::exists($this->storageFile)) {
            return [];
        }

        try {
            $content = Storage::get($this->storageFile);
            $data = json_decode($content, true);

            // Handle the case where we have a single snapshot
            if (isset($data['timestamp'])) {
                return [$data];
            }

            // Handle the case where we have multiple snapshots
            return is_array($data) ? $data : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
