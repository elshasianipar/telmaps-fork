@extends('layouts.admin', ['header' => 'Artikel'])

@section('title', 'Artikel · Pos Dinas TELF')

@section('content')
@php $sec = request()->routeIs('editor.*') ? 'editor' : 'admin'; @endphp
<div class="max-w-5xl mx-auto px-5 md:px-8 py-8">
    {{-- Header --}}
    <div class="flex items-end justify-between gap-4 mb-6">
        <div>
            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5C6770]">Konten · Artikel</p>
            <h2 class="font-fraunces text-2xl text-[#14181A] mt-0.5">Artikel</h2>
        </div>
        <a href="{{ route($sec . '.articles.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1C3A14] text-cream text-sm font-semibold rounded-full hover:bg-[#0F2109] transition-colors">
            + Tambah artikel
        </a>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3500)"
             class="mb-5 rounded-xl bg-[#1C3A14]/8 border border-[#1C3A14]/25 px-4 py-3 text-sm text-[#1C3A14] font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Telemetry stat strip --}}
    <div class="grid grid-cols-4 gap-px bg-[#E3E6E4] rounded-xl overflow-hidden mb-6 border border-[#E3E6E4]">
        @php
            $stats = [
                ['label' => 'TOTAL', 'value' => $counts['total'], 'color' => '#14181A'],
                ['label' => 'LIVE', 'value' => $counts['live'], 'color' => '#2F7A3C'],
                ['label' => 'DRAFT', 'value' => $counts['draft'], 'color' => '#E8A93A'],
                ['label' => 'ARSIP', 'value' => $counts['arsip'], 'color' => '#C84A26'],
            ];
        @endphp
        @foreach ($stats as $s)
            <div class="bg-[#F4F6F5] px-4 py-3">
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full led" style="background:{{ $s['color'] }}; color:{{ $s['color'] }}"></span>
                    <span class="font-jetbrains-mono text-[9px] uppercase tracking-[0.18em] text-[#5C6770]">{{ $s['label'] }}</span>
                </div>
                <div class="font-fraunces text-2xl font-medium mt-1 tabular-nums" style="color:{{ $s['color'] }}">{{ $s['value'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Article rows --}}
    <div class="bg-white rounded-2xl border border-[#E3E6E4] overflow-hidden">
        <div class="hidden md:grid grid-cols-[auto_1fr_auto] items-center gap-4 px-5 py-3 bg-[#F4F6F5] border-b border-[#E3E6E4] font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-[#5C6770]">
            <span class="w-28">Status</span>
            <span>Artikel</span>
            <span class="text-right w-32">Aksi</span>
        </div>

        <div class="divide-y divide-[#E3E6E4]">
            @forelse ($articles as $article)
                <div class="grid grid-cols-1 md:grid-cols-[auto_1fr_auto] items-center gap-3 md:gap-4 px-5 py-4 hover:bg-[#F4F6F5]/60 transition-colors">
                    {{-- Status LED + code --}}
                    <div class="flex items-center gap-2 md:w-28">
                        <span class="w-2 h-2 rounded-full led shrink-0" style="background:{{ $article->status_color }}; color:{{ $article->status_color }}"></span>
                        <span class="font-jetbrains-mono text-[11px] tracking-[0.12em] font-medium" style="color:{{ $article->status_color }}">{{ $article->status_code }}</span>
                    </div>

                    {{-- Title + meta --}}
                    <div class="min-w-0">
                        <div class="flex items-center gap-2.5">
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="" class="w-10 h-10 rounded-md object-cover border border-[#E3E6E4] shrink-0">
                            @endif
                            <div class="min-w-0">
                                <div class="font-medium text-[#14181A] truncate">{{ $article->title }}</div>
                                @if ($article->title_en)
                                    <div class="text-[12px] text-[#5C6770] truncate font-jetbrains-mono">{{ $article->title_en }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-1 font-jetbrains-mono text-[10px] text-[#9AA3A0]">
                            <span>{{ $article->author?->name ?? '—' }}</span>
                            <span class="text-[#E3E6E4]">·</span>
                            <span>{{ $article->published_at?->format('Y-m-d') ?? 'belum terbit' }}</span>
                            @if ($article->link)
                                <span class="text-[#E3E6E4]">·</span>
                                <span class="text-[#2F7A3C]">↗ tautan</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 md:justify-end md:w-32">
                        <a href="{{ route($sec . '.articles.edit', $article) }}" class="text-[12px] font-medium text-[#1C3A14] hover:underline">Edit</a>
                        <form method="POST" action="{{ route($sec . '.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel “{{ addslashes($article->title) }}”? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[12px] font-medium text-[#C84A26] hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <p class="font-fraunces text-lg text-[#14181A]">Belum ada artikel.</p>
                    <p class="text-sm text-[#5C6770] mt-1">Klik <strong class="text-[#1C3A14]">Tambah artikel</strong> untuk membuat yang pertama.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-5">
        {{ $articles->links() }}
    </div>
</div>
@endsection