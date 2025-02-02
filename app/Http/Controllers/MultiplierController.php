<?php
// app/Http/Controllers/MultiplierController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MultiplierController extends Controller
{
    private $configPath = 'data-json/multipliers.json';

    public function getMultipliers()
    {
        $multipliers = $this->loadMultipliers();
        return response()->json($multipliers);
    }

    public function updateMultipliers(Request $request)
    {
        $request->validate([
            'twitter' => 'required|numeric',
            'reddit' => 'required|numeric',
            'youtube' => 'required|numeric',
            'news' => 'required|numeric',
            'bsky' => 'required|numeric',
            'threads' => 'required|numeric',
            'pool' => 'require|numeric',
        ]);

        $multipliers = [
            'twitter' => $request->twitter,
            'reddit' => $request->reddit,
            'youtube' => $request->youtube,
            'news' => $request->news,
            'bsky' => $request->bsky,
            'threads' => $request->threads,
            'pool' => $request->pool,
        ];

        Storage::disk('public')->put($this->configPath, json_encode($multipliers));

        return response()->json(['message' => 'Multipliers updated successfully']);
    }

    private function loadMultipliers()
    {
        if (!Storage::disk('public')->exists($this->configPath)) {
            // Default values
            $defaultMultipliers = [
                'twitter' => 1,
                'reddit' => 1,
                'youtube' => 1,
                'news' => 1,
                'bsky' => 1,
                'threads' => 1,
                'pool' => 400000,
            ];
            Storage::disk('public')->put($this->configPath, json_encode($defaultMultipliers));
            return $defaultMultipliers;
        }

        return json_decode(Storage::disk('public')->get($this->configPath), true);
    }
}
