<div class="max-w-5xl mx-auto px-5 md:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50">Konten Halaman</p>
            <h2 class="font-fraunces text-2xl text-forest mt-0.5">Tim</h2>
        </div>
        <button type="button" wire:click="create"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-lime text-forest text-sm font-semibold rounded-full hover:bg-[#d8ea5a] transition-colors">
            + Tambah Anggota
        </button>
    </div>

    @if ($successMessage)
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3500)"
             class="mb-5 rounded-xl bg-lime/15 border border-lime/40 px-4 py-3 text-sm text-forest font-medium">
            {{ $successMessage }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-forest/15 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-cream/60 text-left font-jetbrains-mono text-[10px] uppercase tracking-[0.15em] text-bark/60">
                <tr>
                    <th class="px-5 py-3">Anggota</th>
                    <th class="px-5 py-3 hidden md:table-cell">Peran</th>
                    <th class="px-5 py-3 text-center">Urut</th>
                    <th class="px-5 py-3 text-center">Aktif</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-forest/10">
                @forelse ($members as $member)
                    <tr class="hover:bg-cream/30">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if ($member->photo)
                                    <img src="{{ str_starts_with($member->photo, 'http') ? $member->photo : asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" class="w-9 h-9 rounded-full object-cover border border-forest/15">
                                @else
                                    <span class="w-9 h-9 rounded-full bg-forest/10 text-forest flex items-center justify-center text-xs font-medium">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                @endif
                                <div class="min-w-0">
                                    <div class="font-medium text-forest truncate">{{ $member->name }}</div>
                                    <div class="text-xs text-bark/60 md:hidden truncate">{{ $member->role }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 hidden md:table-cell text-bark/70">{{ $member->role }}</td>
                        <td class="px-5 py-3 text-center font-jetbrains-mono text-bark/70">{{ $member->sort_order }}</td>
                        <td class="px-5 py-3 text-center">
                            <button wire:click="toggleActive({{ $member->id }})" type="button"
                                    class="inline-block w-9 h-5 rounded-full transition-colors {{ $member->is_active ? 'bg-lime' : 'bg-forest/20' }}">
                                <span class="block w-4 h-4 bg-white rounded-full transition-transform {{ $member->is_active ? 'translate-x-4' : 'translate-x-0.5' }}"></span>
                            </button>
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <button wire:click="edit({{ $member->id }})" type="button" class="text-forest/70 hover:text-forest text-xs font-medium mr-3">Edit</button>
                            <button wire:click="confirmDelete({{ $member->id }})" type="button" class="text-loss/70 hover:text-loss text-xs font-medium">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-12 text-center text-bark/50 text-sm">Belum ada anggota tim. Klik <strong>Tambah Anggota</strong>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal form --}}
@if ($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:keydown.escape.window="showModal = false">
        <div class="absolute inset-0 bg-ink/50" wire:click="showModal = false"></div>
        <div class="relative w-full max-w-lg bg-cream rounded-2xl border border-forest/20 shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-forest/15">
                <h3 class="font-fraunces text-lg text-forest">{{ $editingId ? 'Edit Anggota' : 'Tambah Anggota' }}</h3>
                <button wire:click="showModal = false" type="button" class="text-bark/50 hover:text-forest text-xl leading-none">&times;</button>
            </div>
            <form wire:submit="save" class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-bark/70 mb-1.5">Nama *</label>
                    <input wire:model="name" type="text" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                    @error('name') <p class="text-loss text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-bark/70 mb-1.5">Peran / Jabatan</label>
                    <input wire:model="role" type="text" placeholder="Founder & Lead Designer" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-bark/70 mb-1.5">Bio</label>
                    <textarea wire:model="bio" rows="3" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-bark/70 mb-1.5">Foto</label>
                    @if ($photo)
                        <img src="{{ str_starts_with($photo, 'http') ? $photo : asset('storage/'.$photo) }}" alt="foto" class="w-24 h-24 object-cover rounded-lg mb-2 border border-forest/15">
                    @endif
                    <input wire:model="photo_upload" type="file" accept="image/*"
                           class="text-sm text-bark/70 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-lime/20 file:text-forest file:text-xs file:font-medium">
                    @error('photo_upload') <p class="text-loss text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-bark/70 mb-1.5">Urutan</label>
                        <input wire:model="sort_order" type="number" min="0" class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-bark/70 mb-1.5">Status</label>
                        <label class="flex items-center gap-2 h-[42px] text-sm">
                            <input wire:model="is_active" type="checkbox" class="accent-lime w-4 h-4"> Tampilkan di situs
                        </label>
                    </div>
                </div>
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
            <p class="font-fraunces text-lg text-forest mb-2">Hapus anggota ini?</p>
            <p class="text-sm text-bark/70 mb-5">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button wire:click="confirmingDelete = false" type="button" class="px-4 py-2 text-sm text-bark/70 hover:text-forest">Batal</button>
                <button wire:click="delete" type="button" class="px-5 py-2 bg-loss text-cream text-sm font-semibold rounded-full hover:bg-[#b13d1f] transition-colors">Hapus</button>
            </div>
        </div>
    </div>
@endif