@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-lg border-emerald-200 shadow-sm focus:border-emerald-600 focus:ring-emerald-500']) }}>
