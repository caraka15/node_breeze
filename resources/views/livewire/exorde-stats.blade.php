<!-- resources/views/livewire/exorde-stats.blade.php -->

<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <form wire:submit.prevent="submitForm">
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        Address
                    </label>
                    <div class="mt-1">
                        <input wire:model="address" type="text" id="address" name="address"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <button type="submit"
                        class="focus:shadow-outline-indigo mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-indigo-500 focus:border-indigo-700 focus:outline-none active:bg-indigo-800">
                        Submit
                    </button>
                </form>

                {{-- Tampilkan hasil data di sini --}}
                @if ($stats)
                    <div class="mt-4">
                        <p>Total Reputation: {{ $totalRep }}</p>
                        <p>Rank: {{ $leaderboardStats['rank'] }}</p>
                        <p>Reputation: {{ $leaderboardStats['reputation'] }}</p>
                        <p>Percentage: {{ $leaderboardStats['percentage'] }}%</p>
                        <p>Bounty: {{ $bountiesStats['bounty'] }}</p>
                        <p>Bounty Percentage: {{ $bountiesStats['percentage'] }}%</p>
                        <p>Projected Hourly Reward: {{ $hourlyRewardStats['projected_hourly_reward'] }}</p>
                        <p>Expected Monthly Reward: {{ $hourlyRewardStats['expected_monthly_reward'] }}</p>
                        <p>Expected Monthly Reward USD: {{ $hourlyRewardStats['expected_monthly_reward_usd'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
