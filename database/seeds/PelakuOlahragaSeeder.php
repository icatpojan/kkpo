<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Kota;
use App\Cabor;
use App\KelompokCabor;

class PelakuOlahragaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pelaku_olahragas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kotas = Kota::all();
        if ($kotas->isEmpty()) {
            // Default 8 Kota/Kab Banten jika belum ada
            $kotaList = [
                ['kode' => '3671', 'nama' => 'KOTA TANGERANG'],
                ['kode' => '3603', 'nama' => 'KAB. TANGERANG'],
                ['kode' => '3674', 'nama' => 'KOTA TANGERANG SELATAN'],
                ['kode' => '3672', 'nama' => 'KOTA CILEGON'],
                ['kode' => '3673', 'nama' => 'KOTA SERANG'],
                ['kode' => '3602', 'nama' => 'KAB. LEBAK'],
                ['kode' => '3604', 'nama' => 'KAB. SERANG'],
                ['kode' => '3601', 'nama' => 'KAB. PANDEGLANG'],
            ];
            foreach ($kotaList as $k) {
                Kota::create($k);
            }
            $kotas = Kota::all();
        }

        $namaPria = [
            'Rizky Pratama', 'Budi Santoso', 'Andi Wijaya', 'Hendra Kusuma', 'Iqbal Ramadhan',
            'Dimas Anggara', 'Bayu Saputra', 'Dedi Mulyadi', 'Farhan Hakim', 'Gilang Dirga',
            'Hasan Basri', 'Ilham Akbar', 'Reza Pahlevi', 'Agus Setiawan', 'Fajar Alfian',
            'Anthony Ginting', 'Jonatan Christie', 'Eko Yuli', 'Rifda Irfanaluthfi', 'Bambang Pamungkas'
        ];

        $namaWanita = [
            'Siti Nurhaliza', 'Ayu Ting Ting', 'Dewi Persik', 'Fitri Carlina', 'Gita Gutawa',
            'Nisa Sabyan', 'Putri Titian', 'Rossa', 'Raisa Andriana', 'Maudy Ayunda',
            'Chelsea Islan', 'Tara Basro', 'Pevita Pearce', 'Dian Sastrowardoyo', 'Greysia Polii',
            'Apriyani Rahayu', 'Liliyana Natsir', 'Susy Susanti', 'Sri Wahyuni', 'Windy Cantika'
        ];

        $allCaborsFromDb = Cabor::all();
        if ($allCaborsFromDb->isNotEmpty()) {
            $caborList = $allCaborsFromDb->map(function($c) {
                return ['nama' => $c->nama, 'kel' => $c->kelompok_kode, 'kode' => $c->kode];
            })->toArray();
        } else {
            $caborList = [
                ['nama' => 'Atletik', 'kel' => 'TR', 'kode' => '02'],
                ['nama' => 'Bulu Tangkis', 'kel' => 'PR', 'kode' => '03'],
                ['nama' => 'Renang', 'kel' => 'TR', 'kode' => '03'],
                ['nama' => 'Pencak Silat', 'kel' => 'BD', 'kode' => '01'],
                ['nama' => 'Karate', 'kel' => 'BD', 'kode' => '06'],
                ['nama' => 'Taekwondo', 'kel' => 'BD', 'kode' => '02'],
                ['nama' => 'Panahan', 'kel' => 'AK', 'kode' => '01'],
                ['nama' => 'Sepak Bola', 'kel' => 'PR', 'kode' => '01'],
                ['nama' => 'Futsal', 'kel' => 'PR', 'kode' => '17'],
                ['nama' => 'Bola Basket', 'kel' => 'PR', 'kode' => '04'],
                ['nama' => 'Catur', 'kel' => 'AK', 'kode' => '03'],
                ['nama' => 'Tenis Meja', 'kel' => 'PR', 'kode' => '07'],
                ['nama' => 'Esport', 'kel' => 'PR', 'kode' => '20'],
            ];
        }

        $data = [];
        $priaIdx = 0;
        $wanitaIdx = 0;

        foreach ($kotas as $kota) {
            // Tiap Kota/Kab memiliki atlet pria dan wanita untuk berbagai cabor
            for ($i = 0; $i < 6; $i++) {
                $cabor = $caborList[($priaIdx + $i) % count($caborList)];
                $nama = $namaPria[$priaIdx % count($namaPria)];
                $priaIdx++;

                $data[] = [
                    'kategori' => 'atlit',
                    'nama' => $nama,
                    'jk' => 'L',
                    'nomor_anggota' => 'ATLIT-' . $kota->kode . '-L' . str_pad($priaIdx, 3, '0', STR_PAD_LEFT),
                    'ttl' => $kota->nama . ', 199' . rand(5, 9) . '-0' . rand(1, 9) . '-1' . rand(0, 9),
                    'nik' => $kota->kode . rand(100000000000, 999999999999),
                    'no_wa' => '0812' . rand(10000000, 99999999),
                    'alamat' => 'Jl. Pemuda No. ' . rand(1, 80) . ', ' . $kota->nama,
                    'riwayat_kesehatan' => 'Sehat Bebas Cedera',
                    'cabor' => $cabor['nama'],
                    'kel_cabor' => 'Olahraga Prestasi',
                    'kontingen' => $kota->nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            for ($i = 0; $i < 6; $i++) {
                $cabor = $caborList[($wanitaIdx + $i + 2) % count($caborList)];
                $nama = $namaWanita[$wanitaIdx % count($namaWanita)];
                $wanitaIdx++;

                $data[] = [
                    'kategori' => 'atlit',
                    'nama' => $nama,
                    'jk' => 'P',
                    'nomor_anggota' => 'ATLIT-' . $kota->kode . '-P' . str_pad($wanitaIdx, 3, '0', STR_PAD_LEFT),
                    'ttl' => $kota->nama . ', 200' . rand(0, 4) . '-0' . rand(1, 9) . '-1' . rand(0, 9),
                    'nik' => $kota->kode . rand(100000000000, 999999999999),
                    'no_wa' => '0813' . rand(10000000, 99999999),
                    'alamat' => 'Jl. Kartini No. ' . rand(1, 80) . ', ' . $kota->nama,
                    'riwayat_kesehatan' => 'Sehat Bebas Cedera',
                    'cabor' => $cabor['nama'],
                    'kel_cabor' => 'Olahraga Prestasi',
                    'kontingen' => $kota->nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('pelaku_olahragas')->insert($data);
    }
}
