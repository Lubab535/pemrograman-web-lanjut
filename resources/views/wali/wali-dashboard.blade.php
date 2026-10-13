<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-emerald-950">Absensi Anak</h2></x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @forelse ($santris as $santri)
            <section class="rounded-2xl border border-emerald-100 bg-white/90 p-6 shadow-lg shadow-emerald-950/5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div><h3 class="text-lg font-semibold text-emerald-950">{{ $santri->nama }}</h3><p class="text-sm text-slate-600">NISN {{ $santri->nisn }} · Kamar {{ $santri->kamar }}</p></div>
                    <span class="rounded-full px-3 py-1 text-sm {{ $santri->status_keberadaan === 'di_pesantren' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">{{ $santri->status_keberadaan === 'di_pesantren' ? 'Di pesantren' : 'Sedang izin keluar' }}</span>
                </div>

                <h4 class="mb-3 mt-6 font-semibold text-blue-950">Riwayat absensi</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-blue-100 bg-blue-50/70 text-blue-800"><tr><th class="rounded-l-lg py-2 pl-2">Aktivitas</th><th>Waktu</th><th class="rounded-r-lg">Petugas</th></tr></thead>
                        <tbody>
                            @forelse ($santri->absensis as $absensi)
                                <tr class="border-b border-blue-50 last:border-0 hover:bg-blue-50/40"><td class="py-3 pl-2">{{ ucfirst($absensi->jenis) }}</td><td>{{ $absensi->tercatat_at->format('d M Y H:i') }}</td><td>{{ $absensi->satpam->name }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="py-4 text-gray-500">Belum ada riwayat absensi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h4 class="mb-3 mt-6 font-semibold text-emerald-950">Perizinan terbaru</h4>
                <div class="space-y-2">
                    @forelse ($santri->perizinans as $perizinan)
                        <div class="flex flex-wrap justify-between gap-2 rounded-lg border border-emerald-100 bg-emerald-50/60 p-3 text-sm">
                            <span>{{ $perizinan->alasan }} · {{ $perizinan->mulai_at->format('d M H:i') }} – {{ $perizinan->kembali_sebelum->format('d M H:i') }}</span>
                            <span>{{ ucfirst($perizinan->status) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada perizinan.</p>
                    @endforelse
                </div>
            </section>
        @empty
            <section class="rounded-2xl border border-yellow-200 bg-yellow-50/80 p-6 text-amber-950 shadow-lg shadow-yellow-950/5">Belum ada santri yang terhubung dengan akun wali ini. Hubungi admin pesantren untuk menghubungkan akun.</section>
        @endforelse
    </div>
</x-app-layout>
