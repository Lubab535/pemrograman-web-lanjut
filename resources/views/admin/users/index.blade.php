<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-emerald-950">Kelola Pengguna</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <section class="rounded-2xl border border-emerald-100 bg-white/90 p-6 shadow-lg shadow-emerald-950/5">
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-emerald-950">{{ $userToEdit ? 'Ubah akun pengguna' : 'Tambah akun pengurus atau satpam' }}</h3>
                    <p class="mt-1 text-sm text-slate-600">Pendaftaran publik hanya tersedia untuk wali santri.</p>
                </div>
                @if ($userToEdit)
                    <a class="text-sm font-semibold text-blue-700 hover:text-blue-950" href="{{ route('admin.users.index') }}">Tambah akun baru</a>
                @endif
            </div>

            @if ($userToEdit)
                <form method="POST" action="{{ route('admin.users.update', $userToEdit) }}" class="grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')
                    <label class="text-sm font-medium text-emerald-950">Nama
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="name" required value="{{ old('name', $userToEdit->name) }}">
                    </label>
                    <label class="text-sm font-medium text-emerald-950">Email
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" type="email" name="email" required value="{{ old('email', $userToEdit->email) }}">
                    </label>
                    @if ($userToEdit->role === 'satpam')
                        <label class="text-sm font-medium text-emerald-950">Nomor induk karyawan
                            <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="nomor_induk_karyawan" required value="{{ old('nomor_induk_karyawan', $userToEdit->satpam?->nomor_induk_karyawan) }}">
                        </label>
                        <label class="text-sm font-medium text-emerald-950">Shift
                            <select class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="shift" required>
                                @foreach (['pagi' => 'Pagi', 'siang' => 'Siang', 'malam' => 'Malam'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('shift', $userToEdit->satpam?->shift) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>
                    @endif
                    <label class="text-sm font-medium text-emerald-950 md:col-span-2">Password baru <span class="font-normal text-slate-500">(kosongkan jika tidak diubah)</span>
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" type="password" name="password" autocomplete="new-password">
                    </label>
                    <label class="text-sm font-medium text-emerald-950 md:col-span-2">Konfirmasi password baru
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" type="password" name="password_confirmation" autocomplete="new-password">
                    </label>
                    <div class="flex items-center gap-3 md:col-span-2">
                        <button class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:ring-2 focus:ring-yellow-400">Simpan perubahan</button>
                        <a class="rounded-lg border border-blue-200 px-4 py-2 text-sm font-medium text-blue-800 hover:bg-blue-50" href="{{ route('admin.users.index') }}">Batal</a>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ route('admin.users.store') }}" x-data="{ role: @js(old('role', 'pengurus')) }" class="grid gap-4 md:grid-cols-2">
                    @csrf
                    <label class="text-sm font-medium text-emerald-950">Nama
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="name" required value="{{ old('name') }}">
                    </label>
                    <label class="text-sm font-medium text-emerald-950">Email
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" type="email" name="email" required value="{{ old('email') }}">
                    </label>
                    <label class="text-sm font-medium text-emerald-950">Peran
                        <select class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="role" x-model="role" required>
                            <option value="pengurus">Pengurus</option>
                            <option value="satpam">Satpam</option>
                        </select>
                    </label>
                    <label class="text-sm font-medium text-emerald-950">Password sementara
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" type="password" name="password" autocomplete="new-password" required>
                    </label>
                    <label class="text-sm font-medium text-emerald-950">Konfirmasi password
                        <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" type="password" name="password_confirmation" autocomplete="new-password" required>
                    </label>
                    <div x-cloak x-show="role === 'satpam'" class="contents">
                        <label class="text-sm font-medium text-emerald-950">Nomor induk karyawan
                            <input class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="nomor_induk_karyawan" :required="role === 'satpam'" value="{{ old('nomor_induk_karyawan') }}">
                        </label>
                        <label class="text-sm font-medium text-emerald-950">Shift
                            <select class="mt-1 block w-full rounded-lg border-emerald-200 focus:border-emerald-600 focus:ring-emerald-500" name="shift" :required="role === 'satpam'">
                                <option value="">Pilih shift</option>
                                <option value="pagi" @selected(old('shift') === 'pagi')>Pagi</option>
                                <option value="siang" @selected(old('shift') === 'siang')>Siang</option>
                                <option value="malam" @selected(old('shift') === 'malam')>Malam</option>
                            </select>
                        </label>
                    </div>
                    <button class="w-fit rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:ring-2 focus:ring-yellow-400 md:col-span-2">Tambah akun</button>
                </form>
            @endif
        </section>

        <section class="rounded-2xl border border-blue-100 bg-white/90 p-6 shadow-lg shadow-blue-950/5">
            <h3 class="mb-4 text-lg font-semibold text-blue-950">Daftar akun terdaftar</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-blue-100 bg-blue-50/70 text-blue-800">
                        <tr><th class="rounded-l-lg py-3 pl-3">Nama</th><th>Email</th><th>Peran</th><th>Informasi</th><th class="rounded-r-lg">Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-blue-50 align-top last:border-0 hover:bg-blue-50/40">
                                <td class="py-3 pl-3 font-medium text-blue-950">{{ $user->name }}</td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3">
                                    <span @class([
                                        'rounded-full px-3 py-1 text-xs font-semibold',
                                        'bg-yellow-100 text-amber-900' => $user->role === 'admin',
                                        'bg-emerald-100 text-emerald-900' => $user->role === 'pengurus',
                                        'bg-blue-100 text-blue-900' => $user->role === 'satpam',
                                        'bg-slate-100 text-slate-700' => $user->role === 'wali_santri',
                                    ])>{{ ['admin' => 'Admin', 'pengurus' => 'Pengurus', 'satpam' => 'Satpam', 'wali_santri' => 'Wali santri'][$user->role] }}</span>
                                </td>
                                <td class="py-3 text-slate-600">
                                    @if ($user->role === 'satpam' && $user->satpam)
                                        {{ $user->satpam->nomor_induk_karyawan }} · Shift {{ ucfirst($user->satpam->shift) }}
                                    @elseif ($user->role === 'admin')
                                        Administrasi pengguna
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="flex flex-wrap gap-3">
                                        <a class="font-semibold text-emerald-700 hover:text-emerald-950" href="{{ route('admin.users.edit', $user) }}">Ubah</a>
                                        @if ($user->id !== auth()->id() && ($user->role !== 'admin' || $users->where('role', 'admin')->count() > 1))
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="font-semibold text-red-700 hover:text-red-900">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-5 text-slate-500">Belum ada pengguna terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
