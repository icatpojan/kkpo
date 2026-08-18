<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Kronologis</title>
    <style>
        @page { margin: 20px 40px; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1.35;
            color: #000;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
            vertical-align: top;
        }
        .label-col {
            width: 32%;
        }
        .colon-col {
            width: 2%;
        }
        .data-col {
            border-bottom: 1px dotted #000;
            width: 66%;
        }
        .section-text {
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .dotted-line {
            border-bottom: 1.5px dotted #000;
            width: 100%;
            display: inline-block;
        }
        .ans { border-bottom: 1px dotted #000; }
    </style>
</head>
<body>
    <div class="title">Berita Acara Kronologis</div>

    <div class="section-text">Yang bertanda tangan dibawah ini, saya :</div>
    <table>
        <tr>
            <td class="label-col">Nama</td>
            <td class="colon-col">:</td>
            <td class="data-col">&nbsp;</td>
        </tr>
        <tr>
            <td class="label-col">Jabatan</td>
            <td class="colon-col">:</td>
            <td class="data-col">&nbsp;</td>
        </tr>
        <tr>
            <td class="label-col">Perusahaan</td>
            <td class="colon-col">:</td>
            <td class="data-col">KONI TANGERANG SELATAN</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Perusahaan</td>
            <td class="colon-col">:</td>
            <td class="data-col">JLN BINTARO UTAMA 3A PONDOK AREN<br>TANGERANG SELATAN</td>
        </tr>
    </table>

    <div class="section-text" style="margin-top: 20px;">Menjelaskan dengan sesungguhnya bahwa telah terjadi kecelakaan kerja pada :</div>
    <table>
        <tr>
            <td class="label-col">Hari</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $hari_kejadian }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $tanggal_kejadian }}</td>
        </tr>
        <tr>
            <td class="label-col">Pukul</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $jam_kejadian }}</td>
        </tr>
        <tr>
            <td class="label-col">Lokasi Kecelakaan</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $kegiatan_nama }}</td>
        </tr>
    </table>

    <div class="section-text" style="margin-top: 20px;">Yang menimpa tenaga kerja kami atas nama :</div>
    <table>
        <tr>
            <td class="label-col">Nama</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $pelaku->nama }}</td>
        </tr>
        <tr>
            <td class="label-col">No. Kartu BPJSTK</td>
            <td class="colon-col">:</td>
            <td class="data-col">&nbsp;</td>
        </tr>
        <tr>
            <td class="label-col">NIK KTP</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $pelaku->nik ?: '&nbsp;' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jabatan</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ strtoupper($pelaku->kategori) }} / {{ strtoupper($pelaku->cabor) }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat sesuai KTP</td>
            <td class="colon-col">:</td>
            <td class="data-col">{{ $pelaku->alamat ?: '&nbsp;' }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Domisili</td>
            <td class="colon-col">:</td>
            <td class="data-col">&nbsp;</td>
        </tr>
        <tr>
            <td class="label-col">Kantor Penempatan Kerja</td>
            <td class="colon-col">:</td>
            <td class="data-col">&nbsp;</td>
        </tr>
    </table>

    <div class="section-text" style="margin-top: 20px;">Adapun kronologis kecelakaan sbb :</div>
    
    <div style="padding-left: 20px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 5%; vertical-align: top;"><strong>1.</strong></td>
                <td style="width: 95%;">
                    <strong>Kecelakaan terjadi saat di <i>Tempat Kerja</i><br>Alamat Tempat Kerja (Kantor):</strong><br>
                    <div style="border-bottom: 2px dotted #000; width: 60%; margin-top: 8px;"></div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding-top: 15px;"><strong>2.</strong></td>
                <td style="padding-top: 15px;">
                    <strong>Uraian Kronologis Kejadian Kecelakaan :</strong><br>
                    <div style="line-height: 25px; margin-top: 5px;">
                        @if($cedera->kronologis)
                            {{ $cedera->kronologis }}
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                        @else
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                            <div style="border-bottom: 2px dotted #000; margin-top: 20px;"></div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; margin-top: 40px; text-align: center;">
        <tr>
            <td style="width: 50%;">Mengetahui,</td>
            <td style="width: 50%;">Yang Membuat,</td>
        </tr>
        <tr>
            <td style="height: 60px;"></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; text-align: center;">Saksi 1</td>
                        <td style="width: 50%; text-align: center;">Saksi 2</td>
                    </tr>
                    <tr>
                        <td style="height: 30px;"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding-left: 40px;">Nama</td>
                        <td style="text-align: left; padding-left: 20px;">Nama</td>
                    </tr>
                </table>
            </td>
            <td>
                Tandatangan + Stempel
                <br><br><br>
                <table style="width: 100%; margin-top: 10px;">
                    <tr>
                        <td style="text-align: left; padding-left: 50px;">Nama</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding-left: 50px;">Jabatan</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <p style="font-weight: bold; font-style: italic; margin-top: 20px;">NB: Mohon melampirkan Foto Copy KTP Saksi-saksi</p>

</body>
</html>
