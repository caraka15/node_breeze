<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight items-center">
            <div class="flex items-center justify-center">
                <input type="text"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-l-md w-96"
                    placeholder="Search" />
                <button
                    class="inline-flex items-center p-3 bg-gray-800 dark:bg-orange-500 border border-transparent rounded-r-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-orange-600 focus:bg-gray-700 dark:focus:bg-orange-600 active:bg-gray-900 dark:active:bg-orange-600  transition ease-in-out duration-150">
                    {{ __('Search') }}
                </button>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Post All') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
