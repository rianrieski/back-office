<?php

namespace Database\Factories;

use App\Models\Golongan;
use App\Models\UangMakan;
use Illuminate\Database\Eloquent\Factories\Factory;

class UangMakanFactory extends Factory
{
    protected $model = UangMakan::class;

    public function definition()
    {
        return [
            'golongan_id' => Golongan::factory(),
            'nominal' => $this->faker->randomNumber(),
        ];
    }
}
