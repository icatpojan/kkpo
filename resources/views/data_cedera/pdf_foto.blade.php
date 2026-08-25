<!DOCTYPE html>
<html>
<head>
    <title>Laporan Foto & Perawatan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 16px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 12px; margin: 5px 0 0 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table th, .info-table td { padding: 5px; text-align: left; vertical-align: top; }
        .info-table th { width: 150px; }
        .section-title { font-size: 14px; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; margin-top: 20px; }
        .img-container { text-align: center; margin-bottom: 15px; }
        .img-container img { max-width: 250px; max-height: 250px; border: 1px solid #ddd; padding: 3px; }
        .img-caption { font-size: 11px; color: #555; margin-top: 5px; font-style: italic; }
        .treatment-item { margin-bottom: 20px; padding: 10px; border: 1px solid #eee; background-color: #f9f9f9; }
        .treatment-header { font-weight: bold; margin-bottom: 5px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">LAPORAN FOTO DAN RIWAYAT PERAWATAN CEDERA</p>
        <p class="subtitle">Kompensasi Kejadian Pekan Olahraga (KKPO)</p>
    </div>

    <table class="info-table">
        <tr>
            <th>Nama Pasien</th>
            <td>: {{ $cedera->pelakuOlahraga->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Cabang Olahraga</th>
            <td>: {{ $cedera->pelakuOlahraga->cabor ?? '-' }}</td>
        </tr>
        <tr>
            <th>Bagian Cedera</th>
            <td>: {{ $cedera->bagian_cedera ?? '-' }}</td>
        </tr>
        <tr>
            <th>Waktu Kejadian</th>
            <td>: {{ \Carbon\Carbon::parse($cedera->waktu_kejadian)->format('d F Y, H:i') }}</td>
        </tr>
        <tr>
            <th>Status Terakhir</th>
            <td>: {{ strtoupper($cedera->status) }} @if($cedera->status == 'rujuk') ({{ $cedera->rs_rujukan }}) @endif</td>
        </tr>
    </table>

    @if($cedera->images && $cedera->images->count() > 0)
        <div class="section-title">FOTO INSIDEN (KONDISI AWAL)</div>
        @foreach($cedera->images as $img)
            <div class="img-container">
                @php
                    // Check possible paths for storage
                    $path1 = public_path('storage/' . $img->image_path);
                    $path2 = public_path($img->image_path);
                    $path = file_exists($path1) ? $path1 : (file_exists($path2) ? $path2 : null);
                @endphp
                @if($path)
                    <img src="{{ $path }}">
                @else
                    <p>[Gambar tidak ditemukan di server: {{ $img->image_path }}]</p>
                @endif
                <div class="img-caption">Foto Insiden/Cedera Awal</div>
            </div>
        @endforeach
    @endif

    <div class="section-title">RIWAYAT PERAWATAN</div>
    @if($cedera->riwayatPerawatans && $cedera->riwayatPerawatans->count() > 0)
        @foreach($cedera->riwayatPerawatans as $idx => $riwayat)
            <div class="treatment-item">
                <div class="treatment-header">
                    {{ \Carbon\Carbon::parse($riwayat->tanggal_waktu)->format('d M Y H:i') }} - {{ $riwayat->tindakan }}
                </div>
                @if($riwayat->keterangan)
                    <p style="margin: 5px 0;">Catatan: {{ $riwayat->keterangan }}</p>
                @endif
                
                @if($riwayat->foto)
                    @php
                        $path = public_path($riwayat->foto);
                    @endphp
                    <div class="img-container" style="margin-top: 10px;">
                        @if(file_exists($path))
                            <img src="{{ $path }}">
                        @else
                            <p>[Gambar tidak ditemukan: {{ $riwayat->foto }}]</p>
                        @endif
                        <div class="img-caption">Foto Dokumentasi Perawatan</div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <p>Belum ada catatan riwayat perawatan.</p>
    @endif
</body>
</html>
