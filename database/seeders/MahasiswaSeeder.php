<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nrp' => '161124031'],
            ['nrp' => '160423002'],
            ['nrp' => '160423003'],
            ['nrp' => '160423004'],
            ['nrp' => '160423005'],
        ];

        foreach ($data as $mahasiswa) {
            Mahasiswa::updateOrCreate(
                ['nrp' => $mahasiswa['nrp']],
                []
            );
        }
    }
}