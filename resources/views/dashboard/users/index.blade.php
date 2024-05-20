<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <a href="{{ route('users.create') }}" class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">New
                user</a>
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
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                    <th scope="row"
                                        class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="w-[800px] whitespace-normal px-12 py-4">{{ $user->name }}</td>
                                    <td class="px-6 py-4">
                                        {{ $user->username }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        delete
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
