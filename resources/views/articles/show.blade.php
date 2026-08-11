@extends('layouts.landing')

@section('title', $article->titleFor($lang) . ' · TELF')

@section('content')
@php
    $toggle = function (string $to) {
        return request()->fullUrlWithQuery(['lang' => $to]);
    };
    $body = $article->contentFor($lang) ?: $article->excerptFor($lang);
    $date = $article->published_at?->format('Y-m-d');
    $author = $article->author?->name;
    $hasLink = filled($article->link);
@endphp

<article class="max-w-3xl mx-auto px-6 pt-28 pb-20">
    {{-- Dossier meta strip --}}
    <div class="flex items-center justify-between gap-4 mb-10">
        <a href="{{ route('articles.index') }}?lang={{ $lang }}" class="inline-flex items-center gap-2 text-sm text-bark/70 hover:text-forest transition-colors">
            <span>←</span> {{ $lang === 'en' ? 'All articles' : 'Semua artikel' }}
        </a>
        <div class="flex items-center gap-0.5 border border-forest/15 rounded-full p-0.5 bg-white/60">
            <a href="{{ $toggle('id') }}"
               class="font-jetbrains-mono text-[11px] uppercase tracking-[0.14em] rounded-full px-3 py-1.5 transition-colors {{ $lang === 'id' ? 'bg-lime text-ink' : 'text-bark/70 hover:text-forest' }}">ID</a>
            <a href="{{ $toggle('en') }}"
               class="font-jetbrains-mono text-[11px] uppercase tracking-[0.14em] rounded-full px-3 py-1.5 transition-colors {{ $lang === 'en' ? 'bg-lime text-ink' : 'text-bark/70 hover:text-forest' }}">EN</a>
        </div>
    </div>

    {{-- Dispatch header --}}
    <header>
        <p class="font-jetbrains-mono text-[11px] uppercase tracking-[0.22em] text-lime">
            Pos Sumatera · {{ $lang === 'en' ? 'field report' : 'laporan lapangan' }}
        </p>
        <h1 class="font-fraunces text-3xl md:text-5xl text-forest leading-tight mt-3">{{ $article->titleFor($lang) }}</h1>

        <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 mt-6 font-jetbrains-mono text-[11px] uppercase tracking-[0.18em] text-sage">
            @if ($date)
                <span class="tabular-nums">{{ $lang === 'en' ? 'Date' : 'Tgl' }} {{ $date }}</span>
            @endif
            @if ($author)
                <span>{{ $lang === 'en' ? 'By' : 'Penulis' }} {{ $author }}</span>
            @endif
            @if ($hasLink)
                <span class="text-lime">↗ {{ $lang === 'en' ? 'external link' : 'tautan eksternal' }}</span>
            @endif
        </div>

        @if ($article->excerptFor($lang))
            <p class="mt-6 text-lg text-bark/80 leading-relaxed">{{ $article->excerptFor($lang) }}</p>
        @endif
    </header>

    {{-- Rule --}}
    <hr class="border-forest/10 my-10">

    {{-- Image --}}
    @if ($article->featured_image)
        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->titleFor($lang) }}"
             class="w-full aspect-[16/9] object-cover rounded-xl border border-forest/15 mb-10">
    @endif

    {{-- Body --}}
    @if ($body)
        <div class="article-body text-bark/85 leading-[1.85] text-[15px]">{!! $body !!}</div>
    @endif

    {{-- External link CTA --}}
    @if ($hasLink)
        <div class="mt-12 pt-8 border-t border-forest/10">
            <a href="{{ $article->link }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-6 py-3 bg-lime text-ink text-sm font-semibold rounded-full hover:bg-[#E6652A] transition-colors">
                {{ $lang === 'en' ? 'Open external link' : 'Buka tautan eksternal' }}
                <span>↗</span>
            </a>
        </div>
    @endif

    {{-- Back --}}
    <div class="mt-12">
        <a href="{{ route('articles.index') }}?lang={{ $lang }}" class="inline-flex items-center gap-2 text-sm font-medium text-forest hover:text-sage transition-colors border-b border-forest/30 pb-1">
            <span>←</span> {{ $lang === 'en' ? 'Back to the log' : 'Kembali ke buku laporan' }}
        </a>
    </div>
</article>
@endsection
