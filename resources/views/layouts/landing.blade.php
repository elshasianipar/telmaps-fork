<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'Garden Tree') . ' · Professional Landscaping')</title>

        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔥</text></svg>">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html { scroll-behavior: smooth; }
            body { -webkit-font-smoothing: antialiased; }
            #navbar.nav-scrolled { background-color: rgba(23, 16, 9, 0.95); backdrop-filter: blur(8px); }
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(216, 80, 30, 0.25); border-radius: 3px; }
        </style>
    </head>
    <body class="bg-cream text-forest font-inter antialiased">
        <div class="bg-cream">
            @include('components.landing-navbar')
            @yield('content')
            @include('components.landing-footer')
        </div>

        <script>
            (function () {
                const nav = document.getElementById('navbar');
                if (nav) {
                    const onScroll = () => nav.classList.toggle('nav-scrolled', window.scrollY > 40);
                    window.addEventListener('scroll', onScroll, { passive: true });
                    onScroll();
                }

                const menuBtn = document.getElementById('menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const openIcon = document.getElementById('menu-open-icon');
                const closeIcon = document.getElementById('menu-close-icon');
                if (menuBtn && mobileMenu && openIcon && closeIcon) {
                    const closeMenu = () => {
                        mobileMenu.classList.add('hidden');
                        openIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    };
                    menuBtn.addEventListener('click', () => {
                        const isOpen = !mobileMenu.classList.contains('hidden');
                        if (isOpen) {
                            closeMenu();
                        } else {
                            mobileMenu.classList.remove('hidden');
                            openIcon.classList.add('hidden');
                            closeIcon.classList.remove('hidden');
                        }
                    });
                    mobileMenu.querySelectorAll('a').forEach((a) => a.addEventListener('click', closeMenu));
                }
            })();
        </script>

        @yield('extra-scripts')
    </body>
</html>
