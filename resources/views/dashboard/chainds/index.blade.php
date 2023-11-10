<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('chainds.create') }}" class="bg-orange-600 px-5 py-2 rounded-md hover:bg-orange-500">New
                Chaind</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex w-[480px] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="m-auto dark:text-white">
                    <table class="border-collapse border border-slate-500 w-96 text-center">
                        <thead class="w-28">
                            <tr>
                                <th class="border border-slate-600 ">Logo</th>
                                <th class="border border-slate-600">Name</th>
                                <th class="border border-slate-600">Type</th>
                                <th class="border border-slate-600">RPC</th>
                                <th class="border border-slate-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chainds as $chaind)
                                <tr>
                                    <td class="border border-slate-700 w-12 h-12"><img
                                            src="https://crxa.my.id/storage/logo-chaind/2dN8UK49kdvkbHmePJwjDdOB1Sz2xFcDQ141R9jS.png"
                                            alt="" class="rounded-full w-12 h-12">
                                    </td>
                                    <td class="border border-slate-700">{{ $chaind->name }}</td>
                                    <td class="border border-slate-700">{{ $chaind->type }}</td>
                                    <td class="border border-slate-700"><a class="text-blue-500 hover:text-blue-600"
                                            href="{{ $chaind->rpc_link }}" target="_blank">{{ $chaind->slug }}</a></td>
                                    <td class="border border-slate-700 justify-center p-1">
                                        <div class="mx-auto justify-center flex">
                                            <a href="/dashboard/chainds/{{ $chaind->slug }}/edit"
                                                class="bg-orange-600 w-12 h-8 px-3 py-1 me-1 rounded-md hover:bg-orange-500"><i
                                                    data-feather="edit"></i></a>
                                            <form action="/dashboard/chainds/{{ $chaind->slug }}" method="post"
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
