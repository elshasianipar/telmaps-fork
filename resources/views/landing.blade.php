@extends('layouts.landing')

@section('content')
    {{-- Hero --}}
    <section id="top" class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(23,16,9,0.55) 0%, rgba(23,16,9,0.4) 60%, rgba(23,16,9,0.7) 100%), url('https://images.unsplash.com/photo-1730061753977-126196ac19ee?w=1600&h=1000&fit=crop&auto=format'); background-size: cover; background-position: center;">
        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $lang === 'en' ? 'Sumatra Forest Monitoring' : 'Pemantauan Hutan Sumatera' }}</p>
        <h1 class="font-fraunces text-5xl md:text-7xl text-lime font-normal leading-tight max-w-3xl">
            {!! $lang === 'en'
                ? 'Forest-loss monitoring<br><em class="not-italic">for Sumatra</em>'
                : 'Pemantauan kehilangan hutan<br><em class="not-italic">di Sumatera</em>' !!}
        </h1>
        <p class="mt-6 text-white/70 text-base max-w-md leading-relaxed">
            {{ $lang === 'en'
                ? 'TELF combines Landsat satellite data (GLAD Alert) with Indonesian administrative boundaries to highlight deforestation hotspots in near real-time.'
                : 'TELF memadukan data satelit Landsat (GLAD Alert) dengan batas administrasi Indonesia untuk menyoroti titik panas deforestasi secara real-time.' }}
        </p>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
            <div class="w-px h-12 bg-white/30"></div>
            <p class="text-white/40 text-xs tracking-widest uppercase">{{ $lang === 'en' ? 'Scroll' : 'Gulir' }}</p>
        </div>
    </section>

    {{-- Latest articles (pratinjau laporan dari lapangan, ambil dari DB) --}}
    @include('components.latest-articles')

    {{-- About intro --}}
    <section id="about" class="max-w-7xl mx-auto px-6 py-24 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">
                {{ $lang === 'en'
                    ? 'Welcome to TELF — we monitor more than just trees'
                    : 'Selamat datang di TELF — kami memantau lebih dari sekadar pepohonan' }}
            </h2>
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-forest hover:text-sage transition-colors border-b border-forest pb-1">{{ $lang === 'en' ? 'About us' : 'Tentang kami' }} &rarr;</a>
        </div>
        <div>
            <p class="text-bark/70 leading-relaxed">
                {{ $lang === 'en'
                    ? 'Founded with a commitment to forest stewardship and sustainability, TELF provides open-satellite-data-based forest-loss monitoring — from province to village — so every stakeholder can see where deforestation happens.'
                    : 'Didirikan dengan kepedulian terhadap kelestarian hutan, TELF menyediakan pemantauan kehilangan hutan berbasis data satelit terbuka — dari provinsi hingga desa — agar setiap pemangku kepentingan dapat melihat di mana deforestasi terjadi.' }}
            </p>
            <img src="https://images.unsplash.com/photo-1759538575044-77c261e0183e?w=800&h=400&fit=crop&auto=format" alt="Hutan tropis hijau lebat" class="mt-8 w-full h-56 object-cover rounded-2xl">
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-cream border-t border-b border-forest/10 py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">10</div>
                <div class="text-sage text-sm mt-1 font-medium">{{ $lang === 'en' ? 'Provinces monitored' : 'Provinsi dipantau' }}</div>
            </div>
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">{{ $lang === 'en' ? '91,355' : '91.355' }}</div>
                <div class="text-sage text-sm mt-1 font-medium">{{ $lang === 'en' ? 'Fire points' : 'Titik kebakaran' }}</div>
            </div>
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">5</div>
                <div class="text-sage text-sm mt-1 font-medium">{{ $lang === 'en' ? 'Years of data' : 'Tahun data' }}</div>
            </div>
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">3</div>
                <div class="text-sage text-sm mt-1 font-medium">{{ $lang === 'en' ? 'Confidence tiers' : 'Tingkat keyakinan' }}</div>
            </div>
        </div>
    </section>

    {{-- CTA Banner --}}
    <section id="contact" class="relative py-32 flex items-center justify-center text-center overflow-hidden" style="background-image: linear-gradient(rgba(23,16,9,0.7), rgba(23,16,9,0.7)), url('https://images.unsplash.com/photo-1668120089662-42642838cfef?w=1600&h=600&fit=crop&auto=format'); background-size: cover; background-position: center;">
        <div class="px-6">
            <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $lang === 'en' ? 'Ready to monitor?' : 'Siap memantau?' }}</p>
            <h2 class="font-fraunces text-4xl md:text-6xl text-white font-normal max-w-2xl mx-auto leading-tight">
                {{ $lang === 'en'
                    ? 'See deforestation hotspots on the interactive map'
                    : 'Lihat titik panas deforestasi di peta interaktif' }}
            </h2>
            <a href="{{ route('map') }}" class="inline-block mt-8 px-8 py-3 bg-lime text-ink text-sm font-semibold rounded-full hover:bg-[#E6652A] transition-colors">{{ $lang === 'en' ? 'Open Platform' : 'Buka Platform' }}</a>
        </div>
    </section>
@endsection

@section('extra-scripts')
    <script>
        (function () {
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
