<!-- resources/views/exorde-stats.blade.php -->

<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                {{-- Menampilkan Livewire Component --}}
                @livewire('exorde-stats')
            </div>
        </div>
    </div>

</x-app-layout>
