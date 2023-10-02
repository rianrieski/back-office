<?php

namespace Database\Factories;

use App\Models\Tukin;
use Illuminate\Database\Eloquent\Factories\Factory;

class TukinFactory extends Factory
{
    protected $model = Tukin::class;

    public function definition()
    {
        return [
            'grade' => fake()->unique()->randomNumber(),
            'nominal' => fake()->numerify('#######'),
        ];
    }
}
