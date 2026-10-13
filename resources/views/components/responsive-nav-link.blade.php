@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-300 text-start text-base font-medium text-yellow-200 bg-white/10 focus:outline-none focus:text-white focus:bg-white/10 focus:border-yellow-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-emerald-100 hover:text-white hover:bg-white/5 hover:border-emerald-300 focus:outline-none focus:text-white focus:bg-white/5 focus:border-emerald-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
