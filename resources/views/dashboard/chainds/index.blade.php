<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <a href="{{ route('chainds.create') }}" class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">New
                Chaind</a>
        </h2>
    </x-slot>

    @if (session()->has('success'))
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
            <div class="flex w-[480px] bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="m-auto dark:text-white">
                    <table class="w-96 border-collapse border border-slate-500 text-center">
                        <thead class="w-28">
                            <tr>
                                <th class="border border-slate-600">Logo</th>
                                <th class="border border-slate-600">Name</th>
                                <th class="border border-slate-600">Type</th>
                                <th class="border border-slate-600">RPC</th>
                                <th class="border border-slate-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chainds as $chaind)
                                <tr>
                                    <td class="h-12 w-12 border border-slate-700"><img
                                            src="{{ 'https://raw.githubusercontent.com/caraka15/node_network/main/logo-chaind/' . $chaind->slug . '.png' }}"
                                            alt="" class="h-12 w-12 rounded-full">
                                    </td>
                                    <td class="border border-slate-700">{{ $chaind->name }}</td>
                                    <td class="border border-slate-700">{{ $chaind->type }}</td>
                                    <td class="border border-slate-700"><a
                                            class="text-blue-500 hover:text-blue-500 dark:text-blue-500 dark:hover:text-blue-600"
                                            href="{{ $chaind->rpc_link }}" target="_blank">{{ $chaind->slug }}</a></td>
                                    <td class="justify-center border border-slate-700 p-1">
                                        <div class="mx-auto flex justify-center">
                                            <a href="/dashboard/chainds/{{ $chaind->slug }}/edit"
                                                class="me-1 h-8 w-12 rounded-md bg-orange-600 px-3 py-1 hover:bg-orange-500"><i
                                                    data-feather="edit"></i></a>
                                            <form action="/dashboard/chainds/{{ $chaind->slug }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button
                                                    class="h-8 w-12 rounded-md bg-red-600 px-3 py-1 hover:bg-red-500"
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
