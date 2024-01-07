<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="mx-auto max-w-full space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-full">
                    <h2 class="mb-7 text-center text-2xl dark:text-white">ADD NEW CHAIND</h2>
                    <form method="post" action="/dashboard/posts/{{ $post->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                                :value="old('name', $post->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="category_id" class="form-label">Category</x-input-label>
                            <select
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-orange-600 dark:focus:ring-orange-600"
                                name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mt-4">
                            <x-input-label for="public" class="form-label">Post Status</x-input-label>
                            <select
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-orange-600 dark:focus:ring-orange-600"
                                name="public">
                                <option value="1" {{ old('public', $post->public) == 1 ? 'selected' : '' }}>Public
                                </option>
                                <option value="0" {{ old('public', $post->public) == 0 ? 'selected' : '' }}>Private
                                </option>
                            </select>
                        </div>


                        <div class="mt-4">
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" class="mt-1 block w-full" type="text" name="slug"
                                :value="old('slug', $post->slug)" required autofocus autocomplete="slug" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <textarea name="description" id="description" class="mb-2 h-52 w-full border-2 border-gray-200 p-2">{{ $post->description }}</textarea>
                        </div>

                        <x-primary-button class="ml-[450px] mt-5 w-[122px]">
                            {{ __('Add Posts') }}
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
            fetch('/dashboard/posts/checkSlug?name=' + name.value)
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
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        $('#description').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onPaste: function(e) {
                    // Block default paste behavior
                    e.preventDefault();

                    // Get plain text from clipboard
                    var text = (e.originalEvent.clipboardData || window.clipboardData).getData('text/plain');

                    // Remove all tags and attributes (including style and class)
                    var cleanText = text.replace(/<\/?[^>]+(>|$)/g, "");

                    // Insert plain text into Summernote
                    document.execCommand('insertText', false, cleanText);
                }
            }
        });
    </script>

</x-app-layout>
