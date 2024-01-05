<x-app-layout>

    @include('hero')
    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="py-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 pl-6 text-2xl">
                        {{ __('Mainnet') }}
                    </div>

                    <div id="network" class="flex flex-wrap justify-start">
                        @foreach ($chainds as $chaind)
                            @if ($chaind['type'] === 'Mainnet')
                                @php
                                    $rpc_status = @file_get_contents("{$chaind['rpc_link']}/status?");
                                    $rpc_status = json_decode($rpc_status);
                                @endphp

                                <div class="card m-4">
                                    <div class="card-content">
                                        <img src="{{ 'https://raw.githubusercontent.com/caraka15/node_network/main/logo-chaind/' . $chaind->slug . '.png' }}"
                                            alt="{{ $chaind->name }}" class="mx-auto h-[70px] w-[70px] rounded-full" />
                                        <h2>{{ $chaind->name }}</h2>
                                        <a href="{{ $chaind->stake_link }}"
                                            class="relative mb-3 inline-block h-[35px] w-[120px] rounded-md bg-orange-600 pt-[5px] hover:scale-105 hover:bg-orange-500"
                                            target="_blank">STAKE</a>
                                        <a href="{{ $chaind->slug }}"
                                            class="relative mb-3 inline-block h-[35px] w-[120px] rounded-md bg-orange-600 pt-[5px] hover:scale-105 hover:bg-orange-500"
                                            target="_blank">GUIDE</a>

                                        @if (
                                            $rpc_status &&
                                                isset($rpc_status->result->sync_info->catching_up) &&
                                                $rpc_status->result->sync_info->catching_up == false)
                                            <div class="dot-active"></div>
                                        @else
                                            <div class="dot-inactive"></div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="py-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 pl-6 text-2xl">
                        {{ __('Testnet') }}
                    </div>

                    <div class="flex flex-wrap justify-start">
                        @foreach ($chainds as $chaind)
                            @if ($chaind['type'] === 'Testnet')
                                @php
                                    $rpc_status = @file_get_contents("{$chaind['rpc_link']}/status?");
                                    $rpc_status = json_decode($rpc_status);
                                @endphp

                                <div class="card m-6">
                                    <div class="card-content">
                                        <img src="{{ 'https://raw.githubusercontent.com/caraka15/node_network/main/logo-chaind/' . $chaind->slug . '.png' }}"
                                            class="mx-auto h-[70px] w-[70px] rounded-full" />
                                        <h2>{{ $chaind->name }}</h2>
                                        <a href="{{ $chaind->stake_link }}"
                                            class="relative mb-3 inline-block h-[35px] w-[120px] rounded-md bg-orange-600 pt-[5px] hover:scale-105 hover:bg-orange-500"
                                            target="_blank">STAKE</a>
                                        <a href="{{ $chaind->slug }}"
                                            class="relative mb-3 inline-block h-[35px] w-[120px] rounded-md bg-orange-600 pt-[5px] hover:scale-105 hover:bg-orange-500"
                                            target="_blank">GUIDE</a>

                                        @if (
                                            $rpc_status &&
                                                isset($rpc_status->result->sync_info->catching_up) &&
                                                $rpc_status->result->sync_info->catching_up == false)
                                            <div class="dot-active"></div>
                                        @else
                                            <div class="dot-inactive"></div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
