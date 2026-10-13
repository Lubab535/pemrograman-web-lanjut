@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-emerald-950']) }}>
    {{ $value ?? $slot }}
</label>
