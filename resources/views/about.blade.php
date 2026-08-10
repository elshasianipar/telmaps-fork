@extends('layouts.landing')

@section('title', config('app.name', 'Garden Tree') . ' · About')

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(15,33,9,0.6) 0%, rgba(15,33,9,0.55) 55%, rgba(15,33,9,0.85) 100%), url('https://images.unsplash.com/photo-1730061753977-126196ac19ee?w=1600&h=1000&fit=crop&auto=format'); background-size: cover; background-position: center;">
        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">About Garden Tree</p>
        <h1 class="font-fraunces text-5xl md:text-7xl text-cream font-normal leading-tight max-w-4xl">
            We cultivate more than<br>
            <em class="not-italic">just plants.</em>
        </h1>
        <p class="mt-6 text-white/70 text-base md:text-lg max-w-xl leading-relaxed">
            Garden Tree is a landscape studio focused on thoughtful design, sustainable planting, and long-term care. We blend deep horticultural knowledge with modern environmental practice to create spaces that thrive for people and nature.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
            <a href="{{ route('map') }}" class="inline-flex items-center justify-center px-8 py-3 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">Home</a>
            <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center px-8 py-3 border border-white/40 text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-colors">Platform</a>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
            <div class="w-px h-12 bg-white/30"></div>
            <p class="text-white/40 text-xs tracking-widest uppercase">Scroll</p>
        </div>
    </section>

    {{-- Our story --}}
    <section class="max-w-7xl mx-auto px-6 py-24 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">Our story</p>
            <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">
                Since 2008, we've grown into the region's trusted landscape partner.
            </h2>
            <p class="mt-6 text-bark/70 leading-relaxed">
                Garden Tree started as a small design studio and blossomed into a leading company dedicated to providing innovative solutions for gardening, landscaping, and environmental stewardship.
            </p>
            <ul class="mt-8 space-y-4">
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-lime text-forest text-xs">✓</span>
                    <span class="text-bark/80">Deep expertise in native planting, sustainable irrigation, and ecological landscape systems.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-lime text-forest text-xs">✓</span>
                    <span class="text-bark/80">Personalized design with durable materials and low-maintenance plant palettes.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-lime text-forest text-xs">✓</span>
                    <span class="text-bark/80">Strong care and support after installation so your landscape stays healthy year after year.</span>
                </li>
            </ul>
            <!-- <a href="{{ route('home') }}#services" class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-forest hover:text-sage transition-colors border-b border-forest pb-1">Explore our services &rarr;</a> -->
        </div>

        <div class="relative">
            <img src="https://images.unsplash.com/photo-1759538575044-77c261e0183e?w=800&h=700&fit=crop&auto=format" alt="Japanese garden with pagoda surrounded by lush green trees" class="w-full h-[420px] md:h-[520px] object-cover rounded-[2rem]">
        </div>
    </section>

    {{-- Stats --}}
    <!-- <section class="bg-cream border-t border-b border-forest/10 py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">16+</div>
                <div class="text-sage text-sm mt-1 font-medium">Years of Experience</div>
            </div>
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">874</div>
                <div class="text-sage text-sm mt-1 font-medium">Projects Completed</div>
            </div>
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">169k</div>
                <div class="text-sage text-sm mt-1 font-medium">Clients Served</div>
            </div>
            <div>
                <div class="font-fraunces text-5xl font-normal text-forest">98%</div>
                <div class="text-sage text-sm mt-1 font-medium">Client Satisfaction</div>
            </div>
        </div>
    </section> -->

    {{-- Mission & Vision --}}
    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">What drives us</p>
            <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">Design with nature, not against it.</h2>
        </div>

        <div class="mt-14 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="rounded-[2rem] border border-forest/15 bg-white p-10 shadow-[0_35px_80px_rgba(15,33,9,0.08)]">
                <span class="inline-block rounded-full bg-lime/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-forest">Mission</span>
                <p class="mt-5 text-bark/80 leading-relaxed">
                    Our work creates outdoor spaces that are beautiful, functional, and resilient. From concept to care, every decision is made to support long-term health.
                </p>
            </div>
            <div class="rounded-[2rem] border border-forest/15 bg-white p-10 shadow-[0_35px_80px_rgba(15,33,9,0.08)]">
                <span class="inline-block rounded-full bg-lime/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-forest">Vision</span>
                <p class="mt-5 text-bark/80 leading-relaxed">
                    We believe every garden can be more than a backyard. It can be a vibrant habitat, a source of calm, and a place for people to connect with the living world.
                </p>
            </div>
        </div>
    </section>

    {{-- Why choose us --}}
@endsection
