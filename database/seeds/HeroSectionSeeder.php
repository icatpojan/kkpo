<?php

use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\HeroSection::create([
            'judul' => 'Kesehatan Prima, <span>Prestasi</span> Maksimal',
            'sub_judul' => 'Klinik Kesehatan Pelaku Olahraga (KKPO) KONI Tangerang Selatan siap mengawal dan memastikan setiap atlet berada dalam kondisi puncak untuk meraih kemenangan.',
            'gambar' => null, // Default to null initially so it uses the asset path in blade
        ]);
    }
}
