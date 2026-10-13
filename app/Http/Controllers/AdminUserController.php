<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return $this->listing();
    }

    public function edit(User $user): View
    {
        return $this->listing($user);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                Rule::unique('users', 'username'),
            ],
            'role' => ['required', Rule::in(['pengurus', 'satpam'])],
            'password' => ['required', 'confirmed', 'string', 'min:8'],
            'nomor_induk_karyawan' => [
                Rule::requiredIf($request->input('role') === 'satpam'),
                'nullable',
                'string',
                'max:255',
                Rule::unique('satpams', 'nomor_induk_karyawan'),
            ],
            'shift' => [
                Rule::requiredIf($request->input('role') === 'satpam'),
                'nullable',
                Rule::in(['pagi', 'siang', 'malam']),
            ],
        ]);

        DB::transaction(function () use ($data): void {
            $user = User::create([
                'username' => $data['email'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            if ($data['role'] === 'satpam') {
                $user->satpam()->create([
                    'nomor_induk_karyawan' => $data['nomor_induk_karyawan'],
                    'shift' => $data['shift'],
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('status', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user),
                Rule::unique('users', 'username')->ignore($user),
            ],
            'password' => ['nullable', 'confirmed', 'string', 'min:8'],
            'nomor_induk_karyawan' => [
                Rule::requiredIf($user->role === 'satpam'),
                'nullable',
                'string',
                'max:255',
                Rule::unique('satpams', 'nomor_induk_karyawan')->ignore($user->satpam?->id),
            ],
            'shift' => [
                Rule::requiredIf($user->role === 'satpam'),
                'nullable',
                Rule::in(['pagi', 'siang', 'malam']),
            ],
        ]);

        DB::transaction(function () use ($data, $user): void {
            $emailChanged = $user->email !== $data['email'];
            $password = $data['password'] ?? null;

            $user->update([
                'username' => $data['email'],
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => $emailChanged ? null : $user->email_verified_at,
                ...($password ? ['password' => Hash::make($password)] : []),
            ]);

            if ($user->role === 'satpam') {
                $user->satpam()->updateOrCreate([], [
                    'nomor_induk_karyawan' => $data['nomor_induk_karyawan'],
                    'shift' => $data['shift'],
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('status', 'Akun berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'Akun yang sedang digunakan tidak dapat dihapus dari halaman ini.']);
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() === 1) {
            return back()->withErrors(['user' => 'Akun admin terakhir tidak dapat dihapus.']);
        }

        if (
            $user->perizinansDibuat()->exists()
            || Perizinan::where('disetujui_oleh', $user->id)->exists()
            || Absensi::where('satpam_id', $user->id)->exists()
        ) {
            return back()->withErrors(['user' => 'Akun tidak dapat dihapus karena masih memiliki riwayat absensi atau perizinan.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Akun berhasil dihapus.');
    }

    private function listing(?User $userToEdit = null): View
    {
        return view('admin.users.index', [
            'users' => User::with('satpam')->orderBy('role')->orderBy('name')->get(),
            'userToEdit' => $userToEdit,
        ]);
    }
}
