<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-emerald-950">Dashboard Pengurus Pesantren</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-emerald-100 border-t-4 border-t-emerald-600 bg-white/90 p-6 shadow-lg shadow-emerald-950/5"><p class="text-sm font-medium text-emerald-800">Total santri</p><p class="mt-2 text-3xl font-bold text-emerald-950">{{ $jumlahSantri }}</p></div>
            <div class="rounded-2xl border border-blue-100 border-t-4 border-t-blue-600 bg-white/90 p-6 shadow-lg shadow-blue-950/5"><p class="text-sm font-medium text-blue-800">Izin menunggu</p><p class="mt-2 text-3xl font-bold text-blue-950">{{ $izinMenunggu }}</p></div>
            <div class="rounded-2xl border border-yellow-200 border-t-4 border-t-yellow-400 bg-white/90 p-6 shadow-lg shadow-yellow-950/5"><p class="text-sm font-medium text-amber-800">Sedang di luar</p><p class="mt-2 text-3xl font-bold text-amber-950">{{ $sedangKeluar }}</p></div>
        </div>

        <section class="rounded-2xl border border-emerald-100 bg-white/90 p-6 shadow-lg shadow-emerald-950/5">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-emerald-950">Aktivitas absensi terbaru</h3>
                <div class="flex gap-3">
                    <a class="text-sm font-semibold text-emerald-700 transition hover:text-emerald-950" href="{{ route('pengurus.santris.index') }}">Kelola santri</a>
                    <a class="text-sm font-semibold text-blue-700 transition hover:text-blue-950" href="{{ route('pengurus.perizinans.index') }}">Kelola perizinan</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-emerald-100 bg-emerald-50/70 text-emerald-800"><tr><th class="rounded-l-lg py-3 pl-3">Santri</th><th>Aktivitas</th><th>Petugas</th><th class="rounded-r-lg">Waktu</th></tr></thead>
                    <tbody>
                        @forelse ($absensiTerbaru as $absensi)
                            <tr class="border-b border-emerald-50 transition last:border-0 hover:bg-emerald-50/50"><td class="py-3 pl-3 font-medium text-emerald-950">{{ $absensi->santri->nama }}</td><td>{{ ucfirst($absensi->jenis) }}</td><td>{{ $absensi->satpam->name }}</td><td>{{ $absensi->tercatat_at->format('d M Y H:i') }}</td></tr>
                        @empty
                            <tr><td class="py-5 text-gray-500" colspan="4">Belum ada catatan absensi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
