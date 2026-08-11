@php
    $toggle = fn (string $to) => request()->fullUrlWithQuery(['lang' => $to]);
@endphp

<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('home') }}#top" class="flex items-center gap-2">
            <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center overflow-hidden">
                <img src="{{ asset('img/LOGOFIRE.png') }}" alt="TELF Logo" class="w-full h-full object-cover rounded-full">
            </div>
        </a>

        {{-- Desktop nav --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}#top" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">{{ $lang === 'en' ? 'Home' : 'Beranda' }}</a>
            <a href="{{ route('about') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">{{ $lang === 'en' ? 'About' : 'Tentang' }}</a>
            <a href="{{ route('faq') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">FAQ</a>
            <a href="{{ route('teams') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">{{ $lang === 'en' ? 'Teams' : 'Tim' }}</a>
            <a href="{{ route('articles.index') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">{{ $lang === 'en' ? 'Articles' : 'Artikel' }}</a>
        </div>

        <div class="hidden md:flex items-center gap-4">
            {{-- Locale toggle --}}
            <div class="flex items-center gap-1 border border-white/20 rounded-full p-1">
                <a href="{{ $toggle('id') }}"
                   class="font-jetbrains-mono text-[11px] uppercase tracking-[0.14em] rounded-full px-3 py-1 transition-colors {{ $lang === 'id' ? 'bg-lime text-ink' : 'text-white/60 hover:text-white' }}">
                    ID
                </a>
                <a href="{{ $toggle('en') }}"
                   class="font-jetbrains-mono text-[11px] uppercase tracking-[0.14em] rounded-full px-3 py-1 transition-colors {{ $lang === 'en' ? 'bg-lime text-ink' : 'text-white/60 hover:text-white' }}">
                    EN
                </a>
            </div>
            @admin
                <a href="{{ route('admin.about') }}" class="text-sm font-medium text-white/70 hover:text-lime transition-colors">Admin</a>
            @endadmin
            <a href="{{ route('map') }}" class="px-5 py-2 bg-lime text-ink text-sm font-semibold rounded-full hover:bg-[#E6652A] transition-colors">Platform</a>
        </div>

        {{-- Mobile menu button --}}
        <button id="menu-btn" type="button" class="md:hidden text-white" aria-label="{{ $lang === 'en' ? 'Toggle menu' : 'Buka menu' }}">
            <svg id="menu-open-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
            <svg id="menu-close-icon" class="hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile dropdown --}}
    <div id="mobile-menu" class="hidden md:hidden bg-forest-dark border-t border-white/10 px-6 py-4 flex flex-col gap-4">
        <a href="{{ route('home') }}#top" class="text-white text-sm font-medium hover:text-lime transition-colors">{{ $lang === 'en' ? 'Home' : 'Beranda' }}</a>
        <a href="{{ route('about') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">{{ $lang === 'en' ? 'About' : 'Tentang' }}</a>
        <a href="{{ route('faq') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">FAQ</a>
        <a href="{{ route('teams') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">{{ $lang === 'en' ? 'Teams' : 'Tim' }}</a>
        <a href="{{ route('articles.index') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">{{ $lang === 'en' ? 'Articles' : 'Artikel' }}</a>
        <div class="flex items-center gap-1 border border-white/20 rounded-full p-1 self-start">
            <a href="{{ $toggle('id') }}"
               class="font-jetbrains-mono text-[11px] uppercase tracking-[0.14em] rounded-full px-3 py-1 transition-colors {{ $lang === 'id' ? 'bg-lime text-ink' : 'text-white/60 hover:text-white' }}">
                ID
            </a>
            <a href="{{ $toggle('en') }}"
               class="font-jetbrains-mono text-[11px] uppercase tracking-[0.14em] rounded-full px-3 py-1 transition-colors {{ $lang === 'en' ? 'bg-lime text-ink' : 'text-white/60 hover:text-white' }}">
                EN
            </a>
        </div>
        @admin
            <a href="{{ route('admin.about') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">Admin</a>
        @endadmin
        <a href="{{ route('map') }}" class="mt-2 px-5 py-2 bg-lime text-ink text-sm font-semibold rounded-full text-center">Platform</a>
    </div>
</nav>
