<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('posts.create') }}" class="bg-orange-600 px-5 py-2 rounded-md hover:bg-orange-500">New
                post</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex w-full p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="m-auto dark:text-white">
                    <table class="border-collapse border border-slate-500 w-6xl text-center">
                        <thead class="w-full">
                            <tr>
                                <th class="border border-slate-600 w-10">NO</th>
                                <th class="border border-slate-600 w-[900px]">Title</th>
                                <th class="border border-slate-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="border border-slate-700">{{ $loop->iteration }}</td>
                                    <td class="border border-slate-700">{{ $post->name }}</td>
                                    <td class="border border-slate-700 justify-center p-1">
                                        <div class="mx-auto justify-center flex">
                                            <a href="/dashboard/posts/{{ $post->slug }}"
                                                class="relative inline-block bg-orange-600 w-12 h-8 px-3 py-1 me-1 rounded-md group">
                                                <i data-feather="eye"></i>
                                                <span
                                                    class="z-50 opacity-0 group-hover:opacity-100 transition duration-300 absolute left-7 top-8 bg-slate-100 text-black text-xs px-0.5 py-0.5 border border-black">View</span>
                                            </a>
                                            <a href="/dashboard/posts/{{ $post->slug }}/edit"
                                                class="relative inline-block bg-orange-600 w-12 h-8 px-3 py-1 me-1 rounded-md group">
                                                <i data-feather="edit"></i>
                                                <span
                                                    class="z-50 opacity-0 group-hover:opacity-100 transition duration-300 absolute left-7 top-8 bg-slate-100 text-black text-xs px-0.5 py-0.5 border border-black">Edit</span>
                                            </a>
                                            <form action="/dashboard/posts/{{ $post->slug }}" method="post"
                                                class="d-inline relative inline-block">
                                                @method('delete')
                                                @csrf
                                                <button class="relative bg-red-600 w-12 h-8 px-3 py-1 rounded-md group">
                                                    <i data-feather="x-circle"></i>
                                                    <span
                                                        class="z-50 opacity-0 group-hover:opacity-100 transition duration-300 absolute left-7 top-8 bg-slate-100 text-black text-xs px-0.5 py-0.5 border border-black">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
