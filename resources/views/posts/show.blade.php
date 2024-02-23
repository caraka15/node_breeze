<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-full">
                    <h2 class="mb-7 text-center text-2xl dark:text-white">{{ $post->name }}</h2>

                    <div class="prose max-w-full p-5 dark:prose-invert">
                        {!! $post->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
