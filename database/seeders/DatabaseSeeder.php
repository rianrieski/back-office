<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RefDokumenSeeder::class);
        $this->call(JenisKursusSeeder::class);
        $this->call(AgamaSeeder::class);
        $this->call(JenisPegawaiSeeder::class);
        $this->call(JenisJabatanSeeder::class);
        $this->call(TingkatPendidikanSeeder::class);
        $this->call(JenisKawinSeeder::class);
        $this->call(JenisKepanitiaanSeeder::class);
        $this->call(JenisDiklatSeeder::class);
        $this->call(JenisDokumenSeeder::class);
        $this->call(TaspenSeeder::class);
        $this->call(GolonganSeeder::class);
        $this->call(JenisKpSeeder::class);
        $this->call(InstansiSeeder::class);
    }
}
