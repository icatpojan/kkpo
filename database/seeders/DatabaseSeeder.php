<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // 1. Seed User
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Admin KKPO',
            'email' => 'admin@kkpo.id',
            'password' => bcrypt('password'),
            'role' => 'admin_cabor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Tentang KKPO
        DB::table('tentang_kkpos')->truncate();
        DB::table('tentang_kkpos')->insert([
            'judul' => 'Tentang KKPO',
            'konten' => 'Merupakan bidang yang Melaksanakan peran dan fungsi dalam mengelola kesehatan dan kesejahteraan pelaku olah raga dalam event atau kegiatan pertandingan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Struktur Organisasi
        DB::table('struktur_organisasis')->truncate();
        $jabatans = ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator Nakes', 'Anggota Tim Medis', 'Humas', 'Anggota', 'Anggota', 'Anggota', 'Anggota', 'Anggota', 'Anggota', 'Anggota', 'Anggota'];
        for ($i = 0; $i < 15; $i++) {
            DB::table('struktur_organisasis')->insert([
                'nama' => $i === 0 ? 'Karyadi' : $faker->name,
                'jabatan' => $jabatans[$i],
                'keterangan' => 'Pengurus Aktif 2026',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. KKPO Se Banten
        DB::table('kkpo_sebantens')->truncate();
        $kabkota = [
            'KONI Tangerang Selatan', 'KONI Kabupaten Tangerang', 'KONI Kota Tangerang',
            'KONI Serang Kabupaten', 'KONI Kota Serang', 'KONI Kota Cilegon',
            'KONI Pandeglang', 'KONI Lebak'
        ];
        foreach ($kabkota as $index => $wadah) {
            DB::table('kkpo_sebantens')->insert([
                'wadah' => $wadah,
                'npp' => 'NPP-'.(1000+$index),
                'alamat_kantor' => $faker->address,
                'no_tlp' => $faker->phoneNumber,
                'nama_personil' => $faker->name,
                'email' => $faker->safeEmail,
                'no_wa' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = count($kabkota); $i < 15; $i++) {
            DB::table('kkpo_sebantens')->insert([
                'wadah' => 'Wadah Olahraga ' . $faker->city,
                'npp' => 'NPP-'.(1000+$i),
                'alamat_kantor' => $faker->address,
                'no_tlp' => $faker->phoneNumber,
                'nama_personil' => $faker->name,
                'email' => $faker->safeEmail,
                'no_wa' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Pelaku Olahraga
        DB::table('pelaku_olahragas')->truncate();
        $caborList = ['Karate', 'Kempo', 'Pencak Silat', 'Taekwondo', 'Renang', 'Atletik', 'Badminton', 'Futsal', 'Basket'];
        for ($i = 1; $i <= 30; $i++) {
            $kategori = $faker->randomElement(['atlit', 'atlit', 'atlit', 'pelatih', 'official', 'koni']);
            
            $data = [
                'kategori' => $kategori,
                'nama' => ($i === 1) ? 'Karyadi' : (($i === 2) ? 'Hendi' : $faker->name),
                'jk' => $faker->randomElement(['L', 'P']),
                'ttl' => $faker->city . ', ' . $faker->date('Y-m-d'),
                'nik' => $faker->nik(),
                'no_wa' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'riwayat_kesehatan' => $faker->randomElement(['Sehat', 'Tidak ada riwayat', 'Alergi dingin', 'Asma ringan']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($kategori !== 'koni') {
                $data['cabor'] = ($i === 1) ? 'Karate' : (($i === 2) ? 'Kempo' : $faker->randomElement($caborList));
                $data['kel_cabor'] = 'Bela Diri';
                $data['kontingen'] = ($i === 1) ? 'TANGSEL' : (($i === 2) ? 'SERANG KOTA' : $faker->randomElement(['TANGSEL', 'KOTA TANGERANG', 'KAB TANGERANG']));
            } else {
                $data['bagian'] = 'Kesehatan';
                $data['koni'] = 'KONI TANGSEL';
            }

            DB::table('pelaku_olahragas')->insert($data);
        }

        // 6. Data Cedera
        DB::table('data_cederas')->truncate();
        $statusList = ['cedera', 'rujuk', 'sembuh'];
        for ($i = 1; $i <= 20; $i++) {
            $pelaku_id = $faker->numberBetween(1, 30);
            DB::table('data_cederas')->insert([
                'pelaku_olahraga_id' => $pelaku_id,
                'waktu_kejadian' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d H:i:s'),
                'event' => 'Pekan Olahraga Provinsi ' . $faker->year,
                'venue' => $faker->randomElement(['KODIKLAT TANGSEL', 'GOR Tangerang', 'PCC', 'Stadion Banten']),
                'bagian_cedera' => $faker->randomElement(['Lutut', 'Pergelangan Tangan', 'Ankle', 'Pundak', 'Paha']),
                'kronologis' => $faker->randomElement(['Saat kuda-kuda ditendang lawan', 'Terjatuh saat melompat', 'Benturan saat berebut bola', 'Salah tumpuan saat mendarat', 'Tangan tertekuk saat dibanting']),
                'penanganan' => $faker->randomElement(['Kompres, pemberian analgetik', 'Kompres, massage, pemberian obat', 'Dibidai dan dirujuk ke RS', 'Pemberian oksigen dan istirahat']),
                'status' => $faker->randomElement($statusList),
                'keterangan' => $faker->randomElement(['DI RUJUK KE RS PREMIER', 'SEMBUH', 'Dalam Pemantauan Dokter', '-']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. Jadwal Pertandingan
        DB::table('jadwal_pertandingans')->truncate();
        for ($i = 1; $i <= 15; $i++) {
            DB::table('jadwal_pertandingans')->insert([
                'jenis_cabor' => $faker->randomElement($caborList),
                'kel_cabor' => 'Bela Diri',
                'venue' => $faker->randomElement(['KODIKLAT TANGSEL', 'GOR Tangerang', 'PCC', 'Stadion Banten']),
                'jumlah_lapangan' => $faker->numberBetween(1, 5),
                'tanggal' => Carbon::now()->addDays(rand(1, 14))->format('Y-m-d'),
                'waktu' => $faker->time('H:i'),
                'nakes' => 'Tim ' . $faker->lastName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 8. Nakes Jaga
        DB::table('nakes_jagas')->truncate();
        for ($i = 1; $i <= 15; $i++) {
            DB::table('nakes_jagas')->insert([
                'tanggal' => Carbon::now()->subDays(rand(0, 10))->format('Y-m-d'),
                'cabor' => $faker->randomElement($caborList),
                'venue' => $faker->randomElement(['PCC', 'KODIKLAT TANGSEL', 'GOR Tangerang']),
                'instansi' => 'PKM ' . $faker->randomElement(['PAMULANG', 'SERPONG', 'CIPUTAT', 'PONDOK AREN']),
                'nama_ketua_team' => $faker->name,
                'no_wa' => $faker->phoneNumber,
                'personil' => 'Andri, Heru, Driver',
                'jumlah_cedera' => $faker->numberBetween(0, 5),
                'keterangan' => 'Standby aman',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 9. Berita
        DB::table('beritas')->truncate();
        for ($i = 1; $i <= 15; $i++) {
            DB::table('beritas')->insert([
                'judul' => 'Berita Olahraga: ' . $faker->sentence(4),
                'konten' => '<p>' . implode('</p><p>', $faker->paragraphs(3)) . '</p>',
                'tanggal_publikasi' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 10. Kegiatan
        DB::table('kegiatans')->truncate();
        for ($i = 1; $i <= 15; $i++) {
            DB::table('kegiatans')->insert([
                'nama_kegiatan' => 'Kegiatan ' . $faker->words(3, true),
                'tanggal' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'lokasi' => $faker->city,
                'deskripsi' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 11. Hero Section
        DB::table('hero_sections')->truncate();
        DB::table('hero_sections')->insert([
            'judul' => 'Sistem Informasi KKPO KONI Tangerang Selatan',
            'sub_judul' => 'Mengelola kesehatan dan kesejahteraan pelaku olahraga dengan cepat, tepat, dan terintegrasi.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
