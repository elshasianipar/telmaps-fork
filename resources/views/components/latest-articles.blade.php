@php
    // Pratinjau 3 laporan terbaru yang sudah dipublikasikan. Mengambil langsung
    // dari DB (konsisten dengan halaman publik lain). Kartu mengikuti pola
    // "deck" dengan panel deskripsi bersama yang diperbarui saat hover/focus.
    $articles = \App\Models\Article::published()->latest('published_at')->take(3)->get();
    $lang = $lang ?? 'id';
@endphp

<section id="articles" class="max-w-7xl mx-auto px-6 py-20">
    {{-- Header --}}
    <div class="flex items-end justify-between gap-6 flex-wrap mb-10">
        <div>
            <p class="font-jetbrains-mono text-[11px] uppercase tracking-[0.22em] text-sage">TELF · {{ $lang === 'en' ? 'Stories from the field' : 'Kabar dari lapangan' }}</p>
            <h2 class="font-fraunces text-4xl md:text-5xl text-forest mt-2">{{ $lang === 'en' ? 'Latest field reports' : 'Laporan terbaru dari lapangan' }}</h2>
            <p class="mt-3 text-bark/70 max-w-xl leading-relaxed">
                {{ $lang === 'en'
                    ? 'Notes and context on forest and fire monitoring across Sumatra.'
                    : 'Catatan dan konteks seputar pemantauan hutan dan kebakaran di Sumatera.' }}
            </p>
        </div>

        <a href="{{ route('articles.index') }}?lang={{ $lang }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-forest hover:text-sage transition-colors border-b border-forest/30 pb-1 shrink-0">
            {{ $lang === 'en' ? 'View all articles' : 'Lihat semua artikel' }} <span>&rarr;</span>
        </a>
    </div>

    @if ($articles->isEmpty())
        @include('partials.empty-state', [
            'eyebrow' => $lang === 'en' ? 'Articles' : 'Artikel',
            'title' => $lang === 'en' ? 'No data yet.' : 'Belum ada data.',
            'hint' => $lang === 'en'
                ? 'Field reports will appear here once published.'
                : 'Kabar dari lapangan akan tampil di sini setelah dipublikasikan.',
        ])
    @else
        {{-- Deck of image cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($articles as $i => $article)
                @php
                    $hasLink = filled($article->link);
                    $url = $hasLink ? $article->link : route('articles.show', $article);
                    $desc = $article->excerptFor($lang) ?? $article->titleFor($lang);
                @endphp
                <a href="{{ $url }}" @if($hasLink) target="_blank" rel="noopener noreferrer" @endif
                   data-article-card data-desc="{{ $desc }}"
                   aria-label="{{ $article->titleFor($lang) }}"
                   class="article-card relative overflow-hidden rounded-2xl cursor-pointer group transition-all duration-300 h-[280px] {{ $i === 0 ? 'article-active ring-2 ring-lime' : '' }}">
                    @if ($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->titleFor($lang) }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-forest to-forest-dark"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/80 to-transparent"></div>
                    <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-lg font-light">+</div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-lime/90 mb-1">{{ $article->published_at?->format('Y-m-d') }}</div>
                        <h3 class="text-white font-fraunces text-lg font-normal leading-snug">{{ $article->titleFor($lang) }}</h3>
                    </div>
                </a>
            @endforeach
        </div>

        <script>
            (function () {
                const cards = document.querySelectorAll('[data-article-card]');
                const desc = document.getElementById('article-desc');
                if (!cards.length || !desc) return;

                const activate = (card) => {
                    cards.forEach((c) => c.classList.remove('article-active', 'ring-2', 'ring-lime'));
                    card.classList.add('article-active', 'ring-2', 'ring-lime');
                    desc.textContent = card.dataset.desc;
                };

                cards.forEach((card) => {
                    card.addEventListener('mouseenter', () => activate(card));
                    card.addEventListener('focus', () => activate(card));
                });
            })();
        </script>
    @endif
</section>
