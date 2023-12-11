<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('config.create') }}" class="bg-orange-600 px-5 py-2 rounded-md hover:bg-orange-500">New
                Chaind</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex w-[480px] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="m-auto dark:text-white">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
