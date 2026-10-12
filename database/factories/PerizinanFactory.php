<?php

namespace Database\Factories;

use App\Models\Perizinan;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perizinan>
 */
class PerizinanFactory extends Factory
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
            'dibuat_oleh' => User::factory()->state(['role' => 'admin']),
            'alasan' => fake()->sentence(),
            'mulai_at' => now()->subHour(),
            'kembali_sebelum' => now()->addHours(4),
            'status' => 'menunggu',
        ];
    }
}
