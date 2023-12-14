<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title') - Crxa Nodes Services
    </title>

    {{-- meta tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content=" @yield('description') ">
    <meta name="robots" content="index, follow">


    {{-- tags og --}}
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content=" @yield('description')">
    <meta property="og:image" content="{{ asset('img/' . basename(request()->path()) . '.PNG') }}">
    <meta property="og:url" content="{{ request()->url() }}">


    {{-- link --}}
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @if (request()->route()->getName() == 'home')
        <link rel="canonical" href="{{ url()->current() }}">
    @endif

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L33K6VP4EV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-L33K6VP4EV');
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    <script>
        feather.replace();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            const togglePassword = document.getElementById('togglePassword');

            togglePassword.addEventListener('change', function() {
                const passwordType = togglePassword.checked ? 'text' : 'password';
                passwordInput.type = passwordType;
                eyeOpen.classList.toggle('hidden');
                eyeClosed.classList.toggle('hidden');
            });
        });
    </script>
    <script>
        // Mendapatkan path URL tanpa karakter slash terakhir
        var pathWithoutSlash = window.location.pathname.replace(/\/$/, "");

        // Mendapatkan nama file dari path URL
        var fileName = pathWithoutSlash.substring(pathWithoutSlash.lastIndexOf("/") + 1);

        // Mengubah nama file menjadi huruf besar dan menambahkan ekstensi PNG
        var thumbnailFileName = fileName.toUpperCase() + ".PNG";
        var thumbnailPath = "{{ asset('img/') }}" + '/' + thumbnailFileName;

        // Mengatur nilai og:image dengan URL gambar thumbnail
        document.getElementById("ogImage").content = thumbnailPath;
    </script>
</body>

</html>
