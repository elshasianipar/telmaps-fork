@extends('layouts.landing')

@section('title', config('app.name', 'TELF') . ' · Teams')

@php
    $members = \App\Models\TeamMember::active()->ordered()->get();
    $img = fn ($p) => $p ? (str_starts_with($p, 'http') ? $p : asset('storage/'.$p)) : null;
@endphp

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-[70vh] flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(15,33,9,0.6) 0%, rgba(15,33,9,0.55) 55%, rgba(15,33,9,0.85) 100%), url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1600&h=900&fit=crop&auto=format'); background-size: cover; background-position: center;">
        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">Meet the Team</p>
        <h1 class="font-fraunces text-5xl md:text-7xl text-cream font-normal leading-tight max-w-4xl">
            Orang-orang di balik<br><em class="not-italic">TELF.</em>
        </h1>
        <p class="mt-6 text-white/70 text-base md:text-lg max-w-xl leading-relaxed">
            Tim geospasial, analis, dan peneliti yang mengubah data satelit menjadi alat bantu pemantauan hutan yang dapat ditelusuri.
        </p>
    </section>

    {{-- Team grid --}}
    <section class="max-w-7xl mx-auto px-6 py-24">
        @if ($members->isEmpty())
            <p class="text-center text-bark/60">Belum ada anggota tim.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($members as $member)
                    <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                        <div class="aspect-[4/5] overflow-hidden bg-forest/10">
                            @if ($img($member->photo))
                                <img src="{{ $img($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-forest/30 text-4xl font-fraunces">{{ strtoupper(mb_substr($member->name, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-fraunces text-xl text-forest">{{ $member->name }}</h3>
                            @if ($member->role)
                                <p class="text-lime text-sm font-semibold mt-1">{{ $member->role }}</p>
                            @endif
                            @if ($member->bio)
                                <p class="text-bark/70 text-sm leading-relaxed mt-3">{{ $member->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection