<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-emerald-950">Absensi QR Santri</h2></x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))<div class="rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-lg bg-red-50 p-4 text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <section class="rounded-2xl border border-emerald-100 bg-white/90 p-6 shadow-lg shadow-emerald-950/5">
            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-amber-900">Gerbang pesantren</span>
            <h3 class="mt-3 text-lg font-semibold text-emerald-950">Pindai KTS</h3>
            <p id="scanner-status" class="mt-2 text-sm text-gray-600">Memulai kamera… Izinkan akses kamera, atau masukkan token QR secara manual.</p>
            <p class="mt-1 text-xs text-gray-500">Akses kamera membutuhkan HTTPS atau localhost. Jika tidak tersedia, masukkan token dari QR KTS secara manual.</p>
            <div id="qr-reader" class="mt-4 max-w-md overflow-hidden rounded-lg"></div>
            <form id="attendance-form" method="POST" action="{{ route('satpam.absensi.store') }}" class="mt-5 flex flex-wrap gap-3">
                @csrf
                <input class="min-w-64 flex-1 rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="qr_token" placeholder="Token QR KTS" autocomplete="off" required>
                <button class="rounded-lg bg-emerald-700 px-5 py-2 font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:ring-2 focus:ring-yellow-400">Catat scan</button>
            </form>
        </section>

        <section class="rounded-2xl border border-blue-100 bg-white/90 p-6 shadow-lg shadow-blue-950/5">
            <h3 class="mb-4 text-lg font-semibold text-blue-950">Absensi terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-blue-100 bg-blue-50/70 text-blue-800"><tr><th class="rounded-l-lg py-3 pl-3">Santri</th><th>Aktivitas</th><th class="rounded-r-lg">Waktu</th></tr></thead>
                    <tbody>
                        @forelse ($absensiTerbaru as $absensi)
                            <tr class="border-b border-blue-50 last:border-0 hover:bg-blue-50/40"><td class="py-3 pl-3 font-medium text-blue-950">{{ $absensi->santri->nama }}</td><td>{{ ucfirst($absensi->jenis) }}</td><td>{{ $absensi->tercatat_at->format('d M Y H:i') }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="py-5 text-gray-500">Belum ada absensi tercatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
