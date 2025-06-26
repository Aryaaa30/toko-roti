<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans antialiased bg-black text-gray-800">
<div class="min-h-screen bg-black flex flex-col" style="color: rgb(245, 245, 245);">
        {{-- Navigasi utama --}}
        @include('layouts.navigation')

        {{-- Page Heading (hanya muncul di dashboard) --}}
        @hasSection('header')
            @if (request()->routeIs('dashboard'))
                <header class="bg-black shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif
        @endif

        {{-- Page Content --}}
        <main class="flex-grow">
            @yield('content')
        </main>
        
        {{-- Footer --}}
        @include('layouts.footer')
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1jRVv6Gk6GkG6lLrj5lZQ+1Q9Q4p1gXkG4QmQf3s=" crossorigin=""></script>
</body>
</html>
