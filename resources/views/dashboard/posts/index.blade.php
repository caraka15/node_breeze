<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <a href="{{ route('posts.create') }}" class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">New
                post</a>
        </h2>
    </x-slot>

    @if (session()->has('success'))
        <!-- Alert Container -->
        <div id="alert"
            class="relative right-0 top-0 m-4 flex justify-between rounded bg-green-500 p-4 text-white shadow-lg">
            <p>{{ session('success') }}</p>
            <button type="button" id="closeBtn" class="close transition" data-dismiss="alert">
                <i class="text-white" data-feather="x"></i>
            </button>
        </div>
    @endif

    <div class="py-12">
        <div class="mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="flex w-full bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="relative max-w-full">
                    <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="w-[800px] px-12 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                    <th scope="row"
                                        class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="w-[800px] whitespace-normal px-12 py-4">
                                        <a class="status-element hover:underline hover:underline-offset-1"
                                            href="/dashboard/posts/{{ $post->slug }}" data-slug="{{ $post->slug }}"
                                            data-current-value="{{ $post->public }}">
                                            {{ $post->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-element" data-slug="{{ $post->slug }}"
                                            data-current-value="{{ $post->public }}">
                                            {{ $post->public ? 'Public' : 'Private' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="mx-auto flex justify-start text-white">
                                            <a href="/dashboard/posts/{{ $post->slug }}/edit"
                                                class="group relative me-1 inline-block h-8 w-12 rounded-md bg-orange-600 px-3 py-1">
                                                <i data-feather="edit"></i>
                                                <span
                                                    class="absolute left-7 top-8 z-50 border border-black bg-slate-100 px-0.5 py-0.5 text-xs text-black opacity-0 transition duration-300 group-hover:opacity-100">Edit</span>
                                            </a>
                                            <form action="/dashboard/posts/{{ $post->slug }}" method="post"
                                                class="d-inline relative inline-block">
                                                @method('delete')
                                                @csrf
                                                <button class="group relative h-8 w-12 rounded-md bg-red-600 px-3 py-1">
                                                    <i data-feather="x-circle"></i>
                                                    <span
                                                        class="absolute left-7 top-8 z-50 border border-black bg-slate-100 px-0.5 py-0.5 text-xs text-black opacity-0 transition duration-300 group-hover:opacity-100">Delete</span>
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
