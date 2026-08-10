@extends('layouts.landing')

@section('title', config('app.name', 'TELF') . ' · About')

@php
    $about = \App\Models\About::where('is_active', true)->latest('id')->first();
    $heroEyebrow = $about?->hero_eyebrow ?? 'About TELF';
    $heroTitle = $about?->hero_title ?? 'Memantau hilangnya hutan, satu piksel pada satu waktu.';
    $heroSubtitle = $about?->hero_subtitle ?? '';
    $heroImage = $about?->hero_image ?? 'https://images.unsplash.com/photo-1730061753977-126196ac19ee?w=1600&h=1000&fit=crop&auto=format';
    $storyEyebrow = $about?->story_eyebrow ?? 'Kisah kami';
    $storyTitle = $about?->story_title ?? '';
    $storyBody = $about?->story_body ?? '';
    $storyImage = $about?->story_image ?? 'https://images.unsplash.com/photo-1759538575044-77c261e0183e?w=800&h=700&fit=crop&auto=format';
    $mission = $about?->mission ?? '';
    $vision = $about?->vision ?? '';
    $img = fn ($p) => $p ? (str_starts_with($p, 'http') ? $p : asset('storage/'.$p)) : null;
@endphp

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(15,33,9,0.6) 0%, rgba(15,33,9,0.55) 55%, rgba(15,33,9,0.85) 100%), url('{{ $img($heroImage) }}'); background-size: cover; background-position: center;">
        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $heroEyebrow }}</p>
        <h1 class="font-fraunces text-5xl md:text-7xl text-cream font-normal leading-tight max-w-4xl">
            {{ $heroTitle }}
        </h1>
        @if ($heroSubtitle)
            <p class="mt-6 text-white/70 text-base md:text-lg max-w-xl leading-relaxed">{{ $heroSubtitle }}</p>
        @endif
        <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
            <a href="{{ route('map') }}" class="inline-flex items-center justify-center px-8 py-3 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">Buka Platform</a>
            <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center px-8 py-3 border border-white/40 text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-colors">Hubungi Kami</a>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
            <div class="w-px h-12 bg-white/30"></div>
            <p class="text-white/40 text-xs tracking-widest uppercase">Scroll</p>
        </div>
    </section>

    {{-- Our story --}}
    <section class="max-w-7xl mx-auto px-6 py-24 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $storyEyebrow }}</p>
            <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">{{ $storyTitle }}</h2>
            @if ($storyBody)
                <p class="mt-6 text-bark/70 leading-relaxed">{{ $storyBody }}</p>
            @endif
        </div>

        <div class="relative">
            @if ($img($storyImage))
                <img src="{{ $img($storyImage) }}" alt="Our story" class="w-full h-[420px] md:h-[520px] object-cover rounded-[2rem]">
            @endif
        </div>
    </section>

    {{-- Mission & Vision --}}
    @if ($mission || $vision)
        <section class="max-w-7xl mx-auto px-6 py-24">
            <div class="text-center max-w-2xl mx-auto">
                <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">What drives us</p>
                <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">Data untuk kelestarian hutan.</h2>
            </div>

            <div class="mt-14 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($mission)
                    <div class="rounded-[2rem] border border-forest/15 bg-white p-10 shadow-[0_35px_80px_rgba(15,33,9,0.08)]">
                        <span class="inline-block rounded-full bg-lime/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-forest">Mission</span>
                        <p class="mt-5 text-bark/80 leading-relaxed">{{ $mission }}</p>
                    </div>
                @endif
                @if ($vision)
                    <div class="rounded-[2rem] border border-forest/15 bg-white p-10 shadow-[0_35px_80px_rgba(15,33,9,0.08)]">
                        <span class="inline-block rounded-full bg-lime/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-forest">Vision</span>
                        <p class="mt-5 text-bark/80 leading-relaxed">{{ $vision }}</p>
                    </div>
                @endif
            </div>
        </section>
    @endif
@endsection