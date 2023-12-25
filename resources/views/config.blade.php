<x-app-layout>
    @section('title', $title)

    @if (session()->has('success'))
        <!-- Alert Container -->
        <div id="alert"
            class="relative right-0 top-0 m-4 flex justify-between rounded bg-green-500 p-4 text-white shadow-lg">
            <p>{{ session('success') }}</p>
            <button type="button" id="closeBtn" class="close transition" data-dismiss="alert">
                <i class="text-white" data-feather="x"></i>
            </button>
        </div>
    @endif

    <div class="py-6">
        <div class="mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="overflow-x-auto dark:text-white">
                    <table class="min-w-full border-collapse border border-slate-500 text-center">
                        <thead>
                            <tr>
                                <th class="border border-slate-600">Config</th>
                                <th class="border border-slate-600">Type</th>
                                <th class="border border-slate-600">Tanggal Upload</th>
                                <th class="border border-slate-600">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($configs as $config)
                                <tr>
                                    <td class="relative border border-slate-700 py-2">
                                        <div class="text-sm">
                                            {{ $config->name }}
                                            @if (now()->diffInDays($config->updated_at) < 5)
                                                <span
                                                    class="absolute left-0 top-0 rounded-full border bg-red-500 px-0.5 py-0.5 text-xs text-white">New</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-slate-700 py-2">
                                        <div class="text-sm">
                                            {{ $config->type }}
                                        </div>
                                    </td>
                                    <td class="border border-slate-700 py-2">
                                        <div class="text-sm">
                                            {{ $config->updated_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="border border-slate-700 py-2">
                                        <div class="flex justify-center">
                                            @if ($config->type === 'vmess')
                                                <button
                                                    class="me-1 h-8 w-12 rounded-md bg-blue-600 px-3 py-1 hover:bg-blue-500"
                                                    onclick="copyToClipboard('{{ $config->config }}')">
                                                    <i data-feather="copy"></i>
                                                </button>
                                            @else
                                                <a href="{{ asset('storage/uploads/' . $config->config) }}"
                                                    class="me-1 h-8 w-12 rounded-md bg-orange-600 px-3 py-1 hover:bg-orange-500"><i
                                                        data-feather="download"></i></a>
                                            @endif
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
    <script>
        function copyToClipboard(text) {
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Show popup
            showAlert('Config copied to clipboard!');
        }

        function showAlert(message) {
            // Create alert div with Tailwind CSS classes
            var alertDiv = document.createElement("div");
            alertDiv.className = "fixed top-16 right-0 p-4 bg-green-500 text-white";
            alertDiv.textContent = message;

            // Append alert div to body
            document.body.appendChild(alertDiv);

            // Hide the alert after 3 seconds
            setTimeout(function() {
                // Use opacity to animate the hide effect
                alertDiv.style.opacity = 0;
                // Remove the alert div from the DOM after the animation
                setTimeout(function() {
                    document.body.removeChild(alertDiv);
                }, 500);
            }, 3000);
        }
    </script>
</x-app-layout>
