@extends('layouts.landing')

@section('title', config('app.name', 'Garden Tree') . ' · Teams')

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-[70vh] flex flex-col items-center justify-center text-center px-6 pt-20" style="background-image: linear-gradient(to bottom, rgba(15,33,9,0.6) 0%, rgba(15,33,9,0.55) 55%, rgba(15,33,9,0.85) 100%), url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1600&h=900&fit=crop&auto=format'); background-size: cover; background-position: center;">
        <p class="text-lime text-sm font-medium tracking-widest uppercase mb-4">Meet the Team</p>
        <h1 class="font-fraunces text-5xl md:text-7xl text-cream font-normal leading-tight max-w-4xl">
            The people behind<br><em class="not-italic">the greenery.</em>
        </h1>
        <p class="mt-6 text-white/70 text-base md:text-lg max-w-xl leading-relaxed">
            A passionate crew of horticulturists, designers, and caretakers who turn every project into a living, thriving space.
        </p>
    </section>

    {{-- Team grid --}}
    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?w=600&h=750&fit=crop&auto=format" alt="Portrait of Sarah Mitchell" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="font-fraunces text-xl text-forest">Sarah Mitchell</h3>
                    <p class="text-lime text-sm font-semibold mt-1">Founder &amp; Lead Designer</p>
                    <p class="text-bark/70 text-sm leading-relaxed mt-3">Founded Garden Tree in 2008 with a passion for native planting and thoughtful, sustainable landscape design.</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=750&fit=crop&auto=format" alt="Portrait of David Chen" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="font-fraunces text-xl text-forest">David Chen</h3>
                    <p class="text-lime text-sm font-semibold mt-1">Head Horticulturist</p>
                    <p class="text-bark/70 text-sm leading-relaxed mt-3">Oversees planting health, seasonal strategies, and our native plant nursery across all projects.</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&h=750&fit=crop&auto=format" alt="Portrait of Amelia Rodriguez" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="font-fraunces text-xl text-forest">Amelia Rodriguez</h3>
                    <p class="text-lime text-sm font-semibold mt-1">Landscape Architect</p>
                    <p class="text-bark/70 text-sm leading-relaxed mt-3">Blends ecology with aesthetics, turning client conversations into resilient, season-proof outdoor spaces.</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=750&fit=crop&auto=format" alt="Portrait of James Okafor" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="font-fraunces text-xl text-forest">James Okafor</h3>
                    <p class="text-lime text-sm font-semibold mt-1">Project Manager</p>
                    <p class="text-bark/70 text-sm leading-relaxed mt-3">Keeps every project on schedule and on budget with clear milestones and open communication.</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=600&h=750&fit=crop&auto=format" alt="Portrait of Priya Sharma" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="font-fraunces text-xl text-forest">Priya Sharma</h3>
                    <p class="text-lime text-sm font-semibold mt-1">Sustainability Specialist</p>
                    <p class="text-bark/70 text-sm leading-relaxed mt-3">Champions native plant palettes, responsible water use, and design choices that support local biodiversity.</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl border border-forest/15 overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=750&fit=crop&auto=format" alt="Portrait of Elena Petrova" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="font-fraunces text-xl text-forest">Elena Petrova</h3>
                    <p class="text-lime text-sm font-semibold mt-1">Customer Care Lead</p>
                    <p class="text-bark/70 text-sm leading-relaxed mt-3">The friendly voice of Garden Tree, guiding clients from first consultation to long-term care.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
