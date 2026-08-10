@extends('layouts.landing')

@section('content')
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
@endsection

@section('extra-scripts')
    <script>
        (function () {
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
@endsection
