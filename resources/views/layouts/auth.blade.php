<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'TELF'))</title>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔥</text></svg>">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-forest-dark text-cream font-inter antialiased min-h-screen flex flex-col">
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-8">
                <div class="w-9 h-9 rounded-full bg-lime flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#20140D" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="font-fraunces text-lg font-medium text-cream">TELF</div>
                    <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-cream/50 -mt-0.5">Pemantauan Hutan & Kebakaran</div>
                </div>
            </a>

            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>