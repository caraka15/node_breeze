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
                                <div class="card mr-10">
                                    <div class="card-content">
                                        <img src="https://crxa.my.id/storage/logo-chaind/2dN8UK49kdvkbHmePJwjDdOB1Sz2xFcDQ141R9jS.png"
                                            alt="$name" class="mx-auto w-[70px] h-[70px] rounded-full" />
                                        <h2>{{ $chaind->name }}</h2>
                                        <a href="{{ $chaind->stake_link }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
                                            target="_blank">STAKE
                                        </a>
                                        <a href="{{ $chaind->slug }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
                                            target="_blank">GUIDE
                                        </a>
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
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 text-2xl">
                        {{ __('Testnet') }}
                    </div>

                    <div class="flex flex-row">
                        @foreach ($chainds as $chaind)
                            @if ($chaind['type'] === 'Testnet')
                                <div class="card mt-10">
                                    <div class="card-content">
                                        <img src="https://crxa.my.id/storage/logo-chaind/2dN8UK49kdvkbHmePJwjDdOB1Sz2xFcDQ141R9jS.png"
                                            alt="$name" class="mx-auto w-[70px] h-[70px] rounded-full" />
                                        <h2>{{ $chaind->name }}</h2>
                                        <a href="{{ $chaind->stake_link }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
                                            target="_blank">STAKE
                                        </a>
                                        <a href="{{ $chaind->slug }}"
                                            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
                                            target="_blank">GUIDE
                                        </a>
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
