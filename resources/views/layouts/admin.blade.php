<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'TELF') . ' · Pos Dinas')</title>

        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌳</text></svg>">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            html, body { height: 100%; }
            body { -webkit-font-smoothing: antialiased; }
            .pos-scroll { scrollbar-width: thin; scrollbar-color: rgba(20,24,26,.16) transparent; }
            .pos-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
            .pos-scroll::-webkit-scrollbar-thumb { background: rgba(20,24,26,.14); border-radius: 4px; }
            .led { box-shadow: 0 0 0 3px color-mix(in srgb, currentColor 18%, transparent); }
            :focus-visible { outline: 2px solid #1C3A14; outline-offset: 2px; border-radius: 3px; }
            @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }
        </style>
    </head>
    <body class="bg-[#F4F6F5] text-[#14181A] font-inter antialiased min-h-screen">
        <div class="flex min-h-screen">
            {{-- Sidebar: the station panel --}}
            <aside class="hidden md:flex w-60 shrink-0 flex-col bg-[#171009] text-cream">
                <div class="px-5 py-5 border-b border-cream/10">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-lime flex items-center justify-center shrink-0">
                            <svg width="16" height="16" viewBox="0 0 18 18" fill="none">
                                <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#20140D" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="leading-tight">
                            <div class="font-fraunces text-base font-medium">TELF</div>
                            <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/45 -mt-0.5">Pos Dinas</div>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                    <span class="block px-3 pb-1 font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/35">Konten</span>
                    @include('partials.admin-nav-item', ['route' => 'admin.about', 'label' => 'Tentang', 'icon' => 'info'])
                    @include('partials.admin-nav-item', ['route' => 'admin.teams', 'label' => 'Tim', 'icon' => 'users'])
                    @include('partials.admin-nav-item', ['route' => 'admin.faq', 'label' => 'FAQ', 'icon' => 'question'])
                    @include('partials.admin-nav-item', ['route' => 'admin.articles.index', 'label' => 'Artikel', 'icon' => 'article'])
                </nav>

                <div class="px-3 py-4 border-t border-cream/10 text-sm space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-cream/60 hover:text-lime hover:bg-cream/5 transition-colors">
                        <span class="w-4 text-center font-jetbrains-mono text-[11px]">↗</span> Lihat situs
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-cream/60 hover:text-loss hover:bg-cream/5 transition-colors">
                            <span class="w-4 text-center font-jetbrains-mono text-[11px]">⎋</span> Keluar
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Main --}}
            <div class="flex-1 flex flex-col min-w-0">
                <header class="flex items-center justify-between gap-4 px-5 md:px-8 h-14 border-b border-[#E3E6E4] bg-[#F4F6F5] shrink-0">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="md:hidden flex items-center gap-2">
                            <span class="font-fraunces text-base font-medium text-[#14181A]">TELF</span>
                            <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5C6770]">Pos Dinas</span>
                        </div>
                        <h1 class="hidden md:block font-fraunces text-xl text-[#14181A] truncate">{{ $header ?? 'Panel Admin' }}</h1>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        @admin
                            <span class="hidden sm:block font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-[#5C6770]">{{ auth()->user()->name }}</span>
                            <span class="w-7 h-7 rounded-full bg-[#1C3A14] text-cream flex items-center justify-center text-xs font-medium">{{ auth()->user()->initials() }}</span>
                        @endadmin
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto pos-scroll">
                    {{ $slot ?? '' }}@yield('content')
                </main>
            </div>
        </div>

        @livewireScripts
        @stack('scripts')
    </body>
</html>