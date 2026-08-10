@extends('layouts.landing')

@section('title', config('app.name', 'Garden Tree') . ' · FAQ')

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-[70vh] flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(15,33,9,0.6) 0%, rgba(15,33,9,0.55) 55%, rgba(15,33,9,0.85) 100%), url('https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=1600&h=900&fit=crop&auto=format'); background-size: cover; background-position: center;">
        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">Frequently Asked Questions</p>
        <h1 class="font-fraunces text-5xl md:text-7xl text-cream font-normal leading-tight max-w-4xl">
            Answers for every<br><em class="not-italic">green thumb.</em>
        </h1>
        <p class="mt-6 text-white/70 text-base md:text-lg max-w-xl leading-relaxed">
            Everything you need to know about working with Garden Tree — from our services and process to maintenance and pricing.
        </p>
    </section>

    {{-- FAQ accordion --}}
    <section id="faq" class="max-w-3xl mx-auto px-6 py-24">
        <div class="faq-item bg-white rounded-2xl border border-forest/15 overflow-hidden">
            <button type="button" class="faq-toggle w-full flex items-center justify-between gap-4 text-left px-6 md:px-8 py-6 cursor-pointer">
                <span class="font-fraunces text-lg md:text-xl text-forest">What services does Garden Tree offer?</span>
                <span class="faq-icon shrink-0 w-8 h-8 rounded-full bg-lime/20 text-forest flex items-center justify-center text-lg transition-transform duration-300">+</span>
            </button>
            <div class="faq-body px-6 md:px-8 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                <p class="text-bark/70 leading-relaxed pb-6">
                    We specialize in native plant nurseries, gardening consultation, and eco-friendly landscaping. From initial design and planting to year-round maintenance, every project is tailored to your site and goals.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white rounded-2xl border border-forest/15 overflow-hidden">
            <button type="button" class="faq-toggle w-full flex items-center justify-between gap-4 text-left px-6 md:px-8 py-6 cursor-pointer">
                <span class="font-fraunces text-lg md:text-xl text-forest">How does the consultation process work?</span>
                <span class="faq-icon shrink-0 w-8 h-8 rounded-full bg-lime/20 text-forest flex items-center justify-center text-lg transition-transform duration-300">+</span>
            </button>
            <div class="faq-body px-6 md:px-8 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                <p class="text-bark/70 leading-relaxed pb-6">
                    Every project begins with a careful survey of your site and a collaborative conversation. We assess sunlight, soil, and water, then present a seasonal strategy so your garden performs beautifully through the year.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white rounded-2xl border border-forest/15 overflow-hidden">
            <button type="button" class="faq-toggle w-full flex items-center justify-between gap-4 text-left px-6 md:px-8 py-6 cursor-pointer">
                <span class="font-fraunces text-lg md:text-xl text-forest">Do you offer ongoing maintenance?</span>
                <span class="faq-icon shrink-0 w-8 h-8 rounded-full bg-lime/20 text-forest flex items-center justify-center text-lg transition-transform duration-300">+</span>
            </button>
            <div class="faq-body px-6 md:px-8 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                <p class="text-bark/70 leading-relaxed pb-6">
                    Yes. After installation we provide strong care and support — seasonal planting, pruning, irrigation checks, and health monitoring — so your landscape stays vibrant long after the project is done.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white rounded-2xl border border-forest/15 overflow-hidden">
            <button type="button" class="faq-toggle w-full flex items-center justify-between gap-4 text-left px-6 md:px-8 py-6 cursor-pointer">
                <span class="font-fraunces text-lg md:text-xl text-forest">Are your services eco-friendly?</span>
                <span class="faq-icon shrink-0 w-8 h-8 rounded-full bg-lime/20 text-forest flex items-center justify-center text-lg transition-transform duration-300">+</span>
            </button>
            <div class="faq-body px-6 md:px-8 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                <p class="text-bark/70 leading-relaxed pb-6">
                    Sustainability is at our core. We prioritize native, drought-tolerant plants, responsible water use, and durable materials — designing resilient landscapes that support local biodiversity.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white rounded-2xl border border-forest/15 overflow-hidden">
            <button type="button" class="faq-toggle w-full flex items-center justify-between gap-4 text-left px-6 md:px-8 py-6 cursor-pointer">
                <span class="font-fraunces text-lg md:text-xl text-forest">How much does a project cost?</span>
                <span class="faq-icon shrink-0 w-8 h-8 rounded-full bg-lime/20 text-forest flex items-center justify-center text-lg transition-transform duration-300">+</span>
            </button>
            <div class="faq-body px-6 md:px-8 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                <p class="text-bark/70 leading-relaxed pb-6">
                    Pricing depends on the size of your space, scope of work, and plant selections. After an initial consultation we provide a clear, detailed estimate — no surprises, ever.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white rounded-2xl border border-forest/15 overflow-hidden">
            <button type="button" class="faq-toggle w-full flex items-center justify-between gap-4 text-left px-6 md:px-8 py-6 cursor-pointer">
                <span class="font-fraunces text-lg md:text-xl text-forest">How long does a typical project take?</span>
                <span class="faq-icon shrink-0 w-8 h-8 rounded-full bg-lime/20 text-forest flex items-center justify-center text-lg transition-transform duration-300">+</span>
            </button>
            <div class="faq-body px-6 md:px-8 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                <p class="text-bark/70 leading-relaxed pb-6">
                    Timelines vary by scope — a garden consultation and planting may take a few weeks, while larger landscape designs can take a season. We set clear milestones so you always know where things stand.
                </p>
            </div>
        </div>
    </section>

    {{-- CTA Banner --}}
@endsection

@section('extra-scripts')
    <script>
        (function () {
            document.querySelectorAll('.faq-item').forEach((item) => {
                const toggle = item.querySelector('.faq-toggle');
                const body = item.querySelector('.faq-body');
                const icon = item.querySelector('.faq-icon');
                toggle.addEventListener('click', () => {
                    const isOpen = item.classList.contains('faq-open');
                    document.querySelectorAll('.faq-item.faq-open').forEach((openItem) => {
                        openItem.classList.remove('faq-open');
                        openItem.querySelector('.faq-body').style.maxHeight = null;
                        openItem.querySelector('.faq-icon').style.transform = '';
                    });
                    if (!isOpen) {
                        item.classList.add('faq-open');
                        body.style.maxHeight = body.scrollHeight + 'px';
                        icon.style.transform = 'rotate(45deg)';
                    }
                });
            });
        })();
    </script>
@endsection
