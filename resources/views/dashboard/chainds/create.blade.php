<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="mx-auto max-w-[700px] space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    <h2 class="mb-7 text-center text-2xl dark:text-white">ADD NEW CHAIND</h2>
                    <form method="post" action="/dashboard/chainds" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="type" class="form-label">Type</x-input-label>
                            <select
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                                name="type">
                                <option value="Mainnet" selected>Mainnet</option>
                                <option value="Testnet">Testnet</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" class="mt-1 block w-full" type="text" name="slug"
                                :value="old('slug')" required autofocus autocomplete="slug" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rpc_link" :value="__('rpc link')" />
                            <x-text-input id="rpc_link" class="mt-1 block w-full" type="text" name="rpc_link"
                                :value="old('rpc_link')" required autofocus autocomplete="rpc_link" />
                            <x-input-error :messages="$errors->get('rpc_link')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="stake_link" :value="__('Stake link')" />
                            <x-text-input id="stake_link" class="mt-1 block w-full" type="text" name="stake_link"
                                :value="old('stake_link')" required autofocus autocomplete="stake_link" />
                            <x-input-error :messages="$errors->get('stake_link')" class="mt-2" />
                        </div>

                        <x-primary-button class="ml-[450px] mt-5 w-[122px]">
                            {{ __('Add Chaind') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        name.addEventListener('change', function() {
            fetch('/dashboard/chainds/checkSlug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        })

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })
    </script>
</x-app-layout>
