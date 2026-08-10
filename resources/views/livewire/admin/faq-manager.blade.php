<div class="max-w-4xl mx-auto px-5 md:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50">Konten Halaman</p>
            <h2 class="font-fraunces text-2xl text-forest mt-0.5">FAQ</h2>
        </div>
        <button type="button" wire:click="create"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">
            + Tambah Item
        </button>
    </div>

    @if ($successMessage)
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3500)"
             class="mb-5 rounded-xl bg-lime/15 border border-lime/40 px-4 py-3 text-sm text-forest font-medium">
            {{ $successMessage }}
        </div>
    @endif

    <div class="space-y-3">
        @forelse ($items as $item)
            <div class="bg-white rounded-2xl border border-forest/15 p-5">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            @if ($item->category)
                                <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.15em] text-bark/50 bg-cream px-2 py-0.5 rounded">{{ $item->category }}</span>
                            @endif
                            <span class="font-jetbrains-mono text-[10px] text-bark/40">#{{ $item->sort_order }}</span>
                        </div>
                        <h3 class="font-fraunces text-base text-forest">{{ $item->question }}</h3>
                        <p class="text-sm text-bark/70 leading-relaxed mt-1.5 line-clamp-2">{{ $item->answer }}</p>
                    </div>
                    <div class="flex flex-col items-end gap-2 shrink-0">
                        <button wire:click="toggleActive({{ $item->id }})" type="button"
                                class="inline-block w-9 h-5 rounded-full transition-colors {{ $item->is_active ? 'bg-lime' : 'bg-forest/20' }}">
                            <span class="block w-4 h-4 bg-white rounded-full transition-transform {{ $item->is_active ? 'translate-x-4' : 'translate-x-0.5' }}"></span>
                        </button>
                        <div class="flex gap-3 text-xs">
                            <button wire:click="edit({{ $item->id }})" type="button" class="text-forest/70 hover:text-forest font-medium">Edit</button>
                            <button wire:click="confirmDelete({{ $item->id }})" type="button" class="text-loss/70 hover:text-loss font-medium">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-forest/15 p-12 text-center text-bark/50 text-sm">
                Belum ada item FAQ. Klik <strong>Tambah Item</strong>.
            </div>
        @endforelse
    </div>
</div>

{{-- Modal form --}}
@if ($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:keydown.escape.window="showModal = false">
        <div class="absolute inset-0 bg-ink/50" wire:click="showModal = false"></div>
        <div class="relative w-full max-w-lg bg-cream rounded-2xl border border-forest/20 shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-forest/15">
                <h3 class="font-fraunces text-lg text-forest">{{ $editingId ? 'Edit Item' : 'Tambah Item FAQ' }}</h3>
                <button wire:click="showModal = false" type="button" class="text-bark/50 hover:text-forest text-xl leading-none">&times;</button>
            </div>
            <form wire:submit="save" class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-bark/70 mb-1.5">Pertanyaan *</label>
                    <input wire:model="question" type="text" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                    @error('question') <p class="text-loss text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-bark/70 mb-1.5">Jawaban *</label>
                    <textarea wire:model="answer" rows="5" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none"></textarea>
                    @error('answer') <p class="text-loss text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-bark/70 mb-1.5">Kategori</label>
                        <input wire:model="category" type="text" placeholder="Umum" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-bark/70 mb-1.5">Urutan</label>
                        <input wire:model="sort_order" type="number" min="0" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input wire:model="is_active" type="checkbox" class="accent-lime w-4 h-4"> Tampilkan di situs
                </label>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="showModal = false" class="px-4 py-2 text-sm text-bark/70 hover:text-forest">Batal</button>
                    <button type="submit" wire:loading.attr="disabled"
                            class="px-5 py-2 bg-forest text-cream text-sm font-semibold rounded-full hover:bg-forest-dark transition-colors disabled:opacity-50">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

{{-- Delete confirm --}}
@if ($confirmingDelete)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-ink/50"></div>
        <div class="relative w-full max-w-sm bg-cream rounded-2xl border border-forest/20 shadow-2xl p-6 text-center">
            <p class="font-fraunces text-lg text-forest mb-2">Hapus item ini?</p>
            <p class="text-sm text-bark/70 mb-5">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button wire:click="confirmingDelete = false" type="button" class="px-4 py-2 text-sm text-bark/70 hover:text-forest">Batal</button>
                <button wire:click="delete" type="button" class="px-5 py-2 bg-loss text-cream text-sm font-semibold rounded-full hover:bg-[#b13d1f] transition-colors">Hapus</button>
            </div>
        </div>
    </div>
@endif