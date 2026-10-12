<?php

namespace Database\Seeders;

use App\Models\Perizinan;
use App\Models\Santri;
use App\Models\Satpam;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'username' => 'admin_pondok',
            'name' => 'Admin Pondok',
            'email' => 'admin@pesantren.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Satpam beserta Profilnya
        $userSatpam = User::create([
            'username' => 'satpam_budi',
            'name' => 'Budi Satpam',
            'email' => 'budi@pesantren.com',
            'password' => Hash::make('password123'),
            'role' => 'satpam',
        ]);

        Satpam::create([
            'user_id' => $userSatpam->id,
            'nomor_induk_karyawan' => 'NIK-2026-001',
            'shift' => 'pagi',
        ]);

        // 3. Membuat Akun Wali Santri beserta Profilnya
        $userWali = User::create([
            'username' => 'wali_ahmad',
            'name' => 'Ahmad Wali',
            'email' => 'ahmad@pesantren.com',
            'password' => Hash::make('password123'),
            'role' => 'wali_santri',
        ]);

        $waliSantri = WaliSantri::create([
            'user_id' => $userWali->id,
            'alamat' => 'Jl. Merdeka No. 12, Jombang',
            'no_telepon' => '081234567890',
        ]);

        $santri = Santri::create([
            'nisn' => '2026000001',
            'nama' => 'Ahmad Fauzan',
            'kamar' => 'A-01',
            'nama_orang_tua' => $userWali->name,
            'nomor_darurat' => '081234567890',
            'wali_santri_id' => $waliSantri->id,
        ]);

        Perizinan::create([
            'santri_id' => $santri->id,
            'dibuat_oleh' => User::where('role', 'admin')->value('id'),
            'alasan' => 'Contoh izin yang telah disetujui',
            'mulai_at' => now()->subHour(),
            'kembali_sebelum' => now()->addDay(),
            'status' => 'disetujui',
        ]);
    }
}
