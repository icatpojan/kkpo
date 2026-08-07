<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
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
        $tentang = [
            ['judul' => 'Tentang KKPO', 'konten' => 'Merupakan bidang yang Melaksanakan peran dan fungsi dalam mengelola kesehatan dan kesejahteraan pelaku olah raga dalam event atau kegiatan pertandingan.'],
            ['judul' => 'Visi Kami', 'konten' => 'Mewujudkan kesejahteraan pelaku olahraga yang unggul, profesional, dan berstandar medis terbaik di tingkat nasional.'],
            ['judul' => 'Misi Pertama', 'konten' => 'Memberikan layanan kesehatan pertama yang cepat dan tepat saat terjadi cedera di lapangan.'],
            ['judul' => 'Misi Kedua', 'konten' => 'Mengelola sistem rekam medis atlet yang terintegrasi untuk pemantauan jangka panjang.'],
            ['judul' => 'Fokus Utama', 'konten' => 'Pencegahan, penanganan cepat, dan rehabilitasi atlet pasca cedera olahraga.'],
            ['judul' => 'Jejaring RS', 'konten' => 'Kami bekerja sama dengan berbagai Rumah Sakit terkemuka di Banten untuk proses rujukan atlet yang mengalami cedera parah.'],
            ['judul' => 'Pusat Pemulihan', 'konten' => 'Menyediakan fasilitas pemulihan fisik dan mental bagi atlet yang sedang dalam masa penyembuhan.'],
            ['judul' => 'Layanan Konsultasi', 'konten' => 'Memberikan layanan konsultasi gizi dan psikologi olahraga bagi atlet binaan KONI.'],
            ['judul' => 'Edukasi Nakes', 'konten' => 'Melatih para tenaga kesehatan (Puskesmas/Klinik) agar terampil menangani cedera olahraga spesifik.'],
            ['judul' => 'Peran Penting', 'konten' => 'Mengawal setiap event pertandingan olahraga agar aman dari risiko fatal.'],
            ['judul' => 'Sistem IT Terpadu', 'konten' => 'Menggunakan aplikasi digital untuk mendata seluruh riwayat medis atlet Banten secara real-time.'],
            ['judul' => 'Tim Reaksi Cepat', 'konten' => 'Tim ambulans dan medis lapangan selalu standby di setiap arena pertandingan.'],
            ['judul' => 'Komitmen Kami', 'konten' => 'Kesehatan atlet adalah aset terbesar bangsa yang harus dijaga tanpa kompromi.'],
            ['judul' => 'Dukungan Pemerintah', 'konten' => 'Program ini didukung penuh oleh Pemerintah Kota Tangerang Selatan melalui Dispora.'],
            ['judul' => 'Moto KKPO', 'konten' => 'Kesehatan Terjaga, Prestasi Gemilang. Kami siap mendukung setiap langkah kemenangan Anda.'],
        ];
        foreach ($tentang as $t) {
            DB::table('tentang_kkpos')->insert(array_merge($t, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 3. Struktur Organisasi
        DB::table('struktur_organisasis')->truncate();
        $struktur = [
            ['nama' => 'Karyadi', 'jabatan' => 'Ketua', 'keterangan' => 'Pengurus Aktif'],
            ['nama' => 'dr. Andi Pratama, Sp.KO', 'jabatan' => 'Wakil Ketua', 'keterangan' => 'Bidang Medis'],
            ['nama' => 'Hendi Suhendar', 'jabatan' => 'Sekretaris', 'keterangan' => 'Administrasi'],
            ['nama' => 'Siti Aminah, S.E.', 'jabatan' => 'Bendahara', 'keterangan' => 'Keuangan'],
            ['nama' => 'dr. Budi Santoso', 'jabatan' => 'Koordinator Nakes', 'keterangan' => 'Koordinator Lapangan'],
            ['nama' => 'Rina Melati, S.Kep', 'jabatan' => 'Kepala Perawat', 'keterangan' => 'Tim Medis Internal'],
            ['nama' => 'Ahmad Fauzan', 'jabatan' => 'Humas', 'keterangan' => 'Hubungan Masyarakat'],
            ['nama' => 'Doni Setiawan', 'jabatan' => 'Anggota', 'keterangan' => 'Bidang Perlengkapan Medis'],
            ['nama' => 'dr. Citra Kirana', 'jabatan' => 'Anggota', 'keterangan' => 'Tim Psikolog Olahraga'],
            ['nama' => 'Drg. Faisal', 'jabatan' => 'Anggota', 'keterangan' => 'Dokter Gigi Spesialis'],
            ['nama' => 'Nina Marlina', 'jabatan' => 'Anggota', 'keterangan' => 'Fisioterapis Utama'],
            ['nama' => 'Rizal Efendi', 'jabatan' => 'Anggota', 'keterangan' => 'Seksi Transportasi Medis'],
            ['nama' => 'Dwi Handayani', 'jabatan' => 'Anggota', 'keterangan' => 'Seksi Konsumsi Atlet'],
            ['nama' => 'Rahmat Hidayat', 'jabatan' => 'Anggota', 'keterangan' => 'Seksi Pendataan IT'],
            ['nama' => 'dr. Zulfikar', 'jabatan' => 'Anggota', 'keterangan' => 'Dokter Jaga Khusus Bela Diri'],
        ];
        foreach ($struktur as $s) {
            DB::table('struktur_organisasis')->insert(array_merge($s, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 4. KKPO Se Banten
        DB::table('kkpo_sebantens')->truncate();
        $kkpos = [
            ['wadah' => 'KONI Tangerang Selatan', 'npp' => 'NPP-1001', 'alamat_kantor' => 'Jl. Pahlawan Seribu No. 1, Tangsel', 'no_tlp' => '021-7401122', 'nama_personil' => 'Karyadi'],
            ['wadah' => 'KONI Kabupaten Tangerang', 'npp' => 'NPP-1002', 'alamat_kantor' => 'Komplek Pemda Tigaraksa', 'no_tlp' => '021-5991234', 'nama_personil' => 'Bambang S.'],
            ['wadah' => 'KONI Kota Tangerang', 'npp' => 'NPP-1003', 'alamat_kantor' => 'Jl. TMP Taruna Raya, Kota Tangerang', 'no_tlp' => '021-5523441', 'nama_personil' => 'Herman'],
            ['wadah' => 'KONI Serang Kabupaten', 'npp' => 'NPP-1004', 'alamat_kantor' => 'Alun-alun Kramatwatu, Kab Serang', 'no_tlp' => '0254-201999', 'nama_personil' => 'Syaiful'],
            ['wadah' => 'KONI Kota Serang', 'npp' => 'NPP-1005', 'alamat_kantor' => 'Stadion Maulana Yusuf, Serang', 'no_tlp' => '0254-221888', 'nama_personil' => 'Deny A.'],
            ['wadah' => 'KONI Kota Cilegon', 'npp' => 'NPP-1006', 'alamat_kantor' => 'Jl. Jenderal Sudirman, Cilegon', 'no_tlp' => '0254-394000', 'nama_personil' => 'Lukman Hakim'],
            ['wadah' => 'KONI Pandeglang', 'npp' => 'NPP-1007', 'alamat_kantor' => 'Alun-alun Pandeglang', 'no_tlp' => '0253-201555', 'nama_personil' => 'Tubagus A.'],
            ['wadah' => 'KONI Lebak', 'npp' => 'NPP-1008', 'alamat_kantor' => 'Stadion Ona, Rangkasbitung, Lebak', 'no_tlp' => '0252-202222', 'nama_personil' => 'Mulyadi'],
            ['wadah' => 'Dispora Tangsel', 'npp' => 'NPP-2001', 'alamat_kantor' => 'Gedung III Pemkot Tangsel', 'no_tlp' => '021-7554433', 'nama_personil' => 'Wiwik'],
            ['wadah' => 'Klinik Atlet Banten', 'npp' => 'NPP-3001', 'alamat_kantor' => 'Jl. Raya Serang KM 14', 'no_tlp' => '0254-555112', 'nama_personil' => 'dr. Faisal'],
            ['wadah' => 'Puskesmas Pamulang', 'npp' => 'NPP-4001', 'alamat_kantor' => 'Jl. Surya Kencana, Pamulang', 'no_tlp' => '021-7412233', 'nama_personil' => 'dr. Citra'],
            ['wadah' => 'Puskesmas Serpong', 'npp' => 'NPP-4002', 'alamat_kantor' => 'BSD City Sektor 1', 'no_tlp' => '021-5371122', 'nama_personil' => 'dr. Andika'],
            ['wadah' => 'RSUD Tangsel', 'npp' => 'NPP-5001', 'alamat_kantor' => 'Pamulang Barat, Tangsel', 'no_tlp' => '021-7471199', 'nama_personil' => 'dr. Indah'],
            ['wadah' => 'RS Premier Bintaro', 'npp' => 'NPP-5002', 'alamat_kantor' => 'Bintaro Jaya Sektor 7', 'no_tlp' => '021-27625500', 'nama_personil' => 'drg. Lina'],
            ['wadah' => 'Satgas Medis Porprov', 'npp' => 'NPP-6001', 'alamat_kantor' => 'KODIKLAT TNI, Serpong', 'no_tlp' => '021-5389900', 'nama_personil' => 'Kapten Medis'],
        ];
        foreach ($kkpos as $k) {
            DB::table('kkpo_sebantens')->insert(array_merge($k, ['email' => 'info@kkpobanten.id', 'no_wa' => '081234567890', 'created_at' => now(), 'updated_at' => now()]));
        }

        // 5. Pelaku Olahraga
        DB::table('pelaku_olahragas')->truncate();
        $pelaku = [
            ['kategori' => 'atlit', 'nama' => 'Karyadi', 'jk' => 'L', 'cabor' => 'Karate', 'kel_cabor' => 'Bela Diri', 'kontingen' => 'TANGSEL', 'riwayat_kesehatan' => 'Tidak ada riwayat serius', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Hendi', 'jk' => 'L', 'cabor' => 'Kempo', 'kel_cabor' => 'Bela Diri', 'kontingen' => 'SERANG KOTA', 'riwayat_kesehatan' => 'Sehat', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Nabila Putri', 'jk' => 'P', 'cabor' => 'Pencak Silat', 'kel_cabor' => 'Bela Diri', 'kontingen' => 'TANGSEL', 'riwayat_kesehatan' => 'Pernah asma ringan', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Kevin Sanjaya', 'jk' => 'L', 'cabor' => 'Badminton', 'kel_cabor' => 'Raket', 'kontingen' => 'KOTA TANGERANG', 'riwayat_kesehatan' => 'Alergi makanan laut', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Riska Meilani', 'jk' => 'P', 'cabor' => 'Renang', 'kel_cabor' => 'Akuatik', 'kontingen' => 'KAB TANGERANG', 'riwayat_kesehatan' => 'Sehat', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Budi Gunawan', 'jk' => 'L', 'cabor' => 'Futsal', 'kel_cabor' => 'Bola Besar', 'kontingen' => 'TANGSEL', 'riwayat_kesehatan' => 'Pernah patah tulang kaki kanan', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Sinta Nuriyah', 'jk' => 'P', 'cabor' => 'Atletik', 'kel_cabor' => 'Lintasan', 'kontingen' => 'CILEGON', 'riwayat_kesehatan' => 'Sehat', 'bagian' => null, 'koni' => null],
            ['kategori' => 'atlit', 'nama' => 'Fajar Alfian', 'jk' => 'L', 'cabor' => 'Taekwondo', 'kel_cabor' => 'Bela Diri', 'kontingen' => 'LEBAK', 'riwayat_kesehatan' => 'Sehat', 'bagian' => null, 'koni' => null],
            ['kategori' => 'pelatih', 'nama' => 'Coach Yudi', 'jk' => 'L', 'cabor' => 'Karate', 'kel_cabor' => 'Bela Diri', 'kontingen' => 'TANGSEL', 'riwayat_kesehatan' => 'Kolesterol tinggi', 'bagian' => null, 'koni' => null],
            ['kategori' => 'pelatih', 'nama' => 'Coach Sarah', 'jk' => 'P', 'cabor' => 'Renang', 'kel_cabor' => 'Akuatik', 'kontingen' => 'KOTA TANGERANG', 'riwayat_kesehatan' => 'Sehat', 'bagian' => null, 'koni' => null],
            ['kategori' => 'official', 'nama' => 'Agus Santoso', 'jk' => 'L', 'cabor' => 'Badminton', 'kel_cabor' => 'Raket', 'kontingen' => 'TANGSEL', 'riwayat_kesehatan' => 'Hipertensi', 'bagian' => null, 'koni' => null],
            ['kategori' => 'official', 'nama' => 'Diana Susanti', 'jk' => 'P', 'cabor' => 'Atletik', 'kel_cabor' => 'Lintasan', 'kontingen' => 'SERANG KOTA', 'riwayat_kesehatan' => 'Alergi debu', 'bagian' => null, 'koni' => null],
            ['kategori' => 'koni', 'nama' => 'Bapak Sudirman', 'jk' => 'L', 'cabor' => null, 'kel_cabor' => null, 'kontingen' => null, 'riwayat_kesehatan' => 'Sehat', 'bagian' => 'Bidang Prestasi', 'koni' => 'KONI TANGSEL'],
            ['kategori' => 'koni', 'nama' => 'Ibu Rahmawati', 'jk' => 'P', 'cabor' => null, 'kel_cabor' => null, 'kontingen' => null, 'riwayat_kesehatan' => 'Diabetes melitus', 'bagian' => 'Bidang Kesehatan', 'koni' => 'KONI TANGSEL'],
            ['kategori' => 'koni', 'nama' => 'dr. Anton', 'jk' => 'L', 'cabor' => null, 'kel_cabor' => null, 'kontingen' => null, 'riwayat_kesehatan' => 'Sehat', 'bagian' => 'Kepala Klinik KKPO', 'koni' => 'KONI TANGSEL'],
        ];
        foreach ($pelaku as $index => $p) {
            DB::table('pelaku_olahragas')->insert(array_merge($p, [
                'ttl' => 'Tangerang, ' . (1990 + $index) . '-01-01',
                'nik' => '367401' . rand(1000000000, 9999999999),
                'no_wa' => '0812' . rand(10000000, 99999999),
                'alamat' => 'Perumahan BSD Sektor ' . rand(1, 14),
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // 6. Data Cedera
        DB::table('data_cederas')->truncate();
        $cedera = [
            ['waktu_kejadian' => '2026-12-12 12:00:00', 'event' => 'PORPROV', 'venue' => 'KODIKLAT TANGSEL', 'bagian_cedera' => 'LUTUT', 'kronologis' => 'Saat kuda-kuda ditendang lawan pada sesi sparing babak penyisihan', 'penanganan' => 'Kompres es dan pemberian analgetik', 'status' => 'rujuk', 'keterangan' => 'DI RUJUK KE RS PREMIER BINTARO'],
            ['waktu_kejadian' => '2026-12-13 14:30:00', 'event' => 'PORPROV', 'venue' => 'GOR Pamulang', 'bagian_cedera' => 'PERGELANGAN TANGAN', 'kronologis' => 'Tangan tertekuk secara paksa saat dibanting oleh lawan', 'penanganan' => 'Kompres dingin, massage ringan, pemberian obat anti radang', 'status' => 'sembuh', 'keterangan' => 'Sudah bisa berlatih ringan'],
            ['waktu_kejadian' => '2026-12-14 09:15:00', 'event' => 'KEJURDA BANTEN', 'venue' => 'Stadion Maulana Yusuf', 'bagian_cedera' => 'ANKLE KANAN', 'kronologis' => 'Salah mendarat saat melakukan lompatan jauh', 'penanganan' => 'Dibidai dengan elastic bandage', 'status' => 'cedera', 'keterangan' => 'Dalam pantauan fisioterapis harian'],
            ['waktu_kejadian' => '2026-12-15 16:45:00', 'event' => 'PORPROV', 'venue' => 'Kolam Renang BSD', 'bagian_cedera' => 'BAHU KIRI', 'kronologis' => 'Kelelahan otot saat melakukan gaya kupu-kupu di putaran terakhir', 'penanganan' => 'Istirahat total dan terapi pemanasan', 'status' => 'sembuh', 'keterangan' => 'Otot sudah rileks'],
            ['waktu_kejadian' => '2026-12-16 11:20:00', 'event' => 'KEJURNAS', 'venue' => 'GOR Tangerang', 'bagian_cedera' => 'PELIPIS', 'kronologis' => 'Terkena sikutan lawan saat berebut bola di udara', 'penanganan' => 'Pembersihan luka dan jahit luar', 'status' => 'rujuk', 'keterangan' => 'Dirujuk ke IGD RSUD Tangsel'],
            ['waktu_kejadian' => '2026-12-17 10:00:00', 'event' => 'LATIHAN BERSAMA', 'venue' => 'KODIKLAT TANGSEL', 'bagian_cedera' => 'JARI TANGAN', 'kronologis' => 'Jari telunjuk terkilir karena salah menangkis pukulan', 'penanganan' => 'Pemberian kinesio tape', 'status' => 'sembuh', 'keterangan' => 'Bisa lanjut tanding'],
            ['waktu_kejadian' => '2026-12-18 13:10:00', 'event' => 'PORPROV', 'venue' => 'PCC', 'bagian_cedera' => 'PAHA KANAN', 'kronologis' => 'Kram otot hamstring saat lari sprint', 'penanganan' => 'Stretching dan semprotan ethyl chloride', 'status' => 'sembuh', 'keterangan' => '-'],
            ['waktu_kejadian' => '2026-12-19 15:50:00', 'event' => 'KEJURDA', 'venue' => 'GOR Serpong', 'bagian_cedera' => 'HIDUNG', 'kronologis' => 'Terkena tendangan memutar dari lawan', 'penanganan' => 'Hentikan perdarahan dengan tampon', 'status' => 'rujuk', 'keterangan' => 'Observasi patah tulang rawan di RS'],
            ['waktu_kejadian' => '2026-12-20 08:30:00', 'event' => 'LATIHAN FISIK', 'venue' => 'Taman Kota 1', 'bagian_cedera' => 'TELAPAK KAKI', 'kronologis' => 'Lecet parah akibat sepatu yang kurang pas', 'penanganan' => 'Pembersihan dan pemberian plester', 'status' => 'sembuh', 'keterangan' => 'Ganti sepatu standar'],
            ['waktu_kejadian' => '2026-12-21 16:00:00', 'event' => 'PORPROV', 'venue' => 'GOR Ciputat', 'bagian_cedera' => 'PINGGANG', 'kronologis' => 'Sakit mendadak saat membungkuk menahan beban lawan', 'penanganan' => 'Kompres hangat dan bed rest', 'status' => 'cedera', 'keterangan' => 'Masih butuh observasi'],
            ['waktu_kejadian' => '2026-12-22 14:00:00', 'event' => 'SELEKSI ATLET', 'venue' => 'Stadion Mini Ciputat', 'bagian_cedera' => 'OTOT BETIS', 'kronologis' => 'Tertendang secara tidak sengaja oleh teman latihan', 'penanganan' => 'Pemberian semprotan pereda nyeri', 'status' => 'sembuh', 'keterangan' => '-'],
            ['waktu_kejadian' => '2026-12-23 09:00:00', 'event' => 'PORPROV', 'venue' => 'KODIKLAT TANGSEL', 'bagian_cedera' => 'LEHER', 'kronologis' => 'Salah urat saat melakukan gerakan pemanasan', 'penanganan' => 'Diberikan balsem dan neck collar', 'status' => 'cedera', 'keterangan' => 'Disarankan tidak bertanding hari ini'],
            ['waktu_kejadian' => '2026-12-24 11:45:00', 'event' => 'KEJURNAS JUNIOR', 'venue' => 'PCC', 'bagian_cedera' => 'DADA', 'kronologis' => 'Sesak napas saat bertanding akibat asma kambuh', 'penanganan' => 'Pemberian inhaler dan oksigen', 'status' => 'sembuh', 'keterangan' => 'Istirahat di ruang medis'],
            ['waktu_kejadian' => '2026-12-25 15:30:00', 'event' => 'FINAL PORPROV', 'venue' => 'GOR Tangerang', 'bagian_cedera' => 'LENGAN KANAN', 'kronologis' => 'Benturan keras dengan tiang pembatas lapangan', 'penanganan' => 'Pengecekan rontgen sementara di lokasi', 'status' => 'rujuk', 'keterangan' => 'Dirujuk ke RS Sari Asih'],
            ['waktu_kejadian' => '2026-12-26 10:20:00', 'event' => 'EKSBISI', 'venue' => 'Bintaro Xchange', 'bagian_cedera' => 'TULANG KERING', 'kronologis' => 'Bertubrukan langsung dengan lutut lawan', 'penanganan' => 'Kompres es dan pemberian perban', 'status' => 'cedera', 'keterangan' => 'Bengkak masih besar'],
        ];
        foreach ($cedera as $index => $c) {
            DB::table('data_cederas')->insert(array_merge($c, [
                'pelaku_olahraga_id' => ($index % 10) + 1,
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        // 7. Jadwal Pertandingan
        DB::table('jadwal_pertandingans')->truncate();
        $jadwal = [
            ['jenis_cabor' => 'KARATE', 'kel_cabor' => 'BELA DIRI', 'venue' => 'KODIKLAT TANGSEL', 'jumlah_lapangan' => 3, 'tanggal' => '2026-12-10', 'waktu' => '08:00', 'nakes' => 'Tim Puskesmas Pamulang'],
            ['jenis_cabor' => 'KEMPO', 'kel_cabor' => 'BELA DIRI', 'venue' => 'PCC', 'jumlah_lapangan' => 2, 'tanggal' => '2026-12-11', 'waktu' => '09:00', 'nakes' => 'Tim Puskesmas Serpong'],
            ['jenis_cabor' => 'PENCAK SILAT', 'kel_cabor' => 'BELA DIRI', 'venue' => 'GOR Banten', 'jumlah_lapangan' => 4, 'tanggal' => '2026-12-12', 'waktu' => '10:00', 'nakes' => 'Tim RSUD Tangsel'],
            ['jenis_cabor' => 'TAEKWONDO', 'kel_cabor' => 'BELA DIRI', 'venue' => 'GOR Pamulang', 'jumlah_lapangan' => 2, 'tanggal' => '2026-12-13', 'waktu' => '13:00', 'nakes' => 'Tim Klinik Medika'],
            ['jenis_cabor' => 'RENANG', 'kel_cabor' => 'AKUATIK', 'venue' => 'Kolam Renang BSD', 'jumlah_lapangan' => 1, 'tanggal' => '2026-12-14', 'waktu' => '08:30', 'nakes' => 'Tim RS Premier Bintaro'],
            ['jenis_cabor' => 'ATLETIK', 'kel_cabor' => 'LINTASAN', 'venue' => 'Stadion Maulana Yusuf', 'jumlah_lapangan' => 1, 'tanggal' => '2026-12-15', 'waktu' => '07:00', 'nakes' => 'Tim Medis KONI Serang'],
            ['jenis_cabor' => 'BADMINTON', 'kel_cabor' => 'RAKET', 'venue' => 'GOR Serpong', 'jumlah_lapangan' => 6, 'tanggal' => '2026-12-16', 'waktu' => '10:00', 'nakes' => 'Tim Puskesmas Setu'],
            ['jenis_cabor' => 'FUTSAL', 'kel_cabor' => 'BOLA BESAR', 'venue' => 'Tangerang Futsal Center', 'jumlah_lapangan' => 2, 'tanggal' => '2026-12-17', 'waktu' => '15:00', 'nakes' => 'Tim Medis Futsal'],
            ['jenis_cabor' => 'BASKET', 'kel_cabor' => 'BOLA BESAR', 'venue' => 'GOR Ciputat', 'jumlah_lapangan' => 1, 'tanggal' => '2026-12-18', 'waktu' => '14:00', 'nakes' => 'Tim RS IMC Bintaro'],
            ['jenis_cabor' => 'VOLI', 'kel_cabor' => 'BOLA BESAR', 'venue' => 'GOR Jombang', 'jumlah_lapangan' => 2, 'tanggal' => '2026-12-19', 'waktu' => '16:00', 'nakes' => 'Tim Klinik Bhakti'],
            ['jenis_cabor' => 'TENIS MEJA', 'kel_cabor' => 'RAKET', 'venue' => 'Aula Pemkot Tangsel', 'jumlah_lapangan' => 8, 'tanggal' => '2026-12-20', 'waktu' => '09:00', 'nakes' => 'Tim Medis Internal KONI'],
            ['jenis_cabor' => 'CATUR', 'kel_cabor' => 'PAPAN', 'venue' => 'Hotel Santika Premiere Bintaro', 'jumlah_lapangan' => 20, 'tanggal' => '2026-12-21', 'waktu' => '10:00', 'nakes' => 'Tim Puskesmas Pondok Aren'],
            ['jenis_cabor' => 'TINJU', 'kel_cabor' => 'BELA DIRI', 'venue' => 'PCC', 'jumlah_lapangan' => 1, 'tanggal' => '2026-12-22', 'waktu' => '19:00', 'nakes' => 'Tim Khusus RSUD Banten'],
            ['jenis_cabor' => 'SEPAK BOLA', 'kel_cabor' => 'BOLA BESAR', 'venue' => 'Stadion Mini Ciputat', 'jumlah_lapangan' => 1, 'tanggal' => '2026-12-23', 'waktu' => '15:30', 'nakes' => 'Tim Ambulans PMI Tangsel'],
            ['jenis_cabor' => 'PANAHAN', 'kel_cabor' => 'TARGET', 'venue' => 'Lapangan Sunburst BSD', 'jumlah_lapangan' => 10, 'tanggal' => '2026-12-24', 'waktu' => '08:00', 'nakes' => 'Tim Klinik Mata & Bedah'],
        ];
        foreach ($jadwal as $j) {
            DB::table('jadwal_pertandingans')->insert(array_merge($j, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 7.5 Master Nakes
        DB::table('master_nakes')->truncate();
        $master_nakes = [
            ['nama' => 'Hendi', 'spesialisasi' => 'Perawat', 'no_str' => 'STR-12345', 'instansi' => 'PKM PAMULANG', 'no_wa' => '0988776655'],
            ['nama' => 'dr. Andika', 'spesialisasi' => 'Dokter Umum', 'no_str' => 'STR-12346', 'instansi' => 'PKM SERPONG', 'no_wa' => '081299998888'],
            ['nama' => 'dr. Indah', 'spesialisasi' => 'Dokter Umum', 'no_str' => 'STR-12347', 'instansi' => 'RSUD Tangsel', 'no_wa' => '087711223344'],
            ['nama' => 'Suster Dina', 'spesialisasi' => 'Perawat', 'no_str' => 'STR-12348', 'instansi' => 'Klinik Medika', 'no_wa' => '085612341234'],
            ['nama' => 'drg. Lina', 'spesialisasi' => 'Dokter Gigi', 'no_str' => 'STR-12349', 'instansi' => 'RS Premier Bintaro', 'no_wa' => '081199887766'],
            ['nama' => 'dr. Budi Santoso', 'spesialisasi' => 'Dokter Olahraga', 'no_str' => 'STR-12350', 'instansi' => 'KONI Medis', 'no_wa' => '082233445566'],
            ['nama' => 'Bidan Yuli', 'spesialisasi' => 'Bidan', 'no_str' => 'STR-12351', 'instansi' => 'PKM SETU', 'no_wa' => '083344556677'],
            ['nama' => 'Agus Perawat', 'spesialisasi' => 'Perawat', 'no_str' => 'STR-12352', 'instansi' => 'Tim Futsal Medis', 'no_wa' => '081211112222'],
            ['nama' => 'dr. Anton', 'spesialisasi' => 'Dokter Bedah', 'no_str' => 'STR-12353', 'instansi' => 'RS IMC Bintaro', 'no_wa' => '081322223333'],
            ['nama' => 'dr. Wahyu', 'spesialisasi' => 'Dokter Umum', 'no_str' => 'STR-12354', 'instansi' => 'Klinik Bhakti', 'no_wa' => '081433334444'],
            ['nama' => 'Rina Melati', 'spesialisasi' => 'Perawat', 'no_str' => 'STR-12355', 'instansi' => 'Tim Medis KONI', 'no_wa' => '081544445555'],
            ['nama' => 'Dr. Laras', 'spesialisasi' => 'Dokter Umum', 'no_str' => 'STR-12356', 'instansi' => 'PKM PONDOK AREN', 'no_wa' => '081655556666'],
            ['nama' => 'dr. Bedah', 'spesialisasi' => 'Dokter Bedah', 'no_str' => 'STR-12357', 'instansi' => 'RSUD Banten Khusus', 'no_wa' => '081766667777'],
            ['nama' => 'Relawan Budi', 'spesialisasi' => 'PMI', 'no_str' => 'STR-12358', 'instansi' => 'PMI Tangsel', 'no_wa' => '081877778888'],
            ['nama' => 'dr. Mata', 'spesialisasi' => 'Dokter Spesialis', 'no_str' => 'STR-12359', 'instansi' => 'Klinik Mata & Bedah', 'no_wa' => '081988889999'],
        ];
        foreach ($master_nakes as $mn) {
            DB::table('master_nakes')->insert(array_merge($mn, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 8. Nakes Jaga
        DB::table('nakes_jagas')->truncate();
        $nakes = [
            ['tanggal' => '2026-12-10', 'cabor' => 'KARATE', 'venue' => 'KODIKLAT TANGSEL', 'nakes_id' => 1, 'personil' => 'Andri, Heru, Driver', 'jumlah_cedera' => 2, 'keterangan' => 'Semua cedera tertangani di tempat'],
            ['tanggal' => '2026-12-11', 'cabor' => 'KEMPO', 'venue' => 'PCC', 'nakes_id' => 2, 'personil' => 'Risa, Susi, Supir Ambulans', 'jumlah_cedera' => 1, 'keterangan' => 'Aman terkendali'],
            ['tanggal' => '2026-12-12', 'cabor' => 'PENCAK SILAT', 'venue' => 'GOR Banten', 'nakes_id' => 3, 'personil' => 'Lukman, Yanti, Doni, Driver', 'jumlah_cedera' => 4, 'keterangan' => '1 Rujukan ke IGD RSUD'],
            ['tanggal' => '2026-12-13', 'cabor' => 'TAEKWONDO', 'venue' => 'GOR Pamulang', 'nakes_id' => 4, 'personil' => 'Siska, Rizal', 'jumlah_cedera' => 3, 'keterangan' => 'Terjadi pendarahan hidung, sudah dibersihkan'],
            ['tanggal' => '2026-12-14', 'cabor' => 'RENANG', 'venue' => 'Kolam Renang BSD', 'nakes_id' => 5, 'personil' => 'Fery, Deni, Budi', 'jumlah_cedera' => 0, 'keterangan' => 'Hanya kasus kram ringan, tidak masuk rekapan serius'],
            ['tanggal' => '2026-12-15', 'cabor' => 'ATLETIK', 'venue' => 'Stadion Maulana Yusuf', 'nakes_id' => 6, 'personil' => 'Fisioterapis Intan, Perawat Agung', 'jumlah_cedera' => 5, 'keterangan' => 'Banyak cedera engkel akibat salah tumpuan'],
            ['tanggal' => '2026-12-16', 'cabor' => 'BADMINTON', 'venue' => 'GOR Serpong', 'nakes_id' => 7, 'personil' => 'Joko, Anwar, Rini', 'jumlah_cedera' => 1, 'keterangan' => 'Atlet kelelahan, diberikan tabung oksigen'],
            ['tanggal' => '2026-12-17', 'cabor' => 'FUTSAL', 'venue' => 'Tangerang Futsal', 'nakes_id' => 8, 'personil' => 'Tim Ambulans Swasta', 'jumlah_cedera' => 3, 'keterangan' => 'Benturan lutut dan kepala'],
            ['tanggal' => '2026-12-18', 'cabor' => 'BASKET', 'venue' => 'GOR Ciputat', 'nakes_id' => 9, 'personil' => 'Suster Nita, Fisioterapi Bima', 'jumlah_cedera' => 2, 'keterangan' => 'Cedera jari tangan'],
            ['tanggal' => '2026-12-19', 'cabor' => 'VOLI', 'venue' => 'GOR Jombang', 'nakes_id' => 10, 'personil' => 'Tika, Coki, Driver', 'jumlah_cedera' => 0, 'keterangan' => 'Pertandingan berjalan aman'],
            ['tanggal' => '2026-12-20', 'cabor' => 'TENIS MEJA', 'venue' => 'Aula Pemkot Tangsel', 'nakes_id' => 11, 'personil' => 'Beni, Cindy', 'jumlah_cedera' => 0, 'keterangan' => 'Tidak ada insiden'],
            ['tanggal' => '2026-12-21', 'cabor' => 'CATUR', 'venue' => 'Hotel Santika', 'nakes_id' => 12, 'personil' => 'Susi', 'jumlah_cedera' => 0, 'keterangan' => 'Satu orang atlet pusing, diberi obat pereda nyeri'],
            ['tanggal' => '2026-12-22', 'cabor' => 'TINJU', 'venue' => 'PCC', 'nakes_id' => 13, 'personil' => 'Tim Reaksi Cepat Bedah', 'jumlah_cedera' => 6, 'keterangan' => '2 Rujukan akibat pelipis robek parah'],
            ['tanggal' => '2026-12-23', 'cabor' => 'SEPAK BOLA', 'venue' => 'Stadion Ciputat', 'nakes_id' => 14, 'personil' => '6 Relawan PMI + 2 Ambulans', 'jumlah_cedera' => 4, 'keterangan' => 'Dehidrasi dan kram kaki'],
            ['tanggal' => '2026-12-24', 'cabor' => 'PANAHAN', 'venue' => 'Lapangan Sunburst', 'nakes_id' => 15, 'personil' => 'Perawat Lilis, Roni', 'jumlah_cedera' => 0, 'keterangan' => 'Aman terkendali sepanjang hari'],
        ];
        foreach ($nakes as $n) {
            DB::table('nakes_jagas')->insert(array_merge($n, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 9. Berita
        DB::table('beritas')->truncate();
        $berita = [
            ['judul' => 'Peresmian Aplikasi Sistem Manajemen KKPO KONI Tangsel', 'konten' => '<p>Hari ini secara resmi KONI Tangerang Selatan meluncurkan aplikasi terbaru untuk mengelola kesehatan atlet secara terpusat.</p><p>Aplikasi ini diharapkan dapat mempercepat proses pendataan dan penanganan cedera di lapangan. Dengan kerja sama berbagai RS, rujukan akan lebih mudah dilakukan.</p>'],
            ['judul' => 'Pelatihan Medis untuk Pelatih Bela Diri Tangsel', 'konten' => '<p>KONI Tangsel menyelenggarakan pelatihan pertolongan pertama khusus untuk pelatih cabang olahraga bela diri seperti Karate, Kempo, dan Pencak Silat.</p><p>Tujuan acara ini adalah agar pelatih mampu memberikan penanganan darurat sebelum petugas nakes tiba di lokasi pertandingan.</p>'],
            ['judul' => 'Sukses Mengawal Atlet di PORPROV VI Banten', 'konten' => '<p>Tim nakes KKPO berhasil menurunkan angka cedera parah pada PORPROV tahun ini melalui intervensi preventif dan screening ketat sebelum atlet bertanding.</p><p>Kepala tim nakes mengucapkan terima kasih kepada seluruh pihak, terutama puskesmas jejaring yang telah membantu proses screening.</p>'],
            ['judul' => 'Puskesmas Pamulang Raih Penghargaan Tim Nakes Terbaik', 'konten' => '<p>Dalam malam penganugerahan KONI Award, tim medis dari Puskesmas Pamulang mendapatkan predikat sebagai tim dengan respons tercepat di lapangan.</p><p>Mereka berhasil menangani belasan kasus cedera kritis selama kejuaraan daerah berlangsung.</p>'],
            ['judul' => 'RSUD Tangsel Tambah Bed Khusus Atlet Rujukan', 'konten' => '<p>Mendukung visi KKPO, RSUD Kota Tangerang Selatan menambah 5 tempat tidur khusus di ruang rawat inap bagi atlet yang membutuhkan tindakan operasi pasca cedera.</p>'],
            ['judul' => 'Pentingnya Pemanasan: Angka Cedera Menurun 30%', 'konten' => '<p>Menurut data dari aplikasi KKPO, terjadi penurunan angka cedera ligamen hingga 30% setelah digalakkannya kampanye pemanasan wajib selama 30 menit sebelum bertanding.</p>'],
            ['judul' => 'Seminar Nutrisi Olahraga Digelar Akhir Bulan Ini', 'konten' => '<p>KKPO tidak hanya mengurus cedera, tetapi juga gizi atlet. Kami akan menyelenggarakan seminar nutrisi yang mendatangkan pakar gizi olahraga nasional.</p><p>Seluruh atlet binaan KONI diwajibkan untuk hadir.</p>'],
            ['judul' => 'Tim Fisioterapi KONI Gunakan Metode Kinesio Taping Baru', 'konten' => '<p>Mulai tahun ini, seluruh staf medis lapangan dibekali dengan keahlian metode Kinesio Taping terbaru yang diklaim lebih cepat meredakan nyeri otot atlet saat turnamen beruntun.</p>'],
            ['judul' => 'Pemeriksaan Jantung Gratis bagi Atlet Lari Maraton', 'konten' => '<p>Mengingat tingginya beban kardiovaskular pada olahraga maraton, klinik KKPO memfasilitasi EKG dan USG Jantung gratis bagi 100 atlet atletik unggulan Banten.</p>'],
            ['judul' => 'Jangan Remehkan Kram Otot, Ini Pesan Dokter KONI', 'konten' => '<p>Kram otot sering dianggap sepele, namun dr. Andi Pratama mengingatkan bahwa kram berulang bisa menjadi indikasi ketidakseimbangan elektrolit atau micro-tear pada serabut otot yang bisa fatal jika dipaksa bertanding.</p>'],
            ['judul' => 'Stok Oksigen Portabel Siap Disalurkan ke Semua Venue', 'konten' => '<p>Menjelang ajang Pekan Olahraga Pelajar, KKPO telah mendistribusikan lebih dari 50 tabung oksigen portabel ke semua gelanggang olahraga di Tangsel.</p>'],
            ['judul' => 'Kerja Sama KKPO dan BPJS Ketenagakerjaan', 'konten' => '<p>Kini, seluruh pengobatan akibat cedera olahraga yang terjadi selama masa pemusatan latihan dan turnamen resmi akan di-cover penuh melalui skema BPJS Ketenagakerjaan kategori pekerja rentan.</p>'],
            ['judul' => 'Kunjungan KONI Pusat ke Klinik KKPO Tangsel', 'konten' => '<p>Perwakilan KONI Pusat memuji sistem pendataan rekam medis digital KKPO Tangsel dan berencana menjadikannya percontohan untuk provinsi lain di Indonesia.</p>'],
            ['judul' => 'Senam Pemulihan Massal Pasca Kejuaraan', 'konten' => '<p>Setelah 2 minggu bertanding penuh tekanan, ratusan atlet berkumpul di Alun-Alun Pamulang untuk mengikuti senam pemulihan (recovery workout) yang dipimpin oleh instruktur terapi KKPO.</p>'],
            ['judul' => 'Persiapan Tim Nakes Sambut Kejuaraan Nasional Renang', 'konten' => '<p>Cabang akuatik memiliki tantangan medis tersendiri seperti hipotermia ringan dan masalah telinga. Tim medis sudah mempersiapkan SOP khusus untuk kejuaraan nasional renang bulan depan.</p>'],
        ];
        foreach ($berita as $index => $b) {
            DB::table('beritas')->insert(array_merge($b, [
                'tanggal_publikasi' => Carbon::now()->subDays(15 - $index)->format('Y-m-d'),
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        // 10. Kegiatan
        DB::table('kegiatans')->truncate();
        $kegiatans = [
            ['nama_kegiatan' => 'Pemeriksaan Kesehatan Berkala Atlet', 'tanggal' => '2026-09-01', 'lokasi' => 'Klinik KKPO Tangsel', 'deskripsi' => 'Pemeriksaan fisik, tensi darah, dan rekam jantung bagi atlet unggulan persiapan PORPROV.'],
            ['nama_kegiatan' => 'Pelatihan Pertolongan Pertama (First Aid) Cabor Bela Diri', 'tanggal' => '2026-10-15', 'lokasi' => 'GOR Basket Tangsel', 'deskripsi' => 'Pelatihan wajib bagi pelatih dan asisten pelatih terkait penanganan patah tulang dan pendarahan.'],
            ['nama_kegiatan' => 'Rapat Koordinasi Nakes Jaga PORPROV', 'tanggal' => '2026-11-05', 'lokasi' => 'Ruang Rapat KONI Tangsel', 'deskripsi' => 'Pembagian jadwal jaga, mapping venue, dan penyerahan rompi tugas medis.'],
            ['nama_kegiatan' => 'Seminar Nutrisi dan Doping', 'tanggal' => '2026-11-20', 'lokasi' => 'Hotel Santika Bintaro', 'deskripsi' => 'Edukasi mengenai makanan bergizi dan zat terlarang (doping) dalam olahraga profesional.'],
            ['nama_kegiatan' => 'Simulasi Evakuasi Medis Lapangan', 'tanggal' => '2026-12-01', 'lokasi' => 'Stadion Mini Ciputat', 'deskripsi' => 'Simulasi pengangkutan atlet cedera leher menggunakan tandu scoop stretcher ke ambulans.'],
            ['nama_kegiatan' => 'Tes Kebugaran Vo2Max', 'tanggal' => '2026-08-10', 'lokasi' => 'Taman Kota 1 BSD', 'deskripsi' => 'Uji daya tahan paru dan jantung bagi seluruh atlet lari jarak jauh.'],
            ['nama_kegiatan' => 'Vaksinasi Atlet dan Official', 'tanggal' => '2026-08-25', 'lokasi' => 'Puskesmas Pamulang', 'deskripsi' => 'Pemberian vaksin influenza tahunan untuk menjaga imunitas atlet saat musim hujan.'],
            ['nama_kegiatan' => 'Workshop Psikologi Olahraga: Mengatasi Mental Block', 'tanggal' => '2026-09-10', 'lokasi' => 'Aula Kecamatan Serpong', 'deskripsi' => 'Diskusi panel dengan psikolog olahraga bagi atlet yang sering gugup sebelum bertanding.'],
            ['nama_kegiatan' => 'Evaluasi Kinerja Tim Medis Semester 1', 'tanggal' => '2026-07-30', 'lokasi' => 'Klinik KKPO', 'deskripsi' => 'Rapat internal membahas angka cedera, keluhan atlet, dan evaluasi respon time ambulans.'],
            ['nama_kegiatan' => 'Distribusi Kotak P3K ke Tiap Pengcab', 'tanggal' => '2026-08-05', 'lokasi' => 'Gudang Logistik KONI', 'deskripsi' => 'Penyerahan 30 koper medis lengkap ke seluruh Pengurus Cabang Olahraga di Tangsel.'],
            ['nama_kegiatan' => 'Pendataan Rekam Medis Digital Berbasis Sidik Jari', 'tanggal' => '2026-09-20', 'lokasi' => 'Klinik KKPO', 'deskripsi' => 'Pengambilan sampel sidik jari atlet untuk mempermudah akses rekam medis di IGD RSUD.'],
            ['nama_kegiatan' => 'Layanan Fisioterapi Keliling', 'tanggal' => '2026-10-01', 'lokasi' => 'Pemadepokan Pencak Silat', 'deskripsi' => 'Mobil klinik KKPO mengunjungi tempat latihan atlet untuk memberikan pijat olahraga.'],
            ['nama_kegiatan' => 'Medical Check Up Lengkap Atlet Elit', 'tanggal' => '2026-10-25', 'lokasi' => 'RS Premier Bintaro', 'deskripsi' => 'Cek darah, MRI lutut, dan rontgen tulang belakang bagi atlet peraih medali emas.'],
            ['nama_kegiatan' => 'Penyuluhan Bahaya Suplemen Ilegal', 'tanggal' => '2026-11-15', 'lokasi' => 'KODIKLAT Tangsel', 'deskripsi' => 'Edukasi kepada binaragawan dan atlet angkat berat mengenai risiko kerusakan ginjal.'],
            ['nama_kegiatan' => 'Doa Bersama dan Cek Tekanan Darah Terakhir', 'tanggal' => '2026-12-09', 'lokasi' => 'Kantor KONI', 'deskripsi' => 'Persiapan spiritual dan fisik sehari sebelum keberangkatan kontingen ke PORPROV Banten.'],
        ];
        foreach ($kegiatans as $kg) {
            DB::table('kegiatans')->insert(array_merge($kg, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 11. Hero Section
        DB::table('hero_sections')->truncate();
        DB::table('hero_sections')->insert([
            'judul' => 'Sistem Informasi KKPO KONI Tangerang Selatan',
            'sub_judul' => 'Mengelola kesehatan dan kesejahteraan pelaku olahraga dengan cepat, tepat, dan terintegrasi melalui satu platform cerdas.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
