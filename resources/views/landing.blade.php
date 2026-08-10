<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Garden Tree') }} &middot; Professional Landscaping</title>

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
            {{-- Navbar --}}
            <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                    {{-- Logo --}}
                    <a href="#top" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-lime flex items-center justify-center">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5" stroke="#1C3A14" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5" stroke="#1C3A14" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#1C3A14" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="text-white leading-tight">
                            <div class="font-fraunces text-sm font-semibold">Garden</div>
                            <div class="font-fraunces text-sm font-light -mt-1">Tree</div>
                        </div>
                    </a>

                    {{-- Desktop nav --}}
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#top" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Home</a>
                        <a href="#about" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">About</a>
                        <a href="#services" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Services</a>
                        <a href="#process" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Projects</a>
                        <a href="#contact" class="nav-link text-sm font-medium text-white hover:text-lime transition-colors">Contact</a>
                    </div>

                    <div class="hidden md:flex items-center gap-4">
                        <a href="{{ route('map') }}" class="px-5 py-2 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">Let's Talk</a>
                    </div>

                    {{-- Mobile menu button --}}
                    <button id="menu-btn" type="button" class="md:hidden text-white" aria-label="Toggle menu">
                        <svg id="menu-open-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
                        <svg id="menu-close-icon" class="hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Mobile dropdown --}}
                <div id="mobile-menu" class="hidden md:hidden bg-forest-dark border-t border-white/10 px-6 py-4 flex flex-col gap-4">
                    <a href="#top" class="text-white text-sm font-medium hover:text-lime transition-colors">Home</a>
                    <a href="#about" class="text-white text-sm font-medium hover:text-lime transition-colors">About</a>
                    <a href="#services" class="text-white text-sm font-medium hover:text-lime transition-colors">Services</a>
                    <a href="#process" class="text-white text-sm font-medium hover:text-lime transition-colors">Projects</a>
                    <a href="#contact" class="text-white text-sm font-medium hover:text-lime transition-colors">Contact</a>
                    <a href="{{ route('map') }}" class="mt-2 px-5 py-2 bg-lime text-forest text-sm font-semibold rounded-full text-center">Let's Talk</a>
                </div>
            </nav>

            {{-- Hero --}}
            <section id="top" class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(15,33,9,0.55) 0%, rgba(15,33,9,0.4) 60%, rgba(15,33,9,0.7) 100%), url('https://images.unsplash.com/photo-1730061753977-126196ac19ee?w=1600&h=1000&fit=crop&auto=format'); background-size: cover; background-position: center;">
                <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">Professional Landscaping</p>
                <h1 class="font-fraunces text-5xl md:text-7xl text-lime font-normal leading-tight max-w-3xl">
                    We take care of your<br>
                    <em class="not-italic">garden &amp; tree</em>
                </h1>
                <p class="mt-6 text-white/70 text-base max-w-md leading-relaxed">
                    Garden Tree has blossomed into a leading company dedicated to providing innovative solutions for gardening.
                </p>
                <div class="flex gap-4 mt-8">
                    <a href="#contact" class="px-6 py-3 border border-lime text-lime text-sm font-medium rounded-full hover:bg-lime hover:text-forest transition-all">Get in Touch</a>
                    <a href="#about" class="px-6 py-3 bg-white/10 border border-white/20 text-white text-sm font-medium rounded-full hover:bg-white/20 transition-all backdrop-blur-sm">Who We Are</a>
                </div>

                {{-- Scroll indicator --}}
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
                    <div class="w-px h-12 bg-white/30"></div>
                    <p class="text-white/40 text-xs tracking-widest uppercase">Scroll</p>
                </div>
            </section>

            {{-- Services cards --}}
            <section id="services" class="max-w-7xl mx-auto px-6 -mt-20 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="service-card relative overflow-hidden rounded-2xl cursor-pointer group transition-all duration-300 h-[280px]" data-desc="Sourcing and cultivating plants that thrive in your local ecosystem, reducing water needs and supporting biodiversity.">
                        <img src="https://images.unsplash.com/photo-1569736957322-b5e515f249b0?w=600&h=480&fit=crop&auto=format" alt="Native Plant Nursery" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/80 to-transparent"></div>
                        <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-lg font-light">+</div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-fraunces text-lg font-normal">Native Plant Nursery</h3>
                        </div>
                    </div>

                    <div class="service-card service-active relative overflow-hidden rounded-2xl cursor-pointer group transition-all duration-300 h-[280px] ring-2 ring-lime" data-desc="Expert guidance on planning, planting, and maintaining your ideal garden space with year-round seasonal strategies.">
                        <img src="https://images.unsplash.com/photo-1713305298073-0c5d481bf381?w=600&h=480&fit=crop&auto=format" alt="Gardening Consultation" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/80 to-transparent"></div>
                        <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-lg font-light">+</div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-fraunces text-lg font-normal">Gardening Consultation</h3>
                        </div>
                    </div>

                    <div class="service-card relative overflow-hidden rounded-2xl cursor-pointer group transition-all duration-300 h-[280px]" data-desc="Sustainable design and installation that minimizes environmental impact while maximizing outdoor beauty.">
                        <img src="https://images.unsplash.com/photo-1748267984369-76a1c4849df8?w=600&h=480&fit=crop&auto=format" alt="Eco-Friendly Landscaping" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/80 to-transparent"></div>
                        <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-lg font-light">+</div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-fraunces text-lg font-normal">Eco-Friendly Landscaping</h3>
                        </div>
                    </div>
                </div>

                {{-- Active service detail --}}
                <div class="mt-4 bg-white rounded-2xl p-6">
                    <p id="service-desc" class="text-sage text-sm leading-relaxed max-w-2xl">Expert guidance on planning, planting, and maintaining your ideal garden space with year-round seasonal strategies.</p>
                    <a href="#services" class="inline-flex items-center gap-2 mt-3 text-sm font-medium text-forest hover:text-sage transition-colors">View all services <span>&rarr;</span></a>
                </div>
            </section>

            {{-- About intro --}}
            <section id="about" class="max-w-7xl mx-auto px-6 py-24 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">
                        Welcome To Garden Tree, We Cultivate More Than Just Plants
                    </h2>
                    <a href="#about" class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-forest hover:text-sage transition-colors border-b border-forest pb-1">About Us &rarr;</a>
                </div>
                <div>
                    <p class="text-bark/70 leading-relaxed">
                        Established with a passion for nature and a commitment to sustainable living, Garden Tree has blossomed into a leading company dedicated to providing innovative solutions for gardening, landscaping, and environmental stewardship.
                    </p>
                    <img src="https://images.unsplash.com/photo-1759538575044-77c261e0183e?w=800&h=400&fit=crop&auto=format" alt="Japanese garden with pagoda surrounded by lush green trees" class="mt-8 w-full h-56 object-cover rounded-2xl">
                </div>
            </section>

            {{-- Stats --}}
            <section class="bg-cream border-t border-b border-forest/10 py-16">
                <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="font-fraunces text-5xl font-normal text-forest">29</div>
                        <div class="text-sage text-sm mt-1 font-medium">Partner Companies</div>
                    </div>
                    <div>
                        <div class="font-fraunces text-5xl font-normal text-forest">874</div>
                        <div class="text-sage text-sm mt-1 font-medium">Total Employees</div>
                    </div>
                    <div>
                        <div class="font-fraunces text-5xl font-normal text-forest">169k</div>
                        <div class="text-sage text-sm mt-1 font-medium">Clients</div>
                    </div>
                    <div>
                        <div class="font-fraunces text-5xl font-normal text-forest">265</div>
                        <div class="text-sage text-sm mt-1 font-medium">Employee Growth</div>
                    </div>
                </div>
            </section>

            {{-- Process --}}
            <section id="process" class="bg-forest-dark py-24">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                        <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-white leading-tight max-w-md">
                            Meticulous And<br>Sustainable Process
                        </h2>
                        <a href="#process" class="self-start md:self-auto px-5 py-2 border border-white/20 text-white text-sm rounded-full hover:border-lime hover:text-lime transition-colors">Our Process</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="group">
                            <div class="w-16 h-16 rounded-full border border-lime/30 flex items-center justify-center mb-6 group-hover:border-lime transition-colors">
                                <span class="text-lime font-fraunces text-lg">1</span>
                            </div>
                            <p class="text-lime text-xs font-semibold tracking-wider uppercase mb-2">01</p>
                            <h3 class="text-white font-fraunces text-xl font-normal mb-3">Discovery and Consultation</h3>
                            <p class="text-white/50 text-sm leading-relaxed">Our landscape architects engage with clients to understand their vision, preferences, and the unique characteristics of their space.</p>
                        </div>
                        <div class="group">
                            <div class="w-16 h-16 rounded-full border border-lime/30 flex items-center justify-center mb-6 group-hover:border-lime transition-colors">
                                <span class="text-lime font-fraunces text-lg">2</span>
                            </div>
                            <p class="text-lime text-xs font-semibold tracking-wider uppercase mb-2">02</p>
                            <h3 class="text-white font-fraunces text-xl font-normal mb-3">Native Plant Integration</h3>
                            <p class="text-white/50 text-sm leading-relaxed">Garden Tree Landscape utilizes the use of native plants in our designs for long-term sustainability.</p>
                        </div>
                        <div class="group">
                            <div class="w-16 h-16 rounded-full border border-lime/30 flex items-center justify-center mb-6 group-hover:border-lime transition-colors">
                                <span class="text-lime font-fraunces text-lg">3</span>
                            </div>
                            <p class="text-lime text-xs font-semibold tracking-wider uppercase mb-2">03</p>
                            <h3 class="text-white font-fraunces text-xl font-normal mb-3">Water-Efficient Irrigation</h3>
                            <p class="text-white/50 text-sm leading-relaxed">Garden Tree Landscape is committed to responsible water management through smart drip systems.</p>
                        </div>
                        <div class="group">
                            <div class="w-16 h-16 rounded-full border border-lime/30 flex items-center justify-center mb-6 group-hover:border-lime transition-colors">
                                <span class="text-lime font-fraunces text-lg">4</span>
                            </div>
                            <p class="text-lime text-xs font-semibold tracking-wider uppercase mb-2">04</p>
                            <h3 class="text-white font-fraunces text-xl font-normal mb-3">Quality Control &amp; Support</h3>
                            <p class="text-white/50 text-sm leading-relaxed">Garden Tree Landscape doesn't consider the completion of a project as the end — we provide ongoing care.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CTA Banner --}}
            <section id="contact" class="relative py-32 flex items-center justify-center text-center overflow-hidden" style="background-image: linear-gradient(rgba(15,33,9,0.7), rgba(15,33,9,0.7)), url('https://images.unsplash.com/photo-1668120089662-42642838cfef?w=1600&h=600&fit=crop&auto=format'); background-size: cover; background-position: center;">
                <div class="px-6">
                    <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">Ready to transform?</p>
                    <h2 class="font-fraunces text-4xl md:text-6xl text-white font-normal max-w-2xl mx-auto leading-tight">
                        Let's Design Your Dream Outdoor Space
                    </h2>
                    <a href="#contact" class="inline-block mt-8 px-8 py-3 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">Start a Project</a>
                </div>
            </section>

            {{-- Footer --}}
            <footer class="bg-forest-dark text-white">
                <div class="max-w-7xl mx-auto px-6 pt-16 pb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-white/10">
                        {{-- Brand --}}
                        <div class="md:col-span-1">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 rounded-full bg-lime flex items-center justify-center">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5" stroke="#1C3A14" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5" stroke="#1C3A14" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#1C3A14" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="leading-tight">
                                    <div class="font-fraunces text-sm font-semibold">Garden</div>
                                    <div class="font-fraunces text-sm font-light -mt-1">Tree</div>
                                </div>
                            </div>
                            <p class="text-white/50 text-sm leading-relaxed">
                                Cultivating beautiful, sustainable outdoor spaces since 2008.
                            </p>
                        </div>

                        {{-- Company links --}}
                        <div>
                            <h4 class="text-sm font-semibold text-lime mb-4 uppercase tracking-wider">Company</h4>
                            <ul class="space-y-2">
                                <li><a href="#about" class="text-white/60 text-sm hover:text-white transition-colors">About Us</a></li>
                                <li><a href="#about" class="text-white/60 text-sm hover:text-white transition-colors">Our Team</a></li>
                                <li><a href="#about" class="text-white/60 text-sm hover:text-white transition-colors">Careers</a></li>
                                <li><a href="#contact" class="text-white/60 text-sm hover:text-white transition-colors">Press</a></li>
                            </ul>
                        </div>

                        {{-- Services links --}}
                        <div>
                            <h4 class="text-sm font-semibold text-lime mb-4 uppercase tracking-wider">Services</h4>
                            <ul class="space-y-2">
                                <li><a href="#services" class="text-white/60 text-sm hover:text-white transition-colors">Native Plant Nursery</a></li>
                                <li><a href="#services" class="text-white/60 text-sm hover:text-white transition-colors">Garden Consultation</a></li>
                                <li><a href="#services" class="text-white/60 text-sm hover:text-white transition-colors">Eco-Friendly Landscaping</a></li>
                                <li><a href="#services" class="text-white/60 text-sm hover:text-white transition-colors">Tree Care</a></li>
                            </ul>
                        </div>

                        {{-- Contact --}}
                        <div>
                            <h4 class="text-sm font-semibold text-lime mb-4 uppercase tracking-wider">Contact</h4>
                            <ul class="space-y-2 text-white/60 text-sm">
                                <li>123 Green Valley Rd</li>
                                <li>Portland, OR 97201</li>
                                <li class="pt-1">
                                    <a href="tel:+15035550148" class="hover:text-white transition-colors">+1 (503) 555-0148</a>
                                </li>
                                <li>
                                    <a href="mailto:hello&#64;gardentree.co" class="hover:text-white transition-colors">hello&#64;gardentree.co</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-white/40 text-xs">
                        <p>&copy; 2026 Garden Tree. All rights reserved.</p>
                        <div class="flex gap-6">
                            <a href="#" class="hover:text-white/70 transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-white/70 transition-colors">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            (function () {
                // Navbar: transparent over hero, dark after scroll
                const nav = document.getElementById('navbar');
                const onScroll = () => {
                    if (window.scrollY > 40) {
                        nav.classList.add('nav-scrolled');
                    } else {
                        nav.classList.remove('nav-scrolled');
                    }
                };
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();

                // Mobile menu toggle
                const menuBtn = document.getElementById('menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const openIcon = document.getElementById('menu-open-icon');
                const closeIcon = document.getElementById('menu-close-icon');
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

                // Active service card
                const cards = document.querySelectorAll('.service-card');
                const descEl = document.getElementById('service-desc');
                cards.forEach((card) => {
                    card.addEventListener('click', () => {
                        cards.forEach((c) => c.classList.remove('ring-2', 'ring-lime'));
                        card.classList.add('ring-2', 'ring-lime');
                        if (descEl && card.dataset.desc) {
                            descEl.textContent = card.dataset.desc;
                        }
                    });
                });

                // Scrollspy: highlight the nav link for the section in view
                const sectionIds = ['top', 'about', 'services', 'process', 'contact'];
                const navLinks = document.querySelectorAll('.nav-link');
                const indexById = Object.fromEntries(sectionIds.map((id, i) => [id, i]));
                if ('IntersectionObserver' in window) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                navLinks.forEach((l) => l.classList.remove('text-lime'));
                                const idx = indexById[entry.target.id];
                                if (navLinks[idx]) {
                                    navLinks[idx].classList.add('text-lime');
                                }
                            }
                        });
                    }, { rootMargin: '-40% 0px -55% 0px' });
                    sectionIds.forEach((id) => {
                        const el = document.getElementById(id);
                        if (el) observer.observe(el);
                    });
                }
            })();
        </script>
    </body>
</html>