<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pertanyaan;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'kategori_id' => 1, // Akademik
                'pertanyaan' => 'Bagaimana alur prosedur perwalian KRS semester ganjil/genap?',
                'jawaban' => 'Prosedur perwalian dapat dilakukan secara online melalui MyUBAYA. Mahasiswa diwajibkan memeriksa jadwal perwalian, berkonsultasi dengan Dosen Wali, serta memilih mata kuliah yang sesuai dengan batasan SKS.',
                'status' => 'published',
            ],
            [
                'kategori_id' => 2, // Keuangan
                'pertanyaan' => 'Kapan batas waktu pembayaran Uang Kuliah Tunggal (UKT)?',
                'jawaban' => 'Batas akhir pembayaran UKT dapat dilihat pada Kalender Akademik UBAYA di portal resmi. Pembayaran dilakukan melalui Virtual Account bank mitra (BCA, Mandiri, BNI).',
                'status' => 'published',
            ],
            [
                'kategori_id' => 2, // Keuangan
                'pertanyaan' => 'Bagaimana cara mengajukan beasiswa potongan prestasi?',
                'jawaban' => 'Pengajuan beasiswa dilakukan melalui Direktorat Kemahasiswaan dengan melampirkan Transkrip Nilai (IPK minimal 3.50) serta sertifikat prestasi non-akademik.',
                'status' => 'published',
            ],
            [
                'kategori_id' => 5, // Fasilitas
                'pertanyaan' => 'Bagaimana cara mendaftar dan mengoneksikan WiFi Kampus Ubaya-Secure?',
                'jawaban' => 'Pilih Wi-Fi Ubaya-Secure pada perangkat Anda. Masukkan NPK/NRP sebagai username dan kata sandi akun SSO MyUBAYA Anda.',
                'status' => 'published',
            ],
            [
                'kategori_id' => 4, // Ujian
                'pertanyaan' => 'Apa syarat untuk mendaftar Sidang Tugas Akhir / Skripsi?',
                'jawaban' => 'Syarat meliputi: Telah lulus semua mata kuliah wajib, nilai TOEFL minimal 450, bebas pinjaman perpustakaan, dan berkas TA yang disetujui Dosen Pembimbing.',
                'status' => 'published',
            ],
            [
                'kategori_id' => 3, // Kemahasiswaan
                'pertanyaan' => 'Bagaimana cara mengajukan Surat Keterangan Pendamping Ijazah (SKPI)?',
                'jawaban' => 'Input poin sertifikat kegiatan UKM/Kepanitiaan melalui SIM-SKPI di MyUBAYA, kemudian lakukan verifikasi ke bagian Ormawa Fakultas.',
                'status' => 'published',
            ],
        ];

        foreach ($faqs as $faq) {
            Pertanyaan::firstOrCreate(
                ['pertanyaan' => $faq['pertanyaan']],
                $faq
            );
        }
    }
}