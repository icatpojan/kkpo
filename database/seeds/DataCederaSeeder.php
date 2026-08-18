<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataCederaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('data_cederas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $cederaTypes = [
            ['bagian' => 'Ankle Kanan', 'kronologis' => 'Salah tumpuan saat melompat untuk smes', 'penanganan' => 'RICE (Rest, Ice, Compression, Elevation)', 'status' => 'cedera', 'keterangan' => 'Pemantauan fisioterapi selama 3 hari', 'rujuk' => null],
            ['bagian' => 'Bahu Kiri', 'kronologis' => 'Dislokasi bahu akibat benturan keras dengan lawan saat mendarat', 'penanganan' => 'Fiksasi bahu (arm sling), pemberian pereda nyeri', 'status' => 'rujuk', 'keterangan' => 'Dirujuk untuk foto Rontgen', 'rujuk' => 'RS Premier Bintaro'],
            ['bagian' => 'Lutut Kanan', 'kronologis' => 'Terkena tendangan lawan saat melakukan kuda-kuda bawah', 'penanganan' => 'Kompres es, pemberian spray pereda nyeri', 'status' => 'sembuh', 'keterangan' => 'Bisa melanjutkan pertandingan', 'rujuk' => null],
            ['bagian' => 'Kepala', 'kronologis' => 'Benturan kepala di udara saat menyundul bola', 'penanganan' => 'Observasi kesadaran, perawatan luka robek ringan di pelipis', 'status' => 'sembuh', 'keterangan' => 'Luka sudah diperban dan pendarahan berhenti', 'rujuk' => null],
            ['bagian' => 'Paha Depan', 'kronologis' => 'Kram otot hamstring akibat kurang pemanasan', 'penanganan' => 'Stretching, penyemprotan etil klorida, dan pijatan ringan', 'status' => 'sembuh', 'keterangan' => 'Sembuh dalam 15 menit', 'rujuk' => null],
            ['bagian' => 'Pergelangan Tangan', 'kronologis' => 'Jatuh menumpu pada tangan saat didorong lawan', 'penanganan' => 'Pembidaian (spalk) sementara, es kompres', 'status' => 'rujuk', 'keterangan' => 'Suspect fraktur radius', 'rujuk' => 'RSUD Tangsel'],
            ['bagian' => 'Pelipis Mata', 'kronologis' => 'Terkena pukulan siku lawan', 'penanganan' => 'Membersihkan darah, perban tekan', 'status' => 'sembuh', 'keterangan' => 'Pasien stabil', 'rujuk' => null],
            ['bagian' => 'Pinggang', 'kronologis' => 'Low back pain mendadak saat mengangkat beban', 'penanganan' => 'Kompres panas/dingin, pemberian obat relaksan otot', 'status' => 'cedera', 'keterangan' => 'Istirahat total', 'rujuk' => null],
            ['bagian' => 'Hidung', 'kronologis' => 'Mimisan akibat terkena lemparan bola basket', 'penanganan' => 'Menekan cuping hidung, menundukkan kepala, kompres es', 'status' => 'sembuh', 'keterangan' => 'Pendarahan berhenti', 'rujuk' => null],
            ['bagian' => 'Engkel Kiri', 'kronologis' => 'Terpeleset di pinggir kolam renang', 'penanganan' => 'Pembebatan dengan perban elastis', 'status' => 'cedera', 'keterangan' => 'Bengkak ringan', 'rujuk' => null],
            ['bagian' => 'Dada', 'kronologis' => 'Terkena hantaman keras saat tanding silat', 'penanganan' => 'Cek pernapasan, observasi', 'status' => 'rujuk', 'keterangan' => 'Sesak napas tidak kunjung hilang, butuh rontgen dada', 'rujuk' => 'RS Sari Asih Ciputat'],
            ['bagian' => 'Jari Tangan', 'kronologis' => 'Jari kelingking terkilir saat blocking bola voli', 'penanganan' => 'Buddy taping (pengikatan ke jari sebelah)', 'status' => 'sembuh', 'keterangan' => 'Bisa bertanding kembali', 'rujuk' => null],
            ['bagian' => 'Betis Kanan', 'kronologis' => 'Ketegangan otot (strain) saat berlari sprint', 'penanganan' => 'Kompres es, elevasi kaki', 'status' => 'cedera', 'keterangan' => 'Dilarang ikut nomor lari berikutnya', 'rujuk' => null],
            ['bagian' => 'Kaki (Luka Bakar Gesek)', 'kronologis' => 'Terjatuh terseret di lintasan sintetis', 'penanganan' => 'Pembersihan luka dengan NaCl, pemberian salep antibiotik, perban', 'status' => 'sembuh', 'keterangan' => 'Luka luar ringan', 'rujuk' => null],
            ['bagian' => 'Gigi', 'kronologis' => 'Gigi depan patah akibat terkena tongkat', 'penanganan' => 'Hentikan pendarahan gusi', 'status' => 'rujuk', 'keterangan' => 'Butuh penanganan dokter gigi segera', 'rujuk' => 'Klinik Gigi Serpong'],
            ['bagian' => 'Selangkangan (Groin)', 'kronologis' => 'Otot tertarik saat meregang kaki terlalu lebar (split)', 'penanganan' => 'Kompres dingin, istirahat di luar lapangan', 'status' => 'cedera', 'keterangan' => 'Rekomendasi fisioterapi lanjutan', 'rujuk' => null],
            ['bagian' => 'Tulang Kering (Shin)', 'kronologis' => 'Tendangan mengenai tulang kering tanpa pelindung', 'penanganan' => 'Kompres es dan anti inflamasi', 'status' => 'sembuh', 'keterangan' => 'Memar biasa', 'rujuk' => null],
            ['bagian' => 'Lutut Kiri', 'kronologis' => 'Suara "pop" terdengar saat berputar arah mendadak', 'penanganan' => 'Imobilisasi lutut, kompres es', 'status' => 'rujuk', 'keterangan' => 'Suspect ACL tear, butuh MRI', 'rujuk' => 'RS Premier Bintaro'],
            ['bagian' => 'Tumit (Achilles)', 'kronologis' => 'Nyeri tajam mendadak di tumit saat mulai berlari', 'penanganan' => 'Dilarang menumpu, diberikan kruk', 'status' => 'rujuk', 'keterangan' => 'Rujukan bedah ortopedi', 'rujuk' => 'RSUD Banten'],
            ['bagian' => 'Lengan Bawah', 'kronologis' => 'Luka sayat/robek terkena paku di pinggir lapangan', 'penanganan' => 'Hentikan pendarahan, tutup dengan kasa steril', 'status' => 'sembuh', 'keterangan' => 'Sudah diberikan perawatan antiseptik', 'rujuk' => null],
        ];

        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $type = $cederaTypes[$i];
            $data[] = [
                'pelaku_olahraga_id' => rand(1, 30),
                'nakes_jaga_id' => rand(1, 20),
                'waktu_kejadian' => Carbon::now()->subDays(rand(0, 10))->subHours(rand(0, 10))->format('Y-m-d H:i:s'),
                'bagian_cedera' => $type['bagian'],
                'kronologis' => $type['kronologis'],
                'penanganan' => $type['penanganan'],
                'status' => $type['status'],
                'rs_rujukan' => $type['rujuk'],
                'keterangan' => $type['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Add 5 more random ones to make it 25
        for ($i = 0; $i < 5; $i++) {
            $type = $cederaTypes[rand(0, 19)];
            $data[] = [
                'pelaku_olahraga_id' => rand(1, 30),
                'nakes_jaga_id' => rand(1, 20),
                'waktu_kejadian' => Carbon::now()->subDays(rand(0, 5))->format('Y-m-d H:i:s'),
                'bagian_cedera' => $type['bagian'],
                'kronologis' => $type['kronologis'],
                'penanganan' => $type['penanganan'],
                'status' => $type['status'],
                'rs_rujukan' => $type['rujuk'],
                'keterangan' => $type['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('data_cederas')->insert($data);
    }
}
