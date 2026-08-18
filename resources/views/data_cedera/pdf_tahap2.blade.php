<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir 3a KK 2 - Tahap II</title>
    <style>
        @page { margin: 10px 20px; }
        body {
            font-family: Arial, sans-serif;
            font-size: 9.5px;
            line-height: 1.1;
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
            padding: 2px;
        }
        table.table-layout {
            width: 100%;
            border-collapse: collapse;
        }
        table.table-layout td {
            padding: 1.5px;
            vertical-align: top;
        }
        table.border-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        table.border-table th, table.border-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
        }
        .box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }
        .box.checked {
            background-color: #000;
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
                    <div class="subtitle">TAHAP II</div>
                </td>
                <td style="width: 25%;">
                    <div class="form-code">
                        Formulir<br>3a KK 2<br>
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

        <table style="width: 100%; border-collapse: collapse; border-top: 2px solid #000; border-bottom: 2px solid #000;">
            <tr>
                <td style="width: 50%; background-color: #dbeafe; font-weight: bold; text-align: center; padding: 5px; border-right: 2px solid #000;">
                    Laporan Kasus Kecelakaan Kerja Tahap II<br>
                    Wajib dilaporkan dalam waktu 2 X 24 Jam<br>
                    Sejak pekerja dinyatakan sembuh, cacat, atau meninggal dunia
                </td>
                <td style="width: 50%; background-color: #dbeafe; font-weight: bold; text-align: center; padding: 5px;">
                    Formulir ini berfungsi juga sebagai pengajuan pembayaran Jaminan<br>
                    Kecelakaan Kerja
                </td>
            </tr>
        </table>

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
                    <td style="padding-left: 15px;">Jenis Pekerjaan/jabatan</td>
                    <td>:</td>
                    <td class="ans">&nbsp;{{ strtoupper($pelaku->kategori) }} / {{ strtoupper($pelaku->cabor) }}</td>
                </tr>

                <tr>
                    <td colspan="3" style="padding-top: 10px;">3. Tanggal Kecelakaan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tanggal_kejadian }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;" colspan="3">
                        Waktu kejadian (khusus PMI) &nbsp;&nbsp;: <span class="box"></span> Sebelum penempatan &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Sesudah penempatan &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Selama penempatan (negara<span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span>)
                    </td>
                </tr>

                <tr>
                    <td style="padding-top: 10px;" colspan="3">4. Berdasarkan hasil pemeriksaan terakhir &nbsp;&nbsp;: Pada tanggal : <span class="ans" style="display:inline-block; min-width: 100px;">&nbsp;</span>/<span class="ans" style="display:inline-block; min-width: 100px;">&nbsp;</span>/<span class="ans" style="display:inline-block; min-width: 100px;">&nbsp;</span> (dd/mm/yyyy)</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left: 15px;">
                        <span class="box {{ $cedera->status == 'sembuh' ? 'checked' : '' }}"></span> Sembuh &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Cacat total tetap untuk selamanya<br>
                        <span class="box"></span> Cacat sebagian fungsi &nbsp;&nbsp; <span class="box"></span> Meninggal dunia<br>
                        <span class="box"></span> Cacat sebagian anatomis &nbsp; <span class="box {{ $cedera->status == 'cedera' ? 'checked' : '' }}"></span> Masih dalam pengobatan
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="padding-top: 10px;">5. Total Pengajuan Pembiayaan</td>
                </tr>
            </table>

            <table class="border-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Penerima manfaat pembiayaan</th>
                        <th>Perawatan dan pengobatan</th>
                        <th>Santunan Cacat</th>
                        <th>Prothesa dan Orthesa</th>
                        <th>Gigi tiruan</th>
                        <th>Transportasi</th>
                        <th>STMB</th>
                        <th>Nama Bank</th>
                        <th>No. Rekening</th>
                        <th>Nama Rekening</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: left;">Pemberi Kerja</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Peserta</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Ahli Waris</td>
                        <td style="background-color: #555;"></td>
                        <td style="background-color: #555;"></td>
                        <td style="background-color: #555;"></td>
                        <td style="background-color: #555;"></td>
                        <td style="background-color: #555;"></td>
                        <td style="background-color: #555;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <table class="table-layout">
                <tr>
                    <td colspan="3" style="padding-top: 10px;">6. Lamanya tidak bekerja &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span style="display:inline-block; border: 1px solid #000; width: 50px; height: 15px;"></span> hari (Sesuai dengan jumlah hari perawatan dan atau surat keterangan istirahat dokter)</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-top: 10px;">7. Data ahli waris (diisi jika peserta meninggal dunia)</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;" class="w-30">Nama Ahli Waris</td>
                    <td style="width: 2%;">:</td>
                    <td class="w-70 ans">&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">NIK / No. Paspor (WNA)</td>
                    <td>:</td>
                    <td class="ans">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Hubungan ahli waris dengan peserta</td>
                    <td>:</td>
                    <td class="ans">&nbsp;
                        <span class="box"></span> Janda/duda &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Anak &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Ayah/Ibu &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Kakek/Nenek &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Cucu<br>
                        <span class="box"></span> Saudara Kandung &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Mertua &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Pihak yang ditunjuk dalam wasiat
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">No Telepon/ HP</td>
                    <td>:</td>
                    <td class="ans">&nbsp;(&nbsp;)&nbsp;/&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">Nama Bank & No. Rekening</td>
                    <td>:</td>
                    <td class="ans">&nbsp;&nbsp;&&nbsp;</td>
                </tr>
                
                <tr>
                    <td colspan="3" style="padding-top: 10px;">Data wali anak (untuk ahli waris anak di bawah usia 18 tahun)</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">a. Nama</td>
                    <td>:</td>
                    <td class="ans">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">b. NIK</td>
                    <td>:</td>
                    <td class="ans">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">c. No. Telepon / HP & email</td>
                    <td>:</td>
                    <td class="ans">&nbsp;(&nbsp;)&nbsp;/&nbsp;email : &nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;">d. Hubungan dengan anak Peserta</td>
                    <td>:</td>
                    <td class="ans">&nbsp;&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="3" style="padding-top: 10px;">8. Memiliki anak belum mencapai usia 23 tahun / belum bekerja / belum menikah *</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left: 15px;">
                        <span class="box"></span> ada** &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> tidak ada
                    </td>
                </tr>
                
                <tr>
                    <td style="padding-top: 10px;">9. Keterangan lainnya jika perlu</td>
                    <td style="padding-top: 10px;">:</td>
                    <td style="padding-top: 10px;">
                        <div style="border: 1px dashed #000; padding: 10px; min-height: 20px;">
                            {{ $cedera->keterangan }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="padding-top: 10px;">10. Persyaratan yang diperlukan</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left: 15px;">
                        <span class="box"></span> Surat Keterangan Dokter Kasus Kecelakaan Kerja (Formulir 3b KK3) &nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Kuitansi asli biaya pengangkutan<br>
                        <span class="box"></span> Kuitansi asli biaya pengobatan dan perawatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="box"></span> Dokumen pendukung lain apabila diperlukan
                    </td>
                </tr>
            </table>

            <div class="signature-box" style="text-align: center;">
                Dengan ini saya menyatakan bahwa data dan keterangan yang saya sampaikan kepada BPJS Ketenagakerjaan<br>
                adalah benar. Apabila data yang diberikan tidak benar,<br>
                saya bersedia bertanggung jawab sesuai peraturan perundangan yang berlaku
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
                        *) Jika kondisi meninggal dunia atau cacat total tetap<br>
                        **) Jika ada dan berhak atas manfaat beasiswa, harap mengisi formulir pengajuan manfaat beasiswa</i>
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
