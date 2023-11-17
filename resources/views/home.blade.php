<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 text-gray-900 dark:text-gray-100">
                    <div class="pl-6 mb-4 text-2xl">
                        {{ __('Mainnet') }}
                    </div>

                    <div class="flex flex-wrap justify-start">
                        @foreach ($chainds as $chaind)
                            @if ($chaind['type'] === 'Mainnet')
                                @php
                                    $rpc_status = @file_get_contents("{$chaind['rpc_link']}/status?");
                                    $rpc_status = json_decode($rpc_status);
                                @endphp

                                <div class="card m-4">
                                    <div class="card-content ">
                                        <img src="{{ asset('storage/' . $chaind->logo) }}" alt="{{ $chaind->name }}"
                                            class="mx-auto w-[70px] h-[70px] rounded-full" />
                                        <h2>{{ $chaind->name }}</h2>
                                        <a href="{{ $chaind->stake_link }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
                                            target="_blank">STAKE</a>
                                        <a href="{{ $chaind->slug }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 text-gray-900 dark:text-gray-100">
                    <div class="pl-6 mb-4 text-2xl">
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
                                        <img src="{{ asset('storage/' . $chaind->logo) }}" alt="{{ $chaind->name }}"
                                            class="mx-auto w-[70px] h-[70px] rounded-full" />
                                        <h2>{{ $chaind->name }}</h2>
                                        <a href="{{ $chaind->stake_link }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
                                            target="_blank">STAKE</a>
                                        <a href="{{ $chaind->slug }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
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
