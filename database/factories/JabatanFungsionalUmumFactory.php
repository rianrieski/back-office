<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JabatanFungsionalUmum>
 */
class JabatanFungsionalUmumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'cepat_kode' => fake()->word(),
            'bkn_id' => fake()->numerify('#####'),
            'status' => fake()->numerify('#'),
        ];
    }
}
