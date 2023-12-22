<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="max-w-[700px] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="dark:text-white mb-7 text-2xl text-center">ADD NEW CONFIG</h2>

                    <div class="flex justify-center space-x-4 mb-4">
                        <button id="vmessBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md">vmess</button>
                        <button id="otherBtn" class="px-4 py-2 bg-green-500 text-white rounded-md">other</button>
                    </div>

                    <form id="vmessForm" method="post" action="/dashboard/config" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-text-input id="type" class="block mt-1 w-full" type="hidden" name="type"
                                :value="'vmess'" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="config" :value="__('Config')" />
                            <div class="flex items-center">
                                <input type="text" id="config" name="config"
                                    class="mt-1 block w-full text-lg text-slate-500 border border-gray-300 rounded-md focus:ring focus:border-blue-300 focus:outline-none px-4 py-3" />
                            </div>
                            <x-input-error :messages="$errors->get('config')" class="mt-2" />
                        </div>
                        <x-primary-button class="ml-[450px] mt-5 w-[122px]">
                            {{ __('Add Config') }}
                        </x-primary-button>
                    </form>

                    <form id="otherForm" method="post" action="/dashboard/config" enctype="multipart/form-data"
                        style="display: none;">
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
                                name="type" id="type">
                                <option value="netmod" selected>netmod</option>
                                <option value="http custom">http custom</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="config" :value="__('Config')" />
                            <div class="flex items-center">
                                <span class="sr-only mt-1">Choose profile photo</span>
                                <input type="file" id="config" name="config"
                                    class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:text-sm file:font-semibold file:rounded-full file:border-0 file:bg-violet-50 file:text-orange-700 hover:file:bg-violet-100" />
                            </div>
                        </div>
                        <x-primary-button class="ml-[450px] mt-5 w-[122px]">
                            {{ __('Add Config') }}
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
            const image = document.querySelector('#config');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]); // Perbaikan typo di sini

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
    <script>
        const vmessForm = document.querySelector('#vmessForm');
        const otherForm = document.querySelector('#otherForm');
        const vmessBtn = document.querySelector('#vmessBtn');
        const otherBtn = document.querySelector('#otherBtn');

        vmessBtn.addEventListener('click', function() {
            vmessForm.style.display = 'block';
            otherForm.style.display = 'none';
        });

        otherBtn.addEventListener('click', function() {
            vmessForm.style.display = 'none';
            otherForm.style.display = 'block';
        });

        // ... (lanjutkan dengan script yang lain)
    </script>
</x-app-layout>
