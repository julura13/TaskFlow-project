<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-taskflow-dark border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-taskflow-dark focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
