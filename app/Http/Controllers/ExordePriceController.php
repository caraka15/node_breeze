<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExordePriceController extends Controller
{
    public function getPrice()
    {
        try {
            $path = 'public/data-json/exorde_price.json';

            if (!Storage::exists($path)) {
                return response()->json([
                    'error' => 'Price data not available'
                ], 404);
            }

            $priceData = json_decode(Storage::get($path), true);

            // Check if data is older than 2 hours (as a safeguard)
            $lastUpdated = \Carbon\Carbon::parse($priceData['last_updated']);
            if ($lastUpdated->diffInHours(now()) > 2) {
                return response()->json([
                    'error' => 'Price data is stale',
                    'last_updated' => $priceData['last_updated']
                ], 500);
            }

            return response()->json($priceData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch price data'
            ], 500);
        }
    }
}