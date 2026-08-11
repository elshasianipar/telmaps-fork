@extends('layouts.landing')

@section('title', ($lang === 'en' ? 'About' : 'Tentang') . ' · TELF')

@php
    $about = \App\Models\About::where('is_active', true)->latest('id')->first();
    $img = fn ($p) => $p ? (str_starts_with($p, 'http') ? $p : asset('storage/'.$p)) : null;
@endphp

@section('content')
    @if (! $about)
        {{-- No About content published yet --}}
        <section class="max-w-3xl mx-auto px-6 pt-40 pb-32">
            @include('partials.empty-state', [
                'eyebrow' => $lang === 'en' ? 'About TELF' : 'Tentang TELF',
                'title' => $lang === 'en' ? 'No data yet.' : 'Belum ada data.',
                'hint' => $lang === 'en'
                    ? 'The about page has not been published yet. The story behind TELF is coming soon.'
                    : 'Konten halaman tentang belum dipublikasikan. Nantikan cerita di balik TELF segera.',
            ])
        </section>
    @else
        {{-- Hero --}}
        @php
            $heroBg = $img($about->hero_image)
                ? "linear-gradient(to bottom, rgba(23,16,9,0.6) 0%, rgba(23,16,9,0.55) 55%, rgba(23,16,9,0.85) 100%), url('{$img($about->hero_image)}')"
                : 'linear-gradient(to bottom, #2E3D24 0%, #171009 100%)';
        @endphp
        <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: {{ $heroBg }}; background-size: cover; background-position: center;">
            @if ($about->heroEyebrowFor($lang))
                <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $about->heroEyebrowFor($lang) }}</p>
            @endif
            @if ($about->heroTitleFor($lang))
                <h1 class="font-fraunces text-5xl md:text-7xl text-cream font-normal leading-tight max-w-4xl">
                    {{ $about->heroTitleFor($lang) }}
                </h1>
            @endif
            @if ($about->heroSubtitleFor($lang))
                <p class="mt-6 text-white/70 text-base md:text-lg max-w-xl leading-relaxed">{{ $about->heroSubtitleFor($lang) }}</p>
            @endif
            <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
                <a href="{{ route('map') }}" class="inline-flex items-center justify-center px-8 py-3 bg-lime text-ink text-sm font-semibold rounded-full hover:bg-[#E6652A] transition-colors">{{ $lang === 'en' ? 'Open Platform' : 'Buka Platform' }}</a>
                <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center px-8 py-3 border border-white/40 text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-colors">{{ $lang === 'en' ? 'Contact us' : 'Hubungi Kami' }}</a>
            </div>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
                <div class="w-px h-12 bg-white/30"></div>
                <p class="text-white/40 text-xs tracking-widest uppercase">{{ $lang === 'en' ? 'Scroll' : 'Gulir' }}</p>
            </div>
        </section>

        {{-- Our story --}}
        @if ($about->storyTitleFor($lang) || $about->storyBodyFor($lang))
            <section class="max-w-7xl mx-auto px-6 py-24 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    @if ($about->storyEyebrowFor($lang))
                        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $about->storyEyebrowFor($lang) }}</p>
                    @endif
                    @if ($about->storyTitleFor($lang))
                        <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">{{ $about->storyTitleFor($lang) }}</h2>
                    @endif
                    @if ($about->storyBodyFor($lang))
                        <p class="mt-6 text-bark/70 leading-relaxed">{{ $about->storyBodyFor($lang) }}</p>
                    @endif
                </div>

                <div class="relative">
                    @if ($img($about->story_image))
                        <img src="{{ $img($about->story_image) }}" alt="{{ $lang === 'en' ? 'Our story' : 'Cerita kami' }}" class="w-full h-[420px] md:h-[520px] object-cover rounded-[2rem]">
                    @endif
                </div>
            </section>
        @endif

        {{-- Mission & Vision --}}
        @if ($about->missionFor($lang) || $about->visionFor($lang))
            <section class="max-w-7xl mx-auto px-6 py-24">
                <div class="text-center max-w-2xl mx-auto">
                    <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">{{ $lang === 'en' ? 'What drives us' : 'Apa yang mendorong kami' }}</p>
                    <h2 class="font-fraunces text-4xl md:text-5xl font-normal text-forest leading-tight">{{ $lang === 'en' ? 'Data for forest conservation.' : 'Data untuk kelestarian hutan.' }}</h2>
                </div>

                <div class="mt-14 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if ($about->missionFor($lang))
                        <div class="rounded-[2rem] border border-forest/15 bg-white p-10 shadow-[0_35px_80px_rgba(23,16,9,0.08)]">
                            <span class="inline-block rounded-full bg-lime/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-lime">Mission</span>
                            <p class="mt-5 text-bark/80 leading-relaxed">{{ $about->missionFor($lang) }}</p>
                        </div>
                    @endif
                    @if ($about->visionFor($lang))
                        <div class="rounded-[2rem] border border-forest/15 bg-white p-10 shadow-[0_35px_80px_rgba(23,16,9,0.08)]">
                            <span class="inline-block rounded-full bg-lime/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-lime">Vision</span>
                            <p class="mt-5 text-bark/80 leading-relaxed">{{ $about->visionFor($lang) }}</p>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    @endif
@endsection
