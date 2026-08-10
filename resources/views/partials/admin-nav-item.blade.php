@php
    $active = request()->routeIs($route);
@endphp
<a href="{{ route($route) }}"
   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ $active ? 'bg-lime/15 text-lime' : 'text-cream/70 hover:text-cream hover:bg-cream/5' }}">
    <span class="w-4 text-center">
        @if ($icon === 'info') ℹ
        @elseif ($icon === 'users') 👥
        @elseif ($icon === 'question') ?
        @else •
        @endif
    </span>
    {{ $label }}
</a>