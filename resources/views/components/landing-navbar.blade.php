<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        {{-- Logo --}}
        <a href="#top" class="flex items-center gap-2">
            <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center">
                <img src="{{ asset('img/LOGOTEL.png') }}" alt="Garden Tree Logo" class="w-50">
            </div>
        </a>

        {{-- Desktop nav --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}#top" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Home</a>
            <a href="{{ route('about') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">About</a>
            <a href="{{ route('faq') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">FAQ</a>
            <a href="{{ route('teams') }}" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Teams</a>
            <a href="{{ route('home') }}#contact" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Contact</a>
        </div>

        <div class="hidden md:flex items-center gap-4">
            @admin
                <a href="{{ route('admin.about') }}" class="text-sm font-medium text-white/70 hover:text-lime transition-colors">Admin</a>
            @endadmin
            <a href="{{ route('map') }}" class="px-5 py-2 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">Platform</a>
        </div>

        {{-- Mobile menu button --}}
        <button id="menu-btn" type="button" class="md:hidden text-white" aria-label="Toggle menu">
            <svg id="menu-open-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
            <svg id="menu-close-icon" class="hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile dropdown --}}
    <div id="mobile-menu" class="hidden md:hidden bg-forest-dark border-t border-white/10 px-6 py-4 flex flex-col gap-4">
        <a href="{{ route('home') }}#top" class="text-white text-sm font-medium hover:text-lime transition-colors">Home</a>
        <a href="{{ route('about') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">About</a>
        <a href="{{ route('faq') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">FAQ</a>
        <a href="{{ route('teams') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">Teams</a>
        <a href="{{ route('home') }}#contact" class="text-white text-sm font-medium hover:text-lime transition-colors">Contact</a>
        @admin
            <a href="{{ route('admin.about') }}" class="text-white text-sm font-medium hover:text-lime transition-colors">Admin</a>
        @endadmin
        <a href="{{ route('map') }}" class="mt-2 px-5 py-2 bg-lime text-forest text-sm font-semibold rounded-full text-center">Let's Talk</a>
    </div>
</nav>
