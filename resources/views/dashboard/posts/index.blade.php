<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('posts.create') }}" class="bg-orange-600 px-5 py-2 rounded-md hover:bg-orange-500">New
                post</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex w-[480px] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="m-auto dark:text-white">
                    <table class="border-collapse border border-slate-500 w-96 text-center">
                        <thead class="w-28">
                            <tr>
                                <th class="border border-slate-600 ">ID</th>
                                <th class="border border-slate-600">Name</th>
                                <th class="border border-slate-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="border border-slate-700">{{ $post->id }}</td>
                                    <td class="border border-slate-700">{{ $post->name }}</td>
                                    <td class="border border-slate-700 justify-center p-1">
                                        <div class="mx-auto justify-center flex">
                                            <a href="/dashboard/posts/{{ $post->slug }}"
                                                class="bg-orange-600 w-12 h-8 px-3 py-1 me-1 rounded-md hover:bg-orange-500"><i
                                                    data-feather="eye"></i></a>
                                            <a href="/dashboard/posts/{{ $post->slug }}/edit"
                                                class="bg-orange-600 w-12 h-8 px-3 py-1 me-1 rounded-md hover:bg-orange-500"><i
                                                    data-feather="edit"></i></a>
                                            <form action="/dashboard/posts/{{ $post->slug }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button
                                                    class="bg-red-600 w-12 h-8 px-3 py-1 rounded-md hover:bg-red-500"
                                                    onclick="return confirm('are you sure?')"><i
                                                        data-feather="x-circle"></i></button>
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
