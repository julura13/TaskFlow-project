@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-3']) }}>
        {{ $status }}
    </div>
@endif
