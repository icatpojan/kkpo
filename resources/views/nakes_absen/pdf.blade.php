<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi NAKES</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            padding: 2px;
            font-size: 16px;
            font-weight: bold;
        }
        .tanggal-box {
            margin-bottom: 10px;
            display: table;
        }
        .tanggal-label {
            display: table-cell;
            border: 1px solid #000;
            padding: 5px 10px;
            width: 80px;
            text-align: center;
        }
        .tanggal-value {
            display: table-cell;
            border: 1px solid #000;
            padding: 5px 10px;
            width: 150px;
        }
        .tanggal-gap {
            display: table-cell;
            width: 5px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        table.data-table th {
            text-transform: uppercase;
            font-size: 11px;
            font-weight: normal;
        }
        .ttd-img {
            max-width: 80px;
            max-height: 40px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>ABSENSI KEGIATAN</h2>
        <h2>PEKAN OLAH RAGA PROVINSI (PORPROV KE-VII) BANTEN</h2>
    </div>

    <div class="tanggal-box">
        <div class="tanggal-label">Tanggal</div>
        <div class="tanggal-gap"></div>
        <div class="tanggal-value">
            @if(request('start_date') && request('end_date'))
                @if(request('start_date') == request('end_date'))
                    {{ date('d M Y', strtotime(request('start_date'))) }}
                @else
                    {{ date('d M Y', strtotime(request('start_date'))) }} - {{ date('d M Y', strtotime(request('end_date'))) }}
                @endif
            @elseif($absens->count() > 0)
                @php
                    $firstDate = $absens->last()->created_at->format('d M Y');
                    $lastDate = $absens->first()->created_at->format('d M Y');
                @endphp
                @if($firstDate == $lastDate)
                    {{ $firstDate }}
                @else
                    {{ $firstDate }} - {{ $lastDate }}
                @endif
            @endif
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="10%">Tanggal</th>
                <th width="15%">NAMA</th>
                <th width="15%">INSTANSI</th>
                <th width="15%">VENUE</th>
                <th width="15%">CABOR</th>
                <th width="15%">BANK & NO. REK</th>
                <th width="10%">TTD</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absens as $index => $absen)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $absen->created_at->format('d/m/Y') }}
                </td>
                <td style="text-align: left;">{{ $absen->nama }}</td>
                <td>{{ $absen->instansi ?? '-' }}</td>
                <td>
                    {{ $absen->nakesJaga->venue ?? '-' }}
                </td>
                <td>
                    {{ $absen->nakesJaga->cabor ?? '-' }}
                </td>
                <td>
                    @if($absen->bank || $absen->norek)
                        {{ $absen->bank ?? '-' }} <br> {{ $absen->norek ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($absen->tanda_tangan)
                        @php
                            $path = public_path('storage/' . $absen->tanda_tangan);
                            if (!file_exists($path)) {
                                // sometimes storage symlink is not present, use storage_path as fallback
                                $path = storage_path('app/public/' . $absen->tanda_tangan);
                            }
                        @endphp
                        @if(file_exists($path))
                            <img src="{{ $path }}" class="ttd-img">
                        @else
                            -
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 20px;">Tidak ada data absensi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
