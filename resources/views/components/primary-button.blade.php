<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-taskflow-red border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-taskflow-red focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
