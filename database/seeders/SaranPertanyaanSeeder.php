<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaranPertanyaan;

class SaranPertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $sarans = [
            [
                'mahasiswa_id' => 1,
                'pertanyaan' => 'Apakah ada layanan ujian susulan bagi mahasiswa yang sakit saat UTS/UAS?',
                'ditangani_oleh' => 3,
                'status' => 'diproses',
            ],
            [
                'mahasiswa_id' => 2,
                'pertanyaan' => 'Bagaimana prosedur reset password SSO Ubaya jika email pemulihan lupa?',
                'ditangani_oleh' => null,
                'status' => 'baru',
            ],
        ];

        foreach ($sarans as $saran) {
            SaranPertanyaan::create($saran);
        }
    }
}