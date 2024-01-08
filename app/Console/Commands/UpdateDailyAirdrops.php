<?php
// app/Console/Commands/UpdateDailyAirdrops.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Airdrop;

class UpdateDailyAirdrops extends Command
{
    protected $signature = 'airdrops:update-daily';
    protected $description = 'Update sudah_dikerjakan to false for daily airdrops at 00:00';

    public function handle()
    {
        try {
            // Update sudah_dikerjakan to false for daily airdrops
            Airdrop::where('frekuensi', 'daily')->update(['sudah_dikerjakan' => false]);

            $this->info('Daily Airdrops updated successfully.');
        } catch (\Exception $exception) {
            $this->error('Failed to update Daily Airdrops: ' . $exception->getMessage());
        }
    }
}
