<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('posts.create') }}" class="bg-orange-600 px-5 py-2 rounded-md hover:bg-orange-500">New
                post</a>
        </h2>
    </x-slot>

    @if (session()->has('success'))
        <!-- Alert Container -->
        <div id="alert"
            class="relative flex justify-between top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg">
            <p>{{ session('success') }}</p>
            <button type="button" id="closeBtn" class="close transition" data-dismiss="alert">
                <i class="text-white" data-feather="x"></i>
            </button>
        </div>
    @endif

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex w-full p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="relative max-w-full">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-12 py-3 w-[800px]">
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
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-12 py-4 whitespace-normal w-[800px]">
                                        <a class="hover:underline hover:underline-offset-1 status-element"
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
                                        <div class="text-white mx-auto justify-start flex">
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
    <script>
        // Function to close the alert
        function closeAlert() {
            const alertElement = document.getElementById('alert');
            alertElement.classList.add('hidden');
        }

        // Attach event listener to the close button
        document.getElementById('closeBtn').addEventListener('click', closeAlert);
    </script>
</x-app-layout>
