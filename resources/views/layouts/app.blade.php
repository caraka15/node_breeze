<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <meta name="robots" content="index, follow">

    <title>Crxa Nodes Services | @yield('title')
    </title>

    <meta name="description"
        content="CRXA NODES is a premier individual enterprise dedicated to providing exceptional node and
                            validator services across various networks, with a primary focus on the thriving Cosmos
                            ecosystem. With an unwavering commitment to excellence, we have established ourselves as a
                            trusted partner for network participants, offering reliable infrastructure and comprehensive
                            support to ensure optimal performance, security, and growth">
    <!-- Fonts -->
    <link rel="canonical" href="https://crxanode.com/" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.css" />

    <link rel="stylesheet" href="{{ asset('css/markdown.css') }}">
    <style>
        /* Card styles */
        .card {
            width: 170px;
            height: 254px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 20px;
            background-color: transparent;
        }

        .card h2 {
            z-index: 1;
            color: #eeeeee;
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .type-header h2 {
            color: #eee;
            border-bottom: 3px #eee solid;
            padding-bottom: 10px;
        }

        .card::before {
            content: "";
            position: absolute;
            width: 120px;
            background-image: linear-gradient(180deg,
                    rgb(0, 183, 255),
                    rgb(255, 48, 255));
            height: 150%;
            animation: rotBGimg 2s linear infinite;
            transition: all 0.2s linear;
            filter: blur(20px);
            border-radius: 20px;
        }

        .card::after {
            content: "";
            position: absolute;
            background: #222831;
            inset: 3px;
            border-radius: 20px;
        }

        .card-content {
            position: relative;
            z-index: 1;
            text-align: center;
            transition: transform 0.3s;
            text-transform: uppercase;
        }

        .card-content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg,
                    rgba(0, 0, 0, 0.6) 0%,
                    rgba(0, 0, 0, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .note-editable {
            background-color: white !important;
            color: black !important;
            min-height: 240px;
        }

        .note-editable ul {
            list-style: disc !important;
            list-style-position: inside !important;
        }

        .note-editable ol {
            list-style: decimal !important;
            list-style-position: inside !important;
        }



        @keyframes rotBGimg {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Green dot styles */
        .dot-active {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #28c76f;
            position: absolute;
            top: 5px;
            right: 25px;
            animation: blinking-active 1s infinite;
        }

        /* Red dot styles */
        .dot-inactive {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: red;
            position: absolute;
            top: 5px;
            right: 25px;
            animation: blinking-inactive 1s infinite;
        }

        @keyframes blinking-active {
            0% {
                box-shadow: 0 0 5px 0px rgba(0, 255, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 20px 5px rgba(0, 255, 0, 0.7);
            }

            100% {
                box-shadow: 0 0 5px 0px rgba(0, 255, 0, 0.7);
            }
        }

        @keyframes blinking-inactive {
            0% {
                box-shadow: 0 0 5px 0px red;
            }

            50% {
                box-shadow: 0 0 20px 5px red;
            }

            100% {
                box-shadow: 0 0 5px 0px red;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        feather.replace();
    </script>
</body>

</html>
