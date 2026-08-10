<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'Garden Tree') . ' · Professional Landscaping')</title>

        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌿</text></svg>">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html { scroll-behavior: smooth; }
            body { -webkit-font-smoothing: antialiased; }
            #navbar.nav-scrolled { background-color: rgba(15, 33, 9, 0.95); backdrop-filter: blur(8px); }
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(28, 58, 20, 0.2); border-radius: 3px; }
        </style>
    </head>
    <body class="bg-cream text-forest font-inter antialiased">
        <div class="bg-cream">
            @include('components.landing-navbar')
            @yield('content')
            @include('components.landing-footer')
        </div>

        @yield('extra-scripts')
    </body>
</html>
