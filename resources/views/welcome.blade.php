<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SIABKEK | Absensi dan Perizinan Santri</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="islamic-app-shell min-h-screen font-sans text-slate-800 antialiased">
        <div class="mx-auto flex min-h-screen max-w-7xl flex-col px-4 sm:px-6 lg:px-8">
            <header class="flex items-center justify-between py-6">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <x-application-logo class="size-11 fill-current text-emerald-700" />
                    <span class="font-bold tracking-[0.16em] text-emerald-950">SIABKEK</span>
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-emerald-800 transition hover:bg-emerald-50">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:ring-2 focus:ring-yellow-400">Daftar sebagai wali</a>
                </div>
            </header>

            <main class="flex flex-1 flex-col justify-center pb-12">
                <section class="relative isolate overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-950 via-emerald-900 to-blue-950 px-6 py-14 text-white shadow-2xl shadow-emerald-950/15 sm:px-12 lg:px-16 lg:py-20">
                    <div class="islamic-geometry pointer-events-none absolute inset-0 -z-10 opacity-30"></div>
                    <div class="pointer-events-none absolute -right-16 -top-24 size-80 rounded-full border border-yellow-200/20"></div>
                    <div class="pointer-events-none absolute -right-5 -top-12 size-56 rounded-full border border-yellow-200/15"></div>
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center gap-2 rounded-full border border-yellow-300/40 bg-yellow-300/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-yellow-200">
                            <span class="size-2 rounded-full bg-yellow-300"></span>
                            Amanah · Tertib · Terhubung
                        </span>
                        <h1 class="mt-6 text-4xl font-semibold leading-tight tracking-tight sm:text-5xl lg:text-6xl">Menjaga kabar, merawat kepercayaan.</h1>
                        <p class="mt-6 max-w-2xl text-base leading-7 text-emerald-100 sm:text-lg">
                            Pantau absensi dan perizinan santri dengan mudah. Satu ruang yang membantu pengurus dan wali tetap terhubung dalam mendampingi perjalanan belajar.
                        </p>
                        <div class="mt-9 flex flex-wrap gap-3">
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-yellow-400 px-6 py-3 font-semibold text-emerald-950 shadow-lg shadow-yellow-950/20 transition hover:bg-yellow-300 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-900">
                                Masuk ke SIABKEK
                                <span aria-hidden="true" class="ml-2">→</span>
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center rounded-xl border border-white/25 bg-white/10 px-6 py-3 font-semibold text-white transition hover:bg-white/15 focus:ring-2 focus:ring-yellow-300">
                                Daftar sebagai wali santri
                            </a>
                        </div>
                    </div>
                    <div class="mt-14 grid gap-4 sm:grid-cols-3">
                        <article class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <span class="text-sm font-semibold text-yellow-200">01 · Kehadiran</span>
                            <h2 class="mt-2 font-semibold text-white">Absensi tercatat</h2>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Riwayat keluar dan masuk santri tersusun rapi.</p>
                        </article>
                        <article class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <span class="text-sm font-semibold text-sky-200">02 · Komunikasi</span>
                            <h2 class="mt-2 font-semibold text-white">Wali tetap terhubung</h2>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Informasi anak dapat dipantau dalam satu tempat.</p>
                        </article>
                        <article class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <span class="text-sm font-semibold text-yellow-200">03 · Perizinan</span>
                            <h2 class="mt-2 font-semibold text-white">Proses lebih tertib</h2>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Jadwal dan status izin mudah ditinjau pengurus.</p>
                        </article>
                    </div>
                </section>
            </main>

            <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-emerald-100 py-5 text-xs text-slate-500">
                <span>SIABKEK · Sistem informasi absensi dan perizinan santri</span>
                <span class="font-medium text-emerald-800">Mendampingi tumbuh dalam kebaikan</span>
            </footer>
        </div>
    </body>
</html>
