<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\HasilPertandingan;
use App\Kegiatan;
use App\PelakuOlahraga;
use App\Kota;

class HasilPertandinganSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hasil_pertandingans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil kegiatan olahraga resmi (non-khusus)
        $kegiatan = Kegiatan::where('is_khusus', false)->first();
        if (!$kegiatan) {
            $kegiatan = Kegiatan::create([
                'nama_kegiatan' => 'PORPROV Banten Ke-VII',
                'lokasi' => 'Provinsi Banten',
                'deskripsi' => 'Pekan Olahraga Provinsi Banten ke-VII Tahun 2026',
                'tanggal_mulai' => '2026-11-13',
                'tanggal_selesai' => '2026-11-22',
                'is_khusus' => false,
            ]);
        }

        $allAtlits = PelakuOlahraga::where('kategori', 'atlit')->get();

        if ($allAtlits->isEmpty()) {
            return;
        }

        // Helper function untuk mengambil atlet berdasarkan daerah yang valid
        $getAtletByKota = function($kotaNama) use ($allAtlits) {
            $pool = $allAtlits->filter(function($a) use ($kotaNama) {
                return strcasecmp(trim($a->kontingen), trim($kotaNama)) === 0;
            });
            if ($pool->isEmpty()) {
                $pool = $allAtlits->filter(function($a) use ($kotaNama) {
                    return stripos($a->kontingen, $kotaNama) !== false || stripos($kotaNama, $a->kontingen) !== false;
                });
            }
            return $pool->isNotEmpty() ? $pool->random() : $allAtlits->random();
        };

        // Daftar pertandingan lengkap beserta peraih medali
        $matches = [
            ['cabor' => 'Atletik', 'emas' => 'KOTA TANGERANG', 'perak' => 'KAB. TANGERANG', 'perunggu' => 'KOTA TANGERANG SELATAN'],
            ['cabor' => 'Atletik', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA TANGERANG SELATAN', 'perunggu' => 'KOTA CILEGON'],
            ['cabor' => 'Atletik', 'emas' => 'KAB. TANGERANG', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KOTA SERANG'],
            ['cabor' => 'Bulu Tangkis', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KAB. TANGERANG'],
            ['cabor' => 'Bulu Tangkis', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA TANGERANG SELATAN', 'perunggu' => 'KAB. LEBAK'],
            ['cabor' => 'Bulu Tangkis', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KAB. TANGERANG', 'perunggu' => 'KOTA TANGERANG'],
            ['cabor' => 'Renang', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA CILEGON', 'perunggu' => 'KOTA TANGERANG SELATAN'],
            ['cabor' => 'Renang', 'emas' => 'KAB. TANGERANG', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KOTA SERANG'],
            ['cabor' => 'Renang', 'emas' => 'KOTA CILEGON', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KAB. TANGERANG'],
            ['cabor' => 'Pencak Silat', 'emas' => 'KOTA SERANG', 'perak' => 'KAB. PANDEGLANG', 'perunggu' => 'KAB. LEBAK'],
            ['cabor' => 'Pencak Silat', 'emas' => 'KOTA CILEGON', 'perak' => 'KOTA SERANG', 'perunggu' => 'KAB. SERANG'],
            ['cabor' => 'Pencak Silat', 'emas' => 'KAB. SERANG', 'perak' => 'KOTA TANGERANG SELATAN', 'perunggu' => 'KOTA TANGERANG'],
            ['cabor' => 'Karate', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA TANGERANG SELATAN', 'perunggu' => 'KAB. TANGERANG'],
            ['cabor' => 'Karate', 'emas' => 'KAB. TANGERANG', 'perak' => 'KOTA CILEGON', 'perunggu' => 'KAB. LEBAK'],
            ['cabor' => 'Taekwondo', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KAB. TANGERANG'],
            ['cabor' => 'Taekwondo', 'emas' => 'KOTA TANGERANG', 'perak' => 'KAB. TANGERANG', 'perunggu' => 'KOTA SERANG'],
            ['cabor' => 'Panahan', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KAB. TANGERANG'],
            ['cabor' => 'Panahan', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA CILEGON', 'perunggu' => 'KAB. PANDEGLANG'],
            ['cabor' => 'Sepak Bola', 'emas' => 'KOTA TANGERANG', 'perak' => 'KAB. TANGERANG', 'perunggu' => 'KOTA TANGERANG SELATAN'],
            ['cabor' => 'Futsal', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KOTA SERANG', 'perunggu' => 'KAB. LEBAK'],
            ['cabor' => 'Bola Basket', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA TANGERANG SELATAN', 'perunggu' => 'KAB. TANGERANG'],
            ['cabor' => 'Catur', 'emas' => 'KAB. LEBAK', 'perak' => 'KOTA CILEGON', 'perunggu' => 'KOTA TANGERANG SELATAN'],
            ['cabor' => 'Catur', 'emas' => 'KOTA SERANG', 'perak' => 'KAB. LEBAK', 'perunggu' => 'KOTA TANGERANG'],
            ['cabor' => 'Tenis Meja', 'emas' => 'KOTA CILEGON', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KAB. PANDEGLANG'],
            ['cabor' => 'Tenis Meja', 'emas' => 'KOTA TANGERANG', 'perak' => 'KAB. TANGERANG', 'perunggu' => 'KOTA SERANG'],
            ['cabor' => 'Angkat Besi', 'emas' => 'KOTA SERANG', 'perak' => 'KOTA CILEGON', 'perunggu' => 'KAB. SERANG'],
            ['cabor' => 'Angkat Besi', 'emas' => 'KOTA TANGERANG', 'perak' => 'KOTA SERANG', 'perunggu' => 'KAB. LEBAK'],
            ['cabor' => 'Senam', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KOTA TANGERANG', 'perunggu' => 'KOTA CILEGON'],
            ['cabor' => 'Balap Sepeda', 'emas' => 'KAB. TANGERANG', 'perak' => 'KOTA TANGERANG SELATAN', 'perunggu' => 'KOTA TANGERANG'],
            ['cabor' => 'Dayung', 'emas' => 'KAB. TANGERANG', 'perak' => 'KOTA SERANG', 'perunggu' => 'KAB. PANDEGLANG'],
            ['cabor' => 'Judo', 'emas' => 'KOTA TANGERANG', 'perak' => 'KAB. TANGERANG', 'perunggu' => 'KOTA TANGERANG SELATAN'],
            ['cabor' => 'Menembak', 'emas' => 'KOTA TANGERANG SELATAN', 'perak' => 'KOTA CILEGON', 'perunggu' => 'KOTA TANGERANG'],
        ];

        foreach ($matches as $m) {
            $emasPelaku = $getAtletByKota($m['emas']);
            $perakPelaku = $getAtletByKota($m['perak']);
            $perungguPelaku = $getAtletByKota($m['perunggu']);

            HasilPertandingan::create([
                'kegiatan_id' => $kegiatan->id,
                'cabor' => $m['cabor'],
                'emas_pelaku_id' => $emasPelaku ? $emasPelaku->id : null,
                'emas_kontingen' => $emasPelaku && $emasPelaku->kontingen ? $emasPelaku->kontingen : $m['emas'],
                'perak_pelaku_id' => $perakPelaku ? $perakPelaku->id : null,
                'perak_kontingen' => $perakPelaku && $perakPelaku->kontingen ? $perakPelaku->kontingen : $m['perak'],
                'perunggu_pelaku_id' => $perungguPelaku ? $perungguPelaku->id : null,
                'perunggu_kontingen' => $perungguPelaku && $perungguPelaku->kontingen ? $perungguPelaku->kontingen : $m['perunggu'],
            ]);
        }
    }
}
