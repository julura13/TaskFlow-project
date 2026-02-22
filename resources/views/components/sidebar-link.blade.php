@props(['active' => false, 'href'])

@php
$classes = $active
    ? 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-taskflow-red/10 text-taskflow-red'
    : 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-taskflow-dark hover:bg-gray-100 hover:text-taskflow-dark';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
