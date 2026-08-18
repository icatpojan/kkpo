<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir 3 KK 1 - Tahap I</title>
    <style>
        @page { margin: 15px 30px; }
        body {
            font-family: Arial, sans-serif;
            font-size: 10.5px;
            line-height: 1.15;
            color: #000;
        }
        .container {
            width: 100%;
            border: 2px solid #000;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #000;
        }
        .header td {
            padding: 2px;
            vertical-align: middle;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        .subtitle {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        .form-code {
            text-align: center;
            font-weight: bold;
            border: 2px solid #000;
            padding: 5px;
        }
        .section-header {
            background-color: #dbeafe;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-bottom: 2px solid #000;
            border-top: 2px solid #000;
        }
        .content {
            padding: 5px;
        }
        table.table-layout {
            width: 100%;
            border-collapse: collapse;
        }
        table.table-layout td {
            padding: 1.5px;
            vertical-align: top;
        }
        .box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }
        .w-30 { width: 30%; }
        .w-70 { width: 70%; }
        .signature-box {
            width: 100%;
            border: 1px solid #000;
            padding: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        .ans { border-bottom: 1px dotted #000; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr>
                <td style="width: 25%;"><img src="{{ public_path('img/logo-bpjs.png') }}" style="max-height: 45px;"></td>
                <td style="width: 50%;">
                    <div class="title">LAPORAN KASUS KECELAKAAN KERJA</div>
                    <div class="subtitle">TAHAP I</div>
                </td>
                <td style="width: 25%;">
                    <div class="form-code">
                        Formulir<br>3 KK 1<br>
                        <span style="font-size: 9px; font-weight: normal;">BPJS Ketenagakerjaan</span>
                    </div>
                </td>
            </tr>
        </table>
        
        <div style="padding: 5px;">
            Segmen Kepesertaan : &nbsp;&nbsp; 
            <span class="box"></span> Penerima Upah (PU) &nbsp;&nbsp;
            <span class="box"></span> Bukan Penerima Upah (BPU) &nbsp;&nbsp;
            <span class="box"></span> Jasa Konstruksi (JAKON) &nbsp;&nbsp;
            <span class="box"></span> Pekerja Migran Indonesia (PMI)
        </div>

        <div class="section-header">
            Laporan Kasus Kecelakaan Kerja Tahap I<br>
            Wajib dilaporkan dalam waktu 2 X 24 Jam sejak terjadi kasus kecelakaan kerja
        </div>

        <div class="content">
            <table class="table-layout">
                <tr>
                    <td colspan="3">1. Data Pemberi Kerja/ Wadah/ Mitra/ Pelaksana Penempatan</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;" class="w-30">Nama</td>
                    <td style="width: 2%;">:</td>
                    <td class="w-70 ans">&nbsp;{{ $pelaku->kontingen ?: 'KONI TANGERANG SELATAN' }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">NPP / NPW / Nomor Proyek</td>
                    <td>:</td>
                    <td class="ans">&nbsp;-</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Alamat</td>
                    <td>:</td>
                    <td class="ans">&nbsp;JLN BINTARO UTAMA 3A PONDOK AREN TANGERANG SELATAN.</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">No. Telepon/ HP</td>
                    <td>:</td>
                    <td class="ans">&nbsp;-</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Nama Kontak Personil</td>
                    <td>:</td>
                    <td class="ans">&nbsp;-</td>
                </tr>
                
                <tr>
                    <td colspan="3" style="padding-top: 10px;">2. Data Peserta</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Nama</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ $pelaku->nama }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">No. Peserta</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ $pelaku->nomor_anggota }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">NIK / No. Paspor (WNA/PMI)</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ $pelaku->nik }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Tanggal Lahir</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ $pelaku->ttl }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Alamat Domisili dan no. telepon</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ $pelaku->alamat }}<br>{{ $pelaku->no_wa }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Jenis Pekerjaan/jabatan</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ strtoupper($pelaku->kategori) }} / {{ strtoupper($pelaku->cabor) }}</td>
                </tr>

                <tr>
                    <td colspan="3" style="padding-top: 10px;">3. Upah Peserta *) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Rp <span class="ans" style="display:inline-block; min-width: 100px;">&nbsp;</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> per hari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> per bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> borongan**</td>
                </tr>

                <tr>
                    <td style="padding-top: 10px;" colspan="3">4. Tempat kejadian kecelakaan &nbsp;&nbsp;&nbsp;&nbsp;: <span class="box"></span> dalam lokasi kerja &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> luar lokasi kerja &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> lalu-lintas ***</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Alamat tempat kejadian kecelakaan</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ $kegiatan_nama }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Tanggal dan jam Kecelakaan</td>
                    <td>:</td>
                    <td class="ans">&nbsp;tanggal : {{ $tanggal_kejadian }} &nbsp;&nbsp;&nbsp;&nbsp; jam : {{ $jam_kejadian }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Waktu kejadian (khusus PMI)</td>
                    <td colspan="2">: <span class="box"></span> sebelum penempatan &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> sesudah penempatan &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> selama penempatan (negara<span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span>)</td>
                </tr>

                <tr>
                    <td style="padding-top: 10px; vertical-align: top;">5. Uraian / Kronologis kejadian</td>
                    <td style="padding-top: 10px; vertical-align: top;">:</td>
                    <td style="padding-top: 10px;">
                        <div style="border: 1px dashed #000; padding: 10px; min-height: 50px;">
                            {{ $cedera->kronologis ?: $cedera->keterangan }}
                            <br><br>
                            <span style="font-style: italic; color: #555;">Uraian kejadian kecelakaan lebih lengkap dapat ditambahkan di lampiran tersendiri</span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding-top: 10px;">6. Akibat yang diderita</td>
                    <td style="padding-top: 10px;">:</td>
                    <td style="padding-top: 10px;">
                        <span class="box"></span> Cedera/ Luka, bagian tubuh {{ $cedera->bagian_cedera }}<br>
                        <span class="box"></span> Meninggal Dunia
                    </td>
                </tr>

                <tr>
                    <td style="padding-top: 10px;">7. Layanan Pertolongan Pertama</td>
                    <td style="padding-top: 10px;">:</td>
                    <td style="padding-top: 10px;">
                        Jenis Faskes : <span class="box"></span> Jaringan PLKK, sebutkan {{ $cedera->rs_rujukan }}<br>
                        <span style="display:inline-block; width: 85px;"></span> <span class="box"></span> Rumah Sakit/Klinik/Puskesmas tidak kerjasama, sebutkan <span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span><br>
                        <span style="display:inline-block; width: 85px;"></span> <span class="box"></span> Lain lain, sebutkan <span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Transportasi pada pertolongan pertama</td>
                    <td>:</td>
                    <td class="ans">&nbsp;
                        <span class="box"></span> Laut &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Udara &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Darat/sungai/danau, sebutkan &nbsp;
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="padding-top: 10px;">8. Persyaratan yang diperlukan :</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left: 15px;">
                        <span class="box"></span> Fotokopi Kartu peserta BPJS Ketenagakerjaan<br>
                        <span class="box"></span> Fotokopi Kartu Tanda Penduduk (KTP) bagi WNI/ Paspor bagi WNA<br>
                        <span class="box"></span> Formulir Pendaftaran Proyek Jasa Konstruksi dan bukti pembayaran iuran terakhir (Khusus untuk Jasa Konstruksi)<br>
                        <span class="box"></span> Dokumen pendukung lain apabila diperlukan
                    </td>
                </tr>
            </table>

            <div class="signature-box">
                Dengan ini saya menyatakan bahwa data dan keterangan yang saya sampaikan kepada BPJS Ketenagakerjaan adalah benar dan bersedia memberikan informasi perkembangan kondisi Peserta paling lama 14 (empat belas) hari kerja apabila BPJS Ketenagakerjaan meminta informasi dimaksud. Apabila data yang diberikan tidak benar, saya bersedia bertanggung jawab sesuai peraturan perundangan yang berlaku.
            </div>

            <table style="width: 100%; margin-top: 10px;">
                <tr>
                    <td style="width: 60%; vertical-align: top;">
                        <i>Keterangan :<br>
                        Laporan ini diperuntukkan :<br>
                        - Lembar pertama : BPJS Ketenagakerjaan<br>
                        - Lembar kedua : Dinas Tenaga Kerja Setempat<br>
                        - Lembar ketiga : Pusat Layanan Kecelakaan Kerja<br>
                        - Lembar keempat : Perusahaan<br>
                        *) Upah peserta adalah upah yang diterima Peserta pada saat terjadi KK / PAK...<br>
                        **) upah sebulan bagi borongan = upah rata-rata 3 bulan terakhir<br>
                        ***) lampirkan Laporan Polisi/kronologis kejadian diketahui 2 orang saksi</i>
                    </td>
                    <td style="width: 40%; vertical-align: top; text-align: center;">
                        Kota/Kab : <span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span><br>
                        Tanggal : <span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span><br>
                        <br><br><br><br>
                        (tanda tangan dan stempel perusahaan)<br>
                        Nama : <span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span><br>
                        Jabatan : <span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
