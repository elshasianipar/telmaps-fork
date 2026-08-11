<div class="max-w-4xl mx-auto px-5 md:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5C6770]">Konten · Tentang</p>
            <h2 class="font-fraunces text-2xl text-[#14181A] mt-0.5">Tentang</h2>
        </div>
        <button type="button" wire:click="save" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1C3A14] text-cream text-sm font-semibold rounded-full hover:bg-[#0F2109] transition-colors disabled:opacity-50">
            <svg wire:loading wire:target="save" class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4"/></svg>
            Simpan
        </button>
    </div>

    @if ($successMessage)
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3500)"
             class="mb-6 rounded-xl bg-[#1C3A14]/8 border border-[#1C3A14]/25 px-4 py-3 text-sm text-[#1C3A14] font-medium">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit="save" x-data="{ lang: 'id' }" class="space-y-8">

        {{-- Language tabs --}}
        <div class="flex items-center gap-2">
            <button type="button" @click="lang = 'id'"
                    :class="lang === 'id' ? 'bg-[#1C3A14] text-cream' : 'text-[#5C6770] hover:text-[#14181A] border border-[#E3E6E4]'"
                    class="font-jetbrains-mono text-[10px] uppercase tracking-[0.16em] rounded-full px-3 py-1.5 transition-colors">
                Bahasa Indonesia
            </button>
            <button type="button" @click="lang = 'en'"
                    :class="lang === 'en' ? 'bg-[#1C3A14] text-cream' : 'text-[#5C6770] hover:text-[#14181A] border border-[#E3E6E4]'"
                    class="font-jetbrains-mono text-[10px] uppercase tracking-[0.16em] rounded-full px-3 py-1.5 transition-colors">
                English
            </button>
            <span class="ml-auto font-jetbrains-mono text-[10px] text-[#9AA3A0]">dua bahasa · ID wajib</span>
        </div>

        {{-- Hero --}}
        <section class="bg-white rounded-2xl border border-[#E3E6E4] p-6 md:p-8">
            <h3 class="font-fraunces text-lg text-[#14181A] mb-5">Bagian Hero</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Eyebrow</label>
                    <input x-show="lang === 'id'" wire:model="hero_eyebrow" type="text" placeholder="About TELF"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    <input x-show="lang === 'en'" x-cloak wire:model="hero_eyebrow_en" type="text" placeholder="About TELF (EN)"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Judul Hero</label>
                    <input x-show="lang === 'id'" wire:model="hero_title" type="text" placeholder="We cultivate more than just plants."
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    <input x-show="lang === 'en'" x-cloak wire:model="hero_title_en" type="text" placeholder="Hero title (EN)"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Subjudul</label>
                    <textarea x-show="lang === 'id'" wire:model="hero_subtitle" rows="3" placeholder="Paragraf pengantar singkat…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                    <textarea x-show="lang === 'en'" x-cloak wire:model="hero_subtitle_en" rows="3" placeholder="Short intro paragraph (EN)…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Gambar Hero</label>
                    @if ($hero_image)
                        <img src="{{ str_starts_with($hero_image, 'http') ? $hero_image : asset('storage/'.$hero_image) }}" alt="hero" class="w-full h-40 object-cover rounded-lg mb-2 border border-[#E3E6E4]">
                    @endif
                    <input wire:model="hero_image_upload" type="file" accept="image/*"
                           class="text-sm text-[#5C6770] file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-[#1C3A14]/10 file:text-[#1C3A14] file:text-xs file:font-medium file:cursor-pointer">
                </div>
            </div>
        </section>

        {{-- Our story --}}
        <section class="bg-white rounded-2xl border border-[#E3E6E4] p-6 md:p-8">
            <h3 class="font-fraunces text-lg text-[#14181A] mb-5">Cerita Kami</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Eyebrow</label>
                    <input x-show="lang === 'id'" wire:model="story_eyebrow" type="text" placeholder="Our story"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    <input x-show="lang === 'en'" x-cloak wire:model="story_eyebrow_en" type="text" placeholder="Our story (EN)"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Judul</label>
                    <input x-show="lang === 'id'" wire:model="story_title" type="text" placeholder="Since 2008…"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                    <input x-show="lang === 'en'" x-cloak wire:model="story_title_en" type="text" placeholder="Story title (EN)"
                           class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Isi Cerita</label>
                    <textarea x-show="lang === 'id'" wire:model="story_body" rows="4" placeholder="Paragraf cerita…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                    <textarea x-show="lang === 'en'" x-cloak wire:model="story_body_en" rows="4" placeholder="Story paragraph (EN)…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Gambar Cerita</label>
                    @if ($story_image)
                        <img src="{{ str_starts_with($story_image, 'http') ? $story_image : asset('storage/'.$story_image) }}" alt="story" class="w-full h-40 object-cover rounded-lg mb-2 border border-[#E3E6E4]">
                    @endif
                    <input wire:model="story_image_upload" type="file" accept="image/*"
                           class="text-sm text-[#5C6770] file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-[#1C3A14]/10 file:text-[#1C3A14] file:text-xs file:font-medium file:cursor-pointer">
                </div>
            </div>
        </section>

        {{-- Mission & Vision --}}
        <section class="bg-white rounded-2xl border border-[#E3E6E4] p-6 md:p-8">
            <h3 class="font-fraunces text-lg text-[#14181A] mb-5">Misi &amp; Visi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Misi</label>
                    <textarea x-show="lang === 'id'" wire:model="mission" rows="4" placeholder="Pernyataan misi…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                    <textarea x-show="lang === 'en'" x-cloak wire:model="mission_en" rows="4" placeholder="Mission statement (EN)…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#5C6770] mb-1.5">Visi</label>
                    <textarea x-show="lang === 'id'" wire:model="vision" rows="4" placeholder="Pernyataan visi…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                    <textarea x-show="lang === 'en'" x-cloak wire:model="vision_en" rows="4" placeholder="Vision statement (EN)…"
                              class="w-full rounded-lg border border-[#E3E6E4] bg-[#F4F6F5] px-3 py-2.5 text-sm focus:border-[#1C3A14] focus:ring-2 focus:ring-[#1C3A14]/20 outline-none"></textarea>
                </div>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#1C3A14] text-cream text-sm font-semibold rounded-full hover:bg-[#0F2109] transition-colors disabled:opacity-50">
                Simpan Perubahan
            </button>
        </div>
    </form>

    @push('scripts')
        <style>[x-cloak]{display:none!important}</style>
    @endpush
</div>
