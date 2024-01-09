<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2
            class="flex flex-col items-center text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 sm:flex-row sm:justify-between">
            <div class="mb-2 text-gray-900 dark:text-gray-100 sm:mb-0">
                {{ $title }}
            </div>
            <form action="/blogs">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="flex items-center justify-center">
                    <input type="text"
                        class="max-w-full rounded-l-md border-gray-300 shadow-none focus:border-orange-500 focus:ring-orange-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-orange-600 dark:focus:ring-orange-600 sm:w-80"
                        placeholder="Search.." name="search" value="{{ request('search') }}">
                    <button
                        class="inline-flex items-center rounded-r-md border border-transparent bg-gray-800 p-3 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-orange-500 dark:hover:bg-orange-600 dark:focus:bg-orange-600 dark:active:bg-orange-600"
                        type="submit">Search</button>
                </div>
            </form>
        </h2>


    </x-slot>

    @if ($posts->count())
        <div class="m-6 flex">
            <div class="mx-auto w-full rounded-md bg-white p-6 text-center shadow-md dark:bg-slate-800">
                @if ($posts[0]->image)
                    <div class="mx-auto h-[350px] w-full border-slate-200 bg-cover bg-center bg-no-repeat"
                        style="background-image: url({{ $posts[0]->image }})">
                    </div>
                @else
                    <div class="mx-auto h-[250px] w-full border-slate-200 bg-cover bg-center bg-no-repeat"
                        style="background-image: url(https://source.unsplash.com/500x400?{{ $posts[0]->category->slug }})">
                    </div>
                @endif

                <div class="mt-4">
                    <h3 class="mb-2 text-xl font-semibold">
                        <a href="/blogs/{{ $posts[0]->slug }}"
                            class="text-gray-700 no-underline hover:underline dark:text-white">{{ $posts[0]->name }}</a>
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
                        class="focus:shadow-outline-orange ml-auto mt-3 block w-32 rounded-md bg-orange-500 px-4 py-2 text-white hover:bg-orange-600 focus:outline-none active:bg-orange-800">
                        Read More..
                    </a>
                </div>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="flex w-full border-collapse flex-wrap justify-center">
                @foreach ($posts->skip(1) as $post)
                    <div class="m-3 w-[320px]">
                        <div class="relative overflow-hidden rounded-sm bg-white shadow-md dark:bg-slate-800">
                            <div
                                class="absolute left-0 top-0 bg-black bg-opacity-70 px-3 py-2 text-white dark:text-black">
                                <a href="/blogs?category={{ $post->category->slug }}"
                                    class="no-underline dark:text-white">{{ $post->category->name }}</a>
                            </div>
                            @if ($post->image)
                                <div class="mx-auto h-[250px] w-full border-slate-200 bg-cover bg-center bg-no-repeat"
                                    style="background-image: url({{ $post->image }})">
                                </div>
                            @else
                                <div class="mx-auto h-[250px] w-full border-slate-200 bg-cover bg-center bg-no-repeat"
                                    style="background-image: url(https://source.unsplash.com/500x400?{{ $post->category->slug }})">
                                </div>
                            @endif
                            <div class="p-4">
                                <h5 class="text-lg font-semibold dark:text-white">{{ $post->name }}</h5>
                                <p class="mt-2">
                                    <small class="text-gray-600 dark:text-white">
                                        By.
                                        <a href="/blogs?author={{ $post->author->username }}"
                                            class="text-blue-500">{{ $post->author->name }}</a>
                                        {{ $posts[0]->updated_at->diffForHumans() }}
                                    </small>
                                </p>
                                <p class="mt-2 text-sm text-gray-700 dark:text-white">
                                    {{ $post->excerpt }}
                                </p>
                                <a href="/blogs/{{ $post->slug }}"
                                    class="focus:shadow-outline-orange ml-auto mt-4 block w-32 rounded-md bg-orange-500 px-4 py-2 text-white hover:bg-orange-600 focus:outline-none active:bg-orange-800">
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
            <div class="mx-auto max-w-full rounded-md bg-white p-6 text-center shadow-md dark:bg-slate-800">
                <p class="text-center dark:text-white">No Post Found.</p>
            </div>
        </div>
    @endif

    <div class="p-4">
        {{ $posts->links('vendor.pagination.tailwind') }}
    </div>


</x-app-layout>
