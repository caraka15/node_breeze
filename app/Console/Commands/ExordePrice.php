<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchExordePriceCommand extends Command
{
    protected $signature = 'exorde:fetch-price';
    protected $description = 'Fetch Exorde price from CoinMarketCap and store it in JSON file';

    private $cmcApiKey = 'c67e76f3-c420-4446-9573-c2d591e2e382';

    public function handle()
    {
        try {
            $response = Http::withHeaders([
                'Accepts' => 'application/json',
                'X-CMC_PRO_API_KEY' => $this->cmcApiKey
            ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest', [
                'slug' => 'exorde',
                'convert' => 'USD'
            ]);

            $data = $response->json();
            $price = $data['data']['23638']['quote']['USD']['price'];

            // Create price data structure with timestamp
            $priceData = [
                'price' => $price,
                'last_updated' => now()->toIso8601String()
            ];

            // Store in JSON file
            Storage::put('data-json/exorde_price.json', json_encode($priceData));

            $this->info('Exorde price successfully fetched and stored.');
        } catch (\Exception $e) {
            $this->error('Failed to fetch Exorde price: ' . $e->getMessage());
        }
    }
}