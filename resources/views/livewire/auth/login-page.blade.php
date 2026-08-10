<div class="w-full max-w-sm">
    <div class="bg-cream text-forest rounded-2xl border border-cream/10 shadow-2xl p-7">
        <h1 class="font-fraunces text-2xl text-forest">Masuk</h1>
        <p class="text-sm text-bark/70 mt-1">Akses panel admin TELF.</p>

        <form wire:submit="login" class="mt-6 space-y-4">
            <div>
                <label for="email" class="block text-xs font-medium text-bark/70 mb-1.5">Email</label>
                <input id="email" wire:model="email" type="email" autocomplete="email" autofocus
                       class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                @error('email') <p class="text-loss text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-medium text-bark/70 mb-1.5">Kata Sandi</label>
                <input id="password" wire:model="password" type="password" autocomplete="current-password"
                       class="w-full rounded-lg border border-forest/20 bg-white px-3 py-2.5 text-sm focus:border-lime focus:ring-lime/30 focus:ring-2 outline-none">
                @error('password') <p class="text-loss text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-bark/80">
                <input wire:model="remember" type="checkbox" class="accent-lime w-4 h-4"> Ingat saya
            </label>

            <button type="submit" wire:loading.attr="disabled"
                    class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-forest text-cream text-sm font-semibold rounded-full hover:bg-forest-dark transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="login">Masuk</span>
                <svg wire:loading wire:target="login" class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4"/></svg>
            </button>
        </form>

        <p class="text-sm text-bark/70 mt-5 text-center">
            Belum punya akun? <a href="{{ route('register') }}" class="text-forest font-medium hover:text-sage transition-colors">Daftar</a>
        </p>
    </div>

    <a href="{{ route('home') }}" class="block text-center text-cream/50 text-xs mt-5 hover:text-lime transition-colors">← Kembali ke beranda</a>
</div>