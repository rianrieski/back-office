<?php

namespace Database\Factories;

use App\Models\Penghargaan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PenghargaanFactory extends Factory
{
    protected $model = Penghargaan::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
