@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark placeholder-gray-400 focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none transition']) }}>
