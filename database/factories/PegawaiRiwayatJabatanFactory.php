<?php

namespace Database\Factories;

use App\Models\JabatanUnitKerja;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PegawaiRiwayatJabatan>
 */
class PegawaiRiwayatJabatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pegawai_id' => Pegawai::factory(),
            'jabatan_unit_kerja_id' => JabatanUnitKerja::factory(),
            'no_sk' => fake()->numerify('######'),
            'no_pelantikan' => fake()->numerify('######'),
            'tanggal_sk' => fake()->date(),
            'tanggal_pelantikan' => fake()->date(),
            'tmt_jabatan' => fake()->date(),
            'pejabat_penetap' => fake()->name(),
            'is_plt' => fake()->boolean(),
            'is_current' => fake()->boolean(),
        ];
    }
}
