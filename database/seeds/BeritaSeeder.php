<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('beritas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $beritas = [
            [
                'judul' => 'KKPO Tangsel Buka Layanan Konsultasi Cedera Gratis',
                'konten' => 'Klinik Kesehatan Pelaku Olahraga (KKPO) KONI Tangerang Selatan kini membuka layanan konsultasi cedera secara gratis untuk seluruh atlet yang terdaftar. Layanan ini mencakup fisioterapi dasar, penanganan cedera akut, serta program rehabilitasi pasca cedera untuk memastikan atlet dapat kembali ke performa puncaknya.',
                'tanggal_publikasi' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Tim Medis KKPO Siap Mengawal Porprov 2026',
                'konten' => 'Dalam rangka menyambut Pekan Olahraga Provinsi (Porprov) Banten 2026, KKPO Tangsel telah menyiapkan puluhan tenaga medis profesional yang terdiri dari dokter olahraga, fisioterapis, dan perawat. Mereka akan disebar di berbagai venue pertandingan untuk memberikan respons cepat terhadap insiden medis di lapangan.',
                'tanggal_publikasi' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Pentingnya Pemanasan untuk Mencegah Cedera Otot',
                'konten' => 'Banyak atlet pemula yang mengabaikan pemanasan sebelum bertanding, yang berujung pada cedera otot serius. Dokter spesialis olahraga dari KKPO Tangsel mengingatkan kembali bahwa pemanasan minimal 15 menit sangat esensial untuk melenturkan otot dan sendi. Mari biasakan pemanasan yang benar demi kelangsungan karir olahraga Anda.',
                'tanggal_publikasi' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('beritas')->insert($beritas);
    }
}
