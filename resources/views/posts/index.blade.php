<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2
            class="flex flex-col sm:flex-row sm:justify-between font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight items-center">
            <div class="mb-2 sm:mb-0 text-gray-900 dark:text-gray-100">
                {{ $title }}
            </div>
            <form action="/blogs">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="flex items-center justify-center">
                    <input type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-none
                        dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500
                        dark:focus:ring-orange-600 rounded-l-md max-w-full sm:w-80"
                        placeholder="Search.." name="search" value="{{ request('search') }}">
                    <button
                        class="inline-flex items-center p-3 bg-gray-800 dark:bg-orange-500 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-orange-600 focus:bg-gray-700 dark:focus:bg-orange-600 active:bg-gray-900 dark:active:bg-orange-600  transition ease-in-out duration-150"
                        type="submit">Search</button>
                </div>
            </form>
            </form>
        </h2>


    </x-slot>

    @if ($posts->count())
        <div class="flex m-6">
            <div class="bg-white dark:bg-slate-800 w-full mx-auto shadow-md rounded-md p-6  text-center ">
                @if ($posts[0]->image)
                    <div class="w-full h-[350px] mx-auto bg-cover bg-no-repeat bg-center border-slate-200"
                        style="background-image: url({{ $posts[0]->image }})">
                    </div>
                @else
                    <div class="w-full h-[250px] mx-auto bg-cover bg-no-repeat bg-center border-slate-200"
                        style="background-image: url(https://source.unsplash.com/500x400?{{ $posts[0]->category->slug }})">
                    </div>
                @endif

                <div class="mt-4">
                    <h3 class="text-xl font-semibold mb-2">
                        <a href="/blogs/{{ $posts[0]->slug }}"
                            class="text-gray-700 dark:text-white no-underline hover:underline">{{ $posts[0]->name }}</a>
                    </h3>
                    <p class="text-gray-700 dark:text-white">
                        By.
                        <a href="/blogs?author={{ $posts[0]->author->username }}"
                            class="text-blue-500">{{ $posts[0]->author->name }}</a>
                        in
                        <a href="/blogs?category={{ $posts[0]->category->slug }}"
                            class="text-blue-500">{{ $posts[0]->category->name }}</a>
                        {{ $posts[0]->created_at->diffForHumans() }}
                    </p>
                    <p class="mt-2 text-left text-gray-700 dark:text-white">
                        {{ $posts[0]->excerpt }}
                    </p>
                    <a href="/blogs/{{ $posts[0]->slug }}"
                        class="w-32 ml-auto block mt-3 text-white bg-orange-500 px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:shadow-outline-orange active:bg-orange-800">
                        Read More..
                    </a>
                </div>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center border-collapse w-full">
                @foreach ($posts->skip(1) as $post)
                    <div class="w-[320px] m-3">
                        <div class="relative bg-white dark:bg-slate-800 shadow-md rounded-sm overflow-hidden">
                            <div
                                class="absolute left-0 top-0 px-3 py-2 bg-black text-white dark:text-black bg-opacity-70">
                                <a href="/blogs?category={{ $post->category->slug }}"
                                    class="dark:text-white no-underline">{{ $post->category->name }}</a>
                            </div>
                            @if ($post->image)
                                <div class="w-full h-[250px] mx-auto bg-cover bg-no-repeat bg-center border-slate-200"
                                    style="background-image: url({{ $post->image }})">
                                </div>
                            @else
                                <div class="w-full h-[250px] mx-auto bg-cover bg-no-repeat bg-center border-slate-200"
                                    style="background-image: url(https://source.unsplash.com/500x400?{{ $post->category->slug }})">
                                </div>
                            @endif
                            <div class="p-4">
                                <h5 class="text-lg dark:text-white font-semibold">{{ $post->name }}</h5>
                                <p class="mt-2">
                                    <small class="text-gray-600 dark:text-white">
                                        By.
                                        <a href="/blogs?author={{ $post->author->username }}"
                                            class="text-blue-500">{{ $post->author->name }}</a>
                                        {{ $posts[0]->updated_at->diffForHumans() }}
                                    </small>
                                </p>
                                <p class="mt-2 text-gray-700 dark:text-white text-sm">
                                    {{ $post->excerpt }}
                                </p>
                                <a href="/blogs/{{ $post->slug }}"
                                    class="mt-4 w-32 ml-auto block text-white bg-orange-500 px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:shadow-outline-orange active:bg-orange-800">
                                    Read More..
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="m-6">
            <div class="bg-white dark:bg-slate-800 max-w-full mx-auto shadow-md rounded-md p-6  text-center ">
                <p class="dark:text-white text-center">No Post Found.</p>
            </div>
        </div>
    @endif

    <div class="p-4">
        {{ $posts->links('vendor.pagination.tailwind') }}
    </div>


</x-app-layout>
