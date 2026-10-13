<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-lg border border-transparent bg-emerald-700 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white shadow-sm transition duration-150 ease-in-out hover:bg-emerald-800 focus:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 active:bg-emerald-900']) }}>
    {{ $slot }}
</button>
