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
            'RSUD Tangerang',
            'RS Siloam',
            'RS Sari Asih',
            'RS Medika',
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
