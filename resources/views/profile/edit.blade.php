<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-emerald-950">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl border border-emerald-100 bg-white/90 p-4 shadow-lg shadow-emerald-950/5 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl border border-blue-100 bg-white/90 p-4 shadow-lg shadow-blue-950/5 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl border border-yellow-200 bg-white/90 p-4 shadow-lg shadow-yellow-950/5 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
