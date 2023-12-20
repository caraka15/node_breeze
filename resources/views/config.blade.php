<x-app-layout>
    @section('title', $title)

    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4 sm:p-8">
                <div class="dark:text-white overflow-x-auto">
                    <table class="min-w-full border-collapse border border-slate-500 text-center">
                        <thead>
                            <tr>
                                <th class="border border-slate-600">Config</th>
                                <th class="border border-slate-600">Tanggal Upload</th>
                                <th class="border border-slate-600">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($configs as $config)
                                <tr>
                                    <td class="border border-slate-700 relative py-2">
                                        <div class="text-sm">
                                            {{ $config->config }}
                                            @if (now()->diffInDays($config->updated_at) < 5)
                                                <span
                                                    class="absolute left-0 top-0 text-xs px-0.5 py-0.5 text-white bg-red-500 border rounded-full">New</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-slate-700 py-2">
                                        <div class="text-sm">
                                            {{ $config->updated_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="border border-slate-700 py-2">
                                        <div class="flex justify-center">
                                            <a href="{{ asset('storage/uploads/' . $config->config) }}"
                                                class="bg-orange-600 w-10 h-10 flex items-center justify-center rounded-full hover:bg-orange-500"
                                                title="Download">
                                                <i data-feather="download" class="text-white"></i>
                                            </a>
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
