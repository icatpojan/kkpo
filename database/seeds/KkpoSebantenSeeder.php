<?php

use Illuminate\Database\Seeder;

class KkpoSebantenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'wadah' => 'PANDEGLANG', 
                'nama_personil' => 'Rizki Aulia Rahman Natakusumah',
                'npp' => 'SK.KONI-Banten/PDG/2026/01',
                'alamat_kantor' => 'Jl. A. Sastrawidjaya No.1, Pemerintah Daerah Kabupaten Pandeglang, Banten'
            ],
            [
                'wadah' => 'LEBAK', 
                'nama_personil' => 'Yeppy Wahyu Wandiana',
                'npp' => 'SK.KONI-Banten/LBK/2026/02',
                'alamat_kantor' => 'Jl. Alun-alun Timur No.4, Rangkasbitung, Kabupaten Lebak, Banten'
            ],
            [
                'wadah' => 'TANGERANG KAB', 
                'nama_personil' => 'Eka Wibayu',
                'npp' => 'SK.KONI-Banten/TGR-KAB/2026/03',
                'alamat_kantor' => 'Desa Ranca Iyuh, Kecamatan Panongan, Kabupaten Tangerang'
            ],
            [
                'wadah' => 'SERANG KAB', 
                'nama_personil' => 'Syamsul Rizal Djahidi',
                'npp' => 'SK.KONI-Banten/SRG-KAB/2026/04',
                'alamat_kantor' => 'Jl. Ranca Sawah No. 5, Kelurahan Drangong, Kecamatan Taktakan, Kota Serang'
            ],
            [
                'wadah' => 'TANGERANG KOTA', 
                'nama_personil' => 'H. Dirman',
                'npp' => 'SK.KONI-Banten/TGR-KOTA/2026/05',
                'alamat_kantor' => 'Jl. Taman Makam Pahlawan Taruna No.72, RT.001/RW.002, Sukaasih, Kota Tangerang'
            ],
            [
                'wadah' => 'KOTA CILEGON', 
                'nama_personil' => 'Irfan Ali Hakim',
                'npp' => 'SK.KONI-Banten/CLG/2026/06',
                'alamat_kantor' => 'Komplek Stadion Seruni, Kota Cilegon'
            ],
            [
                'wadah' => 'SERANG KOTA', 
                'nama_personil' => 'Edy Irianto',
                'npp' => 'SK.KONI-Banten/SRG-KOTA/2026/07',
                'alamat_kantor' => 'Jl. Fatah Hasan, Cijawa, Kota Serang, Banten'
            ],
            [
                'wadah' => 'TANGERANG SELATAN', 
                'nama_personil' => 'Mahludin',
                'npp' => 'SK.KONI-Banten/TANGSEL/2026/08',
                'alamat_kantor' => 'Komplek Pemerintah Kota Tangerang Selatan, Banten'
            ],
        ];

        foreach ($data as $item) {
            \App\KkpoSebanten::firstOrCreate(['wadah' => $item['wadah']], $item);
        }
    }
}
