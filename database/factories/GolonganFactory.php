<?php

namespace Database\Factories;

use App\Models\Golongan;
use Illuminate\Database\Eloquent\Factories\Factory;

class GolonganFactory extends Factory
{
    protected $model = Golongan::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            'nama_pangkat' => $this->faker->word(),
        ];
    }
}
