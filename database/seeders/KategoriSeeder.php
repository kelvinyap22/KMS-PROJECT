<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Akademik', 'deskripsi' => 'Seputar perwalian, KRS, dan perkuliahan'],
            ['nama' => 'Keuangan', 'deskripsi' => 'Seputar pembayaran UKT, cicilan, dan beasiswa'],
            ['nama' => 'Kemahasiswaan', 'deskripsi' => 'Seputar UKM, kegiatan, dan SKPI'],
            ['nama' => 'Ujian', 'deskripsi' => 'Seputar UTS, UAS, dan Sidang Tugas Akhir'],
            ['nama' => 'Fasilitas', 'deskripsi' => 'Seputar Wi-Fi, laboratorium, dan fasilitas kampus'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(
                ['nama' => $kategori['nama']],
                ['deskripsi' => $kategori['deskripsi']]
            );
        }
    }
}