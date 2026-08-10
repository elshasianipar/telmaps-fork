<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'TELF') . ' · Admin')</title>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌳</text></svg>">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-cream text-forest font-inter antialiased min-h-screen">
        <div class="flex min-h-screen">
            {{-- Sidebar --}}
            <aside class="hidden md:flex w-60 shrink-0 flex-col bg-forest-dark text-cream">
                <div class="px-5 py-5 border-b border-cream/10">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-lime flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 18 18" fill="none">
                                <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#0F2109" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="leading-tight">
                            <div class="font-fraunces text-base font-medium">TELF</div>
                            <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-cream/50 -mt-0.5">Panel Admin</div>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                    <span class="px-3 font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/40">Konten</span>
                    @include('partials.admin-nav-item', ['route' => 'admin.about', 'label' => 'Tentang', 'icon' => 'info'])
                    @include('partials.admin-nav-item', ['route' => 'admin.teams', 'label' => 'Tim', 'icon' => 'users'])
                    @include('partials.admin-nav-item', ['route' => 'admin.faq', 'label' => 'FAQ', 'icon' => 'question'])
                </nav>

                <div class="px-3 py-4 border-t border-cream/10 text-sm">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-cream/70 hover:text-lime hover:bg-cream/5 transition-colors">
                        <span class="w-4 text-center">↗</span> Lihat Situs
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-cream/70 hover:text-loss hover:bg-cream/5 transition-colors">
                            <span class="w-4 text-center">⎋</span> Keluar
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Main --}}
            <div class="flex-1 flex flex-col min-w-0">
                <header class="flex items-center justify-between gap-4 px-5 md:px-8 py-4 border-b border-forest/15 bg-cream">
                    <div class="md:hidden flex items-center gap-2">
                        <span class="font-fraunces text-base font-medium text-forest">TELF</span>
                        <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/60">Admin</span>
                    </div>
                    <h1 class="hidden md:block font-fraunces text-xl text-forest">{{ $header ?? 'Panel Admin' }}</h1>
                    <div class="flex items-center gap-3 text-sm">
                        @admin
                            <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/60">{{ auth()->user()->name }}</span>
                            <span class="w-7 h-7 rounded-full bg-forest text-cream flex items-center justify-center text-xs font-medium">{{ auth()->user()->initials() }}</span>
                        @endadmin
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>