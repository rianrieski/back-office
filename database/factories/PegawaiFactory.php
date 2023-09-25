<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->unique()->firstName();

        return [
            'nik' => fake()->numerify('################'),
            'nip' => fake()->numerify('##################'),
            'nama_depan' => $firstName,
            'nama_belakang' => fake()->lastName(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'agama_id' => fake()->numberBetween(1, 7),
            'golongan_darah' => fake()->randomElement(['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB-', 'AB+']),
            'jenis_kawin_id' => fake()->numberBetween(1, 4),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->dateTimeBetween('1990-01-01', '2012-12-31')->format('Y-m-d'),
            'email_kantor' => fake()->toLower($firstName) . '@office.com',
            'email_pribadi' => fake()->toLower($firstName) . '@private.com',
            'no_telp' => fake()->numerify('#############'),
            'jenis_pegawai_id' => fake()->numberBetween(1, 19),
            'status_pegawai_id' => fake()->numberBetween(1, 3),
            'status_dinas' => fake()->boolean(),
            'no_bpjs' => fake()->numerify('#############'),
            'no_kartu_pegawai' => fake()->numerify('#########'),
        ];
    }
}
