<?php

use Illuminate\Database\Seeder;

class ConfigToDatabaseSeeder extends Seeder
{
    public function run()
    {
        $rs = [
            'RSU KOTA TANGERANG SELATAN' => 'M',
            'RSU PONDOK AREN' => 'M',
            'RSU SERPONG UTARA' => 'M',
            'PSC 119' => 'M',
            'RS EKA HOSPITAL' => 'utama',
            'RS PREMIER BINTARO' => 'utama',
            'RS BRAWIJAYA' => 'utama',
            'RS SARI ASIH CIPUTAT' => 'umum',
            'RS SARI ASIH BINTARO' => 'umum',
            'RS HERMINA CIPUTAT' => 'umum',
            'RS HERMINA SERPONG' => 'umum',
            'RS MITRA KELUARGA PAMULANG' => 'umum',
            'RS COLUMBIA' => 'umum',
            'RS MITRA KELUARGA BINTARO' => 'umum',
            'RS SYARIF HIDAYATULLAH JAKARTA' => 'umum',
            'RS BUAH HATI CIPUTAT' => 'umum',
            'RS PERMATA PAMULANG' => 'umum',
            'RS CINTA KASIH' => 'umum',
            'RS RIS' => 'umum',
            'RSIA CITRA ANANDA' => 'GRADE 3',
            'RSIA DHIA' => 'GRADE 3',
            'RSIA PERMATA SARANA HUSADA' => 'GRADE 3',
            'RSIA VITALAYA' => 'GRADE 3',
            'RS PROKLAMASI' => 'GRADE 3',
            'RS ST. CAROLUS SUMMARECON SERPONG' => 'PENYANGGA',
            'RS BETHSAIDA HOSPITAL' => 'PENYANGGA',
            'RS DSPEC' => 'PENYANGGA',
            'SILOAM HOSPITALS KELAPA DUA' => 'PENYANGGA',
            'RS MITRA KELUARGA GADING SERPONG' => 'PENYANGGA',
            'RS PRIMAYA' => 'PENYANGGA',
            'RSUD KAB TANGERANG' => 'PENYANGGA',
            
            // Puskesmas
            'Puskesmas Pamulang (Jl. Suryakencana)' => 'PUSKESMAS',
            'Puskesmas Benda Baru (Jl. Vila Dago Raya)' => 'PUSKESMAS',
            'Puskesmas Pondok Benda' => 'PUSKESMAS',
            'Puskesmas Kedaung' => 'PUSKESMAS',
            'Puskesmas Pamulang Timur' => 'PUSKESMAS',
            'Puskesmas Bambu Apus' => 'PUSKESMAS',
            'Puskesmas Ciputat (Jl. Kihajar Dewantara)' => 'PUSKESMAS',
            'Puskesmas Kampung Sawah (Sawah Lama)' => 'PUSKESMAS',
            'Puskesmas Jombang' => 'PUSKESMAS',
            'Puskesmas Sawah Baru' => 'PUSKESMAS',
            'Puskesmas Situ Gintung / Serua' => 'PUSKESMAS',
            'Puskesmas Ciputat Timur' => 'PUSKESMAS',
            'Puskesmas Pondok Ranji' => 'PUSKESMAS',
            'Puskesmas Pisangan' => 'PUSKESMAS',
            'Puskesmas Cireundeu' => 'PUSKESMAS',
            'Puskesmas Rengas' => 'PUSKESMAS',
            'Puskesmas Pondok Aren' => 'PUSKESMAS',
            'Puskesmas Pondok Pucung' => 'PUSKESMAS',
            'Puskesmas Pondok Betung' => 'PUSKESMAS',
            'Puskesmas Jurang Mangu' => 'PUSKESMAS',
            'Puskesmas Parigi' => 'PUSKESMAS',
            'Puskesmas Pondok Kacang Timur' => 'PUSKESMAS',
            'Puskesmas Serpong I (Jl. Raya Serpong)' => 'PUSKESMAS',
            'Puskesmas Serpong II (Jl. Cendana)' => 'PUSKESMAS',
            'Puskesmas Rawa Buntu' => 'PUSKESMAS',
            'Puskesmas Ciater' => 'PUSKESMAS',
            'Puskesmas Lengkong Wetan' => 'PUSKESMAS',
            'Puskesmas Pondok Jagung' => 'PUSKESMAS',
            'Puskesmas Lengkong Karya' => 'PUSKESMAS',
            'Puskesmas Paku Alam' => 'PUSKESMAS',
            'Puskesmas Bakti Jaya' => 'PUSKESMAS',
            'Puskesmas Keranggan' => 'PUSKESMAS',
        ];

        foreach ($rs as $nama => $tipe) {
            \App\RumahSakit::firstOrCreate(['nama' => $nama], ['tipe' => $tipe]);
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
