<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="dark:text-white mb-7 text-2xl text-center">{{ $post->name }}</h2>

                    <div class="prose dark:prose-dark dark:text-white">
                        {!! $post->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
