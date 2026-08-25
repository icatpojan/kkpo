<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelakuOlahragaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pelaku_olahragas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $namaLaki = ['Budi Santoso', 'Andi Pratama', 'Rizky Fadillah', 'Agus Setiawan', 'Hendra Kusuma', 'Iqbal Ramadhan', 'Reza Pahlevi', 'Bayu Saputra', 'Dedi Mulyadi', 'Dimas Anggara', 'Farhan Hakim', 'Gilang Dirga', 'Hasan Basri', 'Ilham Akbar', 'Joko Widodo'];
        $namaPerempuan = ['Siti Aminah', 'Rina Nose', 'Ayu Ting Ting', 'Dewi Persik', 'Fitri Carlina', 'Gita Gutawa', 'Nisa Sabyan', 'Putri Titian', 'Rossa', 'Raisa Andriana', 'Maudy Ayunda', 'Chelsea Islan', 'Tara Basro', 'Pevita Pearce', 'Dian Sastro'];

        // Ambil dari config agar akurat
        $caborConfig = [];
        foreach(\App\Cabor::all() as $c) {
            $caborConfig[$c->kelompok_kode][$c->kode] = $c->nama;
        }
        $kotaConfig = \App\Kota::pluck('nama', 'kode')->toArray();
        $kotaKey = '3674';
        $kotaName = $kotaConfig[$kotaKey]; // TANGERANG SELATAN

        // Pilih beberapa cabor dari config
        $selectedCabors = [
            ['kel' => 'BD', 'kode' => '06', 'nama' => 'Karate'],
            ['kel' => 'BD', 'kode' => '01', 'nama' => 'Pencak Silat'],
            ['kel' => 'PR', 'kode' => '17', 'nama' => 'Futsal'],
            ['kel' => 'TR', 'kode' => '03', 'nama' => 'Renang'],
            ['kel' => 'PR', 'kode' => '04', 'nama' => 'Bola Basket'],
            ['kel' => 'PR', 'kode' => '03', 'nama' => 'Bulu Tangkis'],
            ['kel' => 'TR', 'kode' => '02', 'nama' => 'Atletik'],
        ];

        $data = [];
        $urut = []; // Untuk melacak nomor urut per prefix

        // 15 Laki-laki
        foreach ($namaLaki as $i => $nama) {
            $kategori = ($i < 10) ? 'atlit' : 'pelatih';
            $prefKat = strtoupper($kategori);
            $cabor = $selectedCabors[$i % count($selectedCabors)];
            
            $prefix = $prefKat . ' ' . $cabor['kel'] . $cabor['kode'] . '-' . $kotaKey . '-';
            if (!isset($urut[$prefix])) $urut[$prefix] = 0;
            $urut[$prefix]++;
            
            $nomor_anggota = $prefix . str_pad($urut[$prefix], 4, '0', STR_PAD_LEFT);

            $data[] = [
                'kategori' => $kategori,
                'nama' => $nama,
                'jk' => 'L',
                'nomor_anggota' => $nomor_anggota,
                'ttl' => 'Tangerang, 199' . rand(0, 9) . '-0' . rand(1, 9) . '-1' . rand(0, 9),
                'nik' => '3674' . rand(100000000000, 999999999999),
                'no_wa' => '0812' . rand(10000000, 99999999),
                'alamat' => 'Jl. Merdeka No. ' . rand(1, 100) . ', Tangerang',
                'riwayat_kesehatan' => 'Sehat',
                'cabor' => $cabor['nama'],
                'kel_cabor' => \App\KelompokCabor::where('kode', $cabor['kel'])->value('nama') ?? 'Umum',
                'kontingen' => $kotaName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 15 Perempuan
        foreach ($namaPerempuan as $i => $nama) {
            $kategori = ($i < 10) ? 'atlit' : 'official';
            $prefKat = strtoupper($kategori);
            $cabor = $selectedCabors[$i % count($selectedCabors)];
            
            $prefix = $prefKat . ' ' . $cabor['kel'] . $cabor['kode'] . '-' . $kotaKey . '-';
            if (!isset($urut[$prefix])) $urut[$prefix] = 0;
            $urut[$prefix]++;
            
            $nomor_anggota = $prefix . str_pad($urut[$prefix], 4, '0', STR_PAD_LEFT);

            $data[] = [
                'kategori' => $kategori,
                'nama' => $nama,
                'jk' => 'P',
                'nomor_anggota' => $nomor_anggota,
                'ttl' => 'Serang, 199' . rand(0, 9) . '-0' . rand(1, 9) . '-1' . rand(0, 9),
                'nik' => '3674' . rand(100000000000, 999999999999),
                'no_wa' => '0813' . rand(10000000, 99999999),
                'alamat' => 'Jl. Sudirman No. ' . rand(1, 100) . ', Serang',
                'riwayat_kesehatan' => 'Sehat',
                'cabor' => $cabor['nama'],
                'kel_cabor' => \App\KelompokCabor::where('kode', $cabor['kel'])->value('nama') ?? 'Umum',
                'kontingen' => $kotaName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert non-KONI first
        DB::table('pelaku_olahragas')->insert($data);

        $koniData = [];
        // Tambah 2 orang KONI
        for ($i = 1; $i <= 2; $i++) {
            $prefix = 'KONI ' . date('Y') . '-';
            $koniData[] = [
                'kategori' => 'koni',
                'nama' => 'Pengurus KONI ' . $i,
                'jk' => 'L',
                'nomor_anggota' => $prefix . str_pad($i, 4, '0', STR_PAD_LEFT),
                'bagian' => 'Pengawasan',
                'koni' => $kotaName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pelaku_olahragas')->insert($koniData);
    }
}
