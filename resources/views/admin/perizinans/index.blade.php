<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Perizinan Santri</h2></x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))<div class="rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-lg bg-red-50 p-4 text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-lg font-semibold">Catat permintaan izin</h3>
            <form method="POST" action="{{ route('admin.perizinans.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                <label class="text-sm font-medium">Santri
                    <select class="mt-1 block w-full rounded-md border-gray-300" name="santri_id" required>
                        <option value="">Pilih santri</option>
                        @foreach ($santris as $santri)<option value="{{ $santri->id }}" @selected(old('santri_id') == $santri->id)>{{ $santri->nama }} · {{ $santri->nisn }}</option>@endforeach
                    </select>
                </label>
                <label class="text-sm font-medium">Alasan<input class="mt-1 block w-full rounded-md border-gray-300" name="alasan" required value="{{ old('alasan') }}"></label>
                <label class="text-sm font-medium">Mulai
                    <input class="mt-1 block w-full rounded-md border-gray-300" type="datetime-local" name="mulai_at" required value="{{ old('mulai_at', now()->format('Y-m-d\TH:i')) }}">
                </label>
                <label class="text-sm font-medium">Batas waktu kembali
                    <input class="mt-1 block w-full rounded-md border-gray-300" type="datetime-local" name="kembali_sebelum" required value="{{ old('kembali_sebelum', now()->addHours(4)->format('Y-m-d\TH:i')) }}">
                </label>
                <button class="w-fit rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white md:col-span-2">Simpan permintaan</button>
            </form>
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold">Daftar perizinan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b text-gray-500"><tr><th class="py-3">Santri</th><th>Alasan</th><th>Jadwal</th><th>Status</th><th>Persetujuan</th></tr></thead>
                    <tbody>
                        @forelse ($perizinans as $perizinan)
                            <tr class="border-b align-top last:border-0">
                                <td class="py-3">{{ $perizinan->santri->nama }}</td>
                                <td>{{ $perizinan->alasan }}</td>
                                <td>{{ $perizinan->mulai_at->format('d M H:i') }} – {{ $perizinan->kembali_sebelum->format('d M H:i') }}</td>
                                <td>{{ ucfirst($perizinan->status) }}@if ($perizinan->catatan_penolakan)<p class="text-xs text-red-700">{{ $perizinan->catatan_penolakan }}</p>@endif</td>
                                <td class="py-3">
                                    @if (in_array($perizinan->status, ['menunggu', 'ditolak'], true))
                                        <form method="POST" action="{{ route('admin.perizinans.update', $perizinan) }}" class="flex flex-wrap gap-2">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button class="rounded bg-emerald-700 px-3 py-1 text-xs font-semibold text-white">Setujui</button>
                                        </form>
                                    @endif
                                    @if (in_array($perizinan->status, ['menunggu', 'disetujui'], true))
                                        <form method="POST" action="{{ route('admin.perizinans.update', $perizinan) }}" class="mt-2 flex flex-wrap gap-2">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <input class="w-40 rounded border-gray-300 text-xs" name="catatan_penolakan" placeholder="Alasan penolakan">
                                            <button class="rounded border border-red-300 px-3 py-1 text-xs text-red-700">Tolak</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-5 text-gray-500">Belum ada permintaan izin.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
