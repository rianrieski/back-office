<?php

namespace Database\Factories;

use App\Models\Tukin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TukinFactory extends Factory
{
    protected $model = Tukin::class;

    public function definition()
    {
        return [
            'grade' => $this->faker->randomNumber(),
            'nominal' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
