<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-emerald-950">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-white/90 shadow-lg shadow-emerald-950/5">
                <div class="border-l-4 border-yellow-400 p-6 text-emerald-950">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
