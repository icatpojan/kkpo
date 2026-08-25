<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Kota;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('password');

        // 1. Admin (jika belum ada)
        User::firstOrCreate(
            ['email' => 'admin@kkpo.id'],
            [
                'name' => 'Admin KKPO',
                'password' => $password,
                'role' => 'admin'
            ]
        );

        // 2. Ketua Panitia
        User::firstOrCreate(
            ['email' => 'ketua.panitia@kkpo.id'],
            [
                'name' => 'Ketua Panitia',
                'password' => $password,
                'role' => 'ketua_panitia'
            ]
        );

        // 3. Kabid Kesehatan
        User::firstOrCreate(
            ['email' => 'kabid.kesehatan@kkpo.id'],
            [
                'name' => 'Kabid Kesehatan',
                'password' => $password,
                'role' => 'kabid_kesehatan'
            ]
        );

        // 4. Nakes (Tenaga Kesehatan)
        User::firstOrCreate(
            ['email' => 'nakes1@kkpo.id'],
            [
                'name' => 'Dr. Budi Santoso',
                'password' => $password,
                'role' => 'nakes'
            ]
        );
        User::firstOrCreate(
            ['email' => 'nakes2@kkpo.id'],
            [
                'name' => 'Siti Aisyah, S.Kep',
                'password' => $password,
                'role' => 'nakes'
            ]
        );

        // 5. Rumah Sakit (1 akun per RS)
        $rumahsakit = [
            'RSU KOTA TANGERANG SELATAN',
            'RSU PONDOK AREN',
            'RSU SERPONG UTARA',
            'PSC 119',
            'RS EKA HOSPITAL',
            'RS PREMIER BINTARO',
            'RS BRAWIJAYA',
            'RS SARI ASIH CIPUTAT',
            'RS SARI ASIH BINTARO',
            'RS HERMINA CIPUTAT',
            'RS HERMINA SERPONG',
            'RS MITRA KELUARGA PAMULANG',
            'RS COLUMBIA',
            'RS MITRA KELUARGA BINTARO',
            'RS SYARIF HIDAYATULLAH JAKARTA',
            'RS BUAH HATI CIPUTAT',
            'RS PERMATA PAMULANG',
            'RS CINTA KASIH',
            'RS RIS',
            'RSIA CITRA ANANDA',
            'RSIA DHIA',
            'RSIA PERMATA SARANA HUSADA',
            'RSIA VITALAYA',
            'RS PROKLAMASI',
            'RS ST. CAROLUS SUMMARECON SERPONG',
            'RS BETHSAIDA HOSPITAL',
            'RS DSPEC',
            'SILOAM HOSPITALS KELAPA DUA',
            'RS MITRA KELUARGA GADING SERPONG',
            'RS PRIMAYA',
            'RSUD KAB TANGERANG',
            'Puskesmas Pamulang (Jl. Suryakencana)',
            'Puskesmas Benda Baru (Jl. Vila Dago Raya)',
            'Puskesmas Pondok Benda',
            'Puskesmas Kedaung',
            'Puskesmas Pamulang Timur',
            'Puskesmas Bambu Apus',
            'Puskesmas Ciputat (Jl. Kihajar Dewantara)',
            'Puskesmas Kampung Sawah (Sawah Lama)',
            'Puskesmas Jombang',
            'Puskesmas Sawah Baru',
            'Puskesmas Situ Gintung / Serua',
            'Puskesmas Ciputat Timur',
            'Puskesmas Pondok Ranji',
            'Puskesmas Pisangan',
            'Puskesmas Cireundeu',
            'Puskesmas Rengas',
            'Puskesmas Pondok Aren',
            'Puskesmas Pondok Pucung',
            'Puskesmas Pondok Betung',
            'Puskesmas Jurang Mangu',
            'Puskesmas Parigi',
            'Puskesmas Pondok Kacang Timur',
            'Puskesmas Serpong I (Jl. Raya Serpong)',
            'Puskesmas Serpong II (Jl. Cendana)',
            'Puskesmas Rawa Buntu',
            'Puskesmas Ciater',
            'Puskesmas Lengkong Wetan',
            'Puskesmas Pondok Jagung',
            'Puskesmas Lengkong Karya',
            'Puskesmas Paku Alam',
            'Puskesmas Bakti Jaya',
            'Puskesmas Keranggan',
        ];
        
        foreach ($rumahsakit as $i => $rsName) {
            $email = 'rs' . ($i + 1) . '@kkpo.id';
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $rsName,
                    'password' => $password,
                    'role' => 'rs'
                ]
            );
        }

        // 6. KONI / Kontingen (Ada 9)
        // Ambil 8 dari Kota + 1 KONI BANTEN
        $kontingens = Kota::pluck('nama')->toArray();
        $kontingens[] = 'KONI BANTEN';

        foreach ($kontingens as $i => $kontingenName) {
            $slug = strtolower(str_replace(' ', '', $kontingenName));
            $email = 'koni.' . $slug . '@kkpo.id';
            
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $kontingenName,
                    'password' => $password,
                    'role' => 'koni'
                ]
            );
        }
    }
}
