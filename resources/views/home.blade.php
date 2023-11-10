<!-- resources/views/your-view.blade.php -->
<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 text-2xl">
                        {{ __('Mainnet') }}
                    </div>

                    <div class="flex flex-row">
                        @foreach ($chainds as $chaind)
                            @if ($chaind['type'] === 'Mainnet')
                                @php
                                    $rpc_status = @file_get_contents("{$chaind['rpc_link']}/status?");
                                    $rpc_status = json_decode($rpc_status);
                                @endphp
                                <x-Card class="mr-10" image="{{ asset('storage/' . $chaind->logo) }}"
                                    name="{{ $chaind->name }}" stakeLink="{{ $chaind->stake_link }}"
                                    guideLink="{{ $chaind->slug }}"
                                    dotActive="{{ $rpc_status && isset($rpc_status->result->sync_info->catching_up) && $rpc_status->result->sync_info->catching_up == false }}" />
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 text-2xl">
                        {{ __('Testnet') }}
                    </div>

                    <div class="flex flex-row">
                        @foreach ($chainds as $chaind)
                            @if ($chaind['type'] === 'Testnet')
                                @php
                                    $rpc_status = @file_get_contents("{$chaind['rpc_link']}/status?");
                                    $rpc_status = json_decode($rpc_status);
                                @endphp
                                <x-Card class="mt-10" image="{{ asset('storage/' . $chaind->logo) }}"
                                    name="{{ $chaind->name }}" stakeLink="{{ $chaind->stake_link }}"
                                    guideLink="{{ $chaind->slug }}"
                                    dotActive="{{ $rpc_status && isset($rpc_status->result->sync_info->catching_up) && $rpc_status->result->sync_info->catching_up == false }}" />
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
