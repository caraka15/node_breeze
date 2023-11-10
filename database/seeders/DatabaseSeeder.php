<?php

namespace Database\Seeders;
use App\Models\Chaind;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Chaind::create([
            'type' => 'Mainnet',
            'name' => 'Planq',
            'slug' => 'planq',
            'logo' => 'planq.jpg',
            'guide_link' => 'planq.md',
            'rpc_link' => 'https://rpc.planq.crxa.my.id',
            'stake_link' => 'https://explorer.tcnetwork.io/planq/validator/plqvaloper16cfuq9d8nv2yrfzl409xkk6w0s4mq9asad5c47',
        ]);

        Chaind::create([
            'type' => 'Testnet',
            'name' => 'Mande',
            'slug' => 'mande',
            'logo' => 'mande.png',
            'guide_link' => 'mande.md',
            'rpc_link' => 'https://rpc.mande.crxa.my.id',
            'stake_link' => 'https://explorer.tcnetwork.io/planq/validator/plqvaloper16cfuq9d8nv2yrfzl409xkk6w0s4mq9asad5c47',
        ]);
    }
}