<?php

namespace Database\Factories;

use App\Models\JenisUnitKerja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitKerja>
 */
class UnitKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'jenis_unit_kerja_id' => JenisUnitKerja::factory(),
            'singkatan' => fake()->word(),
            'keterangan' => fake()->text(),
        ];
    }
}
