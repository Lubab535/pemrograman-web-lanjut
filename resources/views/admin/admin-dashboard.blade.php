<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Admin Pesantren</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Total santri</p><p class="mt-2 text-3xl font-semibold">{{ $jumlahSantri }}</p></div>
            <div class="rounded-xl bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Izin menunggu</p><p class="mt-2 text-3xl font-semibold">{{ $izinMenunggu }}</p></div>
            <div class="rounded-xl bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Sedang di luar</p><p class="mt-2 text-3xl font-semibold">{{ $sedangKeluar }}</p></div>
        </div>

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-lg font-semibold">Aktivitas absensi terbaru</h3>
                <div class="flex gap-3">
                    <a class="text-sm font-medium text-emerald-700" href="{{ route('admin.santris.index') }}">Kelola santri</a>
                    <a class="text-sm font-medium text-emerald-700" href="{{ route('admin.perizinans.index') }}">Kelola perizinan</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b text-gray-500"><tr><th class="py-3">Santri</th><th>Aktivitas</th><th>Petugas</th><th>Waktu</th></tr></thead>
                    <tbody>
                        @forelse ($absensiTerbaru as $absensi)
                            <tr class="border-b last:border-0"><td class="py-3">{{ $absensi->santri->nama }}</td><td>{{ ucfirst($absensi->jenis) }}</td><td>{{ $absensi->satpam->name }}</td><td>{{ $absensi->tercatat_at->format('d M Y H:i') }}</td></tr>
                        @empty
                            <tr><td class="py-5 text-gray-500" colspan="4">Belum ada catatan absensi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
