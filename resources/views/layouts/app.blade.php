<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <meta name="keywords" content="CodeWithOlgun, https://twitter.com/olgunsoftware, https://codewitholgun.com, https://www.youtube.com/channel/UCH-xplaz-cmloIUkYspcEhQ">
    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ config('app.name') }}">
    <meta name="description" content="">

    <!-- Twitter -->
    <meta property="twitter:url" content="https://twitter.com/codewitholgun">
    <meta property="twitter:title" content="CodeWithOlgun Youtube: https://www.youtube.com/channel/UCH-xplaz-cmloIUkYspcEhQ">
    <meta property="twitter:description" content="CodeWithOlgun Youtube: https://www.youtube.com/channel/UCH-xplaz-cmloIUkYspcEhQ">
    <meta name="baseUrl" content="{{ asset('/') }}"/>

    <!-- CSS -->
    @production
        @php
            $manifest = json_decode(file_get_contents(asset('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ asset("build/{$manifest['resources/js/app.js']['file']}") }}"></script>
        <link rel="stylesheet" href="{{ asset("build/{$manifest['resources/css/app.css']['file']}") }}">
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endproduction
    @stack('css')
</head>
<body class="bg-white">

<div class="relative min-h-screen md:flex">
    @include('layouts.partials.sidebar')
    <div class="flex-1">
        @include('layouts.partials.navigation')
        <div class="container mx-auto p-6">
            @yield('content')
        </div>
    </div>
</div>

@yield('footer')
<script>
    const btn = document.querySelector(".mobile-menu-button");
    const sidebar = document.querySelector(".sidebar-menu");
    const sidebarLogo = document.querySelector("#sidebar-logo");

    // add our event listener for the click
    btn.addEventListener("click", () => {
        toggleSideBar(true);
    });

    function toggleSideBar(isMobile = false) {
        if (isMobile) {
            sidebar.classList.toggle("-translate-x-full");
        }

        sidebar.classList.toggle("md:relative");
        sidebar.classList.toggle("md:translate-x-0");
    }
</script>
@stack('js')
</body>
</html>
