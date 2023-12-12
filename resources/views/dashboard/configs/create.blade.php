<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="max-w-[700px] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="dark:text-white mb-7 text-2xl text-center">ADD NEW CONFIG</h2>
                    <form method="post" action="/dashboard/config" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <x-input-label for="config" :value="__('Config')" />
                            <div class="flex items-center">
                                <span class="sr-only mt-1">Choose profile photo</span>
                                <input type="file" id="config" name="config"
                                    class=" mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:text-sm file:font-semibold file:rounded-full file:border-0 file:bg-violet-50 file:text-orange-700 hover:file:bg-violet-100
                                    " />
                                <x-input-error :messages="$errors->get('config')" class="mt-2" />
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
</x-app-layout>
