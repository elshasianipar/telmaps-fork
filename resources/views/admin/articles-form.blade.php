@extends('layouts.admin', ['header' => $mode === 'edit' ? 'Edit artikel' : 'Artikel baru'])

@section('title', ($mode === 'edit' ? 'Edit' : 'Buat') . ' artikel · Pos Dinas TELF')

@section('content')
@php
    $isEdit = $mode === 'edit';
    $a = $article ?? null;
    $sec = request()->routeIs('editor.*') ? 'editor' : 'admin';
    $img = $isEdit && $a?->featured_image ? asset('storage/' . $a->featured_image) : null;
@endphp

<div class="max-w-5xl mx-auto px-5 md:px-8 py-8" x-data="{
        lang: 'id',
        slug: '{{ old('slug', $isEdit ? $a?->slug : '') }}',
        title: '{{ old('title', $isEdit ? $a?->title : '') }}',
        preview: '{{ $img ?? '' }}',
        editors: {},
        initEditors() {
            this.$nextTick(() => this.initEditor('content'));
        },
        initEditor(id) {
            if (this.editors[id] || ! document.getElementById(id)) return;
            this.editors[id] = true;
            tinymce.init({
                selector: '#' + id,
                license_key: 'gpl',
                skin_url: '/tinymce/skins/ui/oxide',
                content_css: '/tinymce/skins/content/default/content.css',
                height: 420,
                menubar: false,
                branding: false,
                promotion: false,
                plugins: 'autolink lists link code',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | bullist numlist | link | code',
            });
        },
        setLang(next) {
            this.lang = next;
            this.$nextTick(() => {
                const id = next === 'id' ? 'content' : 'content_en';
                this.initEditor(id);
                window.dispatchEvent(new Event('resize'));
            });
        },
        saveAll() {
            tinymce.triggerSave();
        },
        slugify(s) {
            return (s || '').toString().toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '').trim()
                .replace(/\s+/g, '-').replace(/-+/g, '-');
        },
        onImage(e) {
            const f = e.target.files[0];
            if (f) this.preview = URL.createObjectURL(f);
        }
    }" x-init="initEditors">

    {{-- Header --}}
    <div class="flex items-end justify-between gap-4 mb-6">
        <div>
            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5C6770]">
                Artikel · {{ $isEdit ? 'Edit' : 'Baru' }}
            </p>
            <h2 class="font-fraunces text-2xl text-[#14181A] mt-0.5">{{ $isEdit ? 'Edit artikel' : 'Artikel baru' }}</h2>
        </div>
        <a href="{{ route($sec . '.articles.index') }}" class="text-sm text-[#5C6770] hover:text-[#14181A]">← Kembali</a>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-[#C84A26]/8 border border-[#C84A26]/30 px-4 py-3 text-sm text-[#C84A26]">
            Periksa kembali field yang ditandai.
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route($sec . '.articles.update', $a) : route($sec . '.articles.store') }}"
          enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-5 items-start" x-on:submit="saveAll">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        {{-- Main: bilingual content --}}
        <div class="bg-white rounded-2xl border border-[#E3E6E4] p-6 md:p-7 space-y-5">
            {{-- Language tabs --}}
            <div class="flex items-center gap-2 border-b border-[#E3E6E4] pb-4">
                <button type="button" @click="setLang('id')"
                        :class="lang === 'id' ? 'bg-[#1C3A14] text-cream' : 'text-[#5C6770] hover:text-[#14181A] border border-[#E3E6E4]'"
                        class="font-jetbrains-mono text-[10px] uppercase tracking-[0.16em] rounded-full px-3 py-1.5 transition-colors">
                    Bahasa Indonesia
                </button>
                <button type="button" @click="setLang('en')"
                        :class="lang === 'en' ? 'bg-[#1C3A14] text-cream' : 'text-[#5C6770] hover:text-[#14181A] border border-[#E3E6E4]'"
                        class="font-jetbrains-mono text-[10px] uppercase tracking-[0.16em] rounded-full px-3 py-1.5 transition-colors">
                    English
                </button>
                <span class="ml-auto font-jetbrains-mono text-[10px] text-[#9AA3A0]">dua bahasa · ID wajib</span>
            </div>

            {{-- ID fields --}}
            <div x-show="lang === 'id'" x-cloak class="space-y-5">
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Judul <span class="text-[#C84A26]">*</span></label>
                    <input type="text" name="title" x-model="title" value="{{ old('title', $isEdit ? $a?->title : '') }}"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    @error('title') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Deskripsi</label>
                    <textarea name="excerpt" rows="3" placeholder="Ringkasan singkat untuk kartu…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">{{ old('excerpt', $isEdit ? $a?->excerpt : '') }}</textarea>
                    @error('excerpt') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Isi artikel <span class="text-[#9AA3A0]">opsional · tampil di halaman detail</span></label>
                    <textarea id="content" name="content" rows="6" placeholder="Tulis isi lengkap…"
                              class="mt-2 w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">{{ old('content', $isEdit ? ($isEdit ? $a?->content : '') : '') }}</textarea>
                    @error('content') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- EN fields --}}
            <div x-show="lang === 'en'" x-cloak class="space-y-5">
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Title <span class="text-[#9AA3A0]">(English)</span></label>
                    <input type="text" name="title_en" value="{{ old('title_en', $isEdit ? $a?->title_en : '') }}"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    @error('title_en') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Description <span class="text-[#9AA3A0]">(English)</span></label>
                    <textarea name="excerpt_en" rows="3" placeholder="Short summary for the card…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">{{ old('excerpt_en', $isEdit ? $a?->excerpt_en : '') }}</textarea>
                    @error('excerpt_en') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Article body <span class="text-[#9AA3A0]">optional · shown on detail page</span></label>
                    <textarea id="content_en" name="content_en" rows="6" placeholder="Write the full body…"
                              class="mt-2 w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">{{ old('content_en', $isEdit ? $a?->content_en : '') }}</textarea>
                    @error('content_en') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Slug (shared) --}}
            <div class="border-t border-[#E3E6E4] pt-5">
                <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Slug <span class="text-[#C84A26]">*</span></label>
                <div class="flex gap-2">
                    <input type="text" name="slug" x-model="slug" value="{{ old('slug', $isEdit ? $a?->slug : '') }}"
                           class="flex-1 rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm font-jetbrains-mono focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    <button type="button" @click="slug = slugify(title)"
                            class="shrink-0 font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] text-[#1C3A14] border border-[#1C3A14]/30 rounded-lg px-3 hover:bg-[#1C3A14]/8 transition-colors">
                        Otomatis
                    </button>
                </div>
                <p class="font-jetbrains-mono text-[10px] text-[#9AA3A0] mt-1.5">/articles/<span x-text="slug || '…'"></span></p>
                @error('slug') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Side: image, link, status, publish --}}
        <div class="space-y-5">
            {{-- Image --}}
            <div class="bg-white rounded-2xl border border-[#E3E6E4] p-5">
                <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-[#5C6770] mb-3">Gambar</p>
                <div x-show="preview" x-cloak class="mb-3">
                    <img :src="preview" x-show="preview" alt="pratinjau" class="w-full h-40 object-cover rounded-lg border border-[#E3E6E4]">
                </div>
                <div x-show="!preview" x-cloak class="mb-3 h-40 rounded-lg border border-dashed border-[#E3E6E4] flex items-center justify-center text-[#9AA3A0] text-xs">
                    Tanpa gambar
                </div>
                <input type="file" name="featured_image" accept="image/png,image/jpeg,image/webp" @change="onImage($event)"
                       class="text-xs text-[#5C6770] file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-[#1C3A14]/10 file:text-[#1C3A14] file:text-xs file:font-medium file:cursor-pointer">
                @error('featured_image') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Link --}}
            <div class="bg-white rounded-2xl border border-[#E3E6E4] p-5">
                <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-[#5C6770] mb-3">Tautan eksternal</p>
                <input type="url" name="link" value="{{ old('link', $isEdit ? $a?->link : '') }}" placeholder="https://…"
                       class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm font-jetbrains-mono focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                <p class="font-jetbrains-mono text-[10px] text-[#9AA3A0] mt-1.5">Kosongkan untuk pakai halaman detail.</p>
                @error('link') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status + publish --}}
            <div class="bg-white rounded-2xl border border-[#E3E6E4] p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Status</label>
                    <select name="status"
                            class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                        @php $cur = old('status', $isEdit ? $a?->status : 'draft'); @endphp
                        @foreach (['draft' => 'Draft', 'published' => 'Dipublikasikan', 'archived' => 'Diarsipkan'] as $val => $lbl)
                            <option value="{{ $val }}" @selected($cur === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Terbit pada</label>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', $isEdit && $a?->published_at ? $a->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm font-jetbrains-mono focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    @error('published_at') <p class="text-[#C84A26] text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <a href="{{ route($sec . '.articles.index') }}" class="flex-1 text-center px-4 py-2.5 text-sm text-[#5C6770] hover:text-[#14181A] border border-[#E3E6E4] rounded-full transition-colors">Batal</a>
                <button type="submit" class="flex-1 px-5 py-2.5 bg-[#1C3A14] text-cream text-sm font-semibold rounded-full hover:bg-[#0F2109] transition-colors">
                    {{ $isEdit ? 'Simpan' : 'Terbitkan' }}
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <style>[x-cloak]{display:none!important}</style>
@endpush
@endsection