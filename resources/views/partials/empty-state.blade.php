@php
    $eyebrow = $eyebrow ?? null;
    $title = $title ?? 'Belum ada data.';
    $hint = $hint ?? null;
@endphp

{{-- Field-station empty state: a quiet "no readings yet" panel.
     Lime tick = brand accent; mono eyebrow = telemetry vernacular (ties to the
     pos-dinas CMS); fraunces title + bark hint carry the message. Restraint by
     design — emptiness is an invitation, not a showcase. --}}
<div class="bg-white rounded-2xl border border-forest/15 px-8 py-16 text-center">
    <div class="w-8 h-px bg-lime/70 mx-auto" aria-hidden="true"></div>

    @if ($eyebrow)
        <p class="font-jetbrains-mono text-[11px] uppercase tracking-[0.22em] text-sage mt-5">{{ $eyebrow }}</p>
    @endif

    <h2 class="font-fraunces text-2xl md:text-3xl text-forest mt-3">{{ $title }}</h2>

    @if ($hint)
        <p class="text-bark/60 mt-3 text-sm leading-relaxed max-w-md mx-auto">{{ $hint }}</p>
    @endif
</div>