<?php

namespace Database\Factories;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HirarkiUnitKerja>
 */
class HirarkiUnitKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'child_unit_kerja_id' => UnitKerja::factory(),
            'parent_unit_kerja_id' => UnitKerja::factory(),
        ];
    }
}
