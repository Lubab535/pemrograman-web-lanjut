<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIABKEK | Absensi dan Perizinan Santri</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="islamic-app-shell font-sans text-slate-900 antialiased">
        <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">
            <div class="islamic-geometry pointer-events-none absolute -right-20 -top-20 size-80 rounded-full opacity-60"></div>
            <div class="islamic-geometry pointer-events-none absolute -bottom-28 -left-20 size-96 rounded-full opacity-40"></div>

            <div class="relative grid w-full max-w-5xl overflow-hidden rounded-3xl border border-emerald-100 bg-white shadow-2xl shadow-emerald-950/10 lg:grid-cols-[0.9fr_1.1fr]">
                <section class="relative hidden flex-col justify-between overflow-hidden bg-gradient-to-br from-emerald-950 via-emerald-900 to-blue-950 p-10 text-white lg:flex">
                    <div class="islamic-geometry absolute inset-0 opacity-30"></div>
                    <div class="relative">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                            <x-application-logo class="size-12 fill-current text-yellow-300" />
                            <span class="text-lg font-bold tracking-[0.16em]">SIABKEK</span>
                        </a>
                    </div>
                    <div class="relative space-y-4">
                        <span class="inline-flex rounded-full border border-yellow-300/40 bg-yellow-300/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-yellow-200">Amanah · Tertib · Terhubung</span>
                        <h1 class="text-3xl font-semibold leading-tight">Informasi pesantren, dalam satu ruang.</h1>
                        <p class="max-w-sm text-sm leading-6 text-emerald-100">Kelola absensi dan perizinan santri dengan lebih mudah, tenang, dan terhubung bersama keluarga.</p>
                    </div>
                    <p class="relative text-xs text-emerald-200/80">Mendampingi tumbuh dalam kebaikan.</p>
                </section>

                <section class="p-6 sm:p-10">
                    <a href="{{ url('/') }}" class="mb-8 inline-flex items-center gap-3 lg:hidden">
                        <x-application-logo class="size-10 fill-current text-emerald-700" />
                        <span class="font-bold tracking-[0.16em] text-emerald-950">SIABKEK</span>
                    </a>
                    {{ $slot }}
                </section>
            </div>
        </main>
    </body>
</html>
