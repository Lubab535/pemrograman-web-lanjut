<?php

namespace Database\Factories;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Santri>
 */
class SantriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nisn' => fake()->unique()->numerify('##########'),
            'nama' => fake()->name(),
            'kamar' => fake()->bothify('##-?'),
            'nama_orang_tua' => fake()->name(),
            'nomor_darurat' => fake()->numerify('08##########'),
            'status_keberadaan' => 'di_pesantren',
        ];
    }
}
