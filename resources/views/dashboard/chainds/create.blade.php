<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="max-w-[700px] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="dark:text-white mb-7 text-2xl text-center">ADD NEW CHAIND</h2>
                    <form method="post" action="/dashboard/chainds" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="type" class="form-label">Type</x-input-label>
                            <select
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                name="type">
                                <option value="Mainnet" selected>Mainnet</option>
                                <option value="Testnet">Testnet</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                                :value="old('slug')" required autofocus autocomplete="slug" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>


                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Logo')" />
                            <div class="flex items-center">
                                <span class="sr-only mt-1">Choose profile photo</span>
                                <input type="file" id="logo" name="logo"
                                    class=" mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:text-sm file:font-semibold file:rounded-full file:border-0 file:bg-violet-50 file:text-orange-700 hover:file:bg-violet-100
                                    "
                                    onchange="previewImage()" />
                                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                                <div class="shrink-0">
                                    <img class="img-preview h-14 w-14 object-cover rounded-full" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="guide_link" :value="__('Guide_Link')" />
                            <span class="sr-only mt-1 mb-2">Choose Guide File</span>
                            <input type="file" id="guide_link" name="guide_link"
                                class="cursor-pointer mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:text-sm file:font-semibold file:rounded-full file:border-0 file:bg-violet-50 file:text-orange-700 hover:file:bg-violet-100
                                    " />
                            <x-input-error :messages="$errors->get('guide_link')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rpc_link" :value="__('rpc link')" />
                            <x-text-input id="rpc_link" class="block mt-1 w-full" type="text" name="rpc_link"
                                :value="old('rpc_link')" required autofocus autocomplete="rpc_link" />
                            <x-input-error :messages="$errors->get('rpc_link')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="stake_link" :value="__('Stake link')" />
                            <x-text-input id="stake_link" class="block mt-1 w-full" type="text" name="stake_link"
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

        function previewImage() {
            const image = document.querySelector('#logo');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]); // Perbaikan typo di sini

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
</x-app-layout>
