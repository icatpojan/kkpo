<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        Schema::disableForeignKeyConstraints();

        // 1. Seed User
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('users')->insert([
            'name' => 'Admin KKPO',
            'email' => 'admin@kkpo.id',
            'password' => bcrypt('password'),
            'role' => 'admin_cabor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Tentang KKPO
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tentang_kkpos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('tentang_kkpos')->insert([
            'judul' => 'Tentang KKPO',
            'konten' => 'Merupakan bidang yang Melaksanakan peran dan fungsi dalam mengelola kesehatan dan kesejahteraan pelaku olah raga dalam event atau kegiatan pertandingan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Struktur Organisasi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('struktur_organisasis')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('struktur_organisasis')->insert([
            ['nama' => 'Karyadi', 'jabatan' => 'Ketua', 'keterangan' => 'Pengurus Aktif 2026', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Hendi Setiawan', 'jabatan' => 'Wakil Ketua', 'keterangan' => 'Pengurus Aktif 2026', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Siti Aminah', 'jabatan' => 'Sekretaris', 'keterangan' => 'Pengurus Aktif 2026', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Rina Sulistyaningsih', 'jabatan' => 'Bendahara', 'keterangan' => 'Pengurus Aktif 2026', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Hero Section
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hero_sections')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('hero_sections')->insert([
            'judul' => 'Sistem Informasi KKPO KONI Tangerang Selatan',
            'sub_judul' => 'Mengelola kesehatan dan kesejahteraan pelaku olahraga dengan cepat, tepat, dan terintegrasi.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Panggil seeder terpisah (Berurutan agar FK tidak konflik)
        $this->call([
            ConfigToDatabaseSeeder::class,
            KegiatanSeeder::class,
            JadwalPertandinganSeeder::class,
            PelakuOlahragaSeeder::class,
            MasterNakesSeeder::class,
            NakesJagaSeeder::class,
            DataCederaSeeder::class,
            BeritaSeeder::class,
            KkpoSebantenSeeder::class,
            NakesAbsenSeeder::class,
            UserRolesSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
