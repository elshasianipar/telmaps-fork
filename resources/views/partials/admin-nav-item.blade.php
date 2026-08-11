@php
    $active = request()->routeIs($route);
@endphp
<a href="{{ route($route) }}"
   class="relative flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ $active ? 'bg-cream/10 text-lime' : 'text-cream/60 hover:text-cream hover:bg-cream/5' }}">
    <span class="absolute left-0 top-1.5 bottom-1.5 w-0.5 rounded-full bg-lime transition-opacity {{ $active ? 'opacity-100' : 'opacity-0' }}"></span>
    <span class="w-4 text-center font-jetbrains-mono text-[12px] leading-none">
        @if ($icon === 'info') ℹ
        @elseif ($icon === 'users') 👥
        @elseif ($icon === 'question') ?
        @elseif ($icon === 'article') ▤
        @else •
        @endif
    </span>
    {{ $label }}
</a>