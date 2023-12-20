<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('config.create') }}" class="bg-orange-600 px-5 py-2 rounded-md hover:bg-orange-500">New
                Config</a>
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
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex w-[480px] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="m-auto dark:text-white">
                    <table class="border-collapse border border-slate-500 w-96 text-center">
                        <thead class="w-28">
                            <tr>
                                <th class="border border-slate-600">Name</th>
                                <th class="border border-slate-600">Tanggal Upload</th>
                                <th class="border border-slate-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($configs as $config)
                                <tr>
                                    <td class="border border-slate-700">{{ $config->config }}</td>
                                    <td class="border border-slate-700">
                                        {{ $config->updated_at->diffForHumans() }}</td>
                                    <td class="border border-slate-700 justify-center p-1">
                                        <div class="mx-auto justify-center flex">
                                            <a href="{{ asset('storage/uploads/' . $config->config) }}"
                                                class="bg-orange-600 w-12 h-8 px-3 py-1 me-1 rounded-md hover:bg-orange-500"><i
                                                    data-feather="download"></i></a>
                                            <form action="/dashboard/config/{{ $config->id }}" method="post"
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
