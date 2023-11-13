<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight items-center">
            <div class="flex items-center justify-center">
                <input type="text"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-l-md w-80"
                    placeholder="Search" />
                <button
                    class="inline-flex items-center p-3 bg-gray-800 dark:bg-orange-500 border border-transparent rounded-r-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-orange-600 focus:bg-gray-700 dark:focus:bg-orange-600 active:bg-gray-900 dark:active:bg-orange-600  transition ease-in-out duration-150">
                    {{ __('Search') }}
                </button>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Post All') }}
                </div>
            </div>
        </div>
    </div>

    @php
        // Menghilangkan tag HTML
        $deskripsiWithoutTags = strip_tags($posts[0]->description);

        // Mengambil 200 karakter pertama
        $deskripsi = \Illuminate\Support\Str::limit($deskripsiWithoutTags, 200);
    @endphp

    @if ($posts->count())
        <div class="bg-white shadow-md rounded-md p-6 mb-6 text-center mx-10">
            <img src="https://source.unsplash.com/1200x400?laptop" class="w-full h-auto" alt="" />
            <div class="mt-4">
                <h3 class="text-xl font-semibold mb-2">
                    <a href="/posts/" class="text-black no-underline hover:underline">{{ $posts[0]->name }}</a>
                </h3>
                <p class="text-body-secondary">
                    By.
                    <a href="/posts?author=" class="text-blue-500">{caraka widi saputra}</a>
                    in
                    <a href="/posts?category=" class="text-blue-500">laptop</a>
                </p>
                <p class="mt-2 text-gray-700">
                    {{ $deskripsi }}
                </p>
                <a href="/posts/{{ $posts[0]->slug }}"
                    class="w-32 ml-auto block mt-3 text-white bg-blue-500 px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                    Read More..
                </a>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="flex flex-wrap mx-3 justify-center">
                @foreach ($posts->skip(1) as $post)
                    @php
                        // Menghilangkan tag HTML
                        $deskripsiWithoutTags = strip_tags($post->description);

                        // Mengambil 200 karakter pertama
                        $deskripsi = \Illuminate\Support\Str::limit($deskripsiWithoutTags, 200);
                    @endphp

                    <div class="w-80 m-4">
                        <div class="relative bg-white shadow-md rounded-sm overflow-hidden">
                            <div class="absolute left-0 top-0 px-3 py-2 bg-black bg-opacity-70">
                                <a href="/posts?category=#" class="text-white no-underline">laptop</a>
                            </div>
                            <img src="https://source.unsplash.com/500x400?laptop" class="w-full" alt="" />
                            <div class="p-4">
                                <h5 class="text-lg font-semibold">{{ $post->name }}</h5>
                                <p class="mt-2">
                                    <small class="text-gray-600">
                                        By.
                                        <a href="/posts?author=#" class="text-blue-500">caraka
                                            widi</a>
                                    </small>
                                </p>
                                <p class="mt-2 text-gray-700 text-sm">
                                    {{ $deskripsi }}
                                </p>
                                <a href="/posts/{{ $post->slug }}"
                                    class="mt-4 w-32 ml-auto block text-white bg-blue-500 px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                    Read More..
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No Post Found.</p>
    @endif

</x-app-layout>
