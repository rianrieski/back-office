<?php

namespace Database\Factories;

use App\Models\JabatanFungsionalUmum;
use App\Models\JenisJabatan;
use App\Models\Tukin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JabatanTukin>
 */
class JabatanTukinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jabatan_id' => JabatanFungsionalUmum::factory(),
            'jenis_jabatan_id' => JenisJabatan::factory(),
            'tukin_id' => Tukin::factory(),
        ];
    }
}
