{{--  With Top Menu Public Pages --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />


    <title>{{ config('app.name', 'Just My Health') }}</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GS5QSJH6M9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-GS5QSJH6M9');
    </script>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Local CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/swiper.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/css/tailwind.output.css') }}" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/bg-6.png') }}" />

    <!-- Laravel Vite  Alpine CSS/JS-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-900">
    @include('layouts.public-navbar')
    {{ $slot }}
    @include('layouts.footer')
</body>

</html>
