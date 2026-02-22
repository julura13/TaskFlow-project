@props(['padding' => true])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden']) }}>
    @if ($padding)
        <div class="p-6 sm:p-8">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>
