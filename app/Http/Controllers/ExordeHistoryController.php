<?php

namespace App\Http\Controllers;

use App\Services\ExordeHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExordeHistoryController extends Controller
{
    private $historyService;

    public function __construct(ExordeHistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function getReputationHistory(Request $request)
    {
        $address = strtolower($request->input('user_address')); // Force lowercase

        if (!$address) {
            return response()->json(['error' => 'Address is required'], 400);
        }

        Log::info("Fetching reputation history for address: {$address}");

        $history = $this->historyService->getHistory($address);
        $changes = $this->historyService->getReputationChanges($address);

        if (empty($history)) {
            Log::warning("No reputation history found for: {$address}");
            return response()->json(['error' => 'No data found for this address'], 404);
        }

        return response()->json([
            'history' => $history,
            'changes' => $changes,
            'total_snapshots' => count($history),
            'first_snapshot' => $history[0] ?? null,
            'latest_snapshot' => end($history) ?: null,
        ]);
    }
}
