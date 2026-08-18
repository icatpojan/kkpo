<?php

use Illuminate\Database\Seeder;

class ConfigToDatabaseSeeder extends Seeder
{
    public function run()
    {
        $rs = [
            'RSUD Berkah Pandeglang' => 'Kabupaten Pandeglang',
            'RS Aulia Pandeglang' => 'Kabupaten Pandeglang',
            'RS Permata Ibunda' => 'Kabupaten Pandeglang',
            'RSUD Labuan' => 'Kabupaten Pandeglang',
            'RS Shinta Husada' => 'Kabupaten Pandeglang',
            'Klinik Sehat Pandeglang' => 'Kabupaten Pandeglang',
            'Klinik Medika Pandeglang' => 'Kabupaten Pandeglang',
            'Klinik Pratama Bina Sehat' => 'Kabupaten Pandeglang',
            'Klinik Harapan Medika' => 'Kabupaten Pandeglang',

            'RSUD Dr. Adjidarmo' => 'Kabupaten Lebak',
            'RS Misi Lebak' => 'Kabupaten Lebak',
            'RS Kartini Rangkasbitung' => 'Kabupaten Lebak',
            'RSUD Malingping' => 'Kabupaten Lebak',
            'RS Bhakti Husada' => 'Kabupaten Lebak',
            'Klinik Medika Rangkasbitung' => 'Kabupaten Lebak',
            'Klinik Sehat Lebak' => 'Kabupaten Lebak',
            'Klinik Pratama Harapan' => 'Kabupaten Lebak',
            'Klinik Bina Husada' => 'Kabupaten Lebak',

            'RSUD Kabupaten Tangerang' => 'Kabupaten Tangerang',
            'RS Hermina Bitung' => 'Kabupaten Tangerang',
            'RS Siloam Lippo Village' => 'Kabupaten Tangerang',
            'RS Bethsaida' => 'Kabupaten Tangerang',
            'RS Ciputra Hospital CitraRaya' => 'Kabupaten Tangerang',
            'RS Mitra Keluarga Gading Serpong' => 'Kabupaten Tangerang',
            'RS Qadr' => 'Kabupaten Tangerang',
            'RS Primaya Hospital Tangerang' => 'Kabupaten Tangerang',
            'Klinik Pratama Tangerang Sehat' => 'Kabupaten Tangerang',
            'Klinik Medika CitraRaya' => 'Kabupaten Tangerang',
            'Klinik Bina Sehat' => 'Kabupaten Tangerang',
            'Klinik Mitra Medika' => 'Kabupaten Tangerang',

            'RSUD Kabupaten Serang' => 'Kabupaten Serang',
            'RS Hermina Ciruas' => 'Kabupaten Serang',
            'RS Sari Asih Serang' => 'Kabupaten Serang',
            'RS Kurnia Serang' => 'Kabupaten Serang',
            'RS Krakatau Medika' => 'Kabupaten Serang',
            'RS Bhayangkara Serang' => 'Kabupaten Serang',
            'Klinik Pratama Serang Sehat' => 'Kabupaten Serang',
            'Klinik Medika Serang' => 'Kabupaten Serang',
            'Klinik Bina Husada' => 'Kabupaten Serang',
            'Klinik Harapan Sehat' => 'Kabupaten Serang',

            'RSUD Kota Tangerang' => 'Kota Tangerang',
            'RS Sari Asih Karawaci' => 'Kota Tangerang',
            'RS Sari Asih Ciledug' => 'Kota Tangerang',
            'RS EMC Tangerang' => 'Kota Tangerang',
            'RS Mayapada Tangerang' => 'Kota Tangerang',
            'RS Hermina Tangerang' => 'Kota Tangerang',
            'RS An-Nisa Tangerang' => 'Kota Tangerang',
            'RS Mulya' => 'Kota Tangerang',
            'Klinik Pratama Tangerang Medika' => 'Kota Tangerang',
            'Klinik Sehat Bersama' => 'Kota Tangerang',
            'Klinik Medika Utama' => 'Kota Tangerang',
            'Klinik Harapan Medika' => 'Kota Tangerang',

            'RSUD Kota Cilegon' => 'Kota Cilegon',
            'RS Krakatau Medika' => 'Kota Cilegon',
            'RS Kurnia Cilegon' => 'Kota Cilegon',
            'RSIA Mutiara Bunda' => 'Kota Cilegon',
            'RS Bhayangkara Cilegon' => 'Kota Cilegon',
            'Klinik Cilegon Sehat' => 'Kota Cilegon',
            'Klinik Krakatau Medika' => 'Kota Cilegon',
            'Klinik Pratama Bina Sehat' => 'Kota Cilegon',
            'Klinik Harapan Cilegon' => 'Kota Cilegon',

            'RSUD Kota Serang' => 'Kota Serang',
            'RS Sari Asih Serang' => 'Kota Serang',
            'RS Bhayangkara Banten' => 'Kota Serang',
            'RS Kurnia Serang' => 'Kota Serang',
            'RS Fatimah Serang' => 'Kota Serang',
            'RSIA Puri Garcia' => 'Kota Serang',
            'Klinik Serang Medika' => 'Kota Serang',
            'Klinik Pratama Sehat' => 'Kota Serang',
            'Klinik Bina Husada' => 'Kota Serang',
            'Klinik Harapan Sehat' => 'Kota Serang',

            'RSUD Kota Tangerang Selatan' => 'Kota Tangerang Selatan',
            'RS Sari Asih Ciputat' => 'Kota Tangerang Selatan',
            'RS Sari Asih Bintaro' => 'Kota Tangerang Selatan',
            'RS Premier Bintaro' => 'Kota Tangerang Selatan',
            'RS Eka Hospital BSD' => 'Kota Tangerang Selatan',
            'RS Columbia BSD' => 'Kota Tangerang Selatan',
            'RS Syarif Hidayatullah' => 'Kota Tangerang Selatan',
            'RS Hermina Ciputat' => 'Kota Tangerang Selatan',
            'RS Hermina Serpong' => 'Kota Tangerang Selatan',
            'RS Pondok Indah Bintaro' => 'Kota Tangerang Selatan',
            'RS Mitra Keluarga Bintaro' => 'Kota Tangerang Selatan',
            'RS Mitra Keluarga Pamulang' => 'Kota Tangerang Selatan',
            'RSU Pondok Aren' => 'Kota Tangerang Selatan',
            'RSU Serpong Utara' => 'Kota Tangerang Selatan'
        ];

        foreach ($rs as $nama => $wilayah) {
            \App\RumahSakit::firstOrCreate(['nama' => $nama], ['wilayah' => $wilayah]);
        }

        $kotas = [
            '3601' => 'PANDEGLANG',
            '3602' => 'LEBAK',
            '3603' => 'TANGERANG KAB',
            '3604' => 'SERANG KAB',
            '3671' => 'TANGERANG KOTA',
            '3672' => 'KOTA CILEGON',
            '3673' => 'SERANG KOTA',
            '3674' => 'TANGERANG SELATAN',
        ];

        foreach ($kotas as $kode => $nama) {
            \App\Kota::firstOrCreate(['kode' => $kode], ['nama' => $nama]);
        }

        $kelompoks = [
            'BD' => 'Bela Diri (BD)',
            'AK' => 'Akurasi dan Konsentrasi (AK)',
            'TR' => 'Terukur (TR)',
            'PR' => 'Permainan (PR)',
        ];

        foreach ($kelompoks as $kode => $nama) {
            \App\KelompokCabor::firstOrCreate(['kode' => $kode], ['nama' => $nama]);
        }

        $cabors = [
            'BD' => [
                '01' => 'Pencak Silat',
                '02' => 'Anggar',
                '03' => 'Judo',
                '04' => 'Tinju',
                '05' => 'Gulat',
                '06' => 'Karate',
                '07' => 'Kempo',
                '08' => 'Taekwondo',
                '09' => 'Wushu',
                '10' => 'Tarung Drajat',
                '11' => 'Muaythai',
                '12' => 'Jiu-Jitsu',
                '13' => 'Sambo',
                '14' => 'Kurash',
                '15' => '(MMA) Mixed Martial Arts',
            ],
            'AK' => [
                '01' => 'Catur',
                '02' => 'Panahan',
                '03' => 'Billiard',
                '04' => 'Bridge',
                '05' => 'Menembak',
                '06' => 'Golf',
                '07' => 'Bowling',
                '08' => 'Wood ball',
                '09' => 'Petaques',
            ],
            'TR' => [
                '01' => 'Balap Motor',
                '02' => 'Atletik',
                '03' => 'Renang',
                '04' => 'Balap Sepeda',
                '05' => 'Senam',
                '06' => 'Dayung',
                '07' => 'Selam',
                '08' => 'Drumband',
                '09' => 'Sepatu Roda',
                '10' => 'Panjat Tebing',
                '11' => 'Arung Jeram',
                '12' => 'Selancar',
                '13' => 'Pentathlon',
                '14' => 'Angkat besi',
                '15' => 'Binaraga',
                '16' => 'Angkat berat',
            ],
            'PR' => [
                '01' => 'Sepak Bola',
                '02' => 'Tenis Lapangan',
                '03' => 'Bulu Tangkis',
                '04' => 'Bola Basket',
                '05' => 'Bola Voli',
                '06' => 'Hoki',
                '07' => 'Tenis Meja',
                '08' => 'Softball',
                '09' => 'Sepak Takraw',
                '10' => 'Squash',
                '11' => 'Rugby',
                '12' => 'Bola Tangan',
                '13' => 'Floorball',
                '14' => 'Cricket',
                '15' => 'Gateball',
                '16' => 'Barongsai',
                '17' => 'Futsal',
                '18' => 'Dance Sport',
                '19' => 'Pickleball',
                '20' => 'Esport',
            ],
        ];

        foreach ($cabors as $kel_kode => $cabor_list) {
            foreach ($cabor_list as $kode => $nama) {
                \App\Cabor::firstOrCreate(['kelompok_kode' => $kel_kode, 'kode' => $kode], ['nama' => $nama]);
            }
        }
    }
}
