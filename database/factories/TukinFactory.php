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
            'grade' => $this->faker->numberBetween(1, 20),
            'nominal' => $this->faker->numerify('########'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
