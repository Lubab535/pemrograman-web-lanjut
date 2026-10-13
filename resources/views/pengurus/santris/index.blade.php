<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-emerald-950">Data Santri dan QR KTS</h2></x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))<div class="rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-lg bg-red-50 p-4 text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <section class="rounded-2xl border border-emerald-100 bg-white/90 p-6 shadow-lg shadow-emerald-950/5">
            <h3 class="mb-5 text-lg font-semibold text-emerald-950">{{ $santriToEdit ? 'Ubah data santri' : 'Tambah santri' }}</h3>
            <form method="POST" action="{{ $santriToEdit ? route('pengurus.santris.update', $santriToEdit) : route('pengurus.santris.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($santriToEdit) @method('PUT') @endif
                <label class="text-sm font-medium text-emerald-950">NISN<input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="nisn" required value="{{ old('nisn', $santriToEdit?->nisn) }}"></label>
                <label class="text-sm font-medium text-emerald-950">Nama santri<input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="nama" required value="{{ old('nama', $santriToEdit?->nama) }}"></label>
                <label class="text-sm font-medium text-emerald-950">Kamar<input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="kamar" required value="{{ old('kamar', $santriToEdit?->kamar) }}"></label>
                <label class="text-sm font-medium text-emerald-950">Nama orang tua<input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="nama_orang_tua" required value="{{ old('nama_orang_tua', $santriToEdit?->nama_orang_tua) }}"></label>
                <label class="text-sm font-medium text-emerald-950">Nomor darurat<input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="nomor_darurat" required value="{{ old('nomor_darurat', $santriToEdit?->nomor_darurat) }}"></label>
                <label class="text-sm font-medium">Akun wali
                    <select class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="wali_santri_id">
                        <option value="">Belum dihubungkan</option>
                        @foreach ($waliSantris as $waliSantri)
                            <option value="{{ $waliSantri->id }}" @selected((string) old('wali_santri_id', $santriToEdit?->wali_santri_id) === (string) $waliSantri->id)>{{ $waliSantri->user->name }} ({{ $waliSantri->user->email }})</option>
                        @endforeach
                    </select>
                </label>
                <div class="flex gap-3 md:col-span-2">
                    <button class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:ring-2 focus:ring-yellow-400">{{ $santriToEdit ? 'Simpan perubahan' : 'Tambah santri' }}</button>
                    @if ($santriToEdit)<a class="rounded-lg border border-blue-200 px-4 py-2 text-sm font-medium text-blue-800 transition hover:bg-blue-50" href="{{ route('pengurus.santris.index') }}">Batal</a>@endif
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-blue-100 bg-white/90 p-6 shadow-lg shadow-blue-950/5">
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3"><h3 class="text-lg font-semibold text-blue-950">Kartu QR santri</h3><button class="rounded-lg border border-blue-200 px-4 py-2 text-sm font-medium text-blue-800 transition hover:bg-blue-50 print:hidden" onclick="window.print()">Cetak halaman</button></div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($santris as $santri)
                    <article class="break-inside-avoid rounded-xl border border-emerald-100 bg-emerald-50/30 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div><h4 class="font-semibold">{{ $santri->nama }}</h4><p class="text-sm text-gray-600">NISN {{ $santri->nisn }} · Kamar {{ $santri->kamar }}</p><p class="text-xs text-gray-500">{{ $santri->waliSantri?->user?->name ?? 'Wali belum dihubungkan' }}</p></div>
                            <canvas data-qr-code="{{ $santri->qr_token }}" aria-label="QR KTS {{ $santri->nama }}"></canvas>
                        </div>
                        <div class="mt-3 flex gap-3 text-sm print:hidden">
                            <a class="text-emerald-700" href="{{ route('pengurus.santris.edit', $santri) }}">Ubah</a>
                            <form method="POST" action="{{ route('pengurus.santris.destroy', $santri) }}" onsubmit="return confirm('Hapus data santri ini?')">@csrf @method('DELETE')<button class="text-red-700">Hapus</button></form>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data santri.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
