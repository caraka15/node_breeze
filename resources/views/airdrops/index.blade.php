<x-app-layout>
    @section('title', $title)
    @auth
        <x-slot name="header">
            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }">
                    <!-- Tombol untuk menampilkan modal -->
                    <button @click="showModal = true" class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">
                        New Airdrop
                    </button>
                    <!-- Modal -->
                    <div x-show="showModal" class="fixed inset-9 z-50 overflow-hidden bg-transparent">
                        <div class="items-center justify-center">
                            <div
                                class="mx-auto max-w-5xl rounded-lg border border-gray-700 bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                                <div class="mt-4 flex justify-end">
                                    <button @click="showModal = false" class="relative text-gray-500 hover:text-gray-700">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="max-w-full overflow-auto">
                                    @include('airdrops.create')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ showTutorial: false }">
                    <button @click="showTutorial = true" class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">
                        Tutorial
                    </button>
                    <div x-show="showTutorial" class="fixed inset-16 z-50 overflow-visible bg-transparent">
                        <div class="items-center justify-center">
                            <div
                                class="mx-auto max-w-5xl rounded-lg border border-gray-700 bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                                <div class="mt-4 flex justify-end">
                                    <button @click="showTutorial = false"
                                        class="relative text-gray-500 hover:text-gray-700">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="max-w-full overflow-y-scroll">
                                    @include('airdrops.tutorial')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto space-y-6 sm:px-6 lg:px-8">
                <div class="flex max-w-full overflow-auto bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                    <div class="relative w-full">
                        <div class="mb-4 flex flex-col justify-between sm:flex-row">
                            <div class="mb-2 text-gray-900 dark:text-gray-100 sm:mb-0">
                                <a href="{{ route('airdrops.export.to.excel') }}"
                                    class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">
                                    Export to xls
                                </a>
                            </div>
                            <form action="/airdrop" class="sm:ml-2">
                                <div class="flex flex-col sm:flex-row">
                                    <input type="text"
                                        class="mb-2 max-w-full rounded-l-md border-gray-300 shadow-none focus:border-orange-500 focus:ring-orange-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-orange-600 dark:focus:ring-orange-600 sm:mb-0 sm:w-80"
                                        placeholder="Search.." name="search" value="{{ request('search') }}">
                                    <button
                                        class="w-full rounded-md border border-transparent bg-gray-800 p-3 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-orange-500 dark:hover:bg-orange-600 dark:focus:bg-orange-600 dark:active:bg-orange-600 sm:w-auto"
                                        type="submit">Search</button>
                                </div>
                            </form>
                        </div>

                        @if ($airdrops->count())
                            <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                                <thead
                                    class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">No</th>
                                        <th scope="col" class="max-w-[600px] px-4 py-3">Title</th>
                                        <th scope="col" class="px-6 py-3">Link</th>
                                        <th scope="col" class="px-6 py-3">Frekuensi</th>
                                        <th scope="col" class="px-6 py-3">Action</th>
                                        <th scope="col" class="px-6 py-3">Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($airdrops as $index => $airdrop)
                                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                            <th scope="row"
                                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                {{ ($airdrops->currentPage() - 1) * $airdrops->perPage() + $index + 1 }}
                                            </th>
                                            <td class="max-w-[600px] whitespace-normal px-4 py-4">
                                                {{ $airdrop->nama }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <form action="/airdrop/status/{{ $airdrop->id }}" method="post"
                                                    id="updateForm{{ $index }}">
                                                    @csrf
                                                    @method('put')
                                                    @if ($airdrop->sudah_dikerjakan)
                                                        <button type="submit"
                                                            class="w-24 rounded-md bg-orange-500/50 px-4 py-2 text-white/50"
                                                            disabled>
                                                            Done
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="w-24 rounded-md bg-orange-500 px-4 py-2 text-white hover:scale-105 hover:bg-orange-600">
                                                            Do it
                                                        </button>
                                                    @endif
                                                </form>
                                                <script>
                                                    document.getElementById('updateForm{{ $index }}').addEventListener('submit', function() {
                                                        window.open("{{ $airdrop->link }}", "_blank");
                                                    });
                                                </script>
                                            </td>
                                            <td class="px-6 py-4">{{ $airdrop->frekuensi }}</td>
                                            <td class="px-6 py-4">
                                                <div x-data="{ showEdit: false }">
                                                    <button @click="showEdit = true">
                                                        <i data-feather="edit"></i>
                                                    </button>
                                                    <div x-show="showEdit"
                                                        class="fixed inset-16 z-50 overflow-auto bg-transparent">
                                                        <div class="items-center justify-center">
                                                            <div
                                                                class="mx-auto max-w-5xl rounded-lg border border-gray-700 bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                                                                <div class="mt-4 flex justify-end">
                                                                    <button @click="showEdit = false"
                                                                        class="relative text-gray-500 hover:text-gray-700">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="max-w-full overflow-auto">
                                                                    @include('airdrops.edit')
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <form action="/airdrop/selesai/{{ $airdrop->id }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    @if ($airdrop->selesai)
                                                        <button type="submit"
                                                            class="w-24 rounded-md bg-blue-500 px-4 py-2 text-white hover:scale-105 hover:bg-red-600" disabled>
                                                            Selesai
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="w-24 rounded-md bg-green-500 px-4 py-2 text-white hover:scale-105 hover:bg-green-600">
                                                            Selesaikan
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                {{ $airdrops->links('vendor.pagination.tailwind') }}
                            </div>
                        @else
                            <div class="m-6">
                                <div
                                    class="mx-auto max-w-full rounded-md bg-white p-6 text-center shadow-md dark:bg-slate-800">
                                    <p class="text-center dark:text-white">No Airdrop Found.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-center text-2xl dark:text-white">
                            You are not logged in. Please log in to access this page.
                        </p>
                        <div class="mt-4 flex justify-center">
                            <a href="{{ route('login') }}"
                                class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">
                                Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endauth



</x-app-layout>
