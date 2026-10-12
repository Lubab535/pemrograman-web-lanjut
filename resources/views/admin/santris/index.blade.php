<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Data Santri dan QR KTS</h2></x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))<div class="rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-lg bg-red-50 p-4 text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-lg font-semibold">{{ $santriToEdit ? 'Ubah data santri' : 'Tambah santri' }}</h3>
            <form method="POST" action="{{ $santriToEdit ? route('admin.santris.update', $santriToEdit) : route('admin.santris.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($santriToEdit) @method('PUT') @endif
                <label class="text-sm font-medium">NISN<input class="mt-1 block w-full rounded-md border-gray-300" name="nisn" required value="{{ old('nisn', $santriToEdit?->nisn) }}"></label>
                <label class="text-sm font-medium">Nama santri<input class="mt-1 block w-full rounded-md border-gray-300" name="nama" required value="{{ old('nama', $santriToEdit?->nama) }}"></label>
                <label class="text-sm font-medium">Kamar<input class="mt-1 block w-full rounded-md border-gray-300" name="kamar" required value="{{ old('kamar', $santriToEdit?->kamar) }}"></label>
                <label class="text-sm font-medium">Nama orang tua<input class="mt-1 block w-full rounded-md border-gray-300" name="nama_orang_tua" required value="{{ old('nama_orang_tua', $santriToEdit?->nama_orang_tua) }}"></label>
                <label class="text-sm font-medium">Nomor darurat<input class="mt-1 block w-full rounded-md border-gray-300" name="nomor_darurat" required value="{{ old('nomor_darurat', $santriToEdit?->nomor_darurat) }}"></label>
                <label class="text-sm font-medium">Akun wali
                    <select class="mt-1 block w-full rounded-md border-gray-300" name="wali_santri_id">
                        <option value="">Belum dihubungkan</option>
                        @foreach ($waliSantris as $waliSantri)
                            <option value="{{ $waliSantri->id }}" @selected((string) old('wali_santri_id', $santriToEdit?->wali_santri_id) === (string) $waliSantri->id)>{{ $waliSantri->user->name }} ({{ $waliSantri->user->email }})</option>
                        @endforeach
                    </select>
                </label>
                <div class="flex gap-3 md:col-span-2">
                    <button class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white">{{ $santriToEdit ? 'Simpan perubahan' : 'Tambah santri' }}</button>
                    @if ($santriToEdit)<a class="rounded-md border px-4 py-2 text-sm" href="{{ route('admin.santris.index') }}">Batal</a>@endif
                </div>
            </form>
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3"><h3 class="text-lg font-semibold">Kartu QR santri</h3><button class="rounded-md border px-4 py-2 text-sm print:hidden" onclick="window.print()">Cetak halaman</button></div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($santris as $santri)
                    <article class="break-inside-avoid rounded-lg border p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div><h4 class="font-semibold">{{ $santri->nama }}</h4><p class="text-sm text-gray-600">NISN {{ $santri->nisn }} · Kamar {{ $santri->kamar }}</p><p class="text-xs text-gray-500">{{ $santri->waliSantri?->user?->name ?? 'Wali belum dihubungkan' }}</p></div>
                            <canvas data-qr-code="{{ $santri->qr_token }}" aria-label="QR KTS {{ $santri->nama }}"></canvas>
                        </div>
                        <div class="mt-3 flex gap-3 text-sm print:hidden">
                            <a class="text-emerald-700" href="{{ route('admin.santris.edit', $santri) }}">Ubah</a>
                            <form method="POST" action="{{ route('admin.santris.destroy', $santri) }}" onsubmit="return confirm('Hapus data santri ini?')">@csrf @method('DELETE')<button class="text-red-700">Hapus</button></form>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data santri.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
