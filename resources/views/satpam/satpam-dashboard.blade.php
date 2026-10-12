<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Absensi QR Santri</h2></x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))<div class="rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-lg bg-red-50 p-4 text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Pindai KTS</h3>
            <p id="scanner-status" class="mt-2 text-sm text-gray-600">Memulai kamera… Izinkan akses kamera, atau masukkan token QR secara manual.</p>
            <p class="mt-1 text-xs text-gray-500">Akses kamera membutuhkan HTTPS atau localhost. Jika tidak tersedia, masukkan token dari QR KTS secara manual.</p>
            <div id="qr-reader" class="mt-4 max-w-md overflow-hidden rounded-lg"></div>
            <form id="attendance-form" method="POST" action="{{ route('satpam.absensi.store') }}" class="mt-5 flex flex-wrap gap-3">
                @csrf
                <input class="min-w-64 flex-1 rounded-md border-gray-300" name="qr_token" placeholder="Token QR KTS" autocomplete="off" required>
                <button class="rounded-md bg-emerald-700 px-5 py-2 font-semibold text-white">Catat scan</button>
            </form>
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold">Absensi terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b text-gray-500"><tr><th class="py-3">Santri</th><th>Aktivitas</th><th>Waktu</th></tr></thead>
                    <tbody>
                        @forelse ($absensiTerbaru as $absensi)
                            <tr class="border-b last:border-0"><td class="py-3">{{ $absensi->santri->nama }}</td><td>{{ ucfirst($absensi->jenis) }}</td><td>{{ $absensi->tercatat_at->format('d M Y H:i') }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="py-5 text-gray-500">Belum ada absensi tercatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
