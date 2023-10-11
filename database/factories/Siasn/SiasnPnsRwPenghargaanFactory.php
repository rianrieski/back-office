<?php

namespace Database\Factories\Siasn;

use App\Models\Penghargaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiasnPnsRwPenghargaanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->uuid(),
            'pnsOrangId' => fake()->numerify('#################'),
            'hargaId' => Penghargaan::factory(),
            'tahun' => fake()->year(),
            'skNomor' => fake()->word(),
            'skDate' => fake()->date(),
            'hargaNama' => fake()->word(),
            'path' => ''
        ];
    }
}
