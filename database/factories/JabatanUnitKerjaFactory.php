<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JabatanTukin;
use App\Models\HirarkiUnitKerja;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JabatanUnitKerja>
 */
class JabatanUnitKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {

        return [
            'jabatan_tukin_id' => JabatanTukin::factory(),
            'hirarki_unit_kerja_id' => HirarkiUnitKerja::factory(),
        ];
    }
}
