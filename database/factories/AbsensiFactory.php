<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Absensi>
 */
class AbsensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'santri_id' => Santri::factory(),
            'satpam_id' => User::factory()->state(['role' => 'satpam']),
            'jenis' => 'keluar',
            'tercatat_at' => now(),
        ];
    }
}
