<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Satpam;
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
            'password' => Hash::make('password123'), // Password default encryted
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
            'shift' => 'pagi', // Sesuai pilihan enum Anda ('pagi','siang','malam')
        ]);

        // 3. Membuat Akun Wali Santri beserta Profilnya
        $userWali = User::create([
            'username' => 'wali_ahmad',
            'name' => 'Ahmad Wali',
            'email' => 'ahmad@pesantren.com',
            'password' => Hash::make('password123'),
            'role' => 'wali_santri',
        ]);

        WaliSantri::create([
            'user_id' => $userWali->id,
            'alamat' => 'Jl. Merdeka No. 12, Jombang',
            'no_telepon' => '081234567890',
        ]);
    }
}
